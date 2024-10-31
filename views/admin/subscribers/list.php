<div class="wrap">

    <?php include(dirname(__FILE__) . '/../flash_info.php'); ?>

    <h2>
        <?php _e('SMSAPI subscribers', 'newsletter-sms-smsapi'); ?>
    </h2>

    <?php if (!empty($subscribers)): ?>
    <form method="get" >
        <p class="search-box">
            <label for="post-search-input" class="screen-reader-text"><?php _e('Search subscribers', 'newsletter-sms-smsapi'); ?></label>
            <input type="hidden" name="page" value="smsapi-subscribers" />
            <input type="search" name="search_text" value="<?php echo esc_html($searchText) ?>" id="smsapi-post-search-input">
            <input type="submit" value="<?php _e('Search', 'newsletter-sms-smsapi'); ?>" class="button" id="search-submit">
        </p>
    </form>

    <form action="?page=smsapi-subscribers&noheader=true" method="post" id="smsapi-subscribers-list-form">
        <table class="widefat fixed" cellspacing="0">
            <thead>
                <tr>
                    <th class="manage-column column-cb check-column"><input type="checkbox" name="check_all" value=""/></th>
                    <th scope="col" class="manage-column column-name" width="20%"><?php _e('Phone number', 'newsletter-sms-smsapi'); ?></th>
                    <th scope="col" class="manage-column column-name" width="20%"><?php _e('First name', 'newsletter-sms-smsapi'); ?></th>
                    <th scope="col" class="manage-column column-name" width="20%"><?php _e('Last name', 'newsletter-sms-smsapi'); ?></th>
                    <th scope="col" class="manage-column column-name" width="20%"><?php _e('Email', 'newsletter-sms-smsapi'); ?></th>
                    <th scope="col" class="manage-column column-name" width="10%"><?php _e('Actions', 'newsletter-sms-smsapi'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($subscribers as $subscriber): ?>
                    <tr>
                        <th class="check-column check" scope="row">
                            <input type="checkbox" name="subscribers_ids[]" value="<?php echo esc_attr($subscriber->id); ?>" class="check-single" />
                            <input type="checkbox" name="subscribers_numbers[]" value="<?php echo esc_attr($subscriber->phoneNumber) ?? ''; ?>" style="visibility: hidden" class="check-single-number" />
                        </th>

                        <td><?php echo esc_attr($subscriber->phoneNumber ?? ''); ?></td>
                        <td><?php echo esc_attr($subscriber->firstName); ?></td>
                        <td><?php echo esc_attr($subscriber->lastName); ?></td>
                        <td><?php echo esc_attr($subscriber->email ?? ''); ?></td>

                        <td class="column-name">
                            <a href="?page=smsapi-subscribers&action=edit&id=<?php echo esc_attr($subscriber->id); ?>"><?php _e('Edit', 'newsletter-sms-smsapi'); ?></a> |
                            <a class="confirm-unpin" href="?page=smsapi-subscribers&noheader=true&action=unpin&id=<?php echo esc_attr($subscriber->id); ?>"><?php _e('Unpin', 'newsletter-sms-smsapi'); ?></a> |
                            <a class="confirm-remove" href="?page=smsapi-subscribers&noheader=true&action=delete&id=<?php echo esc_attr($subscriber->id); ?>"><?php _e('Remove', 'newsletter-sms-smsapi'); ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            <tfoot>
                <tr>
                    <th class="manage-column column-cb check-column"><input type="checkbox" name="check_all" value=""/></th>
                    <th scope="col" class="manage-column column-name" width="20%"><?php _e('Phone number', 'newsletter-sms-smsapi'); ?></th>
                    <th scope="col" class="manage-column column-name" width="20%"><?php _e('First name', 'newsletter-sms-smsapi'); ?></th>
                    <th scope="col" class="manage-column column-name" width="20%"><?php _e('Last name', 'newsletter-sms-smsapi'); ?></th>
                    <th scope="col" class="manage-column column-name" width="20%"><?php _e('Email', 'newsletter-sms-smsapi'); ?></th>
                    <th scope="col" class="manage-column column-name" width="10%"><?php _e('Actions', 'newsletter-sms-smsapi'); ?></th>
                </tr>
            </tfoot>
        </table>

        <div class="tablenav">
            <div class="alignleft actions">
                <select name="action" id="smsapi-subscribers-form-action">
                    <optgroup label="<?php _e('Actions on selected subscribers', 'newsletter-sms-smsapi'); ?>">
                        <option value="sendsms" selected><?php _e('Send SMS', 'newsletter-sms-smsapi'); ?></option>
                        <option value="export"><?php _e('Export to CSV', 'newsletter-sms-smsapi'); ?></option>
                        <option value="unpin_bulk"><?php _e('Unpin', 'newsletter-sms-smsapi'); ?></option>
                        <option value="remove"><?php _e('Remove', 'newsletter-sms-smsapi'); ?></option>
                    </optgroup>

                    <optgroup label="<?php _e('Actions on all subscribers', 'newsletter-sms-smsapi'); ?>">
                        <option value="export_all"><?php _e('Export to CSV', 'newsletter-sms-smsapi'); ?></option>
                        <option value="unpin_all"><?php _e('Unpin', 'newsletter-sms-smsapi'); ?></option>
                        <option value="remove_all"><?php _e('Remove', 'newsletter-sms-smsapi'); ?></option>
                    </optgroup>
                </select>
                <input value="<?php _e('Apply', 'newsletter-sms-smsapi'); ?>" name="doaction" id="doaction" class="button-secondary action" type="submit"/>
            </div>

            <div class="alignright">
                <?php echo esc_attr($pagination); ?>
            </div>
            <br class="clear">
        </div>
    </form>
    <?php else: ?>
        <p><?php _e('No subscribers to show', 'newsletter-sms-smsapi'); ?></p>
    <?php endif; ?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("a.confirm-remove").click(function() {
           return confirm("<?php _e('Are you sure you want to delete this subscriber from the server?', 'newsletter-sms-smsapi') ?>")
        });
        $("a.confirm-unpin").click(function() {
           return confirm("<?php _e('Are you sure you want to unpin this subscriber from the group? They will not be removed from the server.', 'newsletter-sms-smsapi') ?>")
        });
        $('input.check-single:checkbox').change(function() {
            this.nextElementSibling.checked = this.checked;
        });
    });
</script>