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

require_once ( JPATH_SITE.'/components/com_vehiclemanager/functions.php' );
if (version_compare(JVERSION, "1.6.0", "lt"))
{

    class JElementShowSearchVehiclelayout extends JElement
    {

        var $_name = 'showsearchvehiclelayout';

        function fetchElement($name, $value, &$node, $control_name)
        {
            $all_categories_layout = getLayoutsRem('com_vehiclemanager','show_search_vehicle');
            $layouts = Array();
            $layouts[] = JHtml::_('select.option', '', 'Use Global');
            foreach($all_categories_layout as $value){
                $layouts[] = JHtml::_('select.option', "$value", "$value"); 
            }
            return JHTML::_('select.genericlist', $layouts, '' . $control_name . '[' . $name . ']', 'class="inputbox"', 'layout', 'title', $value, $control_name . $name);
        }

    }

} else if (version_compare(JVERSION, "1.6.0", "ge") && version_compare(JVERSION, "3.5.0", "lt"))
{

    class JFormFieldShowSearchVehiclelayout extends JFormField
    {

        protected function getInput()
        {
            $all_categories_layout = getLayoutsVeh('com_vehiclemanager','show_search_vehicle');
            $layouts = Array();
            $layouts[] = JHtml::_('select.option', '', 'Use Global');
            foreach($all_categories_layout as $value){
                $layouts[] = JHtml::_('select.option', "$value", "$value"); 
            }
            return JHtml::_('select.genericlist', $layouts, $this->name, 'class="inputbox"', 'layout', 'title', $this->value, $this->name);
        }

    }

} else
{
    echo "Sanity test. Error version check!";
    exit;
}
