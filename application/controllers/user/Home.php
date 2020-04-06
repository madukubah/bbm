<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends User_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model( array( 
			'car_model',
			'purchase_order_model',
			'invoice_model',
			'delivery_order_model',
		) ); 
	} 

	public function index()
	{
		// TODO : halaman dashbord untuk user yang sudah terdaftar 
		$this->data[ "page_title" ] = "Selamat Datang";
		if( $this->ion_auth->in_group("customers" ) )
		{
			$this->data[ "po_process" ] 	= (  $this->purchase_order_model->count_processes_by_user_id( $this->ion_auth->get_user_id() ) );
			$this->data[ "po_complete" ] 	= ( $this->purchase_order_model->count_complete_by_user_id( $this->ion_auth->get_user_id() ) ) ;
			$this->data[ "invioce_bill" ] 	=  $this->invoice_model->count_unprocess_by_user_id( $this->ion_auth->get_user_id() );
		}
		else if( $this->ion_auth->in_group("driver" ) )
		{
			$this->data[ "do_unprocess" ] 	= (  $this->delivery_order_model->count_unprocess_by_user_id( $this->ion_auth->get_user_id() ) );
		}
		
		$this->render( "user/dashboard/content" );
	}
}