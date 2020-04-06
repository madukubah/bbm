<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Soa extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model( array( 'purchase_order_model', 'material_model', 'vendor_model', 'product_model', 'company_model', 'delivery_address_model', 'car_model', 'delivery_order_model'  ) ); 
		$this->load->library( array( 'form_validation' ) ); 
		
	} 

	public function create( $purchase_order_id = NULL )
	{
		$this->data[ "page_title" ] = "Buat SOA";
		$purchase_order  = $this->purchase_order_model->purchase_order( $purchase_order_id )->row();

		if( $purchase_order_id == NULL || $purchase_order == NULL ) redirect(site_url('admin/purchase_order')); 
		if( $this->delivery_order_model->has_delivery_order( $purchase_order_id ) )
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::INFO, "PO sudah di buatkan DO" ) );
			redirect(site_url('admin/purchase_order')); 
		}

		$this->data[ "company" ] = $this->company_model->company(  $purchase_order->company_id  )->row();
		$this->data[ "vendor" ] = $this->vendor_model->vendor( $purchase_order->vendor_id )->row();
		$delivery_address = $this->delivery_address_model->delivery_address( $purchase_order->delivery_address_id )->row();
		$this->data[ "delivery_address" ] = $delivery_address;
		
		$material = $this->material_model->material( $purchase_order->material_id )->row();

		$this->data[ "purchase_order_id" ] 	= $purchase_order_id;
		$this->data[ "material" ] 			= $material;
		$this->data[ "quantity" ] 			=  $purchase_order->quantity ;

		$this->data[ "cars" ] 				=  (  $this->car_model->cars(  )->result() );
		$this->data[ "drivers" ] 			= $this->ion_auth->users( "driver" )->result();
		// echo json_encode( $this->data[ "cars" ] );return;
		$this->render( "admin/soa/V_create" );
	}
}