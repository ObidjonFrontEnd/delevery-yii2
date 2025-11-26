<?php

namespace frontend\models;


use common\components\FileUploader;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class RestauransModel extends ActiveRecord
{

    public $imageFile ;
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
            ],
        ];
    }

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
            [['image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 1024 * 1024 * 10],
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


    public function uploadImage()
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');

        if ($this->imageFile) {
            // Eski rasmni o'chirish
            if ($this->image) {
                FileUploader::delete($this->image, '');
            }

            // Yangi rasmni yuklash
            $fileName = FileUploader::upload($this->imageFile, '');

            if ($fileName) {
                $this->image = $fileName;
                return true;
            }
        }

        return false;
    }

    public function getImageUrl()
    {
        return FileUploader::getUrl($this->image, '');
    }


}