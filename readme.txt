=== GD Security Headers ===
Contributors: GDragoN
Donate link: https://plugins.dev4press.com/gd-security-headers/
Version: 1.0
Tags: dev4press, security, http headers, csp, content security policy, referrer policy
Requires at least: 4.5
Requires PHP: 5.6
Tested up to: 5.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Configure various security related HTTP headers, including Content Security Policy, Referrer Policy and more. All headers can be added to .HTACCESS file.

== Description ==
//

== Installation ==
= General Requirements =
* PHP: 5.6 or newer

= PHP Notice =
* Plugin should work with PHP 5.3, 5.4 and 5.5, but these versions are no longer used for testing, and they are no longer supported.
* Plugin doesn't work with PHP 5.2 or older versions.

= WordPress Requirements =
* WordPress: 4.5 or newer

= WordPress Notice =
* Plugin doesn't work with WordPress 4.4 or older versions.

= bbPress Requirements =
*  bbPress 2.5 or newer

= Basic Installation =
* Plugin folder in the WordPress plugins folder must be `gd-security-headers`.
* Upload `gd-security-headers` folder to the `/wp-content/plugins/` directory.
* Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==
= Does plugin works with WordPress MultiSite installations? =
Yes. In Multisite installation, plugin is available for configuration on the Network level, and headers are configured for all sites in the network at once.

= Can I translate plugin to my language? =
Yes. POT file is provided as a base for translation. Translation files should go into Languages directory.

= Where can I configure the plugin? =
Plugin has own top level item in the WordPress admin side menu: GD Security Headers. This will open a panel with global plugin settings. In Multisite installation, plugin panel is in the Network administration.

== Upgrade Notice ==
= 1.0 =
First plugin version.

== Changelog ==
= 1.0 =
* First plugin version

== Screenshots ==
1. Advanced search form
2. Selected forums search field
3. Part of the filter settings
4. Integration control settings
