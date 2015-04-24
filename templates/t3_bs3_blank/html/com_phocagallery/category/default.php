<?php
defined('_JEXEC') or die('Restricted access');
// echo "<pre>";
// print_r($this->items);
// echo "</pre>";
// die;

?>

<div class="banner-phu-kien-album">
	{module 127}
</div>
<div class="title-random-main detail-main">
	Album <?php echo $this->category->title ?>
</div>
<div class="row" id="phu-kien-album">
	<ul>
		<?php foreach ($this->items  as $key => $item): ?>
		<?php if (!$key==0): ?>
			<li>
				<a href="<?php echo  $item->linkorig;?>" data-lightbox="roadtrip">
				<div class="product-phu-kien product-phu-kien-detail">
					<div class="detail-image">
						<img src="<?php echo  $item->linkorig;?>" alt="<?php echo $item->title;?>">
					</div>
					<div class="title title-detail">
						<h1>
							<?php echo $item->title; ?>
						</h1>
					</div>
					<div class="description">
						<p>
							<?php echo $item->description; ?>
						</p>
					</div>

				</div>
				</a>
			</li>
		<?php endif ?>
		
		<?php endforeach ?>	
	</ul>
</div>