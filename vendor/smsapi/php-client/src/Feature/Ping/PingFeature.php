<?php
declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Ping;

use Smsapi\Client\Version3\Feature\Ping\Data\Ping;

/**
 * @api
 */
interface PingFeature
{
    public function ping(): Ping;
}
