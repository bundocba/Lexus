<?php
/*
# ------------------------------------------------------------------------
# Vina Nivo Image Slider for Joomla 3
# ------------------------------------------------------------------------
# Copyright(C) 2014 www.VinaGecko.com. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: VinaGecko.com
# Websites: http://vinagecko.com
# Forum:    http://vinagecko.com/forum/
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$doc = JFactory::getDocument();
$doc->addScript('modules/mod_vina_nivo_image_slider/assets/js/jquery.nivo.slider.js', 'text/javascript');
$doc->addStyleSheet('modules/mod_vina_nivo_image_slider/assets/css/nivo-slider.css');
$doc->addStyleSheet('modules/mod_vina_nivo_image_slider/assets/themes/'.$moduleStyle.'/'.$moduleStyle.'.css');
$timthumb = JURI::base() . 'modules/mod_vina_nivo_image_slider/libs/timthumb.php?a=c&q=99&z=0';
?>
<style type="text/css" scoped>
#vina-nivo-islider<?php echo $module->id; ?> {
	max-width: <?php echo $moduleWidth; ?>;
	height: <?php echo $moduleHeight; ?>;
	padding: <?php echo $modulePadding; ?>;
	margin: <?php echo $moduleMargin; ?>;
	<?php echo ($bgImage != '') ? 'background: url('.$bgImage.') top center no-repeat;' : ''; ?>
	<?php echo ($isBgColor) ? 'background-color: ' . $bgColor : ''; ?>
}
#vina-nivo-islider<?php echo $module->id; ?> .nivo-controlNav.nivo-thumbs-enabled img {
	width: <?php echo $simageWidth; ?>px;
	height: <?php echo $simageHeight; ?>px;
}
#vina-copyright<?php echo $module->id; ?> {
	font-size: 12px;
	height: 1px;
	overflow: hidden;
	clear: both;
}
</style>
<div id="vina-nivo-islider<?php echo $module->id; ?>" class="vina-nivo-islider slider-wrapper theme-<?php echo $moduleStyle; ?>">
	<div class="nivoSlider">
		<?php foreach($slides as $key => $slide) : ?>
		<?php
			$image 		= $slide->img;
			$image 		= (strpos($image, 'http://') === false) ? JURI::base() . $image : $image;
			$bigImage   = $timthumb . '&amp;w=' . $imageWidth . '&amp;h=' . $imageHeight . '&amp;src=' . $image;
			$smallImage = $timthumb . '&amp;w=' . $simageWidth . '&amp;h=' . $simageHeight . '&amp;src=' . $image;
			$bigImage   = ($resizeImage) ? $bigImage : $image;
			$smallImage = ($controlNavThumbs && $resizeImage) ? $smallImage : $image;
			$title      = !empty($slide->text) ? 'title="#htmlcaption' . $module->id . $key . '"' : '';
		?>
		<?php if(!empty($slide->link)) : ?>
		<a href="<?php echo $slide->link; ?>" target="<?php echo $slide->target; ?>">
		<?php endif; ?>
			<img src="<?php echo $bigImage; ?>" data-thumb="<?php echo $smallImage; ?>" <?php echo $title; ?> alt="nivo" />
		<?php if(!empty($slide->link)) : ?>
		</a>
		<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<?php foreach($slides as $key => $slide) : ?>
		<?php if(!empty($slide->text)) : ?>
		<div id="htmlcaption<?php echo $module->id . $key; ?>" class="nivo-html-caption">
			<?php echo $slide->text; ?>
		</div>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
<script type="text/javascript">
jQuery(document).ready(function ($) {
	$(window).load(function() {
		$('#vina-nivo-islider<?php echo $module->id; ?> div.nivoSlider').nivoSlider({
			effect: 			'<?php echo $effect; ?>',
			slices: 			<?php echo $slices; ?>,
			boxCols: 			<?php echo $boxCols; ?>,
			boxRows: 			<?php echo $boxRows; ?>,
			animSpeed: 			<?php echo $animSpeed; ?>,
			pauseTime: 			<?php echo $pauseTime; ?>,
			startSlide: 		<?php echo $startSlide; ?>,
			directionNav: 		<?php echo $directionNav ? 'true' : 'false'; ?>,
			controlNav: 		<?php echo $controlNav ? 'true' : 'false'; ?>,
			controlNavThumbs: 	<?php echo $controlNavThumbs ? 'true' : 'false'; ?>,
			pauseOnHover: 		<?php echo $pauseOnHover ? 'true' : 'false'; ?>,
			manualAdvance: 		<?php echo $manualAdvance ? 'false' : 'true'; ?>,
		});
	});
});
</script>