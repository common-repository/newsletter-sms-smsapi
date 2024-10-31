<?php

class SmsapiResponse
{
    private static $STATUS_CODES = [13 => 'Invalid phone number'];

    public static function parseResponseCode($code)
    {
        return array_key_exists($code, self::$STATUS_CODES) ? _e(self::$STATUS_CODES[$code], 'newsletter-sms-smsapi') : _e(
                'Unexpected error',
                'smsapi'
            ) . ': ' . $code;
    }
}