<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Contacts\Groups\Bag;

/**
 * @api
 */
class FindContactGroupsBag
{

    /** @var string */
    public $contactId;

    public function __construct(string $contactId)
    {
        $this->contactId = $contactId;
    }
}
