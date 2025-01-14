<?php
declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Sms\Sendernames;

use Smsapi\Client\Version3\Feature\Sms\Sendernames\Bag\CreateSendernameBag;
use Smsapi\Client\Version3\Feature\Sms\Sendernames\Bag\DeleteSendernameBag;
use Smsapi\Client\Version3\Feature\Sms\Sendernames\Bag\FindSendernameBag;
use Smsapi\Client\Version3\Feature\Sms\Sendernames\Bag\MakeSendernameDefaultBag;
use Smsapi\Client\Version3\Feature\Sms\Sendernames\Data\Sendername;

/**
 * @api
 */
interface SendernamesFeature
{
    public function findSendername(FindSendernameBag $findSendernameBag): Sendername;

    /**
     * @return Sendername[]
     */
    public function findSendernames(): array;

    public function createSendername(CreateSendernameBag $createSendernameBag): Sendername;

    public function deleteSendername(DeleteSendernameBag $deleteSendernameBag);

    public function makeSendernameDefault(MakeSendernameDefaultBag $makeSendernameDefault);
}
