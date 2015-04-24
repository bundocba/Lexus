<?php
/**
 * @version		2.6.x
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

class Bun
{
	public function getImage_by_Title($title)
	{
		$db=JFactory::getDbo();
		$query=$db->getQuery(true);
		$query->select("id");
		$query->from($db->quoteName("#__k2_items"));
		$query->where($db->quoteName('title').'like'.$db->quote($title));
		$query->setLimit(1);
		$db->setQuery($query);
		$results = $db->loadResult();

		if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$results).'_XL.jpg'))
			{
				$imageBanner = JURI::base(true).'/media/k2/items/cache/'.md5("Image".$results).'_XL.jpg';
			}
		return $imageBanner;
	}
	public function getVideo_by_Title($title){
		$db=JFactory::getDbo();
		$query=$db->getQuery(true);
		$query->select("video");
		$query->from($db->quoteName("#__k2_items"));
		$query->where($db->quoteName('title').'like'.$db->quote($title));
		$query->setLimit(1);
		$db->setQuery($query);
		$result = $db->loadResult();
		return $result;
	}
	
}
?>