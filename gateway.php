<?php

function action_smsapi_gateway($recipientsNumbers = null)
{
    $smsapiClient = new SMSApiClientProxy();

    $settingsGeneral = get_option('smsapi_client', []);
    $settingsSubscription = get_option('smsapi_subscription', []);

    $config = array_merge($settingsGeneral, $settingsSubscription);

    $senderNames = $smsapiClient->getSenderNames();
    $defaultSendername = smsapi_array_safe_get($config, 'api_sendername');

    if ($recipientsNumbers) {
        $recipients = implode(',', $recipientsNumbers);
    }

    if (!empty($_POST)) {
        $form = new GatewayForm($_POST, $senderNames);

        if ($form->isValid()) {
            $data = $form->getData();

            $recipients = smsapi_array_safe_get($data, 'recipients');
            $message = smsapi_array_safe_get($data, 'message');
            $sendername = smsapi_array_safe_get($data, 'sendername');
            $normalize = smsapi_array_safe_get($data, 'normalize');

            $smsapiClient->setSendername($sendername);
            $smsapiClient->setNormalize($normalize);

            $recipientsType = !empty($_POST['recipients_type']) ? sanitize_text_field($_POST['recipients_type']) : null;
            try {
                if ($recipientsType == 'all') {
                    $smsapiClient->sendSmsToAll($message);
                } elseif ($recipientsType == 'specified') {
                    $numbers = explode(',', $recipients);
                    $smsapiClient->sendSmss($numbers, $message);
                }
                smsapi_set_flash_success(__('Message was sent', 'newsletter-sms-smsapi'));
            } catch (\Smsapi\Client\Infrastructure\ResponseMapper\ApiErrorException $e) {
                if ($e->getMessage() == 'Cannot send sms, account balance is low') {
                    smsapi_set_flash_error(__('Cannot send sms, account balance is low', 'newsletter-sms-smsapi'));
                } else {
                    smsapi_set_flash_error($e->getMessage());
                }
            }

        } else {
            $errors = $form->getErrors();
            smsapi_set_flash_error(__('Correct errors on the form and try again', 'newsletter-sms-smsapi'));
        }
    }

    include_once SMSAPI_PLUGIN_PATH . "/views/admin/gateway/index.php";
}