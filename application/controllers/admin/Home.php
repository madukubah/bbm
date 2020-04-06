<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model( array( 
			'car_model'
		) ); 
	} 
	public function index()
	{
		$this->data[ "page_title" ] = "Beranda";
		$this->data[ "customers_count" ] 	= count(  $this->ion_auth->users( "customers" )->result() );
		$this->data[ "drivers_count" ] 		= count( $this->ion_auth->users( "driver" )->result() ) ;
		$this->data[ "car_count" ] 			=  $this->car_model->record_count(  );
		$this->render( "admin/dashboard/content" );
	}
}