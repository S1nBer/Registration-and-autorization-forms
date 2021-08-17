<?php

namespace app\models;

use creocoder\nestedsets\NestedSetsBehavior;

/**
 * Class UserTree
 *
 * @property int $int
 * @property int $user_id
 *
 * @package app\models
 */
class UserTree extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            'tree' => [
                'class'          => NestedSetsBehavior::className(),
                'treeAttribute'  => 'tree',
                'leftAttribute'  => 'lft',
                'rightAttribute' => 'rgt',
                'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new UserTreeQuery(get_called_class());
    }
}