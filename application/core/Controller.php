<?php

namespace application\core;

abstract class Controller {

    public $route;

    public function __construct($indoor_route) { //если передаем переменную в контроллер она автоматом попадает в конструктор
        $this->route=$indoor_route;
    }


}

?>