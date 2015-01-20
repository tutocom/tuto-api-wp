<?php
defined( 'ABSPATH' ) or die ('No direct load !');

if( ! class_exists('TAW_Admin') ) {
    /**
     * Class TAW_Admin
     */
    class TAW_Admin{

        /**
         * @var
         */
        private $TAW_Admin_Page;

        public function __construct(){
            add_action('admin_menu', array($this, 'add_menu_page'));
        }

        /**
         * Set menu page
         */
        public function add_menu_page(){
            $this->TAW_Admin_Page =
                add_menu_page(
                    __('Tuto.com', TAW_TEXTDOMAIN),
                    __('Tuto.com', TAW_TEXTDOMAIN),
                    'manage_options',
                    strtolower(__CLASS__),
                    array($this, 'admin_page'),
                    TAW_URL . 'assets/img/logo.png'
                );

            register_setting(TAW_SLUG, 'taw_stats');
        }

        /**
         * Grab view
         */
        public function admin_page(){
            $opts = self::get_options();
            $data = get_site_transient( md5($opts['apikey'] . $opts['apilogin'] . $opts['apisecret']) );
            require(TAW_DIR . 'views/admin/settings.php');
        }

        /**
         * @param $options
         * @return array
         */
        protected static function sanitize($options){
            return array_merge(self::get_options(), self::sanitize_options($options));
        }

        /**
         * @param $options
         * @return array
         */
        protected static function sanitize_options($options){
            $new = array();
            if (!is_array($options))
                return $new;
            if (isset($options['apikey']))
                $new['apikey'] = strip_tags(esc_attr($options['apikey']));
            if (isset($options['apilogin']))
                $new['apilogin'] = strip_tags(esc_attr($options['apilogin']));
            if (isset($options['apisecret']))
                $new['apisecret'] = strip_tags(esc_attr($options['apisecret']));
            if (isset($options['use_default']))
                $new['use_default'] = (int) $options['use_default'];

            return $new;
        }

        /**
         * @return array
         */
        protected static function get_options(){
            $options = get_option('taw_stats');
            return array_merge(TAW_Init::get_default_options(), self::sanitize_options($options));
        }

    }
}