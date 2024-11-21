<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property int $user_id
 * @property int $live
 * @property string $title
 * @property string|null $content
 * @property string $date_updated
 * @property string|null $date_published
 *
 * @property Comment[] $comments
 * @property User $user
 * @property PageHasFile[] $pageHasFiles
 * @property File[] $files
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // Only the title is required from the user:
            [['title'], 'required'],
            // User must exist in the related table:
            [['user_id'], 'exist', 'skipOnError' => false, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            // Live needs to be Boolean; default 0:
            [['live'], 'integer'],
            [['live'], 'default', 'value' => 0],
            // Title has a max length and strip tags:
            [['title'], 'string', 'max' => 100],
            [['title'], 'filter', 'filter' => 'strip_tags'],
            // Filter the content to allow for NULL values:
            [['content'], 'string'],
            [['content'], 'default', 'value' => NULL],
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
            'live' => 'Live',
            'title' => 'Title',
            'content' => 'Content',
            'date_updated' => 'Date Updated',
            'date_published' => 'Date Published',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['page_id' => 'id']);
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

    /**
     * Gets query for [[PageHasFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPageHasFiles()
    {
        return $this->hasMany(PageHasFile::className(), ['page_id' => 'id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['id' => 'file_id'])->viaTable('page_has_file', ['page_id' => 'id']);
    }

    public function beforeValidate()
    {
        if(empty($this->user_id)) {
            $session = Yii::$app->session;
            if (!$session->isActive) $session->open();
            $this->user_id = $session['user_id'];
        }
        return parent::beforeValidate();
    }

    public function formattedPublishedDate() 
    {
        if ($this->date_published) {
            $formatter = \Yii::$app->formatter;
            return $formatter->asDate($this->date_published, 'long');
        }
    }
    
}
