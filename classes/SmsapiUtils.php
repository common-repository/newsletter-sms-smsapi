<?php

use Smsapi\Client\Version3\Feature\Contacts\Data\Contact;
use Smsapi\Client\Version3\Service\SmsapiComService;
use Smsapi\Client\Version3\SmsapiHttpClient;

class SmsapiUtils
{
    public static function extractCustomFieldsFromSubscribers(array $subscribers): array
    {
        foreach ($subscribers as &$subscriber) {
            self::extractCustomFieldsFromSubscriber($subscriber);
        }

        return $subscribers;
    }

    public static function extractCustomFieldsFromSubscriber(Contact &$subscriber): Contact
    {
        $subscriber->firstName = "";
        $subscriber->lastName = "";
        $subscriber->city = "";
        $subscriber->birthdayDate = "";

        foreach ($subscriber->customFields as $customField) {
            if ($customField->name == "first_name") {
                $subscriber->firstName = $customField->value;
            }
            if ($customField->name == "last_name") {
                $subscriber->lastName = $customField->value;
            }
            if ($customField->name == "city") {
                $subscriber->city = $customField->value;
            }
            if ($customField->name == "birthday_date") {
                $subscriber->birthdayDate = $customField->value;
            }
        }

        return $subscriber;
    }

    public static function obscureToken(string $token): string
    {
        return substr($token, 0, 3) . '...' . substr($token, -3, 3);
    }

    private static function getService($token): SmsapiComService
    {
        $client = new SmsapiHttpClient(
            new SmsapiPsrClient(),
            new SmsapiRequestFactory(),
            new SmsapiStreamFactory()
        );

        return $client->smsapiComServiceWithUri($token, SMSAPI_HOSTNAME);
    }

    public static function ping(string $token): bool
    {
        $service = self::getService($token);

        return $service->pingFeature()->ping()->authorized;
    }

    public static function patchSubscriberUpdate(&$contactBag, $data)
    {
        if (!empty($data['phonenumber'])) {
            $contactBag->phoneNumber = $data['phonenumber'];
        }
        if (!empty($data['firstname'])) {
            $contactBag->firstName = $data['firstname'];
        }
        if (!empty($data['lastname'])) {
            $contactBag->lastName = $data['lastname'];
        }
        if (!empty($data['email'])) {
            $contactBag->email = $data['email'];
        }
        if (!empty($data['city'])) {
            $contactBag->city = $data['city'];
        }
        if (!empty($data['birthdate'])) {
            $contactBag->birthdayDate = $data['birthdate'];
        }

        return $contactBag;
    }
}
