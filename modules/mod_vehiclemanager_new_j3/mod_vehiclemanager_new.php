<?php

/**
 * @version 3.0 free
 * @package VehicleManager New
 * @copyright 2013 OrdaSoft
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @description Vehicle New for VehicleManager Component
 */

defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$database = JFactory::getDBO();

$f_path = JPATH_BASE .'/components/com_vehiclemanager/functions.php';
if (!file_exists($f_path)){
    echo "To display this module You have to install VehicleManager first<br />"; exit;
} else require_once ($f_path);

global $vehiclemanager_configuration;

vmLittleThings::language_load_VM();

$doc->addStyleSheet(JURI::base(true)  . '/' . 'components' . '/' . 'com_vehiclemanager' . '/' . 'includes' . '/' . 'vehiclemanager.css');



if (!function_exists('sefreltoabs')) {

    function sefRelToAbs($value) {
        //Need check!!!
        // Replace all &amp; with & as the router doesn't understand &amp;
        $url = str_replace('&amp;', '&', $value);
        if (substr(strtolower($url), 0, 9) != "index.php")
            return $url;
        $uri = JURI::getInstance();
        $prefix = $uri->toString(array('scheme', 'host', 'port'));
        return $prefix . JRoute::_($url);
    }

}



$database->setQuery("SELECT id FROM #__menu WHERE link LIKE'%option=com_vehiclemanager%' AND params LIKE '%back_button%'");
$ItemId_tmp_from_db = $database->loadResult();

$defaultDesign = $params->get('defaultDesign');
$background = $params->get('background');
$displaytype = $params->get('displaytype', 0);

$moduleclass_sfx = $params->get('moduleclass_sfx', '');
$count = intval($params->get('count', 1));
$g_words = $params->get('words', '');
$showtitle = $params->get('showtitle', '');
$showcover = $params->get('showimage', 1);
$showdescription = $params->get('showdescription', 1);

$coversize = $params->get('imagesize', '127');
$sortnewby = $params->get('sortnewby', 0);
$ItemId_tmp_from_params = $params->get('ItemId');
if ($ItemId_tmp_from_params == "") {
    $ItemId_tmp = $ItemId_tmp_from_db;
} else {
    $ItemId_tmp = $ItemId_tmp_from_params;
}

switch ($sortnewby) {
    case 0:
        $sql_orderby_query = "date"; // Last Edited
        break;
    case 1:
        $sql_orderby_query = "id";  // Last Added
        break;
}
$s = vmLittleThings::getWhereUsergroupsCondition();

$query = "SELECT language FROM #__modules WHERE id = '$module->id'";
$database->setQuery($query);
$langmodule = $database->loadResult();
 
        if (isset($langContent))
        {
            $lang = $langContent;
            $query = "SELECT lang_code FROM #__languages WHERE sef = '$lang'";
            $database->setQuery($query);
            $lang = $database->loadResult();
            $lang = " and (a.language like 'all' or a.language like '' or a.language like '*' or a.language is null or a.language like '$lang')
                     AND (c.language like 'all' or c.language like '' or c.language like '*' or c.language is null or c.language like '$lang') ";
        } else
        {
            $lang = "";
        }
        
if($langmodule != "" && $langmodule != "*"){
        $selectstring = "SELECT a.*, c.id as catid FROM #__vehiclemanager_vehicles AS a
                        \nLEFT JOIN #__vehiclemanager_categories AS vc ON vc.iditem=a.id
                        \nLEFT JOIN #__vehiclemanager_main_categories AS c ON c.id=vc.idcat
                        WHERE a.published=1 AND a.language = '".$langmodule."' AND ($s) $lang " .
                        " AND c.published='1'" ." AND a.approved='1'" .
                        "\nGROUP BY a.id" .
                        "\nORDER BY " . $sql_orderby_query . " DESC LIMIT 0,$count;";
}
else{
        $selectstring = "SELECT a.*, c.id as catid FROM #__vehiclemanager_vehicles AS a
                        \nLEFT JOIN #__vehiclemanager_categories AS vc ON vc.iditem=a.id
                        \nLEFT JOIN #__vehiclemanager_main_categories AS c ON c.id=vc.idcat
                        WHERE a.published=1 AND ($s) $lang " .
                        " AND c.published='1'" ." AND a.approved='1'" .
                        "\nGROUP BY a.id" .
                        "\nORDER BY " . $sql_orderby_query . " DESC LIMIT 0,$count;";
}

$database->setQuery($selectstring);
$rows = $database->loadObjectList();

if (!function_exists('picture_thumbnail')){
    function picture_thumbnail($file, $high_original, $width_original) {
        

        // get name and type
        $file_inf = pathinfo($file);
        $tmp_type = explode(".", $file_inf['basename']);
        $file_type = "." . end($tmp_type);
        $file_name = basename($file_inf['basename'], $file_type);
        
        // Setting the resize parameters
        list($width, $height) = getimagesize('./components/com_vehiclemanager/photos/' . $file);

        $size = "_" . $high_original . "_" . $width_original;

        if (file_exists('./components/com_vehiclemanager/photos/' . $file_name . $size . $file_type)) {
            return $file_name . $size . $file_type;
        } else {
            if ($width < $height) {
                if ($height > $high_original) {
                    $k = $height / $high_original;
                } else if ($width > $width_original) {
                    $k = $width / $width_original;
                }
                else
                    $k = 1;
            } else {
                if ($width > $width_original) {
                    $k = $width / $width_original;
                } else if ($height > $high_original) {
                    $k = $height / $high_original;
                }
                else
                    $k = 1;
            }
            $w_ = $width / $k;
            $h_ = $height / $k;
        }

        // Creating the Canvas
        $tn = imagecreatetruecolor($w_, $h_);

        switch (strtolower($file_type)) {
            case '.png':
                $source = imagecreatefrompng('./components/com_vehiclemanager/photos/' . $file);
                $file = imagecopyresampled($tn, $source, 0, 0, 0, 0, $w_, $h_, $width, $height);
                imagepng($tn, './components/com_vehiclemanager/photos/' . $file_name . $size . $file_type);
                break;
            case '.jpg':
                $source = imagecreatefromjpeg('./components/com_vehiclemanager/photos/' . $file);
                $file = imagecopyresampled($tn, $source, 0, 0, 0, 0, $w_, $h_, $width, $height);
                imagejpeg($tn, './components/com_vehiclemanager/photos/' . $file_name . $size . $file_type);
                break;
            case '.jpeg':
                $source = imagecreatefromjpeg('./components/com_vehiclemanager/photos/' . $file);
                $file = imagecopyresampled($tn, $source, 0, 0, 0, 0, $w_, $h_, $width, $height);
                imagejpeg($tn, './components/com_vehiclemanager/photos/' . $file_name . $size . $file_type);

                break;
            case '.gif':
                $source = imagecreatefromgif('./components/com_vehiclemanager/photos/' . $file);
                $file = imagecopyresampled($tn, $source, 0, 0, 0, 0, $w_, $h_, $width, $height);
                imagegif($tn, './components/com_vehiclemanager/photos/' . $file_name . $size . $file_type);
                break;
            default:
                echo 'not support';
                return;
        }

        return $file_name . $size . $file_type;
    }
}
  ?>  
<?php if ($defaultDesign == 1) { ?>
    <style type="text/css">
        #last_added {}
        .new_all {
            margin: 10px 10px;
            padding: 10px;
            border: 1px solid #D6D6D6;
           /* width:200px;
            */
            overflow:hidden;
        }
        .new_image {text-align:center;}
        .new_title {}
        .new_text {}
        .new_btn {}
        .new_btn_a {}
    </style>
<?php } ?>
<?php 
if (version_compare(JVERSION, "3.0.0", "lt"))
    require(JModuleHelper::getLayoutPath('mod_vehiclemanager_new', $params->get('layout', 'default'))); else
    require (JModuleHelper::getLayoutPath('mod_vehiclemanager_new_j3', $params->get('layout', 'default')));	
 ?>