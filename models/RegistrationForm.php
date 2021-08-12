<?php

namespace app\models;

use yii\base\Model;

class RegistrationForm extends Model{
   public $name;
   public $email;
   public $partner_id;

   public function rules(){
      return [
         [['name', 'email', 'partner_id'], 'required'],
         ['email', 'email'],
      ];
   }
}
