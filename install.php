<?php

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

function smsapi_install() {
    update_option(SMSAPI_OPTIONS_SUBSCRIPTION, array(
        'subscription_security' => true
    ));
}