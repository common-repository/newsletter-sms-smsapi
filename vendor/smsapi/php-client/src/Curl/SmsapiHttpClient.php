<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Curl;

use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Smsapi\Client\Version3\Curl\Discovery\CurlDiscovery;
use Smsapi\Client\Version3\Curl\Discovery\GuzzleHttpHelpersDiscovery;
use Smsapi\Client\Version3\Service\SmsapiComService;
use Smsapi\Client\Version3\Service\SmsapiPlService;
use Smsapi\Client\Version3\SmsapiClient;

/**
 * @api
 */
class SmsapiHttpClient implements SmsapiClient
{
    use LoggerAwareTrait;

    private $httpClient;

    public function __construct()
    {
        CurlDiscovery::run();
        GuzzleHttpHelpersDiscovery::run();

        $this->httpClient = new \Smsapi\Client\Version3\SmsapiHttpClient(
            new HttpClient(),
            new RequestFactory(),
            new StreamFactory()
        );
    }

    public function smsapiPlService(string $apiToken): SmsapiPlService
    {
        return $this->httpClient()->smsapiPlService($apiToken);
    }

    public function smsapiPlServiceWithUri(string $apiToken, string $uri): SmsapiPlService
    {
        return $this->httpClient()->smsapiPlServiceWithUri($apiToken, $uri);
    }

    public function smsapiComService(string $apiToken): SmsapiComService
    {
        return $this->httpClient()->smsapiComService($apiToken);
    }

    public function smsapiComServiceWithUri(string $apiToken, string $uri): SmsapiComService
    {
        return $this->httpClient()->smsapiComServiceWithUri($apiToken, $uri);
    }

    private function httpClient(): \Smsapi\Client\Version3\SmsapiHttpClient
    {
        if ($this->logger instanceof LoggerInterface) {
            $this->httpClient->setLogger($this->logger);
        }

        return $this->httpClient;
    }
}
