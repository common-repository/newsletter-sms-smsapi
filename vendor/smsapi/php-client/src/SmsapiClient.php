<?php
declare(strict_types=1);

namespace Smsapi\Client\Version3;

use Psr\Log\LoggerAwareInterface;
use Smsapi\Client\Version3\Service\SmsapiComService;
use Smsapi\Client\Version3\Service\SmsapiPlService;

/**
 * @api
 */
interface SmsapiClient extends LoggerAwareInterface
{
    const VERSION = '3.0.6';

    public function smsapiPlService(string $apiToken): SmsapiPlService;

    public function smsapiPlServiceWithUri(string $apiToken, string $uri): SmsapiPlService;

    public function smsapiComService(string $apiToken): SmsapiComService;

    public function smsapiComServiceWithUri(string $apiToken, string $uri): SmsapiComService;
}
