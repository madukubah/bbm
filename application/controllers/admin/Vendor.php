<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model( array( 'vendor_model' ) ); 
		$this->load->library( array( 'form_validation' ) ); 


		
	} 
	public function index()
	{
		$this->data[ "page_title" ] = "Suplier";
		$this->data[ "vendors" ] =  $this->vendor_model->vendors(  )->result();
		// echo var_dump( $this->data[ "cars" ] );return;
		$this->render( "admin/vendor/V_list" );
	}
	public function add(  )
	{
		if( !($_POST) )	redirect(site_url('admin/vendor'));

		$this->form_validation->set_rules('brand', ('Merk Kendaraan'), 'trim|required');
		$this->form_validation->set_rules('capacity', ('Kapasitas'), 'trim|required');
		$this->form_validation->set_rules('plat_number', ('Nomor Plat'), 'trim|required');

		if ($this->form_validation->run() === TRUE )
		{
				$data['brand'] = $this->input->post('brand');
				$data['capacity'] = $this->input->post('capacity');
				$data['plat_number'] = $this->input->post('plat_number');
				
				if($this->vendor_model->create( $data ) )
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->vendor_model->messages() ) );
				}
				else
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->vendor_model->errors() ) );
				}
				redirect(site_url('admin/vendor'));		}
		else
		{
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->vendor_model->errors() ? $this->vendor_model->errors() : $this->session->flashdata('message')));
				if(  validation_errors() || $this->vendor_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
				
				redirect(site_url('admin/vendor'));		
		}
	}

	public function edit(  )
	{
		if( !($_POST) )	redirect(site_url('admin/vendor'));

		$this->form_validation->set_rules('name', ('Nama Suplier'), 'trim|required');
		$this->form_validation->set_rules('description', ('Deskripsi'), 'trim|required');
		$this->form_validation->set_rules('phone', ('Telepon'), 'trim|required');
		$this->form_validation->set_rules('bank_account', ('No. Rekening'), 'trim|required');
		$this->form_validation->set_rules('bank_name', ('Nama Bank'), 'trim|required');
		$this->form_validation->set_rules('bank_branch', ('Cabang Bank'), 'trim|required');
		$this->form_validation->set_rules('swift_code', ('Swift Code'), 'trim|required');
		$this->form_validation->set_rules('address', ('Alamat'), 'trim|required');
		$this->form_validation->set_rules('email', ('Email'), 'trim|required');
		$this->form_validation->set_rules('phone_2', ('Contact 2'), 'trim|required');

		$this->form_validation->set_rules('id', ('id'), 'trim|required');

		if ($this->form_validation->run() === TRUE )
		{
				$data['name'] 			= $this->input->post('name');
				$data['description'] 	= $this->input->post('description');
				$data['phone'] 			= $this->input->post('phone');
				$data['bank_account'] 	= $this->input->post('bank_account');
				$data['bank_name'] 		= $this->input->post('bank_name');
				$data['bank_branch'] 	= $this->input->post('bank_branch');
				$data['swift_code'] 	= $this->input->post('swift_code');
				$data['address'] 		= $this->input->post('address');
				$data['email'] 			= $this->input->post('email');
				$data['phone_2'] 		= $this->input->post('phone_2');
				
				$data_param['id'] = $this->input->post('id');

				if($this->vendor_model->update( $data, $data_param  ) )
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->vendor_model->messages() ) );
				}
				else
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->vendor_model->errors() ) );
				}
				redirect(site_url('admin/vendor'));		}
		else
		{
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->vendor_model->errors() ? $this->vendor_model->errors() : $this->session->flashdata('message')));
				if(  validation_errors() || $this->vendor_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
				
				redirect(site_url('admin/vendor'));		
		}
	}
	public function delete()//ok
	{
		if( !($_POST) )	redirect(site_url('admin/vendor'));

		$data_param['id'] = $this->input->post('id');
		if( $this->vendor_model->delete( $data_param ) )
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->vendor_model->messages() ) );
		}
		else
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->vendor_model->errors() ) );
		}
		redirect(site_url('admin/vendor'));	}

}