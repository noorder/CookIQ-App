<?php

namespace application\core;
use application\core\View;

abstract class Controller {

    public $route;
    public $view;

    public function __construct($indoor_route) { //если передаем переменную в контроллер она автоматом попадает в конструктор
        $this->route = $indoor_route;
        $this->view = new View($indoor_route);
    }


}

?>