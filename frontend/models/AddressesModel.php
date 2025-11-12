<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class AddressesModel extends ActiveRecord
{
    public static function tableName()
    {
        return 'addresses';
    }
}