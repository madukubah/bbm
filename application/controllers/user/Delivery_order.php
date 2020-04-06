<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_order extends Driver_Controller {
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
			'do_report_model',
		) ); 		
		$this->load->library( array( 'form_validation' ) ); 
		
	} 
	public function index()
	{
		$this->data[ "page_title" ] = "Delivery order";
		$user_id = $this->ion_auth->get_user_id();
		// ////////
		$_limit_segment 	= 4;
		$_number_segment 	= 5;
		if ($this->uri->segment( $_limit_segment ) != "") {
			$limit = $this->uri->segment( $_limit_segment );
		} else {
			$limit = 10;
		}

		$page              		= ($this->uri->segment( $_number_segment )) ? $this->uri->segment( $_number_segment ) : 0;
		$base_url = base_url() . "user/delivery_order/index/";
		$this->data["links"]    = $this->_get_pagination( $limit, $this->delivery_order_model->record_count(), $_number_segment, $base_url );

		$this->data[ "delivery_orders" ]  = $this->delivery_order_model->delivery_orders_limit( $limit , $page, $user_id  )->result();

		$search = $this->input->get("search", FALSE);
		// echo $search;return;
		if( $search != FALSE )
		{
			$this->data[ "delivery_orders" ]  	= $this->delivery_order_model->search( $search, $user_id  )->result();
		}
		$this->data[ "search" ]  			= trim( $search );	
		// ////////
		// $this->data[ "delivery_orders" ] = $this->delivery_order_model->driver_delivery_order( $user_id )->result();


		$this->render( "user/delivery_order/V_list" );
	}
	public function detail( $delivery_order_id = NULL )
	{
		if( $delivery_order_id == NULL  ) redirect(site_url('user/')); 

		$this->data[ "page_title" ] = "Delivery order";
		$user_id = $this->ion_auth->get_user_id();
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
		}

		$this->data['delivery_order_id'] = array(
			'name' => 'delivery_order_id',
			'id' => 'delivery_order_id',
			'type' => 'hidden',
			'min' => 1,
			'placeholder' => 'delivery_order_id',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('delivery_order_id', $delivery_order_id),
		);
		$this->data['quantity'] = array(
			'name' => 'quantity',
			'id' => 'quantity',
			'type' => 'number',
			'min' => 1,
			'max' => $this->data[ "delivery_order" ]->quantity,
			'placeholder' => 'Kuantitas',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('quantity'),
		);
		$this->data['temperature'] = array(
			'name' => 'temperature',
			'id' => 'temperature',
			'type' => 'text',
			'min' => 1,
			'placeholder' => 'Temperatur',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('temperature'),
		);
		$this->data['sg'] = array(
			'name' => 'sg',
			'id' => 'sg',
			'type' => 'text',
			'min' => 1,
			'placeholder' => 'SG',
			'class' => 'form-control',
			'value' => $this->form_validation->set_value('sg'),
		);
		$this->data['tank_condition'] = array(
			'name' => 'tank_condition',
			'id' => 'tank_condition',
			'class' => 'form-control',
			'options' => array(
				"Penutup Atas dan atau Bawah Tersegel"=>"Penutup Atas dan atau Bawah Tersegel",
				"Penutup Atas dan atau Bawah Tidak Tersegel"=>"Penutup Atas dan atau Bawah Tidak Tersegel",
			),
		);
		$this->data['quality'] = array(
			'name' => 'quality',
			'id' => 'quality',
			'class' => 'form-control',
			'options' => array(
				"Baik"=>"Baik",
				"Buruk"=>"Buruk",
			),
		);
		$this->data['information'] = array(
			'name' => 'information',
			'id' => 'information',
			'class' => 'form-control',
			'options' => array(
				"Tidak Terkontaminasi"=>"Tidak Terkontaminasi",
				"Terkontaminasi"=>"Terkontaminasi",
				"Tercampur Air atau Minyak Lain dan Tidak Layak Konsumsi"=>"Tercampur Air atau Minyak Lain dan Tidak Layak Konsumsi",
				
			),
		);

		$this->render( "user/delivery_order/V_detail" );
	}

	
}