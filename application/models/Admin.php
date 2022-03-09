<?php

namespace application\models;

use application\core\Model;
//use Imagick;


class Admin extends Model
{

    public $error;

    public function loginValidate($post)
    {
        $config = require 'application/config/admin.php';
        if ($config['login'] != $post['login'] or $config['password'] != $post['password']) {
            $this->error = 'Неверный логин или пароль';
            return false;
        }
        return true;
    }

    public function postValidate($post, $type)
    {

        $nameLen = iconv_strlen($post['name']);
        $descriptionLen = iconv_strlen($post['description']);
        $textLen = iconv_strlen($post['text']);

        if ($nameLen < 3 or  $nameLen > 20) {
            $this->error = 'Ошибка названия(3-20)';
            return false;
        } elseif ($descriptionLen < 3 or  $descriptionLen > 20) {
            $this->error = 'Ошибка описания(3-20)';
            return false;
        } elseif ($textLen < 3 or  $textLen > 2000) {
            $this->error = 'Ошибка текста(3-2000)';
            return false;
        }
         if (empty($_FILES['img']['tmp_name']) and $type == 'add') {
               $this->error = 'Ошибка фото';
              return false;
           }
        return true;
    }

    public function postAdd($post)
    {
        $params = [
            'description' => $post['description'],
            'name' => $post['name'],
            'text' => $post['text'],
        ];
        $this->db->query('INSERT INTO posts (name, description, text) VALUES (:name, :description, :text)', $params);
        return $this->db->lastInsertId();
    }

    public function postUploadImage($path, $id)
    {
        // $img = new Imagick($path);
        // $img->cropThumbnailImage(1024, 1024);
        // $img->setImageCompressionQuality(80);
        // $img->writeImage('public/materials/'.$id.'.jpg');
        move_uploaded_file($path, 'public/materials/'.$id.'.jpg');
    }


    //проверка существования поста перед его удалением или редактированием
    public function isPostExists($id){
        $params = [
            'id' => $id,
        ];
        return $this->db->column('SELECT id FROM posts WHERE id = :id', $params);
    }

    //удаление поста
    public function postDelete($id) {
        $params = [
            'id' => $id,
        ];
        $this->db->query('DELETE FROM posts WHERE id=:id', $params);
        unlink('public/materials/'.$id.'.jpg');
    }
}
