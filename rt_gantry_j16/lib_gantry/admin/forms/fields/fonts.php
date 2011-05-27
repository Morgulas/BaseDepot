<?php
/**
 * @version   3.2.4 April 20, 2011
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2011 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
defined('GANTRY_VERSION') or die;

gantry_import('core.config.gantryformfield');

require_once(dirname(__FILE__).'/selectbox.php');


class GantryFormFieldFonts extends GantryFormFieldSelectBox {
    /**
     * The form field type.
     *
     * @var        string
     * @since    1.6
     */
    protected $type = 'fonts';
    protected $basetype = 'select';

    var $_google_fonts = array("Allan", "Allerta", "Allerta Stencil", "Anonymous Pro", "Arimo", "Arvo", "Bentham", "Buda", "Cabin", "Calligraffitti", "Cantarell", "Cardo", "Cherry Cream Soda", "Chewy", "Coda", "Coming Soon", "Copse", "Corben", "Cousine", "Covered By Your Grace", "Crafty Girls", "Crimson Text", "Crushed", "Cuprum", "Droid Sans", "Droid Sans Mono", "Droid Serif", "Fontdiner Swanky", "Geo", "Gruppo", "Homemade Apple", "IM Fell", "Inconsolata", "Irish Growler", "Josefin Sans", "Josefin Slab", "Just Another Hand", "Just Me Again Down Here", "Kenia", "Kranky", "Kristi", "Lato", "Lekton", "Lobster", "Luckiest Guy", "Merriweather", "Molengo", "Mountains of Christmas", "Neucha", "Neuton", "Nobile", "OFL Sorts Mill Goudy TT", "Old Standard TT", "Orbitron", "PT Sans", "Permanent Marker", "Philosopher", "Puritan", "Raleway", "Reenie Beanie", "Rock Salt", "Schoolbell", "Slackey", "Sniglet", "Sunshiney", "Syncopate", "Tangerine", "Tinos", "Ubuntu", "UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Vibur", "Vollkorn", "Walter Turncoat", "Yanone Kaffeesatz");

    protected function getOptions() {
        global $gantry;
        $options = array();
        $options = parent::getOptions();

		if (!defined("GANTRY_FONTS")) {
			$gantry->addScript($gantry->gantryUrl.'/admin/widgets/fonts/js/fonts.js');
			$gantry->addDomReadyScript("GantryFonts.init('webfonts_enabled', 'webfonts_source', 'font_family');");
			define("GANTRY_FONTS", 1);
		}


		// only google right now
		if ($gantry->get('webfonts-source') == 'google') {
			$webfonts = $this->_google_fonts;
		}
		
		if ($gantry->get('webfonts-enabled')) $disabled = false;
		else $disabled = true;
		
		foreach ($webfonts as $webfont) {
			$webfontsData = $webfont;
			$webfontsValue = $webfont;

			$text = $webfontsData;
			
			// Create a new option object based on the <option /> element.
			$tmp = GantryHtmlSelect::option((string) $webfontsValue, JText::_(trim((string) $text)), 'value', 'text', $disabled);

			// adding reference source class
			if (in_array($webfont, $this->_google_fonts)) $option['class'] = 'google';
			else $option['class'] = 'native';
			
			// Set some option attributes.
			$tmp->class = (string) $option['class'];

			// Set some JavaScript option attributes.

			$tmp->onclick = isset($option['onclick'])?(string) $option['onclick']:'';

			// Add the option object to the result set.
			$options[] = $tmp;
		}
		
        return $options;
    }
}
