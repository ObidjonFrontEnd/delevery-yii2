<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "chat_messages".
 *
 * @property int $id
 * @property int|null $chat_id
 * @property string|null $sender_role
 * @property string|null $message
 * @property string|null $created_at
 *
 * @property Chat $chat
 */
class ChatMessage extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat_id', 'sender_role', 'message'], 'default', 'value' => null],
            [['chat_id'], 'integer'],
            [['message'], 'string'],
            [['created_at'], 'safe'],
            [['sender_role'], 'string', 'max' => 20],
            [['chat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chat::class, 'targetAttribute' => ['chat_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'chat_id' => Yii::t('app', 'Chat ID'),
            'sender_role' => Yii::t('app', 'Sender Role'),
            'message' => Yii::t('app', 'Message'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[Chat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChat()
    {
        return $this->hasOne(Chat::class, ['id' => 'chat_id']);
    }

}
