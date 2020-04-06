<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_order extends User_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model( array( 
			'purchase_order_model', 
			'material_model', 
			'vendor_model', 
			'product_model', 
			'company_model', 
			'delivery_address_model', 
			'delivery_order_model',
			'do_log_model',
			'car_model',
			'do_report_model',
			'do_news_and_tax_model',
			"tax_invoice_model",
		) ); 
		$this->load->library( array( 'form_validation' ) ); 
		if(!$this->ion_auth->is_admin()) 
		{
			$company = $this->company_model->companies( $this->ion_auth->get_user_id() )->row();
			if( $company == NULL ) redirect( site_url("user/") );
		}
	} 
	public function index()
	{
		// TODO : halaman dashbord untuk user yang sudah terdaftar 
		$this->data[ "page_title" ] = "Purchase order";
		$vendors  = $this->vendor_model->vendors(  )->result();
		$products = $this->product_model->products(  )->result();
		$company = $this->company_model->companies( $this->ion_auth->get_user_id() )->row();
		
		$delivery_addresses = $this->delivery_address_model->delivery_addresses( $company->id )->result();
		if( empty( $products ) || empty( $delivery_addresses ) ) redirect(site_url('user'));
		
		$materials  = $this->material_model->materials( $products[0]->id )->result();
		$company = $this->company_model->companies( $this->ion_auth->get_user_id() )->row();
		$delivery_addresses = $this->delivery_address_model->delivery_addresses( $company->id )->result();

		// $this->data[ "purchase_orders" ]  = $this->purchase_order_model->user_purchase_orders( $company->id )->result();
		// ////////
		$_limit_segment 	= 4;
		$_number_segment 	= 5;
		if ($this->uri->segment( $_limit_segment ) != "") {
			$limit = $this->uri->segment( $_limit_segment );
		} else {
			$limit = 10;
		}

		$page              		= ($this->uri->segment( $_number_segment )) ? $this->uri->segment( $_number_segment ) : 0;
		$base_url = base_url() . "user/purchase_order/index/";
		$this->data["links"]    = $this->_get_pagination( $limit, $this->purchase_order_model->record_count(), $_number_segment, $base_url );

		$this->data[ "purchase_orders" ]  = $this->purchase_order_model->purchase_orders_limit( $limit , $page, $company->id  )->result();

		$search = $this->input->get("search", FALSE);
		// echo $search;return;
		if( $search != FALSE )
		{
			$this->data[ "purchase_orders" ]  	= $this->purchase_order_model->search( $search, $company->id  )->result();
			// echo var_dump( $this->purchase_order_model );return;
		}
		$this->data[ "search" ]  			= trim( $search );	
		// ////////
		foreach( $vendors as $vendor )
		{
			$vendor_select[ $vendor->id ] = $vendor->name;
		}
		foreach( $materials as $material )
		{
			$material_select[ $material->id ] = $material->name;
		}
		foreach( $products as $product )
		{
			$product_select[ $product->id ] = $product->name;
		}
		foreach( $delivery_addresses as $delivery_address )
		{
			$delivery_address_select[ $delivery_address->id ] = $delivery_address->code." => ".$delivery_address->name;
		}
		$this->data['vendor_id'] = array(
			'name' => 'vendor_id',
			'id' => 'vendor_id',
			'type' => 'text',
			'placeholder' => 'Vendor',
			'class' => 'form-control',
			'options' => $vendor_select,
		);
		$this->data['product_id'] = array(
			'name' => 'product_id',
			'id' => 'product_id',
			'type' => 'text',
			'placeholder' => 'Produk',
			'class' => 'form-control',
			'options' => $product_select,
		);
		$this->data['material_id'] = array(
			'name' => 'material_id',
			'id' => 'material_id',
			'type' => 'text',
			'placeholder' => 'Material',
			'class' => 'form-control',
			'options' => $material_select,
		);
		$this->data['delivery_address_id'] = array(
			'name' => 'delivery_address_id',
			'id' => 'delivery_address_id',
			'type' => 'text',
			'placeholder' => 'Alamat Serah',
			'class' => 'form-control',
			'options' => $delivery_address_select,
		);
		$this->data['quantity'] = array(
			'name' => 'quantity',
			'id' => 'quantity',
			'type' => 'number',
			'min' => 1,
			'placeholder' => 'Jumlah',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('quantity'),
		);

		$this->render( "user/purchase_order/V_list" );
	}	

	public function order_confirm(  )
	{
		$this->data[ "page_title" ] = "Konfirmasi ";
		if( !($_POST) )	redirect(site_url('user/purchase_order'));


		$this->form_validation->set_rules('vendor_id', ('vendor_id'), 'trim|required');
		$this->form_validation->set_rules('product_id', ('product_id'), 'trim|required');
		$this->form_validation->set_rules('material_id', ('material_id'), 'trim|required');
		$this->form_validation->set_rules('delivery_address_id', ('delivery_address_id'), 'trim|required');
		$this->form_validation->set_rules('quantity', ('Jumlah'), 'trim|required');

		if ($this->form_validation->run() === TRUE )
		{
			$this->data[ "company" ] = $this->company_model->companies(  $this->ion_auth->get_user_id()  )->row();
			$this->data[ "vendor" ] = $this->vendor_model->vendor( $this->input->post( 'vendor_id' ) )->row();
			$delivery_address = $this->delivery_address_model->delivery_address( $this->input->post( 'delivery_address_id' ) )->row();
			$this->data[ "delivery_address" ] = $delivery_address;
			// echo var_dump( $delivery_address );return;
			
			$material = $this->material_model->material( $this->input->post( 'material_id' ) )->row();
			$quantity = $this->input->post( 'quantity' ) ;
			$discount = $delivery_address->discount;
			$price = ( date("d") <= 14 ) ? $material->price_1 : $material->price_2 ;
			$price = ceil( $price - ( $price * $discount ) );
			$subtotal = $price * $quantity;
			// var_dump( $delivery_address->pbbkb * 100 );
			// die;
			$this->data[ "price" ] = $price;
			$this->data[ "material" ] 	= $material;
			$this->data[ "quantity" ] 	=  $quantity ;
			$this->data[ "subtotal" ] 	=  $subtotal  ;
			$this->data[ "ppn" ] 		=  $subtotal * 10/100  ;
			$this->data[ "pph" ] 		=  $subtotal * $this->data[ "company" ]->pph;
			$this->data[ "pbbkb" ] 		=  $subtotal * $delivery_address->pbbkb ;
			$this->data[ "total" ] 		=	$this->data[ "subtotal" ]+ $this->data[ "ppn" ]+  $this->data[ "pbbkb" ] +$this->data[ "pph" ] ;
			
			$this->render( "user/purchase_order/V_confirn" );
		}
		else
		{
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->product_model->errors() ? $this->product_model->errors() : $this->session->flashdata('message')));
				if(  validation_errors() || $this->product_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
				
				redirect(site_url('user/purchase_order'));
		}
	}
	public function order(  )
	{
		$this->data[ "page_title" ] = "Konfirmasi ";
		if( !($_POST) )	redirect(site_url('user/purchase_order'));


		$this->form_validation->set_rules('vendor_id', ('vendor_id'), 'trim|required');
		$this->form_validation->set_rules('product_id', ('product_id'), 'trim|required');
		$this->form_validation->set_rules('material_id', ('material_id'), 'trim|required');
		$this->form_validation->set_rules('delivery_address_id', ('delivery_address_id'), 'trim|required');
		$this->form_validation->set_rules('quantity', ('Jumlah'), 'trim|required');

		if ($this->form_validation->run() === TRUE )
		{
				$this->data[ "company" ] = $this->company_model->companies(  $this->ion_auth->get_user_id()  )->row();
				$this->data[ "vendor" ] = $this->vendor_model->vendor( $this->input->post( 'vendor_id' ) )->row();
				$delivery_address = $this->delivery_address_model->delivery_address( $this->input->post( 'delivery_address_id' ) )->row();
				$this->data[ "delivery_address" ] = $delivery_address;
				
				$material = $this->material_model->material( $this->input->post( 'material_id' ) )->row();
				$quantity = $this->input->post( 'quantity' ) ;
				$discount = $delivery_address->discount;
				$price = ( date("d") <= 14 ) ? $material->price_1 : $material->price_2 ;
				
				$price = ceil( $price - ( $price * $discount ) );
				$subtotal = $price * $quantity;
				$this->data[ "price" ] = $price;
				$this->data[ "material" ] 	= $material;
				$this->data[ "quantity" ] 	=  $quantity ;
				$this->data[ "subtotal" ] 	=  $subtotal  ;
				$this->data[ "ppn" ] 		=  $subtotal * 10/100  ;
				$this->data[ "pph" ] 		=  $subtotal * $this->data[ "company" ]->pph;
				$this->data[ "pbbkb" ] 		=  $subtotal * $delivery_address->pbbkb ;
				$this->data[ "total" ] 		=	$this->data[ "subtotal" ]+ $this->data[ "ppn" ]+  $this->data[ "pbbkb" ] +$this->data[ "pph" ] ;

				// echo var_dump( $this->data[ "total" ] ); return;
				$data["vendor_id"] 					= $this->input->post( 'vendor_id' );
				$data["product_id"] 				= $this->input->post( 'product_id' );
				$data["material_id"] 				= $this->input->post( 'material_id' );
				$data["quantity"] 					= $this->input->post( 'quantity' );
				$data["delivery_address_id"] 		= $this->input->post( 'delivery_address_id' );
				$data["sub_total"] 					= $this->data[ "subtotal" ];
				$data["ppn"] 						= $this->data[ "ppn" ];
				$data[ "pph" ] 						= $this->data[ "pph" ];
				$data["pbbkb"] 						= $this->data[ "pbbkb" ];
				$data["total"] 						= $this->data[ "total" ];
				$data["price"] 						= $this->data[ "price" ];
				$data["date"] 						=  time();
				
				if($this->purchase_order_model->create( $data ) )
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->purchase_order_model->messages() ) );
				}
				else
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->purchase_order_model->errors() ) );
				}
				redirect(site_url('user/purchase_order'));
		}
		else
		{
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->purchase_order_model->errors() ? $this->purchase_order_model->errors() : $this->session->flashdata('message')));
				if(  validation_errors() || $this->purchase_order_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
				
				redirect(site_url('user/purchase_order'));
		}
	}
	public function detail( $purchase_order_id = NULL )
	{
		if( $purchase_order_id == NULL ) redirect(site_url('user/purchase_order')); 
		$this->data[ "delivery_orders" ] = $this->delivery_order_model->delivery_orders( $purchase_order_id )->result();
		$this->data[ "page_title" ] = "Detail ";
		
		$purchase_order  = $this->purchase_order_model->purchase_order( $purchase_order_id )->row();
		if( $purchase_order == NULL )
		{
			redirect(site_url('user/purchase_order')); 
		}
		
		$this->data[ "purchase_order" ] = $purchase_order;

		$this->data[ "company" ] = $this->company_model->company(  $purchase_order->company_id  )->row();
		$this->data[ "vendor" ] = $this->vendor_model->vendor( $purchase_order->vendor_id )->row();
		$delivery_address = $this->delivery_address_model->delivery_address( $purchase_order->delivery_address_id )->row();
		$this->data[ "delivery_address" ] = $delivery_address;
		// if( $this->data[ "purchase_order" ]->status = 2 )
		// {
			$this->data[ "tax_invoice" ] 	= $this->tax_invoice_model->tax_invoices( $purchase_order->id )->row();
		// }
		$material = $this->material_model->material( $purchase_order->material_id )->row();

		$this->data[ "price" ] = $purchase_order->price;
		$this->data[ "material" ] = $material;
		$this->data[ "quantity" ] =  $purchase_order->quantity ;
		$this->data[ "subtotal" ] =  $purchase_order->sub_total  ;
		$this->data[ "ppn" ] =  $purchase_order->ppn;
		$this->data[ "pph" ] =  $purchase_order->pph;
		$this->data[ "pbbkb" ] =  $purchase_order->pbbkb ;
		$this->data[ "total" ] = $purchase_order->total ;
		$this->data[ "date" ] =  date( "d/m/Y" , $purchase_order->date )  ;
		$this->render( "user/purchase_order/V_detail" );
	}
	public function do_detail( $delivery_order_id = NULL )
	{
		if( $delivery_order_id == NULL  ) redirect(site_url('admin/')); 

		$this->data[ "page_title" ] = "Delivery order";
		// $user_id = $this->ion_auth->get_user_id();
		$this->data[ "delivery_order" ] 	= $this->delivery_order_model->delivery_order( $delivery_order_id )->row();
		$this->data[ "purchase_order" ] 	= $this->purchase_order_model->purchase_order( $this->data[ "delivery_order" ]->purchase_order_id )->row();
		$this->data[ "delivery_address" ] 	= $this->delivery_address_model->delivery_address( $this->data[ "purchase_order" ]->delivery_address_id )->row();
		$this->data[ "company" ] 			= $this->company_model->company(  $this->data[ "purchase_order" ]->company_id  )->row();
		$this->data[ "vendor" ] 			= $this->vendor_model->vendor( $this->data[ "purchase_order" ]->vendor_id )->row();
		$this->data[ "material" ] 			= $this->material_model->material( $this->data[ "purchase_order" ]->material_id )->row();
		// echo var_dump( $this->data[ "delivery_orders" ] );return;
		$this->data[ "do_logs" ] 			= $this->do_log_model->logs( $delivery_order_id )->result();
		if( $this->data[ "delivery_order" ]->status = 2 )
		{
			$this->data[ "do_report" ] 	= $this->do_report_model->do_reports( $delivery_order_id )->row();
			$this->data[ "do_news_and_tax" ] 	= $this->do_news_and_tax_model->do_news_and_taxes( $delivery_order_id )->row();
		}

		$this->render( "admin/delivery_order/V_detail" );
	}

	public function generate_pre_invoice_pdf( $purchase_order_id )
	{
		// die;
		$purchase_order  = $this->purchase_order_model->purchase_order( $purchase_order_id )->row();
		if( $purchase_order_id == NULL || $purchase_order == NULL ) redirect(site_url('admin/purchase_order')); 

		$this->data[ "delivery_orders" ] = $this->delivery_order_model->delivery_orders( $purchase_order_id )->result();

		$this->data[ "page_title" ] = "Detail ";
		$this->data[ "purchase_order" ] = $purchase_order;

		$this->data[ "company" ] = $this->company_model->company(  $purchase_order->company_id  )->row();
		$this->data[ "vendor" ] = $this->vendor_model->vendor( $purchase_order->vendor_id )->row();
		$delivery_address = $this->delivery_address_model->delivery_address( $purchase_order->delivery_address_id )->row();
		$this->data[ "delivery_address" ] = $delivery_address;
		
		$material = $this->material_model->material( $purchase_order->material_id )->row();

		$this->data[ "price" ] = $purchase_order->price;
		$this->data[ "material" ] = $material;
		$this->data[ "quantity" ] =  $purchase_order->quantity ;
		$this->data[ "subtotal" ] =  $purchase_order->sub_total  ;
		$this->data[ "ppn" ] =  $purchase_order->ppn;
		$this->data[ "pph" ] =  $purchase_order->pph;
		$this->data[ "pbbkb" ] =  $purchase_order->pbbkb ;
		$this->data[ "total" ] = $purchase_order->total ;
		$this->data[ "date" ] =  date( "d/m/Y" , $purchase_order->date )  ;

		// ////////////////////////////////////////////
		$width = 190;
		// $width = 280-5;
		$line = 5-0.3;
		$content_font_size = 8;
		$border = 0;
		$border_a = 1;

		$this->load->library('pdf');
		// $pdf = new FPDF();
		$pdf = new FPDF('p','mm','A4');
		$pdf->AddPage();
// 		$pdf->Image( base_url().BACKGROUND_PDF, 0, 0, 300, 300 );
		$pdf->Image( base_url().FAVICON_IMAGE, 10, 10, 50/2, 35/2 );
		$pdf->Image( base_url().'assets/images/logo/pertamina.png', 190-15, 10, 50/2, 35/2 );
		$pdf->Cell( $width/3-15 	, $line*4, NULL, 0, 0 );
		$pdf->SetFont('Arial', 'B', 18);
		$pdf->Cell( $width/3+15+15 	, $line*4, NULL, 0, 0, "C" );
		$pdf->Cell( $width/3 -15	, $line*4, NULL, 0, 1 );

		// 
		$pdf->Cell( $width/3 	, $line*2, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line*2, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3	, $line*2, NULL, $border, 1 );
		// 
		// 
		$pdf->SetFont('Arial', 'B', 18);
		$pdf->Cell( $width/3 	, $line*2, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line*2, "INVOICE", $border, 0, "C" );
		$pdf->Cell( $width/3	, $line*2, NULL, $border, 1 );
		// 
		// 
		$pdf->Cell( $width/3 	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3	, $line, NULL, $border, 1 );
		// 
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell( $width/3 +2	, $line, "Bill To : ", $border, 0 );
		$pdf->Cell( $width/3 -4	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3+2	, $line, "Customer Info : ", $border, 1 );
		// 
		// 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->Cell( $width/3 +10, $line*4, NULL, $border_a, 0 ,NULL, true);
		$pdf->Cell( $width/3 -24, $line*4, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3+14	, $line*4, NULL, $border_a, 1 ,NULL, true);
		// 
		// 
		$pdf->setY( $line*12 + 1/3 );
		$pdf->SetFont('Arial', '', $content_font_size);
		$pdf->Cell( $width/3 +10	, $line, "Company : ".$this->data[ "company" ] ->name, $border, 0 );
		$pdf->Cell( $width/3 -24	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3 +14	, $line, "Date : ".date( "d/m/Y" , $this->data[ "purchase_order" ]->date ), $border, 1 );
		// 
		$pdf->Cell( $width/3 +10	, $line, "Address : ".$this->data[ "company" ] ->address, $border, 0 );
		$pdf->Cell( $width/3 -24	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3 +14	, $line, "Customer : ".$this->data[ "delivery_address" ]->name, $border, 1 );
		// 
		$pdf->Cell( $width/3 +10	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3 -24	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3 +14	, $line, "Invoice # : ", $border, 1 );
		// 
		$pdf->Cell( $width/3 +10	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3 -24	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3 +14	, $line, "Page : ", $border, 1 );
		// 
		// 
		$pdf->Cell( $width/3 	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3	, $line, NULL, $border, 1 );
		// 
		// 
		$pdf->SetFillColor(255, 255, 255);
		
		$pdf->Cell( $width/7 -15, $line, "No", $border_a, 0, "C" , true);
		$pdf->Cell( $width/7 +15	, $line, "NO. Purchase Order", $border_a, 0 , 'C', true);
		$pdf->Cell( $width/7 +15	, $line, "Product / Material", $border_a, 0 , 'C', true);
		$pdf->Cell( $width/7 -10, $line, "Quantity", $border_a, 0, 'C' , true);
		$pdf->Cell( $width/7 -10	, $line, "Unit", $border_a, 0, 'C' , true);
		$pdf->Cell( $width/7 + 32	, $line, "Price", $border_a, 1 , "C", true);
		// 
		// 
		$pdf->Cell( $width/7 -15	, $line*2, "1", $border_a, 0, "C" , true);
		$pdf->Cell( $width/7 +15	, $line*2, $this->data[ "purchase_order" ]->code, $border_a, 0 , 'C', true);
		$pdf->Cell( $width/7 +15	, $line*2, $this->data[ "material" ]->name, $border_a, 0 , 'C', true);
		$pdf->Cell( $width/7 -10	, $line*2, number_format( $this->data[ "purchase_order" ]->quantity ), $border_a, 0, 'C' , true);
		$pdf->Cell( $width/7 -10	, $line*2, $this->data[ "material" ]->unit, $border_a, 0, 'C' , true);
		$pdf->Cell( $width/7 + 32	, $line*2, 'Rp. '.number_format( $this->data[ "purchase_order" ]->price ), $border_a, 1 , "C", true);
		// 
		// 
		$pdf->Cell( $width/7 -15	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/7 +15	, $line, NULL, $border, 0 , 'C');
		$pdf->Cell( $width/7 +15	, $line, NULL, $border, 0 , 'C');
		$pdf->Cell( $width/7 -10	, $line, NULL, $border, 0, 'C') ;
		$pdf->Cell( $width/7 -10	, $line, "Total ", $border_a, 0, 'C' , true);
		$pdf->Cell( $width/7 + 32	, $line, 'Rp. '.number_format( $this->data[ "purchase_order" ]->total ), $border_a, 1 , "C", true);
		// 
		// 
		$pdf->Cell( $width/3 	, $line*2, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line*2, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3	, $line*2, NULL, $border, 1 );
		// 
		//
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell( $width/3 +50	, $line*2, 'Other Comments or Special Instructions', $border_a, 0, 'C', true );
		$pdf->Cell( $width/3 -60	, $line*2, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3 +10	, $line*2, "In Words", $border_a, 1, 'C' , true);
		// 
		$pdf->Cell( $width/3 +50	, $line*7, NULL, $border_a, 0, 'C', true );
		$pdf->Cell( $width/3 -60	, $line*7, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3 +10	, $line*7, NULL, $border_a, 1, 'C' , true);
		// 
		$pdf->setY( $line*25 + 1/3 );
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell( $width/3 +2	, $line, "Make All Payment Payable To", $border, 1 );
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell( $width/3 +2	, $line, strtoupper($this->data[ "vendor" ]->name ), $border, 1 );
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell( $width/3 -30	, $line, "Bank Account", $border, 0 );
		$pdf->Cell( $width/3 +15	, $line, ":".$this->data[ "vendor" ]->bank_account, $border, 1 );
		$pdf->Cell( $width/3 -30	, $line, "Bank Name ", $border, 0 );
		$pdf->Cell( $width/3 +15	, $line, ":".$this->data[ "vendor" ]->bank_name, $border, 1 );
		$pdf->Cell( $width/3 -30	, $line, "Bank Branch ", $border, 0 );
		$pdf->Cell( $width/3 +15	, $line, ":".$this->data[ "vendor" ]->bank_branch, $border, 1 );
		$pdf->Cell( $width/3 -30	, $line, "Swift Code", $border, 0 );
		$pdf->Cell( $width/3 +15	, $line, ":".$this->data[ "vendor" ]->swift_code, $border, 1 );
		$pdf->Cell( $width/3 +15	, $line, NULL, $border, 1 );
		// 
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell( $width/3 +50	, $line, NULL, $border, 0, 'C' );
		$pdf->Cell( $width/3 -60	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3 +10	, $line, "If you have question about this invoice", $border, 1, NULL);
		$pdf->Cell( $width/3 +50	, $line, NULL, $border, 0, 'C' );
		$pdf->Cell( $width/3 -60	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3 +10	, $line, "Please Contact to : ", $border, 1, NULL);
		// 
		// 
		$pdf->Cell( $width/3 	, $line*2, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line*2, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3	, $line*2, NULL, $border, 1 );
		// 
		// 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->Cell( $width/3 	, $line*8, NULL, $border, 1,NULL );
		// 
		// 
		$pdf->setY( $line*37 );
		$pdf->SetFont('Arial', 'B', $content_font_size);
		$pdf->Cell( $width/3, $line, strtoupper($this->data[ "vendor" ]->name), 0, 1, "C" );
		$pdf->Cell( $width/3, $line, "Manager Accounting,", 0, 1, "C" );
		// 
		$pdf->setY( $line*37+ $line*5);
		$pdf->Cell( $width/3, $line, "(...........................................)", 0, 1, "C" );
		// 
		// 
		$pdf->Cell( $width/3	, $line*2, NULL, $border, 1 );
		// 
		// 
		$pdf->Cell( $width/3 	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3	, $line, NULL, $border, 1 );
		// 
		// 
		$pdf->Cell( $width/7 -5	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line, "Customer Service : ", $border, 0);
		$pdf->Cell( $width/3	, $line, NULL, $border, 1 );
		//
		// 
		$pdf->Cell( $width/7 -5	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line, strtoupper($this->data[ "vendor" ]->name), $border, 0);
		$pdf->Cell( $width/3	, $line, NULL, $border, 1 );
		// 
		// 
		$pdf->Cell( $width/7 -5	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/30, $line, NULL, $border, 0 );
		$pdf->Cell( $width/7 + 2 	, $line, $this->data[ "vendor" ]->address, $border, 0);
		$pdf->Cell( $width/30, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3	, $line, $this->data[ "vendor" ]->email, $border, 1 );
		// 
		// 
		$pdf->Cell( $width/7 -5	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/30, $line, NULL, $border, 0 );
		$pdf->Cell( $width/7 + 2 	, $line, $this->data[ "vendor" ]->phone, $border, 0);
		$pdf->Cell( $width/30, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3	, $line, $this->data[ "vendor" ]->phone_2, $border, 1 );
		// 

		$pdf->Image( base_url()."assets/images/avatars/CS.png", 10, 215, 4*5, 4*5 );
		$pdf->Image( base_url()."assets/images/icon/home.png", 33, 226, 4, 4 );
		$pdf->Image( base_url()."assets/images/icon/mail.png", 33 + 37, 226, 4, 4 );
		$pdf->Image( base_url()."assets/images/icon/telephone.png", 33, 226 + 5, 4, 4 );
		$pdf->Image( base_url()."assets/images/icon/bbm.png", 33 + 37, 226 + 5, 4, 4 );

		// $pdf->Output(  );
		$pdf->Output("OfficeForm.pdf", "I");
	}
	public function generate_news_pdf( $delivery_order_id )
	{
		$this->data[ "delivery_order" ] 	= $this->delivery_order_model->delivery_order( $delivery_order_id )->row();
		$this->data[ "purchase_order" ] 	= $this->purchase_order_model->purchase_order( $this->data[ "delivery_order" ]->purchase_order_id )->row();
		$this->data[ "delivery_address" ] 	= $this->delivery_address_model->delivery_address( $this->data[ "purchase_order" ]->delivery_address_id )->row();
		$this->data[ "company" ] 			= $this->company_model->company(  $this->data[ "purchase_order" ]->company_id  )->row();
		$this->data[ "vendor" ] 			= $this->vendor_model->vendor( $this->data[ "purchase_order" ]->vendor_id )->row();
		$this->data[ "material" ] 			= $this->material_model->material( $this->data[ "purchase_order" ]->material_id )->row();
		$this->data[ "car" ]	 			= $this->car_model->car( $this->data[ "delivery_order" ]->car_id )->row();
		// ///////////////////////////////////////
		$this->load->library('t_pdf');
		$pdf = new T_pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetTitle('Berita Acara');
		
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		 
		$pdf->SetTopMargin(20);
		$pdf->SetLeftMargin(20);
		$pdf->SetRightMargin(20);
		//$pdf->setFooterMargin(20);
		$pdf->SetAutoPageBreak(true);
		$pdf->SetAuthor('Harum Bumi Mandiri');
		$pdf->SetDisplayMode('real', 'default');
		$pdf->AddPage();
		$pdf->SetFont('helvetica', 'B', 9);

		// $pdf->Image( base_url().BACKGROUND_PDF, 0, 0, 300, 300 );
		$pdf->Image( base_url().FAVICON_IMAGE, 10, 10, 50/2, 35/2 );
		$pdf->Image( base_url().'assets/images/logo/pertamina.png', 190-15, 10, 50/2, 35/2 );

		
		$html = $this->load->view('templates/report/news', $this->data, true);	

		// return;

		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output("Berita Acara",'I');
	}
}