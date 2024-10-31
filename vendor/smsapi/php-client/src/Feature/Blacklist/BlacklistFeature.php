<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Blacklist;

use Smsapi\Client\Version3\Feature\Blacklist\Bag\CreateBlacklistedPhoneNumberBag;
use Smsapi\Client\Version3\Feature\Blacklist\Bag\FindBlacklistedPhoneNumbersBag;
use Smsapi\Client\Version3\Feature\Blacklist\Data\BlacklistedPhoneNumber;

/**
 * @api
 */
interface BlacklistFeature
{
    public function createBlacklistedPhoneNumber(CreateBlacklistedPhoneNumberBag $createBlacklistedPhoneNumberBag): BlacklistedPhoneNumber;

    public function findBlacklistedPhoneNumbers(FindBlacklistedPhoneNumbersBag $blacklistPhoneNumbersFindBag): array;

    public function deleteBlacklistedPhoneNumber(Bag\DeleteBlacklistedPhoneNumberBag $blacklistPhoneNumberDeleteBag);

    public function deleteBlacklistedPhoneNumbers();
}