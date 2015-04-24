<?php
defined('_JEXEC') or die('Restricted access');
// echo "<pre>";
// print_r($items);
// echo "</pre>";
// die;
?>

<div class="row phu-kien-xe">
	<?php if ($items): ?>
		
	<div class="col-md-4 col-xs-4 left">
		{module 130}
		<div class="detail-phu-kien">
			<div class="title title-tin-tuc-menu">
				Tin Tức & Công Nghệ
			</div>
			<div class="intro">
				Tổng hợp tin tức hàng đầu về xe Lexus tại Việt Nam
			</div>
			<div class="more">
				<a href="index.php?option=com_phocagallery&view=categories&Itemid=135">Xem Thêm</a>
			</div>
			
		</div>
	</div>
	<div class="col-md-4 col-xs-4 center">
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
	</div>
	<div class="col-md-4 col-xs-4 right">
	{module 132}
	</div>	
	<?php endif ?>
</div>
