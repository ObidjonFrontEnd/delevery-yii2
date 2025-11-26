<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "chats".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $admin_id
 * @property string|null $created_at
 *
 * @property Admin $admin
 * @property ChatMessage[] $chatMessages
 * @property User $user
 */
class Chat extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chats';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'admin_id'], 'default', 'value' => null],
            [['user_id', 'admin_id'], 'integer'],
            [['created_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['admin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Admin::class, 'targetAttribute' => ['admin_id' => 'id']],
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
            'admin_id' => Yii::t('app', 'Admin ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[Admin]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(Admin::class, ['id' => 'admin_id']);
    }

    /**
     * Gets query for [[ChatMessages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChatMessages()
    {
        return $this->hasMany(ChatMessage::class, ['chat_id' => 'id']);
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
