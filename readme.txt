=== GD Security Headers ===
Contributors: GDragoN
Donate link: https://plugins.dev4press.com/gd-security-headers/
Version: 1.2
Tags: dev4press, security, csp, content security policy, referrer policy, feature policy, security headers, xss
Requires at least: 4.7
Requires PHP: 5.6
Tested up to: 5.3
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Configure various security-related HTTP headers, including CSP, XSS, Referrer Policy and more.

== Description ==
Configure various security-related HTTP headers, including Content Security Policy, Feature Policy, Referrer Policy and more. For CSP and XSS plugin supports report logging with 2 additional database tables to store reports from browsers.

The plugin has support for following HTTP headers:

* Content Security Policy (CSP) - with reporting
* XSS Protection (XXP) - with reporting
* Feature Policy
* Content Type - No Sniff Policy
* Strict Transport Security
* Referrer Policy
* Frame Options

For CSP, the plugin allows you to set rules for all currently supported directives, additional settings including setting the policy in Report or Live mode. The plugin also includes special extensions that can automatically fill CSP rules for popular Google services you might be using on your website (Fonts, Maps, Adsense, Analytics and more) and other populare services (Gravatar, Vimeo and more).

And, for Feature Policy, the plugin allows you to set rules for all currently supported features.

The plugin can add all the generated headers into HTACCESS file (for Apache web servers), and they will be applied to all files, not just WordPress generated content. If your website is not using Apache (or .HTACCESS), all rules are generated with each page request and will work with any server type.

And, if you don't use Apache web server, plugin has a panel where it displays generated headers for most popular servers: Apache, Nginx and IIS, and you can copy generated headers to add to server configuration files.

* More information about [GD Security Headers](https://plugins.dev4press.com/gd-security-headers/)
* Support and Knowledge Base for [GD Security Headers](https://support.dev4press.com/kb/product/gd-security-headers/)

== Installation ==
= General Requirements =
* PHP: 5.6 or newer

= PHP Notice =
* Plugin doesn't work with PHP 5.5 or older versions.

= WordPress Requirements =
* WordPress: 4.7 or newer

= WordPress Notice =
* Plugin doesn't work with WordPress 4.6 or older versions.

= Basic Installation =
* Plugin folder in the WordPress plugins folder must be `gd-security-headers`.
* Upload `gd-security-headers` folder to the `/wp-content/plugins/` directory.
* Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==
= Does plugin works with WordPress MultiSite installations? =
Yes. In Multisite installation, the plugin is available for configuration on the Network level, and headers are configured for all sites in the network at once.

= Where can I configure the plugin? =
The plugin has own top-level item in the WordPress admin side menu: GD Security Headers. This will open a panel with global plugin settings. In Multisite installation, plugin panel is in the Network administration.

= Can I translate the plugin to my language? =
Yes. The POT file is provided as a base for translation. Translation files should go into Languages directory.

== Upgrade Notice ==
= 1.2 =
Feature Policy Header. More CSP predefine rules. Various updates.

== Changelog ==
= 1.2 - 2019.12.05 =
* New: support for feature policy header
* New: csp addon: predefined rules list for Google YouTube
* New: csp addon: predefined rules list for Google Tag Manager
* New: csp addon: predefined rules list for Gravatar
* New: csp addon: predefined rules list for Gleam
* New: csp addon: predefined rules list for Vimeo
* New: csp addon: auto generated rules for some special data sources
* Edit: csp addon: expanded some of the google based preset rules
* Edit: csp addon: various improvements in the generator
* Edit: d4pLib 2.8.2

= 1.1.1 - 2019.08.15 =
* Edit: d4pLib 2.7.6
* Fix: problem with saving the plugin settings in some cases

= 1.1 - 2019.05.11 =
* New: panel with generated headers for various servers
* New: headers panel: for apache servers
* New: headers panel: for nginx servers
* New: headers panel: for iis servers
* New: new method for building the HTACCESS headers
* Edit: improved additional headers object
* Edit: updated rules for google analytics
* Edit: do not run when WordPress runs CRON
* Edit: removed some unused code and strings

= 1.0 - 2019.03.21 =
* First plugin version

== Screenshots ==
1. Plugin Dashboard
2. CSP Reports
3. Various Headers settings
4. XSS Protection settings
5. Content Security Policy settings
6. Global settings
7. Generated security headers
8. Tools
9. HTACCESS with security headers
