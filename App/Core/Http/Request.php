<?php
namespace Core\Http;

use Core\Http\Session;
use App\Models\UserModel;

class Request
{
    public $POST;
    public $GET;

    /**
     * Метод пришедшего запроса
     * 
     * @var string
     */
    public $method;

    /**
     * Массив с загруженными пользователем файлами 
     * 
     *  @var array
     */
    public $FILES;

    /**
     * @var Session
     */
    public $session;

    /**
     * Свойство для работы с пользователем
     *
     * @var User
     */
    public $user;

    public function __construct()
    {
        $this->POST = $_POST;
        $this->GET = $_GET;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->FILES = $_FILES;
        $this->session = new Session();
        $this->user = $this->getUser();
    }

    private function getUser()
    {
        $user_model = new UserModel();
        $user = $user_model->signInUserBySession($this->session);
        return $user;
    }

}
