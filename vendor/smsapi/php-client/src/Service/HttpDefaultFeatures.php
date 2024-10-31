<?php
declare(strict_types=1);

namespace Smsapi\Client\Version3\Service;

use Smsapi\Client\Version3\Feature\Blacklist\BlacklistFeature;
use Smsapi\Client\Version3\Feature\Blacklist\BlacklistHttpFeature;
use Smsapi\Client\Version3\Feature\Contacts\ContactsFeature;
use Smsapi\Client\Version3\Feature\Contacts\ContactsHttpFeature;
use Smsapi\Client\Version3\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Version3\Feature\Hlr\HlrFeature;
use Smsapi\Client\Version3\Feature\Hlr\HlrHttpFeature;
use Smsapi\Client\Version3\Feature\ShortUrl\ShortUlrHttpFeature;
use Smsapi\Client\Version3\Feature\ShortUrl\ShortUrlFeature;
use Smsapi\Client\Version3\Feature\Mfa\MfaFeature;
use Smsapi\Client\Version3\Feature\Mfa\MfaHttpFeature;
use Smsapi\Client\Version3\Feature\Sms\SmsFeature;
use Smsapi\Client\Version3\Feature\Sms\SmsHttpFeature;
use Smsapi\Client\Version3\Feature\Subusers\SubusersFeature;
use Smsapi\Client\Version3\Feature\Ping\PingFeature;
use Smsapi\Client\Version3\Feature\Ping\PingHttpFeature;
use Smsapi\Client\Version3\Feature\Subusers\SubusersHttpFeature;
use Smsapi\Client\Version3\Infrastructure\RequestExecutor\RequestExecutorFactory;

/**
 * @internal
 */
trait HttpDefaultFeatures
{
    /** @var RequestExecutorFactory */
    private $requestExecutorFactory;

    /** @var DataFactoryProvider */
    private $dataFactoryProvider;

    public function pingFeature(): PingFeature
    {
        $restRequestExecutor = $this->requestExecutorFactory->createRestRequestExecutor($this->externalHttpClient);
        $pingFactory = $this->dataFactoryProvider->providePingFactory();

        return new PingHttpFeature($restRequestExecutor, $pingFactory);
    }

    public function smsFeature(): SmsFeature
    {
        return new SmsHttpFeature(
            $this->externalHttpClient,
            $this->requestExecutorFactory,
            $this->dataFactoryProvider
        );
    }

    public function mfaFeature(): MfaFeature
    {
        $restRequestExecutor = $this->requestExecutorFactory->createRestRequestExecutor($this->externalHttpClient);
        $mfaFactory = $this->dataFactoryProvider->provideMfaFactory();

        return new MfaHttpFeature($restRequestExecutor, $mfaFactory);
    }

    public function hlrFeature(): HlrFeature
    {
        return new HlrHttpFeature(
            $this->requestExecutorFactory->createLegacyRequestExecutor($this->externalHttpClient),
            $this->dataFactoryProvider->provideHlrFactory()
        );
    }

    public function subusersFeature(): SubusersFeature
    {
        return new SubusersHttpFeature(
            $this->requestExecutorFactory->createRestRequestExecutor($this->externalHttpClient),
            $this->dataFactoryProvider->provideSubuserFactory()
        );
    }

    public function shortUrlFeature(): ShortUrlFeature
    {
        return new ShortUlrHttpFeature(
            $this->requestExecutorFactory->createRestRequestExecutor($this->externalHttpClient),
            $this->dataFactoryProvider->provideShortUrlLinkFactory()
        );
    }

    public function contactsFeature(): ContactsFeature
    {
        return new ContactsHttpFeature(
            $this->requestExecutorFactory->createRestRequestExecutor($this->externalHttpClient),
            $this->dataFactoryProvider
        );
    }

    public function blacklistFeature(): BlacklistFeature
    {
        return new BlacklistHttpFeature(
            $this->requestExecutorFactory->createRestRequestExecutor($this->externalHttpClient),
            $this->dataFactoryProvider->provideBlacklistedPhoneNumberFactory()
        );
    }
}
