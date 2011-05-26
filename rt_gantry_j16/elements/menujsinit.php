<?php
/**
 * @package     gantry
 * @subpackage  admin.elements
 * @version        3.2.4 April 20, 2011
 * @author        RocketTheme http://www.rockettheme.com
 * @copyright     Copyright (C) 2007 - 2011 RocketTheme, LLC
 * @license        http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
defined('JPATH_BASE') or die();
/**
 * @package     gantry
 * @subpackage  admin.elements
 */
class JElementMenuJSInit extends JElement {


    function fetchElement($name, $value, &$node, $control_name) {
	
		$doc =& JFactory::getDocument();
        $doc->addScript(JURI::Root(true)."/templates/rt_gantry_j16/elements/childtype.js");
	
        return null;
    }



}

?>