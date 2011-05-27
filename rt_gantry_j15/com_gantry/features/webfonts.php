<?php
/**
 * @package     gantry
 * @subpackage  features
 * @version		3.1.4 November 12, 2010
 * @author		RocketTheme http://www.rockettheme.com
 * @copyright 	Copyright (C) 2007 - 2010 RocketTheme, LLC
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */

defined('JPATH_BASE') or die();

gantry_import('core.gantryfeature');

/**
 * @package     gantry
 * @subpackage  features
 */
class GantryFeatureWebFonts extends GantryFeature {

    var $_feature_name = 'webfonts';

    var $_google_fonts = array("Allan", "Allerta", "Allerta Stencil", "Amaranth", "Annie Use Your Telescope", "Anonymous Pro", "Anton", "Architects Daughter", "Arimo", "Arvo", "Astloch", "Bangers", "Bentham", "Bevan", "Buda", "Cabin", "Cabin Sketch", "Calligraffitti", "Candal", "Cantarell", "Cardo", "Cherry Cream Soda", "Chewy", "Coda", "Coming Soon", "Copse", "Corben", "Cousine", "Covered By Your Grace", "Crafty Girls", "Crimson Text", "Crushed", "Cuprum", "Dancing Script", "Dawning of a New Day", "Droid Sans", "Droid Sans Mono", "Droid Serif", "EB Garamond", "Expletus Sans", "Fontdiner Swanky", "Geo", "Goudy Bookletter 1911", "Gruppo", "Homemade Apple", "IM Fell", "Inconsolata", "Indie Flower", "Irish Grover", "Josefin Sans", "Josefin Slab", "Just Another Hand", "Just Me Again Down Here", "Kenia", "Kranky", "Kreon", "Kristi", "Lato", "League Script", "Lekton", "Lobster", "Luckiest Guy", "Maiden Orange", "Meddon", "MedievalSharp", "Merriweather", "Michroma", "Miltonian", "Molengo", "Mountains of Christmas", "Neucha", "Neuton", "Nobile", "Nova", "OFL Sorts Mill Goudy TT", "Old Standard TT", "Orbitron", "Oswald", "PT Sans", "PT Serif", "Pacifico", "Permanent Marker", "Philosopher", "Puritan", "Quattrocento", "Radley", "Raleway", "Reenie Beanie", "Rock Salt", "Schoolbell", "Six Caps", "Slackey", "Sniglet", "Sue Ellen Francisco", "Sunshiney", "Syncopate", "Tangerine", "Terminal Dosis Light", "Tinos", "Ubuntu", "UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "VT323", "Vibur", "Vollkorn", "Waiting for the Sunrise", "Walter Turncoat", "Yanone Kaffeesatz");

    function init() {
        global $gantry;

        $font_family = $gantry->get('font-family');
        
        // Added to setect whether to use HTTP or HTTPS:
        $mode = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
 
        // Only Google at this point
        if ($this->get('source') == "google" && in_array($font_family,$this->_google_fonts)) {
 
        	// Modified to use the HTTP/HTTPS $mode defined earlier:
            $gantry->addStyle($mode.'://fonts.googleapis.com/css?family='.str_replace(" ","+",$font_family));
            $gantry->addInlineStyle("h1, h2 { font-family: '".$font_family."', 'Helvetica', arial, serif; }");
        }

    }

}