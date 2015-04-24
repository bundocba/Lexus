<?php
defined('_JEXEC') or die('Restricted access');
// echo "<pre>";
// print_r($vehicle);
// echo "</pre>";
// die;

require_once (dirname(__FILE__).DS.'get-image.php');
$bun=new bun();

	
?>
<!-- Banner Xe -->
<?php
	$param_title=$vehicle->vmodel;
	$param_title=strtoupper($param_title);
	$param_title = preg_replace('/\s\s+/', ' ', trim($param_title));
	$abc=$bun->getImage_by_Title($param_title);

	$db=JFactory::getDbo();
	$query=$db->getQuery(true);
	$query->select("id,introtext");
	$query->from($db->quoteName("#__k2_items"));
	$query->where($db->quoteName('title').'like'.$db->quote($param_title));
	$query->setLimit(1);
	$db->setQuery($query);
	$result = $db->loadObjectlist();
?>
<?php if ($abc): ?>
<div class="banner-verhicle">
	<img class="img-responsive" src="<?php echo $abc;?>" alt="">
	<div class="logo-banner-detail">
		<div class="year">The <?php echo $vehicle->year;?></div>
		<div class="model"><?php echo $vehicle->vmodel;?></div>
		<div class="ke-ngang"></div>	
	</div>
</div>
<?php endif ?>

<!-- Thông số xe -->	
<div class="title-random-main detail-main">
	Thông Số Kỹ Thuật
</div>
<div class="detail-xe-hoi">
	<div class="col-md-6 col-xs-7 detail-verhicle-left image_content">
	<div class="image_content_main">
		<div class="image_large">
			<img src="<?php echo JUri::root();?>components/com_vehiclemanager/photos/<?php echo $vehicle->image_link;?>" alt="">
		</div>
		<div class="so-do">
			<div class="horzone">
                <div class="horzonecore"></div>
              </div>
            <span>
	      		<?php echo _VEHICLE_MANAGER_LABEL_WHEELBASE;?> : <?php echo $vehicle->wheelbase;?>
	      	</span>
			<div class="horztwo">
                <div class="horztwocore">
                	
                </div>
	      	</div>
	      	<span>
	      		<?php echo _VEHICLE_MANAGER_LABEL_WHEELTYPE;?> : <?php echo $vehicle->wheeltype;?>
	      	</span>
	      	<span class="vertonetext">
	      		<?php echo _VEHICLE_MANAGER_LABEL_REARAXE_TYPE;?> : <?php echo $vehicle->rear_axe_type;?>
	      	</span>
	      	<div class="vertone">
                <div class="vertonecore"></div>
            </div>
		</div>
		
		<?php if (count($vehicle_photos)>0): ?>
		
			<div class="image_thumnai slider1" id="sliderWrap-team">
				<?php foreach ($vehicle_photos as $key => $img): ?>
				
				<li class="image_thumai_detail">
					<img src="<?php echo JUri::root();?>components/com_vehiclemanager/photos/<?php echo $img->main_img;?>" alt="">
				</li>
				
				<?php endforeach ?>
			</div>
			<div class="prev"></div>
			<div class="next"></div>

		<?php endif ?>
	</div>
	
</div>
<div class="col-md-6 col-xs-5 detail-verhicle-right">
	
	<div class="profile-verhicle">
		<div class="model">
			<h3><?php echo $vehicle->vmodel;?></h3>
		</div>
		<div class="power">
			<div class="verhicle-align-left">
				<?php echo _VEHICLE_MANAGER_LABEL_ENGINE_TYPE;?>
			</div>
			<div class="verhicle-align-right">
				<?php echo $vehicle->engine;?>
			</div>
		</div>
		<div class="power">
			<div class="verhicle-align-left">
				<?php echo 	_VEHICLE_MANAGER_LABEL_MAKER;?>
			</div>
			<div class="verhicle-align-right">
				<?php echo $vehicle->maker;?>
			</div>
		</div>
		<div class="power">
			<div class="verhicle-align-left">
				<?php echo 	_VEHICLE_MANAGER_LABEL_ISSUE_YEAR;?>
			</div>
			<div class="verhicle-align-right">
				<?php echo $vehicle->year;?>
			</div>
		</div>
		<div class="power">
			<div class="verhicle-align-left">
				<?php echo 	_VEHICLE_MANAGER_LABEL_FUEL_TYPE;?>
			</div>
			<div class="verhicle-align-right">
				<?php
				$fule="";
				if (($vehicle->fuel_type) != ''){
	                $fuel_type1 = explode(',', _VEHICLE_MANAGER_OPTION_FUEL_TYPE);
	               	foreach ($fuel_type1 as $key => $value) {
	               		$key++;
	               		if ($vehicle->fuel_type==$key) {
	               			$fule=$value;
	               			}
	               		}
	               	 }
				 echo $fule;?>
			</div>
		</div>
		
		<div class="power">
			<div class="verhicle-align-left">
				<?php echo 	_VEHICLE_MANAGER_LABEL_NUMBER_DOORS;?>
			</div>
			<div class="verhicle-align-right">
				<?php echo $vehicle->doors;?>
				
			</div>
		</div>
		<div class="power">
			<div class="verhicle-align-left">
				<?php echo 	_VEHICLE_MANAGER_LABEL_WARRANTY_BASIC;?>
			</div>
			<div class="verhicle-align-right">
				<?php echo $vehicle->w_basic;?> 
				
			</div>
		</div>
		<div class="power">
			<div class="verhicle-align-left">
				<?php echo 	_VEHICLE_MANAGER_LABEL_MILEAGE;?>
			</div>
			<div class="verhicle-align-right">
				<?php echo $vehicle->mileage;?>
				
			</div>
		</div>
		<div class="power">
			<div class="verhicle-align-left">
				<?php echo 	_VEHICLE_MANAGER_LABEL_BRAKES_TYPE;?>
			</div>
			<div class="verhicle-align-right">
				<?php echo $vehicle->brakes_type;?>
				
			</div>
		</div>
		<div class="power">
			<div class="verhicle-align-left">
				<?php echo 	_VEHICLE_MANAGER_LABEL_PRICE;?>
			</div>
			<div class="verhicle-align-right" style="font-weight:bold;">
				<?php echo $vehicle->price;?> 
				<?php echo $vehicle->priceunit;?>
			</div>
		</div>
		
		<div class="power">
			<?php echo 	_VEHICLE_GHI_CHU_VAT;?>	
		</div>

		<div class="button-detail-thong-so">
			<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
			  Thông Số Chi Tiết
			</button>
		</div>
		
	</div>


</div>
</div>
<!-- detail thông số kỉ thuật -->
<?php if ($result): ?>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	   
	      </div>
	      <div class="modal-body">
	       <?php echo $result[0]->introtext; ?>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	       
	      </div>
	    </div>
	  </div>
	</div>
<?php endif ?>
<!-- end detail -->

<div class="title-random-main detail-main detail-main-image">
	Hình Ảnh và Video
</div>
<div class="image-video">
	<?php if ($bun->getVideo_by_Title($param_title)): ?>
		<div class="col-md-6 col-xs-6 detail-video">
			<?php echo $bun->getVideo_by_Title($param_title);?>
		</div>
	<?php endif ?>
	<?php
		$files = array();
		$url_dir=JRoute::_(JUri::root().'/media/k2/galleries/'.$result[0]->id.'/');

		$dir = opendir(JPATH_BASE.'/media/k2/galleries/'.$result[0]->id.'/');

		while ($f = readdir($dir)) {
			if (eregi("\.jpg|\.gif|\.png", $f))
			array_push($files, $f);
		}
		closedir($dir);
	?>
	<?php if (! empty($files)): ?>
	
		
		<?php foreach ($files as $k => $v): ?>
		<!-- <div class="col-md-3 col-xs-3 detail-images">	 -->
		
			<a href="<?php echo $url_dir.$v; ?>" data-lightbox="roadtrip">
			<li class="detail-image" data-lightbox="roadtrip">
				<img src="<?php echo $url_dir.$v; ?>" alt="" width="326" height="183">
			</li>
			</a>
		<!-- </div> -->
		
		<?php endforeach ?>
		
	
	<?php endif?>	


</div>

<script>
	jQuery(window).load(function() {
		jQuery('#sliderWrap-team').bxSlider({
		    slideWidth: 200,
		    minSlides: 1,
		    maxSlides: 1,
		    slideMargin: 10
		  });
		
	});
	jQuery(document).ready(function($) {
		// $('.image_content .prev').click(function(event) {
			
		// 	  var $last = $('.image_content ul.image_thumnai li:last');
		// 	  if ($('.image_content ul.image_thumnai li').length<=1) {
		// 	  		return;
		// 	  };
		// 	    $last.remove().css({ 'margin-left': '-120' });
		// 	    $('.image_content ul.image_thumnai li:first').before($last);
		// 	    $last.animate({ 'margin-left': '0px' }, 200);
		//  });
		
		// $('.image_content .next').click(function(event) {
		// 	   var $first = $('.image_content ul.image_thumnai li:first');
		// 	   if ($('.image_content ul.image_thumnai li').length<=1) {
		// 	  		return;
		// 	  };
		//         $first.animate({ 'margin-left': '-120' }, 200, function() {
		//         $first.remove().css({ 'margin-left': '0px' });
		//         $('.image_content ul.image_thumnai li:last').after($first);
	 //   		 }); 
	 //    });  
	    jQuery( "ul.image_thumnai " ).delegate( "li", "click", function() {
			
			var src = jQuery(this).find('img').attr('src');
			var main_image = jQuery('.image_large').find('img');
			main_image.hide();
			main_image.attr('src',src);
			main_image.fadeIn();
		}); 

		
	});
</script>
