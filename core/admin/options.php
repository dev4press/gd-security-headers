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
            'feature' => array(
                'feature_status' => array('name' => __("Add", "gd-security-headers").': Feature-Policy', 'settings' => array(
                    new d4pSettingElement('', '', __("Information", "gd-security-headers"),
                        '<ul>
                             <li>'.__("Establishes rules for various features to be exposed by browser, limiting potentially malicious requests.", "gd-security-headers").'</li>
                         </ul>'
                        , d4pSettingType::INFO),
                    new d4pSettingElement('feature','protection', __("Add Header", "gd-security-headers"), '', d4pSettingType::BOOLEAN, gdsih_settings()->get('protection', 'feature'))
                ))
            ),
            'csp' => array(
                'csp_mode' => array('name' => __("Mode", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('', '', __("Information", "gd-security-headers"), __("Before switching to live mode, make sure the CSP is working properly in report mode. Do not use this addon if you don't understand how it works!", "gd-security-headers"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('csp', 'mode', __("Policy Mode", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('mode', 'csp'), 'array', $this->get_modes())
                )),
                'csp_basic' => array('name' => __("Basics", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('csp', 'log', __("Log Reports", "gd-security-headers"), __("Plugin will store in events log every CSP report.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('log', 'csp')),
                    new d4pSettingElement('csp', 'log_original_policy', __("Log Orginal Policy", "gd-security-headers"), __("Each report contains full original CSP policy that is not very useful to log, and it takes a lot of space. It is sent for reference purposes as a proof that CSP failed because of the element of that policy. You can log it to match it to your real policy as a method to discover eventual HTTP headers tampering.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('log_original_policy', 'csp')),
                    new d4pSettingElement('csp', 'log_force_ssl', __("Force SSL for Report URL", "gd-security-headers"), __("In some cases, network home URL for the website might be generated with HTTP even if your website is set to use HTTPS. Enable this option, only if you use HTTPS URL and SSL.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('log_force_ssl', 'csp'))
                )),
                'csp_auto' => array('name' => __("Auto Source Rules", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('', '', __("Information", "gd-security-headers"), __("Due to the way WordPress works, it is highly reccommended to allow inline scripts and style and inline script eval. With these options, plugin will add these sources automatically. If you disable them here, you will need to create rules to cover them or add them manually where you need them.", "gd-security-headers"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('csp', 'auto_inline_rule', __("Unsafe Inline Rule", "gd-security-headers"), '', d4pSettingType::BOOLEAN, gdsih_settings()->get('auto_inline_rule', 'csp')),
                    new d4pSettingElement('csp', 'auto_eval_rule', __("Unsafe Eval Rule", "gd-security-headers"), '', d4pSettingType::BOOLEAN, gdsih_settings()->get('auto_eval_rule', 'csp')),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('csp', 'auto_data_rule', __("Data Rule", "gd-security-headers"), __("This might be needed for images or fonts. If you prefer, you can disable this option here, and manually add 'data:' as a custom rule where needed.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('auto_data_rule', 'csp')),
                    new d4pSettingElement('csp', 'auto_blob_rule', __("Blob Rule", "gd-security-headers"), __("This might be needed for media, objects or fonts. If you prefer, you can disable this option here, and manually add 'blob:' as a custom rule where needed.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('auto_blob_rule', 'csp')),
                    new d4pSettingElement('csp', 'auto_mediastream_rule', __("Mediastream Rule", "gd-security-headers"), __("This might be needed for media, objects or fonts. If you prefer, you can disable this option here, and manually add 'blob:' as a custom rule where needed.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('auto_mediastream_rule', 'csp')),
                    new d4pSettingElement('csp', 'auto_filesystem_rule', __("FileSystem Rule", "gd-security-headers"), __("This might be needed for media, objects or fonts. If you prefer, you can disable this option here, and manually add 'blob:' as a custom rule where needed.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('auto_filesystem_rule', 'csp'))
                )),
                'csp_additional' => array('name' => __("Additional CSP Settings", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('csp', 'upgrade_insecure_requests', __("Upgrade insecure requests", "gd-security-headers"), __("Use this only if your website is configured to use secure HTTPS.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('upgrade_insecure_requests', 'csp')),
                    new d4pSettingElement('csp', 'block_all_mixed_content', __("Block all mixed content", "gd-security-headers"), __("Use this only if your website is configured to use secure HTTPS.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('block_all_mixed_content', 'csp')),
                    new d4pSettingElement('csp', 'disown_opener', __("Disown Opener", "gd-security-headers"), __("This is not yet widely supported, it works only with some browsers.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('disown_opener', 'csp'))
                )),
                'csp_extra' => array('name' => __("Automatic rules for third party services", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('', '', __("Google Services", "gd-security-headers"), '', d4pSettingType::HR),
                    new d4pSettingElement('csp', 'extra_google_adsense', __("Google Adsense", "gd-security-headers"), __("If you are using Google Adsense, this option will automatically append required rules.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('extra_google_adsense', 'csp')),
                    new d4pSettingElement('csp', 'extra_google_analytics', __("Google Analytics", "gd-security-headers"), __("If you are using Google Analytics, this option will automatically append required rules.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('extra_google_analytics', 'csp')),
                    new d4pSettingElement('csp', 'extra_google_fonts', __("Google Fonts", "gd-security-headers"), __("If you are using Google Fonts, this option will automatically append required rules.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('extra_google_fonts', 'csp')),
                    new d4pSettingElement('csp', 'extra_google_maps', __("Google Maps", "gd-security-headers"), __("If you are using Google Maps, this option will automatically append required rules.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('extra_google_maps', 'csp')),
                    new d4pSettingElement('csp', 'extra_google_translate', __("Google Translate", "gd-security-headers"), __("If you are using Google Translate or you want to allow your users to use it, this option will automatically append required rules.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('extra_google_translate', 'csp')),
                    new d4pSettingElement('csp', 'extra_google_youtube', __("Google Youtube", "gd-security-headers"), __("If you are embedding YouTube videos, this option will automatically append required rules.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('extra_google_youtube', 'csp')),
                    new d4pSettingElement('csp', 'extra_google_tag_manager', __("Google Tag Manager", "gd-security-headers"), __("If you are using Google Tag Manager, this option will automatically append required rules. Also, make sure to enable support for other Google services you are including through Tag Manager.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('extra_google_tag_manager', 'csp')),
                    new d4pSettingElement('', '', __("More Services", "gd-security-headers"), '', d4pSettingType::HR),
                    new d4pSettingElement('csp', 'extra_gravatar', __("Gravatar", "gd-security-headers"), __("If you are using Gravatar service for user avatars, this option will automatically append required rules.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('extra_gravatar', 'csp')),
                    new d4pSettingElement('csp', 'extra_gleam', __("Gleam", "gd-security-headers"), __("If you are embedding Gleam based contest, this option will automatically append required rules.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('extra_gleam', 'csp')),
                    new d4pSettingElement('csp', 'extra_vimeo', __("Vimeo", "gd-security-headers"), __("If you are embedding Vimeo videos, this option will automatically append required rules.", "gd-security-headers"), d4pSettingType::BOOLEAN, gdsih_settings()->get('extra_vimeo', 'csp'))
                )),
                'csp_rules_default' => array('name' => __("Source Rules: Default", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('csp', 'default_basic', __("Basic", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('default_basic', 'csp'), 'array', $this->get_sources()),
                    new d4pSettingElement('csp', 'default_custom', __("Custom", "gd-security-headers"), '', d4pSettingType::EXPANDABLE_TEXT, gdsih_settings()->get('default_custom', 'csp'), '', '', array('label_button_add' => __("Add new rule", "gd-security-headers"), 'width_button_remove' => 40, 'label_buttom_remove' => '<i class="fa fa-minus"></i>'))
                )),
                'csp_rules_script' => array('name' => __("Source Rules: Script", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('csp', 'script_basic', __("Basic", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('script_basic', 'csp'), 'array', $this->get_sources()),
                    new d4pSettingElement('csp', 'script_custom', __("Custom", "gd-security-headers"), '', d4pSettingType::EXPANDABLE_TEXT, gdsih_settings()->get('script_custom', 'csp'), '', '', array('label_button_add' => __("Add new rule", "gd-security-headers"), 'width_button_remove' => 40, 'label_buttom_remove' => '<i class="fa fa-minus"></i>'))
                )),
                'csp_rules_style' => array('name' => __("Source Rules: Style", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('csp', 'style_basic', __("Basic", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('style_basic', 'csp'), 'array', $this->get_sources()),
                    new d4pSettingElement('csp', 'style_custom', __("Custom", "gd-security-headers"), '', d4pSettingType::EXPANDABLE_TEXT, gdsih_settings()->get('style_custom', 'csp'), '', '', array('label_button_add' => __("Add new rule", "gd-security-headers"), 'width_button_remove' => 40, 'label_buttom_remove' => '<i class="fa fa-minus"></i>'))
                )),
                'csp_rules_img' => array('name' => __("Source Rules: Image", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('csp', 'img_basic', __("Basic", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('img_basic', 'csp'), 'array', $this->get_sources()),
                    new d4pSettingElement('csp', 'img_custom', __("Custom", "gd-security-headers"), '', d4pSettingType::EXPANDABLE_TEXT, gdsih_settings()->get('img_custom', 'csp'), '', '', array('label_button_add' => __("Add new rule", "gd-security-headers"), 'width_button_remove' => 40, 'label_buttom_remove' => '<i class="fa fa-minus"></i>'))
                )),
                'csp_rules_font' => array('name' => __("Source Rules: Font", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('csp', 'font_basic', __("Basic", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('font_basic', 'csp'), 'array', $this->get_sources()),
                    new d4pSettingElement('csp', 'font_custom', __("Custom", "gd-security-headers"), '', d4pSettingType::EXPANDABLE_TEXT, gdsih_settings()->get('font_custom', 'csp'), '', '', array('label_button_add' => __("Add new rule", "gd-security-headers"), 'width_button_remove' => 40, 'label_buttom_remove' => '<i class="fa fa-minus"></i>'))
                )),
                'csp_rules_object' => array('name' => __("Source Rules: Object", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('csp', 'object_basic', __("Basic", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('object_basic', 'csp'), 'array', $this->get_sources()),
                    new d4pSettingElement('csp', 'object_custom', __("Custom", "gd-security-headers"), '', d4pSettingType::EXPANDABLE_TEXT, gdsih_settings()->get('object_custom', 'csp'), '', '', array('label_button_add' => __("Add new rule", "gd-security-headers"), 'width_button_remove' => 40, 'label_buttom_remove' => '<i class="fa fa-minus"></i>'))
                )),
                'csp_rules_connect' => array('name' => __("Source Rules: Connect", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('csp', 'connect_basic', __("Basic", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('connect_basic', 'csp'), 'array', $this->get_sources()),
                    new d4pSettingElement('csp', 'connect_custom', __("Custom", "gd-security-headers"), '', d4pSettingType::EXPANDABLE_TEXT, gdsih_settings()->get('connect_custom', 'csp'), '', '', array('label_button_add' => __("Add new rule", "gd-security-headers"), 'width_button_remove' => 40, 'label_buttom_remove' => '<i class="fa fa-minus"></i>'))
                )),
                'csp_rules_media' => array('name' => __("Source Rules: Media", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('csp', 'media_basic', __("Basic", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('media_basic', 'csp'), 'array', $this->get_sources()),
                    new d4pSettingElement('csp', 'media_custom', __("Custom", "gd-security-headers"), '', d4pSettingType::EXPANDABLE_TEXT, gdsih_settings()->get('media_custom', 'csp'), '', '', array('label_button_add' => __("Add new rule", "gd-security-headers"), 'width_button_remove' => 40, 'label_buttom_remove' => '<i class="fa fa-minus"></i>'))
                )),
                'csp_rules_manifest' => array('name' => __("Source Rules: Manifest", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('csp', 'manifest_basic', __("Basic", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('manifest_basic', 'csp'), 'array', $this->get_sources()),
                    new d4pSettingElement('csp', 'manifest_custom', __("Custom", "gd-security-headers"), '', d4pSettingType::EXPANDABLE_TEXT, gdsih_settings()->get('manifest_custom', 'csp'), '', '', array('label_button_add' => __("Add new rule", "gd-security-headers"), 'width_button_remove' => 40, 'label_buttom_remove' => '<i class="fa fa-minus"></i>'))
                )),
                'csp_rules_child' => array('name' => __("Source Rules: Child", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('csp', 'child_basic', __("Basic", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('child_basic', 'csp'), 'array', $this->get_sources()),
                    new d4pSettingElement('csp', 'child_custom', __("Custom", "gd-security-headers"), '', d4pSettingType::EXPANDABLE_TEXT, gdsih_settings()->get('child_custom', 'csp'), '', '', array('label_button_add' => __("Add new rule", "gd-security-headers"), 'width_button_remove' => 40, 'label_buttom_remove' => '<i class="fa fa-minus"></i>'))
                )),
                'csp_rules_worker' => array('name' => __("Source Rules: Worker", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('', '', __("Information", "gd-security-headers"), __("This is experimental CSP source, and is not used by all browsers", "gd-security-headers"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('csp', 'worker_basic', __("Basic", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('worker_basic', 'csp'), 'array', $this->get_sources()),
                    new d4pSettingElement('csp', 'worker_custom', __("Custom", "gd-security-headers"), '', d4pSettingType::EXPANDABLE_TEXT, gdsih_settings()->get('worker_custom', 'csp'), '', '', array('label_button_add' => __("Add new rule", "gd-security-headers"), 'width_button_remove' => 40, 'label_buttom_remove' => '<i class="fa fa-minus"></i>'))
                )),
                'csp_rules_form-action' => array('name' => __("Experimental Source Rules: Form Action", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('', '', __("Information", "gd-security-headers"), __("This is experimental CSP source, and is not used by all browsers.", "gd-security-headers"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('csp', 'form-action_basic', __("Basic", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('form-action_basic', 'csp'), 'array', $this->get_sources()),
                    new d4pSettingElement('csp', 'form-action_custom', __("Custom", "gd-security-headers"), '', d4pSettingType::EXPANDABLE_TEXT, gdsih_settings()->get('form-action_custom', 'csp'), '', '', array('label_button_add' => __("Add new rule", "gd-security-headers"), 'width_button_remove' => 40, 'label_buttom_remove' => '<i class="fa fa-minus"></i>'))
                )),
                'csp_rules_frame-ancestors' => array('name' => __("Experimental Source Rules: Frame Ancestors", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('', '', __("Information", "gd-security-headers"), __("This is experimental CSP source, and is not used by all browsers.", "gd-security-headers"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('csp', 'frame-ancestors_basic', __("Basic", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('frame-ancestors_basic', 'csp'), 'array', $this->get_sources()),
                    new d4pSettingElement('csp', 'frame-ancestors_custom', __("Custom", "gd-security-headers"), '', d4pSettingType::EXPANDABLE_TEXT, gdsih_settings()->get('frame-ancestors_custom', 'csp'), '', '', array('label_button_add' => __("Add new rule", "gd-security-headers"), 'width_button_remove' => 40, 'label_buttom_remove' => '<i class="fa fa-minus"></i>'))
                )),
                'csp_rules_frame' => array('name' => __("Obsolote Source Rules: Frame", "gd-security-headers"), 'settings' => array(
                    new d4pSettingElement('', '', __("Information", "gd-security-headers"), __("This is obsolete CSP source, use Child source instead.", "gd-security-headers"), d4pSettingType::INFO),
                    new d4pSettingElement('', '', '', '', d4pSettingType::HR),
                    new d4pSettingElement('csp', 'frame_basic', __("Basic", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get('frame_basic', 'csp'), 'array', $this->get_sources()),
                    new d4pSettingElement('csp', 'frame_custom', __("Custom", "gd-security-headers"), '', d4pSettingType::EXPANDABLE_TEXT, gdsih_settings()->get('frame_custom', 'csp'), '', '', array('label_button_add' => __("Add new rule", "gd-security-headers"), 'width_button_remove' => 40, 'label_buttom_remove' => '<i class="fa fa-minus"></i>'))
                ))
            ),
            'xxp' => array(
                'xxp_xss' => array('name' => __("Add", "gd-security-headers").': X-XSS-Protection', 'settings' => array(
                    new d4pSettingElement('', '', __("Information", "gd-security-headers"),
                        '<ul>
                             <li>'.__("Prevents various types of cross site scripting. It also can log the XXS reportes some browsers can send.", "gd-security-headers").'</li>
                         </ul>'
                        , d4pSettingType::INFO),
                    new d4pSettingElement('xxp','x_xss_protection', __("Add Header", "gd-security-headers"), '', d4pSettingType::BOOLEAN, gdsih_settings()->get('x_xss_protection', 'xxp'))
                )),
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

        foreach (gdsih_settings()->features as $feature => $label) {
            $this->settings['feature']['fp_rules_'.$feature] = array('name' => sprintf(__("Rules: %s", "gd-security-headers"), $label), 'settings' => array(
                new d4pSettingElement('feature', $feature.'_basic', __("Basic", "gd-security-headers"), '', d4pSettingType::SELECT, gdsih_settings()->get($feature.'_basic', 'feature'), 'array', $this->get_feature_sources()),
                new d4pSettingElement('feature', $feature.'_custom', __("Custom URL's", "gd-security-headers"), __("Fully qualified URL's with the protocol specified.", "gd-security-headers"), d4pSettingType::EXPANDABLE_TEXT, gdsih_settings()->get($feature.'_custom', 'feature'), '', '', array('label_button_add' => __("Add new URL", "gd-security-headers"), 'width_button_remove' => 40, 'label_buttom_remove' => '<i class="fa fa-minus"></i>'))
            ));
        }
    }

    public function get_feature_sources() {
        return array(
            'no' => __("Disabled", "gd-security-headers"),
            'none' => __("None", "gd-security-headers"),
            'all' => __("All", "gd-security-headers"),
            'self' => __("Self", "gd-security-headers"),
            'custom_self' => __("Self and Custom URL's", "gd-security-headers"),
            'custom' => __("Custom URL's Only", "gd-security-headers")
        );
    }

    public function get_modes() {
        return array(
            'disable' => __("Disabled", "gd-security-headers"),
            'report' => __("Report", "gd-security-headers"),
            'live' => __("Live", "gd-security-headers")
        );
    }

    public function get_refferrer() {
        return array(
            'no' => __("Disabled", "gd-security-headers"),
            'no-referrer' => __("No referrer", "gd-security-headers"),
            'no-referrer-when-downgrade' => __("No referrer when downgrade", "gd-security-headers"),
            'origin' => __("Origin", "gd-security-headers"),
            'origin-when-cross-origin' => __("Origin when cross origin", "gd-security-headers"),
            'unsafe-url' => __("Unsafe URL", "gd-security-headers")
        );
    }

    public function get_sources() {
        return array(
            'no' => __("Disabled", "gd-security-headers"),
            'none' => __("None", "gd-security-headers"),
            'all' => __("All", "gd-security-headers"),
            'self' => __("Self", "gd-security-headers")
        );
    }
}
