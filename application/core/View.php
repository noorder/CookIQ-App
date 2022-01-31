<?php

namespace application\core;

class View
{

    public $path;
    public $route;
    public $layout = 'default';




    public function __construct($indoor_route)
    {
        $this->route = $indoor_route;
        $this->path = $indoor_route['controller'] . '/' . $indoor_route['action'];
    }

    public function render($title, $vars = [])
    {
        if (file_exists('application/views/' . $this->path . '.php')) {
            ob_start();
            require 'application/views/' . $this->path . '.php';
            $content = ob_get_clean();
            require 'application/views/layouts/' . $this->layout . '.php';
        }
    }
    //вывод ошибок
    public static function errorCode($code)
    {
        http_response_code($code);
        $path = 'application/views/errors/' . $code . '.php';
        if (file_exists($path)) {
            require $path;  
        }
        exit;
    }

    //переадресация
    public function redirect($url)
    {
        header('location: ' . $url);
        exit;
    }
}
