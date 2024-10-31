<?php

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

require_once SMSAPI_PLUGIN_PATH . '/classes/SmsapiPsrRequest.php';


class SmsapiRequestFactory implements RequestFactoryInterface
{
    public function createRequest(string $method, $uri): RequestInterface
    {
        return new SmsapiPsrRequest($method, $uri);
    }
}