 === WordPress Category Tag Ratings ===
 
Plugin Name: WordPress Category Tag Ratings
Plugin URI: http://multidots.com/
Author: dots
Author URI: http://multidots.com/
Contributors: dots, mitraval192
Version: 1.0.4
Stable tag: 1.0.4
Tags: shortcode, simple, category, tag, post, page, rating, average
Requires at least: 3.8
Tested up to: 4.7
Donate link: 
Copyright: (c) 2015-2016 Multidots Solutions PVT LTD (info@multidots.com) 
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Very Simple, easy, developer-friendly rating plugin which can be used for pages, posts, categories & tags. 


== Description ==

The "WordPress-Category-Tag-Ratings" will be helpful for applying rating options specially on categories, tags. Developer is also able to use own custom image of rating. User will be allow to rate every where admin wants rating and also User will be able to see average ratings.

Plugin will simply generate shortcode and we can use it wherever we want to display ratings.

= You can check our other plugins: =

1. <a href ="https://store.multidots.com/go/flat-rate">Advance Flat Rate Shipping Method For WooCommerce</a>
2. <a href ="https://store.multidots.com/go/dotstore-woocommerce-blocker">WooCommerce Blocker – Prevent Fake Orders And Blacklist Fraud Customers</a>
3. <a href ="https://store.multidots.com/go/dotstore-enhanced-ecommerce-tracking">WooCommerce Enhanced Ecommerce Analytics Integration With Conversion Tracking</a>
4. <a href ="https://store.multidots.com/go/dotstore-woo-category-banner">Woocommerce Category Banner Management</a>
5. <a href ="https://store.multidots.com/go/dotstore-woo-extra-fees">Woocommerce Conditional Extra Fees</a>
6. <a href ="https://store.multidots.com/go/dotstore-woo-product-sizechart">Woocommerce Advanced Product Size Charts</a>
7. <a href ="https://store.multidots.com/go/dotstore-admenumanager-wp">Advance Menu Manager for WordPress</a>
8. <a href ="https://store.multidots.com/go/dotstore-woo-savefor-later">Woocommerce Save For Later Cart Enhancement</a>
9. <a href ="https://store.multidots.com/go/brandagency">Brand Agency- One Page HTML Template For Agency,Startup And Business</a>
10. <a href ="https://store.multidots.com/go/Meraki">Meraki One Page HTML Resume Template</a>
11. <a href ="https://store.multidots.com/go/dotstore-aapify-theme">Appify - Multipurpose One Page Mobile App landing page HTML</a>


== Installation ==

1. Upload `Wp-Category-Tag-Ratings` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the *Plugins* menu in WordPress.
3. Add the shortcode to a post or page or use in custom templates.
4. Update settings of ratins using below two interface. 
	1) Rating general settings
	2) Display rating options for templates which will be very helpful to developer about front settings of ratings.

= Usage =

There two ways to used this plugin.

1. Using PHP function.

	-> In your active theme put below function in those form where your post is being displayed
	
	-> You can also put on tag.php, category.php, single.php, post.php ,page.php and custom templates.	
	
	`<?php if(function_exists('AIO_Rating')) { AIO_Rating();}?>`

2. Using Shortcode.

	-> You can also use this Shortcode `[aio_rating id=1]`
	
	*here Id will be page id, post id ,category id or tag id.


== Frequently Asked Questions ==

== Is it possible to rate on default categories/tags and custom categories/tags? 

Here user will be able to rate on default categories/ tags. About custom categories/tags, it will be possible in next verion.
 
== Screenshots ==

1. Rating Options.
2. Rating Template.

== Upgrade Notice ==

= 1.0 =
This is the first version of the plugin so you don't need any information about upgrade.

== Changelog ==
= 1.0 =
* This is the first version of the plugin.

= 1.0.1 - 24.12.2015 =
* Tweak - Remote request handles on activate.

= 1.0.2 - 15.07.2016 =
* New - Subscription form added
* Fixes - Minor bug solved

= 1.0.3 - 30.08.2016 =
Check  WordPress and WooCommerce compatibility

= 1.0.4 - 26.12.2016 =
Check  WordPress and WooCommerce compatibility