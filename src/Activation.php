<?php


class Activation {

    public static function Activate() {

        add_action( 'admin_init', array( __CLASS__ , 'check_plugins_exist' ) );

    }

    public static function check_plugins_exist(){

        if( ! is_plugin_active('woocommerce/woocommerce.php') ) wp_die('woocommerce must have installed for using ' . PLUGIN_NAME );
        else wp_die('<h1>plugins_exist</h1>');
		deactivate_plugins(DSM_PLUGIN_PATH);

    }

} 