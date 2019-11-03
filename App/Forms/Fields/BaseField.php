<?php
namespace App\Forms\Fields;

abstract class BaseField
{
    public $attrs;
    public $error = '';

    public function __construct($attrs)
    {
        $this->attrs = $attrs;
    }

    public function addAttr($key, $value)
    {
        $this->attrs[$key] = $value;
    }

    public function addError(string $error)
    {
        $this->error = $error;
        return false;
    }

    /**
     * Генерирует атрибуты для поля
     * 
     * @return string
     */
    public function genAttrs()
    {
        $attrs = [];
        foreach ($this->attrs as $attr => $attr_value) {
            $attrs[] = $attr . '=' . $attr_value;
        }
        $attrs = implode(' ', $attrs);

        return $attrs;
    }

    abstract public function view();

    abstract public function setValue($value);

}
