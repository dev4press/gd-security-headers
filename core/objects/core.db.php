<?php

if (!defined('ABSPATH')) { exit; }

class gdsih_core_db extends d4p_wpdb_core {
    public $_prefix = 'gdsec';
    public $_tables = array(
        'csp_reports',
        'xxp_reports');
    public $_network_tables = array(
        'csp_reports',
        'xxp_reports');

    public function empty_reports_logs($tables) {
        foreach ($tables as $t) {
            if ($t == 'csp') {
                $this->query("TRUNCATE TABLE ".$this->csp_reports);
            }

            if ($t == 'xxp') {
                $this->query("TRUNCATE TABLE ".$this->xxp_reports);
            }
        }
    }

    public function cleanup_reports($days = 365, $tables = array()) {
        foreach ($tables as $t) {
            if ($t == 'csp') {
                $this->query("DELETE FROM ".$this->csp_reports." WHERE reported < DATE_SUB(NOW(), INTERVAL $days DAY)");
            }

            if ($t == 'xxp') {
                $this->query("DELETE FROM ".$this->xxp_reports." WHERE reported < DATE_SUB(NOW(), INTERVAL $days DAY)");
            }
        }
    }
}
