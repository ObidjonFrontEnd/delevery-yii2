<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class WishlistsModel extends ActiveRecord
{


    public static function tableName(){
        return 'wishlists';
    }


    public function rules(){
        return [
            [['user_id', 'product_id'], 'required'   ],
            [['user_id', 'product_id'], 'integer'  ],
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(ProductsModel::class, [ 'id' => 'product_id' ]);
    }
    public  function  getRestaurant(){
        return $this->hasOne( RestauransModel::class , [ 'id' => 'restaurant_id' ] )
            ->via('product');
    }



}