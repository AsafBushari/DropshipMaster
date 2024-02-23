<?php


class Activation {

    public static function deactivate_if_requierd_plugins_unexist () {

        if( ! is_plugin_active('woocommerce/woocommerce.php') ) 
        {
            
            add_action('admin_notices', function () {

                ?>
                
                <div class="error">
                    <p><?php _e('
                    <ul>
                    There was an issue with <b>Dropship Master</b>.
                    <li>WooCommerce must be active on this site!</li>
                    </ul>
                    ', ''); ?></p>
                </div>
                
                <?php
            
            });

            deactivate_plugins( plugin_basename( DSM_INDEX_PATH ) );
        
        }
        
    }

} 