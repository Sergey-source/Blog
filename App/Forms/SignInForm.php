<?php
namespace App\Forms;

use App\Forms\BaseForm;
use App\Forms\Fields\InputField;

class SignInForm extends BaseForm
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
    }

}
