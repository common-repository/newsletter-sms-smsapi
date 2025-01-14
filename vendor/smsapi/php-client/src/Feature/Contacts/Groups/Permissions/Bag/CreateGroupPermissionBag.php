<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Contacts\Groups\Permissions\Bag;

/**
 * @api
 * @property string $read
 * @property string $write
 * @property string $send
 */
class CreateGroupPermissionBag
{

    /** @var string */
    public $groupId;

    /** @var string */
    public $username;

    public function __construct(string $groupId, string $username)
    {
        $this->groupId = $groupId;
        $this->username = $username;
    }
}
