<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Contacts\Fields\Bag;

/**
 * @api
 */
class UpdateContactFieldBag
{

    /** @var string */
    public $fieldId;

    /** @var string */
    public $name;

    public function __construct(string $fieldId, string $name)
    {
        $this->fieldId = $fieldId;
        $this->name = $name;
    }
}
