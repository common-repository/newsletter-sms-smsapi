<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Contacts;

use Smsapi\Client\Version3\Feature\Contacts\Fields\ContactsFieldsFeature;
use Smsapi\Client\Version3\Feature\Contacts\Fields\ContactsFieldsHttpFeature;
use Smsapi\Client\Version3\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Version3\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\Version3\Feature\Contacts\Bag\CreateContactBag;
use Smsapi\Client\Version3\Feature\Contacts\Bag\DeleteContactBag;
use Smsapi\Client\Version3\Feature\Contacts\Bag\FindContactBag;
use Smsapi\Client\Version3\Feature\Contacts\Bag\FindContactsBag;
use Smsapi\Client\Version3\Feature\Contacts\Bag\UpdateContactBag;
use Smsapi\Client\Version3\Feature\Contacts\Data\Contact;
use Smsapi\Client\Version3\Feature\Contacts\Groups\ContactsGroupsFeature;
use Smsapi\Client\Version3\Feature\Contacts\Groups\ContactsGroupsHttpFeature;

/**
 * @internal
 */
class ContactsHttpFeature implements ContactsFeature
{
    private $restRequestExecutor;
    private $dataFactoryProvider;

    public function __construct(RestRequestExecutor $restRequestExecutor, DataFactoryProvider $dataFactoryProvider)
    {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->dataFactoryProvider = $dataFactoryProvider;
    }

    public function findContacts(FindContactsBag $findContactsBag = null): array
    {
        $result = $this->restRequestExecutor->read('contacts', (array)$findContactsBag);

        return array_map(
            [$this->dataFactoryProvider->provideContactFactory(), 'createFromObject'],
            $result->collection
        );
    }

    public function findContact(FindContactBag $findContactBag): Contact
    {
        $result = $this->restRequestExecutor->read('contacts/' . $findContactBag->contactId, []);

        return $this->dataFactoryProvider->provideContactFactory()->createFromObject($result);
    }

    public function createContact(CreateContactBag $createContactBag): Contact
    {
        $result = $this->restRequestExecutor->create('contacts', (array)$createContactBag);

        return $this->dataFactoryProvider->provideContactFactory()->createFromObject($result);
    }

    public function updateContact(UpdateContactBag $updateContactBag): Contact
    {
        $contactId = $updateContactBag->contactId;

        unset($updateContactBag->contactId);

        $result = $this->restRequestExecutor->update('contacts/' . $contactId, (array)$updateContactBag);

        return $this->dataFactoryProvider->provideContactFactory()->createFromObject($result);
    }

    public function deleteContact(DeleteContactBag $deleteContactBag)
    {
        $this->restRequestExecutor->delete('contacts/' . $deleteContactBag->contactId, []);
    }

    public function deleteContacts()
    {
        $this->restRequestExecutor->delete('contacts', []);
    }

    public function groupsFeature(): ContactsGroupsFeature
    {
        return new ContactsGroupsHttpFeature($this->restRequestExecutor, $this->dataFactoryProvider);
    }

    public function fieldsFeature(): ContactsFieldsFeature
    {
        return new ContactsFieldsHttpFeature($this->restRequestExecutor, $this->dataFactoryProvider);
    }
}
