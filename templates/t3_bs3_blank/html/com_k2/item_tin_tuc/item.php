<?php 
defined('_JEXEC') or die('Restricted access');
// echo "<pre>";
// print_r($this->item);
// echo "</pre>";
// die;
$item=$this->item;
?>
<div class="col-md-9 col-xs-9 left">
	<div class="bai-viet-tin-tuc">
		<h1>
			<?php echo $item->title; ?>
		</h1>
					
		<div class="description">
			<?php echo $item->introtext; ?>
			<?php echo $item->fulltext; ?>
		</div>
		<?php if($this->item->params->get('itemTwitterButton',1) || $this->item->params->get('itemFacebookButton',1) || $this->item->params->get('itemGooglePlusOneButton',1)): ?>
		<!-- Social sharing -->
		<div class="itemSocialSharing">

			<?php if($this->item->params->get('itemTwitterButton',1)): ?>
			<!-- Twitter Button -->
			<div class="itemTwitterButton">
				<a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal"<?php if($this->item->params->get('twitterUsername')): ?> data-via="<?php echo $this->item->params->get('twitterUsername'); ?>"<?php endif; ?>>
					<?php echo JText::_('K2_TWEET'); ?>
				</a>
				<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
			</div>
			<?php endif; ?>

			<?php if($this->item->params->get('itemFacebookButton',1)): ?>
			<!-- Facebook Button -->
			<div class="itemFacebookButton">
				<div id="fb-root"></div>
				<script type="text/javascript">
					(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));
				</script>
				<div class="fb-like" data-send="false" data-width="200" data-show-faces="true"></div>
			</div>
			<?php endif; ?>

			<?php if($this->item->params->get('itemGooglePlusOneButton',1)): ?>
			<!-- Google +1 Button -->
			<div class="itemGooglePlusOneButton">
				<g:plusone annotation="inline" width="120"></g:plusone>
				<script type="text/javascript">
				  (function() {
				  	window.___gcfg = {lang: 'en'}; // Define button default language here
				    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				    po.src = 'https://apis.google.com/js/plusone.js';
				    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				  })();
				</script>
			</div>
			<?php endif; ?>

			<div class="clr"></div>
		</div>
		<?php endif; ?>
	</div>
</div>
<div class="col-md-3 col-xs-3 left">
	{module 129}
</div>