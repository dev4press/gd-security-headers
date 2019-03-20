<?php

if (!defined('ABSPATH')) { exit; }

$_classes = array(
    'd4p-wrap', 
    'wpv-'.GDSIH_WPV, 
    'd4p-page-'.gdsih_admin()->page,
    'd4p-panel',
    'd4p-panel-'.$_panel);

$_tabs = array(
    'whatsnew' => __("What&#8217;s New", "gd-security-headers"),
    'info' => __("Info", "gd-security-headers"),
    'changelog' => __("Changelog", "gd-security-headers"),
    'dev4press' => __("Dev4Press", "gd-security-headers")
);

?>

<div class="<?php echo join(' ', $_classes); ?>">
    <h1><?php printf(__("Welcome to GD Security Headers&nbsp;%s", "gd-security-headers"), gdsih_settings()->info_version); ?></h1>
    <p class="d4p-about-text">
        <?php _e("Configure various security related HTTP headers, including Content Security Policy, Referrer Policy and more. All headers can be added to .HTACCESS file.", "gd-security-headers"); ?>
    </p>
    <div class="d4p-about-badge" style="background-color: #69426A;">
        <i class="d4p-icon d4p-plugin-icon-gd-security-headers"></i>
        <?php printf(__("Version %s", "gd-security-headers"), gdsih_settings()->info_version); ?>
    </div>

    <h2 class="nav-tab-wrapper wp-clearfix">
        <?php

        foreach ($_tabs as $_tab => $_label) {
            echo '<a href="admin.php?page=gd-security-headers-about&panel='.$_tab.'" class="nav-tab'.($_tab == $_panel ? ' nav-tab-active' : '').'">'.$_label.'</a>';
        }

        ?>
    </h2>

    <div class="d4p-about-inner">