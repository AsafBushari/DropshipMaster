<?php

require __DIR__ . '/../vendor/autoload.php'; // Adjust the path accordingly
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


 class Supplier {

    public function __construct(){

        add_action( 'woocommerce_order_status_changed', array( $this, 'send_order_details_via_mail' ), 99, 3 );

    }

    public function send_order_details_via_mail($order_id, $old_status, $new_status){

        // wp_mail( 'asafbushari@gmail.com', 'Form dev-site',  'test' );
        // if( $new_status != 'processing' ) return;

        // If empty fields to send to the Supplier, return
        $order = wc_get_order( $order_id );
        $order_data = $order->get_data();
        $order_shipping_data = $order_data['shipping'];
        $order_billing_data = $order_data['billing'];

        $supplier_email = get_option( 'DSM_supplier_mail' );
        $order_fields = get_option( 'DSM_selected_order_fields', array() );
        $product_fields = get_option( 'DSM_selected_product_fields', array() );
        $billing_fields = get_option( 'DSM_selected_billing_fields', array() );
        $shipping_fields = get_option( 'DSM_selected_shipping_fields', array() );
        
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
         
        // Excel start postion point
        $main_title_font_size = 16;
        $first_column_state = 'A';
        $row_jumper = 3;
        $row = 1;
        $column = $first_column_state;
        $loop_counter = 1; 
        /**$nested_loop_counter = 1;**/
        
        // Set excel order data
        $order_fields_length = count( $order_fields );
        foreach( $order_fields as $value ){
            
            // First row in order fields
            // First loop run
            if( $loop_counter == 1 ){

                $sheet->setCellValue( $column . $row , 'Order Details:');
                // Get main title style
                $cell = $sheet->getCell($column . $row);
                $style = $cell->getStyle();
                // Apply main title bold font
                $style->getFont()->setSize($main_title_font_size);

                $row++;
            
            }

            // Set title
            $sheet->setCellValue( $column . $row , $value);
            // Get title style
            $cell = $sheet->getCell($column . $row);
            $style = $cell->getStyle();
            // Apply title bold font
            $style->getFont()->setBold(true); 

            // Set detail
            $sheet->setCellValue( $column . $row + 1 , $order_data[$value]);
            // Get next letter in the alphabet (column)
            $column = strtoupper( ++$column );

            
            // Last loop run
            if( $loop_counter == $order_fields_length ){
                
                $row = $row + $row_jumper;
                $column = $first_column_state;
                $loop_counter = 1;
                
            }
            else $loop_counter++;
             
        }    

        // Set excel billing data
        $billing_fields_length = count( $billing_fields );
        foreach( $billing_fields as $value ){
            
            // First row in billing fields
            // First loop run
            if( $loop_counter == 1 ){

                $sheet->setCellValue( $column . $row , 'Billing Details:'); 
                 // Get main title style
                 $cell = $sheet->getCell($column . $row);
                 $style = $cell->getStyle();
                 // Apply main title bold font
                 $style->getFont()->setSize($main_title_font_size);

                $row++;
            
            }

            // Set title
            $sheet->setCellValue( $column . $row , $value);
             // Get title style
             $cell = $sheet->getCell($column . $row);
             $style = $cell->getStyle();
             // Apply title bold font
             $style->getFont()->setBold(true); 

            // Set detail
            $sheet->setCellValue( $column . $row + 1 , $order_billing_data[$value]);
            // Get next letter in the alphabet (column)
            $column = strtoupper( ++$column );
            
            // Last loop run
            if( $loop_counter == $billing_fields_length ){
                
                $row = $row + $row_jumper;
                $column = $first_column_state;
                $loop_counter = 1;

            }
            else $loop_counter++;
             
        }    

        // Set excel shipping data
        $shipping_fields_length = count( $shipping_fields );
        foreach( $shipping_fields as $value ){
            
            // First row in billing fields
            // First loop run
            if( $loop_counter == 1 ){

                $sheet->setCellValue( $column . $row , 'Shipping Details:'); 
                 // Get main title style
                $cell = $sheet->getCell($column . $row);
                $style = $cell->getStyle();
                // Apply main title bold font
                $style->getFont()->setSize($main_title_font_size);

                $row++;
            
            }

            // Set title
            $sheet->setCellValue( $column . $row , $value);
             // Get title style
             $cell = $sheet->getCell($column . $row);
             $style = $cell->getStyle();
             // Apply title bold font
             $style->getFont()->setBold(true); 

            // Set detail
            $sheet->setCellValue( $column . $row + 1 , $order_shipping_data[$value]);
            // Get next letter in the alphabet (column)
            $column = strtoupper( ++$column );

            // Last loop run
            if( $loop_counter == $shipping_fields_length ){
                
                $row = $row + $row_jumper;
                $column = $first_column_state;
                $loop_counter = 1;

            } 
            else $loop_counter++;
 
        }    
      
        // Set excel products data
        $order_items = $order->get_items();
        $order_items_length = count( $order_items );
        foreach( $order_items as $item ){

            // First row in billing fields
            // First loop run
            if( $loop_counter == 1 ){

                $sheet->setCellValue( $column . $row , 'Product Details:'); 
                 // Get main title style
                $cell = $sheet->getCell($column . $row);
                $style = $cell->getStyle();
                // Apply main title bold font
                $style->getFont()->setSize($main_title_font_size);

                $row++;
                
                foreach( $product_fields as $value ){
                    
                    // Set title
                    $sheet->setCellValue( $column . $row , $value);
                     // Get title style
                    $cell = $sheet->getCell($column . $row);
                    $style = $cell->getStyle();
                    // Apply title bold font
                    $style->getFont()->setBold(true); 

                    // Get next letter in the alphabet (column)
                    $column = strtoupper( ++$column );    
                    
                }   

                $row++;
                $column = $first_column_state;
            
            }
            

            foreach( $product_fields as $value ){
            
                // Set detail
                $sheet->setCellValue( $column . $row , $item[$value]);
                // Get next letter in the alphabet (column)
                $column = strtoupper( ++$column );
                 
            }

            // Go next line for the next product
            $row++;
            $column = $first_column_state;   

            // Last loop run
            if( $loop_counter == $order_items_length ){
                    
                $row = $row + $row_jumper;
                $column = $first_column_state;
                $loop_counter = 1;

            } 
            else $loop_counter++;
            
        }
        
        // Save the spreadsheet to a file
        $filename = ABSPATH . 'new order from ' . get_bloginfo( 'name' ) . '.xlsx'; // Adjust the path accordingly
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        // Email configuration
        $to = $supplier_email; // Replace with the recipient's email address
        $subject = 'New Order Recived From: '. get_bloginfo( 'name' );
        $body = 'Please find attached the Hello World spreadsheet.';
        $headers = array('Content-Type: text/html; charset=UTF-8');

        // Attach the spreadsheet to the email
        $attachments = array($filename);

        // Send the email using wp_mail
        wp_mail($to, $subject, $body, $headers, $attachments);

        $orderFields = get_option( 'DSM_selected_order_fields', array() );            
        $product_fields = get_option( 'DSM_selected_product_fields', array() );      

    }

}
