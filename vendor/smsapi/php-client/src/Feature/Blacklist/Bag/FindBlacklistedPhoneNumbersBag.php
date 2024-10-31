<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Blacklist\Bag;

use Smsapi\Client\Version3\Feature\Bag\PaginationBag;

/**
 * @api
 * @property string $q
 */
class FindBlacklistedPhoneNumbersBag
{
    use PaginationBag;
}
