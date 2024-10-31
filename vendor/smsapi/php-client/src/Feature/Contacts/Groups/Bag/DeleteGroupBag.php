<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Contacts\Groups\Bag;

/**
 * @api
 * @property bool $deleteContacts
 */
class DeleteGroupBag
{

    /** @var string */
    public $groupId;

    public function __construct(string $groupId)
    {
        $this->groupId = $groupId;
    }
}
