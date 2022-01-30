<?php
namespace application\core;

class View {

    public $path;
    public $layout;




    public function __construct($route)
    {
        $this->route=$route;
    }

}