<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tax_invoice extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model( array( 'tax_invoice_model' ) ); 
		$this->load->library( array( 'form_validation' ) ); 
	} 

	public function add(  )
	{
		if( !($_POST) )	redirect(site_url('admin/'));

		$this->form_validation->set_rules('purchase_order_code', ('purchase_order_code'), 'trim|required');
		$this->form_validation->set_rules('purchase_order_id', ('purchase_order_id'), 'trim|required');

		if ($this->form_validation->run() === TRUE )
		{
				$array_file = array("tax_invoice");
				$file = $this->_upload_file( $array_file );
				if( $file != FALSE )
				{
					$data['tax'] 		= $file[0];
					$data['purchase_order_id'] 	=$this->input->post( "purchase_order_id" );
					
					if($this->tax_invoice_model->create( $data ) )
					{
						$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tax_invoice_model->messages() ) );
					}
					else
					{
						$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tax_invoice_model->errors() ) );
					}
					redirect(site_url('admin/purchase_order/detail/').$this->input->post( "purchase_order_id" ));		
				}	
		}
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->tax_invoice_model->errors() ? $this->tax_invoice_model->errors() : $this->session->flashdata('message')));
		if(  validation_errors() || $this->tax_invoice_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		
		redirect(site_url('admin/purchase_order/detail/').$this->input->post( "purchase_order_id" ));		
	}

	protected function _upload_file( $array_file )//ok
	{
		$result = array();

		$config['upload_path']					= './uploads/news_n_tax_factor/';
		$config['allowed_types']                = 'pdf';
		$config['overwrite']			        = "true";
		$config['max_size']						= 20000000;
		$this->load->library('upload');
		$_file_name = array( 'TAX_INVOICE_' );
		foreach( $array_file as $ind => $value )
		{
			$config['file_name'] 			=  $_file_name[ $ind ].$this->input->post( 'purchase_order_code' )."_".time();
			
			$this->upload->initialize( $config );
			if ( ! $this->upload->do_upload( $value ) )
			{
				$this->tax_invoice_model->set_error( $this->upload->display_errors() );
				return FALSE;
			}
			else
			{
				$file_data = $this->upload->data();
				$result[] = $file_data['file_name'];
			}
		}
		return $result;
	}
	public function delete()//ok
	{
		if( !($_POST) )	redirect(site_url('admin/'));

		$data_param['id'] = $this->input->post('id');
		if( $this->tax_invoice_model->delete( $data_param ) )
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tax_invoice_model->messages() ) );
		}
		else
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tax_invoice_model->errors() ) );
		}
		redirect(site_url('admin/purchase_order/detail/').$this->input->post( "purchase_order_id" ));		
	}

}