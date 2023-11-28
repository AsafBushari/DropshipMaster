<?php

	/**
	* Plugin Name: Dropship Master
	* Description: Send your supplier an Excel file for each order with the respective fields selected
	* Version: 0.1
	* Author: Asaf Bushari
	*/

	// namespace DSM;
	

	if( ! defined( 'ABSPATH' ) ){
	
		echo 'You have no premision!';
		exit;
									
	}

	define('DSM_DIR_PATH', plugin_dir_path( __FILE__ ) );
	define('DSM_INDEX_PATH', __FILE__ );
	define('PLUGIN_NAME', 'DropshipMaster');
	
	add_action( 'admin_init', function () {

		require_once 'src/Activation.php';
		Activation::deactivate_if_requierd_plugins_unexist();

	} );

	require_once( 'src/MenuCreator.php' );
	require_once( 'src/Supplier.php' );
	
	new MenuCreator;
	new Supplier;
	
	
	

	
	

	

