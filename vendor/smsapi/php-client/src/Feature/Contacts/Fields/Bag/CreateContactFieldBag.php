<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Contacts\Fields\Bag;

/**
 * @api
 * @property string $type
 */
class CreateContactFieldBag
{

    /** @var string */
    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
