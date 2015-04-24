<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
// echo "<pre>";
// print_r($rows );
// echo "</pre>";
// die;
?>
<div class="title-random-main">
	Các dòng xe 
</div>
<div class="ke-doc"></div>
<?php foreach ($rows as $key => $row): ?>
	<div class="col-lg-4 col-md-4 col-xs-4 ">
			<?php $link = 'index.php?option=com_vehiclemanager&amp;task=view_vehicle&amp;Itemid=4&amp;catid='. $row->catid. '&amp;id='.$row->id;?>
		<a href="<?php echo $link;?>">
		<div class="product-random">
			<div class="img-random">
				<img src="<?php echo JUri::root().'components/com_vehiclemanager/photos/'.$row->image_link; ?>" alt="">
				<div class="opacity">
					
				</div>
			</div>
			<div class="random-detail">
				<div class="random-title">
				<?php echo $row->vtitle; ?>
				</div>
				<div class="random-learn">
					
					<button>Xem Thêm</button>
				</div>
			</div>
			
		</div>
		</a>
	</div>
<?php endforeach ?>