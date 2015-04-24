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
 
//require_once($mosConfig_absolute_path . "/libraries/joomla/plugin/helper.php");
jimport( 'joomla.plugin.helper' );
///require_once($mosConfig_absolute_path . "/includes/HTML_toolbar.php");
require_once($mosConfig_absolute_path . "/administrator/includes/toolbar.php");
if (version_compare(JVERSION, "3.0.0", "lt"))
    require_once($mosConfig_absolute_path . "/libraries/joomla/html/toolbar.php");

require_once($mosConfig_absolute_path . "/components/com_vehiclemanager/vehiclemanager.php");
require_once($mosConfig_absolute_path . "/components/com_vehiclemanager/functions.php");
require_once($mosConfig_absolute_path . "/administrator/components/com_vehiclemanager/menubar_ext.php");

$doc = JFactory::getDocument();
$GLOBALS['doc'] = $doc;
$g_item_count = 0;

class HTML_vehiclemanager
{

    static function showRentRequest(& $vehicles, & $currentcat, & $params, & $tabclass, & $catid, & $sub_categories, $is_exist_sub_categories)
    {
        
        ///require_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/pageNavigation.php' );
        ///$pageNav = new mosPageNav(0, 0, 0);
        $pageNav = new JPagination(0, 0, 0); // for J 1.6
        HTML_vehiclemanager::displayVehicles($vehicles, $currentcat, $params, $tabclass, $catid, $sub_categories, $is_exist_sub_categories, $pageNav);
        // add the formular for send to :-)
    }

    static function displayVehicles(&$rows, $currentcat, &$params, $tabclass, $catid, $categories, $is_exist_sub_categories, &$pageNav, $layout = "list")
    {   
        global $mosConfig_absolute_path;
        $type = 'alone_category';
        require getLayoutPath::getLayoutPathCom('com_vehiclemanager',$type, $layout);
        
    }

    static function displayAllVehicles(&$rows, &$params, $tabclass, &$pageNav, $layout = "list")
    {
        global $mosConfig_absolute_path;
        $type = 'all_vehicle';
        require getLayoutPath::getLayoutPathCom('com_vehiclemanager',$type, $layout);
        
    }



    static function displayAllVehPrint(&$rows, &$params, $tabclass, &$pageNav)
    {

        $session = JFactory::getSession();
        $arr = $session->get("array", "default");

        global $hide_js, $Itemid, $mosConfig_live_site, $mosConfig_absolute_path;
        global $limit, $total, $limitstart, $task, $paginations, $mainframe, $vehiclemanager_configuration;
        ?>
        <div class="componentheading<?php echo $params->get('pageclass_sfx'); ?>">
            <table class="basictable_07">
                <tr>
                    <td align="right">
                        <a href="#" onclick="window.print();return false;">
        <?php
        if (version_compare(JVERSION, "1.6.0", "lt"))
        {
            ?>
                                <img src="<?php echo $mosConfig_live_site; ?>/images/M_images/printButton.png" alt="Print" >
            <?php
        } else
        {
            ?>
                                <img src="<?php echo $mosConfig_live_site; ?>/media/system/images/printButton.png" alt="Print" >
            <?php
        }
        ?>
                        </a>
                    </td>
                </tr>      
            </table>
        </div>

	<div style="clear: both;"></div>

        <div id="list">
            <table class="basictable_08" width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="10%" height="20" class="sectiontableheader<?php echo $params->get('pageclass_sfx'); ?>">
        <?php echo _VEHICLE_MANAGER_LABEL_COVER; ?>
                    </td>
                    <td width="40%" height="20" class="sectiontableheader<?php echo $params->get('pageclass_sfx'); ?>">
        <?php echo _VEHICLE_MANAGER_LABEL_TITLE; ?>
                    </td>
                    <td width="40%" height="20" class="sectiontableheader<?php echo $params->get('pageclass_sfx'); ?>">
        <?php echo _VEHICLE_MANAGER_LABEL_MODEL; ?>
                    </td>
<?php
                        if ($params->get('show_pricerequest')) {
?>  
                        <td width="15%" height="20" class="sectiontableheader<?php echo $params->get('pageclass_sfx'); ?>">
                        <?php echo _VEHICLE_MANAGER_LABEL_PRICE; ?>
                        </td>
                        <?php
                        }
                        if ($params->get('hits'))
                        {
                            ?>
                        <td height="20" class="sectiontableheader<?php echo $params->get('pageclass_sfx'); ?>" align="right">
                            <?php echo _VEHICLE_MANAGER_LABEL_HITS; ?>
                        </td>
                            <?php
                        }
               ?>
                </tr>
            <?php
            $available = false;
            $k = 0;
//****************************************   add my perenos
            $total = count($rows);
            if (isset($_GET['lang']))
                $lang = $_GET['lang']; else
                $lang = '*';
            foreach ($rows as $row) {
                if ($row->language == $lang or $row->language == '*' or $lang == '*')
                {
//****************************************   add my perenos
                    $link = 'index.php?option=com_vehiclemanager&amp;task=view_vehicle&amp;id=' . $row->id . '&amp;catid=' . $row->catid . '&amp;Itemid=' . $Itemid;
                    ?>
                        <tr class="<?php echo $tabclass[$k]; ?>" >
                            <td style="padding-left:5px; padding-top:5px; padding-right:10px;">
                <?php
                $vehicle = $row;
                //for local images
                $imageURL = urlencode($vehicle->image_link);

                if ($imageURL != '')
                {
                    $file_pth = pathinfo($imageURL);
                    $file_type = '.' . $file_pth['extension'];
                    if (array_key_exists('filename', $file_pth))
                        $file_name = $file_pth['filename'];
                    else
                        $file_name = substr($imageURL, 0, strlen($imageURL) - strlen($file_pth['extension']) - 1);
                    echo '<img src="' .
                    $mosConfig_live_site . '/components/com_vehiclemanager/photos/'
                    . $file_name . "_".$vehiclemanager_configuration['foto']['high']."_".$vehiclemanager_configuration['foto']['width'] . $file_type . '" border="0" class="little">';
                } else
                {
                    echo '<img src="' .
                    $mosConfig_live_site . '/components/com_vehiclemanager/images/';
                    echo _VEHICLE_MANAGER_NO_PICTURE;
                    echo '" alt="no-img_eng.gif" border="0"  />&nbsp;';
                }
                ?>
                            </td>
                            <td >
                                <a href="<?php echo sefRelToAbs($link); ?>" class="category<?php echo $params->get('pageclass_sfx'); ?>">
                <?php echo $row->vtitle; ?>
                                </a>

                            </td>
                            <td>
                    <?php
                    if ($row->maker == '0' || $row->maker == 'other')
                        echo $row->vmodel;
                    else
                        echo $row->maker, ', ', $row->vmodel;
                    ?>
                            </td>
<?php
                if ($params->get('show_pricerequest')) {
?>  
                     <td >
                      <?php echo $row->price, ' ', $row->priceunit; ?>
                     </td>
                    <?php
                }    
                if ($params->get('hits'))
                {
                    ?>
                                <td align="left">
                    <?php echo $row->hits; ?>
                                </td>
                       </tr>
        <?php 
                }
		  }
	      } ?>
          </table>
        </div>
        <?php
      //  exit;
    }

    /**
     * Displays the vehicle
     * rent Status
     */
    static function displayVehicle(& $vehicle, & $tabclass, & $params, & $currentcat, & $rating, & $vehicle_photos, & $id, & $catid, & $vehicle_feature, & $currencys_price, & $layout = 'default')
    {
        if(!$catid) $catid = JRequest::getVar('catid');
        global $mosConfig_absolute_path;
        $type = 'view_vehicle';
        require getLayoutPath::getLayoutPathCom('com_vehiclemanager',$type, $layout);
        
        
    }

// END function displayVehicle


    /**
     * Display links to categories
     */
    static function showCategories(&$params, &$categories, &$catid, &$tabclass, &$currentcat, $layout)
    {
        global $mosConfig_absolute_path;
        $type = 'all_categories';
        require getLayoutPath::getLayoutPathCom('com_vehiclemanager',$type, $layout);

    }



//********************************   end add for suggestion   **************************************

    static function listCategories(&$params, $cat_all, $catid, $tabclass, $currentcat)
    {
        global $Itemid, $mosConfig_live_site;
        ?>
        <?php positions_vm($params->get('allcategories04')); ?>
        <div class="basictable_12 basictable">
            <div class="row_01">
                <span class=" col_01 sectiontableheader<?php echo $params->get('pageclass_sfx'); ?>"><?php echo _VEHICLE_MANAGER_LABEL_CATEGORY; ?></span>
                <span class="col_003 sectiontableheader<?php echo $params->get('pageclass_sfx'); ?>"><?php echo _VEHICLE_MANAGER_LABEL_VEHICLES; ?> </span>

            </div>
            <div class="row_02">
                <span class="col_01">
        <?php positions_vm($params->get('allcategories05')); ?>

        <?php
        HTML_vehiclemanager::showInsertSubCategory($catid, $cat_all, $params, $tabclass, $Itemid, 0);
        ?>
                </span>
            </div>
        </div>
        <?php positions_vm($params->get('allcategories06')); ?>

                <?php
            }

            /*
             * function for show subcategory
             */

            static function showInsertSubCategory($id, $cat_all, $params, $tabclass, $Itemid, $deep)
            {
                global $g_item_count, $vehiclemanager_configuration, $mosConfig_live_site;
                $deep++;
                for ($i = 0; $i < count($cat_all); $i++) {
                    if (($id == $cat_all[$i]->parent_id) && ($cat_all[$i]->display == 1))
                    {
                        $g_item_count++;

                        $link = 'index.php?option=com_vehiclemanager&amp;task=alone_category&amp;catid=' . $cat_all[$i]->id . '&amp;Itemid=' . $Itemid;
                        ?>
                <div class="basictable_13 basictable">
                    <div class="row_01 <?php echo $tabclass[($g_item_count % 2)]; ?>">
                        <span class="col_01">
                <?php
                if ($deep != 1)
                {
                    $jj = $deep;
                    while ($jj--) {
                        echo "&nbsp;&nbsp;";
                    }
                    echo "&nbsp;|_";
                }
                ?>
                        </span>
                        <span class="col_01">
                <?php if (($params->get('show_cat_pic')) && ($cat_all[$i]->image != ""))
                { ?>
                                <img src="./images/stories/<?php echo $cat_all[$i]->image; ?>" alt="picture for subcategory" height="48" width="48" />&nbsp;
                    <?php } else
                {
                    ?>
                                <a <?php echo "href=" . sefRelToAbs($link); ?> class="category<?php echo $params->get('pageclass_sfx'); ?>" style="text-decoration: none"><img src="./components/com_vehiclemanager/images/folder.png" alt="picture for subcategory" height="48" width="48" /></a>&nbsp;
                <?php } ?>
                        </span>
                        <span class="col_02">
                <?php
                $count_veh = $cat_all[$i]->vehicles * 1;
                //if ($count_veh != 0)
                //{
                    $disable_link = "";
                    if ($cat_all[$i]->published != 1)
                        $disable_link = "href='#' onClick = 'return false'";
                    else
                        $disable_link = "href='" . sefRelToAbs($link) . "'";
                    ?>            
                                <a <?php echo $disable_link; ?> class="category<?php echo $params->get('pageclass_sfx'); ?>">
                    <?php
                //} else
                //{
                //    echo "";
                //}
                ?>                  
                <?php echo $cat_all[$i]->title; ?>
                            </a>
                        </span>
                        <span class="col_03"><?php if ($cat_all[$i]->vehicles == '') echo "0";else echo $cat_all[$i]->vehicles; ?></span>

                    </div>
                </div>
                    <?php
                    if ($GLOBALS['subcategory_show'])
                        HTML_vehiclemanager::showInsertSubCategory($cat_all[$i]->id, $cat_all, $params, $tabclass, $Itemid, $deep);
                }//end if ($id == $cat_all[$i]->parent_id)
            }//end for(...)	
        }

//end function showInsertSubCategory($id, $cat_all)

    static function showSearchVehicles($params, $currentcat, $clist, $option, $years, &$arraymakersmodels, $layout) {
        global $mosConfig_absolute_path;
        // $layout = $params->get('showsearchvehiclelayout', 'default'); // need when not realize layout select from admin
        $type = 'show_search_vehicle';
        require getLayoutPath::getLayoutPathCom('com_vehiclemanager',$type, $layout);
        
    }

        static function showRssCategories(&$categories, &$catid)
        {
            global $hide_js, $Itemid, $acl, $mosConfig_live_site, $my;
            global $limit, $total, $limitstart, $paginations, $mainframe, $vehiclemanager_configuration;
          //  header("Content-Type: application/rss+xml; charset=utf-8");
          //  exit();
            echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            echo '<!-- generator="AdvertisementBoard" -->' . "\n";
            echo '<?xml-stylesheet href="" type="text/css"?>' . "\n";
            echo '<?xml-stylesheet href="" type="text/xsl"?>' . "\n";
            echo '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";
            echo "    <channel>\n";

            if (!$categories)
            {
                echo "<title>" . $mosConfig_live_site . " - " . _VEHICLE_MANAGER_TITLE . "</title>\n";
                echo "<description>" . _VEHICLE_MANAGER_TITLE . " - " . _VEHICLE_MANAGER_ERROR_HAVENOT_VEHICLES_RSS . "</description>\n";
            } else
            {
                if (!$catid)
                {
                    echo "<title>" . $mosConfig_live_site . " - " . _VEHICLE_MANAGER_TITLE . " - ALL</title>\n";
                    echo "<description>" . _VEHICLE_MANAGER_TITLE . "  " . $categories[0]->cdesc . "</description>\n";
                } else
                {
                    echo "<title>" . $mosConfig_live_site . " - " . _VEHICLE_MANAGER_TITLE . " - " . $categories[0]->ctitle . "</title>\n";
                    echo "<description>" . _VEHICLE_MANAGER_TITLE . "  " . $categories[0]->cdesc . "</description>\n";
                }
            }
            echo "<link>" . $mosConfig_live_site . "</link>\n";
            echo "<lastBuildDate>" . date("Y-m-d H:i:s") . "</lastBuildDate>\n";
            echo "<generator>" . _VEHICLE_MANAGER_TITLE . "</generator>\n";
            for ($i = 0; $i < count($categories); $i++) {
                //Select list for vehicle type
                $vtype[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                $vtype1 = explode(',', _VEHICLE_MANAGER_OPTION_VEHICLE_TYPE);
                $j = 1;
                foreach ($vtype1 as $vtype2) {
                    $vtype[$j] = $vtype2;
                    $j++;
                }
                //Select list for listing type
                $listing_type[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                $listing_type[1] = _VEHICLE_MANAGER_OPTION_FOR_RENT;
                $listing_type[2] = _VEHICLE_MANAGER_OPTION_FOR_SALE;
                //Select list for price type
                $price_type[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                $price_type1 = explode(',', _VEHICLE_MANAGER_OPTION_PRICE_TYPE);
                $j = 1;
                foreach ($price_type1 as $price_type2) {
                    $price_type[$j] = $price_type2;
                    $j++;
                }
                //Select list for condition
                $vcondition[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                $vcondition1 = explode(',', _VEHICLE_MANAGER_OPTION_VEHICLE_CONDITION);
                $j = 1;
                foreach ($vcondition1 as $vcondition2) {
                    $vcondition[$j] = $vcondition2;
                    $j++;
                }
                //Select list for listing status type
                $listing_status_type[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                $listing_status_type1 = explode(',', _VEHICLE_MANAGER_OPTION_LISTING_STATUS);
                $j = 1;
                foreach ($listing_status_type1 as $listing_status_type2) {
                    $listing_status_type[$j] = $listing_status_type2;
                    $j++;
                }
                //Select list for transmission
                $transmission[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                $transmission1 = explode(',', _VEHICLE_MANAGER_OPTION_TRANSMISSION);
                $j = 1;
                foreach ($transmission1 as $transmission2) {
                    $transmission[$j] = $transmission2;
                    $j++;
                }
                //Select list for drive type
                $drive_type[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                $drive_type1 = explode(',', _VEHICLE_MANAGER_OPTION_DRIVE_TYPE);
                $j = 1;
                foreach ($drive_type1 as $drive_type2) {
                    $drive_type[$j] = $drive_type2;
                    $j++;
                }
                //Select list for number of cylinders
                $cylinder[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                $cylinder1 = explode(',', _VEHICLE_MANAGER_OPTION_NUMBER_OF_CYLINDERS);
                $j = 1;
                foreach ($cylinder1 as $cylinder2) {
                    $cylinder[$j] = $cylinder2;
                    $j++;
                }
                //Select list for number of speeds
                $num_speed[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                $num_speed1 = explode(',', _VEHICLE_MANAGER_OPTION_NUMBER_OF_SPEEDS);
                $j = 1;
                foreach ($num_speed1 as $num_speed2) {
                    $num_speed[$j] = $num_speed2;
                    $j++;
                }
                //Select list for fuel type
                $fuel_type[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                $fuel_type1 = explode(',', _VEHICLE_MANAGER_OPTION_NUMBER_OF_SPEEDS);
                $j = 1;
                foreach ($fuel_type1 as $fuel_type2) {
                    $fuel_type[$j] = $fuel_type2;
                    $j++;
                }
                //Select list for number of doors
                $doors[0] = _VEHICLE_MANAGER_OPTION_SELECT;
                $doors1 = explode(',', _VEHICLE_MANAGER_OPTION_NUMBER_OF_DOORS);
                $j = 1;
                foreach ($doors1 as $doors2) {
                    $doors[$j] = $doors2;
                    $j++;
                }

                $category = $categories[$i];
                echo "<item>";
                echo "<title>" . $category->vtitle . "</title>" . "\n";
                echo "<link>" . $mosConfig_live_site . "/index.php?option=com_vehiclemanager&amp;Itemid=" .
                $Itemid . "&amp;task=view_vehicle&amp;id=" . $category->vid . "&amp;catid=" . $category->cid . "</link>" . "\n";
                echo "<description><![CDATA[";
                if ($category->image_link)
                {
                    $imagebase = $category->image_link;
                    $imagemain = explode('.', $imagebase);
                    $image = $mosConfig_live_site . '/components/com_vehiclemanager/photos/' . $imagemain[0] . '_gallery.' . $imagemain[1];
                    echo '<br /><img src="' . $image . '" />';
                }
                if ($category->rent_from != '')
                {
                    echo "<br><lend_from>" . "<b>Lend from: </b>" . $category->rent_from . "</lend_from>";
                    echo "<br><lend_until>" . "<b>Lend until: </b>" . $category->rent_until . "</lend_until>";
                    echo "<br><lend_to>" . "<b>Lend to: </b>" . $category->user_name . "</lend_to>";
                }
                if ($category->maker != 0)
                    echo "<br><maker><b>" . _VEHICLE_MANAGER_LABEL_MAKER . ": </b>" . $category->maker . "</maker>";
                if ($category->vmodel !== 0 && trim($category->vmodel) !== "")
                    echo "<br><model><b>" . _VEHICLE_MANAGER_LABEL_MODEL . ": </b>" . $category->vmodel . "</model>";
                if ($category->vtype != 0)
                    echo "<br><vtype><b>" . _VEHICLE_MANAGER_LABEL_VEHICLE_TYPE . ": </b>" . $vtype[$category->vtype] . "</vtype>";
                if ($category->listing_type != 0)
                    echo "<br><ltype><b>" . _VEHICLE_MANAGER_LABEL_LISTING_TYPE . ": </b>" . $listing_type[$category->listing_type] . "</ltype>";
                if ($category->price > 0)
                    echo "<br><price><b>" . _VEHICLE_MANAGER_LABEL_PRICE . ": </b>" . $category->price . " " . $category->priceunit . "</price>";
                if ($category->price_type != 0)
                    echo "<br><price_type><b>" . _VEHICLE_MANAGER_LABEL_PRICE_TYPE . ": </b>" . $price_type[$category->price_type] . "</price_type>";
                if (trim($category->vlocation))
                    echo "<br><vlocation><b>" . _VEHICLE_MANAGER_LABEL_ADDRESS . ": </b>" . $category->vlocation . "</vlocation>";
                if ($vehiclemanager_configuration['owner']['show'])
                {
                    echo "<br><owner><b>" . _VEHICLE_MANAGER_LABEL_OWNER . ": </b>" . $category->ownername . "(" . $category->owneremail . ")</owner>";
                }
                if ($category->year > 0)
                    echo "<br><year><b>" . _VEHICLE_MANAGER_LABEL_ISSUE_YEAR . ": </b>" . $category->year . "</year>";
                if ($category->vcondition != 0)
                    echo "<br><vcondition><b>" . _VEHICLE_MANAGER_LABEL_CONDITION_STATUS . ": </b>" . $vcondition[$category->vcondition] . "</vcondition>";
                if (trim($category->mileage))
                    echo "<br><mileage><b>" . _VEHICLE_MANAGER_LABEL_MILEAGE . ": </b>" . $category->mileage . "</mileage>";
                if ($category->listing_status != 0)
                    echo "<br><listing_status><b>" . _VEHICLE_MANAGER_LABEL_LISTING_STATUS . ": </b>" . $listing_status_type[$category->listing_status] . "</listing_status>";
                if (trim($category->contacts))
                    echo "<br><contacts><b>" . _VEHICLE_MANAGER_LABEL_CONTACTS . ": </b>" . $category->contacts . "</contacts>";
                if (trim($category->engine))
                    echo "<br><engine><b>" . _VEHICLE_MANAGER_LABEL_ENGINE_TYPE . ": </b>" . $category->engine . "</engine>";
                if ($category->transmission != 0)
                    echo "<br><transmission><b>" . _VEHICLE_MANAGER_LABEL_TRANSMISSION_TYPE . ": </b>" . $transmission[$category->transmission] . "</transmission>";
                if ($category->drive_type != 0)
                    echo "<br><drive_type><b>" . _VEHICLE_MANAGER_LABEL_DRIVE_TYPE . ": </b>" . $drive_type[$category->drive_type] . "</drive_type>";
                if ($category->cylinder != 0)
                    echo "<br><cylinder><b>" . _VEHICLE_MANAGER_LABEL_NUMBER_CYLINDERS . ": </b>" . $cylinder[$category->cylinder] . "</cylinder>";
                if ($category->num_speed != 0)
                    echo "<br><num_speed><b>" . _VEHICLE_MANAGER_LABEL_NUMBER_SPEEDS . ": </b>" . $num_speed[$category->num_speed] . "</num_speed>";
                if ($category->fuel_type != 0)
                    echo "<br><fuel_type><b>" . _VEHICLE_MANAGER_LABEL_FUEL_TYPE . ": </b>" . $fuel_type[$category->fuel_type] . "</fuel_type>";
                if (trim($category->city_fuel_mpg))
                    echo "<br><city_fuel_mpg><b>" . _VEHICLE_MANAGER_LABEL_CITY_FUEL_MPG . ": </b>" . $category->city_fuel_mpg . "</city_fuel_mpg>";
                if (trim($category->highway_fuel_mpg))
                    echo "<br><highway_fuel_mpg><b>" . _VEHICLE_MANAGER_LABEL_HIGHWAY_FUEL_MPG . ": </b>" . $category->highway_fuel_mpg . "</cityhighway_fuel_mpg_fuel_mpg>";
                if (trim($category->wheelbase))
                    echo "<br><wheelbase><b>" . _VEHICLE_MANAGER_LABEL_WHEELBASE . ": </b>" . $category->wheelbase . "</wheelbase>";
                if (trim($category->wheeltype))
                    echo "<br><wheeltype><b>" . _VEHICLE_MANAGER_LABEL_WHEELTYPE . ": </b>" . $category->wheeltype . "</wheeltype>";
                if (trim($category->rear_axe_type))
                    echo "<br><rear_axe_type><b>" . _VEHICLE_MANAGER_LABEL_REARAXE_TYPE . ": </b>" . $category->rear_axe_type . "</rear_axe_type>";
                if (trim($category->brakes_type))
                    echo "<br><brakes_type><b>" . _VEHICLE_MANAGER_LABEL_BRAKES_TYPE . ": </b>" . $category->wheeltype . "</brakes_type>";
                if (trim($category->exterior_color))
                    echo "<br><exterior_color><b>" . _VEHICLE_MANAGER_LABEL_EXTERIOR_COLORS . ": </b>" . $category->exterior_color . "</exterior_color>";
                if ($category->doors != 0)
                    echo "<br><doors><b>" . _VEHICLE_MANAGER_LABEL_NUMBER_DOORS . ": </b>" . $doors[$category->doors] . "</doors>";
                if (trim($category->exterior_amenities))
                    echo "<br><exterior_amenities><b>" . _VEHICLE_MANAGER_LABEL_EXTERIOR_EXTRAS . ": </b>" . $category->exterior_amenities . "</exterior_amenities>";
                if (trim($category->interior_color))
                    echo "<br><interior_color><b>" . _VEHICLE_MANAGER_LABEL_INTERIOR_COLORS . ": </b>" . $category->interior_color . "</interior_color>";
                if (trim($category->seating))
                    echo "<br><seating><b>" . _VEHICLE_MANAGER_LABEL_NUMBER_SEATINGS . ": </b>" . $category->seating . "</seating>";
                if (trim($category->dashboard_options))
                    echo "<br><dashboard_options><b>" . _VEHICLE_MANAGER_LABEL_DASHBOARD_OPTIONS . ": </b>" . $category->dashboard_options . "</dashboard_options>";
                if (trim($category->interior_amenities))
                    echo "<br><interior_amenities><b>" . _VEHICLE_MANAGER_LABEL_INTERIOR_EXTRAS . ": </b>" . $category->interior_amenities . "</interior_amenities>";
                if (trim($category->safety_options))
                    echo "<br><safety_options><b>" . _VEHICLE_MANAGER_LABEL_SAFETY_OPTIONS . ": </b>" . $category->safety_options . "</safety_options>";
                if (trim($category->w_basic))
                    echo "<br><w_basic><b>" . _VEHICLE_MANAGER_LABEL_WARRANTY_BASIC . ": </b>" . $category->w_basic . "</w_basic>";
                if (trim($category->w_drivetrain))
                    echo "<br><w_drivetrain><b>" . _VEHICLE_MANAGER_LABEL_WARRANTY_DRIVETRAIN . ": </b>" . $category->w_drivetrain . "</w_drivetrain>";
                if (trim($category->w_corrosion))
                    echo "<br><w_corrosion><b>" . _VEHICLE_MANAGER_LABEL_WARRANTY_CORROSION . ": </b>" . $category->w_corrosion . "</w_corrosion>";
                if (trim($category->w_roadside_ass))
                    echo "<br><w_roadside_ass><b>" . _VEHICLE_MANAGER_LABEL_WARRANTY_ROADSIDE_ASSISTANCE . ": </b>" . $category->w_roadside_ass . "</w_roadside_ass>";
                echo "<br>" . $category->description;
                echo "]]></description>\n";
                echo "<pubDate>" . $category->date . "</pubDate>\n";
                echo "</item>\n";
            }
            ?>
        </channel>
        </rss>
        <?php
        exit;
    }



    static function showRentRequestThanks($params, $catid, $currentcat,$vehicle=NULL,$time_difference =NULL)
    {
        global $Itemid, $doc, $mosConfig_live_site, $hide_js, $option, $vehiclemanager_configuration;
        $doc->addStyleSheet($mosConfig_live_site . '/components/com_vehiclemanager/includes/vehiclemanager.css');
        ?>
        <div class="componentheading<?php echo $params->get('pageclass_sfx'); ?>">
            <?php echo $currentcat->header; ?>
        </div>

        <div class="table_save_add_vehicle basictable">
        <?php if ($currentcat->img != null)
        { ?>
           <div class="col_01"><img src="<?php echo $currentcat->img; ?>" alt="?" /></div>
            <?php
        }
        ?>
         <div class="col_02"><?php echo $currentcat->descrip; ?></div>
         
        <?php
        if($vehicle){
            $business = $vehiclemanager_configuration['pay_pal_buy']['business'];
            $return = $vehiclemanager_configuration['pay_pal_buy']['return'];      						//'Donate to website.com';
            $image_url = $vehiclemanager_configuration['pay_pal_buy']['image_url'] ;
            $cancel_return =  $vehiclemanager_configuration['pay_pal_buy']['cancel_return'];
            $paypal_real_or_test =  $vehiclemanager_configuration['paypal_real_or_test']['show'];
            $item_name = $vehicle->vtitle;
            
            if($paypal_real_or_test==0)
                $paypal_path = 'www.sandbox.paypal.com';        
            else
                $paypal_path = 'www.paypal.com';
        
            if($time_difference){
                $amount = $time_difference[0]; // price
                $currency_code = $time_difference[1] ; // priceunit  
            }
            else{
                $amount= $vehicle->price;
                $currency_code = $vehicle->priceunit;
            }
        
        $amountLine='';
        $amountLine .= '<input type="hidden" name="amount" value="'.$amount.'" />'."\n"; 
        }
        ?>
		


        <?php
        if ($option != "com_vehiclemanager")
        {
            $path = $mosConfig_live_site . "/index.php?option=" . $option . "&amp;task=my_vehicles&amp;is_show_data=1&amp;
tab=getmyvehiclesTab&amp;Itemid=" . $_REQUEST['Itemid'];
            $path_other = $mosConfig_live_site . "/index.php?option=" . $option . "&amp;task=view_user_vehicles&amp;is_show_data=1&amp;Itemid=" . $_REQUEST['Itemid'];
        } else
        {
            $path = $mosConfig_live_site . "/index.php?option=com_vehiclemanager&amp;task=my_vehicles&amp;Itemid=" . $_REQUEST['Itemid'];
            $path_other = $mosConfig_live_site . "/index.php?option=com_vehiclemanager&amp;task=showCategory&amp;catid=" . $catid . "&amp;Itemid=" . $_REQUEST['Itemid'];
        }
        ?>

    
            </div>

            <div class="basictable_16 basictable">
                    <?php mosHTML::BackButton($params, $hide_js); ?>
            </div>
                        <input class="button" type="submit" ONCLICK="window.location.href='<?php
                       $user = JFactory::getUser(); 
                        if(!$user->guest) {
        if ($catid == 0)
        {
            echo $path;
        } else if ($_REQUEST['where'] == 2)
        {
            echo sefRelToAbs($path_other);
        } else
        {
            echo sefRelToAbs($path);
        }
                        } else
                        {
                            echo sefRelToAbs($mosConfig_live_site . "/index.php?option=com_vehiclemanager&amp;Itemid=" . $_REQUEST['Itemid']);
                        }
        ?>'" value="OK">
        <?php
    }


    static function showTabs(&$params, &$userid, &$username, &$comprofiler, &$option)
    {
        global $Itemid;
		$option = 'com_vehiclemanager';
        ?>
        <div class='button_margin'>
                        <?php
                        if ($params->get('show_cb'))
                        {
                            if ($params->get('show_cb_registrationlevel'))
                            {
                               // if ($option != "com_vehiclemanager") {
                                    ?>
                        <span class='vehicle_button'>
                            <a href="<?php echo JRoute::_('index.php?option=' . $option . '&task=my_vehicles&tab=getmyvehiclesTab&name=' . $username . '&Itemid=' . $Itemid . '&is_show_data=1'); ?>"><?php echo JText::_('show my cars'); ?></a>
                        </span>
                                    <?php
                              //  }
                            }
                        }

                        if ($params->get('show_edit'))
                        {
                            if ($params->get('show_edit_registrationlevel'))
                            {
                                ?>
                    <span class='vehicle_button'>
                        <a href="<?php echo JRoute::_('index.php?option=' . $option . '&task=my_vehicles&Itemid=' . $Itemid . $comprofiler); ?>"><?php echo JText::_('edit my cars'); ?></a>
                    </span>
                <?php
            }
        }

        if ($params->get('show_rent'))
        {
            if ($params->get('show_rent_registrationlevel'))
            {
                ?>
                    <span class='vehicle_button'>
                        <a href="<?php echo JRoute::_('index.php?option=' . $option . '&task=rent_requests_vehicle&Itemid=' . $Itemid . $comprofiler); ?>"><?php echo JText::_('rent requests'); ?></a>
                    </span>
                                <?php
                            }
                        }

                        if ($params->get('show_buy'))
                        {
                            if ($params->get('show_buy_registrationlevel'))
                            {
                                ?>
                    <span class='vehicle_button'>
                        <a href="<?php echo JRoute::_('index.php?option=' . $option . '&task=buying_requests_vehicle&Itemid=' . $Itemid . $comprofiler); ?>"><?php echo JText::_('buying requests'); ?></a>
                    </span>
                                    <?php
                                }
                            }

                            if ($params->get('show_history'))
                            {
                                if ($params->get('show_history_registrationlevel'))
                                {
                                    ?>
                    <span class='vehicle_button'>
                        <a href="<?php echo JRoute::_('index.php?option=' . $option . '&task=rent_history_vehicle&name=' . $username . '&user=' . $userid . '&Itemid=' . $Itemid . $comprofiler); ?>"><?php echo JText::_('my rent history'); ?></a>
                    </span>
                                <?php
                            }
                        }
                        ?>
        </div>
                        <?php
                    }

    static function showRequestRentVehicles($option, &$rent_requests, &$pageNav)
    {
        global $my, $mosConfig_live_site, $mainframe, $doc, $Itemid;
        $session = JFactory::getSession();
        $arr = $session->get("array", "default");
        $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');
        $doc->addStyleSheet($mosConfig_live_site . '/components/com_vehiclemanager/includes/custom.css');
        ?>
        <form action="index.php" method="get" name="adminForm" id="adminForm">
            <div class="rent_requests_vehicle">
             <div class="row_01">
                <span class="col_01"><input type="checkbox" name="toggle" value="" onClick="vm_checkAll(this);" /></span>
                <span class="col_02">check All</span>
           </div>
        <?php
        for ($i = 0, $n = count($rent_requests); $i < $n; $i++) {
            $row = & $rent_requests[$i];
            ?>

    <span class="user_name"><?php echo $row->user_name; ?></span>
      <span class="arrow_up_comment"></span>
              <div class="rent_vehicle_head row_0<?php echo $i % 2; ?>">

        <div class="row_vm_rent">

      <div class="row_vtitle">
       <?php //echo _VEHICLE_MANAGER_LABEL_TITLE; ?>
                   <?php echo $row->vtitle; ?>
      </div>

      <div class="row_01">
        <?php echo mosHTML::idBox($i, $row->id, 0, 'vid'); ?>
        <span class="col_01">id</span>
                    <span class="col_02"><?php echo $row->id; ?></span>
      </div>

      <div class="row_02">
        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_VEHICLEID; ?></span>
        <span class="col_02">
        <?php
          $data = JFactory::getDBO();
          $query = "SELECT vehicleid FROM #__vehiclemanager_vehicles where id = " . $row->fk_vehicleid . " ";
          $data->setQuery($query);
          $vehicleid = $data->loadObjectList();
           echo $vehicleid[0]->vehicleid;
        ?>
        </span>
      </div>

       </div>

    <?php //echo _VEHICLE_MANAGER_LABEL_RENT_USER; ?>

      <div class="row_comment">
        <?php //echo _VEHICLE_MANAGER_LABEL_RENT_ADRES; ?>
        <span class="quotes_before"></span>
        <?php echo $row->user_mailing; ?>
        <span class="quotes_after"></span>
      </div>

     <div class="mailto_from_until">
      <div class="row_mailto">
      <img src="<?php echo $mosConfig_live_site; ?>/components/com_vehiclemanager/images/mail_request.png" alt="email" />
       <?php //echo _VEHICLE_MANAGER_LABEL_RENT_EMAIL; ?>
                   <a href=mailto:"<?php echo $row->user_email; ?>"><?php echo $row->user_email; ?></a>
      </div>
      <div class="row_from">
        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_RENT_FROM; ?></span>
                    <span class="col_02"><?php echo $row->rent_from; ?></span>
      </div>
      <div class="row_until">
        <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_RENT_UNTIL; ?></span>
                    <span class="col_02"><?php echo $row->rent_until; ?></span>
      </div>
     </div>

               </div>
            <?php
        }
        ?>
      </div>

           <div class="page_navigation row_<?php echo $i % 2; ?>">
              <div class="row_02">
    <?php
      $paginations = $arr;
        if ($paginations && ($pageNav->total > $pageNav->limit))
     {
    echo $pageNav->getPagesLinks();
        }
      ?>
             </div>
          </div>

            <input type="hidden" name="option" value="<?php echo $option; ?>" />
        <?php
        if ($option != "com_vehiclemanager")
        {
            ?>
                <input type="hidden" name="tab" value="getmyvehiclesTab" />
                <input type="hidden" name="is_show_data" value="1" />
            <?php
        }
        ?>
            <input type="hidden" id="adminFormTaskInput" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
            <input type="button" name="acceptButton" value="accept request" onclick="vm_buttonClickRentRequest(this)"/>
            <input type="button" name="declineButton" value="decline request" onclick="vm_buttonClickRentRequest(this)"/>
        </form>
        <?php
    }

    static function showRequestBuyingVehicles($option, $buy_requests, $pageNav)
    {
        global $my, $mosConfig_live_site, $mainframe, $doc, $Itemid;
        $session = JFactory::getSession();
        $arr = $session->get("array", "default");
        $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');
        $doc->addStyleSheet($mosConfig_live_site . '/components/com_vehiclemanager/includes/custom.css');
        ?>
        <form action="index.php" method="get" name="adminForm" id="adminForm">

            <div class="buy_requests_form">
                <div class="row_01">
                    <span class="col_01"><input type="checkbox" name="toggle" value="" onClick="vm_checkAll(this);" /></span>
        <span class="check_all_requests">check All</span>
               </div>
        <?php
        for ($i = 0, $n = count($buy_requests); $i < $n; $i++) {
            $row = $buy_requests[$i];
            ?>

        <span class="user_name"><?php echo $row->customer_name; ?></span>
      <span class="arrow_up_comment"></span>
          <div class="box_request_vm row_0<?php echo $i % 2; ?>">

      <div class="row_vid">
  <div class="col_vtitle">
            <?php //echo _VEHICLE_MANAGER_LABEL_TITLE; ?>
            <?php echo $row->vtitle; ?>
  </div>
  <div class="row_01">
            <?php
            if ($row->fk_rentid != 0)
            {
            ?>
              &nbsp;
                <?php
            } else
            {
             ?>
    <?php echo mosHTML::idBox($i, $row->id, ($row->fk_rentid != 0), 'vid'); ?>
             <?php
            }
            ?>
    <span class="col_02">id</span>
    <span class="col_03"><?php echo $row->id; ?></span>
  </div>

  <div class="row_02">
      <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_VEHICLEID; ?></span>
            <span class="col_02"><?php echo $row->fk_vehicleid; ?></span>
  </div>
    </div>

      <?php //echo _VEHICLE_MANAGER_LABEL_RENT_USER; ?>

    <div class="row_comment">
                  <?php //echo _VEHICLE_MANAGER_LABEL_COMMENT; ?>
                  <span class="quotes_before"></span>
          <?php echo $row->customer_comment; ?>
                  <span class="quotes_after"></span>
    </div>

        <div class="mailto_phone">
    <div class="row_mailto">
      <img src="<?php echo $mosConfig_live_site; ?>/components/com_vehiclemanager/images/mail_request.png" alt="email" />
                  <?php //echo _VEHICLE_MANAGER_LABEL_RENT_EMAIL; ?>
      <a href=mailto:"<?php echo $row->customer_email; ?>"><?php echo $row->customer_email; ?></a>
    </div>
    <div class="row_phone">
      <img src="<?php echo $mosConfig_live_site; ?>/components/com_vehiclemanager/images/phone_request.png" alt="phone" />
                  <?php //echo _VEHICLE_MANAGER_LABEL_BUYING_ADRES; ?>
                  <span class="col_phone"><?php echo $row->customer_phone; ?></span>
    </div>
        </div>

            </div>
          <?php
         }
        ?>

    </div>

        <div class="page_navigation">
           <div class="row_02">
      <?php
    $paginations = $arr;
      if ($paginations && ($pageNav->total > $pageNav->limit))
      {
    echo $pageNav->getPagesLinks();
      }
      ?>
    </div>
      </div>

            <input type="hidden" name="option" value="<?php echo $option; ?>" />
        <?php
        if ($option != "com_vehiclemanager")
        {
            ?>
                <input type="hidden" name="tab" value="getmyvehiclesTab" />
                <input type="hidden" name="is_show_data" value="1" />
            <?php
        }
        ?>
            <input type="hidden" id="adminFormTaskInput" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
            <input type="button" name="acceptButton" value="accept request" onclick="vm_buttonClickBuyRequest(this)"/>
            <input type="button" name="declineButton" value="decline request" onclick="vm_buttonClickBuyRequest(this)"/>
        </form>
        <?php
    }
}
//END CLASS VEHICLE MANAGER HTML
?>