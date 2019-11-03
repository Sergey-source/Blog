<?php
namespace Core;

class User
{  
    /**
     * Информация о пользователе (из бд)
     * 
     * @var array
     */
    private $data;
    
    /**
     * Является ли админом
     * 
     * @var boolean
     */
    public $is_staff;

    public function __construct($data)
    {
        $this->data = $data;
        $this->is_staff = $this->data['is_staff'];
    }

    /**
     * Вытаскивает информацию о пользователе
     */
    public function get($key)
    {
        return $this->data[$key];
    }

}
