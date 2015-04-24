<?php
defined('_JEXEC') or die('Restricted access');
// echo "<pre>";
// print_r($items);
// echo "</pre>";
// die;
?>
<div class="tin-tuc-me-nu-title">
	<div class="title">
		<a href="<?php echo $items[0]->categoryLink; ?>"><h1><?php echo $items[0]->categoryname; ?></h1></a>
	</div>
		<div class="intro">
	<a href="<?php  echo $items[0]->link;?>">
			<h3><?php  echo $items[0]->title;?></h3>
			<?php echo $items[0]->introtext; ?>
	</a>
		</div>
</div>
<div class="media-img-menu">
	<?php if ($items[0]->video): ?>
		<?php echo $items[0]->video; ?>
	<?php else: ?>
		<img src="<?php echo $items[0]->imageLarge;?>" alt="<?php echo $items[0]->title; ?>">
	<?php endif ?>
</div>
