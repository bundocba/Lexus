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

JLoader::register('ContentHelper', JPATH_ADMINISTRATOR . '/components/com_content/helpers/content.php');
JLoader::register('CategoryHelperAssociation', JPATH_ADMINISTRATOR . '/components/com_categories/helpers/association.php');

abstract class VehiclemanagerHelperAssociation extends CategoryHelperAssociation{


  public static function getAssociations($id = 0, $view = null){

      if(isset($_REQUEST['task'])){

          $task = $_REQUEST['task'];
          JLoader::import('helpers.route', JPATH_COMPONENT_SITE);

          if($task == 'showCategory' || $task == 'alone_category'  ){

              $catid = intval(mosGetParam($_REQUEST, 'catid', 0));

              if($catid){
                $rederectUrlArr = VehiclemanagerHelperRoute::getVmCategoryRoute( $catid );
                return $rederectUrlArr;
              }
          }

          if( $task == 'view' || $task == 'view_vehicle'  ){

              $id = intval(mosGetParam($_REQUEST, 'id', 0));


              if ($id){
                $rederectUrlArr = VehiclemanagerHelperRoute::getVmAssocRoute($id);
                return $rederectUrlArr;
              }
          }
      }

      return array();
  }
}
