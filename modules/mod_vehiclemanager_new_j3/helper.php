<?php
class modVehiclemanagerNewJ3Helper{
	
	public static function getAjax(){
		
		$catid=$_POST["data"];
		$array=$_POST["row"];
		$myArray = json_decode($array);
		if (isset($array)) { 
			ob_start();
			echo '<ul>';
					foreach ($array as $key => $value)
					{

						// print_r($value);

						if ($value['catid']==$catid)
						{
							$link = 'index.php?option=com_vehiclemanager&amp;task=view_vehicle&amp;id=4&amp;catid='. $value['catid']. '&amp;Itemid='.$value['id'];
							echo'<a href="'.$link.'">';
							echo '<li>';
							echo '<div class="product">';
								echo '<div class="product_image">';
								echo '<p>'; 

								echo '<img src="'.JUri::root(true).'/components/com_vehiclemanager/photos/'.$value['image_link'].'" >';
								echo '</p>';
								echo '</div>';
								echo '<div class="product_title">';
								echo '<p>'.$value['vmodel'].'</p>';
								echo '</div>';

							echo '</div>';
							echo '</li>';
							echo '</a>';
						}	
						
					}
							
			echo'</ul>';
			$content = ob_get_clean();
			echo json_encode(array('data'=>$content));
			
		 } 
		die;

	}
}