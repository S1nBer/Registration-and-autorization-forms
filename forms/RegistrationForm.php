<?php

namespace app\forms;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\UserTree;

class RegistrationForm extends Model
{
    public $name;
    public $email;
    public $partnerId;

    public function rules()
    {
        return [
            [['name', 'email', 'partnerId'], 'required'],
            ['email', 'email'],
            ['email', 'validateEmail'],
            ['partnerId', 'validateParentEmail'],
        ];
    }

    public function validateEmail()
    {
        $users = User::findOne(['email' => $this->email]);
        if ($users) {
            $this->addError('email', 'Ошибка, пользователь с таким email уже зарегистрирован');
        }
    }

    public function validateParentEmail()
    {
        $partner = User::findOne(['partner_id' => $this->partnerId]);
        if (!$partner) {
            $this->addError('partnerId', 'Ошибка, пользователя с таким partner_id не существует');
        }
    }

    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $dbTransaction = Yii::$app->db->beginTransaction();

        try {
            // тут происходит вся регистрация
            $newUser             = new User();
            $newUser->name       = $this->name;
            $newUser->email      = $this->email;
            $newUser->partner_id = $this->_generatePartnerId();
            $newUser->date       = date('Y-m-d');
            $newUser->save();

            $userTree = new UserTree();
            $userTree->user_id = $newUser->id;
            $userTree->save();

            $parent = User::findOne(['partner_id' => $this->partnerId]);

            $client = new UserTree(['user_id' => $parent->id]);
            $client->appendTo($userTree);

            $dbTransaction->commit();

        } catch (\Exception $e) {
            $dbTransaction->rollBack();

            $this->addError('email', 'Ошибка сохранения данных');

            return false;
        }

        return true;
    }

    private function _generatePartnerId()
    {
        $n = rand(1000000000, 9999999999);

        while ($id = User::findOne(['partner_id' => $n])) {
            $n = rand(1000000000, 9999999999);
        }

        return $n;
    }
}
