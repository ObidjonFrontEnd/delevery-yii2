<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order_details".
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $product_id
 * @property int|null $quantity
 * @property float|null $price
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Order $order
 * @property Product $product
 */
class OrderDetail extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'price', 'status'], 'default', 'value' => null],
            [['quantity'], 'default', 'value' => 1],
            [['order_id', 'product_id', 'quantity'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'string', 'max' => 20],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'quantity' => Yii::t('app', 'Quantity'),
            'price' => Yii::t('app', 'Price'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::class, ['id' => 'order_id']);
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

}
