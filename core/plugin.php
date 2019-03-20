<?php

if (!defined('ABSPATH')) exit;

class gdsih_core_plugin extends d4p_plugin_core {
    public $svg_icon = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxOS4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9Ii0xNTYgMjQ3LjEgMjk4LjkgMjk4LjkiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgLTE1NiAyNDcuMSAyOTguOSAyOTguOTsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4NCgkuc3Qwe2ZpbGw6IzlFQTNBODt9DQo8L3N0eWxlPg0KPGc+DQoJPGc+DQoJCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0xMTUuOCwyNjUuNWgtMjQ0LjdjLTQuOCwwLTguOCwzLjktOC44LDguOHYyNDMuNGMwLDQuOSw1LDEwLDkuOSwxMGgyNDEuOWM0LjksMCwxMC40LTUuMiwxMC40LTEwLjFWMjc0LjMNCgkJCUMxMjQuNiwyNjkuNSwxMjAuNiwyNjUuNSwxMTUuOCwyNjUuNXogTTExNiw1MTMuNmMwLDMuMS0yLjUsNS42LTUuNSw1LjZIMTYuMWMzMS4zLTE2LjUsODkuNi01NC4yLDg5LjYtMTA2LjNWMzA0LjhoLTguMw0KCQkJYy0zMC41LDAtNzMuNC0xMS43LTk0LTMwLjdILTE3Yy0yMy4xLDE5LjktNjIuOCwzNC44LTkzLjUsMzQuOGgtOC4zdjEwMy45YzAsNTIuMSw1OC4yLDg5LjgsODkuNiwxMDYuM2gtOTQuMw0KCQkJYy0zLjEsMC01LjUtMi41LTUuNS01LjZ2LTIzNGMwLTMuMSwyLjUtNS41LDUuNS01LjVoMjM0YzMuMSwwLDUuNSwyLjUsNS41LDUuNVY1MTMuNnogTTM2LDQwMC4yYzQuNywwLDguNSwzLjgsOC41LDguNXY1MS4xDQoJCQljMCw0LjctMy44LDguNS04LjUsOC41aC04NS4yYy00LjcsMC04LjUtMy44LTguNS04LjV2LTUxLjFjMC00LjcsMy44LTguNSw4LjUtOC41aDIuOHYtMjguNGMwLTIxLjksMTcuOC0zOS43LDM5LjctMzkuNw0KCQkJUzMzLDM0OS45LDMzLDM3MS44YzAsMy4xLTIuNiw1LjctNS43LDUuN2gtNS43Yy0zLjEsMC01LjctMi42LTUuNy01LjdjMC0xMi41LTEwLjItMjIuNy0yMi43LTIyLjdzLTIyLjcsMTAuMi0yMi43LDIyLjd2MjguNEgzNnoNCgkJCSIvPg0KCTwvZz4NCjwvZz4NCjwvc3ZnPg0K';
    public $cron_job = 'gdsih_cron_daily_maintenance_job';

    public $enqueue = true;
    public $cap = 'gd-security-headers-standard';
    public $plugin = 'gd-security-headers';

    /** @var d4p_datetime_core */
    public $datetime;

    private $_ip;
    private $_ua;

    public function __construct() {
        parent::__construct();

        if (!defined('GDSIH_HTACCESS_FILE_NAME')) {
            define('GDSIH_HTACCESS_FILE_NAME', '.htaccess');
        }

        $this->url = GDSIH_URL;
        $this->datetime = new d4p_datetime_core();
    }

    public function ip() {
        return $this->_ip;
    }

    public function ua() {
        return $this->_ua;
    }

    public function plugins_loaded() {
        parent::plugins_loaded();

        $this->_ip = d4p_visitor_ip();
        $this->_ua = d4p_user_agent();

        define('GDSIH_WPV', intval($this->wp_version));
        define('GDSIH_WPV_MAJOR', substr($this->wp_version, 0, 3));
        define('GDSIH_WP_VERSION', $this->wp_version_real);

        add_action('gdsih_cron_daily_maintenance_job', array($this, 'maintenance_job'));

        do_action('gdsih_plugin_init');

        add_action('init', array($this, 'init'), 20);

        if (is_admin()) {
            add_action('admin_enqueue_scripts', array($this, 'wp'), 20);
        } else {
            add_action('wp', array($this, 'wp'), 20);
        }
    }

    public function init() {
        do_action('gdsih_wp_init');

        $this->scheduler();
    }

    public function wp() {
        do_action('gdsih_wp_ready');
    }

    public function scheduler() {
        $add_job = !is_multisite() || (is_multisite() && is_main_site());

        if ($add_job) {
            if (!wp_next_scheduled($this->cron_job)) {
                $cron_hour = absint(apply_filters('gdsih_cronjob_hour_of_day', 2));
                $cron_time = mktime($cron_hour, 0, 0, date('m'), date('d') + 1, date('Y'));

                wp_schedule_event($cron_time, 'daily', $this->cron_job);
            }
        }
    }

    public function maintenance_job() {

    }
}
