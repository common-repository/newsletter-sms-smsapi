<p class="pagination">
	<?php if ($first_page !== FALSE): ?>
		<a href="<?php echo esc_attr($page->url($first_page)) ?>" rel="first"><?php _e('First', 'newsletter-sms-smsapi') ?></a>
	<?php else: ?>
		<?php _e('First', 'newsletter-sms-smsapi') ?>
	<?php endif ?>

	<?php if ($previous_page !== FALSE): ?>
		<a href="<?php echo esc_attr($page->url($previous_page)) ?>" rel="prev"><?php _e('Previous', 'newsletter-sms-smsapi') ?></a>
	<?php else: ?>
		<?php _e('Previous', 'newsletter-sms-smsapi') ?>
	<?php endif ?>

	<?php for ($i = 1; $i <= $total_pages; $i++): ?>
		<?php if ($i == $current_page): ?>
			<strong><?php echo esc_attr($i) ?></strong>
		<?php else: ?>
			<a href="<?php echo esc_attr($page->url($i)) ?>"><?php echo esc_attr($i) ?></a>
		<?php endif ?>
	<?php endfor ?>

	<?php if ($next_page !== FALSE): ?>
		<a href="<?php echo esc_attr($page->url($next_page)) ?>" rel="next"><?php _e('Next', 'newsletter-sms-smsapi') ?></a>
	<?php else: ?>
		<?php _e('Next', 'newsletter-sms-smsapi') ?>
	<?php endif ?>

	<?php if ($last_page !== FALSE): ?>
		<a href="<?php echo esc_attr($page->url($last_page)) ?>" rel="last"><?php _e('Last', 'newsletter-sms-smsapi') ?></a>
	<?php else: ?>
		<?php _e('Last', 'newsletter-sms-smsapi') ?>
	<?php endif ?>
</p>