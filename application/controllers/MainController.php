<?php


namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\lib\Db;

class MainController extends Controller
{

    public function indexAction()
    {
        $db = new Db;

        $params = [
            'id' => 2,
        ];
        
        $data = $db -> column('SELECT name FROM users WHERE id= :id', $params);
        debug($data);
        //$this->view->render('MAIN');
    }


}
