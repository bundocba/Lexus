<?php
if (!defined('_VALID_MOS') && !defined('_JEXEC')) die('Direct Access to ' . basename(__FILE__) . ' is not allowed.');

/**
 *
 * @package  VehicleManager
 * @copyright 2012 Andrey Kvasnevskiy-OrdaSoft(akbet@mail.ru); Rob de Cleen(rob@decleen.com); 
 * Homepage: http://www.ordasoft.com
 * @version: 3.0 Pro
 * @license GNU General Public license version 2 or later; see LICENSE.txt
 * */
 
global $hide_js, $mainframe, $Itemid, $vehiclemanager_configuration, $mosConfig_live_site, $mosConfig_absolute_path, $my, $acl ;


$doc = JFactory::getDocument();
$doc->addStyleSheet($mosConfig_live_site . '/components/com_vehiclemanager/lightbox/css/lightbox.css');
$doc->addStyleSheet('components/com_vehiclemanager/TABS/tabcontent.css');
$doc->addStyleSheet($mosConfig_live_site . '/components/com_vehiclemanager/includes/vehiclemanager.css');
?>
<script type="text/javascript" src="<?php echo $mosConfig_live_site . '/components/com_vehiclemanager/lightbox/js/jQuerVEH-1.9.0.js'; ?>"></script> 
<script type="text/javascript"> jQuerVEH=jQuerVEH.noConflict(); </script>
<script type="text/javascript" src="<?php echo $mosConfig_live_site . '/components/com_vehiclemanager/lightbox/js/lightbox-2.6.min.js'; ?>"></script> 

<script type="text/javascript" src="<?php echo $mosConfig_live_site . '/components/com_vehiclemanager/includes/jquery.raty.js'; ?>"></script> 

<?php
$doc->addScript('components/com_vehiclemanager/TABS/tabcontent.js');
$vehiclemanager_configuration = $GLOBALS['vehiclemanager_configuration'];
if ($vehiclemanager_configuration['Location_vehicle']['show']) {
    $doc->addScript("http://maps.googleapis.com/maps/api/js?sensor=false");
    ?>
    <script type="text/javascript">
        setTimeout(function() {
            vm_initialize();
        },1000);
        function vm_initialize(){
            var map;
            var myLatlng=new google.maps.LatLng(<?php
    if ($vehicle->vlatitude && $vehicle->vlatitude != '')
        echo $vehicle->vlatitude;else
        echo 0;
    ?>,<?php
    if ($vehicle->vlongitude && $vehicle->vlongitude != '')
        echo $vehicle->vlongitude;else
        echo 0;
    ?>);
            var myOptions = {
                zoom: <?php if ($vehicle->map_zoom) echo $vehicle->map_zoom; else echo 1; ?>,
                center: myLatlng,
                scrollwheel: false,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.LARGE
                },
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("vm_map_canvas"), myOptions);
            var marker = new google.maps.Marker({ position: myLatlng });
            marker.setMap(map);
        }

    </script>
    <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
    <?php } ?>

<script language="javascript" type="text/javascript">

    function vm_review_submitbutton() {
        var form = document.review;
        // do field validation
        var rating_checked = false;
        for (c = 0;  c < form.rating.length; c++){
            if (form.rating[c].checked){
                rating_checked = true;
                form.rating.value = c ;
            }
        }
        if (form.title.value == "") {
            alert( "<?php echo _VEHICLE_MANAGER_INFOTEXT_JS_REVIEW_TITLE; ?>" );
        } else if (form.comment == "") {
            alert( "<?php echo _VEHICLE_MANAGER_INFOTEXT_JS_REVIEW_COMMENT; ?>" );
        } else if (! form.rating.value ) {
            alert( "<?php echo _VEHICLE_MANAGER_INFOTEXT_JS_REVIEW_RATING; ?>" );
        } else {
            form.submit();
        }
    }
    //*****************   begin add for show/hiden button "Add review" ********************
    function vm_button_hidden( is_hide ) {
        var el = document.getElementById('button_hidden_review');
        var el2 = document.getElementById('hidden_review');
        if(is_hide){
            el.style.display = 'none';
            el2.style.display = 'block';
        } else {
            el.style.display = 'block';
            el2.style.display = 'none';
        }
    }

    function vm_buying_request_submitbutton() {
        var form = document.buying_request;
        if (form.customer_name.value == "") {
            alert( "<?php echo _VEHICLE_MANAGER_INFOTEXT_JS_BUY_REQ_NAME; ?>" );
        } else if (form.customer_email.value == ""|| !vm_isValidEmail(form.customer_email.value)) {
            alert( "<?php echo _VEHICLE_MANAGER_INFOTEXT_JS_BUY_REQ_EMAIL; ?>" );
        } else if (form.customer_phone.value == ""||!vm_isValidPhoneNumber(form.customer_phone.value)){
            alert( "<?php echo _VEHICLE_MANAGER_INFOTEXT_JS_BUY_REQ_PHONE; ?>" );
        } else {
            form.submit();
        }
    }
    function vm_isValidPhoneNumber(str){

        myregexp = new RegExp("^([_0-9() -;,]*)$");
        mymatch = myregexp.exec(str);

        if(str == "")
            return false;
        if(mymatch != null)
            return true;
        return false;
    }
    function vm_isValidEmail(str) {
        return (str.indexOf("@") > 1);
    }

    //****************   end add for show/hiden button "Add buying"   *********************
    function vm_buy_vehicle( is_hide )
    {
        var el  = document.getElementById('hidden_buying');
        var el2 = document.getElementById('show_buying');
        if( is_hide ) {
            el.style.display = 'none';
            el2.style.display = 'block';
        } else {
            el.style.display = 'block';
            el2.style.display = 'none';
        }
    }
</script>
<?php positions_vm($params->get('view01')); ?>

<!-- main stylesheet ends, CC with new stylesheet below... -->

<!--[if IE]>
<style type="text/css">
  .basictable {
    zoom: 1;     /* triggers hasLayout */
    }  /* Only IE can see inside the conditional comment
    and read this CSS rule. Don't ever use a normal HTML
    comment inside the CC or it will close prematurely. */
</style>
<![endif]-->

<div style="overflow:hidden;">
    <div class="componentheading<?php echo $params->get('pageclass_sfx'); ?>">
        <h3><?php echo $currentcat->header; ?><h3>     
    </div>
<?php
  if ($params->get('show_pricerequest')) {
?>       
    <div id="currency_price">
  <?php
    if ($vehiclemanager_configuration['price_unit_show'] == '1'){
	echo "<div class=\"pricemoney\"><span class=\"money\">" . formatMoney($vehicle->price, true, $vehiclemanager_configuration['price_format']) . "</span>"; 
	echo "<span class=\"price\">&nbsp;" . $vehicle->priceunit . "</span></div>";
    }
    else {
	  echo "<div class=\"pricemoney\"><span class=\"price\">" . $vehicle->priceunit . "</span>";
	  echo "&nbsp;<span class=\"money\">" . formatMoney($vehicle->price, true, $vehiclemanager_configuration['price_format']) . "</span></div>"; 
     }
    foreach ($currencys_price as $key => $row) {
	    if ($vehicle->priceunit != $key){
	      if ($vehiclemanager_configuration['price_unit_show'] == '1'){
		  echo "<div class=\"pricemoney\"><span class=\"money\">" . formatMoney($row, true, $vehiclemanager_configuration['price_format']) . "</span>";
		  echo "<span class=\"price\">&nbsp;" . $key . "</span></div>";
	     }
	     else{
	      echo "<div class=\"pricemoney\"><span class=\"price\">" . $key . "</span>"; 
	      echo "&nbsp;<span class=\"money\">" . formatMoney($row, true, $vehiclemanager_configuration['price_format']) . "</span></div>";
	     }
    ?>
	<?php 
      }
	  }
    ?>
    </div>
  <?php 
   }
   ?>
</div>
                <!--Adding titles for tabs-->
<?php positions_vm($params->get('view02')); ?>
  <div class="basictable_26 basictable">
      <div class="row_01">
          <span class="col_01">
              <ul id="countrytabs" class="shadetabs">
                  <li><a href="#" rel="country1" class="selected"><?php echo _VEHICLE_MANAGER_HEADER_MAIN ?></a></li>
                  <li><a href="#" rel="country2"><?php echo _VEHICLE_MANAGER_HEADER_TECHNICAL_OPTIONS ?></a></li>
                  <?php
                  global $my, $acl;
                  $i = checkAccess_VM($GLOBALS['Location_vehicle_registrationlevel'], 'RECURSE', userGID_VM($my->id), $acl);

                  if (($GLOBALS['Location_vehicle_show']) && $i) {
                      ?>
                      <li>
                          <a href="#" rel="country4" onmouseup="setTimeout('vm_initialize()',10)"><?php echo _VEHICLE_MANAGER_HEADER_LOCATION ?>
                          </a>
                      </li>

                  <?php } ?>

                  <?php
                  $i = checkAccess_VM($GLOBALS['Reviews_vehicle_registrationlevel'], 'RECURSE', userGID_VM($my->id), $acl);

                  if (($GLOBALS['Reviews_vehicle_show']) && $i) {
                      ?>
                      <li><a href="#" rel="country6"><?php echo _VEHICLE_MANAGER_LABEL_REVIEWS ?></a></li>
                  <?php } ?>

                  <?php
                  if ($vehicle->listing_type == 1) {
                      if ($params->get('show_rentrequest') && $params->get('show_rentstatus') && $params->get('calendarlist_show')) {
                          ?>
                          <li><a href="#" rel="country7"><?php echo _VEHICLE_MANAGER_TAB_CALENDAR ?></a></li>

                          <?php
                      }
                  }
                  ?>
              </ul>
          </span>
        </div>
    </div>
                <!--end Adding titles for tabs-->
<?php positions_vm($params->get('view03')); ?>
    <div class="info_desc">
        <div id="country1" class="tabcontent">
            <div class="basictable_27 basictable">
                <div class="row_01">
                    <span class="col_01"><?php //echo $vehicle->vtitle;   ?></span>
                </div>
                <div class="row_02">
                            <?php
//for local images
                  if ($vehicle->image_link != '')
                      $imageURL = PHP_vehiclemanager::picture_thumbnail($vehicle->image_link, $vehiclemanager_configuration['fotomain']['high'], $vehiclemanager_configuration['fotomain']['width']);

                  if (isset($imageURL)) {
                      echo '<img alt="' . $vehicle->vtitle . '" title="' . $vehicle->vtitle . '" src="' . $mosConfig_live_site .
                      '/components/com_vehiclemanager/photos/' .
                      $imageURL . '"  >';
                  } else {

                      echo '<img alt="' . $vehicle->vtitle . '" title="' . $vehicle->vtitle . '" src="' .
                      $mosConfig_live_site . '/components/com_vehiclemanager/images/' .
                      _VEHICLE_MANAGER_NO_PICTURE_BIG .
                      '" height="' . $vehiclemanager_configuration['fotomain']['high'] . '"
  width="' . $vehiclemanager_configuration['fotomain']['width'] . '"  >';
                  }
                  ?>
      </div>

<?php if ($vehicle->maker != '') {
    ?>
                                <div class="row_03">
                                    <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_MAKER; ?></span>
                                    <span class="col_02"><?php echo $vehicle->maker; ?></span>
                                </div>


<?php } if ($vehicle->vmodel !== 0 && trim($vehicle->vmodel) !== "") { ?>
                                <div class="row_04">
                                    <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_MODEL; ?></span>
                                    <span class="col_02"><?php echo $vehicle->vmodel; ?></span>
                                </div>
                                <?php
                            }
                            $vtype[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                            $vtype1 = explode(',', _VEHICLE_MANAGER_OPTION_VEHICLE_TYPE);
                            $i = 1;
                            foreach ($vtype1 as $vtype2) {
                                $vtype[$i] = $vtype2;
                                $i++;
                            }
                            
                            if ($vehicle->vtype != 0) {
                                ?>
                                <div class="row_05" >
                                    <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_VEHICLE_TYPE; ?></span>
                                    <span class="col_02"><?php echo $vtype[$vehicle->vtype]; ?></span>
                                </div>

                                <?php
                            }                           
                            if ($vehicle->year != 0) {
                                ?>
                                <div class="row_07" >
                                    <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_ISSUE_YEAR; ?></span>
                                    <span class="col_02"><?php echo $vehicle->year; ?></span>
                                </div>

                                <?php
                            }
                            
                            $vcondition[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                            $vcondition1 = explode(',', _VEHICLE_MANAGER_OPTION_VEHICLE_CONDITION);
                            $i = 1;
                            foreach ($vcondition1 as $vcondition2) {
                                $vcondition[$i] = $vcondition2;
                                $i++;
                            }
                            if ($vehicle->vcondition != 0) {
                                ?>
                                <div class="row_08" >
                                    <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_CONDITION_STATUS; ?></span>
                                    <span class="col_02"><?php echo $vcondition[$vehicle->vcondition]; ?></span>
                                </div>
<?php } if (trim($vehicle->mileage)) { ?>
                                <div class="row_09" >
                                    <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_MILEAGE; ?></span>
                                    <span class="col_02"><?php echo $vehicle->mileage; ?></span>
                                </div>
<?php } if (trim($vehicle->vlocation)) { ?>

                                <div class="row_10">
                                    <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_ADDRESS; ?></span>
                                    <span class="col_02"><?php echo $vehicle->vlocation; ?></span>
                                </div>
<?php } if ($vehiclemanager_configuration['owner']['show'] && $vehicle->ownername != '' && $vehicle->owneremail != '') {
    ?>
                                <div class="row_11">
                                    <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_OWNER; ?></span>
                                    <span class="col_02"><?php echo $vehicle->ownername, ', ', $vehicle->owneremail; ?></span>
                                </div>
                                <?php
                            }
                            $listing_type[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                            $listing_type[1] = _VEHICLE_MANAGER_OPTION_FOR_RENT;
                            $listing_type[2] = _VEHICLE_MANAGER_OPTION_FOR_SALE;
                            if ($vehicle->listing_type != 0) {
                                ?>
                                <div class="row_12">
                                    <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_LISTING_TYPE; ?></span>
                                    <span class="col_02"><?php echo $listing_type[$vehicle->listing_type]; ?></span>
                                </div>
                                <?php
                            }
                            $listing_status[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                            $listing_status1 = explode(',', _VEHICLE_MANAGER_OPTION_LISTING_STATUS);
                            $i = 1;
                            foreach ($listing_status1 as $listing_status2) {
                                $listing_status[$i] = $listing_status2;
                                $i++;
                            }
                            if ($vehicle->listing_status != 0) {
                                ?>
                                <div class="row_13">
                                    <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_LISTING_STATUS; ?></span>
                                    <span clas="col_02"><?php echo $listing_status[$vehicle->listing_status]; ?></span>
                                 </div>
                   <?php } if ($vehicle->price > 0 && $params->get('show_pricerequest') ) { ?>
                                <div class="row_14">
                                    <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_PRICE; ?></span>
                                    <span class="col_02">
                                        <?php
                                        if ($vehiclemanager_configuration['price_unit_show'] == '1')
                                            if ($vehiclemanager_configuration['sale_separator'])
                                                echo formatMoney($vehicle->price, true, $vehiclemanager_configuration['price_format']), ' ', $vehicle->priceunit;
                                            else
                                                echo $vehicle->price, ' ', $vehicle->priceunit;
                                        else {
                                            if ($vehiclemanager_configuration['sale_separator'])
                                                echo $vehicle->priceunit, ' ', formatMoney($vehicle->price, true, $vehiclemanager_configuration['price_format']);
                                            else
                                                echo $vehicle->priceunit, ' ', $vehicle->price;
                                        }
                                        ?>
                                    </span>
                                </div>
<?php 
                                global $database;
                                $query = "SELECT * FROM #__vehiclemanager_rent_sal where fk_vehiclesid = " .($vehicle->id);
                                $database->setQuery($query);
                                $rentTerm = $database->loadObjectList();
                                if(isset($rentTerm[0]->special_price)) { 
                                ?>
                
                                <div class = "row_17">
                                    <span class="col_01"><?php echo _VEHICLE_MANAGER_RENT_SPECIAL_PRICE_PER_DAY; ?></span> 
                                    <p>:</p>    
                                        <table class="adminlist adminlist_04">
                                            <tr>
                                                <th class="title" width = "10%" ><?php echo _VEHICLE_MANAGER_FROM; ?></th>
                                                <th class="title" width = "10%" ><?php echo _VEHICLE_MANAGER_TO; ?></th>
                                                <th class="title" width = "20%" ><?php echo _VEHICLE_MANAGER_RENT_PRICE_PER_DAY; ?></th>
                                                <th class="title" ><?php echo _VEHICLE_MANAGER_LABEL_REVIEW_COMMENT; ?></th>
                                            </tr>
                                            <?php                                                
                                                for ($i = 0; $i < count($rentTerm); $i++) {        
                                            ?>
                                            <tr>
                                                <td align ='center'><?php echo $rentTerm[$i]->price_from; ?></td>
                                                <td align ='center'><?php echo $rentTerm[$i]->price_to; ?></td>
                                                <td align ='center'><?php echo $rentTerm[$i]->special_price. ' '.$rentTerm[$i]->priceunit; ?></td>
                                                <td><?php echo $rentTerm[$i]->comment_price; ?></td>                                        
                                            </tr>
                                            <?php } ?>  
                                        </table>
                                </div>
                                <?php } ?> 
                                <?php
                            }
                            $price_type[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                            $price_type1 = explode(',', _VEHICLE_MANAGER_OPTION_PRICE_TYPE);
                            $i = 1;
                            foreach ($price_type1 as $price_type2) {
                                $price_type[$i] = $price_type2;
                                $i++;
                            }
                            if ($vehicle->price_type != 0) {
                                ?>
                                <div class="row_15">
                                    <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_PRICE_TYPE; ?></span>
                                    <span class="col_02"><?php echo $price_type[$vehicle->price_type]; ?></span>
                                </div>
                            <?php } ?>

                            <?php
                            global $my, $acl, $Itemid;

                            $i = checkAccess_VM($vehiclemanager_configuration ['contacts']['registrationlevel'], 'RECURSE', userGID_VM($my->id), $acl);
                            if (($GLOBALS['contacts_show']) && $i && trim($vehicle->contacts)) {
                                ?>
                                <div class="row_16">
                                    <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_CONTACTS; ?></span>
                                    <span class="col_02"><?php echo $vehicle->contacts; ?></span>
                                </div>
                            <?php } 
                                 if ($params->get('show_edocsrequest') && $vehicle->edok_link != null) {
                                    $session = JFactory::getSession();
                                    $sid = $session->getId();
                                    $session->set("ssmid", $sid);
                                    setcookie('ssd', $sid, time() + 60 * 60 * 24, "/");
                                    ?>
                                    <div class="row_18">
                                        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_EDOCUMENT; ?></span>
                                        <span class="col_02">
                                            <a href="<?php echo sefRelToAbs('index.php?option=com_vehiclemanager&amp;task=mdownload&amp;id=' . $vehicle->id . '&amp;Itemid=' . $Itemid); ?>" target="blank">
    <?php echo _VEHICLE_MANAGER_LABEL_EDOCUMENT_DOWNLOAD; ?>
                                            </a>
                                        </span>
                                    </div>

<?php } if (trim($vehicle->description)) {
    ?>
                                    <div class="row_06">
                                        <span class="col_01"><?php 
                                        echo _VEHICLE_MANAGER_LABEL_COMMENT; ?></span>
                                        <span clas="col_02"><?php 
                                        positions_vm ($vehicle->description); ?></span>
                                    </div>
                                    <?php
                                } if ($vehicle->year != 0) {
                                    ?>

                                    <?php
                                } //end if
                                ?>          
                            </div>
                        </div><!--END Main Information-->

                        <div id="country2" class="tabcontent"> <!--Technical options-->
                            <div class="basictable_28 basictable">
<?php if (trim($vehicle->vehicleid)) { ?>
                                    <div class="row_01">
                                        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_VEHICLEID; ?>:</span>
                                        <span class="col_02"><?php echo $vehicle->vehicleid; ?></span>
                                    </div>
<?php } if (trim($vehicle->vtitle)) { ?>
                                    <div class="row_02">
                                        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_TITLE; ?>:</span>
                                        <span class="col_02"><?php echo $vehicle->vtitle; ?></span>
                                    </div>
                                    <?php
                                }
                                if (trim($vehicle->description)) {
                                    ?> 
                                    <div class="row_03">
                                        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_COMMENT; ?>:</span>
                                        <span class="col_02"><?php positions_vm ($vehicle->description); ?></span>
                                    </div>
                                    <?php
                                }
                                if ($vehicle->year != 0) {
                                    ?> 
                                    <div class="row_04">
                                        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_ISSUE_YEAR; ?>:</span>
                                        <span class="col_02"><?php echo $vehicle->year; ?></span>
                                    </div>
<?php } if (trim($vehicle->vlocation)) {
    ?> 
                                    <div class="row_05">
                                        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_ADDRESS; ?>:</span>
                                        <span class="col_02"><?php echo $vehicle->vlocation; ?></span>
                                    </div>
<?php } if (trim($vehicle->country)) { ?>
                                    <div class="row_06">
                                        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_COUNTRY; ?></span>
                                        <span class="col_02"><?php echo $vehicle->country; ?></span>
                                    </div>
<?php } if (trim($vehicle->region)) { ?>
                                    <div class="row_07">
                                        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_REGION; ?></span>
                                        <span class="col_02"><?php echo $vehicle->region; ?></span>
                                    </div>
<?php } if (trim($vehicle->city)) { ?>
                                    <div class="row_08">
                                        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_CITY; ?></span>
                                        <span class="col_02"><?php echo $vehicle->city; ?></span>
                                    </div>                                        
<?php } if (trim($vehicle->district)) { ?>
                                    <div class="row_09">
                                        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_DISTRICT; ?></span>
                                        <span class="col_02"><?php echo $vehicle->district; ?></span>
                                    </div>
<?php } if (trim($vehicle->zipcode)) { ?>
                                    <div class="row_10">
                                        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_ZIPCODE; ?></span>
                                        <span class="col_02"><?php echo $vehicle->zipcode; ?></span>
                                    </div>
<?php } if (trim($vehicle->mileage)) { ?>
                                    <div class="row_11">
                                        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_MILEAGE; ?>:</span>
                                        <span class="col_02"><?php echo $vehicle->mileage; ?></span>
                                    </div>
                                    <?php
                                }
                                $listing_type[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                                $listing_type[1] = _VEHICLE_MANAGER_OPTION_FOR_RENT;
                                $listing_type[2] = _VEHICLE_MANAGER_OPTION_FOR_SALE;
                                if ($vehicle->listing_type != 0) {
                                    ?>
                                    <div class="row_12">
                                        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_LISTING_TYPE; ?>:</span>
                                        <span class="col_02"><?php echo $listing_type[$vehicle->listing_type]; ?></span>
                                    </div>
                                    <?php
                                }
                                $listing_status[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                                $listing_status1 = explode(',', _VEHICLE_MANAGER_OPTION_LISTING_STATUS);
                                $i = 1;
                                foreach ($listing_status1 as $listing_status2) {
                                    $listing_status[$i] = $listing_status2;
                                    $i++;
                                }
                                if ($vehicle->listing_status != 0) {
                                    ?>
                                    <div class="row_13">
                                        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_LISTING_STATUS; ?>:</span>
                                        <span class="col_02"><?php echo $listing_status[$vehicle->listing_status]; ?></span>
                                    </div>
                                    <?php
                                }
                                if ($params->get('show_pricerequest') > 0) {
                                    if (trim($vehicle->price)) {
                                        ?>
                                        <div class="row_14">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_PRICE; ?>:</span>
                                            <span class="col_02">
                                                <?php
                                                if ($vehiclemanager_configuration['price_unit_show'] == '1')
                                                    if ($vehiclemanager_configuration['sale_separator'])
                                                        echo formatMoney($vehicle->price, true, $vehiclemanager_configuration['price_format']), ' ', $vehicle->priceunit;
                                                    else
                                                        echo $vehicle->price, ' ', $vehicle->priceunit;
                                                else {
                                                    if ($vehiclemanager_configuration['sale_separator'])
                                                        echo $vehicle->priceunit, ' ', formatMoney($vehicle->price, true, $vehiclemanager_configuration['price_format']);
                                                    else
                                                        echo $vehicle->priceunit, ' ', $vehicle->price;
                                                }
                                                ?>
                                            </span>
                                        </div>
                                        <?php
                                    }
                                    $price_type[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                                    $price_type1 = explode(',', _VEHICLE_MANAGER_OPTION_PRICE_TYPE);
                                    $i = 1;
                                    foreach ($price_type1 as $price_type2) {
                                        $price_type[$i] = $price_type2;
                                        $i++;
                                    }
                                    if ($vehicle->price_type != 0) {
                                        ?>
                                        <div class="row_15">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_PRICE_TYPE; ?>:</span>
                                            <span class="col_02"><?php echo $price_type[$vehicle->price_type]; ?> </span>
                                        </div>
                                        <?php
                                    }
                                }
                                $i = checkAccess_VM($vehiclemanager_configuration ['contacts']['registrationlevel'], 'RECURSE', userGID_VM($my->id), $acl);
                                if (($GLOBALS['contacts_show']) && $i && trim($vehicle->contacts)) {
                                    ?>
                                    <div class="row_16">
                                        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_CONTACTS; ?>:</span>
                                        <span class="col_02"><?php echo $vehicle->contacts; ?></span>
                                    </div>
                                    <?php
                                }
                                $num = 0;
                            if ($vehicle->listing_type == 1) {

                                $database = JFactory::getDBO();
                                $select = "SELECT rent_from , rent_until FROM #__vehiclemanager_rent AS a " .
                                        "WHERE fk_vehicleid=" . $vehicle->id . " AND rent_return IS NULL";
                                $database->setQuery($select);
                                $rents = $database->loadObjectList();
                                $num = count($rents);
                                if ($num > 0) {
                                    ?>

                                    <div class="row_17">
                                        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_RENT_FROM_UNTIL; ?>:</span>    
                                        <?php
                                        for ($e = 0, $m = count($rents); $e < $m; $e++) {
                                            print ("<span class=\"col_02\">");
                                            $date = data_transform_vm($rents[$e]->rent_from) . " => " . data_transform_vm($rents[$e]->rent_until);
                                            print_r($date);
                                            print ("</span>");
                                         }
                                        ?></div><?php
                                    }
                                }
                                    ?>
                                    <?php
                                    if (trim($vehicle->engine)) {
                                        ?>
                                        <div class="row_18">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_ENGINE_TYPE; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->engine; ?></span>
                                        </div>
                                        <?php
                                    }
                                    $transmission[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                                    $transmission1 = explode(',', _VEHICLE_MANAGER_OPTION_TRANSMISSION);
                                    $i = 1;
                                    foreach ($transmission1 as $transmission2) {
                                        $transmission[$i] = $transmission2;
                                        $i++;
                                    }
                                    if ($vehicle->transmission != 0) {
                                        ?>
                                        <div class="row_19">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_TRANSMISSION_TYPE; ?>:</span>
                                            <span class="col_02"><?php echo $transmission[$vehicle->transmission]; ?> </span>
                                        </div>
                                        <?php
                                    }
                                    $drive_type[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                                    $drive_type1 = explode(',', _VEHICLE_MANAGER_OPTION_DRIVE_TYPE);
                                    $i = 1;
                                    foreach ($drive_type1 as $drive_type2) {
                                        $drive_type[$i] = $drive_type2;
                                        $i++;
                                    }
                                    if ($vehicle->drive_type != 0) {
                                        ?>
                                        <div class="row_20">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_DRIVE_TYPE; ?>:</span>
                                            <span class="col_02"><?php echo $drive_type[$vehicle->drive_type]; ?></span>
                                        </div>
                                        <?php
                                    }
                                    $numcylinder[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                                    $numcylinder1 = explode(',', _VEHICLE_MANAGER_OPTION_NUMBER_OF_CYLINDERS);
                                    $i = 1;
                                    foreach ($numcylinder1 as $numcylinder2) {
                                        $numcylinder[$i] = $numcylinder2;
                                        $i++;
                                    }
                                    if ($vehicle->cylinder != 0) {
                                        ?>
                                        <div class="row_21">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_NUMBER_CYLINDERS; ?>:</span>
                                            <span class="col_02"><?php echo $numcylinder[$vehicle->cylinder]; ?></span>
                                        </div>
                                        <?php
                                    }
                                    $numspeed[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                                    $numspeed1 = explode(',', _VEHICLE_MANAGER_OPTION_NUMBER_OF_SPEEDS);
                                    $i = 1;
                                    foreach ($numspeed1 as $numspeed2) {
                                        $numspeed[$i] = $numspeed2;
                                        $i++;
                                    }
                                    if ($vehicle->num_speed != 0) {
                                        ?>
                                        <div class="row_22">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_NUMBER_SPEEDS; ?>:</span>
                                            <span class="col_02"><?php echo $numspeed[$vehicle->num_speed]; ?></span>
                                        </div>
                                        <?php
                                    }
                                    $fuel_type[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                                    $fuel_type1 = explode(',', _VEHICLE_MANAGER_OPTION_FUEL_TYPE);
                                    $i = 1;
                                    foreach ($fuel_type1 as $fuel_type2) {
                                        $fuel_type[$i] = $fuel_type2;
                                        $i++;
                                    }
                                    if ($vehicle->fuel_type != 0) {
                                        ?>
                                        <div class="row_23">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_FUEL_TYPE; ?>:</span>
                                            <span class="col_02"><?php echo $fuel_type[$vehicle->fuel_type]; ?></span>
                                        </div>
                                        <?php
                                    }
                                    if (trim($vehicle->city_fuel_mpg)) {
                                        ?>

                                        <div class="row_24">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_CITY_FUEL_MPG; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->city_fuel_mpg; ?></span>
                                        </div>
                                        <?php
                                    }

                                    if (trim($vehicle->highway_fuel_mpg)) {
                                        ?>
                                        <div class="row_25">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_HIGHWAY_FUEL_MPG; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->highway_fuel_mpg; ?></span>
                                        </div>
                                        <?php
                                    }

                                    if (trim($vehicle->wheelbase)) {
                                        ?>
                                        <div class="row_26">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_WHEELBASE; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->wheelbase; ?></span>
                                        </div>
                                        <?php
                                    }

                                    if (trim($vehicle->wheeltype)) {
                                        ?>
                                        <div class="row_27">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_WHEELTYPE; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->wheeltype; ?></span>
                                        </div>
                                        <?php
                                    }

                                    if (trim($vehicle->rear_axe_type)) {
                                        ?>
                                        <div class="row_28">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_REARAXE_TYPE; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->rear_axe_type; ?></span>
                                        </div>
                                        <?php
                                    }

                                    if (trim($vehicle->brakes_type)) {
                                        ?>
                                        <div class="row_29">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_BRAKES_TYPE; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->brakes_type; ?></span>
                                        </div>

                                        <?php
                                    }

                                    if (trim($vehicle->exterior_color)) {
                                        ?>
                                        <div class="row_30">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_EXTERIOR_COLORS; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->exterior_color; ?></span>
                                        </div>

                                        <?php
                                    }
                                    $numdoors[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                                    $numdoors1 = explode(',', _VEHICLE_MANAGER_OPTION_NUMBER_OF_DOORS);
                                    $i = 1;
                                    foreach ($numdoors1 as $numdoors2) {
                                        $numdoors[$i] = $numdoors2;
                                        $i++;
                                    }
                                    if ($vehicle->doors != 0) {
                                        ?>
                                        <div class="row_31">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_NUMBER_DOORS; ?>:</span>
                                            <span class="col_02"><?php echo $numdoors[$vehicle->doors]; ?></span>
                                        </div>
                                        <?php
                                    }

                                    if (trim($vehicle->exterior_amenities)) {
                                        ?>
                                        <div class="row_32">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_EXTERIOR_EXTRAS; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->exterior_amenities; ?></span>
                                        </div>

                                        <?php
                                    }

                                    if (trim($vehicle->interior_color)) {
                                        ?>
                                        <div class="row_34">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_INTERIOR_COLORS; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->interior_color; ?></span>
                                        </div>
                                        <?php
                                    }

                                    if (trim($vehicle->seating)) {
                                        ?>
                                        <div class="row_35">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_NUMBER_SEATINGS; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->seating; ?></span>
                                        </div>
                                        <?php
                                    }

                                    if (trim($vehicle->dashboard_options)) {
                                        ?>
                                        <div class="row_36">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_DASHBOARD_OPTIONS; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->dashboard_options; ?></span>
                                        </div>
                                        <?php
                                    }

                                    if (trim($vehicle->interior_amenities)) {
                                        ?>
                                        <div class="row_37">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_INTERIOR_EXTRAS; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->interior_amenities; ?> </span>
                                        </div>
                                        <?php
                                    }

                                    if (trim($vehicle->safety_options)) {
                                        ?>
                                        <div class="row_38">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_SAFETY_OPTIONS; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->safety_options; ?> </span>
                                        </div>

                                        <?php
                                    }
                                    if (trim($vehicle->w_basic) || trim($vehicle->w_drivetrain) || trim($vehicle->w_corrosion)) {
                                        ?>
                                        <div class="row_39"><h4><?php echo _VEHICLE_MANAGER_LABEL_WARRANTY_OPTIONS; ?></h4></div>
                                        <?php
                                    }
                                    if (trim($vehicle->w_basic)) {
                                        ?>

                                        <div class="row_40">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_WARRANTY_BASIC; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->w_basic; ?> </span>
                                        </div>
                                        <?php
                                    }
                                    if (trim($vehicle->w_drivetrain)) {
                                        ?>
                                        <div class="row_41">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_WARRANTY_DRIVETRAIN; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->w_drivetrain; ?> </span>
                                        </div>

                                        <?php
                                    }

                                    if (trim($vehicle->w_corrosion)) {
                                        ?>
                                        <div class="row_42">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_WARRANTY_CORROSION; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->w_corrosion; ?> </span>
                                        </div>
                                        <?php
                                    }

                                    if (trim($vehicle->w_roadside_ass)) {
                                        ?>

                                        <div class="row_43">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_WARRANTY_ROADSIDE_ASSISTANCE; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->w_roadside_ass; ?> </span>
                                        </div>

                                        <?php
                                    }
                                    if (count($vehicle_feature)) {
                                        ?>
                                        <div class="row_44">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_FEATURED_MANAGER_FEATURE; ?>:</span>
                                            <span class="col_02">
                                                <?php
                                                for ($i = 0; $i < count($vehicle_feature); $i++) {
                                                    if ($vehiclemanager_configuration['manager_feature_category'] == 1) {
                                                        if ($i != 0) {
                                                            if ($vehicle_feature[$i]->categories !== $vehicle_feature[$i - 1]->categories)
                                                                echo "<br><strong>" . $vehicle_feature[$i]->categories . ": </strong><br>";
                                                        } else
                                                            echo "<br><strong>" . $vehicle_feature[$i]->categories . ": </strong><br>";
                                                    }
                                                    if ($vehiclemanager_configuration['manager_feature_image'] == 1 and $vehicle_feature[$i]->image_link != '') {
                                                        ?>       
                                                        <img alt="photo" src="<?php echo "$mosConfig_live_site/components/com_vehiclemanager/featured_ico/" . $vehicle_feature[$i]->image_link; ?>"></img>      
                                                        <?php
                                                    }
                                                    echo $vehicle_feature[$i]->name." ,";
                                                    ?>


                                        <?php } ?>
                                            </span>
                                        </div>
<?php } ?>
<?php if ($vehiclemanager_configuration['extra1'] == 1 && $vehicle->extra1 != "") { ?>
                                        <div class="row_45">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA1; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->extra1; ?></span>
                                        </div>
                                        <?php
                                    }
                                    if ($vehiclemanager_configuration['extra2'] == 1 && $vehicle->extra2 != "") {
                                        ?>
                                        <div class="row_46">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA2; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->extra2; ?></span>
                                        </div>
                                        <?php
                                    }
                                    if ($vehiclemanager_configuration['extra3'] == 1 && $vehicle->extra3 != "") {
                                        ?>
                                        <div class="row_47">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA3; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->extra3; ?></span>
                                        </div>
                                        <?php
                                    }
                                    if ($vehiclemanager_configuration['extra4'] == 1 && $vehicle->extra4 != "") {
                                        ?>
                                        <div class="row_48">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA4; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->extra4; ?></span>
                                        </div>
                                        <?php
                                    }
                                    if ($vehiclemanager_configuration['extra5'] == 1 && $vehicle->extra5 != "") {
                                        ?>
                                        <div class="row_49">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA5; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->extra5; ?></span>
                                        </div>
                                        <?php
                                    }
                                    if ($vehiclemanager_configuration['extra6'] == 1 && $vehicle->extra6 > 0) {
                                        $extra1 = explode(',', _VEHICLE_MANAGER_EXTRA6_SELECTLIST);
                                            $i = 1;
                                        foreach($extra1 as $extra2) {
                                            $extra[$i] = $extra2;
                                            $i++;
                                        }
                                        ?>
                                        <div class="row_50">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA6; ?>:</span>
                                            <span class="col_02"><?php echo $extra[$vehicle->extra6]; ?></span>
                                        </div>
                                        <?php
                                    }
                                    if ($vehiclemanager_configuration['extra7'] == 1 && $vehicle->extra7 > 0) {
                                        $extra1 = explode(',', _VEHICLE_MANAGER_EXTRA7_SELECTLIST);
                                            $i = 1;
                                        foreach($extra1 as $extra2) {
                                            $extra[$i] = $extra2;
                                            $i++;
                                        }
                                        ?>
                                        <div class="row_51">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA7; ?>:</span>
                                            <span class="col_02"><?php echo $extra[$vehicle->extra7]; ?></span>
                                        </div>
                                        <?php
                                    }
                                    if ($vehiclemanager_configuration['extra8'] == 1 && $vehicle->extra8 > 0) {
                                        $extra1 = explode(',', _VEHICLE_MANAGER_EXTRA8_SELECTLIST);
                                            $i = 1;
                                        foreach($extra1 as $extra2) {
                                            $extra[$i] = $extra2;
                                            $i++;
                                        }
                                        ?>
                                        <div class="row_52">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA8; ?>:</span>
                                            <span class="col_02"><?php echo $extra[$vehicle->extra8]; ?></span>
                                        </div>
                                        <?php
                                    }
                                    if ($vehiclemanager_configuration['extra9'] == 1 && $vehicle->extra9 > 0) {
                                        $extra1 = explode(',', _VEHICLE_MANAGER_EXTRA9_SELECTLIST);
                                            $i = 1;
                                        foreach($extra1 as $extra2) {
                                            $extra[$i] = $extra2;
                                            $i++;
                                        }
                                        ?>
                                        <div class="row_53">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA9; ?>:</span>
                                            <span class="col_02"><?php echo $extra[$vehicle->extra9]; ?></span>
                                        </div>
                                        <?php
                                    }
                                    if ($vehiclemanager_configuration['extra10'] == 1 && $vehicle->extra10 > 0) {
                                        $extra1 = explode(',', _VEHICLE_MANAGER_EXTRA10_SELECTLIST);
                                            $i = 1;
                                        foreach($extra1 as $extra2) {
                                            $extra[$i] = $extra2;
                                            $i++;
                                        }
                                        ?>
                                        <div class="row_54">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA10; ?>:</span>
                                            <span class="col_02"><?php echo $extra[$vehicle->extra10]; ?></span>
                                        </div>
<?php } ?>
                                </div>
                            </div> <!-- End Technical options -->

                            <div id="country3" class="tabcontent">
                                <!--Exterior/Interior options-->
                                <div class="basictable_29 basictable">
<?php if (trim($vehicle->exterior_color)) { ?>
                                        <div class="row_01">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_EXTERIOR_COLORS; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->exterior_color; ?> </span>
                                        </div>
                                        <?php
                                    }

                                    if ($vehicle->doors != 0) {
                                        ?>
                                        <div class="row_02">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_NUMBER_DOORS; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->doors; ?></span>
                                        </div>
                                        <?php
                                    }

                                    if (trim($vehicle->exterior_amenities)) {
                                        ?>
                                        <div class="row_03">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_EXTERIOR_EXTRAS; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->exterior_amenities; ?></span>
                                        </div>
                                        <?php
                                    }

                                    if (trim($vehicle->interior_color)) {
                                        ?>
                                        <div class="row_05">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_INTERIOR_COLORS; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->interior_color; ?> </span>
                                        </div>
                                        <?php
                                    }

                                    if (trim($vehicle->seating)) {
                                        ?>
                                        <div class="row_06">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_NUMBER_SEATINGS; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->seating; ?> </span>
                                        </div>
                                        <?php
                                    }

                                    if (trim($vehicle->dashboard_options)) {
                                        ?>
                                        <div class="row_07">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_DASHBOARD_OPTIONS; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->dashboard_options; ?></span>
                                        </div>
                                        <?php
                                    }

                                    if (trim($vehicle->interior_amenities)) {
                                        ?>
                                        <div class="row_08">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_INTERIOR_EXTRAS; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->interior_amenities; ?> </span>
                                        </div>
<?php } ?> 
                                </div>
                            </div><!-- End Exterior/Interior options-->

                            <div id="country4" class="tabcontent"> <!--Location-->
                            <!--<table>    -->

                                <!--Google map -->
<?php if ($vehicle->vlatitude && $vehicle->vlongitude) {
    ?>
                                    <div class="basictable_30 basictable">
                                        <div class="row_01">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_LATITUDE; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->vlatitude; ?></span>
                                        </div>
                                        <div class="row_02">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_LONGITUDE; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->vlongitude; ?></span>
                                        </div>
                                        <div class="row_03">

                                            <span class="col_01">
                                                <div id="vm_map_canvas" class="vm_map_canvas_04"></div>
                                                <!--Image google map-->
                                            </span>
                                        </div>
                                    </div>
<?php } else { ?>
                                    <div class="basictable_31 basictable">
                                        <div class="row_01">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_NO_LOCATION_AVAILABLE; ?></span>
                                        </div>
                                    </div>
<?php } ?>
                            </div> <!--End Location -->
                            <div id="country5" class="tabcontent"> <!--Safety/Warranty options-->
                                <div class="basictable_32 basictable">
				    <?php if (trim($vehicle->safety_options)) { ?>
                                        <div class="row_01">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_SAFETY_OPTIONS; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->safety_options; ?> </span>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    if (trim($vehicle->w_basic) || trim($vehicle->w_drivetrain) || trim($vehicle->w_corrosion)
                                            || trim($vehicle->w_roadside_ass)) {
                                        ?>
                                        <div class="row_02">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_WARRANTY_OPTIONS; ?></span>
                                        </div>

                                    <?php } ?>
					<?php if (trim($vehicle->w_basic)) { ?>
                                        <div class="row_03">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_WARRANTY_BASIC; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->w_basic; ?></span>
                                        </div>
                                    <?php } ?>
					  <?php if (trim($vehicle->w_drivetrain)) { ?>
                                        <div class="row_04">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_WARRANTY_DRIVETRAIN; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->w_drivetrain; ?> </span>
                                        </div>
					<?php } ?>
					<?php if (trim($vehicle->w_corrosion)) { ?>
                                        <div class="row_05">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_WARRANTY_CORROSION; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->w_corrosion; ?></span>
                                        </div>
                                    <?php } ?>
					<?php if (trim($vehicle->w_roadside_ass)) { ?>
                                        <div class="row_06">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_WARRANTY_ROADSIDE_ASSISTANCE; ?>:</span>
                                            <span class="col_02"><?php echo $vehicle->w_roadside_ass; ?></span>
                                        </div>
				    <?php } ?>
                                </div>
                            </div> <!--End Safety/Warranty options -->

        <!--Reviews-->
      <div id="country6" class="tabcontent">
       <?php
//show the reviews
       if ($params->get('show_reviews')) {
       if ($reviews = $vehicle->getReviews()) {
          ?>
         <br />
        <div class="componentheading<?php echo $params->get('pageclass_sfx'); ?>">
          <?php echo _VEHICLE_MANAGER_LABEL_REVIEWS; ?>
        </div>

        <div id="user_reviews">
          <?php
            if ($reviews != null && count($reviews) > 0) {
           for ($m = 0, $n = count($reviews); $m < $n; $m++) {
                $review = $reviews[$m];
                 ?>
     <div class="box_comment">
         
	  <div class="user_name"><?php echo $review->user_name; ?></div>
      <span class="arrow_up_comment"></span>
      
     <div class="head_comment">
      <div class="title_rating">
            <span class="col_title_rev"><?php echo $review->title; ?></span>
	    <span class="col_rating_rev">
	      <img src="./components/com_vehiclemanager/images/rating-<?php echo $review->rating; ?>.png" 
	      alt="<?php echo ($review->rating) / 2; ?>" border="0" align="right"/>
	    </span>
      </div>
     <div class="row_comment">
	  <span class="quotes_before"></span><?php echo $review->comment; ?><span class="quotes_after"></span>
     </div>
     <div class="date">
          <span class="date_format"><?php echo data_transform_vm($review->date); ?></span>
     </div>
     </div>
     </div>
        <?php
        }
       }
        ?>
         </div>
            <?php
                   }
                else
              echo "No reviews for vehicle"; //end if( $reviews = $vehicle->getReviews())
            }
     ?> <!-- end if( $params->get('show_reviews')) -->

                            </div>
                            <?php
                            if ($vehicle->listing_type == 1) {
                                if ($params->get('show_rentrequest') && $params->get('show_rentstatus') && $params->get('calendarlist_show')) {
                                    ?>
                                    <div id="country7" class="tabcontent">
                                        <div style="text-align: center;" >
                                            <?php
                                            if (isset($_POST['month']) && isset($_POST['year'])) {
                                                $month = $_POST['month'];
                                                $year = $_POST['year'];
                                                $calendar = PHP_vehiclemanager::getCalendar($month, $year, $vehicle->id);
                                            } else {
                                                $month = date("m", mktime(0, 0, 0, date('m'), 1, date('Y')));
                                                $year = date("Y", mktime(0, 0, 0, date('m'), 1, date('Y')));
                                                $calendar = PHP_vehiclemanager::getCalendar($month, $year, $vehicle->id);
                                            }
                                            ?>
                                            <h4><?php echo _VEHICLE_MANAGER_LABEL_CALENDAR_TITLE; ?></h4>

                                            <form action="" method="post" id="calendar" name="calendar" >    

                                                <select name="month" class="inputbox" onChange="form.submit()">
                                                    <option value="1" <?php if ($month == '1') echo "selected" ?> ><?php echo JText::_('JANUARY'); ?></option>
                                                    <option value="2" <?php if ($month == '2') echo "selected" ?> ><?php echo JText::_('FEBRUARY'); ?></option>
                                                    <option value="3" <?php if ($month == '3') echo "selected" ?> ><?php echo JText::_('MARCH'); ?></option>
                                                    <option value="4" <?php if ($month == '4') echo "selected" ?> ><?php echo JText::_('APRIL'); ?></option>
                                                    <option value="5" <?php if ($month == '5') echo "selected" ?> ><?php echo JText::_('MAY'); ?></option>
                                                    <option value="6" <?php if ($month == '6') echo "selected" ?> ><?php echo JText::_('JUNE'); ?></option>
                                                    <option value="7" <?php if ($month == '7') echo "selected" ?> ><?php echo JText::_('JULY'); ?></option>
                                                    <option value="8" <?php if ($month == '8') echo "selected" ?> ><?php echo JText::_('AUGUST'); ?></option>
                                                    <option value="9" <?php if ($month == '9') echo "selected" ?> ><?php echo JText::_('SEPTEMBER'); ?></option>
                                                    <option value="10" <?php if ($month == '10') echo "selected" ?> ><?php echo JText::_('OCTOBER'); ?></option>
                                                    <option value="11" <?php if ($month == '11') echo "selected" ?> ><?php echo JText::_('NOVEMBER'); ?></option>
                                                    <option value="12" <?php if ($month == '12') echo "selected" ?> ><?php echo JText::_('DECEMBER'); ?></option>
                                                </select>
                                                <select name="year" class="inputbox"  onChange="form.submit()">
                                                    <option value="2012" <?php if ($year == '2012') echo "selected" ?> >2012</option>
                                                    <option value="2013" <?php if ($year == '2013') echo "selected" ?> >2013</option>
                                                    <option value="2014" <?php if ($year == '2014') echo "selected" ?> >2014</option>
                                                    <option value="2015" <?php if ($year == '2015') echo "selected" ?> >2015</option>
                                                    <option value="2016" <?php if ($year == '2016') echo "selected" ?> >2016</option>
                                                    <option value="2017" <?php if ($year == '2017') echo "selected" ?> >2017</option>
                                                </select>
                                            </form>
                                            <style type="text/css">
                                                .tableC td {
                                                    border:none;
                                                }
                                                .tableC tr {
                                                    border:none;
                                                }

                                                .tableC {
                                                    border:none;
                                                }

                                            </style>
                                            <div class="tableC basictable">
                                                <div class="row_01">
                                                    <span class="col_01"><?php echo $calendar->tab1; ?></span>
                                                    <span class="col_02"><?php echo $calendar->tab2; ?></span>
                                                    <span class="col_03"><?php echo $calendar->tab3; ?></span>
                                                </div>

                                                <div class="row_02">
                                                    <span class="col_01"><?php echo $calendar->tab21; ?></span>
                                                    <span class="col_02"><?php echo $calendar->tab22; ?></span>
                                                    <span class="col_03"><?php echo $calendar->tab23; ?><br /></span>
                                                </div>

                                                <div class="calendar_notation row_03">
						   <div class="row_calendar">
                                                     <span class="label_calendar_available"><?php echo _VEHICLE_MANAGER_LABEL_CALENDAR_AVAILABLE; ?></span>
                                                     <div class="calendar_available_notation"></div>
						    </div>

      						   <div class="row_calendar">
                                                     <span class="label_calendar_available"><?php echo _VEHICLE_MANAGER_LABEL_CALENDAR_NOT_AVAILABLE; ?></span>
                                                     <div class="calendar_not_available_notation"></div>
                                                </div>

                                              </div>
                                            </div>

                                        </div>
                                        <!--***********************************************************************************************************************-->
                                    </div>   
                                    <?php
                                }
                            }
                            ?>
                        </div> <!--end all tabs -->
                        <?php
                        if ($vehicle->listing_type == 1) {

                            global $option;
                            if ($option != 'com_vehiclemanager') {
                                $form_action = "index.php?option=" . $option .
                                        "&amp;" . 
                                        "task=rent_request_vehicle&tab=getmyvehiclesTab&is_show_data=1&Itemid=" .
                                        $Itemid;
                            }
                            else
                                $form_action = "index.php?option=com_vehiclemanager&amp;" . 
                                    "task=rent_request_vehicle&amp;Itemid=" . $Itemid 
                            ?>

                            <form action="<?php echo sefRelToAbs($form_action); ?>" method="post" name="vehicle">
			    <?php } ?>                     
                            <script type="text/javascript">
                                var countries=new ddtabcontent("countrytabs")
                                countries.setpersist(true)
                                countries.setselectedClassTarget("link") //"link" or "linkparent"
                                countries.init()
                            </script>
                                <?php positions_vm($params->get('view04')); ?>
                            <div class="basictable_34 basictable">
				<?php if (count($vehicle_photos) > 0) { ?>
                                    <div class="row_01">
                                        <span class="col_01">
                                            <div class="componentheading<?php echo $params->get('pageclass_sfx'); ?>" >
                                                <h3><?php echo _VEHICLE_MANAGER_HEADER_PHOTOGALERY; ?></h3>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="row_02">
                                        <?php for ($i = 0; $i < count($vehicle_photos); $i++) { ?>
                                            <div class="thumbnail viewcar" style="width: <?php echo $vehiclemanager_configuration['fotogal']['width'];?>px; height: <?php echo $vehiclemanager_configuration['fotogal']['high'];?>px;" >
                                                <a href="<?php echo $mosConfig_live_site; ?>/components/com_vehiclemanager/photos/<?php echo PHP_vehiclemanager::picture_thumbnail($vehicle_photos[$i]->main_img, $vehiclemanager_configuration['fotoupload']['high'], $vehiclemanager_configuration['fotoupload']['width']); ?>" rel="lightbox[img]" title="photo" >
                                                    <img alt="<?php echo $vehicle->vtitle; ?>" title="<?php echo $vehicle->vtitle; ?>" src="./components/com_vehiclemanager/photos/<?php echo PHP_vehiclemanager::picture_thumbnail($vehicle_photos[$i]->main_img, $vehiclemanager_configuration['fotogal']['high'], $vehiclemanager_configuration['fotogal']['width']); ?>"  />
                                                </a>
                                            </div>
				  <?php } ?>
                                    </div>

                            <?php } ?>
                            </div>
                            <input type="hidden" name="catid" value="<?php echo $catid; ?>" />
                            <input type="hidden" name="vid[]" value="<?php echo $vehicle->id; ?>" />
                            <?php
                            if ($vehicle->listing_type == 1) {
                                if ($params->get('show_rentrequest') && $params->get('show_rentstatus')) {
                                    ?>
                                    <input type="submit" name="submit" value="<?php echo _VEHICLE_MANAGER_LABEL_BUTTON_RENT_REQU; ?>" class="button" onclick="document.vehicle.submit(); "/>
                                </form>
                                <?php
                            } else
                                echo "</form>";
                        }else if ($vehicle->listing_type == 2) {
                            ?>
                            </form>
                            <?php
                            global $option;
                            if ($params->get('show_buyrequest') && $params->get('show_buystatus')) {

                                if ($option != 'com_vehiclemanager') {
                                    $form_action = "index.php?option=" . $option . "&amp;task=buying_request_vehicle&amp;tab=getmyvehiclesTab&amp;is_show_data=1&amp;Itemid=" . $Itemid;
                                }
                                else
                                    $form_action = "index.php?option=com_vehiclemanager&amp;task=buying_request_vehicle&amp;Itemid=" . $Itemid;
                                ?>
                                <div id="hidden_buying" style = "<?php
                        if (isset($_REQUEST['err_msg_buy'])) {
                            echo 'display:none';
                        }
                        ?>">
                                    <input type="button" name="submit" value="<?php echo _VEHICLE_MANAGER_LABEL_BUTTON_BUY_VEHICLE; ?>" class="button" onclick="vm_buy_vehicle(true)"/>
                                </div>

                                <div id="show_buying" style="<?php
                        if (isset($_REQUEST['err_msg_buy'])) {
                            echo 'display:block';
                        } else {
                            echo 'display:none';
                        }
                        ?>">

                                    <form action="<?php echo sefRelToAbs($form_action); ?>" method="post" name="buying_request">
                                        <div class="componentheading<?php echo $params->get('pageclass_sfx'); ?>">
					      <?php echo _VEHICLE_MANAGER_LABEL_BUYING; ?>
                                        </div>

                                        <div class="basictable_35 basictable">
                                            <div class="row_01">
                                                <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_RENT_REQUEST_NAME ?>:</span>
                                                <span class="col_02">
                                                    <input class="inputbox" type="text" name="customer_name" size="38" maxlength="80" value="<?php echo ($my->name)?$my->name:""; ?>"/>
                                                </span>
                                            </div>
                                            <div class="row_02">
                                                <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_RENT_REQUEST_EMAIL ?>:</span>
                                                <span class="col_02">
                                                    <input class="inputbox" type="text" name="customer_email" size="38" maxlength="80" value="<?php echo ($my->email)?$my->email:""; ?>" />
                                                </span>
                                            </div>
                                            <div class="row_03">
                                                <span class="col_01"><?php echo _VEHICLE_MANAGER_REQUEST_PHONE ?>:</span>
                                                <span class="col_02">
                                                    <input class="inputbox" type="text" name="customer_phone" size="38" maxlength="80" />
                                                </span>
                                            </div>
                                            <div class="row_04">
                                                <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_COMMENT ?>:</span>
                                                <span class="col_02">
                                                    <textarea name="customer_comment" cols="50" rows="8" ></textarea>
                                                    <input type="hidden" name="vid[]" value="<?php echo $vehicle->id; ?>" />
                                                </span>
                                            </div>
                                            <div class="row_05">
                                                <span class="col_01">
                                                    <input type="button" value="<?php echo _VEHICLE_MANAGER_LABEL_BUTTON_SEND_REQUEST; ?>" class="button" onclick="vm_buying_request_submitbutton()"/>
                                                </span>
                                                <span class="col_02">
                                                    <input type="button" value="<?php echo _VEHICLE_MANAGER_LABEL_BUTTON_HIDDEN_BUYING; ?>" class="button" onclick="vm_buy_vehicle(false)"/>
                                                </span>
                                            </div>
                                        </div> <!-- basictable_35 -->
                                    </form>
                                </div><!-- show_buying -->
                                <?php
                            }
                        }
                        ?>

                        <!-- ********************** begin add for show/hiden button "Edit VEHICLE"***************************** -->
                        <?php if ($my->email == $vehicle->owneremail && $my->email != ''): ?>
                            <?php
                            global $option;
                            if ($option != 'com_vehiclemanager') {
                                $form_action = "index.php?option=" . $option . "&task=edit_vehicle&tab=getmyvehiclesTab&is_show_data=1&Itemid=" . $Itemid;
                            }
                            else
                                $form_action = "index.php?option=com_vehiclemanager&task=edit_vehicle&Itemid=" . $Itemid;
                            ?>
                            <form action="<?php echo sefRelToAbs($form_action);
                              ?>" method="post" name="show_add" enctype="multipart/form-data">
                                <br/>
				  <?php positions_vm($params->get('view05')); ?>
                                <div id ="button">
                                    <input type="hidden" name="id" value="<?php echo $vehicle->id; ?>"/>
                                    <input class="button" type="submit" name="submit" value="<?php echo _VEHICLE_MANAGER_LABEL_BUTTON_EDIT_VEHICLE; ?>"/>

                                </div>
                            </form>
                        <?php endif; ?>
                        <!-- ************************* end  add for show/hiden button "Add VEHICLE"***************************** -->
			    <?php
			      if ($params->get('show_inputreviews')) {
				?>
                            <!--***********   begin add for show/hiden button "Add review"   ***********************-->
                            <?php positions_vm($params->get('view06')); ?>
                            <div id ="button_hidden_review" style="float:left;<?php
                        if (isset($_REQUEST['err_msg'])) {
                            echo 'display:none';
                        }
                        ?>">
                                <input type="button" name="submit" value="<?php echo _VEHICLE_MANAGER_LABEL_BUTTON_ADD_REVIEW; ?>" class="button" onclick="javascript:vm_button_hidden(true)"/>
                            </div>
                            <!--***********   end add for show/hiden button "Add review"   ************************-->
                            <?php positions_vm($params->get('view07')); ?>
                            <div id="hidden_review" style="<?php
                        if (isset($_REQUEST['err_msg'])) {
                            echo 'display:block';
                        } else {
                            echo 'display:none';
                        }
                            ?>">
                                <div class="componentheading<?php echo $params->get('pageclass_sfx'); ?>">
                                    <hr />
				  <?php echo _VEHICLE_MANAGER_LABEL_ADDREVIEW; ?>
                                </div>
                                <form action="<?php echo JRoute::_("index.php?option=com_vehiclemanager&task=review&Itemid=" . $Itemid, false); ?>" method="post" name="review">
                                    <div class="basictable_36 basictable">
                                        <div class="row_01">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_REVIEW_TITLE; ?></span>
                                        </div>
                                        <div class="row_02">
                                            <span class="col_01">
                                                <input class="inputbox" type="text" name="title" size="80" value="<?php
					      if (isset($_REQUEST["title"])) {
					      echo $_REQUEST["title"];
					      }
					      ?>" />
                                            </span>
                                        </div>

                                        <div class="row_03">
                                            <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_REVIEW_COMMENT; ?></span>
                                        </div>
                                        <div class="row_04">
                                            <span class="col_01">
                                                <?php
                                                $comm_val = "";
                                                if (isset($_REQUEST["comment"]))
                                                    $comm_val = $_REQUEST["comment"];
                                                // editorArea( 'editor1',  $comm_val, 'comment', '410', '200', '60', '10' );
                                                ?>
                                                <textarea name ="comment"><?php echo $comm_val ?></textarea>
                                            </span>
                                        </div>

                                        <!-- #### RATING #### -->
					    <?php if (version_compare(JVERSION, "3.0", "ge")): ?>
                                            <script type="text/javascript">
                                                os_img_path = '<?php echo $mosConfig_live_site . '/components/com_vehiclemanager/images/'; ?>' ;
                                                jQuerVEH(document).ready(function(){
                                                    jQuerVEH('#star').raty({
                                                        starHalf: os_img_path+'star-half.png',
                                                        starOff: os_img_path+'star-off.png',
                                                        starOn: os_img_path+'star-on.png' 
                                                    });
                                                });
                                            </script>
                                            <div class="row_05">
                                                <span class="lable_rating"><?php echo _VEHICLE_MANAGER_LABEL_REVIEW_RATING; ?></span>
                                                <div id="star"></div>
                                            </div>
					    <?php else: ?>
                                            <div class="row_raty">
                                                <span class="lable_rating"><?php echo _VEHICLE_MANAGER_LABEL_REVIEW_RATING; ?></span>
                                                <br />
                                                <span class="input_raty">
                                                    <?php
                                                    $k = 0;
                                                    while ($k < 11) {
                                                        ?>
                                                        <input type="radio" name="rating" value="<?php echo $k; ?>" <?php
                                                   if (isset($_REQUEST["rating"]) && $_REQUEST["rating"] == $k) {
                                                       echo "CHECKED";
                                                   }
                                                        ?> alt="Rating" />
                                                        <img src="./components/com_vehiclemanager/images/rating-<?php echo $k; ?>.png" alt="<?php echo ($k) / 2; ?>" border="0" /><br />
                                                <?php
                                                $k++;
                                            }
                                            ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>

                                    
                                        <div class="row_11">
                                            <span class="col_01">
                                                <!-- save review button-->
                                                <input class="button" type="button" value="<?php echo _VEHICLE_MANAGER_LABEL_BUTTON_SAVE; ?>" onclick="vm_review_submitbutton()"/>
                                            </span>
                                            <span class="col_02">
                                                <!-- hide review button-->
                                                <input class="button" type="button" value="<?php echo _VEHICLE_MANAGER_LABEL_BUTTON_REVIEW_HIDE; ?>" onclick="javascript:vm_button_hidden(false);"/>
                                            </span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="fk_vehicleid" value="<?php echo $vehicle->id; ?>" />
                                    <input type="hidden" name="catid" value="<?php
				    $temp = $vehicle->catid;
				  echo $temp[0];
				    ?>" />
                                </form>
                            </div> <!-- end <div id="hidden_review"> -->

                                        <?php
                                    }   //end if($params->get('show_inputreviews'))
                                    ?> <!-- end if( $params->get('show_reviews'))          -->                                    
                                    				
		<?php        
        
		$business = $vehiclemanager_configuration['pay_pal_buy']['business'];
        $return = $vehiclemanager_configuration['pay_pal_buy']['return'];
        $item_name = $vehicle->vtitle ;							//'Donate to website.com';
        $image_url = $vehiclemanager_configuration['pay_pal_buy']['image_url'] ;
        $cancel_return =  $vehiclemanager_configuration['pay_pal_buy']['cancel_return'];
        $paypal_real_or_test =  $vehiclemanager_configuration['paypal_real_or_test']['show'];
        
        if($paypal_real_or_test==0)
            $paypal_path = 'www.sandbox.paypal.com';        
        else
            $paypal_path = 'www.paypal.com';
        
        //$pp_image = 'https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif';
        $amountLine = '';       
        
     if($vehiclemanager_configuration['paypal_buy_status']['show'] and $vehicle->listing_type == 2
          and checkAccess_VM($vehiclemanager_configuration['paypal_buy']['registrationlevel'], 'RECURSE', userGID_VM($my->id), $acl)):
            //echo '<pre>';
            //print_r($vehiclemanager_configuration); exit;
        $amountLine .= '<input type="hidden" name="amount" value="'.$vehicle->price.'" />'."\n";
        ?>
                                                    
  <?php endif;

  if($vehiclemanager_configuration['paypal_rent_status']['show'] and $vehicle->listing_type == 1
          and checkAccess_VM($vehiclemanager_configuration['paypal_rent']['registrationlevel'], 'RECURSE', userGID_VM($my->id), $acl)):
            //echo '<pre>';
            //print_r($vehiclemanager_configuration); exit;
        $amountLine .= '<input type="hidden" name="amount" value="'.$vehicle->price.'" />'."\n";
        ?>
                                                   
  <?php endif; 
				
                ?>
                        <div class="basictable_37 basictable">
			    <?php
			    mosHTML::BackButton($params, $hide_js);
			      ?>
                            </div>
                        <br />