<?php

use Smsapi\Client\Version3\SmsapiClientException;

require_once SMSAPI_PLUGIN_PATH . '/classes/SmsapiClient.php';

class SmsapiClientProxy
{
    private $smsapiClient;

    public function __construct()
    {
        try {
            $this->smsapiClient = new SMSApiClient();
        } catch (SmsapiClientException $error) {
            smsapi_set_flash_error(__('Please configure API credentials.', 'newsletter-sms-smsapi'));
        }
    }

    public function __call($name, $arguments)
    {
        if ($this->smsapiClient) {
            return call_user_func_array([$this->smsapiClient, $name], $arguments);
        }

        return null;
    }
}