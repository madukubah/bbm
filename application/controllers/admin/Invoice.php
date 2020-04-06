<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model( array( 'delivery_order_model', 'purchase_order_model', 'delivery_address_model', 'company_model', 'vendor_model', 'material_model','invoice_model' ) ); 
		$this->load->library( array( 'form_validation' ) ); 


		
	} 
	public function index()
	{
		$_limit_segment 	= 4;
		$_number_segment 	= 5;
		#set Limit
		if ($this->uri->segment( $_limit_segment ) != "") {
			$limit = $this->uri->segment( $_limit_segment );
		} else {
			$limit = 10;
		}

		$page              		= ($this->uri->segment( $_number_segment )) ? $this->uri->segment( $_number_segment ) : 0;

		$base_url = base_url() . "admin/invoice/index/";
		$this->data["links"]    = $this->_get_pagination( $limit, $this->invoice_model->record_count(), $_number_segment, $base_url );

		$this->data[ "invoices" ]  = $this->invoice_model->invoices_limit( $limit , $page  )->result();

		$search = $this->input->get("search", FALSE);
		// echo $search;return;
		if( $search != FALSE )
		{
			$this->data[ "invoices" ]  	= $this->invoice_model->search( $search  )->result();
		}
		$this->data[ "search" ]  			= trim( $search );

		$this->data[ "page_title" ] = "Invoice";
		// $this->data[ "invoices" ] =  $this->invoice_model->invoices(  )->result();

		$this->render( "admin/invoice/V_list" );
	}
	public function confirm( $purchase_order_id = NULL )
	{
		$this->data[ "page_title" ] = "Buat Invoice";
		if( $purchase_order_id == NULL )	redirect(site_url('admin'));
		$this->data[ "delivery_orders" ] = $this->delivery_order_model->delivery_orders_and_report( $purchase_order_id )->result();
		$this->data[ "purchase_order" ] 	= $this->purchase_order_model->purchase_order( $purchase_order_id )->row();
		$this->data[ "delivery_address" ] 	= $this->delivery_address_model->delivery_address( $this->data[ "purchase_order" ]->delivery_address_id )->row();
		$this->data[ "company" ] 			= $this->company_model->company(  $this->data[ "purchase_order" ]->company_id  )->row();
		$this->data[ "vendor" ] 			= $this->vendor_model->vendor( $this->data[ "purchase_order" ]->vendor_id )->row();
		$this->data[ "material" ] 			= $this->material_model->material( $this->data[ "purchase_order" ]->material_id )->row();
		$this->data[ "purchase_order_id" ]	= $purchase_order_id;

		$new_quantity=0;
		foreach( $this->data[ "delivery_orders" ] as $delivery_order ): 
			$new_quantity += $delivery_order->do_report_quantity;
		endforeach;

		$discount = $this->data[ "delivery_address" ]->discount;
		$price = ( date("d") < 15 ) ? $this->data[ "material" ]->price_1 : $this->data[ "material" ]->price_2 ;
		$price = $price - ( $price * $discount );
		$subtotal = $price * $new_quantity;
		$this->data[ "price" ] = $price;
		$this->data[ "new_quantity" ] 	=  $new_quantity ;
		$this->data[ "subtotal" ] 		=  $subtotal  ;
		$this->data[ "ppn" ] 			=  $subtotal * 10/100  ;
		$this->data[ "pph" ] 			=  $subtotal * $this->data[ "company" ]->pph;
		$this->data[ "pbbkb" ] 			=  $subtotal * $this->data[ "delivery_address" ]->pbbkb ;
		$this->data[ "total" ] 			=	$this->data[ "subtotal" ]+ $this->data[ "ppn" ]+  $this->data[ "pbbkb" ] +$this->data[ "pph" ] ;
		// echo json_encode( $this->data[ "delivery_orders" ] );

		$this->render( "admin/invoice/V_confirm" );
	}


	public function create(  )
	{
		if( !($_POST) )	redirect(site_url('admin/'));

		$purchase_order_id 	= $this->input->post('purchase_order_id');
		$purchase_order 	= $this->purchase_order_model->purchase_order( $purchase_order_id )->row();
		if( $purchase_order_id == NULL || $purchase_order == NULL )	redirect(site_url('admin'));

		
		$this->data[ "purchase_order" ] 	= $purchase_order;
		$this->data[ "delivery_orders" ] 	= $this->delivery_order_model->delivery_orders_and_report( $purchase_order_id )->result();
		$this->data[ "delivery_address" ] 	= $this->delivery_address_model->delivery_address( $this->data[ "purchase_order" ]->delivery_address_id )->row();
		$this->data[ "company" ] 			= $this->company_model->company(  $this->data[ "purchase_order" ]->company_id  )->row();
		$this->data[ "vendor" ] 			= $this->vendor_model->vendor( $this->data[ "purchase_order" ]->vendor_id )->row();
		$this->data[ "material" ] 			= $this->material_model->material( $this->data[ "purchase_order" ]->material_id )->row();

		$new_quantity=0;
		foreach( $this->data[ "delivery_orders" ] as $delivery_order ): 
			$new_quantity += $delivery_order->do_report_quantity;
		endforeach;

		$discount = $this->data[ "delivery_address" ]->discount;
		$price = ( date("d") < 15 ) ? $this->data[ "material" ]->price_1 : $this->data[ "material" ]->price_2 ;
		$price = $price - ( $price * $discount );
		$subtotal = $price * $new_quantity;
		$this->data[ "price" ] = $price;
		$this->data[ "new_quantity" ] 	=  $new_quantity ;
		$this->data[ "subtotal" ] 		=  $subtotal  ;
		$this->data[ "ppn" ] 			=  $subtotal * 10/100  ;
		$this->data[ "pph" ] 			=  $subtotal * $this->data[ "company" ]->pph;
		$this->data[ "pbbkb" ] 			=  $subtotal * $this->data[ "delivery_address" ]->pbbkb ;
		$this->data[ "total" ] 			=	$this->data[ "subtotal" ]+ $this->data[ "ppn" ]+  $this->data[ "pbbkb" ] +$this->data[ "pph" ] ;

		$prefix = "INVOICE_";
		$data["date"] 				=  time();
		$data["code"] 				= $prefix.substr( $purchase_order->code, strlen( "PO_" ) );
		$data["purchase_order_id"] 	= $purchase_order_id;
		$data["price"] 				= $this->data[ "price" ];
		$data["quantity"] 			= $this->data[ "new_quantity" ];
		$data["sub_total"] 			= $this->data[ "subtotal" ];
		$data["ppn"] 				= $this->data[ "ppn" ];
		$data["pph"] 				= $this->data[ "pph" ];
		$data["pbbkb"] 				= $this->data[ "pbbkb" ];
		$data["total"] 				= $this->data[ "total" ];

		if( $this->invoice_model->exist($data['purchase_order_id'] ) )redirect(site_url('admin/') );  
		
		if($this->invoice_model->create( $data ) )
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->invoice_model->messages() ) );
		}
		else
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->invoice_model->errors() ) );
		}
		redirect(site_url('admin/invoice'));
	}
	public function detail( $invoice_id = NULL )
	{	
		$this->data[ "page_title" ] = "Detail Invoice";
		$invoice  = $this->invoice_model->invoice( $invoice_id )->row();
		if( $invoice_id == NULL || $invoice == NULL ) redirect(site_url('admin/invoice')); 
		$this->data[ "delivery_orders" ] = $this->delivery_order_model->delivery_orders_and_report( $invoice->purchase_order_id )->result();
		$this->data[ "purchase_order" ]  = $this->purchase_order_model->purchase_order( $invoice->purchase_order_id )->row();
		$this->data[ "delivery_address" ] 	= $this->delivery_address_model->delivery_address( $this->data[ "purchase_order" ]->delivery_address_id )->row();
		$this->data[ "company" ] 			= $this->company_model->company(  $this->data[ "purchase_order" ]->company_id  )->row();
		$this->data[ "vendor" ] 			= $this->vendor_model->vendor( $this->data[ "purchase_order" ]->vendor_id )->row();
		$this->data[ "material" ] 			= $this->material_model->material( $this->data[ "purchase_order" ]->material_id )->row();

		$this->data[ "invoice" ] 		= 	$invoice;
		$this->data[ "price" ] 			= 	$invoice->price;
		$this->data[ "quantity" ] 		=  	$invoice->quantity ;
		$this->data[ "subtotal" ] 		=  	$invoice->sub_total  ;
		$this->data[ "ppn" ] 			=  	$invoice->ppn;
		$this->data[ "pph" ] 			=  	$invoice->pph;
		$this->data[ "pbbkb" ] 			=  	$invoice->pbbkb ;
		$this->data[ "total" ] 			= 	$invoice->total ;
		$this->data[ "date" ] 			=  	date( "d/m/Y" , $invoice->date )  ;

		$this->render( "admin/invoice/V_detail" );
	}
	public function paid_off(  )
	{	
		if( !($_POST) )	redirect(site_url('admin/'));

		$this->data[ "page_title" ] = "Detail Invoice";
		$data_param['id'] 		= $this->input->post("invoice_id");
		$data['status'] 		= $this->input->post("status");
		if($this->invoice_model->update( $data, $data_param ) )
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->invoice_model->messages() ) );
		}
		else
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->invoice_model->errors() ) );
		}
		redirect(site_url('admin/invoice'));
	}

	
	
}