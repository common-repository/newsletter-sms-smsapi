<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Service;

use Smsapi\Client\Version3\Feature\Blacklist\BlacklistFeature;
use Smsapi\Client\Version3\Feature\Contacts\ContactsFeature;
use Smsapi\Client\Version3\Feature\Hlr\HlrFeature;
use Smsapi\Client\Version3\Feature\Mms\MmsFeature;
use Smsapi\Client\Version3\Feature\Ping\PingFeature;
use Smsapi\Client\Version3\Feature\Profile\SmsapiPlProfileFeature;
use Smsapi\Client\Version3\Feature\ShortUrl\ShortUrlFeature;
use Smsapi\Client\Version3\Feature\Mfa\MfaFeature;
use Smsapi\Client\Version3\Feature\Sms\SmsFeature;
use Smsapi\Client\Version3\Feature\Subusers\SubusersFeature;
use Smsapi\Client\Version3\Feature\Vms\VmsFeature;

/**
 * @api
 */
interface SmsapiPlService
{
    public function pingFeature(): PingFeature;

    public function smsFeature(): SmsFeature;

    public function mfaFeature(): MfaFeature;

    public function hlrFeature(): HlrFeature;

    public function subusersFeature(): SubusersFeature;

    public function profileFeature(): SmsapiPlProfileFeature;

    public function shortUrlFeature(): ShortUrlFeature;

    public function contactsFeature(): ContactsFeature;

    public function mmsFeature(): MmsFeature;

    public function vmsFeature(): VmsFeature;

    public function blacklistFeature(): BlacklistFeature;
}
