<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class ChatsModel extends ActiveRecord
{
    public static function tableName(){
        return 'chats';
    }
}