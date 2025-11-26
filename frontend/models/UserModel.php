<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Yii;

class UserModel extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_UPDATE = 'update';

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['email', 'password', 'role', 'first_name', 'last_name', 'phone_number' ], 'required', 'on' => self::SCENARIO_REGISTER],
            [['email', 'password'], 'required', 'on' => self::SCENARIO_LOGIN],
            [[ 'image' ], 'string' , 'on' => self::SCENARIO_REGISTER ],
            ['image', 'default', 'value' => 'default.jpg', 'on' => self::SCENARIO_REGISTER],
            [[ 'image' ], 'string' , 'on' => self::SCENARIO_UPDATE],
            ['image', 'default', 'value' => 'default.jpg', 'on' => self::SCENARIO_UPDATE],
            [['email', 'first_name', 'last_name', 'phone_number'], 'required', 'on' => self::SCENARIO_UPDATE],
            ['password', 'safe', 'on' => self::SCENARIO_UPDATE],
            ['email', 'email'],
            ['email', 'unique', 'on' => self::SCENARIO_REGISTER],
            ['first_name', 'string', 'min' => 3],
            ['last_name', 'string', 'min' => 3],
            ['password', 'string', 'min' => 8],
            ['phone_number', 'match', 'pattern' => '/^(?:\+998|998|8)?(9[0-9]{8})$/', 'message' => "Iltimos, telefon raqamingizni to'g'ri kiriting, masalan: +998 9* *** ** **"],
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if (!empty($this->password) && $this->isAttributeChanged('password')) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        }

        if (!empty($this->phone_number)) {
            $this->phone_number = str_replace(' ', '', $this->phone_number);
        }

        return true;
    }

    public function getRestaurants()
    {
        return $this->hasMany(RestauransModel::class, ['user_id' => 'id']);
    }

    // ===== Методы IdentityInterface =====

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key ?? null; // если у вас нет поля auth_key, оставьте null
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    // ===== Дополнительные методы =====

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
}