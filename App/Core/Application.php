<?php
namespace Core;

use Core\Router;
use Core\Http\Request;
use Core\ErrorHandler;

/**
 * Запускает приложение
 * 
 * @version 1.0
 */
class Application
{
    private $errorHandler;

    public function __construct()
    {
        $this->errorHandler = new ErrorHandler();
    }

    public function run()
    {
        if ($result = Router::parseUrl()) {
            $request = new Request();

            $controller = new $result['controller_name']($request->user);
            $action = $result['action'];
            $action_params = $result['action_params'];

            if (!empty($action_params)) {
                $controller->$action($request, ...$action_params);
            } else {
                $controller->$action($request);
            }           
        } else {
            $this->errorHandler->error404();
        }
    }

}
