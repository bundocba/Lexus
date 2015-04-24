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

    global $hide_js, $Itemid, $acl, $mosConfig_live_site, $my,$mainframe;
    $doc = JFactory::getDocument();  
    $doc->addStyleSheet( $mosConfig_live_site.'/components/com_vehiclemanager/includes/vehiclemanager.css' );
    ?>
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

<?php positions_vm($params->get('allcategories01'));?>
    <div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
      <?php //echo $currentcat->header; ?>
    </div>
<?php positions_vm($params->get('allcategories02'));?>
    <div class="category_title basictable">
        <div class="row_01">
            <span class="col_01">
          <?php echo $currentcat->descrip; ?>
            </span>
            <span class="col_02">
                <img src="<?php echo $mosConfig_live_site; ?>/components/com_vehiclemanager/images/vm_logo.png" align="right" alt="Vehicles"/>
            </span>
        </div>
    </div>
<?php positions_vm($params->get('allcategories03'));?>
<?php if ($params->get('show_search')){?>
    <div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
        <div class="basictable_44 basictable">
            <?php
                $link = 'index.php?option=com_vehiclemanager&amp;task=show_search_vehicle&amp;Itemid='. $Itemid;
                //$link = 'index.php?option=com_vehiclemanager&amp;task=show_search_vehicle&amp;catid='. $catid. '&amp;Itemid='. $Itemid;
            ?> 
	   <div class="search_button_vehicle">
            <a href="<?php echo JRoute::_($link, false); ?>" class="category<?php echo $params->get( 'pageclass_sfx' ); ?>">
                <img src="<?php echo $mosConfig_live_site; ?>/components/com_vehiclemanager/images/search.png" alt="?" border="0" />
                <?php echo _VEHICLE_MANAGER_LABEL_SEARCH; ?>
            </a>
	  </div>
        </div>
    </div>
<?php } ?>    
    <br/>
    <br/>
    <?php 
      HTML_vehiclemanager::listCategories($params, $categories, $catid, $tabclass , $currentcat);
    ?>
        <div  class="basictable_45 basictable">
            <?php mosHTML::BackButton ( $params, $hide_js ); ?>
        </div>
    <br/>
    
