<?php
declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Contacts;

use Smsapi\Client\Version3\Feature\Contacts\Bag\CreateContactBag;
use Smsapi\Client\Version3\Feature\Contacts\Bag\DeleteContactBag;
use Smsapi\Client\Version3\Feature\Contacts\Bag\FindContactBag;
use Smsapi\Client\Version3\Feature\Contacts\Bag\FindContactsBag;
use Smsapi\Client\Version3\Feature\Contacts\Bag\UpdateContactBag;
use Smsapi\Client\Version3\Feature\Contacts\Data\Contact;
use Smsapi\Client\Version3\Feature\Contacts\Fields\ContactsFieldsFeature;
use Smsapi\Client\Version3\Feature\Contacts\Groups\ContactsGroupsFeature;

/**
 * @api
 */
interface ContactsFeature
{
    /**
     * @return Contact[]
     */
    public function findContacts(FindContactsBag $findContactsBag = null): array;

    public function findContact(FindContactBag $findContactBag): Contact;

    public function createContact(CreateContactBag $createContactBag): Contact;

    public function updateContact(UpdateContactBag $updateContactBag): Contact;

    public function deleteContact(DeleteContactBag $deleteContactBag);

    public function deleteContacts();

    public function groupsFeature(): ContactsGroupsFeature;

    public function fieldsFeature(): ContactsFieldsFeature;
}
