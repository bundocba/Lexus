<?php
defined('_JEXEC') or die('Restricted access');
// echo "<pre>";
// print_r($items);
// echo "</pre>";
// die;
?>
<?php foreach ($items as $key => $item): ?>	
	<div class="related-content">
		<div class="title">
			<a href="<?php echo $item->link; ?>">
				<h1>
					<?php echo $item->title; ?>
				</h1>
			</a>
		</div>
		<div class="detail">
			<div class="img-detail">
			<?php if ($item->image): ?>
					<img src="<?php echo $item->image;?>" alt="<?php echo $item->title; ?>">	
			<?php endif ?>	
			</div>
			
			<?php echo $item->introtext; ?>
			<div class="creatby-item">
				<?php if($params->get('itemCategory')): ?>
			      <?php echo JText::_('K2_IN') ; ?> <a class="moduleItemCategory" href="<?php echo $item->categoryLink; ?>"><?php echo $item->categoryname; ?></a>
			      <?php endif; ?>

			      <?php if($params->get('itemTags') && count($item->tags)>0): ?>
			      <div class="moduleItemTags">
			      	<b><?php echo JText::_('K2_TAGS'); ?>:</b>
			        <?php foreach ($item->tags as $tag): ?>
			        <a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a>
			        <?php endforeach; ?>
			      </div>
			      <?php endif; ?>
			</div>
			
		</div>
	</div>

<?php endforeach ?>