<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "admins".
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $phone_number
 * @property string|null $password
 * @property string|null $status
 * @property string|null $created_at
 *
 * @property Chat[] $chats
 */
class Admin extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admins';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'phone_number', 'password', 'status'], 'default', 'value' => null],
            [['created_at'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 100],
            [['phone_number', 'status'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 255],
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
            'phone_number' => Yii::t('app', 'Phone Number'),
            'password' => Yii::t('app', 'Password'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[Chats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::class, ['admin_id' => 'id']);
    }

}
