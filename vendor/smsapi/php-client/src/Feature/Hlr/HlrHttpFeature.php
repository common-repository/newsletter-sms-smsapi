<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\Hlr;

use Smsapi\Client\Version3\Feature\Hlr\Bag\SendHlrBag;
use Smsapi\Client\Version3\Feature\Hlr\Data\Hlr;
use Smsapi\Client\Version3\Feature\Hlr\Data\HlrFactory;
use Smsapi\Client\Version3\Infrastructure\RequestExecutor\LegacyRequestExecutor;
use Smsapi\Client\Version3\SmsapiClientException;
use stdClass;

/**
 * @internal
 */
class HlrHttpFeature implements HlrFeature
{

    /** @var LegacyRequestExecutor */
    private $legacyRequestExecutor;

    /** @var HlrFactory */
    private $hlrFactory;

    public function __construct(LegacyRequestExecutor $legacyRequestExecutor, HlrFactory $hlrFactory)
    {
        $this->legacyRequestExecutor = $legacyRequestExecutor;
        $this->hlrFactory = $hlrFactory;
    }

    /**
     * @param SendHlrBag $sendHlrBag
     * @return Hlr
     * @throws SmsapiClientException
     */
    public function sendHlr(SendHlrBag $sendHlrBag): Hlr
    {
        return $this->hlrFactory->createFromObject($this->makeRequest($sendHlrBag));
    }

    /**
     * @param object $data
     * @return stdClass
     * @throws SmsapiClientException
     */
    private function makeRequest($data): stdClass
    {
        return $this->legacyRequestExecutor->request('hlr.do', (array)$data);
    }
}
