<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_management extends Admin_Controller {
	public $CURRENT_PAGE = "admin/user_management/";
	public function __construct(){
		parent::__construct();
		$this->load->library( array( 'form_validation' ) ); 
		$this->load->model( array( 'company_model' ) ); 
	} 
	public function index( $user_id = NULL )
	{
		$this->data[ "page_title" ] = "User Management";

		if( $user_id == NULL )redirect(site_url('admin'));  

		$this->data[ "page_title" ] = "User Account";
		$this->data[ "users" ] = $this->ion_auth->user( $user_id )->result();
		if( $this->ion_auth->in_group( array( "customers" ) ,$user_id ) )
		{
			$this->data[ "companies" ] = $this->company_model->companies( $user_id )->result();
		}
		$this->render( "admin/user_management/V_detail" );

	}
	public function customer( $user_id = NULL )
	{
		$this->data[ "page_title" ] = "Customer";

		// $this->data[ "customers" ] = $this->ion_auth->users( "customers" )->result();
		// $this->render( "admin/user_management/customer/V_list" );
		#set Limit
		$_limit_segment 	= 4;
		$_number_segment 	= 5;
		if ($this->uri->segment( $_limit_segment ) != "") {
			$limit = $this->uri->segment( $_limit_segment );
		} else {
			$limit = 10;
		}

		$page              		= ($this->uri->segment( $_number_segment )) ? $this->uri->segment( $_number_segment ) : 0;
		$base_url = base_url() . $this->CURRENT_PAGE."customer/";
		$data[ "rows" ] = $this->ion_auth->users( 'customers' )->result();
		$this->data["links"]    = $this->_get_pagination( $limit, count( $data[ "rows" ] ), $_number_segment, $base_url );

		$data["header"] = array(
			'username' => 'username',
			'first_name' => 'Nama Depan',
			'last_name' => 'Nama Belakang',
			'phone' => 'No Telepon',
			'email' => 'Email',
			'address' => 'Alamat',
		);
		$data[ "rows" ] = $this->ion_auth->users_limit($limit , $page, 'customers' )->result();
		$data[ "action" ] = array(
			array(
				"name" => "Detail",
				"type" => "link",
				"url" => site_url("admin/user_management/index/"),
				"button_color" => "primary",
				"param" => "id",
			),
			array(
				"name" => "Edit",
				"type" => "link",
				"url" => site_url("admin/user_management/edit/"),
				"button_color" => "primary",
				"param" => "id",
			),
			array(
				"name" => '<i class="ace-icon fa fa-trash bigger-120 red"></i>',
				"type" => "modal_delete",
				"modal_id" => "delete_category_",
				"url" => site_url("admin/user_management/delete/"),
				"button_color" => "danger",
				"param" => "id",
				"form_data" => array(
					"id" => array(
						'type' => 'hidden',
						'label' => "id",
					),
				),
				"title" => "User",
				"data_name" => "username",
			),
		);
		$table = $this->load->view('templates/tables/plain_table', $data, true);
		$this->data[ "table" ] = $table;
		$this->render( "admin/user_management/V_list" );
	}
	
	public function admin( $user_id = NULL )
	{
		$this->data[ "page_title" ] = "Admin";

		// $this->data[ "customers" ] = $this->ion_auth->users( "admin" )->result();
		// $this->render( "admin/user_management/customer/V_list" );
		$_limit_segment 	= 4;
		$_number_segment 	= 5;
		if ($this->uri->segment( $_limit_segment ) != "") {
			$limit = $this->uri->segment( $_limit_segment );
		} else {
			$limit = 10;
		}

		$page              		= ($this->uri->segment( $_number_segment )) ? $this->uri->segment( $_number_segment ) : 0;
		$base_url = base_url() . $this->CURRENT_PAGE."admin/";
		$data[ "rows" ] = $this->ion_auth->users( 'admin' )->result();
		$this->data["links"]    = $this->_get_pagination( $limit, count( $data[ "rows" ] ), $_number_segment, $base_url );

		$data["header"] = array(
			'username' => 'username',
			'first_name' => 'Nama Depan',
			'last_name' => 'Nama Belakang',
			'phone' => 'No Telepon',
			'email' => 'Email',
			'address' => 'Alamat',
		);
		$data[ "rows" ] = $this->ion_auth->users_limit($limit , $page, 'admin' )->result();
		$data[ "action" ] = array(
			array(
				"name" => "Detail",
				"type" => "link",
				"url" => site_url("admin/user_management/index/"),
				"button_color" => "primary",
				"param" => "id",
			),
			array(
				"name" => "Edit",
				"type" => "link",
				"url" => site_url("admin/user_management/edit/"),
				"button_color" => "primary",
				"param" => "id",
			),
			array(
				"name" => '<i class="ace-icon fa fa-trash bigger-120 red"></i>',
				"type" => "modal_delete",
				"modal_id" => "delete_category_",
				"url" => site_url("admin/user_management/delete/"),
				"button_color" => "danger",
				"param" => "id",
				"form_data" => array(
					"id" => array(
						'type' => 'hidden',
						'label' => "id",
					),
				),
				"title" => "User",
				"data_name" => "username",
			),
		);
		$table = $this->load->view('templates/tables/plain_table', $data, true);
		$this->data[ "table" ] = $table;
		$this->render( "admin/user_management/V_list" );
	}
	public function driver( $user_id = NULL )
	{
		$this->data[ "page_title" ] = "Driver";

		// $this->data[ "drivers" ] = $this->ion_auth->users( "driver" )->result();
		// $this->render( "admin/user_management/driver/V_list" );
		#set Limit
		$_limit_segment 	= 4;
		$_number_segment 	= 5;
		if ($this->uri->segment( $_limit_segment ) != "") {
			$limit = $this->uri->segment( $_limit_segment );
		} else {
			$limit = 10;
		}

		$page              		= ($this->uri->segment( $_number_segment )) ? $this->uri->segment( $_number_segment ) : 0;
		$base_url = base_url() . $this->CURRENT_PAGE."driver/";
		$data[ "rows" ] = $this->ion_auth->users( 'driver' )->result();
		$this->data["links"]    = $this->_get_pagination( $limit, count( $data[ "rows" ] ), $_number_segment, $base_url );
		$data["header"] = array(
			'username' => 'username',
			'first_name' => 'Nama Depan',
			'last_name' => 'Nama Belakang',
			'phone' => 'No Telepon',
			'email' => 'Email',
			'address' => 'Alamat',
		);
		$data[ "rows" ] = $this->ion_auth->users_limit($limit , $page, 'driver' )->result();
		$data[ "action" ] = array(
			array(
				"name" => "Detail",
				"type" => "link",
				"url" => site_url("admin/user_management/index/"),
				"button_color" => "primary",
				"param" => "id",
			),
			array(
				"name" => "Edit",
				"type" => "link",
				"url" => site_url("admin/user_management/edit/"),
				"button_color" => "primary",
				"param" => "id",
			),
			array(
				"name" => '<i class="ace-icon fa fa-trash bigger-120 red"></i>',
				"type" => "modal_delete",
				"modal_id" => "delete_category_",
				"url" => site_url("admin/user_management/delete/"),
				"button_color" => "danger",
				"param" => "id",
				"form_data" => array(
					"id" => array(
						'type' => 'hidden',
						'label' => "id",
					),
				),
				"title" => "User",
				"data_name" => "username",
			),
		);
		$table = $this->load->view('templates/tables/plain_table', $data, true);
		$this->data[ "table" ] = $table;
		$this->render( "admin/user_management/V_list" );
	}
	public function delete(  )
	{
		if( !($_POST) ) redirect(site_url('admin')); 
		

		$id = $this->input->post('id');
		if( $this->ion_auth->in_group("customers", $id ) )
        {
            $menu = "customer";
        }
        else if( $this->ion_auth->in_group("admin", $id ) )
		{
			$menu = "admin";
		}
		else
		{
			$menu = "driver";
		}
        
		if( $this->ion_auth->delete_user( $id ) ){
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->ion_auth->messages() ) );
		}else{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->ion_auth->errors() ) );
		}
	   
		redirect(site_url('admin/user_management/').$menu);  
	}
	public function add(  )
	{
		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->form_validation->set_rules( $this->ion_auth->get_validation_config() );
		if ( $this->form_validation->run() === TRUE )
		{
			$group_id = $this->input->post('group_id');
			$username_prefix = $this->config->item('username_prefix', 'ion_auth')[ $group_id];

			$last_user = $this->ion_auth_model->last_user_id( $group_id )->row();
			$last_id = ( $last_user == NULL ) ? 0 :  (int) substr( $last_user->username, strlen( $username_prefix ) );

			$last_id++;

			$email = strtolower( $this->input->post('email') );
			$identity = $username_prefix.$last_id;
			$password = $identity;
			//$this->input->post('password');
			$group_id = array($group_id);


			$additional_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'address' => $this->input->post('address')
			);

		}
		if ($this->form_validation->run() === TRUE && ( $id =  $this->ion_auth->register($identity, $password, $email,$additional_data, $group_id) ) )
		{
		    
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->ion_auth->messages() ) );
			if( $this->ion_auth->in_group("customers", $id ) )
            {
                $menu = "customer";
            }
			else if( $this->ion_auth->in_group("admin", $id ) )
			{
                $menu = "admin";
			}
			else
            {
                $menu = "driver";
            }
			redirect(site_url('admin/user_management/').$menu);  			
		}
		else
		{
				$this->data = $this->ion_auth->get_form_data(); //harus paling pertama

				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
				if(  validation_errors() || $this->ion_auth->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
				$this->data[ "page_title" ] = "Tambah User";
				$this->render( "admin/user_management/V_add" );
		}
	}

	public function edit( $user_id = NULL ) 
	{	
		if( $user_id == NULL ) redirect(site_url('admin'));  

		$this->form_validation->set_rules( $this->ion_auth->get_validation_config() );
		if ( $this->form_validation->run() === TRUE )
		{
			$user_id= $this->input->post('user_id');

			$data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'address' => $this->input->post('address'),
			);

			if ( $this->input->post('user_password') )
			{
				$data['user_password'] = $this->input->post('user_password');
				//$data['old_password'] = $this->input->post('old_password');
			}

			// $user = $this->ion_auth->user( $user_id )->row();
			// check to see if we are updating the user
			if ( $this->ion_auth->update( $user_id, $data ) )
			{
				// redirect them back to the admin page if admin, or to the base url if non admin
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->ion_auth->messages() ) );
				
				// redirect(site_url('admin/user_management'));
			}
			else
			{
				// redirect them back to the admin page if admin, or to the base url if non admin
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->ion_auth->errors() ) );
				// redirect(site_url('admin/user_management'));  
			}
			if( $this->ion_auth->in_group("customers", $user_id ) )
            {
                $menu = "customer";
            }
            else
            {
                $menu = "driver";
            }
			redirect(site_url('admin/user_management/').$menu); 
		}
		else
		{
			$user = $this->ion_auth->user( $user_id )->row();
			$this->data = $this->ion_auth->get_form_data( $user->user_id ); //harus paling pertama
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			if(  validation_errors() || $this->ion_auth->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
			
			$this->data[ "page_title" ] = "Edit User";
			$this->data[ "user" ] = $user;
			

			$this->render( "admin/user_management/V_edit" );
		}
	}
}
