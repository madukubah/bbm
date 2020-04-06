<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model( array( 'product_model', 'material_model' ) ); 
		$this->load->library( array( 'form_validation' ) ); 
	} 
	public function index()
	{
		$this->data[ "page_title" ] = "Produk";
		$products = $this->product_model->products(  )->result();
		foreach( $products as $product  )
		{
			$product->materials = $this->material_model->materials( $product->id )->result();
		}
		// echo var_dump( $products );return;
		$this->data[ "products" ] = $products;
		
		$this->render( "admin/product/V_list" );
	}
	public function detail( $product_id = NULL )
	{
		if( $product_id == NULL ) redirect(site_url('admin/product')); 

		$this->data[ "page_title" ] = "Detail";
		$product = $this->product_model->product( $product_id )->row();
		$product->materials = $this->material_model->materials( $product->id )->result();
		
		// echo var_dump( $products );return;
		$this->data[ "product" ] = $product;
		
		$this->render( "admin/product/V_detail" );
	}

	public function add(  )
	{
		if( !($_POST) )	redirect(site_url('admin/product'));

		$this->form_validation->set_rules('name', ('Nama Produk'), 'trim|required');
		$this->form_validation->set_rules('description', ('Deskripsi'), 'trim|required');

		if ($this->form_validation->run() === TRUE )
		{
				$data['name'] = $this->input->post('name');
				$data['description'] = $this->input->post('description');
				
				if($this->product_model->create( $data ) )
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->product_model->messages() ) );
				}
				else
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->product_model->errors() ) );
				}
				redirect(site_url('admin/product') );  
		}
		else
		{
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->product_model->errors() ? $this->product_model->errors() : $this->session->flashdata('message')));
				if(  ( validation_errors() ) || $this->product_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
				
				redirect(site_url('admin/product') );  
		}
	}

	public function edit(  )
	{

		if( !($_POST) )	redirect(site_url('admin/product'));

		$this->form_validation->set_rules('id', ('id'), 'trim|required');
		$this->form_validation->set_rules('name', ('Nama Produk'), 'trim|required');
		$this->form_validation->set_rules('description', ('Deskripsi'), 'trim|required');

		if ($this->form_validation->run() === TRUE )
		{
				$data['name'] = $this->input->post('name');
				$data['description'] = $this->input->post('description');
				
				$data_param['id'] = $this->input->post('id');
				if($this->product_model->update( $data, $data_param  ) )
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->product_model->messages() ) );
				}
				else
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->product_model->errors() ) );
				}
				redirect(site_url('admin/product') );  
		}
		else
		{
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->product_model->errors() ? $this->product_model->errors() : $this->session->flashdata('message')));
				if(  ( validation_errors() ) || $this->product_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
				
				redirect(site_url('admin/product') );  
		}
	}

	public function delete()//ok
	{
		if( !($_POST) )	redirect(site_url('admin/product'));  

		$data_param['id'] = $this->input->post('id');
		if( $this->product_model->delete( $data_param ) )
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->product_model->messages() ) );
		}
		else
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->product_model->errors() ) );
		}
		redirect(site_url('admin/product'));  
	}

	// material
	public function add_material(  )
	{
		if( !($_POST) )	redirect(site_url('admin/product' ));

		$this->form_validation->set_rules('name', ('Nama Material'), 'trim|required');
		$this->form_validation->set_rules('unit', ('Satuan'), 'trim|required');
		$this->form_validation->set_rules('price_1', ('Harga 1 ( tgl 1-15 )'), 'trim|required');
		$this->form_validation->set_rules('price_2', ('Harga 2 ( tgl 16-30 )'), 'trim|required');
		$this->form_validation->set_rules('product_id', ('product_id'), 'trim|required');

		if ($this->form_validation->run() === TRUE )
		{
				$data['name'] = $this->input->post('name');
				$data['unit'] = $this->input->post('unit');
				$data['price_1'] = $this->input->post('price_1');
				$data['price_2'] = $this->input->post('price_2');

				$data['product_id'] = $this->input->post('product_id');
				
				if($this->material_model->create( $data ) )
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->material_model->messages() ) );
				}
				else
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->material_model->errors() ) );
				}
				redirect(site_url('admin/product/detail/').$this->input->post('product_id') );  
		}
		else
		{
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->material_model->errors() ? $this->material_model->errors() : $this->session->flashdata('message')));
				if(  ( validation_errors() ) || $this->material_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
				
				redirect(site_url('admin/product/detail/').$this->input->post('product_id') );  
		}
	}
	public function edit_material(  )
	{
		if( !($_POST) )	redirect(site_url('admin/product' ));

		$this->form_validation->set_rules('name', ('Nama Material'), 'trim|required');
		$this->form_validation->set_rules('unit', ('Satuan'), 'trim|required');
		$this->form_validation->set_rules('price_1', ('Harga 1 ( tgl 1-15 )'), 'trim|required');
		$this->form_validation->set_rules('price_2', ('Harga 2 ( tgl 16-30 )'), 'trim|required');
		$this->form_validation->set_rules('id', ('id'), 'trim|required');

		if ($this->form_validation->run() === TRUE )
		{
				$data['name'] = $this->input->post('name');
				$data['unit'] = $this->input->post('unit');
				$data['price_1'] = $this->input->post('price_1');
				$data['price_2'] = $this->input->post('price_2');

				$data_param['id'] = $this->input->post('id');
				
				if($this->material_model->update( $data, $data_param  ) )
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->material_model->messages() ) );
				}
				else
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->material_model->errors() ) );
				}
				redirect(site_url('admin/product/detail/').$this->input->post('product_id') );  
		}
		else
		{
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->material_model->errors() ? $this->material_model->errors() : $this->session->flashdata('message')));
				if(  ( validation_errors() ) || $this->material_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
				
				redirect(site_url('admin/product/detail/').$this->input->post('product_id') );  
		}
	}
	public function delete_material()//ok
	{
		if( !($_POST) )	redirect(site_url('admin/product' ));  

		$data_param['id'] = $this->input->post('id');
		if( $this->material_model->delete( $data_param ) )
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->material_model->messages() ) );
		}
		else
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->material_model->errors() ) );
		}
		redirect(site_url('admin/product/detail/').$this->input->post('product_id'));  
	}
	// material
}