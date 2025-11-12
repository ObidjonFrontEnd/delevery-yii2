<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class ProductsModel extends ActiveRecord
{
    public static function tableName(){
        return 'products';
    }

    public function rules(){
        return [
            [['restaurant_id', 'name', 'category_id', 'price' , 'status'], 'required'],
            [['restaurant_id', 'category_id'], 'integer'],
            [['price'], 'number'],
            [['name', 'image'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 255],
            [[ 'image'] , 'string' ],
            [['image'], 'default', 'value' => 'default.jpg'],
        ];
    }

    public function getRestaurant()
    {
        return $this->hasOne( RestauransModel::class , ['id' => 'restaurant_id'] );
    }

    public function getProductTags(){
        return $this->hasMany(ProductTagsModel::class, ['product_id' => 'id']);
    }

    public function getTags(){
        return $this->hasMany(TagsModel::class, ['id' => 'tag_id'])
            ->via('productTags');
    }

    public function getCategory(){
        return $this->hasOne(CategoriesModel::class, ['id' => 'category_id']);
    }

    public function getProdcutDetails(){
        return $this->hasOne( ProductDetailModel::class , ['product_id' => 'id'] );
    }


}