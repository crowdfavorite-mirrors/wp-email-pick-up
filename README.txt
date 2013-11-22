=== Email Pick Up ===
Contributors: circlewaves-team
Donate link: http://circlewaves.com/hire-us/
Tags: email, marketing, email-marketing, opt-in, subscribe, capture, promotion, landing page, coming soon
Requires at least: 3.5.1
Tested up to: 3.7
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Capture email addresses, useful for landing pages, insert opt-in form into post or page using shortcode, create multiple lists, export emails to CSV

== Description ==

This plugin allow you create simple and powerful landing pages with email capture form.
Will be useful to promote your products, "Coming soon" pages and create multiple subscribers lists for your newsletters.

**Features:**

* Easy and flexible
* Shortcode ready
* User-friendly interface integrated in WordPress Visual Editor
* Fully customizable
* CSV Export
* Multiple subscribers lists
* Subscribers statistics
* Print subscribers list directly from your wp-admin

**Add Form to pages and posts**

Use special button in WordPress Visual Editor or use shortcode [emailpickup]

You can customize each form using shortcode options.

For example, hide input label and add input placeholder:
[emailpickup hide_label="yes" placeholder="Enter your email"]

**List of all options:**

* hide_label - yes/no, default 'no'
* label_text - text, default 'Your E-mail'
* placeholder - text, default empty
* button_text - text, default 'Submit'
* error_message - text, default 'Please enter your email'
* success_message - text, default 'Thank you!'
* refer - text, default 'Main List'
* css_class - text, default ''

**Learn more**

You can find showcases and more information about this plugin [here](http://circlewaves.com/products/plugins/email-pick-up/ "circlewaves.com")

== Installation ==

1. Use native WordPress Plugin Installer or Download and unzip plugin to "/wp-content/plugins/" directory
2. Activate plugin in "Plugins" Menu
3. Insert email pick up form into posts and pages using WordPress Visual Editor or use shortcode [emailpickup]
4. You can see statistics, export subscribers to CSV and clear table using plugin options page


== Frequently Asked Questions ==

= How to insert form into post or page? =

Use shortcode [emailpickup] or use special button in WordPress Visual Editor

= How I can add custom styles to forms? =

Use "css_class" shortcode option to wrap each form in custom css class.
For example:
[emailpickup css_class="my-own-class1"]
[emailpickup css_class="my-own-class2"]
Also you should define styles for these classes in style.css of your WordPress Theme.

= It is possible to use several forms on same page/post? =

Yes, it possible!

= How I can add different subscribers lists? =

Use "refer" shortcode option.
For example:
[emailpickup refer="My Main List"]
[emailpickup refer="November subscribers"]

= How I can export subscribers? =

Use "Export" button on plugin option page to export existing subscribers to CSV File.

== Screenshots ==

1. Insert form using WordPress Visual Editor
2. Insert form using WordPress Visual Editor - User-friendly interface
3. Using email pick up form without options
4. Use custom CSS. Customize each form as you wish by adding specific css class.
5. Custom form options. Use input placeholder instead of input label (hide label and add placeholder), change button text, customize messages.
6. View stats and export subscribers to CSV.

== Changelog ==

= 1.0 =
* Release plugin

= 1.1 =
* Added ability to view subscribers list 
* Added ability to printing subscribers list from wp-admin