<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Blacklist\Bag;

use DateTimeInterface;

/**
 * @api
 * @property DateTimeInterface $expireAt
 */
class CreateBlacklistedPhoneNumberBag
{
    /** @var string */
    public $phoneNumber;

    public function __construct(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }
}