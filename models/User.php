<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string|null $pass
 * @property string $type
 * @property string $date_entered
 *
 * @property Comment[] $comments
 * @property File[] $files
 * @property Page[] $pages
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // Required fields when registering:
            [['username', 'email', 'pass'], 'required', 'on'=>'register'],
            // Required fields when logging in:
            [['username', 'pass'], 'required', 'on'=>'login'],
            // Encrypt the password when registering:
            [['pass'], 'encryptPassword', 'on'=>'register'],
            // Username must be unique and less than 45 characters:
            [['username'], 'unique'],
            [['username'], 'string', 'max' => 45],
            // Email address must be unique, an email address, 
            // and less than 60 characters:
            [['email'], 'unique'],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 60],
            // Set the type to "author" by default:
            [['type'], 'default', 'value' => 'author']
            // Type must also be one of three values:
            [['type'], 'in', 'range' => ['author', 'editor', 'admin']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'pass' => 'Pass',
            'type' => 'Type',
            'date_entered' => 'Date Entered',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Pages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['user_id' => 'id']);
    }

    public function validatePassword($loginPass) 
    {
        return password_verify($loginPass, $this->pass);
    }

    public function encryptPassword($attr, $params) 
    {
		$this->pass = password_hash($this->pass);
    }

    public static function findIdentityByAccessToken($token, $type= null) {
    }
    public function getAuthKey() {
    }
    public function validateAuthKey($authKey) 
    {
    }
    public function getId() 
    {
        return $this->id;
    }
    public static function findIdentity($id) 
    {
        return User::findOne($id);
    }
}
