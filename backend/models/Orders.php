<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $restaurant_id
 * @property int|null $courier_id
 * @property float|null $total
 * @property string|null $check_number
 * @property string|null $status
 * @property string|null $payment_status
 * @property int|null $address_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Address $address
 * @property Courier $courier
 * @property OrderDetail[] $orderDetails
 * @property Restaurant $restaurant
 * @property User $user
 */
class Orders extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'restaurant_id', 'courier_id', 'total', 'check_number', 'status', 'payment_status', 'address_id'], 'default', 'value' => null],
            [['user_id', 'restaurant_id', 'courier_id', 'address_id'], 'integer'],
            [['total'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['check_number'], 'string', 'max' => 50],
            [['status', 'payment_status'], 'string', 'max' => 20],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['restaurant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurant::class, 'targetAttribute' => ['restaurant_id' => 'id']],
            [['courier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Courier::class, 'targetAttribute' => ['courier_id' => 'id']],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::class, 'targetAttribute' => ['address_id' => 'id']],
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
            'restaurant_id' => Yii::t('app', 'Restaurant ID'),
            'courier_id' => Yii::t('app', 'Courier ID'),
            'total' => Yii::t('app', 'Total'),
            'check_number' => Yii::t('app', 'Check Number'),
            'status' => Yii::t('app', 'Status'),
            'payment_status' => Yii::t('app', 'Payment Status'),
            'address_id' => Yii::t('app', 'Address ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
     * Gets query for [[Courier]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourier()
    {
        return $this->hasOne(Courier::class, ['id' => 'courier_id']);
    }

    /**
     * Gets query for [[OrderDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetail::class, ['order_id' => 'id']);
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
