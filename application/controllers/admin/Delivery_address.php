<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_address extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model( array( 'delivery_address_model', 'company_model' ) ); 
		$this->load->library( array( 'form_validation' ) ); 
		
	} 
	// public function index()
	// {
	// 	$this->data[ "page_title" ] = "Alamat Serah";
	// 	$companies = $this->company_model->companies(  )->result();
	// 	foreach( $companies as $company  )
	// 	{
	// 		$company->user = $this->ion_auth->user( $company->user_id )->row();
	// 		$company->delivery_addresses = $this->delivery_address_model->delivery_addresses( $company->id )->result();
	// 	}
	// 	// echo var_dump( $companies );return;
	// 	$this->data[ "companies" ] = $companies;
		
	// 	$this->render( "admin/delivery_address/V_list" );
	// }

	public function add(  )
	{
		if( !($_POST) )	redirect(site_url('admin/delivery_address'));

		$this->form_validation->set_rules('name', ('Nama Alamat Serah'), 'trim|required');
		$this->form_validation->set_rules('postal_code', ('Kode Pos'), 'trim|required');
		$this->form_validation->set_rules('city', ('Kota'), 'trim|required');
		$this->form_validation->set_rules('province', ('Provinsi'), 'trim|required');
		$this->form_validation->set_rules('company_id', ('company_id'), 'trim|required');
		$this->form_validation->set_rules('user_id', ('user_id'), 'trim|required');
		$this->form_validation->set_rules('pbbkb', ('pbbkb'), 'trim|required');
		$this->form_validation->set_rules('discount', ('Diskon'), 'trim|required');

		if ($this->form_validation->run() === TRUE )
		{
				$user = $this->ion_auth->user( $this->input->post('user_id') )->row();
				$last_delivery_address = $this->delivery_address_model->last_delivery_address( $this->input->post('company_id') )->row();
				$last_id = ( $last_delivery_address == NULL ) ? 0 :  (int) substr( $last_delivery_address->code, strlen( $user->username ) );
				$last_id++;

				$data['code'] = $user->username.$last_id;

				$data['name'] = $this->input->post('name');
				$data['postal_code'] = $this->input->post('postal_code');
				$data['city'] = $this->input->post('city');
				$data['province'] = $this->input->post('province');

				$pbbkb = array(
					1.29 , 6, 6.75, 7.5
				);
				$data['pbbkb'] =  (1/100)* $pbbkb[ (int) $this->input->post('pbbkb') ];
				$data['discount'] =  1/100 * (float) $this->input->post('discount');
				// echo var_dump( $this->input->post('pbbkb') );return;
				$data['company_id'] = $this->input->post('company_id');
				
				if($this->delivery_address_model->create( $data ) )
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->delivery_address_model->messages() ) );
				}
				else
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->delivery_address_model->errors() ) );
				}
				redirect(site_url('admin/company/detail/').$this->input->post('company_id') );  
		}
		else
		{
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->delivery_address_model->errors() ? $this->delivery_address_model->errors() : $this->session->flashdata('message')));
				if(  validation_errors() || $this->delivery_address_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
				
				redirect(site_url('admin/company/detail/').$this->input->post('company_id') );  
		}
	}

	public function edit(  )
	{
		if( !($_POST) )	redirect(site_url('admin/delivery_address'));

		$this->form_validation->set_rules('id',  ('id'), 'trim|required');
		$this->form_validation->set_rules('name', ('Nama Alamat Serah'), 'trim|required');
		$this->form_validation->set_rules('postal_code', ('Kode Pos'), 'trim|required');
		$this->form_validation->set_rules('city', ('Kota'), 'trim|required');
		$this->form_validation->set_rules('province', ('Provinsi'), 'trim|required');
		$this->form_validation->set_rules('company_id', ('company_id'), 'trim|required');
		$this->form_validation->set_rules('pbbkb', ('pbbkb'), 'trim|required');
		$this->form_validation->set_rules('discount', ('Diskon'), 'trim|required');

		if ($this->form_validation->run() === TRUE )
		{

				$data['name'] = $this->input->post('name');
				$data['postal_code'] = $this->input->post('postal_code');
				$data['city'] = $this->input->post('city');
				$data['province'] = $this->input->post('province');
				$pbbkb = array(
					1.29 , 6, 6.75, 7.5
				);
				$data['pbbkb'] =  (1/100)* $pbbkb[ (int) $this->input->post('pbbkb') ];
				$data['discount'] =  1/100 * (float) $this->input->post('discount');
				
				$data_param['id'] = $this->input->post('id');
				if($this->delivery_address_model->update( $data, $data_param  ) )
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->delivery_address_model->messages() ) );
				}
				else
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->delivery_address_model->errors() ) );
				}
				redirect(site_url('admin/company/detail/').$this->input->post('company_id') );  
		}
		else
		{
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->delivery_address_model->errors() ? $this->delivery_address_model->errors() : $this->session->flashdata('message')));
				if(  validation_errors() || $this->delivery_address_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
				
				redirect(site_url('admin/company/detail/').$this->input->post('company_id') );  
		}
	}

	public function delete()//ok
	{
		if( !($_POST) )	redirect(site_url('admin/delivery_address'));  

		$data_param['id'] = $this->input->post('id');
		if( $this->delivery_address_model->delete( $data_param ) )
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->delivery_address_model->messages() ) );
		}
		else
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->delivery_address_model->errors() ) );
		}
		redirect(site_url('admin/company/detail/').$this->input->post('company_id') );  
	}
}