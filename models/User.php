<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $email
 * @property string $name
 * @property string $surname
 * @property string $phone
 * @property string $password
 * @property integer $city_id
 * @property string $image
 * @property string $thumb_image
 * @property Post[] $posts
 * @property City $city
 */
class User extends ActiveRecord implements IdentityInterface
{

    public $file;
    public $password_repeat;
    public $rememberMe = true;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password',], 'required'],
            [['email', 'name', 'surname', 'phone', 'password'], 'string', 'max' => 255],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Пароли не совпадают"],
            ['email', 'email'],
            ['rememberMe', 'boolean'],
            [['email'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['phone'], 'validatePhone'],
            [['file'], 'file', 'skipOnEmpty' => true,'extensions' => 'png, jpg'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'phone' => 'Телефон',
            'password' => 'Пароль',
            'city_id' => 'Город',
            'password_repeat' => 'Повторите Пароль',
            'file'=>'Аватар'
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->access_token;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->access_token = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    public function login($model)
    {
        $user = static::findOne(['email' => $model->username]);
        if (!$user) {
            return $model->addError('username', 'Пользователя с таким логином не существует');
        }
        if (Yii::$app->getSecurity()->validatePassword($model->password, $user->password)) {
            return Yii::$app->user->login($user, $model->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return $model->addError('password', 'Неправильный пароль');
        }
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['user_id' => 'id']);
    }

    public function  validatePhone($attribute, $params)
    {
        $pattern = '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/';
        if (!preg_match($pattern, $this->$attribute)) {
            $this->addError($attribute, 'Неправильный номер телефона');
        }
    }

    public function upload()
    {
        if ($this->validate()) {
            echo "<pre>".var_dump($this->imageAvatar)."</pre>";
            $this->imageAvatar->saveAs('/uploads/' . $this->imageAvatar->baseName . '.' . $this->imageAvatar->extension);

            return true;
        } else {
            return false;
        }
    }

}
