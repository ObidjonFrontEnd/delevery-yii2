<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "addresses".
 *
 * @property int $id
 * @property int|null $user_id
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $house
 * @property string|null $apartment
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $name
 *
 * @property Order[] $orders
 * @property Restaurant[] $restaurants
 * @property User $user
 */
class Address extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'latitude', 'longitude', 'house', 'apartment', 'status', 'name'], 'default', 'value' => null],
            [['user_id'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['house', 'apartment'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'house' => Yii::t('app', 'House'),
            'apartment' => Yii::t('app', 'Apartment'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['address_id' => 'id']);
    }

    /**
     * Gets query for [[Restaurants]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurants()
    {
        return $this->hasMany(Restaurant::class, ['address_id' => 'id']);
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

}
