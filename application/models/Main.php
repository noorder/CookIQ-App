<?php

namespace application\models;

use application\core\Model;

class Main extends Model
{
    public function getPosts()
    {
        $result = $this->db->row('SELECT title, description FROM posts');
        return $result;     
    }
}
