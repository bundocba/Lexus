<?php 
defined('_JEXEC') or die('Restricted access');
// echo "<pre>";
// print_r($rows);
// echo "</pre>";
// die;
?>
<div class="new-content-verhicle" id="model">
	<div class="title-random-main">
	Các dòng xe 
	</div>
	<!-- <div class="ke-doc"></div> -->
	<?php foreach ($rows as $key => $row): ?>
		<div class="col-lg-3 col-md-4 col-xs-4 ">
			<div class="product-new">
			<?php $link ='index.php?option=com_vehiclemanager&amp;task=view_vehicle&amp;Itemid=4&amp;catid='. $row->catid. '&amp;id='.$row->id;?>
				<div class="img-product">
				<img src="<?php echo JUri::root();?>components/com_vehiclemanager/photos/<?php echo $row->image_link;?>" alt="">
				
				</div>
				<div class="model-product">
					<h4><?php echo $row->vmodel;?></h4>
				</div>
				<div class="detail-new">
					<div class="title-new">
						<span class="glyphicon glyphicon-chevron-right"></span> <a href="index.php?option=com_phocagallery&view=categories&Itemid=135">Phụ Kiện Cho Xe</a>
					</div>
				<a href="<?php echo JRoute::_($link, false); ?>">
					<div class="img-tranfe">
						
					</div>
				</a>
					<div class="price-new">
						<?php echo $row->priceunit;?> - <?php echo $row->price;?>*
					</div>
				 	<div class="power-content">
						<?php echo _VEHICLE_MANAGER_LABEL_ENGINE_TYPE;?> : <?php echo $row->engine;?> 
					</div>
					 <div class="power-content">
						<?php echo _VEHICLE_MANAGER_LABEL_EXTRA1;?> : <?php echo $row->extra1;?>
					</div>
					
				</div>
				
			</div>
		
		</div>
	<?php endforeach ?>
</div>
