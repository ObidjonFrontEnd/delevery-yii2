<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string|null $phone_number
 * @property string|null $password
 * @property string|null $role
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $image
 *
 * @property Address[] $addresses
 * @property Chat[] $chats
 * @property Order[] $orders
 * @property Restaurant[] $restaurants
 * @property Wishlist[] $wishlists
 */
class User extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'phone_number', 'password', 'role', 'status'], 'default', 'value' => null],
            [['image'], 'default', 'value' => 'default.jpg'],
            [['created_at', 'updated_at'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 150],
            [['phone_number', 'role', 'status'], 'string', 'max' => 20],
            [['password', 'image'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'password' => Yii::t('app', 'Password'),
            'role' => Yii::t('app', 'Role'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'image' => Yii::t('app', 'Image'),
        ];
    }

    /**
     * Gets query for [[Addresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Chats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Restaurants]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurants()
    {
        return $this->hasMany(Restaurant::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Wishlists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWishlists()
    {
        return $this->hasMany(Wishlist::class, ['user_id' => 'id']);
    }

}
