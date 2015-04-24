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

    class JElementMyVehicleslayout extends JElement
    {

        var $_name = 'myvehicleslayout';

        function fetchElement($name, $value, &$node, $control_name)
        {
            $component_path = JPath::clean(JPATH_SITE . '/components/com_vehiclemanager/views/my_vehicles/tmpl');
            $component_layouts = array();
            $layouts = array();
            if (is_dir($component_path) && ($component_layouts = JFolder::files($component_path, '^[^_]*\.php$', false, true)))
            {
                foreach ($component_layouts as $i => $file) {
                    $select_file_name = pathinfo($file);
                    $select_file_name = $select_file_name['filename'];
                    $layout = new stdClass;
                    $layout->layout = $select_file_name;
                    $layout->title = $select_file_name;
                    $layouts[] = $layout;
                }
            }
            return JHTML::_('select.genericlist', $layouts, '' . $control_name . '[' . $name . ']', 'class="inputbox"', 'layout', 'title', $value, $control_name . $name);
        }

    }

} else if (version_compare(JVERSION, "1.6.0", "ge") && version_compare(JVERSION, "3.5.0", "lt"))
{

    class JFormFieldMyVehicleslayout extends JFormField
    {

        protected function getInput()
        {
            $all_categories_layout = getLayoutsVeh('com_vehiclemanager','my_vehicles');
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
