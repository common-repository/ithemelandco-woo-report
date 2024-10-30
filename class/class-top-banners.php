<?php

defined('ABSPATH') || exit(); // Exit if accessed directly

class ITWRL_Top_Banners
{
    private static $instance;

    public static function register()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
    }

    private function __construct()
    {
        if (get_option('it_halloween_banner_dismissed', 'no') == 'no' && empty(apply_filters('it_halloween_banner', []))) {
            add_filter('it_halloween_banner', function ($plugins) {
                $plugins['itwrl'] = 'Reports Lite';
                return $plugins;
            });
            add_action('admin_notices', [$this, 'add_halloween_banner']);
            add_action('admin_post_itwrl_halloween_banner_dismiss', [$this, 'halloween_banner_dismiss']);
        }
    }

    public function add_halloween_banner()
    {
        $url = 'https://ithemelandco.com/halloween2024/?utm_source=plugin&utm_medium=banner&utm_campaign=hal2024';
        $output = '<style>
        .itwrl-dismiss-banner{
            position: absolute;
            top: 5px;
            right: 5px;
            color:#868686;
            border:0;
            padding: 0;
            background:transparent;
            cursor:pointer;
        }

        .itwrl-dismiss-banner i{
            color:#fff;
            font-size: 16px;
            vertical-align: middle;
        }

        .itwrl-dismiss-banner:hover,
        .itwrl-dismiss-banner:focus{
            color:#fff;
        }

        .itwrl-middle-button{
            border: 0;
            padding: 0 15px;
            background: #FF5C00;
            float: right;
            margin: 20px 130px;
            cursor: pointer;
            height: 50px;
            font-size: 16px;
            border-radius: 7px;
            -moz-border-radius: 7px;
            -webkit-border-radius: 7px;
        }
        </style>';
        $output .= '<div class="notice" style="background-color:#190b23; border: 0; padding: 0;"><div style="width: 100%; height: 90px; display: inline-block; text-align: left;">';
        $output .= '<a style="width: 100%; float: left; position: relative;" href="' . esc_url($url) . '" target="_blank">';
        $output .= '<img style="float: left; margin: 15px 0 0 10px;" src="' . ITWRL_IMAGES_URL . 'banner-left.png" height="60px">';
        $output .= '<img style="float: right;" src="' . ITWRL_IMAGES_URL . 'banner-right.png" width="auto" height="90px">';
        $output .= '<button type="button" class="itwrl-middle-button">GRAB NOW - TILL 5 NOV</button>';
        $output .= '<form action="' . esc_url(admin_url('admin-post.php')) . '" method="post"><input type="hidden" name="action" value="itwrl_halloween_banner_dismiss"><button class="itwrl-dismiss-banner" type="submit"><i class="dashicons dashicons-dismiss"></i></button></form>';
        $output .= '</a>';
        $output .= '</div></div>';

        echo sprintf('%s', $output);
    }

    public function halloween_banner_dismiss()
    {
        update_option('it_halloween_banner_dismissed', 'yes');
        return wp_safe_redirect(wp_get_referer());
    }
}