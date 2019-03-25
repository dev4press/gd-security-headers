<?php

if (!defined('ABSPATH')) { exit; }

class gdsih_admin_settings {
    private $settings;

    function __construct() {
        $this->init();
    }

    public function get($panel, $group = '') {
        if ($group == '') {
            return $this->settings[$panel];
        } else {
            return $this->settings[$panel][$group];
        }
    }

    public function settings($panel) {
        $list = array();

        foreach ($this->settings[$panel] as $obj) {
            foreach ($obj['settings'] as $o) {
                $list[] = $o;
            }
        }

        return $list;
    }

    private function init() {
        $this->settings = apply_filters('gdsih_admin_internal_settings', array(
            'global' => array(
                'global_main' => array('name' => __("Adding Headers", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('settings', 'htaccess', __("To .HTACCESS", "gd-security-headers"), __("If enabled, plugin will add all security headers into .HTACCESS file. This is available only on Apache web servers.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('htaccess'))
                ))
            ),
            'csp' => array(

            ),
            'xxp' => array(
                'xxp_log' => array('name' => __("Log reports", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('xxp', 'log', __("Log Reports", "gd-security-headers"), __("Plugin will store in events log every CSP report.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('log', 'xxp')),
                    new d4pSettingElement('xxp', 'log_force_ssl', __("Force SSL for Report URL", "gd-security-headers"), __("In some cases, network home URL for the website might be generated with HTTP even if your website is set to use HTTPS. Enable this option, only if you use HTTPS URL and SSL.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('log_force_ssl', 'xxp'))
                ))
            ),
            'msh' => array(
                'msh_nosniff' => array('name' => __("Add", "gd-security-headers").': X-Content-Type-Options', 'settings' => array(
                    new d4pSettingElement('', '', __("Information", "gd-security-headers"),
                        '<ul>
                             <li>'.__("Prevents some browsers from MIME sniffing a response away from declared content type. Reduces exposure to some types of attacks.", "gd-security-headers").'</li>
                         </ul>'
                        , d4pSettingType::INFO),
                    new d4pSettingElement('headers','x_content_type_nosniff', __("Add Header", "gd-security-headers"), '', d4pSettingType::BOOLEAN, gdsih_settings()->get('x_content_type_nosniff', 'headers'))
                )),
                'msh_stricttransportsecurity' => array('name' => __("Add", "gd-security-headers").': Strict-Transport-Security', 'settings' => array(
                    new d4pSettingElement('', '', __("Information", "gd-security-headers"),
                        '<ul>
                             <li>'.__("This header should strengthen secure connection implementation by forcing user agent to use HTTPS.", "gd-security-headers").'</li>
                             <li>'.__("Use only if you use HTTPS on your website!", "gd-security-headers").'</li>
                        </ul>'
                        , d4pSettingType::INFO),
                    new d4pSettingElement('headers','strict_transport_security', __("Add Header", "gd-security-headers"), '', d4pSettingType::BOOLEAN, gdsih_settings()->get('strict_transport_security', 'headers')),
                    new d4pSettingElement('headers','strict_transport_security_max_age', __("Max Age", "gd-security-headers"), '', d4pSettingType::ABSINT, gdsih_settings()->get('strict_transport_security_max_age', 'headers')),
                    new d4pSettingElement('headers','strict_transport_security_extra', __("Extras", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('strict_transport_security_extra', 'headers'), 'array', gdsih_strict_transport_security_list())
                )),
                'msh_referrer_policy' => array('name' => __("Add", "gd-security-headers").': Referrer-Policy', 'settings' => array(
                    new d4pSettingElement('', '', __("Information", "gd-security-headers"),
                        '<ul>
                             <li>'.__("This header allows website to control how much information browser includes when it navigates away from your website.", "gd-security-headers").'</li>
                        </ul>'
                        , d4pSettingType::INFO),
                    new d4pSettingElement('headers','referrer_policy', __("Add Header", "gd-security-headers"), '', d4pSettingType::BOOLEAN, gdsih_settings()->get('referrer_policy', 'headers')),
                    new d4pSettingElement('headers','referrer_policy_value', __("Policy", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('referrer_policy_value', 'headers'), 'array', gdsih_referrer_policies_list())
                )),
                'msh_sameorgin' => array('name' => __("Add", "gd-security-headers").': X-Frame-Options', 'settings' => array(
                    new d4pSettingElement('', '', __("Information", "gd-security-headers"),
                        '<ul>
                             <li>'.__("This header controls loading of the website inside the IFRAME. By default, SAMEORIGIN will allow loading of your website in IFRAME that originated from your website. You can disable IFRAME support, or limit it to listed domains.", "gd-security-headers").'</li>
                             <li>'.__("This header can be replaced with CSP policy 'frame-src' or 'child-src' directives. If you use that, you don't need X-Frame-Options header.", "gd-security-headers").'</li>
                        </ul>'
                        , d4pSettingType::INFO),
                    new d4pSettingElement('headers','x_frame_options_sameorigin', __("Add Header", "gd-security-headers"), '', d4pSettingType::BOOLEAN, gdsih_settings()->get('x_frame_options_sameorigin', 'headers')),
                    new d4pSettingElement('headers','x_frame_options_sameorigin_value', __("Value", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('x_frame_options_sameorigin_value', 'headers'), 'array', gdsih_x_frame_options_list()),
                    new d4pSettingElement('headers','x_frame_options_sameorigin_domains', __("Domains", "gd-security-headers"), '', d4pSettingType::TEXT, gdsih_settings()->get('x_frame_options_sameorigin_domains', 'headers'))
                ))

            )
        ));
    }
}
