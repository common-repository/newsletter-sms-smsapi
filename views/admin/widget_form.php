
<?php if (!SmsapiConfig::isConfigurationCompleted()): ?>
<p class="description-warning">
    <?php _e('The widget will not be visible until plugin is configured.', 'newsletter-sms-smsapi'); ?>
</p>
<?php endif; ?>

<p>
	<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title', 'newsletter-sms-smsapi'); ?></label>

    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
           name="<?php echo esc_attr($this->get_field_name('title')); ?>"  value="<?php echo esc_attr($title); ?>">
</p>

<p>
    <label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php _e('Description', 'newsletter-sms-smsapi'); ?></label>

    <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('description')); ?>"
              name="<?php echo esc_attr($this->get_field_name('description')); ?>"><?php echo esc_attr($description); ?></textarea>
</p>