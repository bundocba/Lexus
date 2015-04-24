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
		<img src="<?php echo $items[0]->imageLarge;?>" alt="">
		<div class="detail-phu-kien">
			<div class="title">
				<?php echo $items[0]->title;?>
			</div>
			<div class="intro">
				<?php echo $items[0]->introtext;?>
			</div>
			<div class="more">
				<a href="index.php?option=com_phocagallery&view=categories&Itemid=135">Xem Thêm</a>
			</div>
			
		</div>
	</div>
	<div class="col-md-8 col-xs-8 right">
		<div class="title-module-phu-kien">
			<div class="title">
				 Nên Tân Trang Cho Xe ?
			</div>
			<div class="info">
				- Thể hiện sự khác biệt , và nâng cấp ngoại hình vốn dĩ đã đẹp nay còn sang trọng hơn !
			</div>
		</div>
		{module 127}
	</div>
	<?php endif ?>
</div>
