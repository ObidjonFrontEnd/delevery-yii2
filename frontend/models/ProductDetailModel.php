<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class ProductDetailModel extends ActiveRecord
{
    public static function tableName(){
        return 'product_details';

    }

    public function rules(){
        return [
            [ [ 'description' , 'product_id' , 'weight' , 'calories' , 'preparation_time'  , 'ingredients' ], 'required'  ],
            [ [ 'product_id', 'weight' , 'calories' , 'preparation_time' ] , 'number' ],
            [ [ 'description' , 'product_id' , 'ingredients' ], 'trim' ],
            [ [ 'description' , 'product_id' , 'ingredients' ], 'string' ],
        ];
    }
}