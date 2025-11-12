<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class TagsModel extends ActiveRecord
{
    public static function tableName(){
        return 'tags';
    }

    public function rules(){
        return [
            [ [ 'name' ], 'required' ],
            [ [ 'name'], 'unique' ],
            [ [ 'name'], 'string', 'max' => 255],

        ];
    }
}