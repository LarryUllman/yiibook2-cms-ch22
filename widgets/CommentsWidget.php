<?php
namespace app\widgets;

use yii\base\InvalidConfigException;
use app\models\Comment;


class CommentsWidget extends \yii\base\Widget {
	public $page_id;
	public $limit = 5;

	public function init() {
	    if (!is_int($this->limit) || ($this->limit < 0)) {
	        throw new InvalidConfigException("'limit' must be a positive integer; 5 is the default.");
	    }
	}

	public function run() {
	    if (is_int($this->page_id) && ($this->page_id > 0)) {
			$comments = Comment::find()
				->where(['page_id' => $this->page_id])
			    ->orderBy(['date_entered' => SORT_DESC])
			    ->limit($this->limit)
			    ->all();
	    } else {
			$comments = Comment::find()
			    ->orderBy(['date_entered' => SORT_DESC])
			    ->limit($this->limit)
			    ->all();
	    }

	    return $this->render('comments', ['comments' => $comments]);
	}

}
