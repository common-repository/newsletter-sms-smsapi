<?php
declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\ShortUrl;

use Smsapi\Client\Version3\Feature\ShortUrl\Bag\CreateShortUrlLinkBag;
use Smsapi\Client\Version3\Feature\ShortUrl\Data\ShortUrlLink;
use Smsapi\Client\Version3\SmsapiClientException;

/**
 * @api
 */
interface ShortUrlFeature
{

    /**
     * @param CreateShortUrlLinkBag $createShortUrlLink
     * @return ShortUrlLink
     * @throws SmsapiClientException
     */
    public function createShortUrlLink(CreateShortUrlLinkBag $createShortUrlLink): ShortUrlLink;
}
