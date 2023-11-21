<?php

	/**
	* Plugin Name: Dropship Master
	* Description: Send your supplier an Excel file for each order with the respective fields selected
	* Version: 0.1
	* Author: Asaf Bushari
	* Author URI: https://dropshipmaster.com
	*/

	// namespace DSM;
	

	if( ! defined( 'ABSPATH' ) ){
	
		echo 'You have no premision!';	
		exit;

	}

	
	define('DSM_FILE_PATH', plugin_dir_path(__FILE__));
	define('DSM_PLUGIN_PATH', __FILE__);
	
	require_once( 'src/MenuCreator.php' );
	require_once( 'src/Supplier.php' );
	
	new MenuCreator;
	new Supplier;
	
	
	

	
	

	
