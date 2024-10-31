<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Contacts\Groups\Members;

use Smsapi\Client\Version3\Feature\Contacts\Data\Contact;
use Smsapi\Client\Version3\Feature\Contacts\Groups\Members\Bag\AddContactToGroupByQueryBag;
use Smsapi\Client\Version3\Feature\Contacts\Groups\Members\Bag\FindContactInGroupBag;
use Smsapi\Client\Version3\Feature\Contacts\Groups\Members\Bag\MoveContactToGroupByQueryBag;
use Smsapi\Client\Version3\Feature\Contacts\Groups\Members\Bag\PinContactToGroupBag;
use Smsapi\Client\Version3\Feature\Contacts\Groups\Members\Bag\UnpinContactFromGroupBag;
use Smsapi\Client\Version3\Feature\Contacts\Groups\Members\Bag\UnpinContactFromGroupByQueryBag;

/**
 * @api
 */
interface ContactsGroupsMembersFeature
{

    public function addContactToGroupByQuery(AddContactToGroupByQueryBag $addContactToGroupByQueryBag);

    public function findContactInGroup(FindContactInGroupBag $findContactInGroupBag): Contact;

    public function moveContactToGroupByQuery(MoveContactToGroupByQueryBag $moveContactToGroupByQueryBag);

    public function pinContactToGroup(PinContactToGroupBag $pinContactToGroupBag): Contact;

    public function unpinContactFromGroupByQuery(UnpinContactFromGroupByQueryBag $unpinContactFromGroupByQueryBag);

    public function unpinContactFromGroup(UnpinContactFromGroupBag $unpinContactFromGroupBag);
}
