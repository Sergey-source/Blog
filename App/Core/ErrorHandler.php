<?php
namespace Core;

use Core\View;

/**
 * Класс для обработки http ошибок
 */
class ErrorHandler
{
    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function error404()
    {
        $this->view->render('errors/404.html');
    }

    public function error500()
    {
        $this->view->render('errors/500.html');
    }

}