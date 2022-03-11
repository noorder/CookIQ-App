<?php

namespace application\models;

use application\core\Model;


class Main extends Model
{

    public $error;
    //вывод  ошибок пользователю

    public function contactValidate($post)
    {
        $nameLen = iconv_strlen($post['name']);
        $textLen = iconv_strlen($post['text']);
        if ($nameLen < 3 or  $nameLen > 20) {
            $this->error = 'Ошибка имени';
            return false;
        } elseif (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $this->error = 'Ошибка почты';
            return false;
        } elseif ($textLen < 3 or  $textLen > 20) {
            $this->error = 'Ошибка текста';
            return false;
        }
        return true;
    }

    public function postsCount() {
        return $this->db->column('SELECT COUNT(id) FROM posts');
    }  
    
    public function postsList($route) {
        $max = 1;
        $params = [
            'max' => $max,
            'start' =>((($route['page'] ?? 1) - 1) * $max), //считаем с какого поста стартовать

        ];
        return $this->db->row('SELECT * FROM posts ORDER BY id DESC LIMIT :start, :max', $params);
    }
}
