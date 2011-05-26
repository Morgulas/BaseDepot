<?php
/**
 * @package   Gantry Template - RocketTheme
 * @version   3.1.13 April 28, 2011
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2011 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Rockettheme Gantry Template uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_BASE.DS.'modules'.DS.'mod_roknavmenu'.DS.'lib'.DS.'BaseRokNavMenuFormatter.php');

/*
 * Created on Jan 16, 2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class RokNavMenuFormatterTemplateGantrySplitMenu extends BaseRokNavMenuFormatter {
	function format(&$node, &$menu_params) {
	    // Format the current node
		
		if ($node->type == 'menuitem' or $node->type == 'separator') {
		    if ($node->hasChildren() ) {
    			$node->addLinkClass("daddy");
    		}  else {
    		    $node->addLinkClass("orphan");
    		}
    		
    		$node->addLinkClass("item");
            
		}
		
	}
}