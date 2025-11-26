<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "wishlists".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $product_id
 * @property int|null $restaurant_id
 * @property int|null $quantity
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Product $product
 * @property Restaurant $restaurant
 * @property User $user
 */
class Wishlist extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wishlists';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id', 'restaurant_id'], 'default', 'value' => null],
            [['quantity'], 'default', 'value' => 1],
            [['user_id', 'product_id', 'restaurant_id', 'quantity'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['restaurant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurant::class, 'targetAttribute' => ['restaurant_id' => 'id']],
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
            'product_id' => Yii::t('app', 'Product ID'),
            'restaurant_id' => Yii::t('app', 'Restaurant ID'),
            'quantity' => Yii::t('app', 'Quantity'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Restaurant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::class, ['id' => 'restaurant_id']);
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
