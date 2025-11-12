<?php

namespace frontend\models;

use yii\base\Model;
use yii\db\ActiveRecord;

class AdminModel extends ActiveRecord
{
    public static function tableName(){
        return 'admins';
    }
}