<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class CouriersModel extends ActiveRecord
{
    public static function tableName(){
        return 'couriers';
    }
}