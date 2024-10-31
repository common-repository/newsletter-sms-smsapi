<?php

class SmsapiConfig
{
    public static function requireReconfiguration()
    {
        $clientConfig = get_option('smsapi_client');

        $clientConfig['configured'] = false;

        update_option('smsapi_client', $clientConfig);
    }

    public static function getApiClientConfig()
    {
        return get_option('smsapi_client', []);
    }

    public static function isConfigurationCompleted()
    {
        $config = get_option('smsapi_client', []);

        return smsapi_array_safe_get($config, 'configured') == 2;
    }

    public static function isCofigurationGeneralCompleted()
    {
        $config = get_option('smsapi_client', []);

        return smsapi_array_safe_get($config, 'configured') >= 1;
    }

    public static function isCofigurationGeneralExtCompleted()
    {
        $config = self::getApiClientConfig();

        return smsapi_array_safe_get($config, 'configured') >= 1 && !empty(smsapi_array_safe_get($config, 'phonebook_group'));
    }

    public static function updateApiClient($data)
    {
        update_option('smsapi_client', $data);
    }

    public static function mergeDataWithApiClient($data)
    {
        $config = self::getApiClientConfig();
        $mergedData = array_merge($config, $data);

        self::updateApiClient($mergedData);
    }

    public static function configurationGeneralCompleted()
    {
        $smsapiCLientConfig = get_option('smsapi_client');

        $smsapiCLientConfig['configured'] = 1;

        self::updateApiClient($smsapiCLientConfig);
    }

    public static function configurationGeneralExtCompleted()
    {
        $smsapiCLientConfig = get_option('smsapi_client');

        $smsapiCLientConfig['configured'] = 2;

        self::updateApiClient($smsapiCLientConfig);
    }
}