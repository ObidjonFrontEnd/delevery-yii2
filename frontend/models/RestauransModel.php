<?php

namespace frontend\models;


use yii\db\ActiveRecord;

class RestauransModel extends ActiveRecord
{
    public static function tableName(){
        return 'restaurants';
    }

    public function rules(){
        return [
            [['title', 'user_id', 'phone_number' , 'description' , 'address_id' ], 'required'],
            [['title'], 'string', 'max' => 255 , 'min' => 5  ],
            [['description'], 'string'],
            [['address_id'], 'integer'],
            ['phone_number', 'match', 'pattern' => '/^(?:\+998|998|8)?(9[0-9]{8})$/', 'message' => "Iltimos, telefon raqamingizni to‘g‘ri kiriting, masalan: +998 9* *** ** **"],
            [['image'], 'default', 'value' => 'default.jpg'],
        ];
    }

    public function getCategories(){
        return $this->hasMany(CategoriesModel::class , ['id' => 'category_id'])
            ->via('products');
    }

    public  function getAddress()
    {
        return $this->hasOne(AddressesModel::class , ['id' => 'address_id']);
    }

    public function getProducts(){
        return $this->hasMany(ProductsModel::class, ['restaurant_id' => 'id']);
    }


}