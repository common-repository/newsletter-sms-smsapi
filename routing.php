<?php

function handle_smsapi_exception(Exception $error)
{
    $invalid_authorization_data_error_codes = array(101, 401);

    if (in_array($error->getCode(), $invalid_authorization_data_error_codes)) {
        smsapi_set_flash_error(__('Invalid authorization data. Please make sure that your token has correct rights.', 'newsletter-sms-smsapi'));

        SmsapiConfig::requireReconfiguration();

        $config = SmsapiConfig::getApiClientConfig();

        include_once SMSAPI_PLUGIN_PATH . "/views/admin/settings/general.php";
    } else {
        smsapi_set_flash_error(__('Something went wrong. Please try again later.', 'newsletter-sms-smsapi'));
        include_once SMSAPI_PLUGIN_PATH . "/views/admin/error.php";
    }
}

function handle_upgrade_error() {
    delete_option('smsapi_client');
    delete_option('smsapi_notifications');
    delete_option('smsapi_subscription');

    include_once SMSAPI_PLUGIN_PATH . "/views/admin/settings/login.php";
}

function smsapi_gateway_routing()
{
    $recipientsNumbers = session_get_once('gateway_recipients', array());

    try {
        action_smsapi_gateway($recipientsNumbers);
    } catch (\SMSApi\Exception\SmsapiException $error) {
        handle_smsapi_exception($error);
    } catch (InvalidArgumentException $ex) {
        handle_upgrade_error();
    }
}

function smsapi_settings_routing()
{
    try {
        $tab = !empty($_GET['tab']) ? sanitize_text_field($_GET['tab']) : null;

        if ($tab == 'subscription') {
            action_smsapi_settings_subscription();
        } elseif ($tab == 'notifications') {
            action_smsapi_settings_notifications();
        } elseif ($tab == 'logout') {
            action_smsapi_logout();
        } else {
            if (SmsapiConfig::isCofigurationGeneralCompleted()) {
                action_smsapi_settings_general_ext();
            } else {
                action_smsapi_settings_general();
            }

        }
    } catch (\SMSApi\Exception\SmsapiException $error) {
        handle_smsapi_exception($error);
    } catch (InvalidArgumentException $ex) {
        handle_upgrade_error();
    }
}

function smsapi_subscribers_routing()
{
    try {
        $action = !empty($_POST['action']) ? sanitize_text_field($_POST['action']) : null;
        if (!$action) {
            $action = !empty($_GET['action']) ? sanitize_text_field($_GET['action']) : null;
        }
        switch ($action) {
            case 'edit':
                $subscriberId = sanitize_text_field($_GET['id']);
                action_smsapi_subscribers_edit($subscriberId);
                break;
            case 'delete':
                $subscriberId = sanitize_text_field($_GET['id']);
                action_smsapi_remove_one($subscriberId);
                break;
            case 'remove':
                $subscribersIds = !empty($_POST['subscribers_ids']) ? array_map('sanitize_text_field', $_POST['subscribers_ids']) : [];
                action_smsapi_remove_by_ids($subscribersIds);
                break;
            case 'remove_all':
                action_smsapi_remove_all();
                break;
            case 'unpin':
                $subscriberId = sanitize_text_field($_GET['id']);
                action_smsapi_unpin_one($subscriberId);
                break;
            case 'unpin_bulk':
                $subscribersIds = !empty($_POST['subscribers_ids']) ? array_map('sanitize_text_field', $_POST['subscribers_ids']) : [];
                action_smsapi_unpin_by_ids($subscribersIds);
                break;
            case 'unpin_all':
                action_smsapi_unpin_all();
                break;
            case 'sendsms':
                $subscribersNumbers = !empty($_POST['subscribers_numbers']) ? array_map('sanitize_text_field', $_POST['subscribers_numbers']) : [];
                action_smsapi_sendsms($subscribersNumbers);
                break;
            case 'export':
                $subscribersIds = !empty($_POST['subscribers_ids']) ? array_map('sanitize_text_field', $_POST['subscribers_ids']) : [];
                action_smsapi_export($subscribersIds);
                break;
            case 'export_all':
                action_smsapi_export_all();
                break;
            default:
                action_smsapi_subscribers_list();
        }
    } catch (\SMSApi\Exception\SmsapiException $error) {
        handle_smsapi_exception($error);
    } catch (InvalidArgumentException $ex) {
        handle_upgrade_error();
        exit;
    } catch (\Smsapi\Client\Infrastructure\ResponseMapper\ApiErrorException $ex) {
        handle_smsapi_exception($ex);
    }
}
