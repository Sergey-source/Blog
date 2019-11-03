<?php
namespace App\Forms\Fields;

use App\Forms\Fields\BaseField;

class InputField extends BaseField
{
    public function view()
    {
        $attrs = $this->genAttrs();

        $html_field = sprintf('<input %s>', $attrs);
        return $html_field;
    }

    public function setValue($value)
    {
        $this->addAttr('value', $value);
    }
}