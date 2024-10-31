<?php
declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Ping\Data;

/**
 * @api
 */
class Ping
{
    /** @var bool */
    public $authorized;

    /** @var array */
    public $unavailable;
}
