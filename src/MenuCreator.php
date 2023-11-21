<?php

$product_field_names_list = array(
	'name' => 'Product Name',
	'quantity' => 'Product Quantity',
	'total' => 'Product Price'
);

$order_field_names_list = array(
	'id' => 'Order id',
	'status' => 'Status',
	'date_created' => 'Date created',
);

$billing_field_names_list = array(
	'first_name' => 'First Name',
	'last_name' => 'Last Name',
	'email' => 'Email',
	'phone' => 'Phone Number',
	'company' => 'Company Name',
	'state' => 'State',
	'country' => 'Country',
	'city' => 'City',
	'address_1' => 'Address 1',
	'address_2' => 'Address 2',
	'postcode' => 'Postcode',
);

$shipping_field_names_list = array(
	'first_name' => 'First Name',
	'last_name' => 'Last Name',
	'company' => 'Company Name',
	'state' => 'State',
	'country' => 'Country',
	'city' => 'City',
	'address_1' => 'Address 1',
	'address_2' => 'Address 2',
	'postcode' => 'Postcode',
);

class MenuCreator {

    public function __construct() {

        add_action( 'admin_menu',  array( $this, 'DSM_create_menu' ) );
        add_action( 'admin_init', array( $this, 'DSM_admin_init_func' ) );

    }

    // ** admin_menu ** //
	public function DSM_create_menu() {

		add_menu_page(

			'DropshipMaster', // Page title
			'DropshipMaster', // Menu title
			'manage_options', // Capability
			'dropshipmaster-options', // Menu slug
			array( $this, 'DSM_create_options_page_func' ), // Page content function
			'dashicons-smiley', // Menu icon
			99

		);
	
	}

	public function DSM_create_options_page_func() {

        settings_errors(); // Wordpress handling the alerts

		echo '<div class="wrap">';
		echo '<h2>Welcome To <b>Dropship Master</b> Setup Page</h2>';
		echo '<form action="options.php" method="post">';
		settings_fields( 'DSM_options_group' );
		do_settings_sections( 'dropshipmaster-options' );
		submit_button( 'Save Changes', 'primary' );
		echo '</form>';
		echo '</div>';
	
	}

    // ** admin_init ** //
	public function DSM_admin_init_func() {

		die(DSM_PLUGIN_PATH);
		deactivate_plugins('/DropshipMaster/plugin.php');

		// Settings API
		register_setting( 'DSM_options_group', 'DSM_supplier_mail' );
		register_setting( 'DSM_options_group', 'DSM_selected_product_fields' );
		register_setting( 'DSM_options_group', 'DSM_selected_shipping_fields' );
		register_setting( 'DSM_options_group', 'DSM_selected_billing_fields' );
		register_setting( 'DSM_options_group', 'DSM_selected_order_fields' );
		
		add_settings_section(
				
			'first-sec', // HTML ID for the section
			'', // The section title within the h2 Tag
			array( $this, 'set_section_text_callback' ), // Function to get descrption about the section
			'dropshipmaster-options' // The page slug, like the "menu slug"	
	
		);
	
		// mail
		add_settings_field(
	
			'DSM-supplier-mail', // HTML input id
			'Supplier Mail:', // Input label text
			array( $this, 'set_supplier_mail_input_callback' ), // Callback to echo the HTML input
			'dropshipmaster-options', // The page slug, like the "menu slug"
			'first-sec', // Input section id
	
		);

		// Represent order fields to choose
		add_settings_field(
	
			'DSM-order-fields-select', // HTML input id
			'Select Order Fields:', // Input label text
			array( $this, 'set_select_order_fields_input_callback' ), // Callback to echo the HTML input
			'dropshipmaster-options', // The page slug, like the "menu slug"
			'first-sec', // Input section id
	
		);
		
		// Represent product fields to choose
		add_settings_field(
	
			'DSM-product-fields-select', // HTML input id
			'Select Product Fields:', // Input label text
			array( $this, 'set_select_product_fields_input_callback' ), // Callback to echo the HTML input
			'dropshipmaster-options', // The page slug, like the "menu slug"
			'first-sec', // Input section id
	
		);

		// Represent billing fields to choose
		add_settings_field(
	
			'DSM-billing-fields-select', // HTML input id
			'Select Billing Fields:', // Input label text
			array( $this, 'set_select_billing_fields_input_callback' ), // Callback to echo the HTML input
			'dropshipmaster-options', // The page slug, like the "menu slug"
			'first-sec', // Input section id
	
		);
		
		// Represent shipping fields to choose
		add_settings_field(
	
			'DSM-shipping-fields-select', // HTML input id
			'Select Shipping Fields:', // Input label text
			array( $this, 'set_select_shipping_fields_input_callback' ), // Callback to echo the HTML input
			'dropshipmaster-options', // The page slug, like the "menu slug"
			'first-sec', // Input section id
	
		);
		
	}

	public function set_section_text_callback() {

		echo "<p>
		This plugin is designed to enable sending an Excel file to your dropshipping provider.
		<br>
		You can attach specific fields of the order and of the products in the order to the Excel file.
		<br>
		All that is required to be done is to fill in the supplier's email and the necessary fields.
		<br>".
		'<b style="color:#a10000;">If the Supplier Mail field is full, the plugin will send the file with every new order that comes in from the moment of saving changes.</b>
		</p>';
	
	}

	public function set_supplier_mail_input_callback() {

		// Get DSM options
		$supplier_mail = esc_attr( get_option( 'DSM_supplier_mail' ) );

		echo '<input type="email" name="DSM_supplier_mail" value="' . $supplier_mail . '"/>';

	}

	public function set_select_product_fields_input_callback() {

		global $product_field_names_list;
		// Get "DSM_selected_order_fields" option
		// Return empty array if not "DSM_selected_order_fields" exist
		$selected_product_fields_list = get_option( 'DSM_selected_product_fields', array() );

		if ( ! $selected_product_fields_list ) $selected_product_fields_list =  array();
		
		echo '<select multiple="multiple" name="DSM_selected_product_fields[]">';

		foreach( $product_field_names_list as $key => $value ){

			echo '<option value="' . $key . '"' .( in_array( $key,  $selected_product_fields_list ) ? 'selected' : '') . '>' . $value . '</option>';

		}

		echo '</select>';

	}

	public function set_select_order_fields_input_callback() {

		global $order_field_names_list;
		// Get "DSM_selected_order_fields" option
		// Return empty array if not "DSM_selected_order_fields" exist
		$selected_order_fields_list = get_option( 'DSM_selected_order_fields', array() );

		if ( ! $selected_order_fields_list ) $selected_order_fields_list =  array();

		echo '<select multiple="multiple" name="DSM_selected_order_fields[]">';

		foreach( $order_field_names_list as $key => $value ){

			echo '<option value="' . $key . '"' .( in_array( $key,  $selected_order_fields_list ) ? 'selected' : '') . '>' . $value . '</option>';

		}

		echo '</select>';

	}
	
	public function set_select_billing_fields_input_callback() {

		global $billing_field_names_list;
		// Get "DSM_selected_billing_fields" option
		// Return empty array if not "DSM_selected_billing_fields" exist
		$selected_billing_fields_list = get_option( 'DSM_selected_billing_fields', array() );

		if ( ! $selected_billing_fields_list ) $selected_billing_fields_list =  array();

		echo '<select multiple="multiple" name="DSM_selected_billing_fields[]">';

		foreach( $billing_field_names_list as $key => $value ){

			echo '<option value="' . $key . '"' .( in_array( $key,  $selected_billing_fields_list ) ? 'selected' : '') . '>' . $value . '</option>';

		}

		echo '</select>';

	}
	
	public function set_select_shipping_fields_input_callback() {

		global $shipping_field_names_list;
		// Get "DSM_selected_shipping_fields" option
		// Return empty array if not "DSM_selected_shipping_fields" exist
		$selected_shipping_fields_list = get_option( 'DSM_selected_shipping_fields', array() );

		if ( ! $selected_shipping_fields_list ) $selected_shipping_fields_list =  array();

		echo '<select multiple="multiple" name="DSM_selected_shipping_fields[]">';

		foreach( $shipping_field_names_list as $key => $value ){

			echo '<option value="' . $key . '"' .( in_array( $key,  $selected_shipping_fields_list ) ? 'selected' : '') . '>' . $value . '</option>';

		}

		echo '</select>';

	}

}