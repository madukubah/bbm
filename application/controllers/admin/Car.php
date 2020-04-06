<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Car extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model( array( 'car_model' ) ); 
		$this->load->library( array( 'form_validation' ) ); 


		
	} 
	public function index()
	{
		$this->data[ "page_title" ] = "Kendaraan";
		$this->data[ "cars" ] =  $this->car_model->cars(  )->result();
		// echo var_dump( $this->data[ "cars" ] );return;
		$this->render( "admin/car/V_list" );
	}
	public function add(  )
	{
		if( !($_POST) )	redirect(site_url('admin/car'));

		$this->form_validation->set_rules('brand', ('Merk Kendaraan'), 'trim|required');
		$this->form_validation->set_rules('capacity', ('Kapasitas'), 'trim|required');
		$this->form_validation->set_rules('plat_number', ('Nomor Plat'), 'trim|required');

		if ($this->form_validation->run() === TRUE )
		{
				$data['brand'] = $this->input->post('brand');
				$data['capacity'] = $this->input->post('capacity');
				$data['plat_number'] = $this->input->post('plat_number');
				
				if($this->car_model->create( $data ) )
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->car_model->messages() ) );
				}
				else
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->car_model->errors() ) );
				}
				redirect(site_url('admin/car'));		}
		else
		{
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->car_model->errors() ? $this->car_model->errors() : $this->session->flashdata('message')));
				if(  validation_errors() || $this->car_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
				
				redirect(site_url('admin/car'));		
		}
	}

	public function edit(  )
	{
		if( !($_POST) )	redirect(site_url('admin/car'));

		$this->form_validation->set_rules('brand', ('Merk Kendaraan'), 'trim|required');
		$this->form_validation->set_rules('capacity', ('Kapasitas'), 'trim|required');
		$this->form_validation->set_rules('plat_number', ('Nomor Plat'), 'trim|required');
		$this->form_validation->set_rules('id', ('id'), 'trim|required');

		if ($this->form_validation->run() === TRUE )
		{
				$data['brand'] = $this->input->post('brand');
				$data['capacity'] = $this->input->post('capacity');
				$data['plat_number'] = $this->input->post('plat_number');
				
				$data_param['id'] = $this->input->post('id');

				if($this->car_model->update( $data, $data_param  ) )
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->car_model->messages() ) );
				}
				else
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->car_model->errors() ) );
				}
				redirect(site_url('admin/car'));		}
		else
		{
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->car_model->errors() ? $this->car_model->errors() : $this->session->flashdata('message')));
				if(  validation_errors() || $this->car_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
				
				redirect(site_url('admin/car'));		
		}
	}
	public function delete()//ok
	{
		if( !($_POST) )	redirect(site_url('admin/car'));

		$data_param['id'] = $this->input->post('id');
		if( $this->car_model->delete( $data_param ) )
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->car_model->messages() ) );
		}
		else
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->car_model->errors() ) );
		}
		redirect(site_url('admin/car'));	}

}