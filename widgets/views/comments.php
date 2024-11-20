<hr />
<?php
foreach ($comments as $comment) {
	echo "<div>
		<p>{$comment->comment}</p>
		<p>Posted by: {$comment->user->username} on {$comment->date_entered}</p>
	</div><hr />";
}