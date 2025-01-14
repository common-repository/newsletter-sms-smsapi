<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Mfa\Bag;

/**
 * @api
 */
class VerificationMfaBag
{
    /**
     * @var string
     */
    public $phoneNumber;
    /**
     * @var string
     */
    public $code;

    public function __construct(string $code, string $phoneNumber)
    {
        $this->code = $code;
        $this->phoneNumber = $phoneNumber;
    }
}
