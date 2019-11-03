<?php
namespace Core\Http;

/**
 * Класс для работы с сессиями
 */
class Session
{
    public function __construct()
    {
        $this->start();
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return ($value = $_SESSION[$key]) ? $value : null;
    }

    public function delete($key)
    {
        unset($_SESSION[$key]);
    }

    public function start()
    {
        session_start();
    }

}
