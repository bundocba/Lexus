<?php
defined('_JEXEC') or die('Restricted access');
// echo "<pre>";
// print_r($items);
// echo "</pre>";
// die;
?>
<div class="new-content-verhicle">
	<div class="title-random-main">
	Tin Tức
	</div>
	<!-- <div class="ke-doc"></div> -->
	<div class="row header-tin-tuc">
		<ul>
			<?php foreach ($items as $key => $row): ?>
				<li>
					<a href="<?php echo $row->link; ?>">
					<div class="tin-tuc-product">
						 
						<div class="img-tintuc">
							<?php if ($row->video): ?>
								<?php echo $row->video;?>
							<?php else:?>
								<img class="img-responsive" src="<?php echo $row->imageLarge;?>" alt="">
							<?php endif ?>
						</div>
						<div class="title-tintuc">
							<h3><?php echo $row->title;?></h3>
						</div>
						<div class="introtext">
							<p><?php echo $row->introtext;?></p> 
						</div>
						<div class="readmore">
							<a class="moduleItemReadMore" href="<?php echo $row->link; ?>">
								<?php echo JText::_('đọc thêm..'); ?>
							</a>
						</div>
						<div class="img-logo">
							
						</div>
						
					</div>
					</a>
				</li>
			<?php endforeach ?>
		</ul>
	</div>
	
</div>
