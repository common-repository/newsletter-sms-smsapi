<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Contacts\Data;

/**
 * @internal
 */
class ContactCustomFieldFactory
{
    public function create(string $name, string $value): ContactCustomField
    {
        return new ContactCustomField($name, $value);
    }
}
