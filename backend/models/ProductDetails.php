<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_details".
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $description
 * @property string|null $weight
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int $calories
 * @property int $preparation_time
 * @property string $ingredients
 *
 * @property Products $product
 */
class productDetails extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'description', 'weight'], 'default', 'value' => null],
            [['product_id', 'calories', 'preparation_time'], 'integer'],
            [['description', 'ingredients'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['calories', 'preparation_time', 'ingredients'], 'required'],
            [['weight'], 'string', 'max' => 50],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'description' => Yii::t('app', 'Description'),
            'weight' => Yii::t('app', 'Weight'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'calories' => Yii::t('app', 'Calories'),
            'preparation_time' => Yii::t('app', 'Preparation Time'),
            'ingredients' => Yii::t('app', 'Ingredients'),
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

}
