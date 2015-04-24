<?php 
defined('_JEXEC') or die('Restricted access');
// echo "<pre>";
// print_r($_POST['row']);
// echo "</pre>";
// die;
?>

	<div class="row model-vehicle-menu">
		<div class="col-lg-6 col-md-6 col-xs-6 left">
			<div class="row">
				<div class="col-lg-7 col-md-7 col-xs-7 left">
					{module 101}
				</div>
				<div class="col-lg-5 col-md-5 col-xs-5 center">
					<?php
								$db = JFactory::getDbo();
								$query = $db->getQuery(true);
								$query->select('*');
								$query->from($db->quoteName('#__vehiclemanager_main_categories'));
								$query->where('published=1');
								$db->setQuery($query);
								$results=$db->loadObjectList();	
											
					?>
					<div class="title">
						<p>Các Dòng Xe</p>
					</div>
					<ul>
					<?php foreach ($results as $key2 => $value): ?>
							
							<?php if ($value->parent_id==0): ?>
							
							<li>
								<p><a title="" href ="<?php echo $value->id;?>"><?php echo $value->title;?></a></p>
								<?php
									$db = JFactory::getDbo();
									$query = $db->getQuery(true);
									$query->select('*');
									$query->from($db->quoteName('#__vehiclemanager_main_categories'));
									$query->where('parent_id="'.$value->id.'"and published=1');
									$db->setQuery($query);
									$results2=			$db->loadObjectList();							
								?>
								<?php if ($results2): ?>
									<ul>
										<?php foreach ($results2 as $key => $detail): ?>
											<li>
												<p><a href="" title=""><?php echo $detail->title;?></a></p>
											</li>
										<?php endforeach ?>
									</ul>
								<?php endif ?>
							</li>
							<?php endif ?>
						
					<?php endforeach ?>
					</ul>
				</div>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-xs-6 right">
			<ul>
			<?php foreach ($rows as $key => $row): ?>
			<?php $link = 'index.php?option=com_vehiclemanager&amp;task=view_vehicle&amp;Itemid=4&amp;catid='. $row->catid. '&amp;id='.$row->id;?>
			<a href="<?php echo JRoute::_($link, false); ?>" >
				<li>
					<div class="product">
						<div class="product_image">
							
							<p><img src="<?php echo JUri::root();?>components/com_vehiclemanager/photos/<?php echo $row->image_link;?>" alt=""></p>
						</div>
						<div class="product_title">
							<p><?php echo $row->vmodel;?></p>
						</div>
					</div>
				</li>
			</a>
			<?php endforeach ?>				
			</ul>
			  <div class="row_02">
                <?php
                $paginations = $arr;
                if ($paginations && ( $pageNav->total > $pageNav->limit ))
                {
                    echo $pageNav->getPagesLinks();
                }
                ?>
        </div>
		</div>
	</div>
	<?php 
	// if ($rows) {
	// 	$session = JFactory::getSession();
	// 	$session->set('iditem', json_encode($rows));
		
	// }
	?>
	<script>
	jQuery(document).ready(function($) {

		
			$('.model-vehicle-menu > .left div .center ul li').each(function() {
			var t = $(this);
			t.find('a').click(function(event) {
				$('.model-vehicle-menu > .left div .center ul li p a').removeClass('active');
				t.find('a').addClass('active');
				event.preventDefault();
				var paramid=$(this).attr('href');
				 
				var rows=<?php echo json_encode($rows);?>;
				$.ajax({
					url: 'index.php?option=com_ajax&module=vehiclemanager_new_j3',
					type: 'post',					
					data: {
						data: paramid,
						row: rows,
						format: 'json'
					},
					success: function(data){						
						
						var result = $.parseJSON(data);
						$('.model-vehicle-menu > .right').html(result.data);
					}
				});					

			});
			
		});
	});
	</script>

	
