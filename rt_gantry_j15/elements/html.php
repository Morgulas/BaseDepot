<?php
/**
 * @package     gantry
 * @subpackage  admin.elements
 * @version        3.1.13 April 28, 2011
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
class JElementHTML extends JElement {


    function fetchElement($name, $value, &$node, $control_name) {
	
		$output = trim($node->data());
	
        return $output;
    }



}

?>