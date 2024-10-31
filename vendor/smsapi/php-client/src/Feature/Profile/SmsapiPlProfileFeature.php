<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Profile;

/**
 * @api
 */
interface SmsapiPlProfileFeature extends ProfileFeature
{

    public function findProfilePrices(): array;
}
