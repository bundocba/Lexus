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

if (!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);

if (isset($GLOBALS['mosConfig_absolute_path']))
    $mosConfig_absolute_path = $GLOBALS['mosConfig_absolute_path'];
else
    $mosConfig_absolute_path = JPATH_SITE; //JURI::base(true); // if file is calling from the module

include_once ($mosConfig_absolute_path . DS . 'components' . DS . 'com_vehiclemanager' . DS . 'vehiclemanager.main.categories.class.php');
require_once ($mosConfig_absolute_path . DS . 'components' . DS . 'com_vehiclemanager' . DS . 'includes' . DS . 'parameters.php');
if (version_compare(JVERSION, '3.0', 'lt'))
{
    require_once (JPATH_ROOT . DS . 'libraries' . DS . 'joomla' . DS . 'database' . DS . 'table' . DS . 'menu.php' );
}
require_once ($mosConfig_absolute_path . DS . 'components' . DS . 'com_vehiclemanager' . DS . 'includes' . DS . 'menu.php' );
jimport('joomla.html.pagination');

if (!isset($GLOBALS['vehiclemanager_configuration']))
{
    require_once (JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_vehiclemanager' . DS . 'admin.vehiclemanager.class.conf.php' );
    $GLOBALS['vehiclemanager_configuration'] = isset($vehiclemanager_configuration) ? $vehiclemanager_configuration : null ;
}


/**
 * Legacy function, use <jdoc:include type="module" /> instead
 *
 * @deprecated As of version 1.5
 */
if (!function_exists('mosLoadModule'))
{

    function mosLoadModule($name, $style = -1)
    {
        ?><jdoc:include type="module" name="<?php echo $name ?>" style="<?php echo $style ?>" /><?php
    }

}


/**
 * Legacy function, using <jdoc:include type="modules" /> instead
 *
 * @deprecated  As of version 1.5
 */
if (!function_exists('mosMail'))
{

    function mosMail($from, $fromname, $recipient, $subject, $body, $mode = 0, $cc = NULL, $bcc = NULL, $attachment = NULL, $replyto = NULL, $replytoname = NULL)
    {
        $mail = JMail::getInstance();
        return $mail->sendMail($from, $fromname, $recipient, $subject, $body, $mode, $cc, $bcc, $attachment, $replyto, $replytoname);
    }

}
if (!function_exists('date_to_data_ms')){
    function date_to_data_ms($data_string){             // 2014-01-25 covetr to date in ms
        global $database;

//        $date = data_transform_vm($data_string);

//         $query = "SELECT UNIX_TIMESTAMP('$data_string')"; 
//         $database->setQuery($query);
//         $rent_ms = $database->loadResult(); 
//         
//         return $rent_ms;
          $rent_mas = explode('-', $data_string);
          $month=$rent_mas[1];
          $day=$rent_mas[2];
          $year=$rent_mas[0];
          $rent_ms = mktime ( 0 ,0, 0, $month , $day , $year);
          return $rent_ms;
    }
}

if (!function_exists('mosLoadAdminModules'))
{

    function mosLoadAdminModules($position = 'left', $style = 0)
    {
        // Select the module chrome function
        if (is_numeric($style))
        {
            switch ($style) {
                case 2:
                    $style = 'xhtml';
                    break;
                case 0:
                default:
                    $style = 'raw';
                    break;
            }
        }
        ?><jdoc:include type="modules" name="<?php echo $position ?>" style="<?php echo $style ?>" /><?php
    }

}


/**
 * Legacy function, using <jdoc:include type="module" /> instead
 *
 * @deprecated  As of version 1.5
 */
if (!function_exists('mosLoadAdminModule'))
{

    function mosLoadAdminModule($name, $style = 0)
    {
        ?><jdoc:include type="module" name="<?php echo $name ?>" style="<?php echo $style ?>" /><?php
    }

}


/**
 * Legacy function, always use {@link JRequest::getVar()} instead
 *
 * @deprecated  As of version 1.5
 */
if (!function_exists('mosStripslashes'))
{

    function mosStripslashes(&$value)
    {
        $ret = '';
        if (is_string($value))
        {
            $ret = stripslashes($value);
        } else
        {
            if (is_array($value))
            {
                $ret = array();
                foreach ($value as $key => $val)
                    $ret[$key] = mosStripslashes($val);
            } else
                $ret = $value;
        }
        return $ret;
    }

}


/**
 * Legacy function, use {@link JFolder::files()} or {@link JFolder::folders()} instead
 *
 * @deprecated  As of version 1.5
 */
if (!function_exists('mosReadDirectory'))
{

    function mosReadDirectory($path, $filter = '.', $recurse = false, $fullpath = false)
    {
        $arr = array(null);
        // Get the files and folders
        jimport('joomla.filesystem.folder');
        $files = JFolder::files($path, $filter, $recurse, $fullpath);
        $folders = JFolder::folders($path, $filter, $recurse, $fullpath);
        // Merge files and folders into one array
        $arr = array();
        if (is_array($files))
            $arr = $files;
        if (is_array($folders))
            $arr = array_merge($arr, $folders);
        // Sort them all
        asort($arr);
        return $arr;
    }

}


/**
 * Legacy function, use {@link JApplication::redirect() JApplication->redirect()} instead
 *
 * @deprecated  As of version 1.5
 */
if (!function_exists('mosRedirect'))
{

    function mosRedirect($url, $msg = '')
    {
        global $mainframe;
        $mainframe->redirect($url, $msg);
    }

}


if (!function_exists("formatMoney"))
{

    function formatMoney($number, $fractional = false, $pattern = ".")
    {

        if(preg_match("/\d/", $pattern)){

            $msg = "Your separator: $pattern - incorrect, you can not use numbers, to split price" ;
            echo '<script>alert("'.$msg.'");</script>';
            $pattern = ".";      
        }
        
        if ($fractional)
        {
            $number = sprintf('%.2f', $number);
        }
        if ($pattern == ".")
            $number = str_replace(".", ",", $number);

        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1' . $pattern . '$2', $number);
            //echo $replaced."<br>";
            if ($replaced != $number)
            {
                $number = $replaced;
            } else
            {
                break;
            }
        }
        // $number = preg_replace('/\^/', $number, $pattern);
        return $number;
    }

}



/**
 * Legacy function, use {@link JArrayHelper::getValue()} instead
 *
 * @deprecated  As of version 1.5
 */
if (!function_exists('mosGetParam'))
{

    function mosGetParam(&$arr, $name, $def = null, $mask = 0)
    {
        // Static input filters for specific settings
        static $noHtmlFilter = null;
        static $safeHtmlFilter = null;

        $var = JArrayHelper::getValue($arr, $name, $def, '');

        // If the no trim flag is not set, trim the variable
        if (!($mask & 1) && is_string($var))
            $var = trim($var);

        // Now we handle input filtering
        if ($mask & 2)
        {
            // If the allow html flag is set, apply a safe html filter to the variable
            if (is_null($safeHtmlFilter))
                $safeHtmlFilter = JFilterInput::getInstance(null, null, 1, 1);
            $var = $safeHtmlFilter->clean($var, 'none');
        } elseif ($mask & 4)
        {
            // If the allow raw flag is set, do not modify the variable
            $var = $var;
        } else
        {
            // Since no allow flags were set, we will apply the most strict filter to the variable
            if (is_null($noHtmlFilter))
            {
                $noHtmlFilter = JFilterInput::getInstance(/* $tags, $attr, $tag_method, $attr_method, $xss_auto */);
            }
            $var = $noHtmlFilter->clean($var, 'none');
        }
        return $var;
    }

}


/**
 * Legacy function, use {@link JEditor::save()} or {@link JEditor::getContent()} instead
 *
 * @deprecated  As of version 1.5
 */
if( !function_exists('editorArea')) {
    function editorArea($name, $content, $hiddenField, $width, $height, $col, $row,$option=true) {
            jimport( 'joomla.html.editor' );
            $editor = JFactory::getEditor();
            echo $editor->display($hiddenField, $content, $width, $height, $col, $row,$option);
    }
}


/**
 * Legacy function, use {@link JFilterOutput::objectHTMLSafe()} instead
 *
 * @deprecated  As of version 1.5
 */
if (!function_exists('mosMakeHtmlSafe'))
{

    function mosMakeHtmlSafe(&$mixed, $quote_style = ENT_QUOTES, $exclude_keys = '')
    {
        JFilterOutput::objectHTMLSafe($mixed, $quote_style, $exclude_keys);
    }

}


/**
 * Legacy utility function to provide ToolTips
 *
 * @deprecated As of version 1.5
 */
if (!function_exists('mosToolTip'))
{

    function mosToolTip($tooltip, $title = '', $width = '', $image = 'tooltip.png', $text = '', $href = '', $link = 1)
    {
        // Initialize the toolips if required
        static $init;
        if (!$init)
        {
            JHTML::_('behavior.tooltip');
            $init = true;
        }
        return JHTML::_('tooltip', $tooltip, $title, $image, $text, $href, $link);
    }

}


/**
 * Legacy function to replaces &amp; with & for xhtml compliance
 *
 * @deprecated  As of version 1.5
 */
if (!function_exists('mosTreeRecurse'))
{

    function mosTreeRecurse($id, $indent, $list, &$children, $maxlevel = 9999, $level = 0, $type = 1)
    {
        jimport('joomla.html.html');
        return JHTML::_('menu.treerecurse', $id, $indent, $list, $children, $maxlevel, $level, $type);
    }

}
if(!class_exists('vmLittleThings')){
class vmLittleThings
{

    static function getGroupsByUser($uid, $recurse)
    {
        if (version_compare(JVERSION, "1.6.0", "lt"))
        {
            
        } else if (version_compare(JVERSION, "1.6.0", "ge") && version_compare(JVERSION, "3.5.0", "lt"))
        {
            $database = JFactory::getDBO();
            // Custom algorythm
            $usergroups = array();
            if ($recurse == 'RECURSE')
            {
                // [1]: Recurse getting the usergroups
                $id_group = array();
                $q1 = "SELECT group_id FROM `#__user_usergroup_map` WHERE user_id={$uid}";
                $database->setQuery($q1);
                $rows1 = $database->loadObjectList();
                foreach ($rows1 as $v)
                    $id_group[] = $v->group_id;
                for ($k = 0; $k < count($id_group); $k++) {
                    $q = "SELECT g2.id FROM `#__usergroups` g1 LEFT JOIN `#__usergroups` g2 ON g1.lft > g2.lft AND g1.lft < g2.rgt WHERE g1.id={$id_group[$k]} ORDER BY g2.lft";
                    $database->setQuery($q);
                    $rows = $database->loadObjectList();
                    foreach ($rows as $r)
                        $usergroups[] = $r->id;
                }
                $usergroups = array_unique($usergroups);
            }
            // [2]: Non-Recurse getting usergroups
            $q = "SELECT * FROM #__user_usergroup_map WHERE user_id = {$uid}";
            $database->setQuery($q);
            $rows = $database->loadObjectList();
            foreach ($rows as $k => $v)
                $usergroups[] = $rows[$k]->group_id;

            // If user is unregistered, Joomla contains it into standard group (Public by default).
            // So, groupId for anonymous users is 1 (by default).
            // But custom algorythm doesnt do this: if user is not autorised, he will NOT connected to any group.
            // And groupId will be 0. 
            if (count($rows) == 0)
                $usergroups[] = -2;
            return $usergroups;
        } else
        {
            echo "Sanity test. Error version check!";
            exit;
        }
    }

    /*
      [description]: instead of using $usergroups.
      (alias_name) its a `#__vehiclemanager_main_categories` table alias.
      (alias_name) depends of the particular query, as usual its "c", "cc" or something like this.
      [call]: $s = vmLittleThings::getWhereUsergroupsString ( "alias_name" );
      [returns]: a WHERE condition for SQL query
      which can be inserted into query like ({$s})
     */

    static function getWhereUsergroupsCondition($table_alias = "c")
    {
        if (version_compare(JVERSION, "1.6.0", "lt"))
        {
            global $my;
            if (!isset($my))
            { // echo "User is logged out"; 
                if ($my = JFactory::getUser())
                    $gid = $my->gid; else
                    $gid = 0;
            } else
                $gid = $my->gid;
            $usergroups_sh = array($gid, -2);
            $s = '';
            for ($i = 0; $i < count($usergroups_sh); $i++) {
                $g = $usergroups_sh[$i];
                $s .= " $table_alias.params LIKE '%,{$g}' or $table_alias.params = '{$g}' or $table_alias.params LIKE '{$g},%' or $table_alias.params LIKE '%,{$g},%' ";
                if (($i + 1) < count($usergroups_sh))
                    $s .= ' or ';
            }
            return $s;
        } else if (version_compare(JVERSION, "1.6.0", "ge") && version_compare(JVERSION, "3.5.0", "lt"))
        {
            $my = JFactory::getUser();
            if (isset($my->id) AND $my->id != 0)
                $usergroups_sh = vmLittleThings::getGroupsByUser($my->id, '');
            else
                $usergroups_sh = array();
            $usergroups_sh[] = -2;

            $s = '';
            for ($i = 0; $i < count($usergroups_sh); $i++) {
                $g = $usergroups_sh[$i];
                $s .= " $table_alias.params LIKE '%,{$g}' or $table_alias.params = '{$g}' or $table_alias.params LIKE '{$g},%' or $table_alias.params LIKE '%,{$g},%' ";
                if (($i + 1) < count($usergroups_sh))
                    $s .= ' or ';
            }
            return $s;
        } else
        {
            echo "Sanity test. Error version check!";
            exit;
        }
    }

    /*
     * function categoryArray () 
     * Replaces the old com_veh_categoryArray ()
     * Returns the Category list depending of user access level.
     */

    static function categoryArray()
    {
        global $database, $my;
        $s = vmLittleThings::getWhereUsergroupsCondition("c");
        $query = "SELECT c.*, c.parent_id AS parent, c.params AS access"
                . "\n FROM #__vehiclemanager_main_categories AS c"
                . "\n  LEFT JOIN #__vehiclemanager_categories AS vc ON c.id=vc.idcat \n"
                . "LEFT JOIN #__vehiclemanager_vehicles AS v ON v.id=vc.iditem AND v.published=1 AND v.approved=1"
                . "\n WHERE section='com_vehiclemanager'"
                . "\n AND c.published <> -2"
                . "\n AND ({$s})"
                . "\n ORDER BY ordering";
        $database->setQuery($query);
        $items = $database->loadObjectList();

        // establish the hierarchy of the menu
        $children = array();
        // first pass - collect children
        foreach ($items as $v) {
            $pt = $v->parent;
            $list = @$children[$pt] ? $children[$pt] : array();
            array_push($list, $v);
            $children[$pt] = $list;
        }
        // second pass - get an indent list of the items
        $array = vmLittleThings::vehicleManagerTreeRecurse(0, '', array(), $children);
        return $array;
    }

    /*
     * Redefines a standard function to not display &nbsp;
     * 1.6
     */

    static function vehicleManagerTreeRecurse($id, $indent, $list, &$children, $maxlevel = 9999, $level = 0, $type = 1)
    {
        if (@$children[$id] && $level <= $maxlevel)
        {
            $parent_id = $id;
            foreach ($children[$id] as $v) {
                $id = $v->id;
                if ($type)
                {
                    $pre = " ";
                    $spacer = '. -- ';
                } else
                {
                    $pre = "- ";
                    $spacer = ' . -';
                }
                if ($v->parent == 0)
                {
                    $txt = $v->name;
                } else
                {
                    $txt = $pre . $v->name;
                }
                $pt = $v->parent;
                $list[$id] = $v;
                $list[$id]->treename = "$indent$txt";
                $list[$id]->children = count(@$children[$id]);
                $list[$id]->all_fields_in_list = count(@$children[$parent_id]);
                $list = vmLittleThings::vehicleManagerTreeRecurse($id, $indent . $spacer, $list, $children, $maxlevel, $level + 1, $type);
            }
        }
        return $list;
    }

    // An updated back-end SubMenu helper 
    static function addSubmenu($vName)
    {
        if (!defined('_VEHICLE_HEADER_NUMBER')) vmLittleThings::loadConstVechicle();
        JSubMenuHelper::addEntry(
                JText::_(_VEHICLE_HEADER_NUMBER), 'index.php?option=com_vehiclemanager', $vName == 'Vehicles'
        );
        JSubMenuHelper::addEntry(
                JText::_(_VEHICLE_CATEGORIES_NAME), 'index.php?option=com_vehiclemanager&section=categories', $vName == 'Categories'
        );  
        JSubMenuHelper::addEntry(
                JText::_(_VEHICLE_MANAGER_ADMIN_RENT_REQUESTS), 'index.php?option=com_vehiclemanager&task=rent_requests', $vName == 'Rent Requests'
        );
        JSubMenuHelper::addEntry(
                JText::_(_VEHICLE_MANAGER_ADMIN_SALE_MANAGER_MENU), 'index.php?option=com_vehiclemanager&task=buying_requests', $vName == 'Sale Manager'
        );
        JSubMenuHelper::addEntry(
                JText::_(_VEHICLE_MANAGER_ADMIN_FEATURES_MANAGER_MENU), 'index.php?option=com_vehiclemanager&section=featured_manager', $vName == 'Features Manager'
        );
        JSubMenuHelper::addEntry(
                JText::_(_VEHICLE_MANAGER_LABEL_LANGUAGE_MENU), 'index.php?option=com_vehiclemanager&section=language_manager', $vName == 'Language Manager'
        );
 
        JSubMenuHelper::addEntry(
                JText::_(_VEHICLE_MANAGER_ADMIN_LABEL_SETTINGS), 'index.php?option=com_vehiclemanager&task=config', $vName == 'Settings'
        );
        JSubMenuHelper::addEntry(
                JText::_(_VEHICLE_MANAGER_ADMIN_ABOUT_ABOUT), 'index.php?option=com_vehiclemanager&task=about', $vName == 'About'
        );
    }
    
    static function loadConstVechicle () {
        global $database, $mosConfig_absolute_path;
        $is_exception = false;

        $database->setQuery("SELECT * FROM #__vehiclemanager_languages");
        $langs = $database->loadObjectList();

        $component_path = JPath::clean($mosConfig_absolute_path . '/components/com_vehiclemanager/lang/');
        $component_layouts = array();

        if (is_dir($component_path) && ($component_layouts = JFolder::files($component_path, '^[^_]*\.php$', false, true)))
        {       


            //check and add constants file in DB
            foreach ($component_layouts as $i => $file) {
                $file_name = pathinfo($file);
                $file_name = $file_name['filename'];

                if ($file_name === 'constant') {
                       $database->setQuery("SELECT id FROM #__vehiclemanager_const");
                       $idConst = $database->loadResult();
                       if(empty($idConst)) {
                          require($mosConfig_absolute_path . "/components/com_vehiclemanager/lang/$file_name.php");
                          foreach ( $constMas as $mas ) {
                              $database->setQuery("INSERT INTO #__vehiclemanager_const (const, sys_type) VALUES ('".$mas["const"]."','".$mas["sys_type"]."')");
                              $database->query(); 
                          }
                       }
                }
            }

            //check and add new text files in DB
            foreach ($component_layouts as $i => $file) {
                $isLang = 0;
                $file_name = pathinfo($file);
                $file_name = $file_name['filename'];
                $LangLocal = '';
                $isLang = 1;

                if ($file_name != 'constant')
                {
                    require($mosConfig_absolute_path . "/components/com_vehiclemanager/lang/$file_name.php");
                   foreach ($langs as $lang) {
                        if ($lang->lang_code == $LangLocal['lang_code'] || $lang->title == $LangLocal['title'])
                        {
                            $isLang = 0;
                            break;
                        } else
                        {
                            $isLang = 1;
                        }

                    }
                    try {
                        if ($isLang === 1 ) {
                            $database->setQuery("INSERT INTO #__vehiclemanager_languages (lang_code,title) VALUES ('" . $LangLocal['lang_code'] . "','" . $LangLocal['title'] . "')");
                            $database->query();
                            $idLang = $database->insertid();
                            foreach ($constLang as $item) {
                                $database->setQuery("SELECT id FROM #__vehiclemanager_const WHERE const = '" . $item['const'] . "'");
                                $idConst = $database->loadResult();
                                if(!array_key_exists ( 'value_const'  , $item ) ){
                                  echo "<br />:loadConstVechicle, This value constant ".$item['const']." for this lang file ". $LangLocal['title']." not exist";
                                } else {
                                  $database->setQuery("INSERT INTO #__vehiclemanager_const_languages (fk_constid,fk_languagesid,value_const) VALUES ($idConst, $idLang, " . $database->quote($item['value_const']) . ")");
                                  $database->query();
                                }
                            }
                        }
                    } catch (Exception $e) {
                        $is_exception = true;
                        echo 'Send exception, please write to admin for language check: ',  $e->getMessage(), "\n";
                    }
                    
                }
        }
        
        if($is_exception) vmLittleThings::language_check();
        
        //if text constant missing recover they in DB
        if (!defined('_VEHICLE_HEADER_NUMBER')) {

              $query = "SELECT c.const, cl.value_const ";
              $query .= "FROM #__vehiclemanager_const_languages as cl ";
              $query .= "LEFT JOIN #__vehiclemanager_languages AS l ON cl.fk_languagesid=l.id ";
              $query .= "LEFT JOIN #__vehiclemanager_const AS c ON cl.fk_constid=c.id ";
              $query .= "WHERE l.lang_code = 'en-GB'";
              $database->setQuery($query);
              $langConst = $database->loadObjectList();

              foreach ($langConst as $item) {
                  define($item->const, $item->value_const);
              }
        }
      }
      
        //if some language file missing recover it
        $component_path = JPath::clean($mosConfig_absolute_path . '/components/com_vehiclemanager/lang/');
        $component_layouts = array();
        if (is_dir($component_path) && ($component_layouts = JFolder::files($component_path, '^[^_]*\.php$', false, true))) {
            foreach ($component_layouts as $i => $file) {
                $isLang = 0;
                $file_name = pathinfo($file);
                $file_name = $file_name['filename'];
                if ($file_name != 'constant') {
                    require($mosConfig_absolute_path . "/components/com_vehiclemanager/lang/$file_name.php");
                    //$fileMas[] = $LangLocal;
                    $fileMas[] = $LangLocal['title'];
                    
                }
            }
        }
        
        $database->setQuery("SELECT title FROM #__vehiclemanager_languages");
        if (version_compare(JVERSION, '3.0', 'lt')) {
            $langs = $database->loadResultArray();
        } else {
            $langs = $database->loadColumn();
        }
    
        if (count($langs) > count($fileMas)) {
            $results = array_diff($langs, $fileMas);
            foreach ($results as $result) {
                $database->setQuery("SELECT lang_code FROM #__vehiclemanager_languages WHERE title = '$result'");
                $lang_code = $database->loadResult();
                $langfile = "<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );";
                $langfile .= "\n/**\n*\n* @package  VehicleManager\n* @copyright 2013 Andrey Kvasnevskiy-OrdaSoft(akbet@mail.ru); Rob de Cleen(rob@decleen.com);\n* Homepage: http://www.ordasoft.com\n* @version: 3.2 Pro\n*\n* */\n";
                $langfile .= "\$LangLocal = array('lang_code'=>'$lang_code', 'title'=>'$result');\n";
                $langfile .= "\$constLang = array();\n";
    
                $query = "SELECT c.const, cl.value_const ";
                $query .= "FROM #__vehiclemanager_const_languages as cl ";
                $query .= "LEFT JOIN #__vehiclemanager_languages AS l ON cl.fk_languagesid=l.id ";
                $query .= "LEFT JOIN #__vehiclemanager_const AS c ON cl.fk_constid=c.id ";
                $query .= "WHERE l.title = '$result'";
    
                $database->setQuery($query);
                $constlanguages = $database->loadObjectList();
    
                foreach ($constlanguages as $constlanguage) {
                    $langfile .= "\$constLang[] = array('const'=>'" . $constlanguage->const . "', 'value_const'=>'" . mysql_real_escape_string($constlanguage->value_const) . "');\n";
                }
    
                // Write out new initialization file
                $fd = fopen($mosConfig_absolute_path . "/components/com_vehiclemanager/lang/$result.php", "w") or die("Cannot create language file.");
                fwrite($fd, $langfile);
                fclose($fd);
            }
        }

        //vmLittleThings::language_check();
      
    }


    static function language_load_VM( ) {
      $database = JFactory::getDBO();

      // load language
      $languagelocale = "";
      $query = "SELECT l.title, l.lang_code, l.sef ";
      $query .= "FROM #__vehiclemanager_const_languages as cl ";
      $query .= "LEFT JOIN #__vehiclemanager_languages AS l ON cl.fk_languagesid=l.id ";
      $query .= "LEFT JOIN #__vehiclemanager_const AS c ON cl.fk_constid=c.id ";
      $query .= "GROUP BY  l.title";
      $database->setQuery($query);
      $languages = $database->loadObjectList();

      $lang = JFactory::getLanguage();
      foreach ($lang->getLocale() as $locale) {
          foreach ($languages as $language) {
              if (strtolower($locale) == strtolower($language->title)
                  || strtolower($locale) == strtolower($language->lang_code) ) {
                  $mosConfig_lang = $locale;
                  $languagelocale = $language->lang_code;
                  break;
              }
          }
      }

      if ($languagelocale == '') {
          $languagelocale = "en-GB";
          $mosConfig_lang = "en-GB";
        }

      // Set content language
      global $langContent;
      $langContent = substr($languagelocale, 0, 2);


      $query = "SELECT c.const, cl.value_const ";
      $query .= "FROM #__vehiclemanager_const_languages as cl ";
      $query .= "LEFT JOIN #__vehiclemanager_languages AS l ON cl.fk_languagesid=l.id ";
      $query .= "LEFT JOIN #__vehiclemanager_const AS c ON cl.fk_constid=c.id ";
      $query .= "WHERE l.lang_code = '$languagelocale'";
      $database->setQuery($query);
      $langConst = $database->loadObjectList();

      foreach ($langConst as $item) {
         if(!defined($item->const) )  define($item->const, $item->value_const); // $database->quote()
      }

    }
    
    static function language_check($component_db_name = 'vehiclemanager' ) {
         global $database;

               
         $database->setQuery("SELECT * FROM #__".$component_db_name."_languages");
         $langIds = $database->loadObjectList();
         
         print_r("These constants exit in Languages files but not exist in file constants:<br />");
         foreach ($langIds as $langId){
         print_r("<br />Languages: ".$langId->title."<br />");
                $query = " SELECT  l1.*  FROM    #__".$component_db_name."_const_languages as l1 ";
                $query .= " WHERE   l1.fk_languagesid = ".$langId->id." and NOT EXISTS ";
                $query .= " ( SELECT  lc.*  FROM #__".$component_db_name."_const as lc ";
                $query .= " WHERE   lc.id = l1.`fk_constid` ) ";
                $database->setQuery($query);
                $badLangConsts = $database->loadObjectList();
                print_r($badLangConsts);
         }

         print_r("<br />These constants exit in file constants but not exist in Languages files:<br />");
         foreach ($langIds as $langId){

                print_r("<br />Languages: ".$langId->title."<br />");
                $query = " SELECT  lc.*  FROM    #__".$component_db_name."_const as lc ";
                $query .= " WHERE  NOT EXISTS ";
                $query .= " ( SELECT  l1.*  FROM #__".$component_db_name."_const_languages as l1 ";
                $query .= " WHERE lc.id = l1.`fk_constid` and l1.fk_languagesid = ".$langId->id.") ";
                $database->setQuery($query);
                $badLangConsts = $database->loadObjectList();
                print_r($badLangConsts);
         }
         
    }


    static function remove_langs($component_db_name = 'vehiclemanager' ) {
         global $database;

               
        $query = " TRUNCATE TABLE #__".$component_db_name."_languages; ";
        $database->setQuery($query);
        $database->query();
        
        $query = " TRUNCATE TABLE #__".$component_db_name."_const; ";
        $database->setQuery($query);
        $database->query();
        
        $query = " TRUNCATE TABLE #__".$component_db_name."_const_languages ;";
        $database->setQuery($query);
        $database->query();
        
    }
    
    
    static function com_veh_categoryTreeList($id, $action, $is_new, &$options = array())
    {
        $database = JFactory::getDBO();
        $list = vmLittleThings::categoryArray(); // for 1.6
        $cat = new mainVehiclemanagerCategories($database); // for 1.6
        $cat->load($id);
        $this_treename = '';
        $childs_ids = Array();
        foreach ($list as $item) {
            if ($item->id == $cat->id || array_key_exists($item->parent_id, $childs_ids))
                $childs_ids[$item->id] = $item->id;
        }

        foreach ($list as $item) {
            if ($this_treename)
            {
                if ($item->id != $cat->id
                        && strpos($item->treename, $this_treename) === false
                        && array_key_exists($item->id, $childs_ids) === false)
                {
                    $options[] = mosHTML::makeOption($item->id, $item->treename);
                }
            } else
            {
                if ($item->id != $cat->id)
                    $options[] = mosHTML::makeOption($item->id, $item->treename);
                else
                    $this_treename = "$item->treename/";
            }
        }

        $parent = null;
        $parent = mosHTML::selectList($options, 'catid', 'class="inputbox" size="1" style="width: 140px"', 'value', 'text', $cat->parent_id);
        return $parent;
    }

}
}
// end of vmLittleThings class
// Updated on June 25, 2011
// accessgroupid - array which contains accepted user groups for this item
// usersgroupid - groupId of the user
// For anonymous user Uid = 0 and Gid = 0 
if (!function_exists('checkAccess_VM'))
{

    function checkAccess_VM($accessgroupid, $recurse, $usersgroupid, $acl)
    {
        if (!is_array($usersgroupid)){
          $usersgroupid = explode(',' , $usersgroupid);
        }

        //parse usergroups
        $tempArr = array();
        $tempArr = explode(',', $accessgroupid);

        
        for ($i = 0; $i < count($tempArr); $i++) {
            if (( (!is_array($usersgroupid) && $tempArr[$i] == $usersgroupid )
                    OR ( is_array($usersgroupid) && in_array($tempArr[$i], $usersgroupid) ) )
                    || $tempArr[$i] == -2)
            {
                //allow access
                return true;
            } else
            {
                if ($recurse == 'RECURSE')
                {
                    if (is_array($usersgroupid))
                    {
                        foreach ( $usersgroupid as $j)
                            if (in_array($j, $tempArr))
                                return 1;
                    } else
                    {
                        if (in_array($usersgroupid, $tempArr))
                            return 1;
                    }
                }
            }
        } // end for
        //deny access
        return 0;
    }

// End of checkAccess_VM ()
}


//this function check - is exist vehicles in folders under this category
if (!function_exists('is_exist_subcategory_vehicles'))
{

    function is_exist_subcategory_vehicles($catid)
    {
        $database = JFActory::getDBO();
        $my = JFActory::getUser();

        $query = "SELECT *, COUNT(a.id) AS numlinks FROM #__vehiclemanager_main_categories AS cc"
                . "\n LEFT JOIN #__vehiclemanager_categories AS vc ON vc.idcat = cc.id"
                . "\n LEFT JOIN #__vehiclemanager_vehicles AS a ON a.id = vc.iditem"
                . "\n WHERE a.published='1' AND a.approved='1' AND section='com_vehiclemanager' "
                . "\n AND cc.parent_id='$catid' AND cc.published='1' "
                . "\n GROUP BY cc.id"
                . "\n ORDER BY cc.ordering"; // Removed: AND cc.access <= '$my->gid'
        $database->setQuery($query);
        $categories = $database->loadObjectList();
        if (count($categories) != 0)
            return true;

        $query = "SELECT id "
                . "FROM #__vehiclemanager_main_categories AS cc "
                . " WHERE section='com_vehiclemanager' AND parent_id='$catid' AND published='1' "; // Removed: AND access<='$my->gid'
        $database->setQuery($query);
        $categories = $database->loadObjectList();

        if (count($categories) == 0)
            return false;
        foreach ($categories as $k)
            if (is_exist_subcategory_vehicles($k->id))
                return true;
        return false;
    }

// end of is_exist_subcategory_vehicles()
}

//this function check - is exist vehicles in this folder and folders under this category 
if (!function_exists('is_exist_curr_and_subcategory_vehicles'))
{

    function is_exist_curr_and_subcategory_vehicles($catid)
    {
        $database = JFActory::getDBO();
        $my = JFActory::getUser();

        $query = "SELECT *, COUNT(a.id) AS numlinks FROM #__vehiclemanager_main_categories AS cc"
                . "\n LEFT JOIN #__vehiclemanager_categories AS vc ON vc.idcat = cc.id"
                . "\n LEFT JOIN #__vehiclemanager_vehicles AS a ON a.id = vc.iditem"
                . "\n WHERE a.published='1' AND a.approved='1' AND section='com_vehiclemanager' AND cc.id='$catid' AND cc.published='1' "
                . "\n GROUP BY cc.id"
                . "\n ORDER BY cc.ordering"; // Removed: AND cc.access <= '$my->gid'
        $database->setQuery($query);
        $categories = $database->loadObjectList();
        if (count($categories) != 0)
            return true;

        $query = "SELECT id "
                . "FROM #__vehiclemanager_main_categories AS cc "
                . " WHERE section='com_vehiclemanager' AND parent_id='$catid' AND published='1' "; // Removed: AND access<='$my->gid'
        $database->setQuery($query);
        $categories = $database->loadObjectList();

        if (count($categories) == 0)
            return false;
        foreach ($categories as $k)
            if (is_exist_curr_and_subcategory_vehicles($k->id))
                return true;
        return false;
    }

// end of is_exist_curr_and_subcategory_vehicles()
}

if (!function_exists('data_transform_vm'))
{
    function data_transform_vm ($date, $date_format = "from"){
        
        global $vehiclemanager_configuration, $database;     

        if (strstr($date, "00:00:00") OR strlen($date) < 11) {
            $format = $vehiclemanager_configuration['date_format'];
            $formatForDateFormat = 'Y-m-d';
        } else {
            $format = $vehiclemanager_configuration['date_format']. " " . $vehiclemanager_configuration['datetime_format'];
            $formatForDateFormat = 'Y-m-d H:i:s';
        }
      
        $formatForCreateObjDate = str_replace("%","",$format); 
        
        if(function_exists('date_format')){
          
            $dateObject = date_create_from_format($formatForCreateObjDate, $date);

            if($dateObject){
                $date = date_format($dateObject, $formatForDateFormat);
            }else{
                $dateObject = date_create_from_format($formatForDateFormat, $date);
                if($dateObject){
                    $date = date_format($dateObject, $formatForDateFormat);
                }  
            }        
        }else{
            $query = "SELECT STR_TO_DATE('$date','$format')"; 
            $database->setQuery($query);
            $normaDat = $database->loadResult(); 
        
            if(strlen($normaDat) > 0){
                $date = $normaDat;
            }           
        }

        return $date;
        
//    if($date_format == "from"){
//        global $vehiclemanager_configuration;
//            if (strstr($date,"00:00:00") OR strlen($date) < 11){
//                $mask = str_replace("%","",$vehiclemanager_configuration['date_format']);
//            }else{
//                $mask = str_replace("%","",$vehiclemanager_configuration['date_format']." ".$vehiclemanager_configuration['datetime_format']);
//            }
//    }elseif($date_format == "to"){
//        $mask = "Y-m-d H:i:s";
//    }
//    $unix_time = strtotime($date);
//    if ($unix_time > 1000 && $unix_time < 2147483647){
//        $data_transform = date($mask, $unix_time);
//        return $data_transform;
//    }else{
//        return $date;  
//    }
    }
}

if(!class_exists('getLayoutPath')){
class getLayoutPath{
    
static function getLayoutPathCom($components,$type, $layout = 'default')
        {
                $template = JFactory::getApplication()->getTemplate();
                $defaultLayout = $layout;
              
                if (strpos($layout, ':') !== false)
                {
                        // Get the template and file name from the string
                        $temp = explode(':', $layout);
                        $template = ($temp[0] == '_') ? $template : $temp[0];
                        $layout = $temp[1];
                        $defaultLayout = ($temp[1]) ? $temp[1] : 'default';
                }
          
                // Build the template and base path for the layout
                $tPath = JPATH_THEMES . '/' . $template . '/html/' . $components . '/'.$type.'/'. $layout . '.php';
                $cPath = JPATH_BASE . '/components/' . $components . '/views/'.$type.'/tmpl/'.$layout.'.php';
                $dPath = JPATH_BASE . '/components/' . $components . '/views/'.$type.'/tmpl/default.php';
        
                // If the template has a layout override use it
                if (file_exists($tPath))
                {   
                        return $tPath;
                }
                else if (file_exists($cPath))
                {   
                        return $cPath;
                }
                else if (file_exists($dPath))
                {   
                        return $dPath;
                } else {
                  echo "Bad layout path, please write to admin"; exit;
                }
        }
 }
}

if (!function_exists('getLayoutsVeh')) {

        function getLayoutsVeh($components, $type) {
            global $database;
            // get current template on frontend
            $template = '';
            $database = JFactory::getDBO();
            $query = "SELECT template FROM #__template_styles WHERE client_id=0 AND home=1"; 
            $database->setQuery($query);
            $template = $database->loadResult();

            // Build the template and base path for the layout
            $tPath = JPATH_SITE . '/templates/' . $template . '/html/' . $components . '/' . $type . '/';
            $cPath = JPATH_SITE . '/components/' . $components . '/views/' . $type . '/tmpl/';

            $layouts1 = array();
            $layouts3 = array();
                   
            if (is_dir($tPath) && ($layouts1 = JFolder::files($tPath, '^[^_]*\.php$', false, true))) {
            
                foreach ($layouts1 as $i => $file) {
                    $select_file_name = pathinfo($file);
                    $select_file_name = $select_file_name['filename'];
                    $layouts3[] = $select_file_name;
                }
            } 
            $layouts2 = array();
            $layouts4 = array();
            
            if (is_dir($cPath) && ($layouts2 = JFolder::files($cPath, '^[^_]*\.php$', false, true))) {
            
                foreach ($layouts2 as $i => $file) {
                    $select_file_name = pathinfo($file);
                    $select_file_name = $select_file_name['filename'];
                    $layouts4[] =  $select_file_name;
                }
            } 
            $layouts = array_merge($layouts3,$layouts4);
            $layouts = array_unique($layouts);
            return $layouts;  
        }
}

if(!function_exists('checkRentDayNightVM')){
    
    
    function checkRentDayNightVM ($from,$until, $rent_from, $rent_until, $vehiclemanager_configuration){
       /* 
        if(isset($rentTerm[$e]) && ($rentTerm[$e]->price_from)){
            $from = $rentTerm[$e]->price_from;
            $until = $rentTerm[$e]->price_to;                    
        }else{
            $from = $rentTerm[$e]->rent_from ;
            $until =$rentTerm[$e]->rent_until ;    
        }
        */
        if(isset($vehiclemanager_configuration) && $vehiclemanager_configuration['special_price']['show']){
            
            if (( $rent_from >= $from &&
                  $rent_from <= $until) || ($rent_from <= $from && 
                  $rent_until >= $until) || ( 
                  $rent_until >= $from && $rent_until <= $until))
                {
                    return 'Sorry, this item not is available from " '. $from .' " until " '. $until . '"';
                }
            }else{
                
                if($rent_from === $rent_until){
                    return 'Sorry, not one night, not selected';
                }

                if(($rent_from < $until && $rent_until > $from)){
                    return 'Sorry, this item not is available from " '. $from .' " until " '. $until . '"';                   
                }                              
            }
    }
}


if(!function_exists('calculatePriceVM')){
    
    
    function calculatePriceVM ($vid,$rent_from,$rent_until,$vehiclemanager_configuration,$database){
        
        
        $rent_from = data_transform_vm($rent_from);
        $rent_until = data_transform_vm($rent_until);
        
        if($rent_from >$rent_until){
            echo '0';exit;
        }
        
        if($vehiclemanager_configuration['special_price']['show']){
            $query = "SELECT * FROM #__vehiclemanager_rent_sal WHERE fk_vehiclesid = ".$vid .
                        " AND (price_from <= ('" .$rent_until. "') AND price_to >= ('" .$rent_from. "'))";         
        }else{
            $query = "SELECT * FROM #__vehiclemanager_rent_sal WHERE fk_vehiclesid = ".$vid .
                        " AND (price_from < ('" .$rent_until. "') AND price_to > ('" .$rent_from. "'))";              
        }        
        $database->setQuery($query);
        $data_for_price = $database->loadObjectList();

        $zapros = "SELECT price, priceunit FROM #__vehiclemanager_vehicles WHERE id=" . $vid . ";";
        $database->setQuery($zapros);
        $item_vehicle = $database->loadObjectList(); 

        $rent_from_ms = date_to_data_ms($rent_from); 
        $rent_to_ms = date_to_data_ms($rent_until);
        
        if($vehiclemanager_configuration['special_price']['show']){                             
            $rent_to_ms = $rent_to_ms + (60*60*24);           
        }
        
        $count_day = (($rent_to_ms - $rent_from_ms)/60/60/24);
        $array_day_between_to_from[0]=$rent_from; 
        
        for($i = 1; $i < $count_day; $i++){
            $array_day_between_to_from[]=date('Y-m-d',$rent_from_ms + (60*60*24)*($i));
        } 
    
        $count_day_spashal_price = 0;                
        $comment_rent_price = '';
        $count_spashal_price = 0;
        
        foreach ($data_for_price as $one_period){
            $from = $one_period->price_from;
            $to = $one_period->price_to; 
            
            for ($day = 0; $day < $count_day; $day++){ 
                $currentday = ($array_day_between_to_from[$day]);
                
                if(isset($vehiclemanager_configuration) && $vehiclemanager_configuration['special_price']['show']){
                    if (($currentday >= $from) && ($currentday <= $to)){   
                        $count_day_spashal_price++;   
                        $count_spashal_price += $one_period->special_price;
                        $comment_rent_price .= (string)$one_period->comment_price;
                    }                     
                }else{
                    if (($currentday >= $from) && ($currentday < $to)){   
                        $count_day_spashal_price++;   
                        $count_spashal_price += $one_period->special_price;
                        $comment_rent_price .= (string)$one_period->comment_price;
                    }                      
                }                                    
            }  
         }   
 
        $count_day_not_sp_price = $count_day - $count_day_spashal_price;
        $sum_price_not_sp_price =  $count_day_not_sp_price * $item_vehicle[0]->price;
        $sum_price = $sum_price_not_sp_price + $count_spashal_price;
    
        $returnArr[0]=$sum_price; 
        $returnArr[1]=$item_vehicle[0]->priceunit; 
        $returnArr[2]=$comment_rent_price;
        
        return $returnArr;
    }
}


if(!function_exists('getCountCarForSingleUserVM')){
    
    
    function getCountCarForSingleUserVM($my,$database,$vehiclemanager_configuration){
        
              
        $user_group = userGID_VM($my->id);         
        $user_group_mas = explode(',', $user_group);
        $max_count_car = 0;
                
        foreach ($user_group_mas as $value) {            
            $count_car_for_single_group = $vehiclemanager_configuration['user_manager_vm'][$value]['count_car'];
            
            if($count_car_for_single_group>$max_count_car){
                $max_count_car = $count_car_for_single_group;
            }            
        }
        
        $count_car_for_single_group = $max_count_car;  
        $database->setQuery("SELECT COUNT('vehicleid') as `count_car` FROM #__vehiclemanager_vehicles WHERE owner_id= '" . $my->id. "'AND published='1'" );
        $car_single_user = $database->loadObject();
		$arr = array();
        $arr[0] = $car_single_user->count_car;
		$arr[1] = $count_car_for_single_group;
        return $arr;  
    }
}
if(!function_exists('createRentTable')){

 function createRentTable($rentTerm, $massage, $typeMessage){
        
        
            echo '<div id ="SpecialPriseBlock">';
            echo            '<table class="adminlist adminlist_04">';
            echo                '<tr>';
            echo                    '<th class="title" width ="35%">'._VEHICLE_MANAGER_LABEL_CALENDAR_SELECT_DELETE.'</th>';
            echo                    '<th class="title" >'._VEHICLE_MANAGER_FROM.'</th>';
            echo                    '<th class="title" >'._VEHICLE_MANAGER_TO.'</th>';
            echo                    '<th class="title" >'._VEHICLE_MANAGER_RENT_PRICE_PER_DAY.'</th>';
            echo                   '<th class="title" >'._VEHICLE_MANAGER_LABEL_REVIEW_COMMENT.'</th>';
            echo                '</tr>';
                for ($i = 0; $i < count($rentTerm); $i++) {                     
                    echo                       '<tr>';
                    echo                           '<td align ="center"><input type="checkbox" name="del_rent_sal[]" value="'.$rentTerm[$i]->id.'"</td>';
                    echo                           '<td align ="center">'.$rentTerm[$i]->price_from.'</td>';
                    echo                           '<td align ="center">'.$rentTerm[$i]->price_to.'</td>';
                    echo                           '<td align ="center">'.$rentTerm[$i]->special_price. ' '.$rentTerm[$i]->priceunit.'</td>';
                    echo                           '<td>'.$rentTerm[$i]->comment_price.'</td>';                                        
                    echo                       '</tr>';
                }   
            echo           '</table>';
            echo           '<p>';
                if($typeMessage === 'error'){
                    echo           '<div id ="message-here" style ="color: red; font-size: 18px;" >'.$massage.'</div>';
                }else{
                    echo           '<div id ="message-here" style ="color: gray; font-size: 18px;" >'.$massage.'</div>';            
                }   
            echo           '<p>';  
            echo           '</div>' ;
             
            exit;
        }
         
} 

if(!function_exists('rentPriceVM')){
    
    function rentPriceVM($vid,$rent_from,$rent_until,$special_price,$comment_price,$currency_spacial_price){
    
        
        global $database, $vehiclemanager_configuration ;
           
           
          if($vid==''){
            $rentTerm = array();
            createRentTable($rentTerm, 'Please save or apply this item first','error');
            return;
        }
        
        $query = "SELECT * FROM #__vehiclemanager_rent_sal where fk_vehiclesid = " . $vid;
        $database->setQuery($query);
        $rentTerm = $database->loadObjectList();            

    
         if($special_price==''){
                createRentTable($rentTerm, 'Input special_price','error');
            }
            if($rent_from==''){
                createRentTable($rentTerm, 'Input rent_from','error');
            }
            if($rent_until==''){
                createRentTable($rentTerm, 'Input rent_until','error');
            }
            if($rent_from >$rent_until){
                createRentTable($rentTerm, 'Incorrect rent_until','error');
            }
            
            foreach ($rentTerm as $oneTerm){
                $returnMessage = checkRentDayNightVM (($oneTerm->price_from),($oneTerm->price_to), $rent_from, $rent_until, $vehiclemanager_configuration);
                
                if(strlen($returnMessage) > 0){
                    createRentTable($rentTerm, $returnMessage, 'error');
                }   
            }      
            
            $sql = "INSERT INTO #__vehiclemanager_rent_sal (fk_vehiclesid, price_from, price_to, special_price, priceunit, comment_price) VALUES (" . $vid . ", '" . $rent_from . "', '" . $rent_until . "', '" . $special_price . "','" . $currency_spacial_price . "','" . $comment_price . "')";             
            $database->setQuery($sql);
            $database->query();

            $query = "SELECT * FROM #__vehiclemanager_rent_sal where fk_vehiclesid = " . $vid;        
            $database->setQuery($query);
            $rentTerm = $database->loadObjectList();           
            
            createRentTable($rentTerm, 'Add special price on data: from "'.$rent_from.'" to "'.$rent_until.'"','');
    }
}

                


if(!function_exists('getAvilableVM')){
    
    
    function getAvilableVM ($calenDate,$month,$year,$vehiclemanager_configuration,$day){
                
        foreach ($calenDate as $oneTerm){
            if(strlen($month) == 1){
                $month = '0'.$month ;
            }
            
            if(strlen($day) == 1){
                $day = '0'.$day ;                     
            }
            
            $toDay = $day+1;
            
            if(strlen($toDay) == 1){
                $toDay = '0'.$toDay ;
            }
            
            $cheackDataFrom = $year.'-'.$month.'-'.$day;
            $cheackDataTo = $year.'-'.$month.'-'.$toDay; 
            $resultmsg = checkRentDayNightVM (($oneTerm->rent_from),($oneTerm->rent_until), $cheackDataFrom, $cheackDataTo, $vehiclemanager_configuration);
                    
            if(strlen($resultmsg) > 1){                      
                return 'calendar_not_available';
            } 
        }   
        return 'calendar_available';
    }
}

//--------------------------Associate------------Associate----------------Associate---------------



if(!function_exists('getAssociateVehiclesLang')){
 
    function getAssociateVehiclesLang($vehicleIds){
        
        global $database;

   
        $query = "select associate_vehicle from #__vehiclemanager_vehicles where id = ".$vehicleIds." and associate_vehicle is not null";
     
        $database->setQuery($query);
        $vehicleAssociateVehicle = $database->loadResult(); 
  
        
        if (!empty($vehicleAssociateVehicle)){
            $vehicleLangIds = unserialize($vehicleAssociateVehicle);
  
        return $vehicleLangIds;
        }
    }   
}

if(!function_exists('getAssociateVehicle')){
 
    function getAssociateVehicle($vehicleIds){
        
        global $database;

        $one = array();
        
        $query = "select associate_vehicle from #__vehiclemanager_vehicles where id = ".$vehicleIds." and associate_vehicle is not null";
     
        $database->setQuery($query);
        $vehicleAssociateVehicle = $database->loadResult(); 
  
        
        if (!empty($vehicleAssociateVehicle)){
            $vehicleIds = unserialize($vehicleAssociateVehicle);
  
            foreach($vehicleIds as $onevehicleIds){
              if($onevehicleIds != 0){
                  $one[] = $onevehicleIds;         
              }
            } 

        $bids = implode(',', $one);
        return $bids;
        }
    }   
}

if(!function_exists('getAssociateDiff')){
 
    function getAssociateDiff($assocArray1,$assocArray2){
        
       global $database;
       
       $diff_ids = array();
       
        $diff = array_diff($assocArray1,$assocArray2);                  
        foreach($diff as $key => $value){
            if($value != 0){
                    $diff_ids[] = $value;                    
            }
        }               
        
        return $diff_ids ;
    }   
}

if(!function_exists('getAssociateOld')){
 
    function getAssociateOld(){
        
        global $database;
        $id_check = JRequest::getVar('id', "");
       
            $query = "select `associate_vehicle` from #__vehiclemanager_vehicles where `id` = ".$id_check."";             
            $database->setQuery($query);
            $oldAssociate = $database->loadResult();           
            $oldAssoc_func = unserialize($oldAssociate);
        
        return $oldAssoc_func;
        
      
    }   
}

if(!function_exists('ClearAssociateDiff')){
 
    function ClearAssociateDiff(){
        
      global $database;
       
      $id_check = JRequest::getVar('id', ""); 
      $language_post = JRequest::getVar('language', "");     
      $oldAssociateArray = getAssociateOld();
      $i = 1;
      $assocArray = array();
      while(count(JRequest::getVar("associate_vehicle".$i))){
              $langAssoc = JRequest::getVar("associate_vehicle_lang".$i);
              $valAssoc = JRequest::getVar("language_associate_vehicle".$i);
              $assocArray[$langAssoc] = $valAssoc;                     
                $i++;
            }             
      $assocArray[$language_post] = $id_check;          
     
      $old_ids_assoc = getAssociateDiff($oldAssociateArray,$assocArray);
              if(count($old_ids_assoc)>0)
              {   
                  foreach($old_ids_assoc as $key => $value) {             
                    $diff_assoc2 = getAssociateVehicle($value);    
                    if(!empty($diff_assoc2)){
                      $ids_assoc_diff2 = explode(',', $diff_assoc2);
                      foreach ($ids_assoc_diff2 as $key2 => $value2){
                        if(!in_array($value2,$old_ids_assoc)){
                          $assoc_lang = getAssociateVehiclesLang($value);
                          foreach ($assoc_lang as $key3 => $value3){
                            if($value3 == $value2){
                              $assoc_lang[$key3] = 0;                    
                            } 
                          }
                          $vehicleLangIds = serialize($assoc_lang);
                          $query = "UPDATE #__vehiclemanager_vehicles SET `associate_vehicle`='".$vehicleLangIds."' where `id` = ".$value."";
                          $database->setQuery($query);
                          $database->query();                        
                        }
                      }
                    }                   
                  }
              }  
        
        $new_ids_assoc = getAssociateDiff($assocArray,$oldAssociateArray);
        if(count($new_ids_assoc)>0)
        {   
            foreach($new_ids_assoc as $key => $value) {            
              $diff_assoc2 = getAssociateVehicle($value);  
              if(!empty($diff_assoc2)){
              $ids_assoc_diff2 = explode(',', $diff_assoc2);
                foreach ($ids_assoc_diff2 as $key2 => $value2){
                  if($value2 == $value || $value2 == 0 ) continue;
                  $assoc_lang = getAssociateVehiclesLang($value2);
                  foreach ($assoc_lang as $key3 => $value3){
                    if($value3 == $value){
                      $assoc_lang[$key3] = 0;                    
                    }
                  }                       
                  $vehicleLangIds = serialize($assoc_lang);
                  $query = "UPDATE #__vehiclemanager_vehicles SET `associate_vehicle`='".$vehicleLangIds."' where `id` = ".$value2."";
                  $database->setQuery($query);
                  $database->query(); 
                }
              }                   
            }
        }  
    }   
}


if(!function_exists('edit_vehicle_associate')){

    function edit_vehicle_associate($vehicle)
    {
        global $database, $my;
        $associateArray = array();
        $userid = $my->id;

            $query = "SELECT lang_code FROM `#__languages` WHERE 1";
            $database->setQuery($query);
            $allLanguages =  $database->loadColumn();

            $query = "SELECT id,language,vtitle FROM `#__vehiclemanager_vehicles` WHERE 1 and  owner_id = " . $userid . "";
            $database->setQuery($query);
            $allVehicle =  $database->loadObjectlist();

            $query = "select associate_vehicle from #__vehiclemanager_vehicles where id =".$vehicle->id;
            $database->setQuery($query);
            $vehicleAssociateVehicle =  $database->loadResult();


            if(!empty($vehicleAssociateVehicle)){
                $vehicleAssociateVehicle = unserialize($vehicleAssociateVehicle);
            }else{
                $vehicleAssociateVehicle = array();
            }

            $i = 0;
            foreach ($allLanguages as &$oneLang) {
                $i++;
                $associate_vehicle = array();
                $associate_vehicle[] = mosHtml::makeOption(0, 'select');

                foreach($allVehicle as &$oneVehicle){
                    if($oneLang == $oneVehicle->language && $oneVehicle->id != $vehicle->id){
                        $associate_vehicle[] = mosHtml::makeOption(($oneVehicle->id), $oneVehicle->vtitle);
                    }
                }
              if($vehicle->language != $oneLang){

                    if(isset($vehicleAssociateVehicle[$oneLang]) && $vehicleAssociateVehicle[$oneLang] !== $vehicle->id ){
                        $associateArray[$oneLang]['assocId'] = $vehicleAssociateVehicle[$oneLang];
                    }else{
                        $associateArray[$oneLang]['assocId'] = 0;
                    }

                    $associate_vehicle_list = mosHTML :: selectList($associate_vehicle, 'language_associate_vehicle'.$i,
                                              'class="inputbox" size="1"', 'value', 'text', $associateArray[$oneLang]['assocId']);
              }else{
                  $associate_vehicle_list = null;
              }

              $associateArray[$oneLang]['list'] = $associate_vehicle_list;

              if(isset($vehicleAssociateVehicle[$oneLang]) && $vehicleAssociateVehicle[$oneLang] !== $vehicle->id ){
                  $associateArray[$oneLang]['assocId'] = $vehicleAssociateVehicle[$oneLang];
              }else{
                  $associateArray[$oneLang]['assocId'] = 0;
              }
            }
      return $associateArray;
    }
}

if(!function_exists('save_vehicle_associate')){
  function save_vehicle_associate()
  {
    global $database;

    $id_check = JRequest::getVar('id', "");
    $id_true = JRequest::getVar('idtrue', "");
    $language_post = JRequest::getVar('language', "");

    if($id_check){
        if(empty($id_true)){
           //----------get new values (what vehicles we choose for chaque language) --------------------------//
            $i = 1;
            $assocArray = array();
            $assocVehicleId = array();

            while(count(JRequest::getVar("associate_vehicle".$i))){
                $langAssoc = JRequest::getVar("associate_vehicle_lang".$i);
                $valAssoc = JRequest::getVar("language_associate_vehicle".$i);
                $assocArray[$langAssoc] = $valAssoc;
                if($valAssoc){
                    $assocVehicleId[] = $valAssoc;
                }
                $i++;
            }

            $query = "select `language` from #__vehiclemanager_vehicles where `id` = ".$id_check."";
            $database->setQuery($query);
            $oldLang = $database->loadResult();

            if($oldLang == $language_post){
               $assocArray[$language_post] = $id_check;
            }else{
               $assocArray[$language_post] = 0;
            }

            $assocStr = serialize($assocArray);

        //-----------slect associate with old values------------------------------------------//
            $oldAssociateArray = getAssociateOld();
        //----------------------------------------------------------------//

          if(!isset($assocVehicleId[$id_check])){
                  $assocVehicleId[] = $id_check;
          }

          if($assocArray !== $oldAssociateArray){ //-----------compare old and new values--

            //---------set null for vehicles that are not more in associates----------------//
            ClearAssociateDiff();

            //---------set new associates for vehicles that are choosed----------------//

            $idToChange = implode(',' , $assocVehicleId); //--ids of new vehicles  where we set new values for column associate_vehicle
            if(count($idToChange) && !empty($idToChange)){
                $query = "select * from #__vehiclemanager_rent where `fk_vehicleid` in (".$idToChange.") and `rent_return` is NULL";
                $database->setQuery($query);
                $CheckAssociate = $database->loadObjectList();
                    if(!empty($CheckAssociate))
                    {
                    echo "<script> alert(' You must return all vehicles from rent first! '); window.history.go(-1); </script>";
                    exit;
                    }

                  $query = "UPDATE #__vehiclemanager_vehicles SET `associate_vehicle`='".$assocStr."' where `id` in (".$idToChange.")";
                  $database->setQuery($query);
                  $database->query();

                }else{
                  $query = "UPDATE #__vehiclemanager_vehicles SET `associate_vehicle`= null where `id` = ".$id_check."";
                  $database->setQuery($query);
                  $database->query();
            }
          }
        }
    }

  }
}
