<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model( array( 'delivery_address_model', 'company_model' ) ); 
		$this->load->library( array( 'form_validation' ) ); 
		
	} 
	public function index(  )
	{
		$_limit_segment 	= 4;
		$_number_segment 	= 5;
		#set Limit
		if ($this->uri->segment( $_limit_segment ) != "") {
			$limit = $this->uri->segment( $_limit_segment );
		} else {
			$limit = 10;
		}

		$page              		= ($this->uri->segment( $_number_segment )) ? $this->uri->segment( $_number_segment ) : 0;

		$base_url = base_url() . "admin/invoice/index/";
		$this->data["links"]    = $this->_get_pagination( $limit, $this->company_model->record_count(), $_number_segment, $base_url );

		$this->data[ "companies" ]  = $this->company_model->companies_limit( $limit , $page  )->result();

		$search = $this->input->get("search", FALSE);
		// echo $search;return;
		if( $search != FALSE )
		{
			$this->data[ "companies" ]  	= $this->company_model->search( $search  )->result();
		}
		$this->data[ "search" ]  			= trim( $search );
		//////////


		$this->data[ "page_title" ] = "Perusahaan";
		// $companies = $this->company_model->companies(  )->result();
		
		$this->render( "admin/company/V_list" );
	}
	public function detail( $company_id = NULL )
	{
		if( $company_id == NULL ) redirect(site_url('admin/company')); 

		$this->data[ "page_title" ] = "Perusahaan";
		$this->data[ "company" ]  = $this->company_model->company( $company_id )->row();
		$this->data[ "delivery_addresses" ]  = $this->delivery_address_model->delivery_addresses( $company_id )->result();
		// echo var_dump( $this->data[ "delivery_addresses" ][0]->pbbkb );return;
		
		$this->render( "admin/company/V_detail" );
	}

	public function add( $user_id = NULL )
	{	
		if( $user_id == NULL ) redirect(site_url('admin'));  

		if( !$this->ion_auth->in_group( array( "customers" ) ,$user_id ) )
		{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, "user bukan customer" ) );
			redirect(site_url('admin/user_management'));  
		}

		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');

		$this->form_validation->set_rules('name',  ('Nama Perusahaan'), 'trim|required');
		$this->form_validation->set_rules('address',  ('Alamat Perusahaan'), 'trim|required');
		$this->form_validation->set_rules('npwp',  ('NPWP'), 'trim|required');
		$this->form_validation->set_rules('situ',  ('SITU'), 'trim|required');
		$this->form_validation->set_rules('siup',  ('SIUP'), 'trim|required');
		$this->form_validation->set_rules('tdo',  ('TDO'), 'trim|required');
		$this->form_validation->set_rules('tdp',  ('TDP'), 'trim|required');
		$this->form_validation->set_rules('business_fields',  ('Bidang Usaha'), 'trim|required');
		$this->form_validation->set_rules('pph',  ('pph'), 'trim|required');
		
		if ($this->form_validation->run() === TRUE )
		{
			$data['name'] 				= $this->input->post('name');
			$data['address'] 			= $this->input->post('address');
			$data['npwp'] 				= $this->input->post('npwp');
			$data['situ'] 				= $this->input->post('situ');
			$data['siup'] 				= $this->input->post('siup');
			$data['tdo'] 				= $this->input->post('tdo');
			$data['tdp'] 				= $this->input->post('tdp');
			$data['business_fields'] 	= $this->input->post('business_fields');
			$data['pph'] 				= (1/100) *  ( float ) $this->input->post('pph');

			$data['user_id'] 		= $this->input->post('customer_id');

			if( $this->company_model->create( $data ) )
			{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->ion_auth->messages() ) );
				redirect(site_url('admin/user_management/index/').$data['user_id']  );
			}
			else
			{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->ion_auth->errors() ) );
				redirect(site_url('admin/user_management/index/').$data['user_id']  );
			}		
		}
		else
		{
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
				if(  validation_errors() || $this->ion_auth->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
				$this->data[ "page_title" ] = "Buat Data Perusahaan";
				$user = $this->ion_auth->user( $user_id )->row();

				if( $user == NULL ) redirect(site_url('admin'));  
				
				$this->data['customer_id'] = array(
					'name' => 'customer_id',
					'id' => 'customer_id',
					'type' => 'hidden',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('name', $user_id),
				);
				$this->data['kode_customer'] = array(
					'name' => 'kode_customer',
					'id' => 'kode_customer',
					'type' => 'text',
					'readonly' => '',
					'class' => 'form-control',
					'placeholder' => "Kode Customer",
					'value' => $this->form_validation->set_value('kode_customer', $user->username  ),
				);
				$this->data['direktur'] = array(
					'name' => 'direktur',
					'id' => 'direktur',
					'type' => 'text',
					'readonly' => '',
					'class' => 'form-control',
					'placeholder' => "Direktur",
					'value' => $this->form_validation->set_value('direktur', $user->first_name." ".$user->last_name  ),
				);
				$this->data['name'] = array(
					'name' => 'name',
					'id' => 'name',
					'type' => 'text',
					'placeholder' => "Nama Perusahaan",
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('name'),
				);
				$this->data['address'] = array(
					'name' => 'address',
					'id' => 'address',
					'type' => 'text',
					'placeholder' => "Alamat Perusahaan",
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('address'),
				);
				$this->data['npwp'] = array(
					'name' => 'npwp',
					'id' => 'npwp',
					'type' => 'text',
					'placeholder' => "NPWP",
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('npwp'),
				);
				$this->data['situ'] = array(
					'name' => 'situ',
					'id' => 'situ',
					'type' => 'text',
					'placeholder' => "SITU",
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('situ'),
				);
				$this->data['siup'] = array(
					'name' => 'siup',
					'id' => 'siup',
					'type' => 'text',
					'placeholder' => "SIUP",
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('siup'),
				);
				$this->data['tdo'] = array(
					'name' => 'tdo',
					'id' => 'tdo',
					'type' => 'text',
					'placeholder' => "TDO",
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('tdo'),
				);
				$this->data['tdp'] = array(
					'name' => 'tdp',
					'id' => 'tdp',
					'type' => 'text',
					'placeholder' => "TDP",
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('tdp'),
				);
				$this->data['business_fields'] = array(
					'name' => 'business_fields',
					'id' => 'business_fields',
					'type' => 'text',
					'placeholder' => "Bidang Usaha",
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('business_fields'),
				);
				$this->data['submit'] = array(
					'data' => 'submit',
					'value' => "Buat" ,
					'id' => 'submit',
					'type' => 'submit',
					'class' => 'btn btn-success pull-right btn-flat',
				);
				$pph_options ="";
				// 0=>tidak | 1 => ya
				$pphs = array( 0 , 0.3 );
				$pph_names = array( "Tidak" , "Ya" );

				foreach($pphs as $n => $item)
				{	
					$pph_options .= form_radio("pph", $pphs[ $n ] ,NULL, ' id="basic_checkbox_'.$n.'"');
					$pph_options .= '<label for="basic_checkbox_'.$n.'"> '. $pph_names[ $n ] .'</label><br>';
				}

				$this->data['pph'] = $pph_options;
				
				$this->render( "admin/company/V_add" );
		}		
	}
	public function edit( $user_id = NULL )
	{	
		if( $user_id == NULL ) redirect(site_url('admin'));  

		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');

		$this->form_validation->set_rules('name',  ('Nama Perusahaan'), 'trim|required');
		$this->form_validation->set_rules('address',  ('Alamat Perusahaan'), 'trim|required');
		$this->form_validation->set_rules('npwp',  ('NPWP'), 'trim|required');
		$this->form_validation->set_rules('situ',  ('SITU'), 'trim|required');
		$this->form_validation->set_rules('siup',  ('SIUP'), 'trim|required');
		$this->form_validation->set_rules('tdo',  ('TDO'), 'trim|required');
		$this->form_validation->set_rules('tdp',  ('TDP'), 'trim|required');
		$this->form_validation->set_rules('business_fields',  ('Bidang Usaha'), 'trim|required');
		$this->form_validation->set_rules('pph',  ('pph'), 'trim|required');

		
		if ($this->form_validation->run() === TRUE )
		{
			$data['name'] 				= $this->input->post('name');
			$data['address'] 			= $this->input->post('address');
			$data['npwp'] 				= $this->input->post('npwp');
			$data['situ'] 				= $this->input->post('situ');
			$data['siup'] 				= $this->input->post('siup');
			$data['tdo'] 				= $this->input->post('tdo');
			$data['tdp'] 				= $this->input->post('tdp');
			$data['business_fields'] 	= $this->input->post('business_fields');
			$data['pph'] 				= (1/100) *  ( float ) $this->input->post('pph');


			$data_param['id'] 		= $this->input->post('company_id');

			if( $this->company_model->update( $data, $data_param ) )
			{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->ion_auth->messages() ) );
				redirect(site_url('admin/user_management/index/').$this->input->post('customer_id') );
			}
			else
			{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->ion_auth->errors() ) );
				redirect(site_url('admin/user_management/index/').$this->input->post('customer_id')  );
			}		
		}
		else
		{
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
				if(  validation_errors() || $this->ion_auth->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
				$this->data[ "page_title" ] = "Buat Data Perusahaan";
				$user = $this->ion_auth->user( $user_id )->row();

				if( $user == NULL ) redirect(site_url('admin'));  
				
				$company = $this->company_model->companies( $user_id )->row();
				if( $company == NULL ) redirect(site_url('admin'));  


				$this->data['customer_id'] = array(
					'name' => 'customer_id',
					'id' => 'customer_id',
					'type' => 'hidden',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('name', $user_id ),
				);
				$this->data['company_id'] = array(
					'name' => 'company_id',
					'id' => 'company_id',
					'type' => 'hidden',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('company_id',$company->id ),
				);
				$this->data['kode_customer'] = array(
					'name' => 'kode_customer',
					'id' => 'kode_customer',
					'type' => 'text',
					'readonly' => '',
					'class' => 'form-control',
					'placeholder' => "Kode Customer",
					'value' => $this->form_validation->set_value('kode_customer', $user->username  ),
				);
				$this->data['direktur'] = array(
					'name' => 'direktur',
					'id' => 'direktur',
					'type' => 'text',
					'readonly' => '',
					'class' => 'form-control',
					'placeholder' => "Direktur",
					'value' => $this->form_validation->set_value('direktur', $user->first_name." ".$user->last_name  ),
				);
				$this->data['name'] = array(
					'name' => 'name',
					'id' => 'name',
					'type' => 'text',
					'placeholder' => "Nama Perusahaan",
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('name', $company->name),
				);
				$this->data['address'] = array(
					'name' => 'address',
					'id' => 'address',
					'type' => 'text',
					'placeholder' => "Alamat Perusahaan",
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('address' ,$company->address),
				);
				$this->data['npwp'] = array(
					'name' => 'npwp',
					'id' => 'npwp',
					'type' => 'text',
					'placeholder' => "NPWP",
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('npwp' ,$company->npwp),
				);
				$this->data['situ'] = array(
					'name' => 'situ',
					'id' => 'situ',
					'type' => 'text',
					'placeholder' => "SITU",
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('situ' ,$company->situ),
				);
				$this->data['siup'] = array(
					'name' => 'siup',
					'id' => 'siup',
					'type' => 'text',
					'placeholder' => "SIUP",
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('siup' ,$company->siup),
				);
				$this->data['tdo'] = array(
					'name' => 'tdo',
					'id' => 'tdo',
					'type' => 'text',
					'placeholder' => "TDO",
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('tdo' ,$company->tdo),
				);
				$this->data['tdp'] = array(
					'name' => 'tdp',
					'id' => 'tdp',
					'type' => 'text',
					'placeholder' => "TDP",
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('tdp' ,$company->tdp),
				);
				$this->data['business_fields'] = array(
					'name' => 'business_fields',
					'id' => 'business_fields',
					'type' => 'text',
					'placeholder' => "Bidang Usaha",
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('business_fields' ,$company->business_fields),
				);
				$this->data['submit'] = array(
					'data' => 'submit',
					'value' => "Edit" ,
					'id' => 'submit',
					'type' => 'submit',
					'class' => 'btn btn-success pull-right btn-flat',
				);
				$pph_options ="";
				// 0=>tidak | 1 => ya
				$pphs = array( 0 , 0.3 );
				$pph_check = array( 0=>"" , 1=>"checked" );
				$pph_names = array( "Tidak" , "Ya" );

				foreach($pphs as $n => $item)
				{	
					$pph_options .= form_radio("pph", $pphs[ $n ] , NULL , $pph_check[ $pphs[ $n ] == $company->pph * 100 ].' id="basic_checkbox_'.$n.'"');
					$pph_options .= '<label for="basic_checkbox_'.$n.'"> '. $pph_names[ $n ] .'</label><br>';
				}

				$this->data['pph'] = $pph_options;

				$this->render( "admin/company/V_edit" );
		}		
	}
}