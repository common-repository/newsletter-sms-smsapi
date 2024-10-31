<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Infrastructure\HttpClient;

use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Smsapi\Client\Version3\Infrastructure\HttpClient\Decorator\AuthorizationHeaderDecorator;
use Smsapi\Client\Version3\Infrastructure\HttpClient\Decorator\BaseUriDecorator;
use Smsapi\Client\Version3\Infrastructure\HttpClient\Decorator\CorrelationIdHeaderDecorator;
use Smsapi\Client\Version3\Infrastructure\HttpClient\Decorator\LoggerDecorator;
use Smsapi\Client\Version3\Infrastructure\HttpClient\Decorator\HttpClientUserAgentHeaderDecorator;

/**
 * @internal
 */
class HttpClientFactory
{
    use LoggerAwareTrait;

    private $apiToken;
    private $uri;

    public function __construct(string $apiToken, string $uri)
    {
        $this->logger = new NullLogger();
        $this->apiToken = $apiToken;
        $this->uri = $uri;
    }

    public function createClient(ClientInterface $externalClient): ClientInterface
    {
        $client = new LoggerDecorator($externalClient, $this->logger);
        $client = new BaseUriDecorator($client, $this->uri);
        $client = new AuthorizationHeaderDecorator($client, $this->apiToken);
        $client = new HttpClientUserAgentHeaderDecorator($client);
        $client = new CorrelationIdHeaderDecorator($client);

        return $client;
    }
}
