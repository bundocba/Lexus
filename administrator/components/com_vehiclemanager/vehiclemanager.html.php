<?php

if (!defined('_VALID_MOS') && !defined('_JEXEC')) die('Direct Access to ' . basename(__FILE__) . ' is not allowed.');

/**
 *
 * @package VehicleManager
 * @copyright 2012 Andrey Kvasnevskiy-OrdaSoft(akbet@mail.ru); Rob de Cleen(rob@decleen.com); 
 * Homepage: http://www.ordasoft.com
 * @version: 3.0 Pro
 * @license GNU General Public license version 2 or later; see LICENSE.txt
 * */

require_once ($mosConfig_absolute_path . "/libraries/joomla/factory.php");
require_once ( JPATH_BASE . DS . 'includes' . DS . 'defines.php' );
require_once ( JPATH_BASE . DS . 'includes' . DS . 'framework.php' );

$mainframe = JFactory::getApplication();
$templateDir = 'templates/' . $mainframe->getTemplate();
$GLOBALS['mainframe'] = $mainframe;
$GLOBALS['templateDir'] = $templateDir;
$mosConfig_live_site = JURI::root(true);
$GLOBALS['mosConfig_live_site'] = $mosConfig_live_site;
$doc = JFactory::getDocument();
$GLOBALS['doc'] = $doc;
?>

<?php
// ensure this file is being included by a parent file
$vid = mosGetParam($_POST, 'vid', array(0));
require_once ($mosConfig_absolute_path .
   "/administrator/components/com_vehiclemanager/admin.vehiclemanager.class.others.php");
$doc->addStyleSheet($css);

class HTML_Categories
{

    static function show(&$rows, $myid, &$pageNav, &$lists, $type)
    {
        global $my, $mainframe, $mosConfig_live_site;
        $section = "com_vehiclemanager";
        $section_name = "VehicleManager";
        // for 1.6
        global $doc, $css;
        $doc->addStyleSheet($css);
        $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');

        $html = "<div class='vehicle_manager_caption' >".
          "<img src='./components/com_vehiclemanager/images/building_icon.jpg' alt ='Config' /> " .
           _VEHICLE_MANAGER_CATEGORIES_MANAGER . "</div>";
        $app = JFactory::getApplication();
        $app->JComponentTitle = $html;
        ?>
        <form action="index.php" method="post" name="adminForm" id="adminForm">
            <?php if (version_compare(JVERSION, "3.0.0", "ge"))
            {
                ?>
                <table width="100%" class="adminform adminform_02">
                    <tr>
                        <td>
                            <div class="btn-group pull-left hidden-phone">
                                <label for="limit" class="element-invisible"><?php
                                   echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
                              <?php echo $pageNav->getLimitBox(); ?>
                            </div>
                        </td>                
                    </tr>
                </table>
        <?php } ?>
            <table class="adminlist adminlist_01">
                <tr>
                    <th width="20" align="center">
                        #
                    </th>
                    <th width="20"><input type="checkbox" name="toggle"
                       onClick="vm_checkAll(this<?php //echo count($rows);  ?>);" /></th>
                    <th align = "center" class="title"><?php echo _VEHICLE_HEADER_CATEGORY; ?></th>
                    <th align = "center" width="5%"><?php echo _VEHICLE_HEADER_NUMBER; ?></th>
                    <th align = "center" width="10%"><?php echo _VEHICLE_HEADER_PUBLISHED; ?></th>
                    <?php
                    if ($section <> 'content')
                    {
                        ?>
                        <th align = "center" colspan="2"><?php echo _VEHICLE_HEADER_REORDER; ?></th>
                        <?php
                    }
                    ?>
                    <th align = "center" width="10%"><?php echo _VEHICLE_HEADER_ACCESS; ?></th>
                    <?php
                    if ($section == 'content')
                    {
                        ?>
                        <th width="12%" align="left">Section</th>
                        <?php
                    }
                    ?>
                    <th align = "center" width="12%">ID</th>
                    <th align = "center" width="12%"><?php echo _VEHICLE_HEADER_CHECKED_OUT; ?></th>
                </tr>
                <?php
                $k = 0;
                $i = 0;
                $n = count($rows);
                foreach ($rows as $row) {
                    $img = $row->published ? 'tick.png' : 'publish_x.png';
                    $task = $row->published ? 'unpublish' : 'publish';
                    $alt = $row->published ? 'Published' : 'Unpublished';
                    if (!$row->access)
                    {
                        $color_access = 'style="color: green;"';
                        $task_access = 'accessregistered';
                    } else if ($row->access == 1)
                    {
                        $color_access = 'style="color: red;"';
                        $task_access = 'accessspecial';
                    } else
                    {
                        $color_access = 'style="color: black;"';
                        $task_access = 'accesspublic';
                    }
                    ?>
                    <tr class="<?php echo "row$k"; ?>">
                        <td width="20" align="center"><?php echo $pageNav->getRowOffset/* rowNumber */($i); ?></td>
                        <td width="20"><?php echo mosHTML::idBox($i, $row->id, ($row->checked_out_contact_category && $row->checked_out_contact_category != $my->id), 'vid'); ?></td>
                        <td width="35%">
                            <?php
                            if ($row->checked_out_contact_category && ($row->checked_out_contact_category != $my->id))
                            {
                                ?>
                                <?php echo $row->treename . ' ( ' . $row->title . ' )'; ?>
                                &nbsp;[ <i>Checked Out</i> ]
                                <?php
                            } else
                            {
                                ?>
                                <a href="#edit" onClick="return listItemTask('cb<?php echo $i; ?>','edit')">
                                <?php echo $row->treename . ' ( ' . $row->title . ' )'; ?>
                                </a>
                                <?php
                            }
                            ?>
                        </td>
                        <td align="center">
                            <?php
                            echo $row->nvehicle;
                            global $templateDir;
                            ?>
                        </td>

                        <td align="center">
                            <a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i; ?>','<?php echo $task; ?>')">
                                <?php
                                if (version_compare(JVERSION, "1.6.0", "lt"))
                                {
                                    ?>
                                    <img src="<?php echo $mosConfig_live_site . "/administrator/images/" . $img; ?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
                                    <?php
                                } else
                                {
                                    ?>
                                    <img src="<?php echo $templateDir . "/images/admin/" . $img; ?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
                                    <?php
                                }
                                ?>
                            </a>
                        </td>

                        <!-- old td  ><?php echo $i . $pageNav->orderUpIcon($i); ?></td>
                        <td><?php echo $i . "::" . $n . $pageNav->orderDownIcon($i, $n); ?></td-->
                        <td align="center"><?php echo catOrderUpIcon($row->ordering - 1, $i); ?></td>
                        <td align="center"><?php echo catOrderDownIcon($row->ordering - 1, $row->all_fields_in_list, $i); ?></td>

                        <td align="center">
                      <?php echo $row->groups; ?>
                            <!--</a>-->
                        </td>
                        <td align="center"><?php echo $row->id; ?></td>
                        <td align="center"><?php echo $row->checked_out_contact_category ? $row->editor : ""; ?></td>
                        <?php
                        $k = 1 - $k;
                        ?>
                    </tr>
                    <?php
                    $k = 1 - $k;
                    $i++;
                }
                ?>
                <tr><td colspan = "11"><?php echo $pageNav->getListFooter(); ?></td></tr>
            </table>
            <input type="hidden" name="option" value="com_vehiclemanager" />
            <input type="hidden" name="section" value="categories" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="chosen" value="" />
            <input type="hidden" name="act" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <input type="hidden" name="type" value="<?php echo $type; ?>" />
        </form>
        <?php
    }

    /**
     * Writes the edit form for new and existing categories
     * 
     * @param mosCategory $ The category object
     * @param string $ 
     * @param array $ 
     */
    static function edit(&$row, $section, &$lists, $redirect, $associate_cat_arr)
    {
        global $my, $mosConfig_live_site, $mainframe, $option, $database;
        // for 1.6
        global $doc, $css;
        $doc->addStyleSheet($css);
        $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');

        $html = "<div class='vehicle_manager_caption' >" .
         "<img src='./components/com_vehiclemanager/images/building_icon.jpg' alt ='Config' /> " .
          _VEHICLE_MANAGER_CATEGORIES_MANAGER . "</div>";
        $app = JFactory::getApplication();
        $app->JComponentTitle = $html;

        if ($row->image == "")
        {
            $row->image = 'blank.png';
        }

        mosMakeHtmlSafe($row, ENT_QUOTES, 'description');
        ?>
        <script language="javascript" type="text/javascript">
            
            Joomla.submitbutton = function(pressbutton, section) {
               
            var form = document.adminForm; 
                if (pressbutton == 'cancel') {
                    submitform( pressbutton );
                    return;
                }

                if ( form.name.value == "" ) {
                    alert('<?php echo _VEHICLE_DML_CAT_MUST_SELECT_NAME; ?>');
                } else if ( form.title.value == "" ) {
                    alert('<?php echo _VEHICLE_DML_CAT_MUST_SELECT_NAME; ?>');
                } else {
                    <?php //getEditorContents('editor1', 'description'); ?>
                        submitform(pressbutton);
                    }
                }
        </script>
        <form action="index.php" method="post" name="adminForm"  id="adminForm" >
            <table>
                <tr>
                    <th  class="vehicle_manager_caption" align="left"><?php
                     echo $row->id ? _VEHICLE_HEADER_EDIT : _VEHICLE_HEADER_ADD; ?> <?php
                      echo _VEHICLE_HEADER_CATEGORY; ?> <?php echo $row->name; ?></th>
                </tr>
            </table>
            <table width="100%"  class="table_01">
                <tr>
                    <td valign="top">
                        <table class="adminform adminform_03">
                            <tr>
                                <td width="185"><?php echo _VEHICLE_CATEGORIES__DETAILS; ?></td>
                            </tr>
                            <tr>
                                <td width="185"><?php echo _VEHICLE_CATEGORIES_HEADER_TITLE; ?>:</td>
                                <td><input class="text_area" type="text" name="title" value="<?php echo $row->title; ?>" size="50" maxlength="250" title="A short name to appear in menus" /></td>
                            </tr>
                            <tr>
                                <td width="185"><?php echo _VEHICLE_CATEGORIES_HEADER_NAME; ?>:</td>
                                <td><input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255" title="A short name to appear in menus" /></td>
                            </tr>
<?php 
/*********************************************************************************************/
         
    if(!empty($associate_cat_arr) && !empty($row->language) && $row->language != '' && $row->language != '*'){
?>
                <tr> 
                    <td width="15%"><?php echo 'language associate category' ?>:</td>                        
                </tr>   
            
<?php
        $j =1;
        foreach ($associate_cat_arr as $lang=>$value) {
            $displ = '';
            if(!$value['list']){
                $displ = 'none';
            }
?>    
                <tr style="display: <?php echo $displ?>">
                    <td width="15%"><?php echo $lang; ?>:</td>
                    <td width="60%"><?php echo $value['list']; ?> 
                    <input class="inputbox" id="associate_category" type="text" name="associate_category<?php echo $j;?>" size="20" readonly="readonly" maxlength="20" style="width:25px; margin-bottom: -4px;" value="<?php echo $value['assocId']; ?>" />
                    <input style="display: none" name="associate_category_lang<?php echo $j;?>" value="<?php echo $lang ?>"/>  
                    </td>                          
                </tr>
<?php
        
        $j++;
        }
   }else{
?>
                <tr> 
                    <td width="15%"><?php echo 'language associate category' ?>:</td> 
                    <td width="60%"><?php echo 'this property only for category with language' ?> 
                </tr> 
<?php
   }

/*********************************************************************************************/
?>     
<script>
    window.onload = function(){
        
        var languageParentId = document.querySelectorAll('#language_associate_category');

        for(var i = 0; i < languageParentId.length; i++){
    
            var el = languageParentId[i];
            var idField = languageParentId[i].nextSibling.nextSibling;
            el.value = idField.value;
    
            var field = (function(x){
                el.onchange= function(){
                    var el = languageParentId[x];
                    var idField = languageParentId[x].nextSibling.nextSibling;
                    idField.value = el.value;     
                };  
            })(i);
        }
    };
</script>                                        
                            <tr>
                                <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_LANGUAGE; ?>:</td>
                                <td><?php echo $lists['languages']; ?></td>
                            </tr>
                            <tr>
                                <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_SINGLE_CATEGORY_LAYOUT; ?>:</td>
                                <td><?php echo $lists['alone_category']; ?></td>
                            </tr>
                            <tr>
                                <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_VEHICLE_PAGE_LAYOUT; ?>:</td>
                                <td><?php echo $lists['view_vehicle']; ?></td>
                            </tr>
                            <tr>
                                <td width="185"><?php echo _VEHICLE_CATEGORIES__PARENTITEM; ?>:</td>
                                <td><?php echo $lists['parent']; ?></td>
                            </tr>
                            <tr><?php $issetImage = substr_count($lists['image'],'<option');?>
                                <td width="185"><?php echo _VEHICLE_CATEGORIES_HEADER_IMAGE; ?>:</td>                           
                                <td><?php 
                                           if ($issetImage==1){
                                                echo $lists['image'].'<br><span style="font-size: 12px;'.
                                                 ' position: absolute;">To load images need to go Content->' .
                                                 'Media Manager.<br> There create a folder stories and load your pictures into it<span>';
                                           }
                                           else  echo $lists['image']; ?></td>    
                                <?php  echo $issetImage==1 ?  "</tr><tr><td>" : '<td rowspan="4" width="50%">';?>
                                    <script language="javascript" type="text/javascript">
                                        if (document.forms[0].image.options.value!=''){
                                            jsimg='../images/stories/' + getSelectedValue( 'adminForm', 'image' );
                                        } 
                                        else 
                                        {
                                            jsimg='../images/M_images/blank.png';
                                        }
                                        document.write('<img src=' + jsimg + ' name="imagelib" width="80"' +
                                         ' height="80" border="2" alt="<?php echo _VEHICLE_CATEGORIES__IMAGEPREVIEW; ?>" />');
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td width="185"><?php echo _VEHICLE_CATEGORIES_HEADER_IMAGEPOS; ?>:</td>
                                <td><?php echo $lists['image_position']; ?></td>
                            </tr>
                            <tr>
                                <td width="185"><?php echo _VEHICLE_CATEGORIES_HEADER_ORDER; ?>:</td>
                                <td><?php echo $lists['ordering']; ?></td>
                            </tr>
                            <tr>
                                <td width="185"><?php echo _VEHICLE_HEADER_ACCESS; ?>:</td>
                                <td><?php echo $lists['category']['registrationlevel']; ?></td>
                            </tr>
                            <tr>
                                <td width="185"><?php echo _VEHICLE_HEADER_PUBLISHED; ?>:</td>
                                <td><?php echo $lists['published']; ?></td>
                            </tr>
                            <tr>
                                <td width="185"><?php echo _VEHICLE_CATEGORIES__DETAILS; ?>:</td>
                                <td>
                                    <?php
                                    // parameters : areaname, content, hidden field, width, height, rows, cols
                                    editorArea('editor1', $row->description, 'description', '500', '200', '50', '5');
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="option" value="com_vehiclemanager" />
            <input type="hidden" name="section" value="categories" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
            <input type="hidden" name="sectionid" value="com_vehiclemanager" />
            <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
        </form>
        <?php
    }

}

/**
 * Vehiclemanager Import Export Class
 * Handles the import and export of data from the VehicleManager.
 */
class HTML_vehiclemanager
{
    static function edit_review($option, $vehicle_id, &$review)
    {
        global $my, $mosConfig_live_site, $mainframe;
        // for 1.6
        global $doc, $css;
        $doc->addStyleSheet($css);
        $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');

        $html = "<div class='vehicle_manager_caption' >" .
         "<img src='./components/com_vehiclemanager/images/building_icon.jpg' alt ='Config' /> " .
          _VEHICLE_MANAGER_SHOW_REVIEW_MANAGER . "</div>";
        $app = JFactory::getApplication();
        $app->JComponentTitle = $html;
        // --
        ?>
        <form action="index.php" method="post" name="adminForm"  id="adminForm" enctype="multipart/form-data">

            <table cellpadding="4" cellspacing="5" border="0" width="100%" class="adminform adminform_04">
                <tr>
                    <td colspan="2"><?php echo _VEHICLE_MANAGER_LABEL_REVIEW_TITLE; ?></td>
                </tr>
                <tr>
                    <td colspan="2"><input class="inputbox" type="text" name="title" size="80" value="<?php echo $review[0]->title ?>" /></td>
                </tr>
                <tr>
                    <td><?php echo _VEHICLE_MANAGER_LABEL_REVIEW_COMMENT; ?></td>
                    <td align="left" ><?php echo _VEHICLE_MANAGER_LABEL_REVIEW_RATING; ?></td>
                </tr>
                <tr>
                    <td>
                        <?php
                        editorArea('editor1', $review[0]->comment, 'comment', '410', '200', '60', '10');
                        ?>
                    </td>
                    <td width="102" align='left'>
                        <?php
                        $k = 0;
                        while ($k < 11) {
                            ?>
                            <input type="radio" name="rating" value="<?php echo $k; ?>" 
            <?php if ($k == $review[0]->rating) echo 'checked="checked"'; ?> alt="Rating" />

                            <img src="../components/com_vehiclemanager/images/rating-<?php echo $k; ?>.png" 
                                 alt="<?php echo ($k) / 2; ?>" border="0" /><br />
                                 <?php
                                 $k++;
                             }
                             ?>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="option" value="<?php echo $option; ?>" />
            <input type="hidden" name="task" value="update_review" />
            <input type="hidden" name="vehicle_id" value="<?php echo $vehicle_id; ?>" />
            <input type="hidden" name="review_id" value="<?php echo $review[0]->id; ?>" />
        </form>
        <?php
    }

//*************   begin for manage reviews   ********************/
    static function edit_manage_review($option, & $review)
    {
        global $my, $mosConfig_live_site, $mainframe;
        // for 1.6
        global $doc, $css;
        $doc->addStyleSheet($css);
        $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');

        $html = "<div class='vehicle_manager_caption' >" .
         "<img src='./components/com_vehiclemanager/images/building_icon.jpg' alt ='Config' /> " .
          _VEHICLE_MANAGER_SHOW_REVIEW_MANAGER . "</div>";
        $app = JFactory::getApplication();
        $app->JComponentTitle = $html;
        // --
        ?>
        <form action="index.php" method="post" name="adminForm"  id="adminForm" enctype="multipart/form-data">
            <table cellpadding="4" cellspacing="5" border="0" width="100%" class="adminform adminform_05">
                <tr>
                    <td colspan="2" align="left"><?php echo _VEHICLE_MANAGER_LABEL_REVIEW_TITLE; ?></td>
                </tr>
                <tr>
                    <td colspan="2" align="left"> <input class="inputbox"
                     type="text" name="title" size="80" value="<?php echo $review[0]->title ?>" /></td>
                </tr>
                <tr>
                    <td><?php echo _VEHICLE_MANAGER_LABEL_REVIEW_COMMENT; ?></td>
                    <td align="left" ><?php echo _VEHICLE_MANAGER_LABEL_REVIEW_RATING; ?></td>
                </tr>
                <tr>
                    <td align="left">
                    <!--<textarea align= "top" name="comment" id="comment" cols="60"
                     rows="10" style="width:400;height:100;"/></textarea>-->

                        <?php
                        editorArea('editor1', $review[0]->comment, 'comment', '410', '200', '60', '10');
                        ?> 
                    </td>
                    <td width="40%" align='left'>
                        <?php
                        $k = 0;
                        while ($k < 11) {
                            ?>
                            <input type="radio" name="rating" value="<?php echo $k; ?>" 
            <?php if ($k == $review[0]->rating) echo 'checked="checked"'; ?> alt="Rating" />
                            <img src="../components/com_vehiclemanager/images/rating-<?php echo $k; ?>.png" 
                                 alt="<?php echo ($k) / 2; ?>" border="0" /><br />
                                 <?php
                                 $k++;
                             }
                             ?>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="option" value="<?php echo $option; ?>" />
            <input type="hidden" name="task" value="update_edit_manage_review" />
            <input type="hidden" name="review_id" value="<?php echo $review[0]->id; ?>" />
        </form>
        <?php
    }

//***************   end for manage reviews   ********************/

    static function showRequestRentVehicles($option, & $rent_requests, $v_associated, $title_assoc, & $pageNav)
    {
        global $my, $mosConfig_live_site, $mainframe;
        // for 1.6
        global $doc, $css;
        $doc->addStyleSheet($css);
        $doc->addScript($mosConfig_live_site . '/media/system/js/core.js');
        $doc->addScript($mosConfig_live_site .
         '/components/com_vehiclemanager/includes/functions.js');
        $html = "<div class='vehicle_manager_caption' >" .
         "<img src='./components/com_vehiclemanager/images/building_icon.jpg' alt ='Config' /> "
          . _VEHICLE_MANAGER_ADMIN_REQUEST_RENT . "</div>";
        $app = JFactory::getApplication();
        $app->JComponentTitle = $html;
        ?>
        <form action="index.php" method="post" name="adminForm"  id="adminForm" >
            <?php if (version_compare(JVERSION, "3.0.0", "ge"))
            {
                ?>
                <table width="100%"  class="table_02">
                    <tr>
                        <td>
                            <div class="btn-group pull-right hidden-phone">
                                <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
            <?php echo $pageNav->getLimitBox(); ?>
                            </div>
                        </td>                
                    </tr>
                </table>
        <?php } ?>
            <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist adminlist_02">
                <tr>
                    <th align = "center" width="20">
                        <input type="checkbox" name="toggle" onClick="vm_checkAll(this<?php //echo count( $rent_requests );   ?>);" />
                    </th>
                    <th align = "center" width="30">#</th>
                    <th align = "center" class="title" width="10%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_FROM; ?></th>
                    <th align = "center" class="title" width="10%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_UNTIL; ?></th>
                    <th align = "center" class="title" width="5%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_VEHICLEID; ?></th>
                    <th align = "center" class="title" width="15%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_TITLE; ?></th>
                    <th align = "center" class="title" width="15%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_USER; ?></th>
                    <th align = "center" class="title" width="15%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_EMAIL; ?></th>
                    <th align = "center" class="title" width="20%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_ADRES; ?></th>
                </tr>
                <?php
                for ($i = 0, $n = count($rent_requests); $i < $n; $i++) {
                    $row = $rent_requests[$i];
                     $assoc_title = ''; 
                      for ($t = 0, $z = count($title_assoc); $t < $z; $t++) {
                          if($title_assoc[$t]->vtitle != $row->vtitle) $assoc_title .= " ".$title_assoc[$t]->vtitle; 
                      }
                    ?>
                    <tr class="row<?php echo $i % 2; ?>">
                        <td width="20" align="center">
                            <?php
                            echo mosHTML::idBox($i, $row->id, false, 'vid');
                            ?>
                        </td>
                        <td align = "center"><?php echo $row->id; ?></td>
                        <td align = "center"><?php echo $row->rent_from; ?></td>
                        <td align = "center"><?php echo $row->rent_until; ?></td>
                        <td align = "center"><?php
                            $data = JFactory::getDBO();
                            $query = "SELECT vehicleid FROM #__vehiclemanager_vehicles where id = " . $row->fk_vehicleid . " ";
                            $data->setQuery($query);
                            $vehicleid = $data->loadObjectList();

                            echo $vehicleid[0]->vehicleid;
                            ?></td>
                        <td align = "center"><?php echo $row->vtitle . " ( " . $assoc_title ." ) "; ?></td>
                        <td align = "center"><?php echo $row->user_name; ?></td>
                        <td align = "center"><a href=mailto:"<?php echo $row->user_email; ?>"><?php echo $row->user_email; ?></a></td>
                        <td align = "center"><?php echo $row->user_mailing; ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr><td colspan = "11"><?php echo $pageNav->getListFooter(); ?></td></tr>
            </table>
            <input type="hidden" name="option" value="<?php echo $option; ?>" />
            <input type="hidden" name="task" value="rent_requests" />
            <input type="hidden" name="boxchecked" value="0" />
        </form>

        <?php
    }

    static function showRequestBuyingVehicles($option, $buy_requests, $pageNav)
    {
        global $my, $mosConfig_live_site, $mainframe;
        // for 1.6
        global $doc, $css;
        $doc->addStyleSheet($css);
        $doc->addScript($mosConfig_live_site . '/media/system/js/core.js');
        $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');

        $html = "<div class='vehicle_manager_caption' ><img src='./components/com_vehiclemanager/images/building_icon.jpg' alt ='Config' /> " . _VEHICLE_MANAGER_ADMIN_SALE_MANAGER . "</div>";
        $app = JFactory::getApplication();
        $app->JComponentTitle = $html;
        ?>
        <form action="index.php" method="post" name="adminForm"  id="adminForm" >
        <?php if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            ?>
                <table width="100%"  class="table_03">
                    <tr>
                        <td>
                            <div class="btn-group pull-right hidden-phone">
                                <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
            <?php echo $pageNav->getLimitBox(); ?>
                            </div>
                        </td>                
                    </tr>
                </table>
        <?php } ?>
            <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist adminlist_03">
                <tr>
                    <th align = "center" >
                        <input type="checkbox" name="toggle" onClick="vm_checkAll(this<?php //echo count( $buy_requests );   ?>);" />
                    </th>
                    <th align = "center" >#</th>
                    <th align = "center" class="title"  nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_VEHICLEID; ?></th>
                    <th align = "center" class="title"  nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_TITLE; ?></th>
                    <th align = "center" class="title"  nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_USER; ?></th>
                    <th align = "center" class="title"  nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_COMMENT; ?></th>
                    <th align = "center" class="title"  nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_EMAIL; ?></th>
                    <th align = "center" class="title"  nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_BUYING_ADRES; ?></th>
                </tr>
                <?php
                for ($i = 0, $n = count($buy_requests); $i < $n; $i++) {
                    $row = $buy_requests[$i];
                    ?>

                    <tr class="row<?php echo $i % 2; ?>">
                        <td width="20">
                            <?php if ($row->fk_rentid != 0)
                            {
                                ?>
                                &nbsp;
                                    <?php
                                } else
                                {
                                    ?>
                                <div align = "center">
                                <?php
                                echo mosHTML::idBox($i, $row->id, ($row->fk_rentid != 0), 'vid');
                                ?>
                                </div>
                <?php
            }
            ?>
                        </td>
                        <td align = "center"><?php echo $row->id; ?></td>
                        <td align = "center"><?php echo $row->fk_vehicleid; ?></td>
                        <td align = "center"><?php echo $row->vtitle; ?></td>
                        <td align = "center"><?php echo $row->customer_name; ?></td>
                        <td align = "center" widt="30%"><?php echo $row->customer_comment; ?></td>
                        <td align = "center">
                            <a href=mailto:"<?php echo $row->customer_email; ?>">
                    <?php echo $row->customer_email; ?>
                            </a>
                        </td>
                        <td align = "center"><?php echo $row->customer_phone; ?></td>
                    </tr>
        <?php } ?>
            </table>
            <?php echo $pageNav->getListFooter(); ?>
            <input type="hidden" name="option" value="<?php echo $option; ?>" />
            <input type="hidden" name="task" value="buying_requests" />
            <input type="hidden" name="boxchecked" value="0" />
        </form>
        <?php
    }

    static function showVehicles($option, $rows_vehicle,& $language, & $clist, & $rentlist,
        & $publist, & $ownerlist, & $search, & $pageNav)
    {
        global $my, $mosConfig_live_site, $mainframe, $session, $templateDir;
        // for 1.6
        global $doc, $css;
        $doc->addStyleSheet($css);
        $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');
        //$doc->addScript($mosConfig_live_site.'/components/com_vehiclemanager/includes/functions.js', 'text/javascript');

        $html = "<div class='vehicle_manager_caption' ><img src='./components/com_vehiclemanager/images/building_icon.jpg' alt ='Config' /> " . _VEHICLE_MANAGER_SHOW . "</div>";
        $app = JFactory::getApplication();
        $app->JComponentTitle = $html;

        $script = "
        function before_print_check(){
            var add = document.getElementsByName('vid[]');
            var count=0;    

            for(var i=0;i<add.length;i++){
                if(add[i].checked){
                    count++;
                    break;
                }
            }

            if(count == 0){
                alert('Please choose some vehicles'); 
                exit;
            } else{
                document.adminForm.target = '_blank' ;
                document.adminForm.task.value='print_vehicles';
                document.adminForm.submit(); 
            }
        } ";
        $doc->addScriptDeclaration($script);
        // --
        ?>
        <form action="index.php" method="post" name="adminForm"  class="vehicles_main"  id="adminForm" >
            <table cellpadding="4" cellspacing="0" border="0" width="100%">
                <tr>                
                    <!--********   begin add for button print in Manager Vehicles   *******************-->
                    </td>
                    <!--******   end add for button print in Manager Vehicles   *******************-->
                </tr>
            </table>
            <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist adminlist_03">
                <tr>
                    <td><?php echo _VEHICLE_MANAGER_SHOW_SEARCH; ?></td>
                    <td><input type="text" name="search" value="<?php echo $search; ?>" class="inputbox" onChange="document.adminForm.submit();" /></td>
                    <td><?php echo $publist; ?></td>
                    <td><?php echo $ownerlist; ?></td>
                    <td><?php echo $rentlist; ?></td>
                    
                    <td><?php echo $language; ?></td>
                    <td width="0px">
                       
                            <?php if (version_compare(JVERSION, "3.0.0", "ge"))
                            {
                                ?>
                        <td>
                            <div class="btn-group pull-left hidden-phone">
                                <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
            <?php echo $pageNav->getLimitBox(); ?>
                            </div>
                        </td> 
        <?php } ?>
                    </td>
                </tr>
            </table>
            <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist adminlist_04">
                <tr>
                    <th width="20"><input type="checkbox" name="toggle" onClick="vm_checkAll(this<?php //echo count( $rows_vehicle );   ?>);" /></th>
                    <th width="30">#</th>
                    <th align = "center" class="title" width="5%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_VEHICLEID; ?></th>
                    <th align = "center" class="title" width="27%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_TITLE; ?></th>
                    <th align = "center" class="title" width="27%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_MAKER, ', ', _VEHICLE_MANAGER_LABEL_MODEL; ?></th>
                    <th align = "center" class="title" width="16%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_CATEGORY; ?></th>
                    <th align = "center" class="title" width="5%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_OWNER; ?></th>
                    <th align = "center" class="title" width="5%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT; ?></th>
                    <th align = "center" class="title" width="5%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_HITS; ?></th>
                    <th align = "center" class="title" width="5%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_PUBLIC; ?></th>
                    <th align = "center" class="title" width="5%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_APPROVED; ?></th>
                    <th align = "center" class="title" width="5%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_CONTROL; ?></th>
                     <th align = "center" class="title" width="5%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_LANGUAGE; ?></th>
                    
                </tr>
        <?php
        for ($i = 0, $n = count($rows_vehicle); $i < $n; $i++) {
            $row = $rows_vehicle[$i];
            ?>
                    <tr class="row<?php echo $i % 2; ?>">

                        <td width="20" align="left">        
                            <?php if ($row->checked_out && $row->checked_out != $my->id)
                            {
                                ?>
                                &nbsp;
                <?php
            } else
                echo mosHTML::idBox($i, $row->id, ($row->checked_out && $row->checked_out != $my->id), 'vid');
            ?>
                        </td>
                        <td align = "center"><?php echo $row->id; ?></td>
                        <td align = "center"><?php echo $row->vehicleid; ?></td>

                        <td align="left">
                            <?php
                            if ($row->checked_out && $row->checked_out != $my->id)
                            {
                                echo $row->vtitle . " [ <i>Checked Out</i> ]";
                            } else
                            {
                                ?>
                                <a href="#edit" onClick="return listItemTask('cb<?php echo $i; ?>','edit')">
                                <?php echo $row->vtitle; ?>
                                </a>
                            <?php } ?>
                        </td>
                        <td align="left">
                            <?php
                            if ($row->checked_out && $row->checked_out != $my->id)
                            {
                                if ($row->maker == '' || $row->maker == 'other')
                                    echo $row->vmodel . " [ <i>Checked Out</i> ]";
                                else
                                    echo $row->maker . ', ' . $row->vmodel . " [ <i>Checked Out</i> ]";
                            } else
                            {
                                ?>
                                <a href="#edit" onClick="return listItemTask('cb<?php echo $i; ?>','edit')">
                                <?php
                                if ($row->maker == '' || $row->maker == 'other')
                                    echo $row->vmodel;
                                else
                                    echo $row->maker . ', ' . $row->vmodel;
                                ?>
                                </a>
            <?php } ?>
                        </td>
                        <!--td>
                            <?php echo $pageNav->orderUpIcon($i, ($row->catid == @$rows_vehicle[$i - 1]->catid), "vehicleorderup"); ?>
                        </td>
                              <td>
                            <?php echo $pageNav->orderDownIcon($i, $n, ($row->catid == @$rows_vehicle[$i + 1]->catid), "vehicleorderdown"); ?>
                        </td-->
                        <td align = "center"><?php echo $row->category; ?></td>                        
                        <td align = "center"><?php echo $row->editor; ?></td>
                        <td align = "center">
            <?php
            if ($row->listing_type == 1)
            {
                if ($row->rent_from == null)
                {
                    ?>
                                    <a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i; ?>','rent')">
                                        <img src='./components/com_vehiclemanager/images/lend_f2.png' align='middle' width='15' height='15' border='0' alt='Rent out' />
                                        <br />
                                    </a>
                                    <?php
                                } else
                                {
                                    ?>
                                    <a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i; ?>','rent_return')"> 
                                        <img src='./components/com_vehiclemanager/images/lend_return_f2.png' align='middle' width='15' height='15' border='0' alt='Return vehicle' />
                                        <br />
                                    </a>
                                <?php
                            }
                        }
                        ?>
                        </td>
                        <td align = "center"><?php echo $row->hits; ?></td>
                        <?php
                        $task = $row->published ? 'unpublish' : 'publish';
                        $alt = $row->published ? 'Unpublish' : 'Publish';
                        $img = $row->published ? 'tick.png' : 'publish_x.png';

                        $task1 = $row->approved ? 'unapprove' : 'approve';
                        $alt1 = $row->approved ? 'Unapproved' : 'Approved';
                        $img1 = $row->approved ? 'tick.png' : 'publish_x.png';
                        ?>
                        <td width="5%" align="center">
                            <a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i; ?>','<?php echo $task; ?>')">
                                <?php
                                if (version_compare(JVERSION, "1.6.0", "lt"))
                                {
                                    ?>
                                    <img src="<?php echo $mosConfig_live_site . "/administrator/images/" . $img; ?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
                                    <?php
                                } else
                                {
                                    ?>
                                    <img src="<?php echo $templateDir . "/images/admin/" . $img; ?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
                                    <?php
                                }
                                ?>
                            </a>
                        </td>
                        <td width="5%" align="center">
                            <a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i; ?>','<?php echo $task1; ?>')">
                                <?php
                                if (version_compare(JVERSION, "1.6.0", "lt"))
                                {
                                    ?>
                                    <img src="<?php echo $mosConfig_live_site . "/administrator/images/" . $img1; ?>" width="12" height="12" border="0" alt="<?php echo $alt1; ?>" />
                                    <?php
                                } else
                                {
                                    ?>
                                    <img src="<?php echo $templateDir . "/images/admin/" . $img1; ?>" width="12" height="12" border="0" alt="<?php echo $alt1; ?>" />
                            <?php
                        }
                        ?>
                            </a>
                        </td>
                        
                        <?php
                        if ($row->checked_out)
                        {
                            ?>
                            <td align="center"><?php echo $row->editor1; ?></td>
                    <?php } else
                    {
                        ?>
                            <td align="center">&nbsp;</td>
            <?php } ?>
                            <td align = "center"><?php echo $row->language; ?></td>
                    </tr>
            <?php
        }//end for
        ?>
                <tr><td colspan = "13"><?php echo $pageNav->getListFooter(); ?></td>
                </tr>
            </table>
            <input type="hidden" name="option" value="<?php echo $option; ?>" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
        </form>

        <?php
    }

//**********   begin for manage reviews  *****************
    static function showManageReviews($option, & $pageNav, & $reviews)
    {
        global $my, $mosConfig_live_site, $mainframe, $templateDir;
        // for 1.6
        global $doc, $css;
        $doc->addStyleSheet($css);
        $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');
        $doc->addScript($mosConfig_live_site . '/media/system/js/core.js');

        $html = "<div class='vehicle_manager_caption' ><img src='./components/com_vehiclemanager/images/building_icon.jpg' alt ='Config' /> " . _VEHICLE_MANAGER_SHOW_REVIEW_MANAGER . "</div>";
        $app = JFactory::getApplication();
        $app->JComponentTitle = $html;
        ?>
        <form action="index.php" method="post" name="adminForm" id="adminForm" >
        <?php if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            ?>
                <table width="100%"  class="table_04">
                    <tr>
                        <td>
                            <div class="btn-group pull-right hidden-phone">
                                <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
            <?php echo $pageNav->getLimitBox(); ?>
                            </div>
                        </td>                
                    </tr>
                </table>
        <?php } ?>
            <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist adminlist_05">
                <tr>
                    <th width="20" align="center"><input type="checkbox" name="toggle" onClick="vm_checkAll(this<?php //echo count( $reviews );  ?>);" /></th>
                    <th align="center" width="30"><a href="#numer" onClick="return listItemTask('cb<?php echo "1"; ?>','sorting_manage_review_numer');">#</a></th>
                    <th align="center" class="title" width="25%" nowrap="nowrap"><a href="#vehicle_title" onClick="return listItemTask('cb<?php echo "1"; ?>','sorting_manage_review_title_vehicle');"><?php echo _VEHICLE_MANAGER_LABEL_TITLE_VEHICLE; ?></a></th>
                    <th align="center" class="title" width="16%" nowrap="nowrap"><a href="#title_catigory" onClick="return listItemTask('cb<?php echo "1"; ?>','sorting_manage_review_title_catigory');"><?php echo _VEHICLE_MANAGER_LABEL_CATEGORY; ?></a></th>
                    <th align="center" class="title" width="25%" nowrap="nowrap"><a href="#title_review" onClick="return listItemTask('cb<?php echo "1"; ?>','sorting_manage_review_title_review');"><?php echo _VEHICLE_MANAGER_LABEL_TITLE_COMMENT; ?></a></th>
                    <th align="center" class="title" width="7%" nowrap="nowrap"><a href="#user_name" onClick="return listItemTask('cb<?php echo "1"; ?>','sorting_manage_review_user_name');"><?php echo _VEHICLE_MANAGER_LABEL_RENT_USER; ?></a></th>
                    <th align="center" class="title" width="8%" nowrap="nowrap"><a href="#date" onClick="return listItemTask('cb<?php echo "1"; ?>','sorting_manage_review_date');"><?php echo _VEHICLE_MANAGER_REVIEW_DATE; ?></a></th>
                    <th align="center" class="title" width="7%" nowrap="nowrap"><a href="#rating" onClick="return listItemTask('cb<?php echo "1"; ?>','sorting_manage_review_rating');"><?php echo _VEHICLE_MANAGER_LABEL_RATING; ?></a></th>
                    <th align="center" class="title" width="7%" nowrap="nowrap"><a href="#published" onClick="return listItemTask('cb<?php echo "1"; ?>','sorting_manage_review_published');"><?php echo _VEHICLE_HEADER_PUBLISHED; ?></a></th>
                </tr>
                        <?php
                        for ($i = 0, $n = count($reviews); $i < $n; $i++) {
                            $row = $reviews[$i];
                            ?>
                    <tr class="row<?php echo $i % 2; ?>">
                        <td width="20" align="center">
                          <!--<input type="checkbox" id="cb<?php echo $i; ?>" name="vid[]" value="<?php echo $row->review_id; ?>" onClick="isChecked(this.checked);" />-->
                                <?php
                                echo mosHTML::idBox($i, $row->review_id, false, 'vid');
                                ?>
                        </td>
                        <td align="center" width="30"><?php echo $reviews[$i]->review_id; ?></td>
                        <td align="center" width="25%"><?php echo $reviews[$i]->vehicle_title; ?></td>
                        <td align="center" width="16%"><?php echo $reviews[$i]->title_catigory; ?></td>
                        <td align="center" width="25%">
                            <a href="#edit" onClick="return listItemTask('cb<?php echo $i; ?>','edit_manage_review');">
                                <?php
                                //if 'title_comment' >55 else 'title_comment' -- all
                                if (strlen($reviews[$i]->title_review) > 55)
                                {
                                    for ($j = 0; $j < 55; $j++) {
                                        echo $reviews[$i]->title_review[$j];
                                    }
                                } else
                                {
                                    echo $reviews[$i]->title_review; /* title comment */
                                }
                                ?>
                            </a>
                        </td>
                        <td align="center" width="7%"><?php echo $reviews[$i]->user_name; ?></td>
                        <td align="center" width="8%"><?php echo $reviews[$i]->date; ?></td>
                        <td align="center" width="7%">
                            <div><img src="../components/com_vehiclemanager/images/rating-<?php echo $reviews[$i]->rating; ?>.png" alt="<?php echo ($reviews[$i]->rating) * 2; ?>" border="0" align="right"/>&nbsp;</div>
                        </td>
                        <td align="center" width="7%">
                                <?php
                                $task = $reviews[$i]->published ? 'unpublish_manage_review' : 'publish_manage_review';
                                $alt = $reviews[$i]->published ? 'Unpublish' : 'Publish';
                                $img = $reviews[$i]->published ? 'tick.png' : 'publish_x.png';
                                ?>
                            <a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i; ?>','<?php echo $task; ?>')">
                                <?php
                                if (version_compare(JVERSION, "1.6.0", "lt"))
                                {
                                    ?>
                                    <img src="<?php echo $mosConfig_live_site . "/administrator/images/" . $img; ?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
                <?php
            } else
            {
                ?>
                                    <img src="<?php echo $templateDir . "/images/admin/" . $img; ?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
                        <?php
                    }
                    ?>
                            </a>

                        </td>
                    </tr>
            <?php
        }//end for(...)
        ?>
                <tr><td colspan = "11"><?php echo $pageNav->getListFooter(); ?></td></tr>
            </table>

                    <!--input type="hidden" name="id" value="<?php /* echo $$row->fk_vehicleid;; */ ?>" /-->
            <input type="hidden" name="option" value="<?php echo $option; ?>" />
            <input type="hidden" name="task" value="manage_review" />
            <input type="hidden" name="boxchecked" value="0" />
        </form>

        <?php
    }

//*****************   end for manage reviews   ****************************************
//***************   begin add for button print in Manager Vehicles   ********************
    static function showPrintVehicles($rows)
    {
        global $my, $mosConfig_live_site, $mainframe;
        // for 1.6
        global $doc;
        $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');
        // --
        ?>
        <html>
            <head>
                <title>
                </title>
            </head>
            <body>
                <form name="Print" action="<?php echo $mosConfig_live_site; ?>/administrator/index.php?option=com_vehiclemanager&task=print_item" method="post" target="_top">
                    <div class="adminform_49">
        <?php echo _VEHICLE_MANAGER_TOOLBAR_ADMIN_PRINT_FONT_SIZE; ?>:
                        <select name="font_size" title="Select size font!">
                            <option value="1">1
                            <option value="2">2
                            <option value="3">3
                            <option value="4">4
                            <option value="5">5
                            <option value="6">6
                            <option value="7">7
                            <option value="8" selected >8
                            <option value="9">9
                            <option value="10">10
                            <option value="11">11
                            <option value="12">12
                            <option value="13">13
                            <option value="14">14
                            <option value="15">15
                            <option value="16">16
                            <option value="17">17
                            <option value="18">18
                        </select>
                        <br /><?php echo _VEHICLE_MANAGER_TOOLBAR_ADMIN_PRINT_FORMAT; ?>:<br />
                        <!--
                            <input type="radio" name="format_w_h" value="verticall" title="Checked format!" checked/>Vertically
                            <input type="radio" name="format_w_h" value="horizontall" title="Checked format!"/>Horizontally<br />
                        -->
                        <input type="hidden" name="format_w_h" value="verticall" title="Checked format!" checked />

                        <select name="format" title="Select size font!">
                            <option value="A5">A5&nbsp;(148x210&nbsp;mm)
                            <option value="A4" selected >A4&nbsp;(210x297&nbsp;mm)
                            <option value="A3">A3&nbsp;(297x420&nbsp;mm)
                            <option value="Letter">Letter&nbsp;(8,5x11&nbsp;inch)
                            <option value="Legal">Legal&nbsp;(8,5x14&nbsp;inch)
                            <option value="Tabloid">Tabloid&nbsp;(11x17&nbsp;inch)
                            <option value="Executive">Executive&nbsp;(7,5x10&nbsp;inch)
                        </select>
                        <p><?php echo _VEHICLE_MANAGER_TOOLBAR_ADMIN_PRINT_SELECT; ?>
                            <br />
                            <input type="submit" value="Next" title="Next step for print!"/>
                        </p>
                    </div>

                    <table cellpadding="4" cellspacing="0" border="1px" style="width:180mm" class="adminlist adminlist_06">
                        <tr class="printbg">
                            <td width="5%" nowrap="nowrap" align="center"><?php echo _VEHICLE_MANAGER_TOOLBAR_ADMIN_PRINT; ?>
                                <input type="checkbox" name="print_id" value="1" title="Select for print!" checked />
                            </td>
                            <td width="5%" nowrap="nowrap" align="center"><?php echo _VEHICLE_MANAGER_TOOLBAR_ADMIN_PRINT; ?>
                                <input type="checkbox" name="print_vehicleid" value="1" title="Select for print!" checked />
                            </td>
                            <td width="20%" nowrap="nowrap" align="center"><?php echo _VEHICLE_MANAGER_TOOLBAR_ADMIN_PRINT; ?>
                                <input type="checkbox" name="print_title" value="1" title="Select for print!" checked />
                            </td>
                            <td width="10%" nowrap="nowrap" align="center"><?php echo _VEHICLE_MANAGER_TOOLBAR_ADMIN_PRINT; ?>
                                <input type="checkbox" name="print_category" value="1" title="Select for print!" checked />
                            </td>
                            <td width="10%" nowrap="nowrap" align="center"><?php echo _VEHICLE_MANAGER_TOOLBAR_ADMIN_PRINT; ?>
                                <input type="checkbox" name="print_rent_from" value="1" title="Select for print!" checked />
                            </td>
                            <td width="10%" nowrap="nowrap" align="center"><?php echo _VEHICLE_MANAGER_TOOLBAR_ADMIN_PRINT; ?>
                                <input type="checkbox" name="print_rent_until" value="1" title="Select for print!" checked />
                            </td>
                            <td width="10%" nowrap="nowrap" align="center"><?php echo _VEHICLE_MANAGER_TOOLBAR_ADMIN_PRINT; ?>
                                <input type="checkbox" name="print_user_name" value="1" title="Select for print!" checked />
                            </td>
                            <td width="10%" nowrap="nowrap" align="center"><?php echo _VEHICLE_MANAGER_TOOLBAR_ADMIN_PRINT; ?>
                                <input type="checkbox" name="print_user_email" value="1" title="Select for print!" checked />
                            </td>
                            <td width="10%" nowrap="nowrap" align="center"><?php echo _VEHICLE_MANAGER_TOOLBAR_ADMIN_PRINT; ?>
                                <input type="checkbox" name="print_user_mailing" value="1" title="Select for print!" checked />
                            </td>
                            <td width="5%" nowrap="nowrap" align="center"><?php echo _VEHICLE_MANAGER_TOOLBAR_ADMIN_PRINT; ?>
                                <input type="checkbox" name="print_hits" value="1" title="Select for print!" checked />
                            </td>
                        </tr>
                        <tr class="printbg">
                            <th width="5%">#</th>
                            <th width="5%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_VEHICLEID; ?></th>
                            <th width="20%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_TITLE; ?></th>
                            <th width="10%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_CATEGORY; ?></th>
                            <th width="10%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_FROM; ?></th>
                            <th width="10%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_UNTIL; ?></th>
                            <th width="10%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_USER; ?></th>
                            <th width="10%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_EMAIL; ?></th>
                            <th width="10%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_ADRES; ?></th>
                            <th width="5%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_HITS; ?></th>
                        </tr>

        <?php for ($i = 0; $i < count($rows); $i++) { ?>
                            <tr bgcolor="#<?php
            if (($i % 2) != 1)
            {
                echo "efefef";
            } else
            {
                echo "ffffff";
            }
            ?>" >
                                <td width="5%" align="center"><?php echo wordwrap($rows[$i]->id, 6, "<br />\n", 1); ?></td>
                                <td width="5%" nowrap="nowrap" align="center"><?php echo wordwrap($rows[$i]->vehicleid, 6, "<br />\n", 1); ?></td>
                                <td width="20%" nowrap="nowrap"><?php echo wordwrap($rows[$i]->vtitle, 20, "<br />\n", 1); ?></td>
                                <td width="10%" nowrap="nowrap"><?php echo wordwrap($rows[$i]->category, 10, "<br />\n", 1); ?></td>
                                <td width="10%" nowrap="nowrap">
                                    <?php
                                    if (isset($rows[$i]->rent_from))
                                    {
                                        for ($j = 0; $j < 10; $j++) {
                                            echo $rows[$i]->rent_from[$j];
                                        }
                                    } else
                                    {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                                <td width="10%" nowrap="nowrap">
                                    <?php
                                    if (isset($rows[$i]->rent_until))
                                    {
                                        for ($j = 0; $j < 10; $j++) {
                                            echo $rows[$i]->rent_until[$j];
                                        }
                                    } else
                                    {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                                <td width="10%" nowrap="nowrap">
                                    <?php
                                    if (isset($rows[$i]->user_name) && ($rows[$i]->user_name != ""))
                                    {
                                        echo wordwrap($rows[$i]->user_name, 10, "<br />\n", 1);
                                    } else
                                    {
                                        echo "--";
                                    }
                                    ?>
                                </td>
                                <td width="10%" nowrap="nowrap">
            <?php
            if (isset($rows[$i]->user_email) && ($rows[$i]->user_email != ""))
            {
                echo wordwrap($rows[$i]->user_email, 10, "<br />\n", 1);
            } else
            {
                echo "--";
            }
            ?>
                                </td>
                                <td width="10%" nowrap="nowrap">
            <?php
            if (isset($rows[$i]->user_mailing) && ($rows[$i]->user_mailing != ""))
            {
                echo wordwrap($rows[$i]->user_mailing, 10, "<br />\n", 1);
            } else
            {
                echo "--";
            }
            ?>
                                </td>
                                <td width="5%" nowrap="nowrap"><?php echo wordwrap($rows[$i]->hits, 6, "<br />\n", 1); ?></td>
                            </tr>
        <?php } ?>
                    </table>
                </form>
            </body>
        </html>
        <?php
        @ session_start();
        $_SESSION['rows'] = $rows;
        exit();
    }

//end showPrintVehicles($rows)
//*********************************************************************************

    static function showPrintItem($rows)
    {
        global $my, $mosConfig_live_site, $mainframe;
        // for 1.6
        global $doc, $css;
        $doc->addStyleSheet($css);
        $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');
        // --
        ?>
        <html> 
            <head>  
                <title>
                </title>
                <style type="text/css">
                    .print_font_nik {
                        background-color: #ffffff;
                        font-size: <?php echo $_REQUEST['font_size']; ?>pt;
                        color: #000000;
                        font-family: Arial, Times, Helvetica, Zapf-Chancery, Western, Courier;
                    }
                </style>
                <script language="JavaScript" type="text/javascript">
                    function print_item_no_button() {
                        var el  = document.getElementById('print_button_off'); 
                        el.style.display = 'none';  
                        window.print();
                    }
                </script>
            </head>
            <body>
                <div align="left" id="print_button_off">
                    <p align="left">
                        <a href="#" onClick="javascript:print_item_no_button();" title="Print">
                            <img src="<?php echo $mosConfig_live_site; ?>/administrator/components/com_vehiclemanager/images/print.png"  alt="Print" name="Print" align="center" border="0" />
                        </a>
                    </p>        
                </div>
                <?php
                $kol = 0;
                if (isset($_REQUEST['print_id']))
                    $kol++;
                if (isset($_REQUEST['print_vehicleid']))
                    $kol++;
                if (isset($_REQUEST['print_title']))
                    $kol++;
                if (isset($_REQUEST['print_category']))
                    $kol++;
                if (isset($_REQUEST['print_rent_from']))
                    $kol++;
                if (isset($_REQUEST['print_rent_until']))
                    $kol++;
                if (isset($_REQUEST['print_user_name']))
                    $kol++;
                if (isset($_REQUEST['print_user_email']))
                    $kol++;
                if (isset($_REQUEST['print_user_mailing']))
                    $kol++;
                if (isset($_REQUEST['print_hits']))
                    $kol++;

                if (($kol < 11) && (isset($_REQUEST['print_title']) == 0) && ($kol != 0))
                    $k = (int) (100 / $kol);
                if (($kol < 11) && (isset($_REQUEST['print_title'])) && ($kol != 0))
                {
                    $k = (int) (100 / $kol);
                    if ($kol == 10)
                    {
                        $k_tit = $k + 9;
                        $k -= 1;
                    }
                    if ($kol == 9)
                    {
                        $k_tit = $k + 8;
                        $k -= 1;
                    }
                    if ($kol == 8)
                    {
                        $k_tit = $k + 15;
                        $k -= 2;
                    }
                    if ($kol == 7)
                    {
                        $k_tit = $k + 16;
                        $k -= 3;
                    }
                    if ($kol == 6)
                    {
                        $k_tit = $k + 20;
                        $k -= 4;
                    }
                    if ($kol == 5)
                    {
                        $k_tit = $k + 20;
                        $k -= 5;
                    }
                    if ($kol == 4)
                    {
                        $k_tit = $k + 15;
                        $k -= 5;
                    }
                    if ($kol == 3)
                    {
                        $k_tit = $k + 10;
                        $k -= 5;
                    }
                    if ($kol == 2)
                    {
                        $k_tit = $k;
                    }
                }//end if

                if ($kol != 0)
                {
                    if (($_REQUEST['format_w_h'] == 'verticall') && ($_REQUEST['format'] == 'A5'))
                    {
                        $width_tabl = 118;
                    }//138;}
                    if (($_REQUEST['format_w_h'] == 'verticall') && ($_REQUEST['format'] == 'A4'))
                    {
                        $width_tabl = 180;
                    }//200;}
                    if (($_REQUEST['format_w_h'] == 'verticall') && ($_REQUEST['format'] == 'A3'))
                    {
                        $width_tabl = 267;
                    }//287;}
                    if (($_REQUEST['format_w_h'] == 'verticall') && ($_REQUEST['format'] == 'Letter'))
                    {
                        $width_tabl = 185;
                    }//205;}
                    if (($_REQUEST['format_w_h'] == 'verticall') && ($_REQUEST['format'] == 'Legal'))
                    {
                        $width_tabl = 185;
                    }//205;}
                    if (($_REQUEST['format_w_h'] == 'verticall') && ($_REQUEST['format'] == 'Tabloid'))
                    {
                        $width_tabl = 249;
                    }//269;}
                    if (($_REQUEST['format_w_h'] == 'verticall') && ($_REQUEST['format'] == 'Executive'))
                    {
                        $width_tabl = 160;
                    }//180;}

                    if (($_REQUEST['format_w_h'] == 'horizontall') && ($_REQUEST['format'] == 'A5'))
                    {
                        $width_tabl = 200;
                    }
                    if (($_REQUEST['format_w_h'] == 'horizontall') && ($_REQUEST['format'] == 'A4'))
                    {
                        $width_tabl = 287;
                    }
                    if (($_REQUEST['format_w_h'] == 'horizontall') && ($_REQUEST['format'] == 'A3'))
                    {
                        $width_tabl = 410;
                    }
                    if (($_REQUEST['format_w_h'] == 'horizontall') && ($_REQUEST['format'] == 'Letter'))
                    {
                        $width_tabl = 269;
                    }
                    if (($_REQUEST['format_w_h'] == 'horizontall') && ($_REQUEST['format'] == 'Legal'))
                    {
                        $width_tabl = 343;
                    }
                    if (($_REQUEST['format_w_h'] == 'horizontall') && ($_REQUEST['format'] == 'Tabloid'))
                    {
                        $width_tabl = 421;
                    }
                    if (($_REQUEST['format_w_h'] == 'horizontall') && ($_REQUEST['format'] == 'Executive'))
                    {
                        $width_tabl = 244;
                    }
                    ?>
                    <table cellpadding="4" cellspacing="0" border="1px" style="width:<?php echo $width_tabl; ?>mm" class="print_font_nik">
                        <tr class="printbg">
                                <?php if (isset($_REQUEST['print_id']))
                                {
                                    ?>
                                <th width="<?php
                                    if (isset($k))
                                    {
                                        echo $k . "%";
                                    } else
                                    {
                                        echo "5%";
                                    }
                                    ?>">#</th>
                                <?php } ?>
                                <?php if (isset($_REQUEST['print_vehicleid']))
                                {
                                    ?>
                                <th width="<?php
                                    if (isset($k))
                                    {
                                        echo $k . "%";
                                    } else
                                    {
                                        echo "5%";
                                    }
                                    ?>" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_VEHICLEID; ?></th>
                            <?php } ?>
                            <?php if (isset($_REQUEST['print_title']))
                            {
                                ?>
                                <th width="<?php
                if (isset($k_tit))
                {
                    echo $k_tit . "%";
                } else if (($kol == 1) && (isset($_REQUEST['print_title'])))
                {
                    echo "100%";
                } else
                {
                    echo "20%";
                }
                                ?>" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_TITLE; ?></th>
                                <?php } ?>
                                <?php if (isset($_REQUEST['print_category']))
                                {
                                    ?>
                                <th width="<?php
                    if (isset($k))
                    {
                        echo $k . "%";
                    } else
                    {
                        echo "10%";
                    }
                                    ?>" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_CATEGORY; ?></th>
                            <?php } ?>
                            <?php if (isset($_REQUEST['print_rent_from']))
                            {
                                ?>
                                <th width="<?php
                if (isset($k))
                {
                    echo $k . "%";
                } else
                {
                    echo "10%";
                }
                                ?>" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_FROM; ?></th>
                            <?php } ?>
                            <?php if (isset($_REQUEST['print_rent_until']))
                            {
                                ?>
                                <th width="<?php
                if (isset($k))
                {
                    echo $k . "%";
                } else
                {
                    echo "10%";
                }
                                ?>" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_UNTIL; ?></th>
                                <?php } ?>
                                <?php if (isset($_REQUEST['print_user_name']))
                                {
                                    ?>
                                <th width="<?php
                                    if (isset($k))
                                    {
                                        echo $k . "%";
                                    } else
                                    {
                                        echo "10%";
                                    }
                                    ?>" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_USER; ?></th>
                                <?php } ?>
                            <?php if (isset($_REQUEST['print_user_email']))
                            {
                                ?>
                                <th width="<?php
                if (isset($k))
                {
                    echo $k . "%";
                } else
                {
                    echo "10%";
                }
                                ?>" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_EMAIL; ?></th>
                                    <?php } ?>
                                    <?php if (isset($_REQUEST['print_user_mailing']))
                                    {
                                        ?>
                                <th width="<?php
                                        if (isset($k))
                                        {
                                            echo $k . "%";
                                        } else
                                        {
                                            echo "10%";
                                        }
                                        ?>" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_ADRES; ?></th>
                                    <?php } ?>
                                    <?php if (isset($_REQUEST['print_hits']))
                                    {
                                        ?>
                                <th width="<?php
                        if (isset($k))
                        {
                            echo $k . "%";
                        } else
                        {
                            echo "5%";
                        }
                        ?>" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_HITS; ?></th>
                            <?php } ?>
                        </tr>
                            <?php for ($i = 0; $i < count($rows); $i++) {
                                ?>
                            <tr bgcolor="#<?php
                if (($i % 2) != 1)
                {
                    echo "efefef";
                } else
                {
                    echo "ffffff";
                }
                                ?>" >
                                        <?php if (isset($_REQUEST['print_id']))
                                        {
                                            ?>
                                    <td align="center" width="<?php
                        if (isset($k))
                        {
                            echo $k . "%";
                        } else
                        {
                            echo "5%";
                        }
                                            ?>">
                                    <?php
                                    if (isset($k))
                                    {
                                        $symbol = $k;
                                    } else
                                    {
                                        $symbol = 6;
                                    } echo wordwrap($rows[$i]->id, $symbol, "<br />\n", 1);
                                    ?>
                                    </td>
                                        <?php } ?>
                                        <?php if (isset($_REQUEST['print_vehicleid']))
                                        {
                                            ?>
                                    <td align="center" width="<?php
                        if (isset($k))
                        {
                            echo $k . "%";
                        } else
                        {
                            echo "5%";
                        }
                                            ?>" nowrap="nowrap">
                                    <?php
                                    if (isset($k))
                                    {
                                        $symbol = $k;
                                    } else
                                    {
                                        $symbol = 6;
                                    } echo wordwrap($rows[$i]->vehicleid, $symbol, "<br />\n", 1);
                                    ?>
                                    </td>
                                        <?php } ?>
                                <?php if (isset($_REQUEST['print_title']))
                                {
                                    ?>
                                    <td width="<?php
                    if (isset($k_tit))
                    {
                        echo $k_tit . "%";
                    } else if (($kol == 1) && (isset($_REQUEST['print_title'])))
                    {
                        echo "100%";
                    } else
                    {
                        echo "20%";
                    }
                                    ?>" nowrap="nowrap">
                                            <?php
                                            if (isset($k_tit))
                                            {
                                                $symbol = $k_tit;
                                            } else if (($kol == 1) && (isset($_REQUEST['print_title'])))
                                            {
                                                $symbol = $k;
                                            } else
                                            {
                                                $symbol = 20;
                                            }
                                            echo wordwrap($rows[$i]->vtitle, $symbol, "<br />\n", 1);
                                            ?>
                                    </td>
                                <?php } ?>
                                    <?php if (isset($_REQUEST['print_category']))
                                    {
                                        ?>
                                    <td width="<?php
                        if (isset($k))
                        {
                            echo $k . "%";
                        } else
                        {
                            echo "10%";
                        }
                                        ?>" nowrap="nowrap">
                                            <?php
                                            if (isset($k))
                                            {
                                                $symbol = $k;
                                            } else
                                            {
                                                $symbol = 10;
                                            } echo wordwrap($rows[$i]->category, $symbol, "<br />\n", 1);
                                            ?>
                                    </td>
                                <?php } ?>
                                <?php if (isset($_REQUEST['print_rent_from']))
                                {
                                    ?>
                                    <td width="<?php
                    if (isset($k))
                    {
                        echo $k . "%";
                    } else
                    {
                        echo "10%";
                    }
                                    ?>" nowrap="nowrap">
                                            <?php
                                            if (isset($rows[$i]->rent_from))
                                            {
                                                for ($j = 0; $j < 10; $j++) {
                                                    echo $rows[$i]->rent_from[$j];
                                                }
                                            } else
                                            {
                                                echo "--";
                                            }
                                            ?>
                                    </td>
                                <?php } ?>
                                <?php if (isset($_REQUEST['print_rent_until']))
                                {
                                    ?>
                                    <td width="<?php
                    if (isset($k))
                    {
                        echo $k . "%";
                    } else
                    {
                        echo "10%";
                    }
                                    ?>" nowrap="nowrap">
                                            <?php
                                            if (isset($rows[$i]->rent_until))
                                            {
                                                for ($j = 0; $j < 10; $j++) {
                                                    echo $rows[$i]->rent_until[$j];
                                                }
                                            } else
                                            {
                                                echo "--";
                                            }
                                            ?>
                                    </td>
                                <?php } ?>
                                <?php if (isset($_REQUEST['print_user_name']))
                                {
                                    ?>
                                    <td width="<?php
                    if (isset($k))
                    {
                        echo $k . "%";
                    } else
                    {
                        echo "10%";
                    }
                                    ?>" nowrap="nowrap">
                                            <?php
                                            if (isset($rows[$i]->user_name) && ($rows[$i]->user_name != ""))
                                            {
                                                if (isset($k))
                                                {
                                                    $symbol = $k;
                                                } else
                                                {
                                                    $symbol = 10;
                                                }
                                                echo wordwrap($rows[$i]->user_name, $symbol, "<br />\n", 1);
                                            } else
                                            {
                                                echo "--";
                                            }
                                            ?>
                                    </td>
                <?php } ?>
                <?php if (isset($_REQUEST['print_user_email']))
                {
                    ?>
                                    <td width="<?php
                    if (isset($k))
                    {
                        echo $k . "%";
                    } else
                    {
                        echo "10%";
                    }
                    ?>" nowrap="nowrap">
                    <?php
                    if (isset($rows[$i]->user_email) && ($rows[$i]->user_email != ""))
                    {
                        if (isset($k))
                        {
                            $symbol = $k;
                        } else
                        {
                            $symbol = 10;
                        }
                        echo wordwrap($rows[$i]->user_email, $symbol, "<br />\n", 1);
                    } else
                    {
                        echo "--";
                    }
                    ?>
                                    </td>
                    <?php } ?>
                    <?php if (isset($_REQUEST['print_user_mailing']))
                    {
                        ?>
                                    <td width="<?php
                    if (isset($k))
                    {
                        echo $k . "%";
                    } else
                    {
                        echo "10%";
                    }
                    ?>" nowrap="nowrap">
                        <?php
                        if (isset($rows[$i]->user_mailing) && ($rows[$i]->user_mailing != ""))
                        {
                            if (isset($k))
                            {
                                $symbol = $k;
                            } else
                            {
                                $symbol = 10;
                            }
                            echo wordwrap($rows[$i]->user_mailing, $symbol, "<br />\n", 1);
                        } else
                        {
                            echo "--";
                        }
                        ?>
                                    </td>
                                <?php } ?>
                <?php if (isset($_REQUEST['print_hits']))
                {
                    ?>
                                    <td width="<?php
                    if (isset($k))
                    {
                        echo $k . "%";
                    } else
                    {
                        echo "5%";
                    }
                    ?>" nowrap="nowrap">
                                    <?php
                                    if (isset($k))
                                    {
                                        $symbol = $k;
                                    } else
                                    {
                                        $symbol = 6;
                                    } echo wordwrap($rows[$i]->hits, $symbol, "<br />\n", 1);
                                    ?>
                                    </td>
                                <?php } ?>
                            </tr>
                            <?php }/* end for */ ?>

                    </table>
                            <?php
                        }//end if($kol != 0)
                        ?>

                <br/>
                <!--<?php echo $mosConfig_live_site; ?>/administrator/index.php?option=com_vehiclemanager# -->
                <!--<form name="back_print" action="javascript:parent.history.back()" method="post" target="_top">-->>
                <form name="back_print" action="index.php" method="post" target="_top">
                    <input type="submit" value="Back" title="Select other items for printing" />
                </form>

            </body>
        </html>
                            <?php
                            exit();
                        }

//end function showPrintItem()
//*********************************************************************
//********   end add for button print in Manager Vehicles   ***********
//*********************************************************************

    /**
     * Writes the edit form for new and existing records
     *
     */
    static function editVehicle($option, & $row, & $clist, & $rating, & $delete_edoc, & $reviews, & $test_list, 
            & $vehicle_type_list, & $listing_status_list, & $condition_status_list, & $transmission_type_list, 
            & $listing_type_list, & $drive_type_list, & $fuel_type_list, & $num_speed_list, & $num_cylinder_list, 
            & $num_doors_list, & $vehicle_photo, & $vehicle_photos, & $maker, & $arr, & $currentmodel, & $modellist, 
            & $vehicle_rent_sal, & $vehicle_feature, & $currency, & $languages, & $extra_list, $owner_email, $owner_id,$currency_spacial_price,$associateArray)
    {       
        
        global $vehiclemanager_configuration, $database;
        global $my, $mosConfig_live_site, $mainframe;
        global $doc, $css;
        
        if($vehiclemanager_configuration['special_price']['show']){
            $switchTranslateDayNight = _VEHICLE_MANAGER_RENT_SPECIAL_PRICE_PER_DAY;       
        }else{
            $switchTranslateDayNight = _VEHICLE_MANAGER_RENT_SPECIAL_PRICE_PER_NIGHT;    
        }   
        
        $doc->addStyleSheet($css);
        $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');

        $html = "<div class='vehicle_manager_caption' ><img src='./components/com_vehiclemanager/images/building_icon.jpg' alt ='Config' /> " . _VEHICLE_MANAGER_SHOW . "</div>";
        $app = JFactory::getApplication();
        $app->JComponentTitle = $html;
        ?>
        <script language="javascript" type="text/javascript">

            function trim(string){
                return string.replace(/(^\s+)|(\s+$)/g, "");
            }
            Joomla.submitbutton = function(pressbutton, section) {
                
        var form = document.adminForm;    
        
                if (pressbutton == 'save' || pressbutton == 'apply') {                   
                    if (trim(form.vehicleid.value) == '') { 
                        alert("<?php echo _VEHICLE_MANAGER_ADMIN_INFOTEXT_JS_EDIT_VEHICLEID_CHECK; ?>");
                        return;
                    } 
                    else if (form.catid.value == '') {
                        alert("<?php echo _VEHICLE_MANAGER_ADMIN_INFOTEXT_JS_EDIT_CATEGORY; ?>");
                        return;
                    }else if (form.vtitle.value == '') {
                        alert("<?php echo _VEHICLE_MANAGER_ADMIN_INFOTEXT_JS_EDIT_TITLE; ?>");
                        return;
                    }
                    else if (window.price_from1 !== undefined && form.price_from1.value >= form.price_to1.value) {
                        alert("<?php echo 'date `from` have to more then date `to`'; ?>");
                        return; 
                    }
                    
                    else {
                        submitform( pressbutton );
                    }
                } else {
                
                    submitform( pressbutton );
                }
            }
            var photos=0;
            function new_photos()
            {  
                div=document.getElementById("items");
                button=document.getElementById("add");
                photos++;
                newitem="<?php echo _VEHICLE_MANAGER_ADMIN_NEW_PHOTO ?>" + photos + ":";
                newitem+="<input type=\"file\" multiple='true' name=\"new_photo_file[]";
                newitem+="\" value=\"\"size=\"45\"><br>";
                newnode=document.createElement("span");
                newnode.innerHTML=newitem;
                div.appendChild(newnode);
            }

        </script>
        <form action="index.php" method="post" name="adminForm" id="adminForm" class="veh_dd_tabs add_vehicle" enctype="multipart/form-data">
            <input type="hidden" name="owner_id" value ="<?php echo $owner_id; ?> ">
        <?php
        if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            $options = array(
                'onActive' => 'function(title, description){
                    description.setStyle("display", "block");
                    title.addClass("open").removeClass("closed");
                    vm_initialize();
                    
                }',
                'onBackground' => 'function(title, description){
                    description.setStyle("display", "none");
                    title.addClass("closed").removeClass("open");
                }',
                'startOffset' => 0,  // 0 starts on the first tab, 1 starts the second, etc...
                'useCookie' => true, // this must not be a string. Don't use quotes.
            );
            echo JHtml::_('tabs.start', 'addVehicle', $options);
            
            echo JHtml::_('tabs.panel', JText::_(_VEHICLE_MANAGER_ADD_VEHICLE_TAB_LABEL_GENERAL_INFO), 'panel_1_addVehicle');
        } else
        {
            $tabs = new mosTabs(3);
            $tabs->startPane("addVehicle");
            $tabs->startTab('<a href="javascript:vm_initialize();">'._VEHICLE_MANAGER_ADD_VEHICLE_TAB_LABEL_GENERAL_INFO.'</a>', "addVehicle");
        }
        
        ?>
<div style="clear: both;"></div>
            <h2><?php echo _VEHICLE_MANAGER_ADD_VEHICLE_TAB_LABEL_REQUIRED_FIELDS; ?></h2>
            <input class="inputbox" type="hidden" name="idtrue" id="idtrue" value="<?php echo $row->id_true; ?>"  />
            <table class="adminform adminform_07">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_VEHICLEID; ?>:</td>
                    <td><input class="inputbox" type="text" name="vehicleid" id="vehicleid" size="20" maxlength="20" value="<?php echo $row->vehicleid; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_VEHICLE_TITLE; ?>:</td>
                    <td><input class="inputbox" type="text" name="vtitle" size="80" value="<?php echo $row->vtitle; ?>" /></td>
                </tr>
                <tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_CATEGORY; ?>:</td>
                    <td><?php echo $clist; ?></td>
                </tr>
<?php
/*********************************************************************************************/
    
    if(!empty($associateArray) && !empty($row->language) && $row->language != '' && $row->language != '*'){
?>
                <tr> 
                    <td width="15%"><?php echo 'language associate vehicle' ?>:</td>                        
                </tr>   
            
<?php
        $j =1;
        foreach ($associateArray as $lang=>$value) {
            $displ = '';
            if(!$value['list']){
                $displ = 'none';
            }
?>    
                <tr style="display: <?php echo $displ?>">
                    <td width="15%"><?php echo $lang; ?>:</td>
                    <td width="60%"><?php echo $value['list']; ?> 
                    <input class="inputbox" id="associate_vehicle" type="text" name="associate_vehicle<?php echo $j;?>" size="20" readonly="readonly" maxlength="20" style="width:25px; margin-bottom: -4px;" value="<?php echo $value['assocId']; ?>" />
                    <input style="display: none" name="associate_vehicle_lang<?php echo $j;?>" value="<?php echo $lang ?>"/>  
                    </td>                          
                </tr>
<?php
        
        $j++;
        }
   }else{
?>
                <tr> 
                    <td width="15%"><?php echo 'language associate vehicle' ?>:</td> 
                    <td width="60%"><?php echo 'this property only for vehicle with language' ?> 
                </tr> 
<?php
   }
/*********************************************************************************************/
?>     
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_LANGUAGE; ?>:</td>
                    <td><?php echo $languages; ?></td>
                </tr>
            </table>
            <h2><?php echo _VEHICLE_MANAGER_ADD_VEHICLE_TAB_LABEL_VEHICLE_DETAILS; ?></h2>
            <table class="adminform adminform_08">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_MAKER; ?>:</td>
                    <td><?php echo $maker; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_MODEL; ?>:</td>
                    <td><?php echo $modellist; ?></td>
                </tr>
                <script type="text/javascript">

                        <?php
                       
                        $makers = $arr[0];
                        $models = $arr[1];
                        echo 'var modelscars = [];';
                        for ($c = 0; $c < count($makers); $c++):
                            $makers[$c] = '\'' . $makers[$c] . '\'';
                            foreach ($models[$c] as $temp => $model)
                                $models[$c][$temp] = '\'' . $model . '\'';
                            echo 'var temp=new Array(' . implode(',', $models[$c]) . ",'other');\n";
                            echo 'modelscars[' . $c . "]=temp;\n";
                        endfor;
                        echo 'var makers=new Array(' . implode(',', $makers) . ');';
                        ?>

                    function changedMaker(maker){
                        var id = in_array(maker.value,makers);
                        //<select onchange="setCurentModel(this)" size="1" class="inputbox" id="maker" name="maker">
                        var model = document.getElementsByName('vmodel')[0]
                        if(model.tagName.toLowerCase()=='input'){
                            var select =  document.createElement('select');
                            select.name='vmodel';
                            select.setAttribute('onchange','changedModel(this)');
                            model.parentNode.appendChild(select);
                            model.parentNode.removeChild(model);
                        }
                        if((maker.value=='other')||(maker.value=='')){
                            setTextfield();
                            return;
                        }
                        clearSelectModel();
                        for(var c=0;c<modelscars[id].length;c++){
                            //modelscars+id[c]
                            createOptionModel(modelscars[id][c],modelscars[id][c]);
                        }
                    }
                    function clearSelectModel(){
                        var objSelect=document.getElementsByName('vmodel')[0];
                        while(objSelect.options.length > 0){objSelect.remove(0);}
                        return objSelect;
                    }
                    function in_array(what, where) {
                        for(var i=0; i<where.length; i++)
                            if(what == where[i])
                                return i;
                        return false;
                    }
                    function setTextfield(){
                        var select=document.getElementsByName('vmodel')[0];
                        var textfield = document.createElement('input');
                        select.parentNode.appendChild(textfield);
                        select.parentNode.removeChild(select);
                        textfield.name='vmodel';
                        textfield.size='35';
                        if (maker.value=='') textfield.disabled=true;

                    }
                    function createOptionModel(newValue,newText){

                        var objSelect = document.getElementsByName('vmodel')[0];
                        var objOption = document.createElement("option");
                        objOption.text = newText
                        objOption.value = newValue

                        if(document.all && !window.opera)
                        {objSelect.add(objOption);}
                        else
                        {objSelect.add(objOption, null);};

                    }
                    function changedModel(select){
                        if(select.value=='other'){
                            setTextfield();
                        }
                    }
                    function onloadPage(){
                        var maker = document.getElementsByName('maker')[0];
                        var model = document.getElementsByName('vmodel')[0];
                        if((maker.value!='other')&&(maker.value!='')){
                            changedMaker(maker);
                        }
                        setModel();
                    }
                    function setModel(){
                        var model = document.getElementsByName('vmodel')[0];
                        model.value='<?php echo $currentmodel; ?>';
                    }
                </script>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_VEHICLE_TYPE; ?>:</td>
                    <td><?php echo $vehicle_type_list; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_LISTING_TYPE; ?>:</td>
                    <td><?php echo $listing_type_list; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_PRICE; ?>:</td>
                    <td>
                        <input class="inputbox price" type="text" name="price" size="15" value="<?php echo $row->price; ?>" />&nbsp;
                        <!--<input class="inputbox" type="text" name="priceunit" size="15" value="<?php echo $row->priceunit; ?>" />-->
                <?php echo $currency; ?>
                    </td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_PRICE_TYPE; ?>:</td>
                    <td><?php echo $test_list; ?></td>
                </tr>    
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_ISSUE_YEAR; ?>:</td>
                    <td>
                        <select name="year" id="year" class="inputbox" size="1" >
        <?php
        echo "<option value=''>";
        echo _VEHICLE_MANAGER_OPTION_SELECT;
        echo "</option>";
        $num = 1900;
        for ($i = 0; $num <= date('Y'); $i++) {
            echo "<option value=\"";
            echo $num;
            echo "\"";
            if ($num == $row->year)
            {
                echo " selected= \"true\" ";
            }
            echo ">";
            echo $num;
            echo "</option>";
            $num++;
        }
        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_CONDITION_STATUS; ?>:</td>
                    <td><?php echo $condition_status_list; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_MILEAGE; ?>:</td>
                    <td><input class="inputbox" type="text" name="mileage" size="30" value="<?php echo $row->mileage; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_LISTING_STATUS; ?>:</td>
                    <td><?php echo $listing_status_list; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_COMMENT; ?>:</td>
                    <td><?php editorArea('editor1', $row->description, 'description', 500, 250, '70', '10');?></td>
                </tr>    
            </table>
             <?php
                        if ($vehiclemanager_configuration['extra1'] == 0 && $vehiclemanager_configuration['extra2'] == 0 && $vehiclemanager_configuration['extra3'] == 0 && $vehiclemanager_configuration['extra4'] == 0 && $vehiclemanager_configuration['extra5'] == 0
                                && $vehiclemanager_configuration['extra6'] == 0 && $vehiclemanager_configuration['extra7'] == 0 && $vehiclemanager_configuration['extra8'] == 0 && $vehiclemanager_configuration['extra9'] == 0 && $vehiclemanager_configuration['extra10'] == 0)
                        {
                            
                        } else
                        {
                            ?>
                <table class="adminform adminform_11">
                    <tr>
                        <td colspan="2"><h2><?php echo _VEHICLE_MANAGER_LABEL_EXTRA; ?></h2></td>
                    </tr>
                            <?php if ($vehiclemanager_configuration['extra1'] == 1)
                            {
                                ?>
                        <tr>
                            <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA1; ?>:</td>
                            <td><input class="inputbox" type="text" name="extra1" size="30" value="<?php echo $row->extra1; ?>" /></td>
                        </tr>
                <?php
            }
            if ($vehiclemanager_configuration['extra2'] == 1)
            {
                ?>
                        <tr>
                            <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA2; ?>:</td>
                            <td><input class="inputbox" type="text" name="extra2" size="30" value="<?php echo $row->extra2; ?>" /></td>
                        </tr>
                <?php
            }
            if ($vehiclemanager_configuration['extra3'] == 1)
            {
                ?>
                        <tr>
                            <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA3; ?>:</td>
                            <td><input class="inputbox" type="text" name="extra3" size="30" value="<?php echo $row->extra3; ?>" /></td>
                        </tr>
                <?php
            }
            if ($vehiclemanager_configuration['extra4'] == 1)
            {
                ?>
                        <tr>
                            <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA4; ?>:</td>
                            <td><input class="inputbox" type="text" name="extra4" size="30" value="<?php echo $row->extra4; ?>" /></td>
                        </tr>
                <?php
            }
            if ($vehiclemanager_configuration['extra5'] == 1)
            {
                ?>
                        <tr>
                            <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA5; ?>:</td>
                            <td><input class="inputbox" type="text" name="extra5" size="30" value="<?php echo $row->extra5; ?>" /></td>
                        </tr>
                <?php
            }
            if ($vehiclemanager_configuration['extra6'] == 1)
            {
                ?>
                        <tr>
                            <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA6; ?>:</td>
                            <td><?php echo $extra_list[0]; ?></td>
                        </tr>
                <?php
            }
            if ($vehiclemanager_configuration['extra7'] == 1)
            {
                ?>
                        <tr>
                            <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA7; ?>:</td>
                            <td><?php echo $extra_list[1]; ?></td>
                        </tr>
                    <?php
                }
                if ($vehiclemanager_configuration['extra8'] == 1)
                {
                    ?>
                        <tr>
                            <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA8; ?>:</td>
                            <td><?php echo $extra_list[2]; ?></td>
                        </tr>
                    <?php
                }
                if ($vehiclemanager_configuration['extra9'] == 1)
                {
                    ?>
                        <tr>
                            <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA9; ?>:</td>
                            <td><?php echo $extra_list[3]; ?></td>
                        </tr>
                <?php
            }
            if ($vehiclemanager_configuration['extra10'] == 1)
            {
                ?>
                        <tr>
                            <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_EXTRA10; ?>:</td>
                            <td><?php echo $extra_list[4]; ?></td>
                        </tr>
            <?php } ?>
                </table>
                        <?php } ?>
            <h2><?php echo _VEHICLE_MANAGER_LABEL_FEATURED_MANAGER_FEATURE_MANAGER; ?></h2>
            <table class="adminform adminform_09">    
                <tr>
                    <td colspan="2" id="checkboxes_veh">
                <?php
                
               for($i = 0; $i < count($vehicle_feature); $i++)
                {
                    
                    if ($i== 0 || $vehicle_feature[$i]->categories !== $vehicle_feature[$i - 1]->categories )
                        echo "<strong>" . $vehicle_feature[$i]->categories . "</strong>";
                    
                    if($vehicle_feature[$i]->name): ?>
                        <div class="checkbox_vm">
                            <input type="checkbox" class="checkbox_veh" id="checkbox_addveh<?php echo $i; ?>" <?php if ($vehicle_feature[$i]->check) echo "checked"; ?> name="feature[]" value="<?php echo $vehicle_feature[$i]->id; ?>">
                            <label for="checkbox_addveh<?php echo $i; ?>"><?php echo $vehicle_feature[$i]->name; ?></label>
                        </div>
                        <?php endif; ?>
                    <?php if ($vehicle_feature[$i]->image_link != ''){ ?>       
                        <img alt="photo" src="<?php echo "$mosConfig_live_site/components/com_vehiclemanager/featured_ico/" . $vehicle_feature[$i]->image_link; ?>"></img>      
                    <?php } ?>
                <?php } ?>
       
                    </td>
                </tr>               
        <?php
        $month = date("m", mktime(0, 0, 0, date('m'), 1, date('Y')));
        $year = date("Y", mktime(0, 0, 0, date('m'), 1, date('Y')));
        $placeholder = $vehiclemanager_configuration['calendar']['placeholder'];
        
        JHtml::_('behavior.calendar'); ?>
        
        
                <script language="javascript" type="text/javascript">

                                                                                                
                  window.addEvent('domready', function() {
                           
                        $('subPrice').addEvent('click', function(event) {
                            var rent_from = $('price_from').get('value');
                            var rent_to = $('price_to').get('value');
                            var special_price = $('special_price').get('value');
                            var comment_price = $('comment_price').get('value');
                            var currency_spacial_price = $('currency_spacial_price').get('value');                            
                            var req = new Request.HTML({
                            method: 'post',
                            url: "index.php?option=com_vehiclemanager&task=ajax_rent_price&vid=<?php 
                                    echo $row->id;?>&rent_from="+rent_from+"&rent_until="+rent_to+
                                    "&special_price="+special_price+"&comment_price="+comment_price+
                                    "&currency_spacial_price="+currency_spacial_price,
                            data: { 'do' : '1' },
                            update: $('SpecialPriseBlock'),
                            onComplete: function(response) { 
                            }
                            }).send();
                        });
                   });
                    
                       
                </script> 
            </table>
            
            <h2><?php echo $switchTranslateDayNight;  ?></h2>
                    <p>
                    <div id ='SpecialPriseBlock'>
                        <table class="adminlist adminlist_04">
                            <tr>
                                <th class="title" width ="35%"><?php echo _VEHICLE_MANAGER_LABEL_CALENDAR_SELECT_DELETE; ?></th>
                                <th class="title" ><?php echo _VEHICLE_MANAGER_FROM; ?></th>
                                <th class="title" ><?php echo _VEHICLE_MANAGER_TO; ?></th>
                                <th class="title" ><?php echo $switchTranslateDayNight; ?></th>
                                <th class="title" ><?php echo _VEHICLE_MANAGER_LABEL_REVIEW_COMMENT; ?></th>
                            </tr>
                                                <?php
                                                
                    for ($i = 0; $i < count($vehicle_rent_sal); $i++) {
                        
                        ?>
                                    <tr>
                                        <td align ='center'><input type="checkbox" name="del_rent_sal[]" value="<?php echo $vehicle_rent_sal[$i]->id; ?>" /></td>
                                        <td align ='center'><?php echo $vehicle_rent_sal[$i]->price_from; ?></td>
                                        <td align ='center'><?php echo $vehicle_rent_sal[$i]->price_to; ?></td>
                                        <td align ='center'><?php echo $vehicle_rent_sal[$i]->special_price. ' '.$vehicle_rent_sal[$i]->priceunit; ?></td>
                                        <td><?php echo $vehicle_rent_sal[$i]->comment_price; ?></td>                                        
                                    </tr>
                    <?php } ?>  
                        </table>
                        <p>
                        <div id ="message-here" style ='color: red; font-size: 18px;' ></div>
                        <p>                      
                    </div>
                  
                    <span class="col_02">
                    <p>
                        <?php echo _VEHICLE_MANAGER_LABEL_RENT_REQUEST_FROM; ?>:<br />
                        <?php echo JHtml::_('calendar', date("Y-m-d"), 'price_from', 'price_from', $vehiclemanager_configuration['date_format']); ?>
                    </p>
                    <p>
                        
                      <?php echo _VEHICLE_MANAGER_LABEL_RENT_REQUEST_UNTIL; ?>:<br />
                      <?php //echo JHtml::_('calendar', date("Y-m-d"), 'rent_until', 'rent_until', $vehiclemanager_configuration['date_format'],'onchange="vm_rent_request_cout_day(this.value);"'); ?>
                      <?php echo JHtml::_('calendar', date("Y-m-d"), 'price_to', 'price_to', $vehiclemanager_configuration['date_format']); ?> 
                        
                    </p>
                    <p><?php echo _VEHICLE_MANAGER_LABEL_PRICE; ?><br/>
                    <input id="special_price" class="inputbox price" type="text" name="special_price" size="15" value="" />
                    <?php echo $currency_spacial_price; ?>
                    </p>
                    <p><?php echo _VEHICLE_MANAGER_LABEL_REVIEW_COMMENT;?>
                    <br /><textarea id="comment_price" rows="5" cols="25" name="comment_price"></textarea></p><br />
                    <p>
                    <input id="subPrice" class="inputbox" type="button" name="new_price" value="<?php echo _VEHICLE_MANAGER_RENT_ADD_SPECIAL_PRICE; ?>"/>
                    </p>
                    </span>
       
                       
        <?php
        if ($reviews > false) /* show, if review exist */
        {
            ?>
                <h2><?php echo _VEHICLE_MANAGER_LABEL_REVIEWS; ?>:</h2> 
                <table class="adminlist adminlist_08">
                    <tr class="row0">
                        <td width="3%" valign="top" align="center"><div>#</div></td>
                        <td width="2%" valign="top" align="center"><div></div></td>
                        <td width="10%" valign="top" align="center"><?php echo _VEHICLE_MANAGER_LABEL_REVIEW_TITLE; ?>:</td>
                        <td width="10%" valign="top" align="center"><?php echo _VEHICLE_MANAGER_LABEL_RENT_USER; ?>:</td>
                        <td width="65%" valign="top" align="center"><?php echo _VEHICLE_MANAGER_LABEL_REVIEW_COMMENT; ?>:</td>
                        <td width="5%" valign="top" align="center"><?php echo _VEHICLE_MANAGER_REVIEW_DATE; ?>:</td>
                        <td width="5%" valign="top" align="center"><?php echo _VEHICLE_MANAGER_LABEL_REVIEW_RATING; ?>:</td>
                    </tr>
            <?php for ($i = 0, $nn = 1; $i < count($reviews); $i++, $nn++) /* if not one comment */ {
                ?>
                        <tr class="row0">
                            <td valign="top" align="center"><div><?php echo $nn; ?></div></td>
                            <td valign="top" align="center"><div><?php echo "<input type='radio' id='cb" . $i . "' name='vid[]' value='" . $row->id . "," . $reviews[$i]->id . "' onClick='Joomla.isChecked(this.checked);' />"; ?></div></td>
                            <td valign="top" align="center"><div><?php print_r($reviews[$i]->title); ?></div></td>
                            <td valign="top" align="left"><div><?php print_r($reviews[$i]->user_name); ?></div></td>
                            <td valign="top" align="left"><div><?php print_r(strip_tags($reviews[$i]->comment)); ?></div></td>
                            <td valign="top" align="left"><div><?php print_r($reviews[$i]->date); ?></div></td>
                            <td valign="top" align="left"><div><img src="../components/com_vehiclemanager/images/rating-<?php echo $reviews[$i]->rating; ?>.png" alt="<?php echo ($reviews[$i]->rating) / 2; ?>" border="0" align="right"/>&nbsp;</div></td>
                        </tr>
                            <?php }/* end for(...) */ ?>

                </table>
        <?php }/* end if(...) */ ?>

        <?php
        if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            echo JHtml::_('tabs.panel', JText::_(_VEHICLE_MANAGER_ADD_VEHICLE_TAB_LABEL_SPECIFICATIONS), 'panel_2_addVehicle');
        } else
        {
            $tabs->endTab();
            $tabs->startTab('<a href="javascript:vm_initialize();">'._VEHICLE_MANAGER_ADD_VEHICLE_TAB_LABEL_SPECIFICATIONS.'</a>', "addVehicle");
        }
        ?>
<div style="clear: both;"></div>
            <table class="adminform adminform_12">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_ENGINE_TYPE; ?>:</td>
                    <td><input class="inputbox" type="text" name="engine" size="80" value="<?php echo $row->engine; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_TRANSMISSION_TYPE; ?>:</td>
                    <td><?php echo $transmission_type_list; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_DRIVE_TYPE; ?>:</td>
                    <td><?php echo $drive_type_list; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_NUMBER_CYLINDERS; ?>:</td>
                    <td><?php echo $num_cylinder_list; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_NUMBER_SPEEDS; ?>:</td>
                    <td><?php echo $num_speed_list; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_FUEL_TYPE; ?>:</td>
                    <td><?php echo $fuel_type_list; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_CITY_FUEL_MPG; ?>:</td>
                    <td><input class="inputbox" type="text" name="city_fuel_mpg" size="30" value="<?php echo $row->city_fuel_mpg; ?>" />                </td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_HIGHWAY_FUEL_MPG; ?>:</td>
                    <td><input class="inputbox" type="text" name="highway_fuel_mpg" size="30" value="<?php echo $row->highway_fuel_mpg; ?>" />                
                    </td>
                </tr>        
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_WHEELBASE; ?>:</td>
                    <td><input class="inputbox" type="text" name="wheelbase" size="20" value="<?php echo $row->wheelbase; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_WHEELTYPE; ?>:</td>
                    <td><input class="inputbox" type="text" name="wheeltype" size="80" value="<?php echo $row->wheeltype; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_REARAXE_TYPE; ?>:</td>
                    <td><input class="inputbox" type="text" name="rear_axe_type" size="80" value="<?php echo $row->rear_axe_type; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_BRAKES_TYPE; ?>:</td>
                    <td><input class="inputbox" type="text" name="brakes_type" size="80" value="<?php echo $row->brakes_type; ?>" /></td>
                </tr>
            </table>
            <table class="adminform adminform_13">
                <tr>
                    <td colspan="2"><h2><?php echo _VEHICLE_MANAGER_HEADER_EXTERIOR_OPTIONS ?></h2></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_EXTERIOR_COLORS; ?>:</td>
                    <td><input class="inputbox" type="text" name="exterior_color" size="30" value="<?php echo $row->exterior_color; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_NUMBER_DOORS; ?>:</td>
                    <td><?php echo $num_doors_list; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_EXTERIOR_EXTRAS; ?>:</td>
                    <td><textarea name="exterior_amenities" cols="50" rows="8" ><?php echo $row->exterior_amenities; ?></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><h2><?php echo _VEHICLE_MANAGER_HEADER_INTERIOR_OPTIONS ?></h2></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_INTERIOR_COLORS; ?>:</td>
                    <td><input class="inputbox" type="text" name="interior_color" size="30" value="<?php echo $row->interior_color; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_NUMBER_SEATINGS; ?>:</td>
                    <td><input class="inputbox" type="text" name="seating" size="30" value="<?php echo $row->seating; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_DASHBOARD_OPTIONS; ?>:</td>
                    <td>
                        <textarea name="dashboard_options" cols="50" rows="8"><?php echo $row->dashboard_options; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_INTERIOR_EXTRAS; ?>:</td>
                    <td><textarea name="interior_amenities" cols="50" rows="8" ><?php echo $row->interior_amenities; ?></textarea></td>
                </tr>       
            </table>
        <?php
        if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            echo JHtml::_('tabs.panel', JText::_(_VEHICLE_MANAGER_ADD_VEHICLE_TAB_LABEL_PHOTOS_AND_DOCUMENETS), 'panel_3_addVehicle');
        } else
        {
            $tabs->endTab();
            $tabs->startTab('<a href="javascript:vm_initialize();">'._VEHICLE_MANAGER_ADD_VEHICLE_TAB_LABEL_PHOTOS_AND_DOCUMENETS."</a>", "addVehicle");
        }
        ?>   
<div style="clear: both;"></div>
            <h2><?php echo _VEHICLE_MANAGER_HEADER_PHOTO_MANAGE; ?></h2>
            <table class="adminform adminform_14">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_PICTURE_URL_UPLOAD; ?>:</td>
                    <td><input class="inputbox" type="file" name="image_link" value="<?php echo $row->image_link; ?>" size="50" maxlength="250" /></td>
                </tr>
                <tr>
            <?php
            if ($row->image_link != '' and !$row->id_true)
                echo '<td valign="bottom" align="right">Select photo if it is necessary to remove:</td>';
            else
                echo '<td>&nbsp</td>';
            ?>

                    <td>
                        <?php
                        if ($row->image_link != '')
                        {
                            $main_phot = pathinfo($row->image_link);
                            $main_photo_type = '.' . $main_phot['extension'];
                            $main_photo_name = basename($row->image_link, $main_photo_type);
                        } else
                        {
                            echo 'The main image is absent';
                            $main_photo_name = '';
                            $main_photo_type = '';
                        }
                        if ($vehicle_photo != '')
                        {
                            if(!$row->id_true)
                                echo '<input type="checkbox" name="del_main_photo" value="' . $vehicle_photo[0] . '" />';
                            ?>
                            <img alt="photo" src="<?php echo $mosConfig_live_site; ?>/components/com_vehiclemanager/photos/<?php echo $vehicle_photo[1]; ?>"/>
        <?php } ?>
                    </td>
                </tr>

        <?php  
        if (count($vehicle_photos) != 0)
        {
            ?>
                    <tr>
                        <td width="185">Select photos which are necessary to remove from photo gallery:</td>
                        <td>
            <?php
            for ($i = 0; $i < count($vehicle_photos); $i++) {
                if (($i % 7) == 0)
                {
                    echo "<br>";
                }
                ?>
                                <input type="checkbox" name="del_photos[]" value="<?php echo $vehicle_photos[$i][0]; ?>" />
                                <img src="<?php echo $mosConfig_live_site; ?>/components/com_vehiclemanager/photos/<?php echo $vehicle_photos[$i][1]; ?>" alt="no such file"/> &nbsp
            <?php } ?>
                        </td>
                    </tr>
        <?php } ?>
                <tr>
                    <td width="185"> <?php echo _VEHICLE_MANAGER_LABEL_OTHER_PICTURES_URL_UPLOAD; ?>:</td>
                    <td>
                        <div ID="items">
                            <input class="inputbox" type="button" name="new_photo" value="<?php echo 'Add new photo'; ?>" onClick="javascript:new_photos()" ID="add"/>
                        </div>
                    </td>
                </tr>
            </table>
            <h2><?php echo _VEHICLE_MANAGER_ADD_VEHICLE_TAB_LABEL_ATTACHMENT_DOCUMENTS; ?></h2>
            <table class="adminform adminform_15">
        <?php if ($vehiclemanager_configuration['edocs']['allow'])
        {
            ?>
                    <tr>
                        <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_EDOCUMENT_UPLOAD; ?>:</td>
                        <td><input class="inputbox" type="file" name="edoc_file" value="" size="50" maxlength="250" onClick="document.adminForm.edok_link.value ='';"/>    <!-- //+ --></td>
                    </tr>
                    <tr>
                        <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_EDOCUMENT_UPLOAD_URL; ?>:</td>
                        <td><input class="inputbox" type="text" name="edocument_Link" value="<?php echo $row->edok_link; ?>" size="50" maxlength="250"/></td>
                    </tr>
            <?php
        }
        if (strlen($row->edok_link) > 0 and !$row->id_true)
        {
            ?>
                    <tr>
                        <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_EDOCUMENT_DELETE; ?>:</td>
                        <td><?php echo $delete_edoc; ?></td>
                    </tr>
        <?php } ?>
            </table>
        <?php
        if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            echo JHtml::_('tabs.panel', JText::_(_VEHICLE_MANAGER_ADD_VEHICLE_TAB_LABEL_ADDITIONAL_INFO), 'panel_4_addVehdicle');
        } else
        {
            $tabs->endTab();
            $tabs->startTab('<a href="javascript:vm_initialize();">'._VEHICLE_MANAGER_ADD_VEHICLE_TAB_LABEL_ADDITIONAL_INFO."</a>", "addVehdicle");
        }
        ?>
<div style="clear: both;"></div>
            <table class="adminform adminform_16">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_SAFETY_OPTIONS; ?>:
                    <td><textarea name="safety_options" cols="50" rows="8"><?php echo $row->safety_options; ?></textarea></td>
                </tr>        
            </table>
            <h2><?php echo _VEHICLE_MANAGER_LABEL_WARRANTY_OPTIONS; ?></h2>
            <table class="adminform adminform_17">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_WARRANTY_BASIC; ?>:</td>
                    <td><input class="inputbox" type="text" name="w_basic" size="30" value="<?php echo $row->w_basic; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_WARRANTY_DRIVETRAIN; ?>:</td>
                    <td><input class="inputbox" type="text" name="w_drivetrain" size="30" value="<?php echo $row->w_drivetrain; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_WARRANTY_CORROSION; ?>:</td>
                    <td><input class="inputbox" type="text" name="w_corrosion" size="30" value="<?php echo $row->w_corrosion; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_WARRANTY_ROADSIDE_ASSISTANCE; ?>:</td>
                    <td><input class="inputbox" type="text" name="w_roadside_ass" size="30" value="<?php echo $row->w_roadside_ass; ?>" /></td>
                </tr>
            </table>
            <h2><?php echo _VEHICLE_MANAGER_HEADER_ADVERTISMENT; ?></h2>
            <table class="adminform adminform_18">       
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_FEATURED_CLICKS; ?>:</td>
                    <td><input class="inputbox" type="text" name="featured_clicks" size="30" value="<?php echo $row->featured_clicks; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_FEATURED_SHOWS; ?>:</td>
                    <td><input class="inputbox" type="text" name="featured_shows" size="30" value="<?php echo $row->featured_shows; ?>" /></td>
                </tr>
            </table>
        <?php
        if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            echo JHtml::_('tabs.panel', JText::_(_VEHICLE_MANAGER_ADD_VEHICLE_TAB_LABEL_SELLER_CONTACTS), 'panel_4_addVehdicle');
        } else
        {
            $tabs->endTab();
            $tabs->startTab('<a href="javascript:vm_initialize();">'._VEHICLE_MANAGER_ADD_VEHICLE_TAB_LABEL_SELLER_CONTACTS.'</a>', "addVehdicle");
            
        }
        ?>
<div style="clear: both;"></div>
            <table class="adminform adminform_19">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_CONTACTS; ?>:</td>
                    <td><input class="inputbox" type="text" name="contacts" size="30" value="<?php echo $row->contacts; ?>" /></td>
                </tr>
            </table>
                 <table class="adminform adminform_20">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_OWNER; ?>:</td>
                    <td>
                <?php if (trim($row->owneremail) != ""): ?>
                    <?php echo $row->getOwnerUsername(), '(', $owner_email, ')'; ?>
                <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo _VEHICLE_MANAGER_LABEL_OWNER_CUSTOM_EMAIL; ?>:</td>
                    <td>
                        <?php if (trim($row->owneremail) != ""): ?>
                                    <input type='text' name='owneremail' value="<?php echo $owner_email; ?>"/>
                        <?php else: ?>
                                    <input type='text' name='owneremail' value="<?php echo $my->email; ?>"/>
                        <?php endif; ?>
                    </td>
                </tr> 
            </table>
            <h2><?php echo _VEHICLE_MANAGER_HEADER_ADDRESS_FIELDS; ?></h2>
            <table class="adminform adminform_21">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_ADDRESS; ?>:</td>
                    <td><input class="inputbox" type="text" id="vlocation" name="vlocation" size="80" value="<?php echo $row->vlocation; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_COUNTRY; ?>:</td>
                    <td><input class="inputbox" type="text" id="country" name="country" size="80" value="<?php echo $row->country; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_REGION; ?>:</td>
                    <td><input class="inputbox" type="text" id="region" name="region" size="80" value="<?php echo $row->region; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_CITY; ?>:</td>
                    <td><input class="inputbox" type="text" id="city" name="city" size="80" value="<?php echo $row->city; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_DISTRICT; ?>:</td>
                    <td><input class="inputbox" type="text" name="district" size="80" value="<?php echo $row->district; ?>" /></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_ZIPCODE; ?>:</td>
                    <td><input class="inputbox" type="text" id="zipcode" name="zipcode" size="80" value="<?php echo $row->zipcode; ?>" /></td>
                </tr>       
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_GEOCOOR; ?></td>
                    <td> <input type="button" value="<?php echo _VEHICLE_MANAGER_BUTTON_SHOW_ADDRESS; ?>" onclick="codeAddress()"></td>
                </tr>       
                <tr>
                    <td  width="185"><?php echo _VEHICLE_MANAGER_LABEL_CLICKMAP; ?></td>
                    <td>
                        <div id="map_canvas" class="vm_map_canvas_admin"></div>
                        <!--Image google map--> 
                        <script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
                        <script type="text/javascript">
                            var map;
                            var lastmarker = null;
                            var marker = null;
                            var mapOptions;
                                
                            setTimeout(function() {
                                vm_initialize();
                            },20);
                            function vm_initialize(){
                                var myOptions = {
                                    zoom: <?php if($row->map_zoom) echo $row->map_zoom;
                                             else echo 1;?>,
                                    center: new google.maps.LatLng(<?php if ($row->vlatitude) echo $row->vlatitude; else echo 0; ?>,<?php if ($row->vlongitude) echo $row->vlongitude; else echo 0; ?>),
                                    scrollwheel: false,
                                    zoomControlOptions: {
                                        style: google.maps.ZoomControlStyle.LARGE
                                    },
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                };
                                var geocoder = new google.maps.Geocoder();
                                var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                                var bounds = new google.maps.LatLngBounds ();

                            <?php if ($row->vlatitude && $row->vlongitude)
                            {
                            ?>
                                    //Set the marker coordinates
                                    var lastmarker = new google.maps.Marker({
                                        position: new google.maps.LatLng(<?php echo $row->vlatitude; ?>, <?php echo $row->vlongitude; ?>)
                                    });
                                    lastmarker.setMap(map);
                            <?php } ?>   
                                //If the zoom, then store it in the field map_zoom
                                google.maps.event.addListener(map,"zoom_changed", function(){
                                    document.getElementById("map_zoom").value=map.getZoom();
                                });
                                google.maps.event.addListener(map,"click", function(e){
                                                                       
                                    //Initialize marker
                                                    marker = new google.maps.Marker({
                                                        position: new google.maps.LatLng(e.latLng.lat(),e.latLng.lng())
                                                    });
                                    
                                    //Delete marker
                                    if(lastmarker) lastmarker.setMap(null);;
                                    //Add marker to the map
                                    marker.setMap(map);
                                    //Output marker information
                                    document.getElementById("vlatitude").value=e.latLng.lat();
                                    document.getElementById("vlongitude").value=e.latLng.lng();
                                    //Memory marker to delete
                                    lastmarker = marker;
                                });                                        
                            } 
                         
                            function updateCoordinates(latlng)
                            {
                                if(latlng) 
                                {
                                    document.getElementById('vlatitude').value = latlng.lat();
                                    document.getElementById('vlongitude').value = latlng.lng();
                                    document.getElementById("map_zoom").value=map.getZoom();
                                }
                            }

                            function toggleBounce() {

                                if (marker.getAnimation() != null) {
                                    marker.setAnimation(null);
                                } else {
                                    marker.setAnimation(google.maps.Animation.BOUNCE);
                                }
                            }

                            function codeAddress() {
                                var geocoder = new google.maps.Geocoder();
                                
                                myOptions = {
                                    zoom:14,
                                    scrollwheel: false,
                                    zoomControlOptions: {
                                        style: google.maps.ZoomControlStyle.LARGE
                                    },
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                }
                                map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                                var address = document.getElementById('vlocation').value + " " + document.getElementById('country').value+ " " + document.getElementById('region').value+ " " + document.getElementById('city').value+ " " + document.getElementById('zipcode').value + " " + document.getElementById('vlatitude').value + " " + document.getElementById('vlongitude').value;
                                geocoder.geocode( { 'address': address}, function(results, status) {
                                    if (status == google.maps.GeocoderStatus.OK) {
                                        map.setCenter(results[0].geometry.location);
                                        updateCoordinates(results[0].geometry.location);
                                       
                                        if (marker) marker.setMap(null);
                                        marker = new google.maps.Marker({
                                            map: map,
                                            position: results[0].geometry.location,
                                            draggable: true,
                                            animation: google.maps.Animation.DROP
                                        });
                                        google.maps.event.addListener(marker, 'click', toggleBounce);
                                        google.maps.event.addListener(marker, "dragend", function() {
                                            updateCoordinates(marker.getPosition());
                                        });
                                    } else {
                                        alert("Please check the accuracy of Address");
                                    }
                                });
                            }    
                            
                        </script> 
                    </td>
                </tr>
                <tr>      
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_LATITUDE; ?>:</td>
                    <td><input class="inputbox" type="text" id="vlatitude" name="vlatitude" size="20" value="<?php echo $row->vlatitude; ?>" readonly/></td>
                </tr>
                <tr>      
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_LONGITUDE; ?>:</td>
                    <td>
                        <input class="inputbox" type="text" id="vlongitude" name="vlongitude" size="20" value="<?php echo $row->vlongitude; ?>" readonly/>
                        <input type="hidden" id="map_zoom" name="map_zoom" value="<?php echo $row->map_zoom; ?>" />
                    </td>
                </tr>
            </table>
        <?php
        if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            echo JHtml::_('tabs.end');
        } else
        {
            $tabs->endTab();
            $tabs->endPane();
        }
        ?>

            <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
            <input type="hidden" name="option" value="<?php echo $option; ?>" />
            <input type="hidden" name="boxchecked" value="0" />
            <input type="hidden" name="task" value="" />
        </form>
        
        <!--************************   end change review ***********************-->

            <?php
        }

                   static function showRentVehicles($option, $main_veh, $rows, & $userlist, $type)
    {

      global $my, $mosConfig_live_site, $mainframe;
      // for 1.6
      global $doc, $css;
      $doc->addStyleSheet($css);
      $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');

      $html = "<div class='vehicle_manager_caption' ><img src='./components/com_vehiclemanager/images/building_icon.jpg' alt ='Config' /> " . _VEHICLE_MANAGER_ADMIN_REQUEST_RENT . "</div>";
      $app = JFactory::getApplication();
      $app->JComponentTitle = $html;

      ?>
        <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
        <form action="index.php" method="post" name="adminForm"  id="adminForm">
            <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform  adminform_24">
                <tr>
                    <td width="100%" class="vehicle_manager_caption"  >
            <?php
            if ($type == "rent")
            {
                echo _VEHICLE_MANAGER_SHOW_RENT_VEHICLES;
            } else
            if ($type == "rent_return")
            {
                echo _VEHICLE_MANAGER_SHOW_RENT_RETURN;
            }if ($type == "edit_rent")
            {
                echo _VEHICLE_MANAGER_SHOW_RENT_EDIT;
            } else
            {

                echo "&nbsp;";
            }
            ?>
                    </td>
                </tr>
            </table>
                <?php
                if ($type == "rent" or $type == "edit_rent")
                {
                    ?>
                <table cellpadding="4" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td align="center" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_TO . ':'; ?></td>
                        <td align="center" nowrap="nowrap"><?php echo $userlist; ?></td>
                        <td align="center" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_USER . ':'; ?></td>
                        <td><input type="text" name="user_name" class="inputbox" /></td>
                        <td width="1000%">
                        </td>
                    </tr>
                    <tr>
                        <td nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_EMAIL . ':'; ?></td>
                        <td>    <input type="text" name="user_email" class="inputbox" /></td>
                    </tr>
                    <tr>
                        <td nowrap="nowrap"><?php echo "Rent from:"; ?></td>
                        <td nowrap="nowrap">
                    <?php
                    // for 1.6
                    echo JHtml::_('calendar', date("Y-m-d"), 'rent_from', 'rent_from', '%Y-%m-%d');
                    ?>
                        </td>
                        <td nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_TIME . ':'; ?></td>
                        <td nowrap="nowrap">
                    <?php
                    // for 1.6
                    echo JHtml::_('calendar', date("Y-m-d"), 'rent_until', 'rent_until', '%Y-%m-%d');
                    ?>
                        </td>
                    </tr>
                </table>

                    <?php
                } else
                {
                    ?>
                &nbsp;
                    <?php
                }

                $all = JFactory::getDBO();
                $query = "SELECT * FROM #__vehiclemanager_rent";
                $all->setQuery($query);
                $num = $all->loadObjectList();
                ?>
            <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist adminlist_09">
                <tr>
                    <th width="20" align="center">
                    <?php if ($type != 'rent')
                    {
                        ?> <input type="checkbox" name="toggle" onClick="vm_checkAll(this<?php //echo count( $num );  ?>);" />
                    <?php 
                    } ?> </th>
                    <th align = "center" width="30">#</th>
                    <th align = "center" class="title" width="5%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_VEHICLEID; ?></th>
                    <th align = "center" class="title" width="25%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_TITLE; ?></th>
                    <th align = "center" class="title" width="15%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_FROM; ?></th>
                    <th align = "center" class="title" width="20%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_UNTIL; ?></th>
                    <th align = "center" class="title" width="15%" nowrap="nowrap"><?php echo "Rent return"; ?></th>
                    <th align = "center" class="title" width="20%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_TO; ?></th>
                </tr>
                  <?php 
                if ($type == "rent")
                {
                    ?>
                        <td align="center">  <input class="inputbox"  type="checkbox"  name="checkVehicle" id="checkVehicle" size="0" maxlength="0" value="on" /></td>
            <?php     
                } else if ($type == "edit_rent"){ ?>
                  <input type="hidden"  name="checkVehicle" id="checkVehicle" value="on" /></td>
                
              <?php
                } 
                $assoc_title = ''; 
                for ($t = 0, $z = count($rows); $t < $z; $t++) {
                  if($rows[$t]->id != $main_veh->id) $assoc_title .= " ".$rows[$t]->vtitle; 
                }

                print_r("
                  <td align=\"center\">". $main_veh->id ."</td>
                  <td align=\"center\">" . $main_veh->vehicleid . "</td>
                  <td align=\"center\">" . $main_veh->vtitle . " ( " . $assoc_title ." ) " . "</td>
                  <td align=\"center\">" . " " . "</td>
                  <td align=\"center\">" . " " . "</td>
                  <td align=\"center\">" . " " . "</td>
                  <td align=\"center\">" . " " . "</td> </tr>");

                print_r("
                  <td align=\"center\">--</td>
                  <td align=\"center\">--</td>
                  <td align=\"center\">" . "----" . "</td>
                  <td align=\"center\">" . "-----------------" . "</td>
                  <td align=\"center\">" . " -------------" . "</td>
                  <td align=\"center\">" . " ---------" . "</td>
                  <td align=\"center\">" . " ---------------------" . "</td>
                  <td align=\"center\">" . "------------------" . "</td> </tr>");
              

                for ($j = 0, $n = count($rows); $j < $n; $j++) {
                    $row = $rows[$j];
                    ?>
                            &nbsp;
                        
                        <input class="inputbox" type="hidden"  name="id" id="id" size="0" maxlength="0" value="<?php echo $main_veh->id; ?>" />
                        <input class="inputbox" type="hidden"  name="vtitle" id="vtitle" size="0" maxlength="0" value="<?php echo $row->vtitle; ?>" />
                <?php
                $vehicle_id = $row->id;
                $data = JFactory::getDBO();

                $query = "SELECT * FROM #__vehiclemanager_rent WHERE fk_vehicleid =" . $vehicle_id . " ORDER BY rent_return "; // AND id =50"   

                $data->setQuery($query);
                $allrent = $data->loadObjectList();
                ?>
               <?php
            $num = 1;
            for ($i = 0, $n2 = count($allrent); $i < $n2; $i++) {
                if (!isset($allrent[$i]->rent_return) && $type != "rent")
                {
                ?>
                    <td align="center"><input type="checkbox"  id="cb<?php echo $i; ?>" name="vid[]" value="<?php echo $allrent[$i]->id; ?>" onClick="isChecked(this.checked);" /></td>
                <?php 
                } else
                { 
                    ?>
                    <td align="center">
                    </td>
        <?php 
                } ?>
                <?php
                print_r("
                  <td align=\"center\">" . $num . "</td>
                  <td align=\"center\">" . $row->vehicleid . "</td>
                  <td align=\"center\">" . $row->vtitle . "</td>
                  <td align=\"center\">" . $allrent[$i]->rent_from . "</td>
                  <td align=\"center\">" . $allrent[$i]->rent_until . "</td>    
                  <td align=\"center\">" . $allrent[$i]->rent_return . "</td>   
                  <td align=\"center\">" . $allrent[$i]->user_name . ":  " . $allrent[$i]->user_email . "</td> </tr>");
                $num++;
            }
            ?>
        <?php } ?>
            </table>
            <input type="hidden" name="option" value="<?php echo $option; ?>" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="1" />
            <input type="hidden" name="save" value="1" />
        </form>
        <?php
    }



 static function editRentVehicles($option, $main_veh, $rows, $title_assoc, & $userlist, & $all_assosiate_rent, $type)
    {

      global $my, $mosConfig_live_site, $mainframe;
      // for 1.6
      global $doc, $css;
      $doc->addStyleSheet($css);
      $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');

      $html = "<div class='vehicle_manager_caption' ><img src='./components/com_vehiclemanager/images/building_icon.jpg' alt ='Config' /> " . _VEHICLE_MANAGER_ADMIN_REQUEST_RENT . "</div>";
      $app = JFactory::getApplication();
      $app->JComponentTitle = $html;

      ?>
        <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
        <form action="index.php" method="post" name="adminForm"  id="adminForm">
            <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminform  adminform_24">
                <tr>
                    <td width="100%" class="vehicle_manager_caption"  >
            <?php
            if ($type == "rent")
            {
                echo _VEHICLE_MANAGER_SHOW_RENT_VEHICLES;
            } else
            if ($type == "rent_return")
            {
                echo _VEHICLE_MANAGER_SHOW_RENT_RETURN;
            }if ($type == "edit_rent")
            {
                echo _VEHICLE_MANAGER_SHOW_RENT_EDIT;
            } else
            {

                echo "&nbsp;";
            }
            ?>
                    </td>
                </tr>
            </table>
                <?php
                if ( $type == "edit_rent")
                {
                    ?>
                <table cellpadding="4" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td align="center" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_TO . ':'; ?></td>
                        <td align="center" nowrap="nowrap"><?php echo $userlist; ?></td>
                        <td align="center" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_USER . ':'; ?></td>
                        <td><input type="text" name="user_name" class="inputbox" /></td>
                        <td width="1000%">
                        </td>
                    </tr>
                    <tr>
                        <td nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_EMAIL . ':'; ?></td>
                        <td>    <input type="text" name="user_email" class="inputbox" /></td>
                    </tr>
                    <tr>
                        <td nowrap="nowrap"><?php echo "Rent from:"; ?></td>
                        <td nowrap="nowrap">
                    <?php
                    // for 1.6
                    echo JHtml::_('calendar', date("Y-m-d"), 'rent_from', 'rent_from', '%Y-%m-%d');
                    ?>
                        </td>
                        <td nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_TIME . ':'; ?></td>
                        <td nowrap="nowrap">
                    <?php
                    // for 1.6
                    echo JHtml::_('calendar', date("Y-m-d"), 'rent_until', 'rent_until', '%Y-%m-%d');
                    ?>
                        </td>
                    </tr>
                </table>

                    <?php
                } 

                $all = JFactory::getDBO();
                $query = "SELECT * FROM #__vehiclemanager_rent";
                $all->setQuery($query);
                $num = $all->loadObjectList();
                ?>
            <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist adminlist_09">
                <tr>
                    <th width="20" align="center">
                    <input type="checkbox" name="toggle" onClick="vm_checkAll(this<?php //echo count( $num );  ?>);" />
                    <th align = "center" width="30">#</th>
                    <th align = "center" class="title" width="5%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_VEHICLEID; ?></th>
                    <th align = "center" class="title" width="25%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_TITLE; ?></th>
                    <th align = "center" class="title" width="15%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_FROM; ?></th>
                    <th align = "center" class="title" width="20%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_UNTIL; ?></th>
                    <th align = "center" class="title" width="15%" nowrap="nowrap"><?php echo "Rent return"; ?></th>
                    <th align = "center" class="title" width="20%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_RENT_TO; ?></th>
                </tr>
            <?php     
                if ($type == "edit_rent"){ ?>
                  <input type="hidden"  name="checkVehicle" id="checkVehicle" value="on" /></td>
                
              <?php
                } 
                $assoc_title = ''; 
                for ($t = 0, $z = count($title_assoc); $t < $z; $t++) {
                  if($title_assoc[$t]->vtitle != $main_veh->vtitle) $assoc_title .= " ".$title_assoc[$t]->vtitle; 
                }

                  //show rent history what we may change
                    ?>
                        &nbsp;
                    <input class="inputbox" type="hidden"  name="id" id="id" size="0" maxlength="0" value="<?php echo $main_veh->id; ?>" />
                    <input class="inputbox" type="hidden"  name="vtitle" id="vtitle" size="0" maxlength="0" value="<?php echo $assoc_title; ?>" />
                    <?php
                    $num = 1;
                    for ($i = 0, $n2 = count($all_assosiate_rent[0]); $i < $n2; $i++) {
                        $assoc_rent_ids = ''; 
                        for ($j = 0, $n3 = count($all_assosiate_rent); $j < $n3; $j++) {
                            if($assoc_rent_ids != "" ) $assoc_rent_ids .= ",".$all_assosiate_rent[$j][$i]->id; 
                            else $assoc_rent_ids = $all_assosiate_rent[$j][$i]->id; 
                        }
                
                                      
                        ?>
                            <td align="center"><input type="checkbox"  id="cb<?php echo $i; ?>" name="vid[]" 
                              value="<?php echo $assoc_rent_ids; ?>" onClick="isChecked(this.checked);" /></td>
                        <?php  
                        print_r("
                          <td align=\"center\">" . $num . "</td>
                          <td align=\"center\"> </td>
                          <td align=\"center\">" . $main_veh->vtitle . " ( " . $assoc_title ." ) " . "</td>
                          <td align=\"center\">" . $all_assosiate_rent[0][$i]->rent_from . "</td>
                          <td align=\"center\">" . $all_assosiate_rent[0][$i]->rent_until . "</td>    
                          <td align=\"center\">" . $all_assosiate_rent[0][$i]->rent_return . "</td>   
                          <td align=\"center\">" . $all_assosiate_rent[0][$i]->user_name . ":  "
                             . $all_assosiate_rent[0][$i]->user_email . "</td> </tr>");
                        $num++;
                    }              
                  
                print_r("
                  <td align=\"center\">--</td>
                  <td align=\"center\">--</td>
                  <td align=\"center\">" . "----" . "</td>
                  <td align=\"center\">" . "-----------------" . "</td>
                  <td align=\"center\">" . " -------------" . "</td>
                  <td align=\"center\">" . " ---------" . "</td>
                  <td align=\"center\">" . " ---------------------" . "</td>
                  <td align=\"center\">" . "------------------" . "</td> </tr>");
                  
                  //show rent history what we can't change
                  for ($j = 0, $n = count($rows); $j < $n; $j++) {
                    $row = $rows[$j];
                     if($row->rent_return == "" ) continue ;
                    ?>
                        &nbsp;

                    <input class="inputbox" type="hidden"  name="id" id="id" size="0"
                      maxlength="0" value="<?php echo $main_veh->id; ?>" />
                    <input class="inputbox" type="hidden"  name="vtitle" id="vtitle"
                       size="0" maxlength="0" value="<?php echo $row->vtitle; ?>" />
                    <?php
               
                   
                    $num = 1;
                  
                        { 
                            ?>
                            <td align="center">
                            </td>
                <?php 
                        } ?>
                        <?php
                        print_r("
                          <td align=\"center\">" . $num . "</td>
                          <td align=\"center\">" . $row->vehicleid . "</td>
                          <td align=\"center\">" . $row->vtitle . "</td>
                          <td align=\"center\">" . $row->rent_from . "</td>
                          <td align=\"center\">" . $row->rent_until . "</td>    
                          <td align=\"center\">" . $row->rent_return . "</td>   
                          <td align=\"center\">" . $row->user_name . ":  " . $row->user_email . "</td> </tr>");
                        $num++;
                     } ?>
            </table>
            <input type="hidden" name="option" value="<?php echo $option; ?>" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="1" />
            <input type="hidden" name="save" value="1" />
        </form>
        <?php
    }


    static function showConfiguration($lists, $option, $txt)
    {
        global $my, $mosConfig_live_site, $mainframe, $act, $task;
        // for 1.6
        global $doc, $css;
        $doc->addStyleSheet($css);
        $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');

        $html = "<div class='vehicle_manager_caption' ><img src='./components/com_vehiclemanager/images/building_icon.jpg' alt ='Config' /> " . _VEHICLE_MANAGER_ADMIN_CONFIG . "</div>";
        $app = JFactory::getApplication();
        $app->JComponentTitle = $html;
        ?>
        <script>
            window.onload=function()
            {
                if (document.getElementById('money_select').options[document.getElementById('money_select').selectedIndex].value == 'other') { 
                    document.getElementById('patt').type="text";
                    document.getElementById('patt').removeAttribute('readonly');
                }
            }
            function set_pricetype(sel) {
                var value = sel.options[sel.selectedIndex].value;
                if (value=="space") {
                    document.getElementById('patt').value="&nbsp;";
                    //      document.getElementById('patt').setAttribute('readonly', true); 
                    //     document.getElementById('patt').type="hidden";
                }
                else if (value!="other") {
                    document.getElementById('patt').value=value;
                    document.getElementById('patt').setAttribute('readonly', true); 
                    document.getElementById('patt').type="hidden";
                } else
                {
                    document.getElementById('patt').value="";
                    document.getElementById('patt').type="text";
                    document.getElementById('patt').removeAttribute('readonly');
                }
            }
        </script>
        <form action="index.php"  class="veh_settings veh_dd_tabs" method="post" name="adminForm"  id="adminForm">
        <?php
        if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            $options = Array();
            echo JHtml::_('tabs.start', 'configurePane', $options);
            echo JHtml::_('tabs.panel', JText::_(_VEHICLE_MANAGER_SETTINGS_TAB_LABEL_VEHICLE_PAGE_SETTINGS), 'panel_1_configurePane');
        } else
        {
            $tabs = new mosTabs(2);
            $tabs->startPane("impexPane");
            $tabs->startTab(_VEHICLE_MANAGER_SETTINGS_TAB_LABEL_VEHICLE_PAGE_SETTINGS, "configurePane");
        }
        ?>
            <h2><?php echo _VEHICLE_MANAGER_SETTINGS_HEADER_LABEL_VEHICLE_IMAGE_SETTINGS; ?></h2>
            <table class="adminform adminform_25">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_FOTOMAIN_SIZE; ?>:</td>
                    <td><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_FOTOMAIN_SIZE_TT_BODY . "' alt='info'>"; ?></td>
                    <td><?php echo ($lists['fotomain']['high']) . "<span class='slash'>&nbsp;&nbsp;</span>  " . ($lists['fotomain']['width']); ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_FOTOGAL_SIZE; ?>:</td>
                    <td><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_FOTOGAL_SIZE_TT_BODY . "' alt='info'>"; ?></td>
                    <td><?php echo ($lists['fotogal']['high']) . " <span class='slash'>&nbsp;&nbsp;</span>  " . ($lists['fotogal']['width']); ?></td>
                </tr>
            </table>
            <h2><?php echo _VEHICLE_MANAGER_SETTINGS_HEADER_LABEL_TABS_MANAGER; ?></h2>
            <table class="adminform adminform_26">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_LOCATION_TAB_SHOW; ?>:</td>
                    <td><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_LOCATION_TAB_SHOW_TT_BODY . "' alt='info'>"; ?></td>
                    <td  class="yesno"><?php echo $lists['Location_vehicle']['show']; ?></td>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_LOCATION_TAB_SHOW_REGISTRATIONLEVEL; ?>:</td>         
                    <td><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_LOCATION_TAB_SHOW_REGISTRATIONLEVEL_TT_BODY . "' alt='info'>"; ?></td>
                    <td><?php echo $lists['Location_vehicle']['registrationlevel']; ?></td>  
                </tr>
               <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_REVIEWS_TAB_SHOW; ?>:</td>
                    <td><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_REVIEWS_TAB_SHOW_TT_BODY . "' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['Reviews_vehicle']['show']; ?></td>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_REVIEWS_TAB_SHOW_REGISTRATIONLEVEL; ?>:</td>         
                    <td><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_REVIEWS_TAB_SHOW_REGISTRATIONLEVEL_TT_BODY . "' alt='info'>"; ?></td>
                    <td><?php echo $lists['Reviews_vehicle']['registrationlevel']; ?></td>  
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_CONFIG_CALENDARLIST_SHOW; ?>:</td>
                    <td><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_CONFIG_CALENDARLIST_SHOW_TT_BODY . "' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['calendar']['show']; ?></td>
                    <td width="185"><?php echo _VEHICLE_MANAGER_CONFIG_CALENDARLIST_REGISTRATIONLEVEL; ?>:</td>
                    <td><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_CONFIG_CALENDARLIST_REGISTRATIONLEVEL_TT_BODY . "' alt='info'>"; ?></td>
                    <td><?php echo $lists['calendarlist']['registrationlevel']; ?></td>
                </tr>
            </table>
            <h2><?php echo _VEHICLE_MANAGER_SETTINGS_HEADER_LABEL_FEATURE_LIST_SETTINGS; ?></h2>
            <table class="adminform adminform_28">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_MANAGER_FEATURE_IMAGE; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_MANAGER_FEATURE_IMAGE_TT_HEAD . "' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['manager_feature_image']; ?></td>
                </tr>
               <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_MANAGER_FEATURE_CATEGORIES_SHOW; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_MANAGER_FEATURE_CATEGORIES_SHOW_TT_HEAD . "' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['manager_feature_category']; ?></td>
                </tr>
            </table>
            <table class="adminform adminform_29">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_VEHICLE_PAGE_LAYOUT; ?>:</td>
                    <td><?php echo $lists['view_vehicle']; ?></td>
                </tr>
            </table>
            <h2><?php echo _VEHICLE_MANAGER_SETTINGS_HEADER_LABEL_EXTRA_FIELDS_MANAGER; ?></h2>
            <table class="adminform adminform_30">
                <tr>
                    <td width="230"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_EXTRA1_SHOW; ?>:</td>
                    <td class="yesno"><?php echo $lists['extra1']; ?></td>
                </tr>
                <tr>
                    <td><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_EXTRA2_SHOW; ?>:</td>
                    <td class="yesno"><?php echo $lists['extra2']; ?></td>
                </tr>
                <tr>
                    <td><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_EXTRA3_SHOW; ?>:</td>
                    <td class="yesno"><?php echo $lists['extra3']; ?></td>
                </tr>
                <tr>
                    <td><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_EXTRA4_SHOW; ?>:</td>
                    <td class="yesno"><?php echo $lists['extra4']; ?></td>
                </tr>
                <tr>
                    <td><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_EXTRA5_SHOW; ?>:</td>
                    <td class="yesno"><?php echo $lists['extra5']; ?></td>
                </tr>
                <tr>
                    <td><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_EXTRA6_SHOW; ?>:</td>
                    <td class="yesno"><?php echo $lists['extra6']; ?></td>
                </tr>
                <tr>
                    <td><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_EXTRA7_SHOW; ?>:</td>
                    <td class="yesno"><?php echo $lists['extra7']; ?></td>
                </tr>
                <tr>
                    <td><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_EXTRA8_SHOW; ?>:</td>
                    <td class="yesno"><?php echo $lists['extra8']; ?></td>
                </tr>
                <tr>
                    <td><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_EXTRA9_SHOW; ?>:</td>
                    <td class="yesno"><?php echo $lists['extra9']; ?></td>
                </tr>
                <tr>
                    <td><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_EXTRA10_SHOW; ?>:</td>
                    <td class="yesno"><?php echo $lists['extra10']; ?></td>
                </tr>    
            </table>
        <?php
        if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            echo JHtml::_('tabs.panel', JText::_(_VEHICLE_MANAGER_SETTINGS_TAB_LABEL_CATEGORY_PAGE_SETTINGS), 'panel_2_configurePane');
        } else
        {
            $tabs->endTab();
            $tabs->startTab(_VEHICLE_MANAGER_SETTINGS_TAB_LABEL_CATEGORY_PAGE_SETTINGS, "configurePane");
        }
        ?><!-- info_make -->
            <h2><?php echo _VEHICLE_MANAGER_HEADER_CATEGORY_OPTIONS; ?></h2>
            <table class="adminform adminform_31">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_ALL_CATEGORIES_LAYOUT; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_INFO_SELECT_LAYOUT . "' alt='info'>"; ?></td>
                    <td  colspan="2"><?php echo $lists['all_categories']; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_SINGLE_CATEGORY_LAYOUT; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_INFO_SELECT_LAYOUT . "' alt='info'>"; ?></td>
                    <td colspan="2"><?php echo $lists['view_type']; ?></td>
                </tr>
                
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_LABEL_SEARCH_LAYOUT; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_INFO_SELECT_LAYOUT . "' alt='info'>"; ?></td>
                    <td  colspan="2"><?php echo $lists['show_search_vehicle']; ?></td>
                </tr>
                               
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_SHOW_LOCATION_MAP; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_SHOW_LOCATION_MAP_TT_BODY . "' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['location_map']; ?></td>
                </tr>
            </table>
            <table class="adminform adminform_32">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_FOTO_SIZE; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_FOTO_SIZE_TT_BODY . "' alt='info'>"; ?></td>
                    <td><?php echo " &nbsp;&nbsp;" .($lists['foto']['high']) . " " . ($lists['foto']['width']); ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_FOTOGALLERY_SIZE; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_FOTOGALLERY_SIZE_TT_BODY . "' alt='info'>"; ?></td>
                    <td><?php echo " &nbsp;&nbsp;" .($lists['fotogallery']['high']) . " " . ($lists['fotogallery']['width']); ?></td>
                </tr>
            </table>
            <table class="adminform adminform_33">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_PAGE_ITEMS; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_PAGE_ITEMS_TT_BODY . "' alt='info'>"; ?></td>
                    <td><?php echo $lists['page']['items']; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_PICTURE_IN_CATEGORY; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_PICTURE_IN_CATEGORY_TT_BODY . "' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['cat_pic']['show']; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_SUBCATEGORY_SHOW; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_SUBCATEGORY_SHOW_TT_BODY . "' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['subcategory']['show']; ?></td>
                </tr>
            </table>     

        <?php
        if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            echo JHtml::_('tabs.panel', JText::_(_VEHICLE_MANAGER_SETTINGS_TAB_LABEL_ADMINISTRATOR_SETTINGS), 'panel_4_configurePane');
        } else
        {
          
            $tabs->endTab();
            $tabs->startTab(_VEHICLE_MANAGER_SETTINGS_TAB_LABEL_ADMINISTRATOR_SETTINGS, "configurePane");
        }
        ?>    
            
            <h2><?php echo _VEHICLE_MANAGER_SETTINGS_HEADER_LABEL_EDOCUMENT_OPTIONS; ?></h2>
            <table class="adminform adminform_40">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_DOWNLOAD; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_DOWNLOAD_TT_BODY . "' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['edocs']['allow']; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_DOWNLOAD_LOCATION; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_DOWNLOAD_LOCATION_TT_BODY . "' alt='info'>"; ?></td>
                    <td><?php echo $lists['edocs']['location']; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_SHOW; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_SHOW_TT_BODY . "' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['edocs']['show']; ?></td>
                    <td width="220"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_REGISTRATIONLEVEL; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_EDOCUMENTS_REGISTRATIONLEVEL_TT_BODY . "' alt='info'>"; ?></td>
                    <td><?php echo $lists['edocs']['registrationlevel']; ?></td>
                </tr>
            </table>
            <h2><?php echo _VEHICLE_MANAGER_SETTINGS_HEADER_LABEL_PRICE_OPTIONS; ?></h2>
              <table class="adminform adminform_41">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_PRICE_SHOW; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_PRICE_SHOW_TT_BODY . "' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['price']['show']; ?></td>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_PRICE_REGISTRATIONLEVEL; ?></td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_PRICE_REGISTRATIONLEVEL_TT_BODY . "' alt='info'>"; ?></td>
                    <td><?php echo $lists['price']['registrationlevel']; ?></td> 
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_SALE_SEPARATOR_SHOW; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_SALE_SEPARATOR_SHOW_TT_HEAD . "' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['sale_separator']; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_CURRENCY; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_CURRENCY_TT_BODY . "' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['currency']; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_PRICE_FORMAT; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_PRICE_FORMAT .": ". _VEHICLE_MANAGER_PRICE_FORMAT_INFO . "' alt='info'>"; ?></td>
                    <td width="185"><?php echo $lists['money_ditlimer'] ?><br /><?php echo $lists['patern']; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_PRICE_UNIT_SHOW; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_PRICE_UNIT_SHOW .": ". _VEHICLE_MANAGER_PRICE_UNIT_SHOW_INFO . "' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['price_unit_show'] ?></td>
                </tr>
                <tr>
                    <td width="185" rowspan="2"><?php echo _VEHICLE_MANAGER_DATE_TIME_FORMAT; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_DATE_FORMAT .": ". _VEHICLE_MANAGER_DATE . "' alt='info'>"; ?></td>
                    <td width="185"><?php echo $lists['date_format'] ?></td>
                 </tr>
                <tr>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_TIME_FORMAT .": ". _VEHICLE_MANAGER_TIME . "' alt='info'>"; ?></td>
                    <td width="185"><?php echo $lists['datetime_format'] ?></td>
                </tr>
            </table>        
            <h2><?php echo _VEHICLE_MANAGER_SETTINGS_COMMON_SETTINGS; ?></h2>
            <table class="adminform adminform_42">
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_BUYSTATUS_SHOW; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_BUYSTATUS_SHOW_TT_BODY . "' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['buystatus']['show']; ?></td>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_BUYREQUEST_REGISTRATIONLEVEL; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_BUYREQUEST_REGISTRATIONLEVEL_TT_BODY . "' alt='info'>"; ?></td>
                    <td><?php echo $lists['buyrequest']['registrationlevel']; ?></td>         
                </tr>        
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_RENTSTATUS_SHOW; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_RENTSTATUS_SHOW_TT_BODY . "' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['rentstatus']['show']; ?></td>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_RENTREQUEST_REGISTRATIONLEVEL; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_RENTREQUEST_REGISTRATIONLEVEL_TT_BODY . "' alt='info'>"; ?></td>
                    <td><?php echo $lists['rentrequest']['registrationlevel']; ?></td>         
                </tr>
                <tr><td colspan="6"><hr /></td></tr>
                <!-- __REVIEW__ -->
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_REVIEWS_SHOW; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_REVIEWS_SHOW_TT_BODY . "' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['reviews']['show']; ?></td>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_REVIEWS_REGISTRATIONLEVEL; ?>:</td>         
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_REVIEWS_REGISTRATIONLEVEL_TT_BODY . "' alt='info'>"; ?></td>
                    <td><?php echo $lists['reviews']['registrationlevel']; ?></td>         
                </tr>
                <!-- END__REVIEW__ --->
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ALLOWED_EXTS; ?>:</td>
                    <td colspan="4" style="padding-left:25px;"><?php echo $lists['allowed_exts']; ?></td>            
                </tr>
                <tr><td colspan="6"><hr /></td></tr>
                <tr class="hw">
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_FOTOUPLOAD_SIZE; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_FOTOUPLOAD_SIZE_TT_BODY . "' alt='info'>"; ?></td>
                    <td width="50">Height: &nbsp;<?php echo $lists['fotoupload']['high']; ?></td>
                    <td width="50">Width: &nbsp;<?php echo $lists['fotoupload']['width']; ?></td>
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ALLOWED_EXTS_IMG; ?>:</td>
                    <td colspan="4" style="padding-left:25px;"><?php echo $lists['allowed_exts_img']; ?></td>            
                </tr>
                <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_UPDATE; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_UPDATE_TT_BODY . "' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['update']; ?></td>
                </tr>
                <tr><td colspan="6"><hr /></td></tr>
            </table>
            
            <h2 id="special_price" ><?php echo _VEHICLE_MANAGER_RENT_SPECIAL_PRICE_AND_RENT_TIME; ?></h2>
            <table class="adminform adminform_43">      
               <tr>
                    <td width="185"><?php echo _VEHICLE_MANAGER_RENT_SPECIAL_PRICE_YES_NO; ?>:</td>
                    <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='"._VEHICLE_MANAGER_RENT_SPECIAL_PRICE_YES_NO_HELP."' alt='info'>"; ?></td>
                    <td class="yesno"><?php echo $lists['special_price']['show']; ?></td>
                </tr>           
                
            </table>    
        <?php
        if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            echo JHtml::_('tabs.end');
        } else
        {
            $tabs->endTab();
            $tabs->endPane();
        }
        ?>
            <input type="hidden" name="option" value="<?php echo $option; ?>" />
            <input type="hidden" name="task" value="config_save" />
        </form>
        <?php
    }

    static function about()
    {
        global $mosConfig_live_site, $mainframe;
        // for 1.6
        global $doc, $css;
        $doc->addStyleSheet($css);
        // --
        $html = "<div class='vehicle_manager_caption' ><img src='./components/com_vehiclemanager/images/building_icon.jpg' alt ='Config' /> " . _VEHICLE_MANAGER_ADMIN_ABOUT . "</div>";
        $app = JFactory::getApplication();
        $app->JComponentTitle = $html;
        ?>
        <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
        
        <form action="index.php"  class="veh_about veh_dd_tabs"  method="post" name="adminForm" id="adminForm">

                <?php
                if (version_compare(JVERSION, "3.0.0", "ge"))
                {
                    $options = Array();
                    echo JHtml::_('tabs.start', 'aboutPane', $options);
                    echo JHtml::_('tabs.panel', JText::_(_VEHICLE_MANAGER_ADMIN_ABOUT_ABOUT), 'panel_1_id');
                } else
                {
                    $tabs = new mosTabs(0);
                    $tabs->startPane("aboutPane");
                    $tabs->startTab(_VEHICLE_MANAGER_ADMIN_ABOUT_ABOUT, "display-page");
                }
                ?>
           <div class="adminform_44">
            <table class="adminform">
                <tr>
                    <td width="80%"><h3><?PHP echo _VEHICLE_MANAGER__HTML_ABOUT; ?></h3><?PHP echo _VEHICLE_MANAGER__HTML_ABOUT_INTRO; ?></td>
                    <td width="20%"><img src="../components/com_vehiclemanager/images/vm_logo.png" align="right" alt="Vehicle" /></td>           
                </tr>
            </table>
          </div>
            <?php
            /* $tabs->endTab();
              //******************************   tab--2 about   **************************************
              $tabs->startTab(_VEHICLE_MANAGER_ADMIN_ABOUT_RELEASENOTE, "display-page");
              include_once("./components/com_vehiclemanager/doc/releasenote.php");
              $tabs->endTab();
              //******************************   tab--3 about--changelog.txt   ***********************
              $tabs->startTab(_VEHICLE_MANAGER_ADMIN_ABOUT_CHANGELOG, "display-page");
              include_once("./components/com_vehiclemanager/doc/changelog.html");
              $tabs->endTab();

              $tabs->endPane(); */
            ?>

        <?php
//******************************   tab--2 about   **************************************
        if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            echo JHtml::_('tabs.panel', JText::_(_VEHICLE_MANAGER_ADMIN_ABOUT_RELEASENOTE), 'panel_2_id');
        } else
        {
            $tabs->endTab();
            $tabs->startTab(_VEHICLE_MANAGER_ADMIN_ABOUT_RELEASENOTE, "display-page");
        } include_once("./components/com_vehiclemanager/doc/releasenote.php");

//******************************   tab--3 about--changelog.txt   ***********************
        if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            echo JHtml::_('tabs.panel', JText::_(_VEHICLE_MANAGER_ADMIN_ABOUT_CHANGELOG), 'panel_2_id');
        } else
        {
            $tabs->endTab();
            $tabs->startTab(_VEHICLE_MANAGER_ADMIN_ABOUT_CHANGELOG, "display-page");
        }

        include_once("./components/com_vehiclemanager/doc/changelog.html");

//End Pane
        if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            echo JHtml::_('tabs.end');
        } else
        {
            $tabs->endTab();
            $tabs->endPane();
        }
        ?>

        </form>
                <?php
            }

        static function showFeaturedManager($features, $pageNav)
        {
            global $my, $mosConfig_live_site, $mainframe, $templateDir;
            // for 1.6
            global $doc, $css;
            $doc->addStyleSheet($css);
            $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');

            $html = "<div class='vehicle_manager_caption' ><img src='./components/com_vehiclemanager/images/building_icon.jpg' alt ='Config' /> " . _VEHICLE_MANAGER_ADMIN_FEATURED_MANAGER . "</div>";
            $app = JFactory::getApplication();
            $app->JComponentTitle = $html;
            ?>
        <form action="index.php" method="post"  name="adminForm" id="adminForm">
        <?php if (version_compare(JVERSION, "3.0.0", "ge"))
        {
        ?>
        <?php
        // Features tabs
        if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            $options = Array();
            echo JHtml::_('tabs.start', 'impexPane', $options);
            echo JHtml::_('tabs.panel', JText::_(_VEHICLE_MANAGER_ADMIN_CONFIG_MANAGER_FEATURE_CATEGORIES_TT_HEAD), 'panel_1_impexPane');
        } else
        {
            $tabs = new mosTabs(0);
            $tabs->startPane("impexPane");
            $tabs->startTab(_VEHICLE_MANAGER_ADMIN_IMP, "impexPane");
        }
        ?>
      <div class="table_07">
        <table width="100%">
            <tr>
            <?php $feature_cat = '<input type="text" name="featuredmanager_placeholder" value="' . $GLOBALS['vehiclemanager_configuration']['featuredmanager']['placeholder'] . '" class="inputbox" size="50" maxlength="500" title=""/>'; ?>
              <td width="185"><?php echo _VEHICLE_MANAGER_ADMIN_CONFIG_MANAGER_FEATURE_CATEGORIES; ?>:</td>
              <td width="20"><?php echo "<img src='" . JURI::base() . 'components/com_vehiclemanager/images/info.png' . "' title='" . _VEHICLE_MANAGER_ADMIN_CONFIG_MANAGER_FEATURE_CATEGORIES_TT_BODY . "' alt='info'>"; ?></td>
              <td class="yesno"><?php echo $feature_cat; ?></td>
           </tr>
         </table>   
      </div>
        <?php
        if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            echo JHtml::_('tabs.panel', JText::_(_VEHICLE_MANAGER_LABEL_FEATURED_MANAGER_FEATURE), 'panel_2_impexPane');
        } else
        {
            $tabs->endTab();
            $tabs->startTab(_VEHICLE_MANAGER_ADMIN_EXP, "impexPane");
        }
        ?>
            <table width="100%"  class="table_08">
                <tr>
                    <td>
                        <div class="btn-group pull-right hidden-phone">
                            <label for="limit" class="element-invisible">
                                  <?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?>
                            </label>
                        <?php echo $pageNav->getLimitBox(); ?>
                        </div>
                    </td>                
                </tr>
            </table>
       <?php } ?>
            <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist adminlist_10">
                <tr>
                    <th width="5" align="center"><input type="checkbox" name="toggle" onClick="vm_checkAll(this<?php //echo count( $features );   ?>);" /></th>
                    <th align = "center" class="title" width="45%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_FEATURED_MANAGER_FEATURE; ?></th>
                    <th align = "center" class="title" width="35%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_FEATURED_MANAGER_CATEGORY; ?></th>
                    <th align = "center" class="title" width="15%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_FEATURED_MANAGER_PUBLISHED; ?></th>
                </tr>

        <?php
        $i = 0;
        foreach ($features as $feature) {
            $task = $feature->published ? 'unpublish' : 'publish';
            $alt = $feature->published ? 'Unpublish' : 'Publish';
            $img = $feature->published ? 'tick.png' : 'publish_x.png';
            
                if($feature->name):?>
                    <tr>
                        <td align="center"><?php echo mosHTML::idBox($i, $feature->id, false, 'vid'); ?></td>
                        <td><?php echo $feature->name; ?></td>
                        <td><?php echo $feature->categories; ?></td>
                        <td align="center">
                            <a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i; ?>','<?php echo $task; ?>')">
            <?php
            if (version_compare(JVERSION, "1.6.0", "lt"))
            {
                ?>
                       <img src="<?php echo $mosConfig_live_site . "/administrator/images/" . $img; ?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
                <?php
            } else
            {
                ?>
                       <img src="<?php echo $templateDir . "/images/admin/" . $img; ?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
                <?php
            }
            ?>
                          </a>
                    </tr>
            <?php endif;
            $i++;
        }
        ?>
                <tr><td colspan = "13"><?php echo $pageNav->getListFooter(); ?></td></tr>
            </table>
            <input type="hidden" name="option" value="com_vehiclemanager" />
            <input type="hidden" name="section" value="featured_manager" />
            <!--<input type="hidden" name="option" value="<?php echo $option; ?>" />-->
            <input type="hidden" name="task" value="" />
            <input type="hidden" value="0" name="boxchecked">
        </form>
        <?php
    }

    static function editFeaturedManager($row, $lists)
    {
        global $mosConfig_live_site;
        global $doc, $css;
        $doc->addStyleSheet($css);
        $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');

        $html = "<div class='vehicle_manager_caption' ><img src='./components/com_vehiclemanager/images/building_icon.jpg' alt ='Config' /> " . _VEHICLE_MANAGER_ADMIN_FEATURED_MANAGER . "</div>";
        $app = JFactory::getApplication();
        $app->JComponentTitle = $html;
        ?>

        <form action="index.php" method="post" name="adminForm"  id="adminForm" enctype="multipart/form-data">
            <table >
                <tr>
                    <th  class="vehicle_manager_caption" align="left"><?php echo $row->id ? _VEHICLE_HEADER_EDIT : _VEHICLE_HEADER_ADD; ?> <?php echo _VEHICLE_MANAGER_LABEL_FEATURED_MANAGER_FEATURE; ?> </th>
                </tr>
            </table>

            <table width="100%"  class="table_9">
                <tr>
                    <td valign="top">
                        <table class="adminform adminform_47" style="height: 150px;">
                            <tr>
                                <th colspan="3"><?php echo _VEHICLE_CATEGORIES__DETAILS; ?></th>
                            </tr>
                            <tr>
                                <td><?php echo _VEHICLE_MANAGER_LABEL_FEATURED_MANAGER_FEATURE; ?>:</td>
                                <td colspan="2"><input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="250" title="A short name to appear in menus" /></td>
                            </tr>
                            <tr>
                                <td><?php echo _VEHICLE_MANAGER_LABEL_FEATURED_MANAGER_CATEGORY; ?>:</td>
                                <td colspan="2"><?php echo $lists['categories']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo _VEHICLE_MANAGER_LABEL_FEATURED_MANAGER_PUBLISHED; ?>:</td>
                                <td colspan="2"><?php echo $lists['published']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo _VEHICLE_MANAGER_LABEL_FEATURED_MANAGER_IMAGE; ?>:</td>
                                <td>
                                    <input class="inputbox" type="file" name="image_link"  size="50" maxlength="250" /><br>
                                    <i><?php echo _VEHICLE_MANAGER_LABEL_FEATURED_MANAGER_RECOMMENDED_IMAGE; ?></i>
                                </td>
                            </tr> 
                            <tr>
                                <td colspan="2">
        <?php  
        if ($row->image_link != '')
        {
          echo _VEHICLE_MANAGER_LABEL_FEATURED_MANAGER_REMOVE; ?>:
              <input type="checkbox" name="del_main_photo" value="<?php echo $row->image_link; ?>" />        
              <img alt="photo" src="<?php echo "$mosConfig_live_site/components/com_vehiclemanager/featured_ico/$row->image_link"; ?>"></img>      
        <?php } else echo "&nbsp"; ?>   
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="option" value="com_vehiclemanager" />
            <input type="hidden" name="section" value="featured_manager" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
            <input type="hidden" name="sectionid" value="com_vehiclemanager" />
        </form>
        <?php
    }

    static function showLanguageManager($const_languages, $pageNav, $search)
    {
        global $my, $mosConfig_live_site, $mainframe, $templateDir;
        // for 1.6
        global $doc, $css;
        $doc->addStyleSheet($css);
        $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');
        $html = "<div class='vehicle_manager_caption' ><img src='./components/com_vehiclemanager/images/building_icon.jpg' alt ='Config' /> " . _VEHICLE_MANAGER_ADMIN_LANGUAGE_MANAGER . "</div>";
        $app = JFactory::getApplication();
        $app->JComponentTitle = $html;
        ?>
        <form action="index.php" method="post" name="adminForm" id="adminForm">    
            <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist language_manager">
                <tr>
                    <td><?php echo _VEHICLE_MANAGER_SHOW_SEARCH; ?></td>
                    <td><input type="text" name="search_const" value="<?php echo $search['const']; ?>" class="inputbox input-medium" onChange="document.adminForm.submit();" /></td>
                    <td><input type="text" name="search_const_value" value="<?php echo $search['const_value']; ?>" class="inputbox input-medium" onChange="document.adminForm.submit();" /></td>
                    <td><?php echo $search['languages']; ?></td>
                    <td><?php echo $search['sys_type']; ?></td>
        <?php if (version_compare(JVERSION, "3.0.0", "ge"))
        {
            ?>
                        <td>
                            <div class="btn-group pull-right hidden-phone">
                                <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
                                        <?php echo $pageNav->getLimitBox(); ?>
                            </div>
                        </td>
        <?php } ?>
                </tr>
                <tr>
                    <th width="5" align="center"></th>
                    <th align = "center" class="title" width="30%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_ADMIN_LANGUAGE_MANAGER_CONST; ?></th>
                    <th align = "center" class="title" width="30%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_ADMIN_LANGUAGE_MANAGER_VALUE_CONST; ?></th>
                    <th align = "center" class="title" width="10%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_LABEL_LANGUAGE; ?></th>
                    <th align = "center" class="title" width="30%" nowrap="nowrap"><?php echo _VEHICLE_MANAGER_ADMIN_LANGUAGE_MANAGER_SYS_TYPE; ?></th>
                </tr>

        <?php
        $i = 0;
        foreach ($const_languages as $const_language) {
            ?>
                    <tr>
                        <td align="center"><?php echo mosHTML::idBox($i, $const_language->id, false, 'vid'); ?></td>
                        <td><a href="#edit" onClick="return listItemTask('cb<?php echo $i; ?>','edit')"><?php echo $const_language->const; ?></a></td>
                        <td><a href="#edit" onClick="return listItemTask('cb<?php echo $i; ?>','edit')"><?php echo $const_language->value_const; ?></a></td>
                        <td align="center"><?php echo $const_language->title; ?></td>
                        <td align="center"><?php echo $const_language->sys_type; ?></td>
                    </tr>
            <?php
            $i++;
        }
        ?>
                <tr><td colspan = "13"><?php echo $pageNav->getListFooter(); ?></td></tr>
            </table>
            <input type="hidden" name="option" value="com_vehiclemanager" />
            <input type="hidden" name="section" value="language_manager" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" value="0" name="boxchecked" />
        </form>
        <?php
    }

    static function editLanguageManager($row, $lists)
    {
        global $mosConfig_live_site;
        global $doc, $css;
        $doc->addStyleSheet($css);
        $doc->addScript($mosConfig_live_site . '/components/com_vehiclemanager/includes/functions.js');

        $html = "<div class='vehicle_manager_caption' ><img src='./components/com_vehiclemanager/images/building_icon.jpg' alt ='Config' /> " . _VEHICLE_MANAGER_ADMIN_LANGUAGE_MANAGER . "</div>";
        $app = JFactory::getApplication();
        $app->JComponentTitle = $html;
        ?>    
        <form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
            <table >
                <tr>
                    <th  class="vehicle_manager_caption" align="left"><?php echo $row->id ? _VEHICLE_HEADER_EDIT : _VEHICLE_HEADER_ADD; ?> <?php echo _VEHICLE_MANAGER_ADMIN_LANGUAGE_MANAGER_CONST; ?> </th>
                </tr>
            </table>
            <table width="100%"  class="table_10">
                <tr>
                    <td valign="top">
                        <table class="adminform adminform_48" style="height: 150px;">
                            <tr>
                                <td><?php echo _VEHICLE_MANAGER_ADMIN_LANGUAGE_MANAGER_CONST; ?>:</td>
                                <td colspan="2"><?php echo $lists['const']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo _VEHICLE_MANAGER_ADMIN_LANGUAGE_MANAGER_VALUE_CONST; ?>:</td>
                                <td colspan="2"><textarea class="text_area" type="text" name="value_const"><?php echo $row->value_const; ?></textarea></td>
                            </tr>
                            <tr>
                                <td><?php echo _VEHICLE_MANAGER_ADMIN_LANGUAGE_MANAGER_SYS_TYPE; ?>:</td>
                                <td colspan="2"><?php echo $lists['sys_type']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo _VEHICLE_MANAGER_LABEL_LANGUAGE; ?>:</td>
                                <td colspan="2"><?php echo $lists['languages']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="const" value="<?php echo $lists['const']; ?>"/>
            <input type="hidden" name="option" value="com_vehiclemanager" />
            <input type="hidden" name="section" value="language_manager" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
            <input type="hidden" name="sectionid" value="com_vehiclemanager" />
        </form>    
        <?php
    }
}
