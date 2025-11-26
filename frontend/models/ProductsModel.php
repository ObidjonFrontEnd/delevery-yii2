<?php

namespace frontend\models;

use common\components\FileUploader;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class ProductsModel extends ActiveRecord
{
    public $imageFile;
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
            [['image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 1024 * 1024 * 10],
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

    /**
     * Rasm URL ini olish
     */
    public function getImageUrl()
    {
        return FileUploader::getUrl($this->image, '');
    }



}