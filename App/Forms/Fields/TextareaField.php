<?php
namespace App\Forms\Fields;

use App\Forms\Fields\BaseField;

class TextareaField extends BaseField
{
    /**
     * Значение поля(для редактирования)
     */
    private $value = '';

    public function view()
    {
        $attrs = $this->genAttrs();

        $html_field = sprintf('<textarea %s>%s</textarea>', $attrs, $this->value);
        return $html_field;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}
