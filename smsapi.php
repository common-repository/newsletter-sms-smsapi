<?php
/**
 * Plugin Name: Newsletter SMS - SMSAPI
 * Description: Plugin which allows you to create Newsletter which will collect clients phone numbers and allow you to send SMS messages to them. Database is synchronized with SMSAPI account so messages can be sent from SMSAPI panel as well.
 * Version: 2.0.4
 * Author: SMSAPI
 * Author URI: http://smsapi.com/
 * Text Domain: newsletter-sms-smsapi
 * Domain Path: /languages
 * License: Apache2.0
 */

define('SMSAPI_PLUGIN_PATH', plugin_dir_path(__FILE__ ));
define('SMSAPI_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SMSAPI_TMP_PATH', SMSAPI_PLUGIN_PATH . 'tmp');

define('SMSAPI_OPTIONS_NOTIFICATIONS', 'smsapi_notifications');
define('SMSAPI_OPTIONS_SUBSCRIPTION', 'smsapi_subscription');

define('SMSAPI_HOSTNAME', 'https://smsapi.io/api');

require_once SMSAPI_PLUGIN_PATH . '/vendor/autoload.php';

require_once SMSAPI_PLUGIN_PATH . '/functions.php';
require_once SMSAPI_PLUGIN_PATH . '/install.php';
require_once SMSAPI_PLUGIN_PATH . '/uninstall.php';
require_once SMSAPI_PLUGIN_PATH . '/widget.php';

require_once SMSAPI_PLUGIN_PATH . '/classes/SmsapiClientProxy.php';
require_once SMSAPI_PLUGIN_PATH . '/classes/SmsapiConfig.php';

require_once SMSAPI_PLUGIN_PATH . '/subscribers.php';
require_once SMSAPI_PLUGIN_PATH . '/settings.php';
require_once SMSAPI_PLUGIN_PATH . '/gateway.php';

require_once SMSAPI_PLUGIN_PATH . '/routing.php';

require_once SMSAPI_PLUGIN_PATH . '/ajax/subscription.php';

function register_smsapi_widget()
{
    register_widget('SMSApiWidget' );
}

function init_admin()
{
    wp_enqueue_style('smsapi', plugins_url('assets/css/admin.css', __FILE__));
}

function smsapi_admin_menu()
{
    add_menu_page('SMSAPI', 'Newsletter SMS - SMSAPI', 'manage_options', 'smsapi-settings', null, plugins_url('assets/images/apl-logo-18x18.png', __FILE__));
    add_submenu_page('smsapi-settings', 'SMSAPI - settings', __('Settings', 'newsletter-sms-smsapi'), 'manage_options', 'smsapi-settings', 'smsapi_settings_routing');
    add_submenu_page('smsapi-settings', 'SMSAPI - sendsms', __('Send SMS', 'newsletter-sms-smsapi'), 'manage_options', 'smsapi-send-sms', 'smsapi_gateway_routing');
    add_submenu_page('smsapi-settings', 'SMSAPI - subscribers', __('Subscribers', 'newsletter-sms-smsapi'), 'manage_options', 'smsapi-subscribers', 'smsapi_subscribers_routing');
}

function ajax_subscription_form_callback()
{
    $action = !empty($_POST['form_action']) ? sanitize_text_field($_POST['form_action']) : null;
    if (!$action) {
        $action = smsapi_session_get('secure_action');
    }

    if ($action == 'subscribe') {
        smsapiRegisterSubscriber($_POST);
    } elseif($action == 'unsubscribe') {
        smsapiUnregisterSubscriber($_POST);
    } elseif($action == 'secure_subscribe') {
        smsapiSecureRegisterSubscriber();
    } elseif($action == 'secure_unsubscribe') {
        smsapiSecureUnregisterSubscriber();
    } else {
        wp_die('Invalid post data');
    }

    die();
}

function smsapiSessionStart()
{
    if (!session_id()) {
        session_start();
    }
}

function smsapiSessionEnd()
{
    session_destroy();
}

function enqueue_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_style('smsapi-css', plugins_url('assets/css/front.css', __FILE__));
}

register_activation_hook(__FILE__, 'smsapi_install');
register_uninstall_hook(__FILE__, 'smsapi_uninstall');

load_plugin_textdomain('smsapi', false, dirname(plugin_basename(__FILE__)) . '/languages');

add_action('wp_enqueue_scripts', 'enqueue_scripts');

add_action('init', 'smsapiSessionStart');

add_action('widgets_init', 'register_smsapi_widget');
add_action('admin_init', 'init_admin');
add_action('admin_menu', 'smsapi_admin_menu');

add_action('wp_logout', 'smsapiSessionEnd');
add_action('wp_login', 'smsapiSessionEnd');

add_action('wp_ajax_subscription_form', 'ajax_subscription_form_callback');
add_action('wp_ajax_nopriv_subscription_form', 'ajax_subscription_form_callback');

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'smsapi_plugin_action_links');

function smsapi_plugin_action_links($links)
{
    $smsapiSettingsUrl = esc_url(get_admin_url(null, 'admin.php?page=smsapi-settings'));

    $links[] = '<a href="'. $smsapiSettingsUrl .'">' . __('Settings', 'newsletter-sms-smsapi') . '</a>';

    return $links;
}