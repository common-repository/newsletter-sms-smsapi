<?php
declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Vms;

use Smsapi\Client\Version3\Feature\Vms\Bag\SendVmsBag;
use Smsapi\Client\Version3\Feature\Vms\Data\Vms;

/**
 * @api
 */
interface VmsFeature
{

    /**
     * @param SendVmsBag $sendVmsBag
     * @return Vms
     */
    public function sendVms(SendVmsBag $sendVmsBag): Vms;
}
