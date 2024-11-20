<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $user_id
 * @property int $page_id
 * @property string $comment
 * @property string $date_entered
 *
 * @property Page $page
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // Required attributes (by the commentor):
            [['username', 'user_email', 'comment'], 'required'],
            // Must be in related tables:
            [['page_id'], 'integer'],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::class, 'targetAttribute' => ['page_id' => 'id']],
            // Strip tags from the comments:
            [['comment'], 'string'],
            [['comment'], 'filter', 'filter' => 'strip_tags'],
            // Username limited to 45:
            [['username'], 'string', 'max' => 45],
            // Email limited to 60 and must be an email address:
            [['user_email'], 'string', 'max' => 60],
            [['user_email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'page_id' => 'Page ID',
            'comment' => 'Comment',
            'date_entered' => 'Date Entered',
        ];
    }

    /**
     * Gets query for [[Page]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
