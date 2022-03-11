<?php


namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Admin;

class MainController extends Controller
{

    public function indexAction()
    { 
        //второй параметр передает количесто постов(по 10 на страницу)
        $pagination = new Pagination($this->route, $this->model->postsCount(), 2);
            $vars = [
                'pagination' => $pagination->get(),
                'list' => $this->model->postsList($this->route),
            ];
        $this->view->render('Главная страница', $vars);
    }

    public function aboutAction()
    {
        $this->view->render('Обо мне');
    }

    public function contactAction()
    {
        if (!empty($_POST)) {
            if (!$this->model->contactValidate($_POST)) {
                $this->view->message('ERROR', $this->model->error);
            }
            mail($_POST['email'], 'Сообщение из блока', $_POST['email'], $_POST['text']);
            $this->view->message('success - ', 'сообщение отправлено');
        }
        $this->view->render('Контакты');
    }





    public function postAction()
    {
        $adminModel = new Admin;
        if(!$adminModel->isPostExists($this->route['id'])) {
            $this->view->errorCode(404);
        }
//Dcontainer??
        $vars = [
            'data' => $adminModel->postData($this->route['id'])[0],
        ];

        $this->view->render('Пост', $vars);
    }
}

///2 - 12.01
