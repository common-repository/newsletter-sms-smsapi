<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Contacts\Bag;

/**
 * @api
 */
class FindContactBag
{

    /** @var string */
    public $contactId;

    public function __construct(string $contactId)
    {
        $this->contactId = $contactId;
    }
}
