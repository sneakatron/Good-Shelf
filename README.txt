=== Plugin Name ===
Contributors: richhole
Donate link: http://www.richardhole.co.uk
Tags: goodreads, reading, reading lists, books
Requires at least: 3.0.1
Tested up to: 4.22
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Goodshelf displays your goodreads shelves as a widget. Choose beween a link list and cover images.

== Description ==


Goodshelf displays your goodreads shelves as a widget. Choose beween a link list and cover images.

* Display a shelf from your Goodreads account

* choose between text links or book covers

* configure how many books are displayed

== Installation ==

* upload the good_shelf.php file to your 'wp-content/plugins' folder. 

* Activate the plugin in the '*plugins*' page

* In the '*appearance > widgets*' page of your wordpress admin, drag and drop the Goodshelf widget into your widgets area.

== Frequently Asked Questions ==

= Somone else's books are being displayed =

If your books are not appearing, then you are probably seeing mine. Please make sure that you have updated your Goddreads user ID.
Your ID can be found at the end if your good reads URL e.g. http://www.goodreads.com/user/show/1234567.

= How do I change the style? =

If you are displaying a link list, the HTML output can be styled with: ul.goodreads.
If you are displaying the cover images then the HTML output can be styled with a.goodreads_image

= Can I change the size of the image displayed? =

At present, the plugin does not have this feature, but the size can be changed in CSS using a.goodreads_image img

= Can I display the name of the Author? =

At present, this feature is not available.

= Can I remove the 'powered by Goodreads' link? =

It is within Goddreads terms of use to display a powered by link.

= I can only choose beween 'currently Reading', 'to-read' and 'read' shelves =

you have to save your widget. The aforementioned shelves are the defualt shelves that all Goodreads users start with. After you have saved your settings, all your shelves should appear in the dropdown.

== Screenshots ==

1. An example of the widget

2. An example of a link list being displayed

3. An example of the cover images being displayed

== Changelog ==

= 1.1 =

* Now has widget support. Shortcode is unsupported for the time being.

= 1.0 =

* Uses a shortcode. No widget support
