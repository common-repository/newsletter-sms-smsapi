<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Blacklist;

use Smsapi\Client\Version3\Feature\Blacklist\Bag\CreateBlacklistedPhoneNumberBag;
use Smsapi\Client\Version3\Feature\Blacklist\Bag\FindBlacklistedPhoneNumbersBag;
use Smsapi\Client\Version3\Feature\Blacklist\Data\BlacklistedPhoneNumberFactory;
use Smsapi\Client\Version3\Feature\Blacklist\Data\BlacklistedPhoneNumber;
use Smsapi\Client\Version3\Infrastructure\RequestExecutor\RestRequestExecutor;

/**
 * @internal
 */
class BlacklistHttpFeature implements BlacklistFeature
{
    private $restRequestExecutor;
    private $blacklistedPhoneNumberFactory;

    public function __construct(RestRequestExecutor $restRequestExecutor, BlacklistedPhoneNumberFactory $blacklistedPhoneNumberFactory)
    {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->blacklistedPhoneNumberFactory = $blacklistedPhoneNumberFactory;
    }

    public function createBlacklistedPhoneNumber(CreateBlacklistedPhoneNumberBag $createBlacklistedPhoneNumberBag): BlacklistedPhoneNumber
    {
        $result = $this->restRequestExecutor->create('blacklist/phone_numbers', (array)$createBlacklistedPhoneNumberBag);

        return $this->blacklistedPhoneNumberFactory->createFromObject($result);
    }

    public function findBlacklistedPhoneNumbers(FindBlacklistedPhoneNumbersBag $blacklistPhoneNumbersFindBag): array
    {
        $result = $this->restRequestExecutor->read('blacklist/phone_numbers', (array)$blacklistPhoneNumbersFindBag);

        return array_map(
            [$this->blacklistedPhoneNumberFactory, 'createFromObject'],
            $result->collection
        );
    }

    public function deleteBlacklistedPhoneNumber(Bag\DeleteBlacklistedPhoneNumberBag $blacklistPhoneNumberDeleteBag)
    {
        $this->restRequestExecutor->delete('blacklist/phone_numbers/' . $blacklistPhoneNumberDeleteBag->id, []);
    }

    public function deleteBlacklistedPhoneNumbers()
    {
        $this->restRequestExecutor->delete('blacklist/phone_numbers/', []);
    }
}
