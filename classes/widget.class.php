<?php
defined( 'ABSPATH' ) or die ('No direct load !');

/**
 * Class TAW_Widget
 */
class TAW_Widget extends WP_Widget {

    const API_HOST = 'https://api.tuto.com';
    const API_VERSION = '0.2';
    const API_ENDPOINT = 'contributor/statistics/common';

    /**
     * @var
     */
    protected $opts;

    function __construct() {

        $this->opts = get_option( 'taw_stats' );

        parent::__construct(
            'TAW_widget', // Base ID
            __( 'API Tuto.com', TAW_TEXTDOMAIN ), // Name
            array( 'description' => __( 'Allows to grab data from tuto.com', TAW_TEXTDOMAIN ), ) // Args
        );

        // could be usefull too
        add_action( 'wp_dashboard_setup', array($this, 'add_dashboard_widget') );

        // style widget
        add_action( 'admin_enqueue_scripts', array($this, 'add_basic_styles') );
    }

    /**
     * @param $hook_suffix
     */
    public function add_basic_styles($hook_suffix){
        if( $hook_suffix == 'index.php'  ) {
            wp_enqueue_style( 'taw-default', TAW_URL . 'assets/css/admin/widget.css', array(), TAW_VERSION );
        }
    }

    /**
     * Just display stats in a dashboard widget
     */
    public function add_dashboard_widget(){

        wp_add_dashboard_widget(
            'tuto_dashboard_widget',// Widget slug.
            'Tuto.com',// Title.
            array( $this, 'add_dashboard_widget_content' ) // Display function.
        );

    }

    /**
     * Grab stats and echo in widget
     */
    public function add_dashboard_widget_content(){

        echo $this->display_stats(1);

    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {

        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }

        if( ( empty( $this->opts['apikey'] ) || empty( $this->opts['apilogin'] ) || empty( $this->opts['apisecret'] ) )

            || (  $this->opts['use_default'] != 1 && empty( $instance['custom_code'] ) )

        ) {

            echo __( 'The widget configuration is wrong !', TAW_TEXTDOMAIN );

        }

        echo $this->display_stats($this->opts['use_default'], $instance['custom_code']);

        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     * @see WP_Widget::form()
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $custom_code = ! empty( $instance['custom_code'] ) ? $instance['custom_code'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>

        <?php if( 1 !== $this->opts['use_default'] ) : ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'custom_code' ); ?>"><?php _e( 'Code' ); ?></label>
            <textarea rows="10" class="widefat" id="<?php echo $this->get_field_id( 'custom_code' ); ?>" name="<?php echo $this->get_field_name( 'custom_code' ); ?>"><?php echo wp_kses_post( $custom_code ); ?></textarea>
        </p><em><strong>%CUSTOMERS_COUNT%, %SALES_COUNT%,%TUTORIALS_COUNT%, %AVERAGE_RATING%</strong></em>
        <?php endif;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['custom_code'] = ( ! empty( $new_instance['custom_code'] ) ) ? wp_kses_post(  $new_instance['custom_code'] ) : '';

        $this->delete_cache($this->opts['apikey'], $this->opts['apilogin'], $this->opts['apisecret']);

        return $instance;
    }

    /**
     * @param $apikey
     * @param $apilogin
     * @param $apisecret
     * @return array|mixed|string
     */
    protected function get_stats($apikey, $apilogin, $apisecret ){

        // quick cache WP
        $data = get_site_transient( md5($apikey . $apilogin . $apisecret) );

        if( false === $data ) {

            $url  = self::API_HOST . '/' . self::API_VERSION . '/' . self:: API_ENDPOINT;
            $args = array(
                'headers' => array(
                    'X-API-KEY' => $apikey,
                    'Authorization' => 'Basic ' .  base64_encode($apilogin .':'.$apisecret ),// thanks remiheens for making this endpoint available with Basic :)
                    )
            );

            try {

                $response = wp_remote_get( $url, $args );
                $response_code = wp_remote_retrieve_response_code( $response );
                $response_mess = wp_remote_retrieve_response_message( $response );

                if( 200 === $response_code ){
                    $data = json_decode( wp_remote_retrieve_body( $response ), true );
                } else {
                    $this->delete_cache($apikey, $apilogin, $apisecret);
                    $data  =  __('The API returns this message (only users with right permissions can see this message) :', TAW_TEXTDOMAIN ) ."\n";
                    $data .= '<strong>' . $response_code . ' : ' . $response_mess . '</strong>';
                    return current_user_can( 'manage_options' ) ? $data : '';
                }

            } catch (Exception $e) {
                $this->delete_cache($apikey, $apilogin, $apisecret);
                $data  =  __('The API returns this message (only users with right permissions can see this message) :', TAW_TEXTDOMAIN ) ."\n";
                $data .= '<strong>' . $e->getMessage() . '</strong>';
                return current_user_can( 'manage_options' ) ? $data : '';
            }

            set_site_transient( md5($apikey . $apilogin . $apisecret), $data, DAY_IN_SECONDS );// seems enough, ~ 1 refresh per day
        }

        return $data;
    }

    /**
     * @param bool $use_default
     * @param bool $custom_code
     * @return array|mixed|string
     */
    public function display_stats($use_default = false, $custom_code = false){

        $data = $this->get_stats($this->opts['apikey'], $this->opts['apilogin'], $this->opts['apisecret']);

        if ( is_array($data) ){

            $stat = reset($data);
            $apilogin = $this->opts['apilogin'];

            $output = '';

            require(TAW_DIR . 'views/client/widget-output.php');

            return $output;
        }

        return $data;
    }

    /**
     * @param $apikey
     * @param $apilogin
     * @param $apisecret
     */
    protected function delete_cache($apikey, $apilogin, $apisecret){

        delete_site_transient( md5($apikey . $apilogin . $apisecret) );

    }

} // class TAW_Widget
