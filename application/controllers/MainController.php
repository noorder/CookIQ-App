<?php


namespace application\controllers;

use application\core\Controller;

class MainController extends Controller
{

    public function indexAction()
    {
        $this->view->render('Главная страница');
    }

    public function aboutAction()
    {
        $this->view->render('Обо мне');
    }

    public function contactAction()
    {
        $this->view->render('Контакты');
    }

    public function postAction()
    {
        $this->view->render('Пост');
    }
}
