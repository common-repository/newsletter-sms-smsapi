<?php include(dirname(__FILE__) . '/../flash_info.php'); ?>
<?php $tab = !empty($_GET['tab']) ? sanitize_text_field($_GET['tab']) : ''; ?>

<h2 class="nav-tab-wrapper">
    <a href="?page=smsapi-settings" class="nav-tab<?php if ($tab == '') { echo " nav-tab-active";} ?>">
        <?php _e('General', 'newsletter-sms-smsapi'); ?>
    </a>

    <?php if (SmsapiConfig::isCofigurationGeneralExtCompleted()): ?>
    <a href="?page=smsapi-settings&tab=subscription" class="nav-tab<?php if ($tab == 'subscription') { echo " nav-tab-active";} ?>">
        <?php _e('Subscription', 'newsletter-sms-smsapi'); ?>
    </a>

	<a href="?page=smsapi-settings&tab=notifications" class="nav-tab<?php if ($tab == 'notifications') { echo " nav-tab-active";} ?>">
        <?php _e('Notifications', 'newsletter-sms-smsapi'); ?>
    </a>
    <?php endif; ?>
</h2>