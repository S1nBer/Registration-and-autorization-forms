<?php

namespace app\models;

use yii\base\NotSupportedException;
use yii\db\ActiveRecord;

/**
 * Class User
 *
 * @property integer $id
 * @property string  $email
 * @property string  $name
 * @property int     $partner_id
 * @property string  $date
 *
 * @package app\models
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public $authKey;

    /**
     * @param int|string $id
     *
     * @return static
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @param string $name
     *
     * @return static|null
     */
    public static function findByEmail($email, $name)
    {
        return self::findOne(['name' => $name, 'email' => $email]);
    }

    /**
     * @return User|null
     */
    public function getParentUser()
    {
        $node = UserTree::findOne(['user_id' => $this->id]);

        $ancestor = null;
        if ($parent = $node->parents(1)->one()) {
            $ancestor = self::findOne(['id' => $parent->user_id]);
        }

        return $ancestor;
    }
}
