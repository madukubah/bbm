<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends User_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model( array( 'delivery_address_model', 'company_model' ) ); 
		$this->load->library( array( 'form_validation' ) ); 
		
	} 

	public function index(  )
	{
		$this->data[ "page_title" ] = "Perusahaan";
		$user_id = $this->ion_auth->get_user_id();

		$this->data[ "company" ]  = $this->company_model->companies( $user_id )->row();
		if( $this->data[ "company" ] == NULL ) redirect( site_url("user/") );
		$this->data[ "delivery_addresses" ]  = $this->delivery_address_model->delivery_addresses( $this->data[ "company" ]->id )->result();
		
		$this->render( "user/company/V_detail" );
	}
}