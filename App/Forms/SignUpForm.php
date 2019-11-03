<?php
namespace App\Forms;

use App\Forms\BaseForm;
use App\Forms\Fields\InputField;

class SignUpForm extends BaseForm
{
    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->fields['email'] = new InputField([
            'type' => 'email',
            'name' => 'email',
            'placeholder' => 'email',
            'class' => 'form_field'
        ]);

        $this->fields['password'] = new InputField([
            'type' => 'password',
            'name' => 'password',
            'placeholder' => 'password',
            'class' => 'form_field'
        ]);

        $this->fields['first_name'] = new InputField([
            'type' => 'text',
            'name' => 'first_name',
            'placeholder' => 'first_name',
            'class' => 'form_field'
        ]);

        $this->fields['last_name'] = new InputField([
            'type' => 'text',
            'name' => 'last_name',
            'placeholder' => 'last_name',
            'class' => 'form_field'
        ]);
    }

    public function clean_password($password)
    {
        if (strlen($password) < 6) {
            return $this->fields['password']->addError('Пароль должен содержать минимум 6 символов');
        }

        return $password;
    }

}
