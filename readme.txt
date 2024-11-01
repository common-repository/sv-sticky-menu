=== SV Sticky Menu ===
Contributors: andreysv
Tags: menu, sticky, top, transiton, fixed
Requires at least: 4.0
Tested up to: 4.8
Stable tag: 1.0.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

SV Sticky Menu is WordPress\'s plugin that create sticky menu on top of page. Plugin helps easy and quickly set menu as sticky with transition.

== Description ==

Small but functional plugin for transforming horizontal top menu to fixed on top when scrolling. Plugin supports dynamic responsive content, dynamicly stop and restore functionality. Can hide other objects when converting, i.e. the sticked menu can look different. 

Identification of sticked object based on CSS selector.

= Features =

* The ability to exclude objects when the menu is sticked. This makes it possible to create a different display of menus in different states.
* In the sticked menu, you can add a logo image with a link.
* To transform from one state to another have been created a series of animations that you can select in the settings.
* In the settings, you can change the background color for a sticked menu, which will further distinguish its two states. Also in the settings you can specify the presence and color of a shadow for a sticked menu. This will give the site a more three-dimensional look.

= Settings list =

* **CSS Selector class or id** - Main field for set the identifier of class name in CSS standard. By default in themes 'Twenty Ten' or 'Twenty Fourteen' used '.navbar'.
* **CSS Selector for hiding objects** - Field for set the identifier(s) of class(es) in CSS standard for objects that need hide while menu is sticky.
* **Set background color** - Checkbox for activating the background color.
* **Background color of sticky object** - The control for selecting the background color if it is activated. 
* **Opacity** - Opacity of the sticked menu.
* **Minimum media width** - Field for set media width for deactivating sticking menu in responsive themes.
* **Select transition** - Field for selecting transition type from the list. Now plugin support five transition: Slide, Fade, Scale, Rotate, Skew and Custom. For Custom transition plugin includes file plugins/sv-sticky-menu/css/style.css. As examples this file has some preset transitions but you can include yours own.
* **Start position** - Field used for Slide transition and indicated start sliding position. By default starting position is -55 pixels.
* **Transition time** - Field to set the time of transition. By default 0.4 second.
* **Z-index of object** - In several cases menu can hide benease other objects. Thet's mean that z-index menu is to low. By default this field has value 99.
* **Show shadow** - Checkbox for activating the menu shadow.
* **Shadow color** - The control for selecting the shadow color if it is activated. 
* **Shadow opacity** - The control for input of the shadow opacity. 
* **Show logo** - Checkbox for activating the logo in the sticked menu.
* **Logo image** - The control for selecting the logo image from media library.
* **Logo height** - The control for set the logo image height.
* **Logo URL** - The control for set the logo URL.

= Themes where plugin was tested =

The plugin has been tested with several themes: 
* Twenty Ten 	     2.3
* Twenty Fourteen    2.0
* Storefront         2.2.3
* Bluestreet         1.2.2
* Rara Academic      1.0.8
* Bakes And Cakes    1.1.1
* Wallstreet         1.7.7.4

= Tested on =

* PC Chrome
* PC Firefox
* PC Opera
* PC IE11

== Installation ==

Automatic installation

1. Log into your WordPress admin
1. Click __Plugins__
1. Click __Add New__
1. Search for __SV Sticky Menu__
1. Click __Install Now__ under "SV Sticky Menu"
1. Activate the plugin

Manual installation:

1. Download the plugin
1. Extract the contents of the zip file
1. Upload the contents of the zip file to the wp-content/plugins/ folder of your WordPress installation
1. Then activate the Plugin from Plugins page.

== Frequently Asked Questions ==

= I installed **SV Sticky Menu**, what now? =

Open the **Settings** menu, then open **SV Sticky Menu** then input menu identifier or class into **CSS Selector class or id**.

= How to find menu identifier? =

Open your site in FireFox, press F12 and click tools button **Pick an element from page**, then pick you menu. In **Inspector** tab of debug window you will see the element class or identifier (id).
For another browsers this process is similar.

= Plugin is not working =

Please disable all plugins and check if sticky menu plugin is working properly. Then you can enable all plugins one by one to find out which plugin is conflicting with SV Sticky Menu plugin.

== Screenshots ==
1. Sample of the plugin functionality.
2. Screenshot of the options page.

== Changelog ==

= 1.0.0 =
* Release of the plugin.

= 1.0.1 =
* The custom transition type was added.
* In the css/style.css was added several samples for custom transition.
* Client java script was improved.

= 1.0.2 =
* BUG FIXED: Selection of transition was corrected.

= 1.0.3 =
* BUG FIXED: Opacity parameter setting was corrected.
* Script was minified.

= 1.0.4 =
* BUG FIXED: Opacity transition was corrected.

= 1.0.5 =
* Added hover opacity change to full opacity.

== Upgrade Notice ==

= 1.0.0 =

= 1.0.1 =
The custom transition type was added. Now you can add any animation for sticky menu.

= 1.0.2 =
BUG FIXED: Selection of transition was corrected.

= 1.0.3 =
BUG FIXED: Opacity parameter setting was corrected.
Script was minified.

= 1.0.4 =
BUG FIXED: Opacity transition was corrected.

= 1.0.5 =
Added hover opacity change to full opacity.