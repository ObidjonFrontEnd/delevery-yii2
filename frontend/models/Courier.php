<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "couriers".
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $phone_number
 * @property string|null $password
 * @property string|null $transport_type
 * @property string|null $courier_license
 * @property string|null $status
 * @property string|null $created_at
 *
 * @property Order[] $orders
 */
class Courier extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'couriers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'phone_number', 'password', 'transport_type', 'courier_license', 'status'], 'default', 'value' => null],
            [['created_at'], 'safe'],
            [['first_name', 'last_name', 'courier_license'], 'string', 'max' => 100],
            [['phone_number', 'status'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 255],
            [['transport_type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone_number' => 'Phone Number',
            'password' => 'Password',
            'transport_type' => 'Transport Type',
            'courier_license' => 'Courier License',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['courier_id' => 'id']);
    }

}
