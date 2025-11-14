<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class CategoriesModel extends ActiveRecord
{
    public static function tableName(){
        return 'categories';
    }

    public function  rules()
    {
        return [
            [ [ 'name' ], 'required' ],
            [ [ 'name' ], 'string', 'max' => 255],
            [ [ 'name' ], 'unique' ],
            [ [ 'parent_id' ], 'integer' ],
        ];
    }

    public function getProducts(){
        return $this->hasMany(ProductsModel::class, ['category_id' => 'id'])->alias('products');
    }

    public function getRestaurants(){
        return $this->hasMany(RestauransModel::class , ['id' => 'restaurant_id'])
            ->via('products');
    }

    public function getProductTag(){
        return $this->hasMany(ProductTagsModel::class, ['product_id'=>'id'])
            ->via('products');
    }

    public function getTags()
    {
        return $this->hasMany(TagsModel::class, ['id' => 'tag_id'])
            ->via('productTag');
    }

}