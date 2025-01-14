<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Hlr\Bag;

/**
 * @api
 * @property string $idx
 */
class SendHlrBag
{

    /** @var string */
    public $number;

    public function __construct(string $number)
    {
        $this->number = $number;
    }
}
