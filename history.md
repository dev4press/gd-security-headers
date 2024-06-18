# GD Security Headers

## Changelog

### Version: 1.6.1 / may 16 2022

* **new** tested with WordPress 6.0

### Version: 1.6 / february 4 2022

* **new** system requirements: PHP 7.2 or newer
* **new** system requirements: WordPress 5.3 or newer
* **new** tested with WordPress 5.9
* **new** csp addon: send reports to custom log URL
* **new** csp addon: support for 'base-uri' directive
* **new** csp addon: predefined rules list for Instagram
* **edit** csp addon: updated various predefined rules lists
* **edit** csp addon: updated settings information about some rules
* **edit** d4pLib 2.8.14
* **fix** csp addon: few typos in the rules names
* **fix** csp addon: minor issues with saving settings

### Version: 1.5 / april 20 2021

* **new** feature/permissions policy addon: support for 'interest-cohort'
* **new** feature/permissions policy addon: dashboard information widget
* **edit** feature/permissions policy addon: expanded information in the settings panel
* **edit** feature/permissions policy addon: improved values explanations
* **fix** feature/permissions policy addon: few typos in the rules names

### Version: 1.4 / october 5 2020

* **new** csp addon: generate predefined rules for one or more CDN's
* **new** csp addon: predefined rules list for WordPress.org
* **new** csp addon: support for 'prefetch-src' directive
* **new** feature policy addon: support for updated 'permissions-policy' version
* **new** feature policy addon: expanded list of policies that can be included
* **edit** csp addon: improved settings organization showing CSP rule levels
* **edit** feature policy addon: included support information for some policies
* **edit** d4pLib 2.8.13
* **fix** csp addon: problem with generating the rules with 'all' basic value
* **fix** feature policy addon: few minor issues with building rules

### Version: 1.3 / may 8 2020

* **edit** csp addon: expanded some of the google based preset rules
* **edit** d4pLib 2.8.8
* **fix** x-frame policy: invalid headers generated when not using .htaccess
* **fix** strict-transport-security policy: invalid headers generated when not using .htaccess
* **fix** referer policy: invalid headers generated when not using .htaccess
* **fix** feature policy: problem printing empty policy header

### Version: 1.2 / december 5 2019

* **new** support for feature policy header
* **new** csp addon: predefined rules list for Google YouTube
* **new** csp addon: predefined rules list for Google Tag Manager
* **new** csp addon: predefined rules list for Gravatar
* **new** csp addon: predefined rules list for Gleam
* **new** csp addon: predefined rules list for Vimeo
* **new** csp addon: auto generated rules for some special data sources
* **edit** csp addon: expanded some of the google based preset rules
* **edit** csp addon: various improvements in the generator
* **edit** d4pLib 2.8.2

### Version: 1.1.1 / august 15 2019

* **edit** d4pLib 2.7.6
* **fix** problem with saving the plugin settings in some cases

### Version: 1.1 / may 11 2019

* **new** panel with generated headers for various servers
* **new** headers panel: for apache servers
* **new** headers panel: for nginx servers
* **new** headers panel: for iis servers
* **new** method for building the HTACCESS headers
* **edit** improved additional headers object
* **edit** updated rules for google analytics
* **edit** do not run when WordPress runs CRON
* **edit** removed some unused code and strings

### Version: 1.0 / march 21 2019

* **new** first official version