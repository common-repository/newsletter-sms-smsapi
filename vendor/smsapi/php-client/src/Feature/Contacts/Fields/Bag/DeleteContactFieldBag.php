<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Contacts\Fields\Bag;

/**
 * @api
 */
class DeleteContactFieldBag
{

    /** @var string */
    public $fieldId;

    public function __construct(string $fieldId)
    {
        $this->fieldId = $fieldId;
    }
}
