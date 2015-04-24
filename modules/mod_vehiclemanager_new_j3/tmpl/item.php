<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
// echo "<pre>";
// print_r($rows );
// echo "</pre>";
// die;
 $document = JFactory::getDocument();
 $rootUrl = JUri::root(true);
 $template = JFactory::getApplication()->getTemplate();


 $document->addStylesheet($rootUrl.'/templates/'.$template.'/css/jquery.bxslider.css');
 $document->addStylesheet($rootUrl.'/templates/'.$template.'/css/content-header-slider.css');
?>
<div class="title-random-main">
	Sang Trọng ở mọi góc nhìn
</div>
<div class="ke-doc"></div>
<div class="slider1" id="sliderWrap">
	<?php foreach ($rows as $key => $item): ?>
	
		<div class="slide-product">
		 	<?php $link = 'index.php?option=com_vehiclemanager&amp;task=view_vehicle&amp;Itemid=4&amp;catid='. $item->catid. '&amp;id='.$item->id;?>
			<a href="<?php echo $link; ?>&r=0">
		 	 
		 	
		 	<div class="slider-product-img">
				<img src="<?php echo JUri::root().'components/com_vehiclemanager/photos/'.$item->image_link;?>">
			</div>
		 	
			<div class="slider-product-title">
				<p><?php echo $item->vmodel;?></p>
			</div>
			<div class="slider-product-year">
				<p><b>Sãn Xuất : </b><?php echo $item->maker.' - '. $item->year;?></p>
			</div>
			<div class="slider-product-mileage">
				<p><b>Tiết Kiệm : </b><?php echo $item->mileage;?></p>
			</div>
			<div class="slider-product-door">
				<p><b>Số Cửa : </b><?php echo $item->price;?>-<?php echo $item->priceunit;?></p>
			</div>
			<!-- <div class="slider-product-door">
				<p><b>Số Cửa : </b><?php echo $item->doors;?></p>
			</div> -->

			
			<!-- <div class="slider-product-introtext">
				<p> <?php echo $item->description; ?></p>
			</div> -->

		 </a>
		 </div>
	
		 
	<?php endforeach ?>
</div>
<script src="<?php echo $rootUrl . '/templates/' . $template . '/js/jquery.bxslider.min.js';?>"></script>
<script language="javascript">
jQuery(window).load(function() {
	jQuery('#sliderWrap').bxSlider({
	    slideWidth: 200,
	    minSlides: 3,
	    maxSlides: 3,
	    slideMargin: 10
	  });
	
	
});
	
</script>
