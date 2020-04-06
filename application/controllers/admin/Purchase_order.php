<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_order extends Admin_Controller {
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
			"tax_invoice_model"
		) ); 
		$this->load->library( array( 'form_validation' ) ); 
		
	} 
	public function index()
	{
		$_limit_segment 	= 4;
		$_number_segment 	= 5;
		$this->data[ "page_title" ] = "Purchase order";
		#set Limit
		if ($this->uri->segment( $_limit_segment ) != "") {
			$limit = $this->uri->segment( $_limit_segment );
		} else {
			$limit = 10;
		}

		$page              		= ($this->uri->segment( $_number_segment )) ? $this->uri->segment( $_number_segment ) : 0;
		$base_url = base_url() . "admin/purchase_order/index/";
		$this->data["links"]    = $this->_get_pagination( $limit, $this->purchase_order_model->record_count(), $_number_segment, $base_url );

		$this->data[ "purchase_orders" ]  = $this->purchase_order_model->purchase_orders_limit( $limit , $page  )->result();

		$search = $this->input->get("search", FALSE);
		// echo $search;return;
		if( $search != FALSE )
		{
			$this->data[ "purchase_orders" ]  	= $this->purchase_order_model->search( $search  )->result();
		}
		$this->data[ "search" ]  			= trim( $search );		
		$this->render( "admin/purchase_order/V_list" );
	}
	public function detail( $purchase_order_id = NULL )
	{
		$purchase_order  = $this->purchase_order_model->purchase_order( $purchase_order_id )->row();
		if( $purchase_order_id == NULL || $purchase_order == NULL ) redirect(site_url('admin/purchase_order')); 
		
		$this->data[ "delivery_orders" ] = $this->delivery_order_model->delivery_orders( $purchase_order_id )->result();

		$this->data[ "page_title" ] = "Detail ";
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
		$this->render( "admin/purchase_order/V_detail" );
	}
	public function delete()//ok
	{
		if( !($_POST) )	redirect(site_url('admin/purchase_order' ));  

		$data_param['id'] = $this->input->post('id');
		if( $this->purchase_order_model->delete( $data_param ) )
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->purchase_order_model->messages() ) );
		}
		else
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->purchase_order_model->errors() ) );
		}
		redirect(site_url('admin/purchase_order/') );  
	}


}