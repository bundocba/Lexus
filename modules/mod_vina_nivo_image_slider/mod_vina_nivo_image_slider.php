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
require_once dirname(__FILE__) . '/helper.php';

// load json code
$slider = json_decode($params->get('slides', ''));

// load data
$slides = modVinaNivoImageSliderHelper::getSildes($slider);

// check if don't have any slide
if(empty($slides)) {
	echo "You don't have any slide!";
	return;
}

// get module params
$moduleStyle		= $params->get('moduleStyle', 'default');
$moduleWidth		= $params->get('moduleWidth', '600px');
$moduleHeight		= $params->get('moduleHeight', 'auto');
$moduleMargin		= $params->get('moduleMargin', '0px auto 0px auto');
$modulePadding		= $params->get('modulePadding', '0px 0px 0px 0px');
$bgImage			= $params->get('bgImage', NULL);
if($bgImage != '') {
	if(strpos($bgImage, 'http://') === FALSE) {
		$bgImage = JURI::base() . $bgImage;
	}
}
$isBgColor			= $params->get('isBgColor', 0);
$bgColor			= $params->get('bgColor', '#FFFFFF');
$resizeImage		= $params->get('resizeImage', 1);
$imageWidth			= $params->get('imageWidth', '600');
$imageHeight		= $params->get('imageHeight', '300');
$controlNavThumbs	= $params->get('controlNavThumbs', 0);
$simageWidth		= $params->get('simageWidth', '120');
$simageHeight		= $params->get('simageHeight', '60');
$controlNav			= $params->get('controlNav', 1);
$directionNav		= $params->get('directionNav', 1);
$effect				= $params->get('effect', 'random');
$slices				= $params->get('slices', 15);
$boxCols			= $params->get('boxCols', 8);
$boxRows			= $params->get('boxRows', 4);
$animSpeed			= $params->get('animSpeed', 500);
$pauseTime			= $params->get('pauseTime', 3000);
$startSlide			= $params->get('startSlide', 0);
$randomStart		= $params->get('randomStart', 0);
$pauseOnHover		= $params->get('pauseOnHover', 1);
$manualAdvance		= $params->get('manualAdvance', 1);

// display layout
require JModuleHelper::getLayoutPath($module->module, $params->get('layout', 'default'));
modVinaNivoImageSliderHelper::getCopyrightText($module);