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
global $gantry;
?>
<?php
$doc =& JFactory::getDocument();

if (defined('GANTRY_FINALIZED')) {
    $doc = &JFactory::getDocument();
    $doc->addStyleSheet(JURI::root(true).'/templates/'.$gantry->templateName.'/css/suckerfish.css');
} else {
    $gantry->addStyle('suckerfish.css');
}

if ( ! defined('modRokNavMenuShowItemsSucker') )
{
function showItemSucker(&$item, &$menu) {
    
   global $activeid;
    
   $doc = &JFactory::getDocument();
?>
<li id="<?php echo $item->css_id;?>">
	<?php if ($item->type == 'menuitem') : ?>
		<a <?php if($item->hasLinkClasses()):?>class="<?php echo $item->getLinkClasses();?>"<?php endif;?> <?php if($item->hasLink()):?>href="<?php echo $item->getLink();?>"<?php endif;?> <?php if(isset($item->target)):?>target="<?php echo $item->target;?>"<?php endif;?> <?php if(isset($item->onclick)):?>onclick="<?php echo $item->onclick;?>"<?php endif;?><?php if($item->hasLinkAttribs()):?> <?php echo $item->getLinkAttribs();?><?php endif;?>>
			<span>
			<?php echo $item->title;?>
			<?php if (!empty($item->subtext)) :?>
			<em><?php echo $item->subtext; ?></em>    
			<?php endif; ?>   
			</span>
		</a>
	<?php elseif($item->type == 'separator') : ?>
		<span <?php if($item->hasLinkClasses()):?>class="<?php echo $item->getLinkClasses();?> nolink"<?php endif;?>>
		    <span>
		    <?php echo $item->title;?>
		    <?php if (!empty($item->subtext)) :?>
			<em><?php echo $item->subtext; ?></em>    
			<?php endif; ?>
		    </span>
		</span>
	<?php endif; ?>
	
	<?php if ($item->hasChildren()): ?>
			<ul class="level<?php echo intval($item->level)+2; ?>">
				<?php foreach ($item->getChildren() as $child) : ?>			
					<?php showItemSucker($child, $menu); ?>
				<?php endforeach; ?>
			</ul>
	<?php endif; ?>	
</li>	
<?php
} 
define('modRokNavMenuShowItemsSucker', true);
}
?>
<ul class="menutop level1" <?php if($menu->getParameter('tag_id') != null):?>id="<?php echo $menu->getParameter('tag_id');?>"<?php endif;?>>
	<?php foreach ($menu->getChildren() as $item) :  ?>
		<?php showItemSucker($item, $menu); ?>
	<?php endforeach; ?>
</ul>
