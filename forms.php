<?php

abstract class Field
{
    protected $message;

    public function getMessage()
    {
        return __($this->message, 'newsletter-sms-smsapi');
    }
}

class FieldRequired extends Field
{
    protected $message = "Field is required";

    public function check($value)
    {
        return !empty(trim($value));
    }
}

class FieldOptional extends Field
{
    protected $message = "";

    public function check($value)
    {
        return true;
    }
}


class FieldPhoneNumber extends Field
{
    protected $message = "Field must contain valid phone number";

    public function check($value)
    {
        if (empty($value)) {
            return true;
        }

        return (bool) preg_match('/^[\d\s\-\+]+$/i', $value);
    }
}

class FieldDate extends Field
{
    protected $message = "Field must be a date";

    public function check($value)
    {
        if (empty($value)) {
            return true;
        }

        return (strtotime($value) !== FALSE);
    }
}

class FieldString extends Field
{
    protected $message = 'Field should contain only letters';

    public function check($value)
    {
        if (empty($value)) {
            return true;
        }

        return (bool)preg_match('/^[\pL\s\.]+$/iu', $value);
    }
}

class FieldRegex extends Field
{
    protected $message = 'Field contains invalid characters';

    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    public function check($value)
    {
        if (empty($value)) {
            return true;
        }

        return preg_match($this->pattern, $value);
    }
}

class FieldEmail extends Field
{
    protected $message = "Field must be a valid email address";

    public function check($value)
    {
        if (empty($value)) {
            return true;
        }

        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}

class FilterPhoneNumber
{
    public function filter($value)
    {
        if (empty($value)) {
            return true;
        }

        return preg_replace('/[\s-]+/', '', $value);
    }
}

class PhoneNumberNotExists extends Field
{
    protected $message = "Phone number already exists";

    public function check($value)
    {
        $smsapiClient = new SMSApiClientProxy();

        return empty($smsapiClient->getSubscriber($value));
    }
}

class PhoneNumberExists extends Field
{
    protected $message = "Phone number does not exist";

    public function check($value)
    {
        $smsapiClient = new SMSApiClientProxy();

        return !empty($smsapiClient->getSubscriber($value));
    }
}

class FieldSecurityCode extends Field
{
    protected $message = "Security code is invalid";

    private $securityCode;

    public function __construct($securityCode)
    {
        $this->securityCode = $securityCode;
    }

    public function check($value)
    {
        return (mb_strtoupper($value) == mb_strtoupper($this->securityCode));
    }
}

class FieldOneOf extends Field
{
    protected $message = 'Invalid value';

    private $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function check($value)
    {
        foreach ($this->options as $option) {
            if ($option == $value) {
                return true;
            }
        }

        return false;
    }
}

class FilterTrim
{
    public function filter($value)
    {
        return trim($value);
    }
}

abstract class Form
{
    protected $originalData;

    protected $postProcessData = array();

    protected $errors = array();

    protected $fieldsDefinitions = array();

    protected $expectedData = array();

    protected $globalFilters = array();

    public function __construct(array $formData)
    {
        $this->originalData = $formData;

        $this->globalFilters = array(
            new FilterTrim()
        );
    }

    public function isValid()
    {
        foreach ($this->originalData as $key => $value) {
            $fieldDefinition = smsapi_array_safe_get($this->fieldsDefinitions, $key);

            if ($fieldDefinition) {
                $this->validField($fieldDefinition, $key, $value);
                $this->filterField($fieldDefinition, $key, $value);
            }
        }

        return empty($this->errors);
    }

    public function validField($fieldDefinition, $fieldName, $value)
    {
        $validators = smsapi_array_safe_get($fieldDefinition, 'validators', array());

        foreach ($validators as $rule) {
            if (!$rule->check($value)) {
                $this->errors[$fieldName] = $rule->getMessage($fieldName);
                break;
            }
        }
    }

    public function filterField($fieldDefinition, $fieldName, $value)
    {
        $fieldFilters = smsapi_array_safe_get($fieldDefinition, 'filters', array());

        $filters = array_merge($fieldFilters, $this->globalFilters);

        foreach ($filters as $filter) {
            $value = $filter->filter($value);
        }

        $this->postProcessData[$fieldName] = $value;
    }

    public function getData()
    {
        return $this->postProcessData;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

class SubscriptionForm extends Form
{
    public function __construct(array $formData)
    {
        parent::__construct($formData);

        $options = get_option('smsapi_subscription');
        $this->fieldsDefinitions = array(
            'phonenumber' => array(
                'validators' => array(new FieldRequired(), new FieldPhoneNumber(), new PhoneNumberNotExists()),
                'filters' => array(new FilterPhoneNumber())
            ),
            'firstname' => array(
                'validators' => array(new FieldRegex('/^[-\pL\pN\s]++$/uD'), (bool)smsapi_array_safe_get($options, 'save_contact_firstname_required') ? new FieldRequired() : new FieldOptional())
            ),
            'lastname' => array(
                'validators' => array(new FieldRegex('/^[-\pL\pN\s]++$/uD'), (bool)smsapi_array_safe_get($options, 'save_contact_lastname_required') ? new FieldRequired() : new FieldOptional())
            ),
            'city' => array(
                'validators' => array(new FieldString(), (bool)smsapi_array_safe_get($options, 'save_contact_city_required') ? new FieldRequired() : new FieldOptional())
            ),
            'birthdate' => array(
                'validators' => array(new FieldDate(), (bool)smsapi_array_safe_get($options, 'save_contact_birthdate_required') ? new FieldRequired() : new FieldOptional())
            ),
            'email' => array(
                'validators' => array(new FieldEmail(), (bool)smsapi_array_safe_get($options, 'save_contact_email_required') ? new FieldRequired() : new FieldOptional())
            ),
        );
    }
}

class SubscriberEditForm extends SubscriptionForm
{
    public function __construct(array $formData)
    {
        parent::__construct($formData);

        $this->fieldsDefinitions['phonenumber']['validators'] = array(
            new FieldRequired(), new FieldPhoneNumber()
        );
    }
}

class UnsubscribeForm extends Form
{
    public function __construct(array $formData)
    {
        parent::__construct($formData);

        $this->fieldsDefinitions = array(
            'phonenumber' => array(
                'validators' => array(new FieldRequired(), new FieldPhoneNumber(), new PhoneNumberExists()),
                'filters' => array(new FilterPhoneNumber())
            )
        );
    }
}

class SecurityCodeForm extends Form
{
    public function __construct(array $formData, $activationCode)
    {
        parent::__construct($formData);

        $this->fieldsDefinitions['security_code']['validators'] = array(
            new FieldRequired(), new FieldSecurityCode($activationCode)
        );
    }
}

class GatewayForm extends Form
{
    private $sendernames;

    public function __construct(array $formData, array $sendernames)
    {
        parent::__construct($formData);

        $this->fieldsDefinitions = array(
            'sendername' => array(
                'validators' => array(new FieldOneOf($sendernames))
            ),
            'message' => array(
                'validators' => array(new FieldRequired())
            ),
            'recipients' => array(
                'validators' => array(new FieldOptional())
            ),
            'normalize' => array(
                'validators' => array(new FieldOptional())
            )
        );

        $this->sendernames = $sendernames;
    }
}

class SmsapiSettingsLoginForm extends Form
{
    public function __construct(array $formData)
    {
        parent::__construct($formData);

        $this->fieldsDefinitions = [
            'api_token' => [
                'validators' => [new FieldRequired()],
            ]
        ];
    }
}

class SmsapiSettingsGeneralForm extends Form
{
    public function __construct(array $formData)
    {
        parent::__construct($formData);

        $this->fieldsDefinitions = [
            'api_sendername' => [
                'validators' => [new FieldOptional()],
            ],
            'new_group_name' => [
                'validators' => [new FieldOptional()],
            ],
        ];

        if (!smsapi_array_safe_get($formData, 'add_new_group')) {
            $this->fieldsDefinitions['phonebook_group'] = [
                'validators' => [new FieldOptional()]
            ];
        }
    }
}

class SmsapiSettingsNotificationsForm extends Form
{
    public function __construct(array $formData)
    {
        parent::__construct($formData);

        $this->fieldsDefinitions = array(
            'subscription_notification' => array(
                'validators' => array(new FieldOptional()),
            ),
            'subscription_notification_content' => array(
                'validators' => array(new FieldOptional()),
            )
        );
    }
}

class SmsapiSettingsSubscriptionForm extends Form
{
    public function __construct(array $formData)
    {
        parent::__construct($formData);

        $this->fieldsDefinitions = array(
            'subscription_security' => array(
                'validators' => array(new FieldOptional()),
            ),
            'save_contact_firstname' => array(
                'validators' => array(new FieldOptional()),
            ),
            'save_contact_lastname' => array(
                'validators' => array(new FieldOptional()),
            ),
            'save_contact_email' => array(
                'validators' => array(new FieldOptional()),
            ),
            'save_contact_city' => array(
                'validators' => array(new FieldOptional()),
            ),
            'save_contact_birthdate' => array(
                'validators' => array(new FieldOptional()),
            ),
            'subscription_security_required' => array(
                'validators' => array(new FieldOptional()),
            ),
            'save_contact_firstname_required' => array(
                'validators' => array(new FieldOptional()),
            ),
            'save_contact_lastname_required' => array(
                'validators' => array(new FieldOptional()),
            ),
            'save_contact_email_required' => array(
                'validators' => array(new FieldOptional()),
            ),
            'save_contact_city_required' => array(
                'validators' => array(new FieldOptional()),
            ),
            'save_contact_birthdate_required' => array(
                'validators' => array(new FieldOptional()),
            ),
        );
    }
}