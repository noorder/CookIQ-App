<?php


namespace application\controllers;

use application\core\Controller;

class AdminController extends Controller
{

    public function __construct($route)
    {
        parent::__construct($route);
        $this->view->layout = 'admin'; 
    }

    public function loginAction()
    {
        $this->view->render('Вход');
    }

    public function addAction()
    {
        $this->view->render('Добавить пост');
    }

    public function deleteAction()
    {
        $this->view->render('Удаление поста');
    }

      public function editAction()
    {
        $this->view->render('Редактирование поста');
    }

    public function logoutAction()
    {
        $this->view->render('Выход');
    }

    

}
