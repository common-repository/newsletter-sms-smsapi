<?php

use Smsapi\Client\Version3\Feature\Contacts\Groups\Bag\UnpinContactFromGroupBag;
use Smsapi\Client\Version3\Feature\Contacts\Bag\CreateContactBag;
use Smsapi\Client\Version3\Feature\Contacts\Bag\DeleteContactBag;
use Smsapi\Client\Version3\Feature\Contacts\Bag\FindContactBag;
use Smsapi\Client\Version3\Feature\Contacts\Bag\FindContactsBag;
use Smsapi\Client\Version3\Feature\Contacts\Bag\UpdateContactBag;
use Smsapi\Client\Version3\Feature\Contacts\Groups\Bag\CreateGroupBag;
use Smsapi\Client\Version3\Feature\Contacts\Groups\Bag\FindGroupBag;
use Smsapi\Client\Version3\Feature\Contacts\Groups\Members\Bag\PinContactToGroupBag;
use Smsapi\Client\Version3\Feature\Contacts\Groups\Members\Bag\UnpinContactFromGroupByQueryBag;
use Smsapi\Client\Version3\Feature\Sms\Bag\SendSmsBag;
use Smsapi\Client\Version3\Feature\Sms\Bag\SendSmssBag;
use Smsapi\Client\Version3\Feature\Sms\Bag\SendSmsToGroupBag;
use Smsapi\Client\Version3\Infrastructure\ResponseMapper\ApiErrorException;
use Smsapi\Client\Version3\SmsapiClientException;
use Smsapi\Client\Version3\SmsapiHttpClient;

require_once SMSAPI_PLUGIN_PATH . '/classes/SmsapiPsrClient.php';
require_once SMSAPI_PLUGIN_PATH . '/classes/SmsapiRequestFactory.php';
require_once SMSAPI_PLUGIN_PATH . '/classes/SmsapiStreamFactory.php';

class SMSApiClient
{
    private $client;

    private $sendername;

    private $service;

    private $normalize;

    public function __construct()
    {
        $this->setClient();
        $this->setService();

        if (!$this->service->pingFeature()->ping()->authorized) {
            throw new SmsapiClientException();
        }
    }

    public function getUsername(): string
    {
        $profile = $this->service->profileFeature()->findProfile();

        return $profile->username;
    }

    public function setNormalize($normalize)
    {
        $this->normalize = $normalize;
    }

    public function setSendername($sendername)
    {
        $this->sendername = $sendername;
    }

    public function getPhonebookGroups()
    {
        return $this->service->contactsFeature()->groupsFeature()->findGroups();
    }

    public function getSenderNames(): array
    {
        $sendernames = $this->service->smsFeature()->sendernameFeature()->findSendernames();
        $sendernameList = [];
        if (!empty($sendernames)) {
            foreach ($sendernames as $sendername) {
                $sendernameList[] = $sendername->sender;
            }
        }

        return $sendernameList;
    }

    public function sendSingleSms($to, $message): bool
    {
        $smsBag = SendSmsBag::withMessage($to, $message);

        if ($this->normalize) {
            $smsBag->normalize = true;
        }

        $sendername = $this->getSendername();
        if ($sendername) {
            $smsBag->from = $sendername;
        }
        $send = $this->service->smsFeature()->sendSms($smsBag);

        return empty($send->error);
    }

    public function sendSmss($to, $message)
    {
        $smsBag = SendSmssBag::withMessage($to, $message);

        if ($this->normalize) {
            $smsBag->normalize = true;
        }

        $sendername = $this->getSendername();
        if ($sendername) {
            $smsBag->from = $sendername;
        }

        $this->service->smsFeature()->sendSmss($smsBag);
    }

    public function sendSmsToAll($message)
    {
        $groupId = $this->getSetting('phonebook_group');
        $group = $this->service->contactsFeature()->groupsFeature()->findGroup(
            new FindGroupBag($groupId)
        );
        $smsBag = SendSmsToGroupBag::withMessage($group->name, $message);

        if ($this->normalize) {
            $smsBag->normalize = true;
        }

        $sendername = $this->getSendername();
        if ($sendername) {
            $smsBag->from = $sendername;
        }

        $this->service->smsFeature()->sendSmsToGroup($smsBag);
    }

    public function saveSubscriber(array $subscriber)
    {
        $groupId = $this->getSetting('phonebook_group');
        $phoneNumber = smsapi_array_safe_get($subscriber, 'phonenumber');
        $alreadySavedSubscriber = $this->getSubscriberFromAnyGroup($phoneNumber);

        if (!empty($alreadySavedSubscriber)) {
            $subscriber = $this->updateSubscriber($alreadySavedSubscriber->id, $subscriber);
        } else {
            $contactBag = CreateContactBag::withPhoneNumber($phoneNumber);
            $patchedSubscriberBag = SmsapiUtils::patchSubscriberUpdate($contactBag, $subscriber);
            $subscriber = $this->service->contactsFeature()->createContact($patchedSubscriberBag);
        }

        $pinBag = new PinContactToGroupBag($subscriber->id, $groupId);

        return $this->service->contactsFeature()->groupsFeature()->membersFeature()->pinContactToGroup($pinBag);
    }

    public function updateSubscriber(string $subscriberId, array $data)
    {
        $contactBag = new UpdateContactBag($subscriberId);
        $contactBag = SmsapiUtils::patchSubscriberUpdate($contactBag, $data);

        return $this->service->contactsFeature()->updateContact($contactBag);
    }

    public function getSubscriber($phonenumber)
    {
        $groupId = $this->getSetting('phonebook_group');
        $contactBag = new FindContactsBag();
        $contactBag->phoneNumber = $phonenumber;
        $contactBag->groupId = $groupId;

        $subscriber = $this->service->contactsFeature()->findContacts($contactBag);

        return !empty($subscriber) ? reset($subscriber) : [];
    }

    public function getSubscriberFromAnyGroup($phonenumber)
    {
        $contactBag = new FindContactsBag();
        $contactBag->phoneNumber = $phonenumber;

        $subscriber = $this->service->contactsFeature()->findContacts($contactBag);

        return !empty($subscriber) ? reset($subscriber) : [];
    }

    public function getSubscriberById($contactId)
    {
        $contactBag = new FindContactBag($contactId);
        try {
            return $this->service->contactsFeature()->findContact($contactBag);
        } catch (ApiErrorException $e) {
            wp_die('Subscriber does not exist');
        }
    }

    public function getSubscribersList($limit = null, $offset = null, $search = null)
    {
        $contactsBag = new FindContactsBag();
        $contactsBag->groupId = $this->getSetting('phonebook_group');
        $contactsBag->q = $search;
        if (!is_null($limit)) {
            $contactsBag->limit = $limit;
        }
        if (!is_null($offset)) {
            $contactsBag->offset = $offset;
        }

        return $this->service->contactsFeature()->findContacts($contactsBag);
    }

    public function unpinSubscriberFromDefaultGroup(string $contactId)
    {
        $groupId = $this->getSetting('phonebook_group');

        try {
            $contactBag = new UnpinContactFromGroupBag($contactId, $groupId);
            $this->service->contactsFeature()->groupsFeature()->unpinContactFromGroup($contactBag);
        } catch (ApiErrorException $e) {
            // do nothing so bulk unpin won't break
        }
    }

    public function unpinAllSubscriberFromDefaultGroup()
    {
        $groupId = $this->getSetting('phonebook_group');

        $contactBag = new UnpinContactFromGroupByQueryBag($groupId);
        $this->service->contactsFeature()->groupsFeature()->membersFeature()->unpinContactFromGroupByQuery($contactBag);
    }

    public function removeSubscriberFromServer(string $contactId)
    {
        try {
            $contactBag = new DeleteContactBag($contactId);
            $this->service->contactsFeature()->deleteContact($contactBag);
        } catch (ApiErrorException $e) {
            // do nothing so bulk remove won't break
        }
    }

    public function countContacts($search = null)
    {
        $contactsBag = new FindContactsBag();
        $contactsBag->groupId = $this->getSetting('phonebook_group');
        $contactsBag->q = $search;
        $contacts = $this->service->contactsFeature()->findContacts($contactsBag);

        return count($contacts);
    }

    public function getSubscribersByIds(array $subscribersIds)
    {
        $contactsBag = new FindContactsBag();
        $contactsBag->id = $subscribersIds;
        $subscribers = $this->service->contactsFeature()->findContacts($contactsBag);

        return $subscribers;
    }

    public function addGroup($groupName)
    {
        $group = new CreateGroupBag($groupName);

        $this->service->contactsFeature()->groupsFeature()->createGroup($group);
    }

    private function getSendername(): string
    {
        $defaultSendername = $this->getSetting('api_sendername');

        return $this->sendername ? $this->sendername : $defaultSendername;
    }

    private function setClient()
    {
        $httpClient = new SmsapiPsrClient();
        $requestFactory = new SmsapiRequestFactory();
        $streamFactory = new SmsapiStreamFactory();

        $this->client = new SmsapiHttpClient($httpClient, $requestFactory, $streamFactory);
    }

    private function setService()
    {
        $token = $this->getSetting('api_token');
        if (empty($token)) {
            throw new InvalidArgumentException('Missing token');
        }

        $this->service = $this->client->smsapiComServiceWithUri($token, SMSAPI_HOSTNAME);
    }

    private function getSetting(string $settingName)
    {
        $config = get_option('smsapi_client', []);

        return smsapi_array_safe_get($config, $settingName);
    }
}