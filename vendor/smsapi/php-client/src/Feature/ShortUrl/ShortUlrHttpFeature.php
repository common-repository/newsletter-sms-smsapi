<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Feature\ShortUrl;

use Smsapi\Client\Version3\Feature\ShortUrl\Bag\CreateShortUrlLinkBag;
use Smsapi\Client\Version3\Feature\ShortUrl\Data\ShortUrlLink;
use Smsapi\Client\Version3\Feature\ShortUrl\Data\ShortUrlLinkFactory;
use Smsapi\Client\Version3\Infrastructure\RequestExecutor\RestRequestExecutor;

/**
 * @internal
 */
class ShortUlrHttpFeature implements ShortUrlFeature
{

    /** @var RestRequestExecutor */
    private $restRequestExecutor;

    /** @var ShortUrlLinkFactory */
    private $factory;

    public function __construct(RestRequestExecutor $restRequestExecutor, ShortUrlLinkFactory $factory)
    {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->factory = $factory;
    }

    /**
     * @inheritdoc
     */
    public function createShortUrlLink(CreateShortUrlLinkBag $createShortUrlLink): ShortUrlLink
    {
        $result = $this->restRequestExecutor->create('short_url/links', (array)$createShortUrlLink);
        return $this->factory->createFromObject($result);
    }
}
