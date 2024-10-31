<?php
ini_set('track_errors', 1);

require_once SMSAPI_PLUGIN_PATH . '/forms.php';
require_once SMSAPI_PLUGIN_PATH . '/classes/SmsapiPagination.php';
require_once SMSAPI_PLUGIN_PATH . '/classes/SmsapiUtils.php';

function action_smsapi_subscribers_list()
{
    $smsapiClient = new SMSApiClientProxy();

    $searchText = !empty($_GET['search_text']) ? sanitize_text_field($_GET['search_text']) : null;

    $count = $smsapiClient->countContacts($searchText);

    $uri = sprintf('admin.php?page=smsapi-subscribers%s', $searchText ? '&search_text=' . $searchText : '');

    $pagination = new SmsapiPagination(array(
        'base_url' => admin_url($uri),
        'total_items' => $count
    ));

    $subscriberList = $smsapiClient->getSubscribersList($pagination->getLimit(), $pagination->getOffset(), $searchText);
    $subscribers = SmsapiUtils::extractCustomFieldsFromSubscribers($subscriberList);

    $searchText = $searchText ?? '';

    include_once SMSAPI_PLUGIN_PATH . "/views/admin/subscribers/list.php";
}

function action_smsapi_subscribers_edit($subscriberId)
{
    $smsapiClient = new SMSApiClientProxy();

    $subscriberRaw = $smsapiClient->getSubscriberById($subscriberId);
    $subscriber = SmsapiUtils::extractCustomFieldsFromSubscriber($subscriberRaw);

    if (!empty($_POST)) {
        $form = new SubscriberEditForm($_POST);

        if ($form->isValid()) {
            $data = $form->getData();
            $updatedSubscriber = $smsapiClient->updateSubscriber($subscriber->id, $data);
            $subscriber = SmsapiUtils::extractCustomFieldsFromSubscriber($updatedSubscriber);

            smsapi_set_flash_success(__('Data was saved', 'newsletter-sms-smsapi'));
        } else {
            $errors = $form->getErrors();
            smsapi_set_flash_error(__('Correct errors on the form and try again', 'newsletter-sms-smsapi'));
        }
    }

    include_once SMSAPI_PLUGIN_PATH . "/views/admin/subscribers/form.php";
}

function action_smsapi_unpin_one($subscriberId)
{
    $smsapiClient = new SMSApiClientProxy();
    $smsapiClient->unpinSubscriberFromDefaultGroup($subscriberId);

    smsapi_set_flash_success(__('Subscriber was unpinned from the group', 'newsletter-sms-smsapi'));

    wp_redirect(admin_url() . 'admin.php?page=smsapi-subscribers');
}

function action_smsapi_unpin_by_ids(array $subscribersIds)
{
    $smsapiClient = new SMSApiClientProxy();

    foreach ($subscribersIds as $subscriberId) {
        $smsapiClient->unpinSubscriberFromDefaultGroup($subscriberId);
    }

    smsapi_set_flash_success(__('Subscribers ware unpinned from the group.', 'newsletter-sms-smsapi'));

    wp_redirect(admin_url() . 'admin.php?page=smsapi-subscribers');
}

function action_smsapi_unpin_all()
{
    $smsapiClient = new SMSApiClientProxy();

    $smsapiClient->unpinAllSubscriberFromDefaultGroup();

    smsapi_set_flash_success(__('Subscribers were unpinned from the group.', 'newsletter-sms-smsapi'));

    wp_redirect(admin_url() . 'admin.php?page=smsapi-subscribers');
}

function action_smsapi_remove_one($subscriberId)
{
    $smsapiClient = new SMSApiClientProxy();

    $smsapiClient->removeSubscriberFromServer($subscriberId);

    smsapi_set_flash_success(__('Subscriber was removed', 'newsletter-sms-smsapi'));

    wp_redirect(admin_url() . 'admin.php?page=smsapi-subscribers');
}

function action_smsapi_remove_by_ids(array $subscribersIds)
{
    $smsapiClient = new SMSApiClientProxy();

    foreach ($subscribersIds as $subscriberId) {
        $smsapiClient->removeSubscriberFromServer($subscriberId);
    }

    smsapi_set_flash_success(__('Subscribers were removed', 'newsletter-sms-smsapi'));

    wp_redirect(admin_url() . 'admin.php?page=smsapi-subscribers');
}

function action_smsapi_remove_all()
{
    $smsapiClient = new SMSApiClientProxy();
    $subscribers = $smsapiClient->getSubscribersList();

    foreach ($subscribers as $subscriber) {
        $smsapiClient->removeSubscriberFromServer($subscriber->id);
    }

    smsapi_set_flash_success(__('Subscribers were removed', 'newsletter-sms-smsapi'));

    wp_redirect(admin_url() . 'admin.php?page=smsapi-subscribers');
}

function action_smsapi_sendsms(array $subscriberNumbers)
{
    smsapi_session_set('gateway_recipients', array_filter($subscriberNumbers));

    wp_redirect(admin_url() . 'admin.php?page=smsapi-send-sms');
}

function action_smsapi_export(array $subscribersIds)
{
    $smsapiClient = new SMSApiClientProxy();

    $subscribers = $smsapiClient->getSubscribersByIds($subscribersIds);

    if ($subscribers) {
        $filepath = save_smsapi_subscribers_to_file($subscribers);

        smsapi_send_file($filepath, $filepath, array(
            'delete' => true
        ));
    }
}

function action_smsapi_export_all()
{
    $smsapiClient = new SMSApiClientProxy();
    $subscribers = $smsapiClient->getSubscribersList();
    if ($subscribers) {
        $filepath = save_smsapi_subscribers_to_file($subscribers);

        smsapi_send_file($filepath, $filepath, ['delete' => true]);
    }
}

function save_smsapi_subscribers_to_file($subscribers)
{
    $filename = 'subscribers' . substr(sha1(uniqid()), 0, 6);
    $filepath = SMSAPI_TMP_PATH . '/' . $filename . '.csv';

    if (!file_exists(SMSAPI_TMP_PATH)) {
        mkdir(SMSAPI_TMP_PATH);
    }

    if (!$fp = fopen($filepath, 'w')) {
        print 'Fatal error: ' . $php_errormsg;
        die();
    }

    //@todo nazwy?
    $headersRow = array('Numer', 'Imię', 'Nazwisko', 'Data urodzenia', 'Miasto', 'Email');

    fputcsv($fp, $headersRow);

    foreach ($subscribers as $subscriber) {
        $subscriber = SmsapiUtils::extractCustomFieldsFromSubscriber($subscriber);
        fputcsv($fp, array(
            $subscriber->phoneNumber,
            $subscriber->firstName,
            $subscriber->lastName,
            $subscriber->birthdayDate,
            $subscriber->city,
            $subscriber->email,
        ));
    }

    fclose($fp);

    return $filepath;
}