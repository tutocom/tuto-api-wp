<?php
defined('ABSPATH') or die('No direct load !');

?>
<div class="wrap taw-settings">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <?php if ( isset( $_GET['settings-updated'] ) ) echo "<div class='updated'><p>".__('Settings saved.')."</p></div>"; ?>

    <form class="simple-mm-form" method="POST" action="options.php">
        <?php settings_fields( TAW_SLUG ); ?>
        <fieldset>
            <legend class="hide-text"><?php _e('Options'); ?></legend>
            <p><a href="//fr.tuto.com/compte/vendeur/informations/api/"><?php _e( 'Get your keys', TAW_TEXTDOMAIN ); ?></a></p>
            <p>
                <label for="taw-apikey"><strong><?php _e( 'API Key:', TAW_TEXTDOMAIN );  ?></strong></label><br/>
                <input type="text" id="taw-apikey" name="taw_stats[apikey]" value="<?php echo esc_attr( $opts['apikey'] );?>" class="regular-text code" />
            </p>
            <p>
                <label for="taw-apilogin"><strong></trong><?php _e( 'API Login:', TAW_TEXTDOMAIN ); ?></strong></label><br/>
                <input type="text" id="taw-apilogin" name="taw_stats[apilogin]" value="<?php echo esc_attr( $opts['apilogin']);?>" class="regular-text code" />
            </p>
            <p>
                <label for="taw-apisecret"><strong><?php _e( 'API Secret:', TAW_TEXTDOMAIN ); ?></strong></label><br/>
                <input type="text" id="taw-apisecret" name="taw_stats[apisecret]" value="<?php echo esc_attr( $opts['apisecret'] );?>" class="regular-text code" />
            </p>
            <p>
                <label for="taw-usedefault"><strong><?php _e( 'Use default widget ?', TAW_TEXTDOMAIN ); ?></strong></label><br />
                <select id="taw-usedefault" name="taw_stats[use_default]">
                    <option value="1" <?php selected( $opts['use_default'], 1) ;?>><?php _e( 'Yes', TAW_TEXTDOMAIN ); ?></option>
                    <option value="0" <?php selected( $opts['use_default'], 0) ;?>><?php _e( 'No', TAW_TEXTDOMAIN ); ?></option>
                </select>
            </p>
            <?php submit_button(null, 'primary', '_submit'); ?>
        </fieldset>
        <p><?php _e( 'You can choose which statistics you want to show. By default all statistics will be displayed by the widget Tuto.com but you can easily change it. Just select "no" for the option "Use default widget" and use the following special markers :', TAW_TEXTDOMAIN ); ?></p>
        <p><strong>%CUSTOMERS_COUNT%, %SALES_COUNT%,%TUTORIALS_COUNT%,%AVERAGE_RATING%</strong></p>
    </form>
</div>