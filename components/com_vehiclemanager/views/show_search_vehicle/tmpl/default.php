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

global $hide_js, $Itemid, $mainframe, $mosConfig_live_site, $doc, $vehiclemanager_configuration;
$doc->addStyleSheet($mosConfig_live_site . '/components/com_vehiclemanager/includes/vehiclemanager.css');
//$doc->addScript($mosConfig_live_site.'/includes/js/joomla.javascript.js');
?>

<!--[if IE]>
<style type="text/css">
  .basictable {
    zoom: 1;     /* triggers hasLayout */
    }  /* Only IE can see inside the conditional comment
    and read this CSS rule. Don't ever use a normal HTML
    comment inside the CC or it will close prematurely. */
</style>
<![endif]-->

<?php positions_vm($params->get('showsearch01')); ?>
<div class="span6 componentheading<?php echo $params->get('pageclass_sfx'); ?>">
    <h3><?php echo $currentcat->header; ?></h3>
</div>
<?php positions_vm($params->get('showsearch02')); ?>
<div class="basictable_39 basictable">
    <div class="row_01">
<?php
if ($currentcat->img != null && $currentcat->align == 'left') {
    ?>
      <span class="col_01">
          <img src="<?php echo $currentcat->img; ?>" alt="img" align="<?php echo $currentcat->align; ?>" />
      </span>
       <?php
        }
        ?>
        <span class="col_02">
        <?php //echo $currentcat->descrip; ?>
        </span>
        <?php
        if ($currentcat->img != null && $currentcat->align == 'right') {
            ?>
            <span class="col_03">
                <img src="<?php echo $currentcat->img; ?>" align="<?php echo $currentcat->align; ?>"  alt = "?"/>
            </span>
            <?php
        }
        ?>
    </div>
</div>
<br />

<script type="text/javascript">
    function vm_showDate()
    {
        if(document.userForm1.search_date_box.checked )
        {
            var x=document.getElementById("search_date_from");
            document.userForm1.search_date_from.type="text";

            var x=document.getElementById("search_date_until");
            document.userForm1.search_date_until.type="text";

        }
        else
        {
            var x=document.getElementById("search_date_from");
            document.userForm1.search_date_from.type="hidden";

            var x=document.getElementById("search_date_until");
            document.userForm1.search_date_until.type="hidden";
        }

    }

</script>
<?php positions_vm($params->get('showsearch03')); ?>

<?php $path = "index.php?option=" . $option . "&amp;task=search_vehicle&amp;Itemid=" . $Itemid; ?>

<form action="<?php echo sefRelToAbs($path); //JRoute::_($path);?>" method="get" name="userForm1" id="userForm1">
    <input type="hidden" name="option" value="<?php echo $option; ?>" />
    <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
    <input type="hidden" name="task" value="search_vehicle" />

    <div class="search_filter">

        <div class="row_01">

            <div class="fix_width_3">
                <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_SEARCH_KEYWORD; ?></span>
                <input class="inputbox" type="text" name="searchtext" size="20" maxlength="20"/>
		<br />
                <input type="submit" name="submit" value="<?php echo _VEHICLE_MANAGER_LABEL_SEARCH_BUTTON; ?>" class="button search_f" />
            </div>

        </div> <!-- row_01 -->

        <div class="row_02">

            <div class="fix_width_2">
                <span class="col_01"><?php echo _VEHICLE_MANAGER_LABEL_CATEGORY; ?></span>
                <?php echo $clist; ?>
            </div>

      </div> <!-- row_02 -->
<input type="hidden" name="Address" value="on" >
<input type="hidden" name="Title" value="on" >
<input type="hidden" name="Description" value="on" >
<input type="hidden" name="Engine_type" value="on" >
<input type="hidden" name="Exterior_colors" value="on" >
<input type="hidden" name="Exterior_extras" value="on" >
<input type="hidden" name="Dashboard_options" value="on" >
<input type="hidden" name="Interior_extras" value="on" >
<input type="hidden" name="Interior_colors" value="on" >
<input type="hidden" name="Wheeltype" value="on" >
<input type="hidden" name="Warranty_options" value="on" >
<input type="hidden" name="Safety_options" value="on" >
<input type="hidden" name="Vehicleid" value="on" >
<input type="hidden" name="Country" value="on" >
<input type="hidden" name="Region" value="on" >
<input type="hidden" name="City" value="on" >
<input type="hidden" name="District" value="on" >
<input type="hidden" name="Zipcode" value="on" >
<input type="hidden" name="Mileage" value="on" >
<input type="hidden" name="Contacts" value="on" >
<input type="hidden" name="City_fuel_mpg" value="on" >
<input type="hidden" name="Highway_fuel_mpg" value="on" >
<input type="hidden" name="Wheelbase" value="on" >
<input type="hidden" name="Rear_axe_type" value="on" >
<input type="hidden" name="Brakes_type" value="on" >
<input type="hidden" name="Vm_model" value="on" >
<input type="hidden" name="Maker" value="on" >
      

 </div> <!--  search_filter  -->
    <br />

    <div class="basictable_41 basictable">
        <?php mosHTML::BackButton($params, $hide_js); ?>
    </div>

</form>
<div style="text-align: center;"><a href="http://ordasoft.com" style="font-size: 10px;">Powered by OrdaSoft!</a></div>
<?php positions_vm($params->get('showsearch04')); ?>
