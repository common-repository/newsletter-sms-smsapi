<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Mfa\Bag;

/**
 * @api
 * @property string $from
 * @property string $content
 * @property bool $fast
 */
class CreateMfaBag
{
    /**
     * @var string
     */
    public $phoneNumber;

    public function __construct(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public static function notFast(string $phonenumber): self
    {
        $createMfaBag = new self($phonenumber);
        $createMfaBag->fast = false;

        return $createMfaBag;
    }
}
