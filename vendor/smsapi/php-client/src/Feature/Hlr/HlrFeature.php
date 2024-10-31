<?php
declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Hlr;

use Smsapi\Client\Version3\Feature\Hlr\Bag\SendHlrBag;
use Smsapi\Client\Version3\Feature\Hlr\Data\Hlr;

/**
 * @api
 */
interface HlrFeature
{
    public function sendHlr(SendHlrBag $sendHlrBag): Hlr;
}
