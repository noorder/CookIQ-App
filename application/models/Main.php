<?php

namespace application\models;

use application\core\Model;

class Main extends Model
{
    public function contactValidate($post)
    {
        $nameLen = strlen($post['name']);
        if($nameLen < 1 or  $nameLen > 20) {
            return false;
        }
        return true;
    }
}
