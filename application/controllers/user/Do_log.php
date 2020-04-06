<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Do_log extends Driver_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model( array( 
			'do_log_model', 
			'delivery_order_model',
			'purchase_order_model',
			'do_report_model',
		) ); 		
		$this->load->library( array( 'form_validation' ) ); 
		
		
	} 
	public function index()
	{
		$this->ion_auth->trigger_events('on_update_do');
		$this->data[ "page_title" ] = "Purchase order";
		$user_id = $this->ion_auth->get_user_id();
		$this->data[ "delivery_orders" ] = $this->delivery_order_model->driver_delivery_order( $user_id )->result();

		$this->render( "user/delivery_order/V_list" );
	}
	
	public function add()
	{
		if( !($_POST) )	redirect(site_url('user'));
		
		// echo var_dump(  $this->input->post() );return;

		$this->form_validation->set_rules('delivery_order_id', ('delivery_order_id'), 'trim|required');
		$this->form_validation->set_rules('flag', ('flag'), 'trim|required');
		if( $this->input->post('flag') == 3 )
		{
			$this->form_validation->set_rules('quantity', ('quantity'), 'trim|required');
			$this->form_validation->set_rules('temperature', ('temperature'), 'trim|required');
			$this->form_validation->set_rules('sg', ('sg'), 'trim|required');
			$this->form_validation->set_rules('tank_condition', ('Kondisi Tanki'), 'trim|required');
			$this->form_validation->set_rules('quality', ('Qualitas'), 'trim|required');
			$this->form_validation->set_rules('information', ('Keterangan'), 'trim|required');
		}

		if ($this->form_validation->run() === TRUE )
		{		
				$data['delivery_order_id'] = $this->input->post('delivery_order_id');
				$data['flag'] = $this->input->post('flag');
				$data['date'] = time();

				if( $this->do_log_model->exist( $data['flag'], $data['delivery_order_id'] ) )redirect(site_url('user/delivery_order/detail/'). $this->input->post('delivery_order_id') );  

				if( $this->do_log_model->create( $data ) )
				{
					if( $this->input->post('flag') == 3 )
					{
						$_data['delivery_order_id'] = $this->input->post('delivery_order_id');
						$_data['quantity'] 			= $this->input->post('quantity');
						$_data['temperature'] 		= $this->input->post('temperature');
						$_data['sg'] 		        = $this->input->post('sg');
						$_data['tank_condition'] 	= $this->input->post('tank_condition');
						$_data['quality'] 			= $this->input->post('quality');
						$_data['information'] 		= $this->input->post('information');
						$this->do_report_model->create( $_data );
					}
					$this->update_do( $data );
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->do_log_model->messages() ) );
				}
				else
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->do_log_model->errors() ) );
				}
				redirect(site_url('user/delivery_order/detail/'). $this->input->post('delivery_order_id') );  
		}
		else
		{
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->do_log_model->errors() ? $this->do_log_model->errors() : $this->session->flashdata('message')));
				if(  validation_errors() || $this->do_log_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
				
				redirect(site_url('user/delivery_order/detail/'). $this->input->post('delivery_order_id') );  
		}
	}
	protected function update_do( $data )
	{
		$_data_param['id'] 				= $data['delivery_order_id'];
		$_data['status'] 				= ( $data['flag'] == 3 ) ? 2 : 1  ;
		$this->delivery_order_model->update( $_data, $_data_param );
		$delivery_order = $this->delivery_order_model->delivery_order( $_data_param['id'] )->row();
		$this->purchase_order_model->sync_status( $delivery_order->purchase_order_id );
	}

}