<?php

namespace app\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;

class UserTreeQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::class,
        ];
    }
}