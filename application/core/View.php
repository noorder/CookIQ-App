<?php
namespace application\core;

class View {

    public $path;
    public $route;
    public $layout = 'default';




    public function __construct($indoor_route)
    {
        $this->route=$indoor_route;
        $this->path=$indoor_route['controller'].'/'.$indoor_route['action'];
        debug($this->path);
    }

}