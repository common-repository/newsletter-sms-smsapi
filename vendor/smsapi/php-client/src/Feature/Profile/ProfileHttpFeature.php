<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Profile;

use Smsapi\Client\Version3\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Version3\Infrastructure\RequestExecutor\RestRequestExecutor;

/**
 * @internal
 */
class ProfileHttpFeature implements ProfileFeature
{

    use ProfileDefaultHttpFeatures;

    private $restRequestExecutor;
    private $dataFactoryProvider;

    public function __construct(RestRequestExecutor $restRequestExecutor, DataFactoryProvider $dataFactoryProvider)
    {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->dataFactoryProvider = $dataFactoryProvider;
    }
}
