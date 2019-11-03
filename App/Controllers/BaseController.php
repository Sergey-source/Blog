<?php
namespace App\Controllers;

use Core\View;
use Core\ErrorHandler;

class BaseController
{
    protected $view;
    protected $errorHandler;

    public function __construct($user)
    {
        $this->view = new View($user);
        $this->errorHandler = new ErrorHandler();
    }
}
