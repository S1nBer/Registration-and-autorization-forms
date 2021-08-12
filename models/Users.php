<?php

namespace app\models;

use yii\db\ActiveRecord;

class Users extends ActiveRecord{
   public static function Users()
    {
        return '{{users}}';
    }
}