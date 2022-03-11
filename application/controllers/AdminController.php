<?php


namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\lib\Pagination;
use application\models\Main;

class AdminController extends Controller
{

    public function __construct($route)
    {
        parent::__construct($route);
        $this->view->layout = 'admin';
    }

    public function loginAction()
    {
        if (isset($_SESSION['admin'])) {

            $this->view->redirect('admin/add');
        }
        if (!empty($_POST)) {
            if (!$this->model->loginValidate($_POST)) {
                $this->view->message('ERROR', $this->model->error);
            }
            $_SESSION['admin'] = true;
            $this->view->location('admin/add');
        }
        $this->view->render('Вход');
    }



    public function addAction()
    {
        if (!empty($_POST)) {
            if (!$this->model->postValidate($_POST, 'add')) {
                $this->view->message('ERROR', $this->model->error);
            }
            $id = $this->model->postAdd($_POST);
            if (!$id) {
                $this->view->message('error', 'Ощибка загрузки картинок');
            }

            $this->model->postUploadImage($_FILES['img']['tmp_name'], $id);
            $this->view->message('success', 'id: ' . $id);
        }
        $this->view->render('Добавить пост');
    }



    public function editAction()
    {
        if (!empty($_POST)) {
            if (!$this->model->postValidate($_POST, 'edit')) {
                $this->view->message('ERROR', $this->model->error);
            }
            $this->model->postEdit($_POST, $this->route['id']);
            if ($_FILES['img']['tmp_name']) {
                $this->model->postUploadImage($_FILES['img']['tmp_name'], $this->route['id']);
            }
            $this->view->message('success', 'Сохранено');
        }
        //в массив все данные о посте
        $vars = [
            'data' => $this->model->postData($this->route['id'])[0],
        ];
        $this->view->render('Редактирование поста', $vars);
    }



    public function deleteAction()
    {
        //если нет поста при удалении тогда выдаем ошибку
        if (!$this->model->isPostExists($this->route['id'])) {
            $this->view->errorCode(404);
        }
        $this->model->postDelete($this->route['id']);
        $this->view->redirect('admin/posts');
    }



    public function logoutAction()
    {
        unset($_SESSION['admin']);
        $this->view->redirect('admin/login');
    }


    //#6 26:52 разобраться в механизме наследования класса
    public function postsAction()
    {
        $mainModel = new Main; //вытаскиваю из майн модели код пагинатора
        $pagination = new Pagination($this->route, $mainModel->postsCount());
        $vars = [
            'pagination' => $pagination->get(),
            'list' => $mainModel->postsList($this->route),
        ];
        $this->view->render('Посты', $vars);
    }
}


///////////#5 08:00    
