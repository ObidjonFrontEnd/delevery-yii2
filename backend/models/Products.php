<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property int|null $restaurant_id
 * @property string|null $name
 * @property int|null $category_id
 * @property string|null $image
 * @property float|null $price
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Category $category
 * @property OrderDetail[] $orderDetails
 * @property ProductDetail[] $productDetails
 * @property ProductTags[] $productTags
 * @property Restaurant $restaurant
 * @property Wishlist[] $wishlists
 */
class Products extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['restaurant_id', 'name', 'category_id', 'image', 'price', 'status'], 'default', 'value' => null],
            [['restaurant_id', 'category_id'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 150],
            [['image'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 20],
            [['restaurant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurant::class, 'targetAttribute' => ['restaurant_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'restaurant_id' => Yii::t('app', 'Restaurant ID'),
            'name' => Yii::t('app', 'Name'),
            'category_id' => Yii::t('app', 'Category ID'),
            'image' => Yii::t('app', 'Image'),
            'price' => Yii::t('app', 'Price'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[OrderDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetail::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductDetails()
    {
        return $this->hasMany(ProductDetails::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductTags()
    {
        return $this->hasMany(ProductTags::class, ['product_id' => 'id']);
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
     * Gets query for [[Wishlists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWishlists()
    {
        return $this->hasMany(Wishlist::class, ['product_id' => 'id']);
    }

}
