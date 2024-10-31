<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Contacts\Groups\Members\Bag;

/**
 * @api
 */
class PinContactToGroupBag
{

    /** @var string */
    public $contactId;

    /** @var string */
    public $groupId;

    public function __construct(string $contactId, string $groupId)
    {
        $this->contactId = $contactId;
        $this->groupId = $groupId;
    }
}
