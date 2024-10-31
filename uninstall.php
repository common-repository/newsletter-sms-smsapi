<?php

function smsapi_uninstall() {
    delete_option('smsapi_client');
    delete_option('smsapi_notifications');
    delete_option('smsapi_subscription');
}