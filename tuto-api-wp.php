<?php
/*
 * Plugin name: Tuto.com WordPress Wrapper
 * Description: Un widget WordPress pour utiliser l'API auteur de tuto.com dans WordPress
 * Version: 0.0.7
 * Author: Julien Maury
 * Author URI: http://www.tweetpress.fr
 */
/*
Copyright (C) 2014-2015, Julien Maury - contact@tweetpress.fr
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

defined( 'ABSPATH' ) or die ('No direct load !');

define( 'TAW_VERSION', '0.0.7' );
define( 'TAW_DIR', plugin_dir_path(__FILE__) );
define( 'TAW_URL', plugin_dir_url(__FILE__) );
define( 'TAW_LANG_DIR', dirname(plugin_basename(__FILE__)) . '/languages/' );
define( 'TAW_TEXTDOMAIN', 'taw' );
define( 'TAW_SLUG', 'taw-stats' );

// call class
if( is_admin() ){
    require(TAW_DIR. 'classes/admin/init.class.php' );
    require(TAW_DIR. 'classes/admin/admin.class.php' );
}

require( TAW_DIR. 'classes/widget.class.php' );

/**
 *  early init
 */
add_action( 'plugins_loaded', '_taw_init' );
function _taw_init(){
    // i18n
    load_plugin_textdomain( TAW_TEXTDOMAIN, false, TAW_LANG_DIR );

    if( is_admin() ){
        new TAW_Admin();
    }

}

/**
 * register TAW_Widget widget
 */
add_action( 'widgets_init', '_taw_register_widget' );
function _taw_register_widget() {
    register_widget( 'TAW_Widget' );
}

/**
 * on activation
 */
register_activation_hook( __FILE__, array('TAW_Init', 'on_activation') );