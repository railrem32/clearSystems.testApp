<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $value
 * @property string $date
 * @property integer $user_id
 * @property string $theme
 * @property User $user
 */
class Post extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'/*, 'date', 'user_id'*/,'theme'], 'required'],
            [['value'], 'string'],
            /*[['date'], 'safe'],*/
            [['user_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Содержание',
            'date' => 'Date',
            'user_id' => 'User ID',
            'theme' => 'Тема',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
