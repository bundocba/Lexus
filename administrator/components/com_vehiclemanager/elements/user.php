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

if (version_compare(JVERSION, "1.6.0", "lt"))
{

    class JElementUser extends JElement
    {

        function fetchElement($name, $value, &$node, $control_name)
        {
            $db = &JFactory::getDBO();
            $query = "SELECT u.name AS user
                      FROM `#__users` AS u
                      LEFT JOIN `#__vehiclemanager_vehicles` AS v ON v.owneremail=u.email
                      WHERE v.published = 1
                      GROUP BY u.name
                      ORDER BY u.name";
            $db->setQuery($query);
            $showownervehicles = $db->loadObjectList();
            return JHTML::_('select.genericlist', $showownervehicles, '' . $control_name . '[' . $name . ']', 'class="inputbox"', 'user', 'user', $value, $control_name . $name);
        }

    }

} else if (version_compare(JVERSION, "1.6.0", "ge") && version_compare(JVERSION, "3.5.0", "lt"))
{

    class JFormFieldUser extends JFormField
    {

        protected function getInput()
        {
            $db = &JFactory::getDBO();
            $query = "SELECT u.name AS user, u.name AS title 
                      FROM #__users AS u
                      LEFT JOIN #__vehiclemanager_vehicles AS v ON v.owneremail=u.email
                      WHERE v.published = 1
                      GROUP BY u.name
                      ORDER BY u.name";
            $db->setQuery($query);
            $showownervehicles = $db->loadObjectList();
            return JHtml::_('select.genericlist', $showownervehicles, $this->name, 'class="inputbox"', 'user', 'user', $this->value, $this->name);
        }

    }

} else
{
    echo "Sanity test. Error version check!";
    exit;
}
