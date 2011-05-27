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
if (!class_exists('FusionScriptLoader')) {
	class FusionScriptLoader {
		function loadScripts(&$menu)
		{
			global $gantry, $isJSEnabled, $isPillEnabled;

			$enablejs = $menu->getParameter('enable_js', '1');
			$opacity = $menu->getParameter('opacity', 1);
			$effect = $menu->getParameter('effect', 'slidefade');
			$hidedelay = $menu->getParameter('hidedelay', 500);
			$menu_animation = $menu->getParameter('menu-animation', 'Quad.easeOut');
			$menu_duration = $menu->getParameter('menu-duration', 400);
			$pill = $menu->getParameter('pill-enabled', 0);
			$pill_animation = $menu->getParameter('pill-animation', 'Back.easeOut');
			$pill_duration = $menu->getParameter('pill-duration', 400);
			$tweakInitial_x = $menu->getParameter('tweak-initial-x', '0');
			$tweakInitial_y = $menu->getParameter('tweak-initial-y', '0');
			$tweakSubsequent_x = $menu->getParameter('tweak-subsequent-x', '0');
			$tweakSubsequent_y = $menu->getParameter('tweak-subsequent-y', '0');
			$widthCompensation = $menu->getParameter('tweak-width', '0');
			$heightCompensation = $menu->getParameter('tweak-height', '0');
			$centeredOffset = $menu->getParameter('centered-offset', '0');

			if ($enablejs != '1' && $enablejs != 1) $isJSEnabled = 'nojs';
			if ($pill != '1' && $pill != 1) $isPillEnabled = false;
			else $isPillEnabled = true;

			if ($effect == 'slidefade') $effect = "slide and fade";

			if ($gantry->browser->name == 'ie' && $effect == 'slide and fade') $effect = "slide";

		    if ($enablejs) {
				$gantry->addScript($gantry->baseUrl.'modules/mod_roknavmenu/themes/fusion/js/fusion.js');

		        $initialization = "
		        window.addEvent('load', function() {
					new Fusion('ul.menutop', {
						pill: $pill,
						effect: '$effect',
						opacity: $opacity,
						hideDelay: $hidedelay,
						centered: $centeredOffset,
						tweakInitial: {'x': ".$tweakInitial_x.", 'y': ".$tweakInitial_y."},
        				tweakSubsequent: {'x': ".$tweakSubsequent_x.", 'y': ".$tweakSubsequent_y."},
						tweakSizes: {'width': ".$widthCompensation.", 'height': ".$heightCompensation."},
						menuFx: {duration: $menu_duration, transition: Fx.Transitions.$menu_animation},
						pillFx: {duration: $pill_duration, transition: Fx.Transitions.$pill_animation}
					});
	            });";
	            $gantry->addInlineScript($initialization);
	        }
		}
	}
}

FusionScriptLoader::loadScripts($menu);

global $activeid, $isJSEnabled, $isPillEnabled;
$activeid = $menu->getParameter('enable_current_id',0) == 0 ? false : true;

if (defined('GANTRY_FINALIZED')) {
    $doc = &JFactory::getDocument();
    $doc->addStyleSheet(JURI::root(true).'/templates/'.$gantry->templateName.'/css/fusionmenu.css');
} else {
    $gantry->addStyle('fusionmenu.css');
}

if (!defined('modRokNavMenuShowItemsFusion')) {

    function getModule ($id=0, $name='') {

        $modules	=& JModuleHelper::_load();
        $total		= count($modules);
        for ($i = 0; $i < $total; $i++)
        {
            // Match the name of the module
            if ($modules[$i]->id == $id || $modules[$i]->name == $name)
            {
                return $modules[$i];
            }
        }
        return null;
    }

    function getModules ($position) {
        $modules = JModuleHelper::getModules ($position);
        return $modules;
    }

    function array_chunkd(array $array, $chunk)
    {
        if ($chunk === 0)
            return $array;

        // number of elements in an array
        $size = count($array);

        // average chunk size
        $chunk_size = $size / $chunk;

        // calculate how many not-even elements eg in array [3,2,2] that would be element "3"
        $real_chunk_size = floor($chunk_size);
        $diff = $chunk_size - $real_chunk_size;
        $not_even = $diff > 0 ? round($chunk * $diff) : 0;

        // initialise values for return
        $result = array();
        $current_chunk = 0;

        foreach ($array as $key => $element)
        {
            $count = isset($result[$current_chunk]) ? count($result[$current_chunk]) : 0;

            // move to a new chunk?
            if ($count == $real_chunk_size && $current_chunk >= $not_even || $count > $real_chunk_size && $current_chunk < $not_even)
                $current_chunk++;

            // save value
            $result[$current_chunk][$key] = $element;
        }

        return $result;
    }

    function calculate_sizes (array $array)
    {
        return implode(', ', array_map('count', $array));
    }

	function showItemFusion(&$item, &$menu) {
	   global $activeid, $gantry;

        $wrapper_css = '';
        $ul_css = '';
        $group_css = '';

	    //get columns count for children
	    $columns = $item->getParameter('fusion_columns',1);
	    //get custom image
	    $custom_image = $item->getParameter('fusion_customimage');
        $custom_class = $item->getParameter('fusion_customclass');

	    if ($custom_image && $custom_image != -1) $item->addLinkClass('image');
	    else $item->addLinkClass('bullet');
        if ($custom_class != '') $item->addListItemClass($custom_class);

        $dropdown_width = $item->getParameter('fusion_dropdown_width');
        $column_widths = explode(",",$item->getParameter('fusion_column_widths'));


        if (trim($columns)=='') $columns = 1;
        if (trim($dropdown_width)=='') $dropdown_width = 180;

        $wrapper_css = ' style="width:'.trim($dropdown_width).'px;"';

        $col_total = 0;$cols_left=$columns;
        if (trim($column_widths[0] != '')) {
            for ($i=0; $i < $columns; $i++) {
                if (isset($column_widths[$i])) {
                    $ul_css[] = ' style="width:'.trim($column_widths[$i]).'px;"';
                    $col_total += $column_widths[$i];
                    $cols_left--;
                } else {
                    $col_width = floor(intval((intval($dropdown_width) - $col_total) / $cols_left));
                    $ul_css[] = ' style="width:'.$col_width.'px;"';
                }
            }
        } else {
            for ($i=0; $i < $columns; $i++) {
                $col_width = floor(intval($dropdown_width)/$columns);
                $ul_css[] = ' style="width:'.$col_width.'px;"';
            }
        }

	    $grouping = $item->getParameter('fusion_children_group');
        if ($grouping == 1) $item->addListItemClass('grouped-parent');

	    $child_type = $item->getParameter('fusion_children_type');
        $child_type = $child_type == '' ? 'menuitems' : $child_type;

        $modules = array();
        if ($child_type == 'modules') {
            $modules_id = $item->getParameter('fusion_modules');

            $ids = is_array($modules_id) ? $modules_id : array($modules_id);
            foreach ($ids as $id) {
                if ($module = getModule ($id)) $modules[] = $module;
            }
            $group_css = ' type-module';

        } elseif ($child_type == 'modulepos') {
            $modules_pos = $item->getParameter('fusion_module_positions');

            $positions = is_array($modules_pos) ? $modules_pos : array($modules_pos);
            foreach ($positions as $pos) {
                $mod = getModules ($pos);
                $modules = array_merge ($modules, $mod);
            }
            $group_css = ' type-module';
        }

	    //not so elegant solution to add subtext
	    $item->subtext = $item->getParameter('fusion_item_subtext','');
	    if ($item->subtext=='') $item->subtext = false;
	    else $item->addLinkClass('subtext');

       //sort out module children:
       if ($child_type!="menuitems") {
            $document	= &JFactory::getDocument();
            $renderer	= $document->loadRenderer('module');
            $params		= array('style'=>'fusion');

            $mod_contents = array();
            foreach ($modules as $mod)  {

                $mod_contents[] = $renderer->render($mod, $params);
            }
            $item->_children = $mod_contents;
            //replace orphan with daddy if needed
            if ($item->hasChildren() && in_array('orphan',$item->_a_classes) ) {
                $item->_a_classes[array_search ('orphan',$item->_a_classes)] = 'daddy';
    		}
       }
	?>
	<li <?php if($item->hasListItemClasses()) : ?>class="<?php echo $item->getListItemClasses()?>"<?php endif;?> <?php if(isset($item->css_id) && $activeid):?>id="<?php echo $item->css_id;?>"<?php endif;?>>
        <?php if ($item->type == 'menuitem') : ?>
			<a <?php if($item->hasLinkClasses()):?>class="<?php echo $item->getLinkClasses();?>"<?php endif;?> <?php if($item->hasLink()):?>href="<?php echo $item->getLink();?>"<?php endif;?> <?php if(isset($item->target)):?>target="<?php echo $item->target;?>"<?php endif;?> <?php if(isset($item->onclick)):?>onclick="<?php echo $item->onclick;?>"<?php endif;?><?php if($item->hasLinkAttribs()):?> <?php echo $item->getLinkAttribs();?><?php endif;?>>
				<span>
			    <?php if ($custom_image && $custom_image != -1) :?>
			        <img src="<?php echo $gantry->templateUrl."/images/icons/".$custom_image; ?>" alt="<?php echo $custom_image; ?>" />
			    <?php endif; ?>
				<?php echo $item->title;?>
				<?php if (!empty($item->subtext)) :?>
				<em><?php echo $item->subtext; ?></em>
				<?php endif; ?>
				</span>
			</a>
		<?php elseif($item->type == 'separator') : ?>
			<span <?php if($item->hasLinkClasses()):?>class="<?php echo $item->getLinkClasses();?> nolink"<?php endif;?>>
			    <span>
			        <?php if ($custom_image && $custom_image != -1) :?>
	    		        <img src="<?php echo $gantry->templateUrl."/images/icons/".$custom_image; ?>" alt="<?php echo $custom_image; ?>" />
	    		    <?php endif; ?>
			    <?php echo $item->title;?>
			    <?php if (!empty($item->subtext)) :?>
				<em><?php echo $item->subtext; ?></em>
				<?php endif; ?>
			    </span>
			</span>
		<?php endif; ?>

        <?php if ($item->hasChildren()): ?>
            <?php if ($grouping == 0 or $item->level == 0) :
                if ($item->getParameter('fusion_distribution')=='inorder') {
                    $count = sizeof($item->_children);
                    $items_per_col = intval(ceil($count / $columns));
                    $children_cols = array_chunk($item->_children,$items_per_col);
                } else {
                    $children_cols = array_chunkd($item->_children,$columns);
                }
                $col_counter = 0;
                ?>
                <div class="fusion-submenu-wrapper level<?php echo intval($item->level)+2; ?><?php if ($columns > 1) echo ' columns'.$columns; ?>"<?php echo $wrapper_css; ?>>
                    <?php foreach($children_cols as $col) : ?>

                    <ul class="level<?php echo intval($item->level)+2; ?>"<?php echo $ul_css[$col_counter++]; ?>>
                        <?php foreach ($col as $child) : ?>
                            <?php if ($child_type=='menuitems'): ?>
                                <?php showItemFusion($child, $menu); ?>
                            <?php else: ?>
                                <li>
                                    <div class="fusion-modules item">
                                    <?php echo ($child); ?>
                                    </div>

                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>

                    <?php endforeach;?>
                    <div class="drop-bot"></div>
                </div>
            <?php else : ?>
                <div class="fusion-grouped<?php echo $group_css; ?>">
                    <ol>
                        <?php foreach ($item->getChildren() as $child) : ?>
                            <?php if ($child_type=='menuitems'): ?>
                                <?php showItemFusion($child, $menu); ?>
                            <?php else: ?>
                                <li>
                                    <div class="fusion-modules item">
                                    <?php echo ($child); ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ol>
                </div>

            <?php endif; ?>
        <?php endif; ?>
	</li>
	<?php
	}
		define('modRokNavMenuShowItemsFusion', true);
	}
?>
<?php if (!$isPillEnabled): ?>
<div class="nopill">
<?php endif; ?>
	<ul class="menutop level1 <?php echo $isJSEnabled; ?>" <?php if($menu->getParameter('tag_id') != null):?>id="<?php echo $menu->getParameter('tag_id');?>"<?php endif;?>>
		<?php foreach ($menu->getChildren() as $item) :  ?>
			<?php showItemFusion($item, $menu); ?>
		<?php endforeach; ?>
	</ul>
<?php if (!$isPillEnabled): ?>
</div>
<?php endif; ?>