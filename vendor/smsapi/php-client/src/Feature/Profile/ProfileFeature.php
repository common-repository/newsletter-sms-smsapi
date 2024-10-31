<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Profile;

use Smsapi\Client\Version3\Feature\Profile\Data\Profile;

/**
 * @api
 */
interface ProfileFeature
{

    public function findProfile(): Profile;
}
