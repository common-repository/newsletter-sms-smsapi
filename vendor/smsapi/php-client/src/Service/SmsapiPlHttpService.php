<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Service;

use Psr\Http\Client\ClientInterface;
use Smsapi\Client\Version3\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Version3\Feature\Mms\MmsFeature;
use Smsapi\Client\Version3\Feature\Mms\MmsHttpFeature;
use Smsapi\Client\Version3\Feature\Profile\SmsapiPlProfileFeature;
use Smsapi\Client\Version3\Feature\Profile\SmsapiPlProfileHttpFeature;
use Smsapi\Client\Version3\Feature\Vms\VmsFeature;
use Smsapi\Client\Version3\Feature\Vms\VmsHttpFeature;
use Smsapi\Client\Version3\Infrastructure\RequestExecutor\RequestExecutorFactory;

/**
 * @internal
 */
class SmsapiPlHttpService implements SmsapiPlService
{
    use HttpDefaultFeatures;

    private $externalHttpClient;
    private $requestExecutorFactory;
    private $dataFactoryProvider;

    public function __construct(
        ClientInterface $externalHttpClient,
        RequestExecutorFactory $requestExecutorFactory,
        DataFactoryProvider $dataFactoryProvider
    ) {
        $this->externalHttpClient = $externalHttpClient;
        $this->requestExecutorFactory = $requestExecutorFactory;
        $this->dataFactoryProvider = $dataFactoryProvider;
    }

    public function mmsFeature(): MmsFeature
    {
        return new MmsHttpFeature(
            $this->requestExecutorFactory->createLegacyRequestExecutor($this->externalHttpClient),
            $this->dataFactoryProvider->provideMmsFactory()
        );
    }

    public function vmsFeature(): VmsFeature
    {
        return new VmsHttpFeature(
            $this->requestExecutorFactory->createLegacyRequestExecutor($this->externalHttpClient),
            $this->dataFactoryProvider->provideVmsFactory()
        );
    }

    public function profileFeature(): SmsapiPlProfileFeature
    {
        return new SmsapiPlProfileHttpFeature(
            $this->requestExecutorFactory->createRestRequestExecutor($this->externalHttpClient),
            $this->dataFactoryProvider
        );
    }
}
