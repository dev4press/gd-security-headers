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
}
