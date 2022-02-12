<?php

namespace application\core;

use application\core\View;

abstract class Controller
{

    public $route;
    public $view;
    public $acl;

    public function __construct($indoor_route)
    { //если передаем переменную в контроллер она автоматом попадает в конструктор
        $this->route = $indoor_route;
        if (!$this->checkAcl()) {
        View::errorCode(403);
        };
        $this->view = new View($indoor_route);
        $this->model = $this->loadModel($indoor_route['controller']);
    }

    public function loadModel($name)
    {
        $path = 'application\models\\' . ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        }
    }

    public function checkAcl()
    {
        $this->acl = require 'application/acl/' . $this->route['controller'] . '.php';
        if ($this->isAcl('all')) {
            return true;
        } elseif (isset($_SESSION['authorize']['id']) and $this->isAcl('authorize')) {
            return true;
        } elseif (!isset($_SESSION['guest']['id']) and $this->isAcl('guest')) {
            return true;
        } elseif (isset($_SESSION['admin']) and $this->isAcl('admin')) {
            return true;
        }
        return false;
    }

    public function isAcl($key)
    {
        return in_array($this->route['action'], $this->acl[$key]);
    }
}
