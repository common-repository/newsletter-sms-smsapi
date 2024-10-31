<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Mfa;

use Smsapi\Client\Version3\Feature\Mfa\Bag\CreateMfaBag;
use Smsapi\Client\Version3\Feature\Mfa\Bag\VerificationMfaBag;
use Smsapi\Client\Version3\Feature\Mfa\Data\Mfa;

/**
 * @api
 */
interface MfaFeature
{
    public function generateMfa(CreateMfaBag $createMfaBag): Mfa;

    public function verifyMfa(VerificationMfaBag $verificationMfaBag);
}
