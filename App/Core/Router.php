<?php
namespace Core;

class Router {
    /**
     * Список всех url маршрутов
     * 
     * @var array
     */
    static private $routes = [];
      
    static public function add($route, $controllerName, $actionName) {
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
        $route = '#^'.$route.'$#';
        
        $params = [
            'controller' => $controllerName,
            'action' => $actionName
        ];
        
        self::$routes[$route] = $params;
    }
   
    /**
     * @return array
     */
    static public function parseUrl() {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach (self::$routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {  // Если url совпадает
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        if (is_numeric($match)) {
                            $match = (int) $match;
                        }
                        $action_params[] = $match;
                    }
                }
                
                $controller_path = dirname(__DIR__) . '/Controllers' . '/' . $params['controller'] . '.php';
                require_once $controller_path;

                $result = [
                    'controller_name' => $params['controller'],
                    'action' => $params['action'],
                    'action_params' => $action_params
                ];
                return $result;
            } else {
                continue;
            }
        }
        return false;
    }
    
}
