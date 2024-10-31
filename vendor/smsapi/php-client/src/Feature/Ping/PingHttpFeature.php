<?php
declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Ping;

use Smsapi\Client\Version3\Feature\Ping\Data\PingFactory;
use Smsapi\Client\Version3\Feature\Ping\Data\Ping;
use Smsapi\Client\Version3\Infrastructure\RequestExecutor\RestRequestExecutor;

/**
 * @internal
 */
class PingHttpFeature implements PingFeature
{
    private $restRequestExecutor;
    private $pingFactory;

    public function __construct(RestRequestExecutor $restRequestExecutor, PingFactory $pingFactory)
    {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->pingFactory = $pingFactory;
    }

    public function ping(): Ping
    {
        $result = $this->restRequestExecutor->read('ping', []);

        return $this->pingFactory->createFromObject($result);
    }
}
