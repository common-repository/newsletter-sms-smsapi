<?php
declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Mms\Data;

use DateTimeInterface;

/**
 * @api
 */
class Mms
{
    /** @var string */
    public $id;

    /** @var float */
    public $points;

    /** @var string */
    public $number;

    /** @var DateTimeInterface */
    public $dateSent;

    /** @var string */
    public $status;
}
