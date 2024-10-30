=== Image Credit ===
Contributors: tylermenezes
Donate link: https://tyler.menez.es/
Tags: comments, spam
Requires at least: 3.0.0
Tested up to: 3.1.1
Stable tag: trunk

Adds a credit field for images.

== Description ==

Adds a credit field for images, added through the standard media uploader. Credit will be added directly to the image code if the image has no caption, or automatically added to the caption if one exists. Can be styled with CSS as .credit, .image-credit, or #image-credit-(ID).

== Frequently Asked Questions ==
=== I added a caption to my image and now there's two credit tags! ===
Because of the way Wordpress renders things, we need to add credit inside the caption in order for it to look reasonable. However if there is no caption, we need to add it directly into the editor. You'll need to remove the HTML manually.

=== The tag looks all weird ===
You'll need to style it manually. We recommend adding float: left, and changing the font size.

== Installation ==

1. Upload `image-credit.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. An example of a rendered credit note.
2. Interface