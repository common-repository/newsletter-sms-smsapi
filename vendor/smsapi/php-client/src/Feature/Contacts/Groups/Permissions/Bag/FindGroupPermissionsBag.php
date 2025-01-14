<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Contacts\Groups\Permissions\Bag;

/**
 * @api
 */
class FindGroupPermissionsBag
{

    /** @var string */
    public $groupId;

    public function __construct(string $groupId)
    {
        $this->groupId = $groupId;
    }
}
