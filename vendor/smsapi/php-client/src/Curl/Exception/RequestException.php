<?php

declare(strict_types=1);

namespace Smsapi\Client\Version3\Curl\Exception;

use Psr\Http\Client\RequestExceptionInterface;

/**
 * @api
 */
class RequestException extends ClientException implements RequestExceptionInterface
{

}