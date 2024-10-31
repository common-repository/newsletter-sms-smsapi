<div id="smsapi-widget">
    <p id="smsapi-widget-request-result"></p>
    <p id="smsapi-widget-description">
        <?php echo esc_attr($description); ?>
    </p>

    <?php include(dirname(__FILE__) . '/_subscribe_form.php'); ?>
    <?php include(dirname(__FILE__) . '/_unsubscribe_form.php'); ?>
    <?php include(dirname(__FILE__) . '/_security_token_form.php'); ?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {

        var $subscriptionForm = $("#smsapi-subscribe-form"),
            $unsubscribeForm = $("#smsapi-unsubscribe-form"),
            $activationForm = $("#smsapi-subscription-activation-form"),
            $loadingElem = $(".smsapi-form-loading"),
            $submitButton = $(".smsapi-submit"),
            $resultElem = $("#smsapi-widget-request-result");

        $("input[name='form_action']").click(function(event) {
            event.preventDefault();

            if ($(this).val() == 'subscribe') {
                $subscriptionForm.show();
                $unsubscribeForm.hide();
            } else {
                $subscriptionForm.hide();
                $unsubscribeForm.show();
            }

            return false;
        });

        $(".smsapi-form").on('submit', function(event) {
            event.preventDefault();
            $submitButton.prop("disabled", true);

            var $inputs = $("input[type=text]", $(this)),
                formActionURL = '<?php echo admin_url('admin-ajax.php'); ?>';

            $loadingElem.show();

            var formData = $(this).serialize() + "&action=subscription_form";

            $.post(formActionURL, formData, function(response) {
                if(response.errors) {
                    $inputs.each(function(idx, elem) {
                        var $elem = $(elem),
                            inpError = response.errors[$elem.attr('name')] || '';

                        $elem.next().html(inpError);
                    });
                }

                if(response.security_state) {
                    $subscriptionForm.hide();
                    $unsubscribeForm.hide();
                    $activationForm.show();
                }

                if (response.reset_form) {
                    $activationForm.hide();
                    $unsubscribeForm.hide();
                    $subscriptionForm.show();
                }

                if(response.message) {
                    $resultElem.html(response.message);

                    $inputs.each(function(idx, elem) {
                        $(elem).val('').next().html('');
                    });

                    setTimeout(function() {
                        $resultElem.html('');
                    }, 10000);
                }

                $loadingElem.hide();
                $submitButton.prop("disabled", false);
            }, 'json');

            return false;
        });
    });
</script>