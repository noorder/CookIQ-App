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

        $form ='';
        
        $data = $db -> row('SELECT name FROM users WHERE id=2');
        debug($data);
        //$this->view->render('MAIN');
    }


}
