<?php

namespace application\core;

use application\core\View;

class Router
{
    protected $routes = []; //новый массив с ключами
    protected $params = []; //новый массив со значениями

    function __construct()
    {
        $arr = require 'application/config/routes.php';
        foreach ($arr as $key => $value) {
            $this->add($key, $value);
        }
    }

    public function add($route, $params)
    {
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }


    public function match()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        if (is_numeric($match)) {
                            $match = (int) $match;
                        }
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run()
    {
        if ($this->match()) { //если маршрут найден, то подключаю контроллер
            $path = 'application\controllers\\' . ucfirst($this->params['controller']) . 'Controller'; //имя контроллера подставляю из routes.php
            if (class_exists($path)) { //проверка существования класса
                $action = $this->params['action'] . 'Action';
                if (method_exists($path, $action)) { //проверка существования метода
                    $controller = new $path($this->params); //если все прошло ОК, то создаю экземпляр класса и передаю в него параметры с экшном и контроллером
                    $controller->$action(); //и передаю в контроллер экшн
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else View::errorCode(404);
    }
}
