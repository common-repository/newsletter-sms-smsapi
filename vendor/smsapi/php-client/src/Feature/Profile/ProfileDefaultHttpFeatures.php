<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Profile;

use Smsapi\Client\Version3\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Version3\Feature\Profile\Data\Profile;
use Smsapi\Client\Version3\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\Version3\SmsapiClientException;

/**
 * @internal
 */
trait ProfileDefaultHttpFeatures
{
    /** @var RestRequestExecutor */
    private $restRequestExecutor;

    /** @var DataFactoryProvider */
    private $dataFactoryProvider;

    /**
     * @return Profile
     * @throws SmsapiClientException
     */
    public function findProfile(): Profile
    {
        return $this->dataFactoryProvider
            ->provideProfileFactory()
            ->createFromObject($this->restRequestExecutor->read('profile', []));
    }
}
