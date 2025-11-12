<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class OrdersModel extends ActiveRecord
{
    public static function tableName(){
        return 'orders';
    }
}