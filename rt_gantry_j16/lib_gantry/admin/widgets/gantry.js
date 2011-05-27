/**
 * @version		3.2.4 April 20, 2011
 * @author		RocketTheme http://www.rockettheme.com
 * @copyright 	Copyright (C) 2007 - 2011 RocketTheme, LLC
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

var Gantry={init:function(){if(document.id("gantry-mega-form")){document.id("gantry-mega-form").set("autocomplete","off");}Gantry.cookie=Cookie.read("gantry-admin");Gantry.cleanance();Gantry.initTabs();Gantry.inputs();Gantry.selectedSets();Gantry.Overlay=new Gantry.Layer();Gantry.Tips.init();Gantry.notices();Gantry.badges();Gantry.toolbarButtons();Gantry.loadDefaults();},load:function(){},toolbarButtons:function(){var buttons=$$("#toolbar li[id!=toolbar-delete-style][id!=toolbar-help][class!=divider]");buttons.each(function(button){if(button.id=="toolbar-apply"){return;}var a=button.getElement("a");var onclick=a.get("onclick").replace("javascript:","");a.onclick=function(){};a.removeProperty("onclick");if(button.id!="toolbar-new-style"){a.addEvent("click",function(e){if(a.getElement("span").hasClass("toolbar-inactive")){e.stop();}else{if(button.id!="toolbar-purge"){eval(onclick);}}});}});var apply=document.id("toolbar-apply");if(apply){var otherButtons=buttons.clone().filter(function(button){return button.id!=apply.id;});var form=document.id("template-form");var currentAction=null;var req=new Request({url:GantryAjaxURL,method:"post",onRequest:function(){currentAction.addClass("spinner");},onSuccess:function(response){currentAction.removeClass("spinner");$$(otherButtons).getElement("span").removeClass("toolbar-inactive");$$(otherButtons).removeClass("disabled");Gantry.NoticeBox.getElement("li").set("html",response);Gantry.NoticeBoxFx.start("opacity",[0,1]);}});apply.getElement("a").onclick=function(){};apply.getElement("a").removeProperty("onclick");apply.addEvent("click",function(e){e.stop();currentAction=apply;$$(otherButtons).getElement("span").addClass("toolbar-inactive");$$(otherButtons).addClass("disabled");var query=form.toQueryString().parseQueryString();Object.each(query,(function(value,key){if(key.contains("[]")){delete query[key];query[key.replace("[]","")]=(typeof value=="string")?[value]:value;}}));req.post(Object.merge(query,{model:"template-save",action:"save",task:"ajax"}));});}var reset=document.id("toolbar-purge");if(reset){reset.addEvent("click",function(e){e.stop();if(Gantry.defaults){var field;Gantry.defaults.each(function(value,key){field=document.id(key);if(field){if(field.className.contains("toggle-input")){field.getParent(".toggle-container").fireEvent("mouseenter");field.fireEvent("set",[field.retrieve("details"),value]);}else{field.getParent().fireEvent("mouseenter");field.fireEvent("set",value);}}});Gantry.NoticeBox.getElement("li").set("html","Fields have been reset to default values.");Gantry.NoticeBoxFx.start("opacity",[0,1]);}});}},notices:function(){Gantry.NoticeBox=document.id("system-message");var b=Gantry.NoticeBox.getElement(".close");if(b){Gantry.NoticeBoxFx=new Fx.Tween(Gantry.NoticeBox,{duration:200,link:"ignore",onStart:function(){Gantry.NoticeBox.setStyle("display","block");}});b.addEvent("click",function(){Gantry.NoticeBoxFx.start("opacity",0).chain(function(){Gantry.NoticeBox.setStyle("display","none");});});}var a=$$(".overrides-button.button-del");a.addEvent("click",function(d){var c=confirm(GantryLang.are_you_sure);if(!c){d.stop();}});},dropdown:function(){var b=document.id("overrides-inside"),e=document.id("overrides-first"),c=null;var a=new Fx.Slide("overrides-inside",{duration:100,onStart:function(){var g=document.id("overrides-actions").getSize().x-4;b.setStyle("width",g);this.wrapper.setStyle("width",g+4);},onComplete:function(){if(!this.open){e.removeClass("slide-down");}}}).hide();b.setStyle("display","block");var d=function(){if(b.hasClass("slidedown")){a.slideIn();e.addClass("slide-down");}};var f=function(){if(b.hasClass("slideup")){a.slideOut();}};$$("#overrides-toggle, #overrides-inside").addEvents({mouseenter:function(){$clear(c);b.removeClass("slideup").addClass("slidedown");c=d();},mouseleave:function(){$clear(c);b.removeClass("slidedown").addClass("slideup");f.delay(300);}});Gantry.dropdownActions();},dropdownActions:function(){var g=document.id("overrides-actions"),e=document.id("overrides-toolbar"),f=document.id("overrides-first");var a=document.id("overrides-toggle");if(e){var d=e.getElement(".button-add"),b=e.getElement(".button-del"),c=e.getElement(".button-edit");if(c){c.addEvent("click",function(){if(f.getElement("input")){f.getElement("input").empty().dispose();a.removeClass("hidden");return;}a.addClass("hidden");var h=new Element("input",{type:"text","class":"add-edit-input",value:f.get("text").clean().trim()});h.addEvent("keydown",function(k){if(k.key=="esc"){this.empty().dispose();a.removeClass("hidden");}else{if(k.key=="enter"){k.stop();var j=document.id("overrides-inside").getElements("a");var i=j.get("text").indexOf(this.value);if(i!=-1){this.highlight("#ff4b4b","#fff");return;}document.getElement("input[name=override_name]").set("value",this.value);i=j.get("text").indexOf(f.get("text").clean().trim());if(i!=-1){j[i].set("text",this.value);}this.empty().dispose();a.removeClass("hidden");f.getElement("a").set("text",this.value);}}});h.inject(f,"top").focus();});}}},inputs:function(){var a=$$(".text-short, .text-medium, .text-long, .text-color");a.addEvents({attach:function(){this.removeClass("disabled");},detach:function(){this.addClass("disabled");},set:function(b){this.value=b;},keydown:function(b){if(this.hasClass("disabled")){b.stop();return;}},focus:function(){if(this.hasClass("disabled")){this.blur();}},keyup:function(b){if(this.hasClass("disabled")){b.stop();return;}}});},selectedSets:function(){var b=$$(".selectedset-switcher select");var a=$$(".selectedset-enabler input[id]");b.each(function(d,c){d.store("gantry:values",d.getElements("option").get("value"));d.addEvent("change",function(){this.retrieve("gantry:values").each(function(f){var e=document.id("set-"+f);if(e&&a[c].value.toInt()){e.removeClass("selectedset-hidden-field");e.setStyle("display",(f==this.value)?"block":"none");}},this);});});a.each(function(d,c){d.store("gantry:values",b[c].retrieve("gantry:values"));d.addEvent("onChange",function(){this.retrieve("gantry:values").each(function(f){var e=document.id("set-"+f);if(e){if(!this.value.toInt()){e.setStyle("display","none");}else{e.removeClass("selectedset-hidden-field");e.setStyle("display",(f==b[c].get("value"))?"block":"none");}}},this);});});},cleanance:function(){Gantry.overridesBadges();Gantry.tabs=[];Gantry.panels=[];var e=document.getElement(".pane-sliders")||document.getElement("#gantry-panel");var g=e.getChildren();var c=g.getElement(".panelform");Gantry.tabs=document.getElements("#gantry-tabs li");if(!a){var a=document.getElement(".gantry-wrapper");}if(!d){var d=document.getElement("#gantry-panel");}var i=document.getElements("#widget-list .widget .widget-top, #wp_inactive_widgets .widget .widget-top");if(i.length){i.each(function(l){var k=l.getParent();if(k.id.contains("gantrydivider")){k.addClass("gantry-divider");}});}var b=c.getElements(".inner-tabs ul li").flatten();var h=c.getElements(".inner-panels .inner-panel").flatten();b=$$(b);h=$$(h);b.each(function(l,k){l.addEvents({mouseenter:function(){this.addClass("hover");},mouseleave:function(){this.removeClass("hover");},click:function(){$$(h).setStyle("position","absolute");h.fade("out");h[k].setStyles({position:"relative","float":"left",top:0,"z-index":5}).fade("in");b.removeClass("active");this.addClass("active");}});});Gantry.panels=$$(".gantry-panel");Gantry.wrapper=a;Gantry.container=d;Gantry.tabs=$$(Gantry.tabs);var f=document.id("cache-clear-wrap");if(f){var j=new Asset.image("images/wpspin_dark.gif",{onload:function(){this.setStyles({display:"none"}).addClass("ajax-loading").inject(f,"top");}});f.addEvent("click",function(k){k.stop();new Request.HTML({url:AdminURI,onRequest:function(){f.addClass("disabled");j.setStyle("display","block");},onSuccess:function(){window.location.reload();}}).post({action:"gantry_admin",model:"cache",gantry_action:"clear"});});}},overridesBadges:function(){$$(".overrides-involved").filter(function(a){return a.get("text").trim().clean().toInt();}).setStyles({display:"block",opacity:1});},initTabs:function(){var a=0;Gantry.panels.setStyle("position","absolute");var b=document.getElement("#gantry-panel .active-panel");(b||Gantry.panels[0]).setStyle("position","relative");Gantry.panels.set("tween",{duration:"short",onComplete:function(){if(!this.to[0].value){this.element.setStyle("display","none");}}});Gantry.panels.each(function(d,e){var c=d.retrieve("gantry:height");Gantry.tabs[e].addEvents({mouseenter:function(){this.addClass("hover");},mouseleave:function(){this.removeClass("hover");},click:function(){Cookie.write("gantry-admin-tab",e);if(this.hasClass("active")){return;}$$(Gantry.panels).removeClass("active-panel").setStyle("display","none");d.addClass("active-panel");Gantry.panels.setStyle("position","absolute");Gantry.panels.setStyles({visibility:"hidden",opacity:0,"z-index":5,display:"none"});d.set("morph",{duration:330});d.setStyles({display:"inline-block",position:"relative",top:-20,"z-index":15}).morph({top:0,opacity:1});Gantry.tabs.removeClass("active");this.addClass("active");}});});},badges:function(){var d=$$("#menu-assignment input[type=checkbox][disabled!=disabled]");var a=$$("button.jform-rightbtn");var b=$$(".menuitems-involved span");if(d.length&&b.length){b=b[0];var c=b.get("html").clean().toInt();d.addEvent("click",function(){if(this.checked){c+=1;}else{c-=1;}b.set("html",c);});}if(a.length){a=a[0];a.addEvent("click",function(){var e=$$("#menu-assignment input[type=checkbox][disabled!=disabled]");if(e.length){e=e.filter(function(f){return f.checked;});c=e.length;b.set("html",c);}});}},loadDefaults:function(){Gantry.defaultsXHR=new Request({url:GantryAjaxURL,onSuccess:function(a){Gantry.defaults=new Hash(JSON.decode(a));}}).post({model:"overrides",action:(GantryIsMaster)?"get_default_values":"get_base_values"});}};Gantry.Tips={init:function(){var a=$$(".gantry-panel"),b;if(document.id(document.body).getElement(".defaults-wrap")){b=a.getElements(".gantry-panel-left .gantry-field > label:not(.rokchecks), .gantry-panel-left .gantry-field span[class!=chain-label][class!=group-label] > label:not(.rokchecks)");}else{b=a.getElements(".gantry-panel-left .gantry-field .base-label label");}b.each(function(c,d){if(c.length){c.addEvent("mouseenter",function(){var g=c.indexOf(this);var e=a[d];if(e){var h=(!this.id)?false:"tip-"+this.id.replace(GantryParamsPrefix,"").replace(/-lbl$/,"");var f=e.getElement(".gantrytips-left");if(f){if(!h){f.fireEvent("jumpTo",1);}else{f.fireEvent("jumpById",h);}}}});}});}};Gantry.Layer=new Class({Implements:[Events,Options],options:{duration:200,opacity:0.8},initialize:function(b){var a=this;this.setOptions(b);this.id=new Element("div",{id:"gantry-layer"}).inject(document.body);this.fx=new Fx.Tween(this.id,{duration:this.options.duration,wait:false,onComplete:function(){if(!this.to[0].value){a.open=false;}else{a.open=true;a.fireEvent("show");}}}).set("opacity",0);this.open=false;},show:function(){this.calcSizes();this.fx.start("opacity",this.options.opacity);},hide:function(){this.fireEvent("hide");this.fx.start("opacity",0);},toggle:function(){this[this.open?"hide":"show"]();},calcSizes:function(){this.id.setStyles({width:window.getScrollSize().x,height:window.getScrollSize().y});}});window.addEvent("domready",Gantry.init);