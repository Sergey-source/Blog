<?php
namespace App\Forms;

/**
 * Класс для работы с html формами
 */
class BaseForm
{
    protected $fields;
    protected $errors = false;
    
    /**
     * Хранит данные заполненной пользователем формы
     * 
     * @var array
     */
    public $data;
    
    /**
     * Очищенные данные, готовые к внесению в бд
     * 
     * @var array
     */
    public $cleaned_data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Устанавливает значения для полей(для редактирования)
     */
    public function setValues(array $fields_values)
    {
        foreach($fields_values as $field_name => $value) {
            $this->fields[$field_name]->setValue($value);
        }
    }

    /**
     * Валидирует все поля формы
     */
    public function isValid()
    {
        foreach ($this->data as $key => $value) {
            $method = 'clean_' . $key;
            
            if (method_exists($this, $method)) {
                if ($data = $this->$method($value)) {
                    $this->cleaned_data[$key] = $data;
                } else {
                    $this->errors = true;
                    break;
                }
            } else {
                $this->cleaned_data[$key] = $value;
            }
        }
        
        return (!$this->errors) ? true : false;
    }
   
}
