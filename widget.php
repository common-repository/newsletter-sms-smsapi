<?php

class SMSApiWidget extends WP_Widget
{
    public function __construct()
    {
        $widgetOptions = ['description' => __('Allow to connect phone numbers.', 'newsletter-sms-smsapi')];
        parent::__construct('smsapi_widget', __('Newsletter SMSAPI - SMSAPI', 'newsletter-sms-smsapi'), $widgetOptions);
    }

    public function widget($args, $instance)
    {
        $config = get_option('smsapi_client', []);

        if (SmsapiConfig::isConfigurationCompleted()) {
            echo $args['before_widget'];

            if (!empty($instance['title'])) {
                echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
            }

            $description = smsapi_array_safe_get($instance, 'description');

            $options = get_option('smsapi_subscription', []);

            include SMSAPI_PLUGIN_PATH . "/views/front/widget_form.php";

            echo $args['after_widget'];
        }
    }

    public function form($instance)
    {
        $title = smsapi_array_safe_get($instance, 'title', __('Newsletter subscription', 'newsletter-sms-smsapi'));
        $description = smsapi_array_safe_get($instance, 'description', '');

        $config = get_option('smsapi_client', []);

        include SMSAPI_PLUGIN_PATH. "/views/admin/widget_form.php";
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();

        $instance['title'] = strip_tags(smsapi_array_safe_get($new_instance, 'title', ''));
        $instance['description'] = smsapi_array_safe_get($new_instance, 'description', '');

        return $instance;
    }
}