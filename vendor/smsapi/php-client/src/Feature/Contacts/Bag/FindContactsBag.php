<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Contacts\Bag;

use Smsapi\Client\Version3\Feature\Bag\PaginationBag;
use Smsapi\Client\Version3\Feature\Bag\SortBag;

/**
 * @api
 * @property string $q
 * @property string $phoneNumber
 * @property string $email
 * @property string $firstName
 * @property string $lastName
 * @property array $groupId
 * @property string $gender
 * @property string $birthdayDate
 */
class FindContactsBag
{
    use PaginationBag;
    use SortBag;

    public function setName(string $firstName, string $lastName): self
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        return $this;
    }
}
