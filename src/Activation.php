<?php


class Activation {

    public static function deactivate_if_requierd_plugins_unexist () {

        if( ! is_plugin_active('woocommerce/woocommerce.php') ) 
        {
            
            add_action('admin_notices', function () {

                ?>
                
                <div class="error">
                    <p><?php _e('There was an issue with <b>Dropship Master</b>. <br> WooCommerce must be active on this site!', ''); ?></p>
                </div>
                
                <?php
            
            });

            deactivate_plugins(plugin_basename( DSM_INDEX_PATH ));
        
        
        }
    

        
    }

} 