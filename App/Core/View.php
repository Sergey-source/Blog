<?php
namespace Core;

/**
 * Класс для работы с шаблонами
 */
class View
{
    /**
     * Папка со всеми шаблонами
     * 
     * @var string
     */
    private $views_path;

    /**
     * Параметры для каждого шаблона по умолчанию
     * 
     * @var array
     */
    private $default_vars;

    public $twig;
    
    public function __construct($user = null)
    {
        $this->views_path = dirname(__DIR__) . '/Views/';

        $this->default_vars = [
            'STATIC' => '/public/static',  // Путь к директории со статическими файлами(css, js, img)
            'MEDIA' => 'public/media',  // Путь к директории с динамическими файлами(пример: аватар пользователя)
            'user' => $user
        ];
        
        $loader = new \Twig_Loader_Filesystem($this->views_path);
        $twig = new \Twig_Environment($loader);
        $this->twig = $twig;
    }

    /**
     * Рендерит html шаблон
     */
    public function render(string $view_path, array $vars = [])
    {
        $html_vars = array_merge($this->default_vars, $vars);
        echo $this->twig->render($view_path, $html_vars);
    }

}
