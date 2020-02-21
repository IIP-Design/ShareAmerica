=== Share This Image ===
Contributors: Mihail Barinov
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GSE37FC4Y7CEY
Tags: facebook, image, sharing, social buttons, twitter
Requires at least: 4.0
Tested up to: 5.2
Stable tag: 1.28
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Image sharing plugin for WordPress.

== Description ==

**Share selected image with customizable content!**

This plugin adds social sharing icons to each image in your site.

Share This Image is simple and flexible image sharing plugin for WordPress. It’s give you great flexibility to promoting your content in 11 most popular social networks.

[Live DEMO](https://share-this-image.com/?utm_source=wp-repo&utm_medium=listing&utm_campaign=sti-repo)

= Main Features =

* Supports 12 sharing buttons: **facebook**, **twitter**, **linkedin**, **pinterest**, **tumblr**, **WhatsApp**, **Messenger**, **reddit**, **digg**, **delicious**, **vkontakte**, **odnoclassniki**.
* **Exact sharing** - user will share exactly the same image that he wants.
* **Select what images to share**. Share all images of you site or just from several pages. Or just single images that you want. All this is possible!
* **Customize content** - fully customizable url, image, title and content that you want to share.
* **Powerfull Admin Panel** – all settings in one page.
* Build-in **shortcode** for easier work
* **Fast** - Nothing extra. Just what you need for proper work
* **Not only images** – apply it not only for image but for any block of content with specified data-media attribute.
* **Google Analytics** support
* Supports all major desktop browsers (IE8, IE9, IE10, Chrome, Firefox, Safari, Opera) and mobile browsers.

= Premium Features =

[Premium Version](https://share-this-image.com/?utm_source=wp-repo&utm_medium=listing&utm_campaign=sti-repo)

* New sharing options - **link** and **email** sharing.
* New option in admin page to **exclude all images from desired pages** from sharing.
* **Black list** option to exclude single images fom sharing.
* **Auto-scroll** your visitors to the exact location of the image they came to see.
* Set sources and their priority for shared **title** and **description**.
* Set of **styling options** - 3 predefined icons styles, horizontal or vertical view, offsets by x and y planes.
* Priority support.

== Installation ==

1. Upload share-this-image to the /wp-content/plugins/ directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How can I customize what url, image, title and description to share? =

When sharing new image for title and description plugin first of all looks in 'data-title' and 'data-summary' attributes of image.

So you can set your fully customizable content by adding this attributes. It's can look like that:

`<img src="images/youre-cool-image.jpg" data-title="Title for image" data-summary="Description for image">`

If image doesn't have data attributes then plugin will use title attribute for title and attr attribute for summary.

`<img src="images/youre-cool-image.jpg" title="Title for image" attr="Description for image">`

If image doesn't have data, title and attr attributes then will be used default title and description that you set in the plugin settings page.

Also it is possible to set shared image that can be different from image in the 'img' tag.

It's can be done with help of 'data-media' attribute:

`<img src="youre-image-to-display-on-page.jpg" data-media="youre-image-to-share.jpg">`

Also you can change shared link.

By default plugin will share link to the page where your shared image in situated. But you can simply change this behavior.

Just add 'data-url' attribute with link that you want to be shared.

`img src="images/youre-cool-image.jpg" data-url="http://your-link.com">`

= How to use plugins build-in shortcode? =

Most common there is no need to use shortcode. Plugin will automatically work with all images that you have on your site.

But with shorcode it is very simple to share desired image with custom title and description.

All you need to do is add this shortcode inside your page or post content section

`[sti_image image="http://your-image-to-display.jpg" shared_image="http://your-image-to-share.jpg" shared_title="Your-title" shared_desc="Your-Description"]`

It is very simple and don't need additional explanation.

= Is it works only with 'img' tag? =

No.

Plugin give ability to run it not only for images, but for any blocks of content.

Only one condition - this block must have data-media attribute with link to shared image.

For example - we have block with custom content inside. This block has class shared-box. So it is very easy to add sharing content for it.

`<div class="shared-box" data-media="images/youre-cool-image.jpg" data-title="Title for image" data-summary="Description for image">
   Youre custom content ( text, html or any other )
</div>`

Don't forget, that class name of block must be specified in plugin selector option. For example, if we want to share all images and this block then selector will be img, .shared-box.

That's all! After this if any of your visitors hover on block with class name shared-box he will see appeared share box with social buttons.

= I install this plugin on my local server and have issues with sharing images. What's wrong? =

In order to share images and all other data social networks must scrap data from you website page. So if your website is not publicly available data will not be scraped.

== Screenshots ==

1. Plugin settings page
2. Image sharing buttons that appears on image hover

== Changelog ==

= 1.28 =
* Add - Google Analytics support
* Update - Settings page options

= 1.27 =
* Update - Plugin settings page

= 1.26 =
* Fix - Fancyboxes support
* Fix - Sharing buttons positions

= 1.25 =
* Update - Position of sharing buttons. This must solve some issues with "twitching" images on hover
* Update - Settings page text
* Update - Settings page options

= 1.24 =
* Add - FaceBook messenger button
* Fix - Plugin text domain for translations
* Update - VK button style

= 1.23 =
* Dev - Update code structure
* Update - Settings page view

= 1.22 =
* Dev - Add sti_buttons_array filter

= 1.21 =
* Dev - Add sanitize_text_field function

= 1.20 =
* Dev - Security updates

= 1.19 =
* Fix - Bug woth relative path in data-media attribute

= 1.18 =
* Fix bug with Facebook image sharing
* Don't remove dot char from image title and description

= 1.17 =
* Remove Google+ sharing button
* Update settings page styles

= 1.16 =
* Fix bug with js source code

= 1.15 =
* Fix bug with source selection
* Update admin page styles
* Add WhatsApp button

= 1.14 =
* Add fancybox plugin support
* Add Metaslider plugin support
* Add support for Nivo slider
* Add support for Coin slider
* Update icons styles

= 1.13 =
* Fix Facebook sharing bug
* Add debug query parameter 
* Add wp caption as description sources
* Update sharing buttons styling
* Update settings page info

= 1.12 =
* Fix Facebook sharing for movile devices
* Fix Odnoklassniki sharing
* Add feature to find sharing content in child nodes

= 1.11 =
* Update Facebook settings

= 1.10 =
* Update social icons

= 1.09 =
* Add support fot Yoast Seo plugin

= 1.08 =
* Update meta tags generation

= 1.07 =
* Fix bug with special chars in options

= 1.06 =
* Update settings page

= 1.05 =
* Fix bug with sharing box offset

= 1.04 =
* Fix XSS issue

= 1.03 =
* Add og:image:width and og:image:height Open Graph tags for pre-caching shared images

= 1.02 =
* Add admin notice about local server issues

= 1.01 =
* Fix bugs
* Separated settings page

= 1.00 =
* First Release