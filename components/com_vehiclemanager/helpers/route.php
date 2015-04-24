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

abstract class VehiclemanagerHelperRoute{

  protected static $lookup = array();

  protected static $lang_lookup = array();

  public static function getVmAssocRoute($id){

      $database = JFactory::getDBO();
      $link = array();
      $vehiclesIdArr = array();
      $associate_vehicles = array();

      if( isset($id) ){
          $query = "SELECT associate_vehicle FROM #__vehiclemanager_vehicles WHERE id = $id";
          $database->setQuery($query);
          $associate_vm = $database->loadResult();

          if($associate_vm != "" ) $associate_vehicles = unserialize($associate_vm);

          if(count($associate_vehicles) > 0){
              foreach($associate_vehicles as $one){
                  if($one != 0){
                      $vehiclesIdArr[] = $one;
                  }
              }


              $vehiclesIdStr = implode(',', $vehiclesIdArr);
              $query = "SELECT id, language
                          FROM #__vehiclemanager_vehicles
                          WHERE id in ( $vehiclesIdStr )";
              $database->setQuery($query);
              $assocVehicles = $database->loadAssocList();

              foreach ($assocVehicles as $value) {
                  $lang = $value['language'];
                  $CurId = $value['id'];

                  if(isset($assocVehicles)){
                    $query = "SELECT idcat
                                  FROM #__vehiclemanager_categories
                                  WHERE iditem = $CurId";
                      $database->setQuery($query);
                      $assocVehicleCat = $database->loadResult();
                  }
                  $link[$lang] = "index.php?option=com_vehiclemanager&task=view_vehicle&catid=$assocVehicleCat&id=$CurId";

                  $needles = array();
                  if ( $lang != "*" && JLanguageMultilang::isEnabled())
                  {
                    self::buildLanguageLookup();

                    if (isset(self::$lang_lookup[$lang]))
                    {
                      $link[$lang] .= '&lang=' . self::$lang_lookup[$lang];
                      $needles['language'] = $lang;
                    }
                  }

                  if ($item = self::_findItem($needles))
                  {
                    $link[$lang] .= '&Itemid=' . $item;
                  }
              }
          }
      }

      return $link;
  }

  public static function getVmCategoryRoute($catid){


          $database = JFactory::getDBO();
          $link = array();
          $assos_ids = array();

          if(isset($catid) ){
            $catIdArr = array();

            $query = "SELECT associate_category FROM #__vehiclemanager_main_categories WHERE id = $catid";
            $database->setQuery($query);
            $ids = $database->loadResult();

            if($ids != "" ) $assos_ids = unserialize($ids);


            if(count($assos_ids) > 0){
                foreach($assos_ids as $oneCat){
                    if($oneCat != 0){
                        $catIdArr[] = $oneCat;
                    }
                }

                $catIdStr = implode(',', $catIdArr);
                $query = "SELECT id, language
                            FROM #__vehiclemanager_main_categories
                             WHERE id in ($catIdStr)";
                $database->setQuery($query);
                $assocCategory = $database->loadAssocList();

                foreach ($assocCategory as $value) {
                    $lang = $value['language'];
                    $CurId = $value['id'];

                    $link[$lang] = "index.php?option=com_vehiclemanager&task=showCategory&catid=$CurId";

                    $needles = array();
                    if ( $lang != "*" && JLanguageMultilang::isEnabled())
                    {
                      self::buildLanguageLookup();

                      if (isset(self::$lang_lookup[$lang]))
                      {
                        $link[$lang] .= '&lang=' . self::$lang_lookup[$lang];
                        $needles['language'] = $lang;
                      }
                    }

                    if ($item = self::_findItem($needles))
                    {
                      $link[$lang] .= '&Itemid=' . $item;
                    }
                }
            }
        }

        return $link;
  }

  protected static function buildLanguageLookup()
  {
    if (count(self::$lang_lookup) == 0)
    {
      $db    = JFactory::getDbo();
      $query = $db->getQuery(true)
        ->select('a.sef AS sef')
        ->select('a.lang_code AS lang_code')
        ->from('#__languages AS a');

      $db->setQuery($query);
      $langs = $db->loadObjectList();

      foreach ($langs as $lang)
      {
        self::$lang_lookup[$lang->lang_code] = $lang->sef;
      }
    }
  }


  protected static function _findItem($needles = null)
  {
    $app      = JFactory::getApplication();
    $menus    = $app->getMenu('site');
    $language = isset($needles['language']) ? $needles['language'] : '*';

    // Prepare the reverse lookup array.
    if (!isset(self::$lookup[$language]))
    {
      self::$lookup[$language] = array();

      $component  = JComponentHelper::getComponent('com_vehiclemanager');

      $attributes = array('component_id');
      $values     = array($component->id);

      if ($language != '*')
      {
        $attributes[] = 'language';
        $values[]     = array($needles['language'], '*');
      }

      $items = $menus->getItems($attributes, $values);

      foreach ($items as $item)
      {
        if (isset($item->query) && (isset($item->query['view']) || isset($item->query['task'] ) ) )
        {
          if ( isset($item->query['view'] ) )  $view = $item->query['view'];
          else $view = $item->query['task'];

          if (!isset(self::$lookup[$language][$view]))
          {
            self::$lookup[$language][$view] = array();
          }

          if (isset($item->query['id']))
          {
            /**
             * Here it will become a bit tricky
             * language != * can override existing entries
             * language == * cannot override existing entries
             */
            if (!isset(self::$lookup[$language][$view][$item->query['id']]) || $item->language != '*')
            {
              self::$lookup[$language][$view][$item->query['id']] = $item->id;
            }
          }
        }
      }
    }

    if ($needles)
    {
      foreach ($needles as $view => $ids)
      {
        if (isset(self::$lookup[$language][$view]))
        {
          foreach ($ids as $id)
          {
            if (isset(self::$lookup[$language][$view][(int) $id]))
            {
              return self::$lookup[$language][$view][(int) $id];
            }
          }
        }
      }
    }

    // Check if the active menuitem matches the requested language
    $active = $menus->getActive();

    if ($active && $active->component == 'com_vehiclemanager' &&
      ($language == '*' || in_array($active->language, array('*', $language)) || !JLanguageMultilang::isEnabled()))
    {
      return $active->id;
    }

    // If not found, return language specific home link
    $default = $menus->getDefault($language);

    return !empty($default->id) ? $default->id : null;
  }

}
