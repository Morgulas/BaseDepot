/**
 * @version		3.2.4 April 20, 2011
 * @author		RocketTheme http://www.rockettheme.com
 * @copyright 	Copyright (C) 2007 - 2011 RocketTheme, LLC
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

window.addEvent("domready",function(){var b=document.id("gantry-totop");if(b){var a=new Fx.Scroll(window);b.setStyle("outline","none").addEvent("click",function(c){c.stop();a.toTop();});}});