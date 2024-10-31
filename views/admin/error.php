<div style="margin-top: 20px;">
    <?php include(dirname(__FILE__) . '/flash_info.php'); ?>
</div>

<div>
    <?php _e("Error", 'newsletter-sms-smsapi'); ?>:
    <?php echo esc_attr($error->getMessage()); ?>
</div>
