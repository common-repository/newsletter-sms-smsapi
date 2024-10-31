<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Blacklist\Data;

use DateTimeInterface;

/**
 * @api
 */
class BlacklistedPhoneNumber
{
    /** @var string */
    public $id;

    /** @var string */
    public $phoneNumber;

    /** @var DateTimeInterface|null */
    public $expireAt;

    /** @var DateTimeInterface */
    public $createdAt;
}
