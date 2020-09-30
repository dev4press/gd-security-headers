<?php

if (!defined('ABSPATH')) exit;

class gdsih_core_info {
    public $name = 'GD Security Headers';
    public $code = 'gd-security-headers';

    public $version = '1.4';
    public $build = 40;
    public $edition = 'pro';
    public $status = 'stable';
    public $updated = '2020.10.05';
    public $url = 'https://plugins.dev4press.com/gd-security-headers/';
    public $author_name = 'Milan Petrovic';
    public $author_url = 'https://www.dev4press.com/';
    public $released = '2019.03.26';

    public $php = '5.6';
    public $mysql = '5.1';
    public $wordpress = '4.9';

    public $install = false;
    public $update = false;
    public $previous = 0;

    function __construct() { }

    public function to_array() {
        return (array)$this;
    }
}
