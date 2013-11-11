<?php
require_once 'config.php';
require_once 'php/Fakebook.php';

$pageTitle = 'Homepage';

$fakebook = new Fakebook();

// if the user is not logged, redirect to the login page
if (!$fakebook->getLoggedUserId()) {
	header("location: index.php");
}

$updates = $fakebook->getUpdates();

?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head.inc.php'; ?>
<body>

	<?php include 'topbar.inc.php'; ?>
	
	<div id="container">
		<?php include 'sidebar.inc.php' ?>
		<form id="new-status" method="post" action="push-status.php">
			<input type="text" name="message" placeholder="Say something..!">
			<input type="submit">
		</form>
		<section id="content">
			<h1 style="margin-top: 0;">News feed:</h1>
			<?php if (!$updates) {
				echo 'Sorry but there are no news.';
			}?>
			<?php
			foreach ($updates as $update) {
				$aux = explode('|',$update); ?>
				<div class="status">
					<div class="author"><a href="user.php?id=<?= $aux[1] ?>"><?= $fakebook->getFullName($aux[1]) ?></a></div>
					<div class="text"><?= $aux[2] ?></div>
					<div class="details">
						<?php if (!$fakebook->checkLike($aux[0])) : ?>
							<a href="like.php?id=<?= $aux[0] ?>">Like</a>
						<?php else : ?>
							<a href="like.php?id=<?= $aux[0] ?>&unlike=true">Unlike</a>
						<?php endif ?>
						 - <a href="#"><?= $fakebook->countLikes($aux[0]) ?> likes</a>
						 - <a href="#"><?= $fakebook->countComments($aux[0]) ?> comments</a>
						 - <?= $fakebook->timeAgo($aux[3]) ?></div>
					<hr>
				</div>
				<?php } ?>
		</section>
	</div>
</body>
</html>