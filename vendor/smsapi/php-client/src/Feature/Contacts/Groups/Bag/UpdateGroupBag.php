<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Contacts\Groups\Bag;

/**
 * @api
 * @property string $description
 * @property string $idx
 * @property integer $contactExpireAfter
 */
class UpdateGroupBag
{

    /** @var string */
    public $groupId;

    /** @var string */
    public $name;

    public function __construct(string $groupId, string $name)
    {
        $this->groupId = $groupId;
        $this->name = $name;
    }
}
