<?php
defined('_JEXEC') or die('Restricted access');
// echo "<pre>";
// print_r($this->categories);
// echo "</pre>";
// die;

?>
<div class="banner-phu-kien-album">
	{module 127}
</div>
<div class="title-random-main detail-main">
	Album Phụ Kiện Theo Xe
</div>
<div class="row" id="phu-kien-album">
	<ul>
		<?php foreach ($this->categories as $key => $item): ?>
		<li>
			<a href="<?php echo $item->link;?>">
			<div class="product-phu-kien">
				<div class="img-phukien">
					<img src="<?php echo  'images/phocagallery/'.$item->filename;?>" alt="<?php echo $item->title_self;?>">
				</div>
				<div class="title">
					<h1>
						<?php echo $item->title_self; ?>
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
		<?php endforeach ?>	
	</ul>
</div>