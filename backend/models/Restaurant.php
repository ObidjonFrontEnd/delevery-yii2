<?php

namespace backend\models;

use common\components\FileUploader;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "restaurants".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $phone_number
 * @property string|null $image
 * @property int|null $address_id
 * @property float|null $rate
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string $title
 * @property string|null $description
 *
 * @property Address $address
 * @property Orders[] $orders
 * @property Products[] $products
 * @property User $user
 * @property Wishlist[] $wishlists
 */
class Restaurant extends \yii\db\ActiveRecord
{

    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'restaurants';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'phone_number', 'image', 'address_id', 'status', 'description'], 'default', 'value' => null],
            [['rate'], 'default', 'value' => 0.0],
            [['user_id', 'address_id'], 'integer'],
            [['rate'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'required'],
            [['description'], 'string'],
            [['phone_number', 'status'], 'string', 'max' => 20],
            [['image', 'title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::class, 'targetAttribute' => ['address_id' => 'id']],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 1024 * 1024 * 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'image' => Yii::t('app', 'Image'),
            'address_id' => Yii::t('app', 'Address ID'),
            'rate' => Yii::t('app', 'Rate'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * Gets query for [[Address]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::class, ['id' => 'address_id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['restaurant_id' => 'id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::class, ['restaurant_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Wishlists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWishlists()
    {
        return $this->hasMany(Wishlist::class, ['restaurant_id' => 'id']);
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
