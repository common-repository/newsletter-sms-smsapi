<?php
declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Mms;

use Smsapi\Client\Version3\Feature\Mms\Bag\SendMmsBag;
use Smsapi\Client\Version3\Feature\Mms\Data\Mms;
use Smsapi\Client\Version3\Feature\Mms\Data\MmsFactory;
use Smsapi\Client\Version3\Infrastructure\RequestExecutor\LegacyRequestExecutor;
use Smsapi\Client\Version3\SmsapiClientException;

/**
 * @internal
 */
class MmsHttpFeature implements MmsFeature
{
    private $legacyRequestExecutor;
    private $mmsFactory;

    public function __construct(LegacyRequestExecutor $legacyRequestExecutor, MmsFactory $mmsFactory)
    {
        $this->legacyRequestExecutor = $legacyRequestExecutor;
        $this->mmsFactory = $mmsFactory;
    }

    /**
     * @param SendMmsBag $sendMmsBag
     * @return Mms
     * @throws SmsapiClientException
     */
    public function sendMms(SendMmsBag $sendMmsBag): Mms
    {
        $object = current($this->legacyRequestExecutor->request('mms.do', (array)$sendMmsBag)->list);

        return $this->mmsFactory->createFromObject($object);
    }
}
