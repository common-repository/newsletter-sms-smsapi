<?php

require_once SMSAPI_PLUGIN_PATH . '/forms.php';
require_once SMSAPI_PLUGIN_PATH . '/classes/SmsapiResponse.php';


function smsapiSendSubscriptionWelcomeMessage($phonenumber)
{
    $notificationsSettings = get_option('smsapi_notifications', []);

    $welcomeNotificationEnabled = smsapi_array_safe_get($notificationsSettings, 'subscription_notification');

    if ($welcomeNotificationEnabled) {
        $smsapiClient = new SMSApiClientProxy();

        $notificationContent = smsapi_array_safe_get($notificationsSettings, 'subscription_notification_content');

        if ($notificationContent) {
            $smsapiClient->sendSingleSms($phonenumber, $notificationContent);
        }
    }
}

function smsapiSaveSubscriber(array $data)
{
    $smsapiClient = new SMSApiClientProxy();
    $subscriberPhoneNumber = smsapi_array_safe_get($data, 'phonenumber');

    $smsapiClient->saveSubscriber($data);

    smsapiSendSubscriptionWelcomeMessage($subscriberPhoneNumber);
}

function smsapiRegisterSubscriber($formData)
{
    $form = new SubscriptionForm($formData);

    if ($form->isValid()) {
        try {
            $subscriber = $form->getData();
            $subscriptionSettings = get_option('smsapi_subscription');

            if (smsapi_array_safe_get($subscriptionSettings, 'subscription_security')) {
                smsapiContinueRegistrationWithSecureCtx($subscriber);
            } else {
                smsapiSaveSubscriber($subscriber);
                $response = array('message' => __('Subscription successful', 'newsletter-sms-smsapi'));
            }
        } catch (\SMSApi\Exception\SmsapiException $error) {
            $response = smsapiFormResponse($error->getMessage());;
        } catch (\Smsapi\Client\Infrastructure\ResponseMapper\ApiErrorException $error) {
            $response = smsapiFormResponse($error->getMessage());
        }
    } else {
        $response = array('errors' => $form->getErrors());
    }

    echo json_encode($response);
}

function smsapiContinueRegistrationWithSecureCtx(array $subscriber)
{
    $smsapiClient = new SMSApiClientProxy();

    $subscriberPhoneNumber = smsapi_array_safe_get($subscriber, 'phonenumber');

    smsapi_session_set('subscriber_to_save', $subscriber);
    smsapi_session_set('secure_action', 'secure_subscribe');

    $securityCode = smsapi_security_session_token(true);
    $message = sprintf("%s: %s", __("Your activation code is", 'newsletter-sms-smsapi'), $securityCode);

    $send = $smsapiClient->sendSingleSms($subscriberPhoneNumber, $message);

    if ($send) {
        $response = [
            'security_state' => true,
            'message' => __('Activation code was sent to your phone number.', 'newsletter-sms-smsapi')
        ];
    } else {
        $response = ['message' => __('Something went wrong. Please try again later.', 'newsletter-sms-smsapi')];
    }

    echo json_encode($response);
    exit;
}

function smsapiSecureRegisterSubscriber()
{
    $securityToken = smsapi_security_session_token();

    $form = new SecurityCodeForm($_POST, $securityToken);

    if ($form->isValid()) {
        $subscriber = session_get_once('subscriber_to_save');

        if (!$subscriber) {
            $response = array(
                'reset_form' => true,
                'message' => __('Something went wrong. Please try again later.', 'newsletter-sms-smsapi')
            );
        } else {
            try {
                smsapiSaveSubscriber($subscriber);

                $response = array(
                    'reset_form' => true,
                    'message' => __('Subscription successful', 'newsletter-sms-smsapi')
                );
            } catch (\SMSApi\Exception\SmsapiException $error) {
                $response = smsapiFormResponse($error->getMessage());;
            } catch (\Smsapi\Client\Infrastructure\ResponseMapper\ApiErrorException $error) {
                $response = smsapiFormResponse($error->getMessage());
            }
        }
    } else {
        $response = array('errors' => $form->getErrors());
    }

    echo json_encode($response);
}

function smsapiUnregisterSubscriber($formData)
{
    $form = new UnsubscribeForm($formData);

    if ($form->isValid()) {
        try {
            $data = $form->getData();
            $smsapiClient = new SMSApiClientProxy();

            $subscriberPhoneNumber = smsapi_array_safe_get($data, 'phonenumber');
            $subscriptionSettings = get_option('smsapi_subscription');

            if (smsapi_array_safe_get($subscriptionSettings, 'subscription_security')) {
                smsapiContinueUnregisterWithSecureCtx($subscriberPhoneNumber);
            } else {
                $subscriber = $smsapiClient->getSubscriber($subscriberPhoneNumber);

                if ($subscriber) {
                    $smsapiClient->unpinSubscriberFromDefaultGroup($subscriber->id);
                }

                $response = ['message' => __('Phone number has been removed', 'newsletter-sms-smsapi')];
            }
        } catch (\SMSApi\Exception\SmsapiException $error) {
            $response = smsapiFormResponse($error->getMessage());;
        } catch (\Smsapi\Client\Infrastructure\ResponseMapper\ApiErrorException $error) {
            $response = smsapiFormResponse($error->getMessage());
        }
    } else {
        $response = ['errors' => $form->getErrors()];
    }

    echo json_encode($response);
}

function smsapiFormResponse(string $responseMessage)
{
    $message = __('Something went wrong. Please try again later.', 'newsletter-sms-smsapi');

    if ($responseMessage == 'No correct phone numbers') {
        $message = __('The provided phone number is incorrect.', 'newsletter-sms-smsapi');
    }

    $styledMessage = '<span style="color:#900;">' . $message . '</span>';

    return ['message' => $styledMessage];
}

function smsapiContinueUnregisterWithSecureCtx($subscriberPhoneNumber)
{
    $smsapiClient = new SMSApiClientProxy();

    $securityToken = smsapi_security_session_token(true);

    smsapi_session_set('phonenumber_to_remove', $subscriberPhoneNumber);
    smsapi_session_set('secure_action', 'secure_unsubscribe');

    $message = sprintf("%s: %s", __('Your subscription cancellation code is', 'newsletter-sms-smsapi'), $securityToken);

    $send = $smsapiClient->sendSingleSms($subscriberPhoneNumber, $message);

    if ($send) {
        $response = array(
            'security_state' => true,
            'message' => __('Subscription cancellation code was sent to your phone number.', 'newsletter-sms-smsapi')
        );
    } else {
        $response = array(
            'message' => __('Something went wrong. Please try again later.', 'newsletter-sms-smsapi')
        );
    }

    echo json_encode($response);

    exit;
}

function smsapiSecureUnregisterSubscriber()
{
    $securityToken = smsapi_security_session_token();
    $phonenumber = session_get_once('phonenumber_to_remove');

    $form = new SecurityCodeForm($_POST, $securityToken);

    if ($form->isValid()) {
        try {
            $smsapiClient = new SMSApiClientProxy();

            $subscriber = $smsapiClient->getSubscriber($phonenumber);

            if (!$subscriber) {
                $response = array(
                    'reset_form' => true,
                    'message' => __('Something went wrong. Please try again later.', 'newsletter-sms-smsapi')
                );
            } else {
                $smsapiClient->unpinSubscriberFromDefaultGroup($subscriber->id);

                $response = array(
                    'reset_form' => true,
                    'message' => __('Phone number has been removed', 'newsletter-sms-smsapi')
                );
            }
        } catch (\SMSApi\Exception\SmsapiException $error) {
            $response = smsapiFormResponse($error->getMessage());;
        } catch (\Smsapi\Client\Infrastructure\ResponseMapper\ApiErrorException $error) {
            $response = smsapiFormResponse($error->getMessage());
        }
    } else {
        $response = array('errors' => $form->getErrors());
    }

    echo json_encode($response);
}