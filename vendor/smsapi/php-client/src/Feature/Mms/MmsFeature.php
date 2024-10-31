<?php
declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Mms;

use Smsapi\Client\Version3\Feature\Mms\Bag\SendMmsBag;
use Smsapi\Client\Version3\Feature\Mms\Data\Mms;

/**
 * @api
 */
interface MmsFeature
{
    public function sendMms(SendMmsBag $sendMmsBag): Mms;
}
