<?php
declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Sms\Sendernames\Bag;

/**
 * @api
 */
class DeleteSendernameBag
{
    public $sender;

    public function __construct(string $sender)
    {
        $this->sender = $sender;
    }
}
