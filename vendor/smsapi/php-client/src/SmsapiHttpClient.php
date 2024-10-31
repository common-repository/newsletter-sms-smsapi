<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Smsapi\Client\Version3\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Version3\Infrastructure\HttpClient\HttpClientFactory;
use Smsapi\Client\Version3\Infrastructure\RequestExecutor\RequestExecutorFactory;
use Smsapi\Client\Version3\Service\SmsapiComService;
use Smsapi\Client\Version3\Service\SmsapiComHttpService;
use Smsapi\Client\Version3\Service\SmsapiPlService;
use Smsapi\Client\Version3\Service\SmsapiPlHttpService;

/**
 * @api
 */
class SmsapiHttpClient implements SmsapiClient
{
    use LoggerAwareTrait;

    private $httpClient;
    private $requestFactory;
    private $streamFactory;

    private $smsapiPlUri = 'https://api.smsapi.pl';
    private $smsapiComUri = 'https://api.smsapi.com';
    private $dataFactoryProvider;

    public function __construct(
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->dataFactoryProvider = new DataFactoryProvider();
        $this->logger = new NullLogger();
        $this->streamFactory = $streamFactory;
    }

    public function smsapiPlService(string $apiToken): SmsapiPlService
    {
        return $this->smsapiPlServiceWithUri($apiToken, $this->smsapiPlUri);
    }

    public function smsapiPlServiceWithUri(string $apiToken, string $uri): SmsapiPlService
    {
        return new SmsapiPlHttpService(
            $this->httpClient,
            $this->createRequestExecutorFactory($apiToken, $uri),
            $this->dataFactoryProvider
        );
    }

    public function smsapiComService(string $apiToken): SmsapiComService
    {
        return $this->smsapiComServiceWithUri($apiToken, $this->smsapiComUri);
    }

    public function smsapiComServiceWithUri(string $apiToken, string $uri): SmsapiComService
    {
        return new SmsapiComHttpService(
            $this->httpClient,
            $this->createRequestExecutorFactory($apiToken, $uri),
            $this->dataFactoryProvider
        );
    }

    private function createRequestExecutorFactory(string $apiToken, string $uri): RequestExecutorFactory
    {
        $httpClientFactory = new HttpClientFactory($apiToken, $uri);
        $requestExecutorFactory = new RequestExecutorFactory($httpClientFactory, $this->requestFactory, $this->streamFactory);
        $requestExecutorFactory->setLogger($this->logger);

        return $requestExecutorFactory;
    }
}
