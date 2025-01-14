<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Contacts\Groups\Members\Bag;

/**
 * @api
 * @property string $q
 * @property string $phoneNumber
 * @property string $email
 * @property string $firstName
 * @property string $lastName
 * @property string $groupId
 * @property string $gender
 * @property string $birthdayDate
 */
class UnpinContactFromGroupByQueryBag
{

    /** @var string */
    public $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
