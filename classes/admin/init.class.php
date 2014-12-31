<?php
defined('ABSPATH')
or die('No direct load !');

if( ! class_exists('TAW_Init') ) {
    /**
     * Class TAW_Init
     */
    class TAW_Init{

        /**
         * Initialized options on activation
         */
        public static function on_activation(){
            $opts = get_option( 'taw_stats' );
            if (!is_array($opts)) {
                update_option( 'taw_stats', self::get_default_options() );
            }
        }

        /**
         * Return default options
         * @return array
         */
        public static function get_default_options(){
            return array(
                'apikey' => '',
                'apilogin' => '',
                'apisecret' => '',
                'use_default' => 1
            );
        }

    }
}