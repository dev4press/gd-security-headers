<?php if (!defined('ABSPATH')) { exit; } ?>
<div class="d4p-group d4p-group-changelog">
    <h3><?php _e("Version", "gd-security-headers"); ?> 1</h3>
    <div class="d4p-group-inner">
        <h4>Version: 1.4 / october 5 2020</h4>
        <ul>
            <li><strong>new</strong> csp addon: generate predefined rules for one or more CDN's</li>
            <li><strong>new</strong> csp addon: predefined rules list for WordPress.org</li>
            <li><strong>new</strong> csp addon: support for 'prefetch-src' directive</li>
            <li><strong>new</strong> feature policy addon: support for updated 'permission-policy' version</li>
            <li><strong>new</strong> feature policy addon: expanded list of policies that can be included</li>
            <li><strong>edit</strong> csp addon: improved settings organization showing CSP rule levels</li>
            <li><strong>edit</strong> feature policy addon: included support information for some policies</li>
            <li><strong>edit</strong> d4pLib 2.8.13</li>
            <li><strong>fix</strong> csp addon: problem with generating the rules with 'all' basic value</li>
            <li><strong>fix</strong> feature policy addon: few minor issues with building rules</li>
        </ul>

        <h4>Version: 1.3 / may 8 2020</h4>
        <ul>
            <li><strong>edit</strong> csp addon: expanded some of the google based preset rules</li>
            <li><strong>edit</strong> d4pLib 2.8.8</li>
            <li><strong>fix</strong> x-frame policy: invalid headers generated when not using .htaccess</li>
            <li><strong>fix</strong> strict-transport-security policy: invalid headers generated when not using .htaccess</li>
            <li><strong>fix</strong> referer policy: invalid headers generated when not using .htaccess</li>
            <li><strong>fix</strong> feature policy: problem printing empty policy header</li>
        </ul>

        <h4>Version: 1.2 / december 5 2019</h4>
        <ul>
            <li><strong>new</strong> support for feature policy header</li>
            <li><strong>new</strong> csp addon: predefined rules list for Google YouTube</li>
            <li><strong>new</strong> csp addon: predefined rules list for Google Tag Manager</li>
            <li><strong>new</strong> csp addon: predefined rules list for Gravatar</li>
            <li><strong>new</strong> csp addon: predefined rules list for Gleam</li>
            <li><strong>new</strong> csp addon: predefined rules list for Vimeo</li>
            <li><strong>new</strong> csp addon: auto generated rules for some special data sources</li>
            <li><strong>edit</strong> csp addon: expanded some of the google based preset rules</li>
            <li><strong>edit</strong> csp addon: various improvements in the generator</li>
            <li><strong>edit</strong> d4pLib 2.8.2</li>
        </ul>

        <h4>Version: 1.1.1 / august 15 2019</h4>
        <ul>
            <li><strong>edit</strong> d4pLib 2.7.6</li>
            <li><strong>fix</strong> problem with saving the plugin settings in some cases</li>
        </ul>

        <h4>Version: 1.1 / may 11 2019</h4>
        <ul>
            <li><strong>new</strong> panel with generated headers for various servers</li>
            <li><strong>new</strong> headers panel: for apache servers</li>
            <li><strong>new</strong> headers panel: for nginx servers</li>
            <li><strong>new</strong> headers panel: for iis servers</li>
            <li><strong>new</strong> new method for building the HTACCESS headers</li>
            <li><strong>edit</strong> improved additional headers object</li>
            <li><strong>edit</strong> updated rules for google analytics</li>
            <li><strong>edit</strong> do not run when WordPress runs CRON</li>
            <li><strong>edit</strong> removed some unused code and strings</li>
        </ul>

        <h4>Version: 1.0 / march 21 2019</h4>
        <ul>
            <li><strong>new</strong> first official version</li>
        </ul>
    </div>
</div>
