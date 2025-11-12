<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class ProductTagsModel extends ActiveRecord
{
    public static function tableName(){
        return 'product_tag';
    }

    public function rules(){
        return [
            [ [ 'product_id', 'tag_id' ], 'required' ],
            [ [ 'product_id', 'tag_id' ], 'integer' ],
        ];
    }


    public function getTags(){
        return $this->hasOne(TagsModel::class, ['id' => 'tag_id']);
    }
}