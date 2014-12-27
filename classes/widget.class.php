<?php
defined( 'ABSPATH' ) or die ('No direct load !');

/**
 * Adds TAW_Widget widget.
 */
class TAW_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'TAW_widget', // Base ID
            __( 'API Tuto.com', TAW_TEXTDOMAIN ), // Name
            array( 'description' => __( 'Allows to grab data from tuto.com', TAW_TEXTDOMAIN ), ) // Args
        );
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

        if( empty( $instance['apikey'] ) || empty( $instance['apilogin'] ) || empty( $instance['apisecret'] ) ) {

            echo __( 'The widget configuration is wrong !', TAW_TEXTDOMAIN );

        }

        echo $this->get_stats( $instance['apikey'], $instance['apilogin'], $instance['apisecret'] );

        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $apikey = ! empty( $instance['apikey'] ) ? $instance['apikey'] : '';
        $apilogin = ! empty( $instance['apilogin'] ) ? $instance['apilogin'] : '';
        $apisecret = ! empty( $instance['apisecret'] ) ? $instance['apisecret'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'apikey' ); ?>"><?php _e( 'API Key:', TAW_TEXTDOMAIN ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'apikey' ); ?>" name="<?php echo $this->get_field_name( 'apikey' ); ?>" type="text" value="<?php echo esc_attr( $apikey ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'apilogin' ); ?>"><?php _e( 'API Login:', TAW_TEXTDOMAIN ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'apilogin' ); ?>" name="<?php echo $this->get_field_name( 'apilogin' ); ?>" type="text" value="<?php echo esc_attr( $apilogin ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'apisecret' ); ?>"><?php _e( 'API Secret:', TAW_TEXTDOMAIN ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'apisecret' ); ?>" name="<?php echo $this->get_field_name( 'apisecret' ); ?>" type="text" value="<?php echo esc_attr( $apisecret ); ?>">
        </p>
    <?php
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
        $instance['apikey'] = ( ! empty( $new_instance['apikey'] ) ) ? strip_tags( $new_instance['apikey'] ) : '';
        $instance['apilogin'] = ( ! empty( $new_instance['apilogin'] ) ) ? strip_tags( $new_instance['apilogin'] ) : '';
        $instance['apisecret'] = ( ! empty( $new_instance['apisecret'] ) ) ? strip_tags( $new_instance['apisecret'] ) : '';

        $this->delete_cache($instance['apikey'],  $instance['apilogin'], $instance['apisecret']);

        return $instance;
    }

    /**
     * Use the library to get data
     *
     * @link http://api.tuto.com/docs/
     * @param string $apikey
     * @param string $apilogin
     * @param string $apisecret
     *
     * @return $transient
     */
    protected function get_stats($apikey, $apilogin, $apisecret){

        $output = '@(-_-)@';

        // quick cache WP
        $transient = get_site_transient( md5($apikey . $apilogin . $apisecret) );

        if( false === $transient ) {

            // to generate digest and call API
            require( TAW_DIR . 'library/vendor/autoload.php' );

            // we could - maybe we should - use HTTP API but here we have a wrapper
            // let's make it quick before 1.0
            $client = new Tuto\Client($apikey);
            $client->setCredentials($apilogin, $apisecret);

            try {
                $stats = $client->contributor->statistics('common');
                if( is_array($stats) ){
                    // call view
                    require(TAW_DIR . 'view/widget-output.php');
                }
            } catch (Exception $e) {
                $output =  $e->getMessage();
            }

            set_site_transient( md5($apikey . $apilogin . $apisecret), $output, DAY_IN_SECONDS );// seems enough, ~ 1 refresh per day
        }

        return $transient;
    }

    /**
     * Delete cache
     * @param $apikey
     * @param $apilogin
     * @param $apisecret
     */
    protected function delete_cache($apikey, $apilogin, $apisecret){

        delete_site_transient( md5($apikey . $apilogin . $apisecret) );

    }

} // class TAW_Widget
