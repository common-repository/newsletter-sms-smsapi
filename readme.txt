=== Newsletter SMS - SMSAPI ===
Contributors: smsapi
Tags: newsletter, smsapi, sms
Requires at least: 4.2.3
Tested up to: 5.8.1
Stable tag: 2.0.4
Requires PHP: 7.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Plugin which allows you to create Newsletter which will collect clients phone numbers and allow you to send SMS messages to them. Database is synchronized with SMSAPI account so messages can be sent from SMSAPI panel as well. More information on page <a href="https://www.smsapi.com">https://www.smsapi.com</a>.

== Installation ==

= From your WordPress dashboard =

1.  Register your account on <a href="https://www.smsapi.com/signup">SMSAPI.com</a>.
2.  Visit 'Plugins > Add New'.
3.  Search for 'Newsletter SMS - SMSAPI'.
4.  Activate 'Newsletter SMS - SMSAPI' from your Plugins page. (You'll see it in left bar in admin panel).
5.  Configure plugin in 'Newsletter SMS - SMSAPI > Settings'.
6.  Enter your API token. You could generate your token in SMSAPI panel ( 'API settings > API tokens' ). Remember to set correct access rights. The minimum ones required by the plugin are  'Contacts', 'Profile', 'Users', 'SMS' and 'Sendernames'.
7.  Choose group to collect data collected by newsletter or add new group.
8.  Adjust Newsletter SMS - SMSAPI widget in 'Apperance > Widgets > Manage in Customizer'.

= From WordPress.org =

1.  Register your account on <a href="https://www.smsapi.com/signup">SMSAPI.com</a>.
2.  Download and unzip last realase Newsletter SMS - SMSAPI zip file.
3.  Upload the 'Newsletter SMS' directory to your '/wp-content/plugins/' directory, using your favorite method (ftp, sftp, scp, etc...)
4.  Activate Newsletter SMS from your Plugins page. (You'll see Newsletter SMS in left bar in admin panel.)
5.  Configure plugin in 'Newsletter SMS - SMSAPI > Settings'.
6.  Enter your API token. You could generate your token in SMSAPI panel ( 'API settings > API tokens' ). Remember to set correct access rights. The minimum ones required by the plugin are  'Contacts', 'Profile', 'Users', 'SMS' and 'Sendernames'.
7.  Choose group to collect data collected by newsletter or add new group.
8.  Adjust Newsletter SMS - SMSAPI widget in 'Apperance > Widgets > Manage in Customizer'.


== Screenshots ==

1. After installing the plugin and moving to its settings, you'll see this overview.

2. After filling authorization data and saving you'll see next required settings as group to store subscribers and sender name of SMS messages sending through plugin.

3. In 'Subscription' tab you can set additional fields for newsletter and subscription verification by sending SMS message with random code.

4. In 'Notification' tab you can set own subscription notification sent after submitting by new subscribers.

5. On left bar in 'Send SMS' subtab of 'Newsletter SMS - SMSAPI' you can send SMS messages to all subscribers or to phone numbers that you type on your own.

6. In 'Subscribers' subtab you can view, edit or remove current subscribers.

== Changelog ==

= 2.0.4 =
* Fix dependency conflicts with `SMSAPI WooCommerce` plugin

= 2.0.3 =
* Missing class fix

= 2.0.2 =
* Add request error handling
* Update vendor smsapi-php-client library

= 2.0.1 =
* Fix security issues

= 2.0.0 =
* Upgraded underlying library to the newest version.
* Changed login method to OAuth.
* Added option to unpin subscribers from the group instead of removing them entirely.

= 1.7.0 =
* Added support for PHP 7.3

= 1.6.0 =
* Added optional required fields used in widget
* Fixed custom responses

= 1.5.5 =
* Fix sms shipping for all recipients

= 1.5.3 =
* Update link in description

= 1.5.2 =
* Update description

= 1.5.1 =
* Update installation instruction

= 1.5 =
* Update translations
* Add screenshots

= 1.4 =
* Support for PHP 5.3

= 1.3 =
* Added warning information after basic configuration submit about default contacts group selection

= 1.2 =
* Added missing translations
* Make activation code case-insensitive
* Fix submit subscription form after provide invalid activation code

= 1.1 =
* Added domain selection for international users
* Fixed errors when user provide invalid authorization data

= 1.0 =
* In development
