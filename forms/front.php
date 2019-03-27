<?php

if (!defined('ABSPATH')) { exit; }

include(GDSIH_PATH.'forms/shared/top.php');
include(GDSIH_PATH.'core/objects/core.statistics.php');

?>

<div class="d4p-plugin-dashboard">
    <div class="d4p-content-left">
        <div class="d4p-dashboard-badge" style="background-color: #69426A">
            <div aria-hidden="true" class="d4p-plugin-logo"><i class="d4p-icon d4p-plugin-icon-gd-security-headers"></i></div>
            <h3>GD Security Headers Pro</h3>

            <h5>
                <?php

                _e("Version", "gd-security-headers");
                echo': '.gdsih_settings()->info->version;

                if (gdsih_settings()->info->status != 'stable') {
                    echo ' - <span class="d4p-plugin-unstable" style="color: #fff; font-weight: 900;">'.strtoupper(gdsih_settings()->info->status).'</span>';
                }

                ?>

            </h5>
        </div>

        <div class="d4p-buttons-group">
            <a class="button-secondary" href="admin.php?page=gd-security-headers-settings"><i aria-hidden="true" class="fa fa-cogs fa-fw"></i> <?php _e("Settings", "gd-security-headers"); ?></a>
            <a class="button-secondary" href="admin.php?page=gd-security-headers-tools"><i aria-hidden="true" class="fa fa-wrench fa-fw"></i> <?php _e("Tools", "gd-security-headers"); ?></a>
        </div>

        <div class="d4p-buttons-group">
            <a class="button-secondary" href="admin.php?page=gd-security-headers-about"><i aria-hidden="true" class="fa fa-info-circle fa-fw"></i> <?php _e("About", "gd-security-headers"); ?></a>
        </div>
    </div>
    <div class="d4p-content-right">
        <?php

            include(GDSIH_PATH.'forms/dashboard/headers.php');
            include(GDSIH_PATH.'forms/dashboard/reports.php');

        ?>
    </div>
</div>

<?php

include(GDSIH_PATH.'forms/shared/bottom.php');
