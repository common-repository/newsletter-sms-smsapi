<?php

require_once SMSAPI_PLUGIN_PATH . '/forms.php';
require_once SMSAPI_PLUGIN_PATH . '/classes/SmsapiUtils.php';

function action_smsapi_settings_general()
{
    if (smsapi_is_post_request()) {
        action_smsapi_settings_general_login_post();
    } else {
        action_smsapi_settings_general_login();
    }
}

function action_smsapi_settings_general_login()
{
    include_once SMSAPI_PLUGIN_PATH . "/views/admin/settings/login.php";
}

function action_smsapi_settings_general_login_post()
{
    $formValid = true;
    $form = new SmsapiSettingsLoginForm($_POST);

    if (!$form->isValid()) {
        $formValid = false;
        smsapi_set_flash_error(__('Correct errors on the form and try again', 'newsletter-sms-smsapi'));
        $errors = $form->getErrors();
    }
    $data = $form->getData();
    if (empty($data['api_token']) || !SmsapiUtils::ping($data['api_token'])) {
        $formValid = false;
        smsapi_set_flash_error(__('Please configure API credentials.', 'newsletter-sms-smsapi'));
    }

    if ($formValid) {
        SmsapiConfig::updateApiClient($data);
        SmsapiConfig::configurationGeneralCompleted();
        smsapi_set_flash_success(__('Data has been saved', 'newsletter-sms-smsapi'));
        smsapi_set_flash_warning(__('Please select group and sender name to finish settings', 'newsletter-sms-smsapi'));
        action_smsapi_settings_general_ext_form();
    } else {
        action_smsapi_settings_general_login();
    }
}

function action_smsapi_settings_general_ext()
{
    if (smsapi_is_post_request()) {
        action_smsapi_settings_general_ext_post();
    } else {
        action_smsapi_settings_general_ext_form();
    }
}

function action_smsapi_settings_general_ext_form()
{
    $config = get_option('smsapi_client', array());
    $smsapiClient = new SMSApiClientProxy();

    $username = $smsapiClient->getUsername();
    $token = SmsapiUtils::obscureToken(smsapi_array_safe_get($config, 'api_token'));
    $senderNames = $smsapiClient->getSenderNames();
    $phonebookGroups = $smsapiClient->getPhonebookGroups();

    include_once SMSAPI_PLUGIN_PATH . "/views/admin/settings/general.php";
}

function action_smsapi_settings_general_ext_post()
{
    $form = new SmsapiSettingsGeneralForm($_POST);
    if ($form->isValid()) {
        $data = $form->getData();

        $newGroupName = smsapi_array_safe_get($data, 'new_group_name');

        if (!empty($_POST['add_new_group']) && $newGroupName) {
            $smsapiClient = new SMSApiClientProxy();

            if ($group = $smsapiClient->addGroup($newGroupName)) {
                $data['phonebook_group'] = $group->getId();
            }

            unset($data['new_group_name']);
        }

        SmsapiConfig::mergeDataWithApiClient($data);
        SmsapiConfig::configurationGeneralExtCompleted();

        smsapi_set_flash_success(__('Data has been saved', 'newsletter-sms-smsapi'));
    } else {
        smsapi_set_flash_error(__('Correct errors on the form and try again', 'newsletter-sms-smsapi'));
        $errors = $form->getErrors();
    }
    action_smsapi_settings_general_ext_form();
}

function action_smsapi_settings_subscription()
{
    if (smsapi_is_post_request()) {
        $form = new SmsapiSettingsSubscriptionForm($_POST);

        if ($form->isValid()) {
            update_option('smsapi_subscription', $form->getData());
            smsapi_set_flash_success(__('Data has been saved', 'newsletter-sms-smsapi'));
        } else {
            smsapi_set_flash_error(__('Correct errors on the form and try again', 'newsletter-sms-smsapi'));
            $errors = $form->getErrors();
        }
    }

    $clientConfig = get_option('smsapi_client', array());
    $subscriptionConfig = get_option('smsapi_subscription', array());

    $config = array_merge($clientConfig, $subscriptionConfig);

    include_once SMSAPI_PLUGIN_PATH . "/views/admin/settings/subscription.php";
}

function action_smsapi_settings_notifications()
{
    if (smsapi_is_post_request()) {
        $form = new SmsapiSettingsNotificationsForm($_POST);

        if ($form->isValid()) {
            update_option('smsapi_notifications', $form->getData());
            smsapi_set_flash_success(__('Data has been saved', 'newsletter-sms-smsapi'));
        } else {
            smsapi_set_flash_error(__('Correct errors on the form and try again', 'newsletter-sms-smsapi'));
            $errors = $form->getErrors();
        }
    }

    $clientConfig = get_option('smsapi_client', array());
    $notificationsConfig = get_option('smsapi_notifications', array());

    $config = array_merge($clientConfig, $notificationsConfig);

    include_once SMSAPI_PLUGIN_PATH . "/views/admin/settings/notifications.php";
}

function action_smsapi_logout()
{
    delete_option('smsapi_client');
    delete_option('smsapi_notifications');
    delete_option('smsapi_subscription');

    wp_redirect(admin_url() . 'admin.php?page=smsapi-settings');
}