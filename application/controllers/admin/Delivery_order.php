<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_order extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model( array( 
			'purchase_order_model', 
			'material_model', 
			'vendor_model', 
			'product_model', 
			'company_model', 
			'delivery_address_model', 
			'delivery_order_model',
			'do_log_model',
			'car_model',
			'do_report_model',
			'do_news_and_tax_model',
		) );
		$this->load->library( array( 'form_validation' ) ); 
	}
	public function create(  )
	{
		if( !($_POST) ) redirect(site_url('admin'));  
		$this->form_validation->set_rules('purchase_order_id', ('purchase_order_id'), 'trim|required');
		$this->form_validation->set_rules('car_id[]', ('car_id[]'), 'trim|required');
		$this->form_validation->set_rules('user_id[]', ('user_id[]'), 'trim|required');
		$this->form_validation->set_rules('quantity[]', ('quantity[]'), 'trim|required');
		$this->form_validation->set_rules('trip[]', ('Trip'), 'trim|required');
		$this->form_validation->set_rules('travel_cost[]', ('Uang Jalan'), 'trim|required');
		if ($this->form_validation->run() === TRUE )
		{
				$cars  				= $this->input->post('car_id[]');
				$drivers  			= $this->input->post('user_id[]');
				$quantities  			= $this->input->post('quantity[]');

				$base_quantity  	= $this->input->post('base_quantity');

				if( !$this->validation_order( $cars, $drivers, $quantities, $base_quantity )  )
				{
					$this->delivery_order_model->set_error( "terjadi kesalahan" );
				}
				else
				{
					// return;
					$data_do = array();
					$inputs =  ( $this->input->post('car_id[]') == null )? array(): $this->input->post('car_id[]')  ;
	
					$data = array();
					$data["purchase_order_id"] 	= $this->input->post('purchase_order_id');
					$data["create_date"] 		= time();
	
					foreach($inputs as $ind=>$val)
					{
							$data["car_id"] = $this->input->post('car_id')[$ind] ;
							$data["user_id"] = $this->input->post('user_id')[$ind] ;
							$data["quantity"] = $this->input->post('quantity')[$ind] ;
							$data["trip"] = $this->input->post('trip')[$ind] ;
							$data["travel_cost"] = $this->input->post('travel_cost')[$ind];
	
							array_push($data_do, $data);
					}
					
					if($this->delivery_order_model->insert_batch( $data_do ) )
					{
						$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->delivery_order_model->messages() ) );
					}
					else
					{
						$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->delivery_order_model->errors() ) );
					}
					redirect(site_url('admin/purchase_order/detail/').$this->input->post('purchase_order_id')  );  
				}
		}
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->delivery_order_model->errors() ? $this->delivery_order_model->errors() : $this->session->flashdata('message')));
		if(  validation_errors() || $this->delivery_order_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		
		redirect(site_url('admin/soa/create/').$this->input->post('purchase_order_id')  );  
	}

	protected function validation_order( $cars, $drivers, $quantities, $base_quantity )
	{	
		$car_array 		= array();
		$driver_array 	= array();

		foreach ($cars as $car) {
			if( in_array( $car, $car_array  ) ) return FALSE;
			else{
				array_push( $car_array, $car );
			}
		}
		foreach ($drivers as $driver) {
			if( in_array( $driver, $driver_array  ) ) return FALSE;
			else{
				array_push( $driver_array, $driver );
			}
		}
		$num = 0;
		foreach ($quantities as $quantity) {
			$num += $quantity;
		}
		return ( $num == $base_quantity );
	}

	public function detail( $delivery_order_id = NULL )
	{
		if( $delivery_order_id == NULL  ) redirect(site_url('admin/')); 

		$this->data[ "page_title" ] = "Delivery order";
		// $user_id = $this->ion_auth->get_user_id();
		$this->data[ "delivery_order" ] 	= $this->delivery_order_model->delivery_order( $delivery_order_id )->row();
		$this->data[ "purchase_order" ] 	= $this->purchase_order_model->purchase_order( $this->data[ "delivery_order" ]->purchase_order_id )->row();
		$this->data[ "delivery_address" ] 	= $this->delivery_address_model->delivery_address( $this->data[ "purchase_order" ]->delivery_address_id )->row();
		$this->data[ "company" ] 			= $this->company_model->company(  $this->data[ "purchase_order" ]->company_id  )->row();
		$this->data[ "vendor" ] 			= $this->vendor_model->vendor( $this->data[ "purchase_order" ]->vendor_id )->row();
		$this->data[ "material" ] 			= $this->material_model->material( $this->data[ "purchase_order" ]->material_id )->row();
		// echo var_dump( $this->data[ "delivery_orders" ] );return;
		$this->data[ "do_logs" ] 			= $this->do_log_model->logs( $delivery_order_id )->result();
		if( $this->data[ "delivery_order" ]->status = 2 )
		{
			$this->data[ "do_report" ] 	= $this->do_report_model->do_reports( $delivery_order_id )->row();
			$this->data[ "do_news_and_tax" ] 	= $this->do_news_and_tax_model->do_news_and_taxes( $delivery_order_id )->row();
		}

		$this->render( "admin/delivery_order/V_detail" );
	}

	public function generate_pdf( $delivery_order_id = NULL )
	{
		if( $delivery_order_id == NULL  ) redirect(site_url('admin/')); 

		// die;
		$this->data[ "delivery_order" ] 	= $this->delivery_order_model->delivery_order( $delivery_order_id )->row();
		$this->data[ "purchase_order" ] 	= $this->purchase_order_model->purchase_order( $this->data[ "delivery_order" ]->purchase_order_id )->row();
		$this->data[ "delivery_address" ] 	= $this->delivery_address_model->delivery_address( $this->data[ "purchase_order" ]->delivery_address_id )->row();
		$this->data[ "company" ] 			= $this->company_model->company(  $this->data[ "purchase_order" ]->company_id  )->row();
		$this->data[ "vendor" ] 			= $this->vendor_model->vendor( $this->data[ "purchase_order" ]->vendor_id )->row();
		$this->data[ "material" ] 			= $this->material_model->material( $this->data[ "purchase_order" ]->material_id )->row();
		$this->data[ "car" ]	 			= $this->car_model->car( $this->data[ "delivery_order" ]->car_id )->row();

		// var_dump($this->data[ "purchase_order" ]);die;
		$width = 190;
		// $width = 280-5;
		$line = 5-0.3;
		$content_font_size = 8;

		$this->load->library('pdf');
		$pdf = new FPDF();
		// $pdf = new FPDF('l','mm','A4');

		$pdf->AddPage();
		// $pdf->Image( base_url().BACKGROUND_PDF, 0, 0, 300, 300 );
		$pdf->Image( base_url().FAVICON_IMAGE, 10, 10, 50/2, 35/2 );
		$pdf->Image( base_url().'assets/images/logo/pertamina.png', 190-15, 10, 50/2, 35/2 );
		$pdf->Cell( $width/3-15 	, $line*4, NULL, 0, 0 );
		$pdf->SetFont('Arial', 'B', 18);
		$pdf->Cell( $width/3+15+15 	, $line*4, "Letter Of Delivery", 0, 0, "C" );
		$pdf->Cell( $width/3 -15	, $line*4, NULL, 0, 1 );

		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell( $width	, $line*5/2-3, "Activity Record", 0, 1, "C" );
		// 
		$pdf->Cell( $width/3 	, $line*2, NULL, 1, 0 );
		$pdf->Cell( $width/3 	, $line*2, NULL, 1, 0, "C" );
		$pdf->Cell( $width/3	, $line*2, NULL, 1, 1 );
		// 
		$pdf->setY( $line*8 );
		$pdf->SetFont('Arial', '', $content_font_size);
		$pdf->Cell( $width/3, $line, "Ship to Company ", 0, 0 );
		$pdf->Cell( $width/3, $line, ucwords( $this->data[ "company" ]->name ), 0, 0 );
		$pdf->Cell( $width/3, $line, "Street : ".ucwords( $this->data[ "delivery_address" ]->name ), 0, 1 );
		$pdf->Cell( $width/3, $line, "Company Address ", 0, 0 );
		$pdf->Cell( $width/3, $line, NULL, 0, 0 );
		$pdf->Cell( $width/3, $line, "City : ".ucwords( $this->data[ "delivery_address" ]->city ).", ".ucwords( $this->data[ "delivery_address" ]->province ) , 0, 1 );
		// 
		$pdf->Cell( $width/3 	, $line*2, NULL, 1, 0 );
		$pdf->Cell( $width/3 	, $line*2, NULL, 1, 0, "C" );
		$pdf->Cell( $width/3	, $line*2, NULL, 1, 1 );
		// 
		
		// 
		$pdf->setY( $line*10 );
		$pdf->SetFont('Arial', '', $content_font_size);
		$pdf->Cell( $width/3, $line, "Transport Agent ", 0, 0 );
		$pdf->Cell( $width/3, $line,  ucwords( $this->data[ "vendor" ]->name ) , 0, 0 );
		$pdf->Cell( $width/3, $line, "Street : ".ucwords( $this->data[ "vendor" ]->address ), 0, 1 );
		$pdf->Cell( $width/3, $line, "Transport Agent Address ", 0, 0 );
		$pdf->Cell( $width/3, $line, NULL, 0, 0 );
		$pdf->Cell( $width/3, $line, "City : Kendari, Sulawesi Tenggara" , 0, 1 );
		// 
		$pdf->SetFont('Arial', 'B', 11);
		$pdf->Cell( $width/3	, $line*2, "Validation", 1, 0, "C" );
		$pdf->Cell( $width/3	, $line*2, "Product", 1, 0, "C" );
		$pdf->Cell( $width/3	, $line*2, "Qty", 1, 1, "C" );
		// 
		$pdf->SetFont('Arial', '', $content_font_size);
		$pdf->Cell( $width/3	, $line, "Delivery Order Oil", 1, 0, "C" );
		$pdf->Cell( $width/3	, $line, ucwords( $this->data[ "material" ]->name ), 1, 0, "C" );
		$pdf->Cell( $width/3	, $line, number_format( $this->data[ "delivery_order" ]->quantity )." ".ucwords( $this->data[ "material" ]->unit )  , 1, 1, "C" );
		// 
		$pdf->SetFont('Arial', '', $content_font_size);
		$pdf->Cell( $width/3	, $line, "Delivery Date \t: ".date( "d/m/Y" , $this->data[ "delivery_order" ]->create_date ), 1, 0  );
		$pdf->Cell( $width/3	, $line, "Seal Above : ", 1, 0 );
		$pdf->Cell( $width/3	, $line, "Start Discharge Hour : ", 1, 1);
		// 
		$pdf->SetFont('Arial', '', $content_font_size);
		$pdf->Cell( $width/3	, $line, "Delivery Order Number : ".$this->data[ "delivery_order" ]->code, 1, 0  );
		$pdf->Cell( $width/3	, $line, "", 1, 0 );
		$pdf->Cell( $width/3	, $line, "", 1, 1);
		// 
		$pdf->SetFont('Arial', '', $content_font_size);
		$pdf->Cell( $width/3	, $line, "Police Number : ".$this->data[ "car" ]->plat_number, 1, 0  );
		$pdf->Cell( $width/3	, $line, "Seal Down \t: ", 1, 0 );
		$pdf->Cell( $width/3	, $line, "Finished Discharge Hour :", 1, 1);
		// 
		$pdf->Cell( $width	, $line, NULL, 0, 1, "C" );
		// 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->Cell( $width/3 	, $line*8, NULL, 1, 0,NULL,  true );
		$pdf->Cell( $width/3 	, $line*8, NULL, 1, 0, NULL,  true );
		$pdf->Cell( $width/3	, $line*8, NULL, 1, 1,NULL,  true );
		// 
		// 
		$pdf->setY( $line*20 );
		$pdf->SetFont('Arial', '', $content_font_size);
		$pdf->Cell( $width/3, $line, "Acknowledge By,", 0, 0, "C" );
		$pdf->Cell( $width/3, $line, "Received By,", 0, 0, "C" );
		$pdf->Cell( $width/3, $line, "Driver,", 0, 0, "C" );
		// 
		$pdf->setY( $line*20+ $line*5);
		$pdf->Cell( $width/3, $line, "(...........................................)", 0, 0, "C" );
		$pdf->Cell( $width/3, $line, "(...........................................)", 0, 0, "C" );
		$pdf->Cell( $width/3, $line, "(".ucwords( $this->data[ "delivery_order" ]->driver_name ).")", 0, 1, "C" );
		$pdf->Cell( $width/3, $line, "Office Head", 0, 0, "C" );
		#################################################################################################################################################################
		#################################################################################################################################################################
		#################################################################################################################################################################
		$pdf->setY( $line*32 );
		// $pdf->Image( base_url().BACKGROUND_PDF, 0, 0, 300, 300 );
		$pdf->Image( base_url().FAVICON_IMAGE, 10, 10  + ($line*30), 50/2, 35/2 );
		$pdf->Image( base_url().'assets/images/logo/pertamina.png', 190-15, 10 + ($line*30), 50/2, 35/2 );
		$pdf->Cell( $width/3-15 	, $line*4, NULL, 0, 0 );
		$pdf->SetFont('Arial', 'B', 18);
		$pdf->Cell( $width/3+15+15 	, $line*4, "Letter Of Delivery", 0, 0, "C" );
		$pdf->Cell( $width/3 -15	, $line*4, NULL, 0, 1 );

		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell( $width	, $line*5/2-3, "Activity Record", 0, 1, "C" );
		// 
		$pdf->Cell( $width/3 	, $line*2, NULL, 1, 0 );
		$pdf->Cell( $width/3 	, $line*2, NULL, 1, 0, "C" );
		$pdf->Cell( $width/3	, $line*2, NULL, 1, 1 );
		// 
		$pdf->setY( $line*5.88 + $line*32 );
		$pdf->SetFont('Arial', '', $content_font_size);
		$pdf->Cell( $width/3, $line, "Ship to Company ", 0, 0 );
		$pdf->Cell( $width/3, $line, ucwords( $this->data[ "company" ]->name ), 0, 0 );
		$pdf->Cell( $width/3, $line, "Street : ".ucwords( $this->data[ "delivery_address" ]->name ), 0, 1 );
		$pdf->Cell( $width/3, $line, "Company Address ", 0, 0 );
		$pdf->Cell( $width/3, $line, NULL, 0, 0 );
		$pdf->Cell( $width/3, $line, "City : ".ucwords( $this->data[ "delivery_address" ]->city ).", ".ucwords( $this->data[ "delivery_address" ]->province ) , 0, 1 );
		// 
		$pdf->Cell( $width/3 	, $line*2, NULL, 1, 0 );
		$pdf->Cell( $width/3 	, $line*2, NULL, 1, 0, "C" );
		$pdf->Cell( $width/3	, $line*2, NULL, 1, 1 );
		// 
		
		// 
		$pdf->setY( $line*( 10 - 2.12  )+ $line*32 );
		$pdf->SetFont('Arial', '', $content_font_size);
		$pdf->Cell( $width/3, $line, "Transport Agent ", 0, 0 );
		$pdf->Cell( $width/3, $line,  ucwords( $this->data[ "vendor" ]->name ) , 0, 0 );
		$pdf->Cell( $width/3, $line, "Street : ".ucwords( $this->data[ "vendor" ]->address ), 0, 1 );
		$pdf->Cell( $width/3, $line, "Transport Agent Address ", 0, 0 );
		$pdf->Cell( $width/3, $line, NULL, 0, 0 );
		$pdf->Cell( $width/3, $line, "City : Kendari, Sulawesi Tenggara" , 0, 1 );
		// 
		$pdf->SetFont('Arial', 'B', 11);
		$pdf->Cell( $width/3	, $line*2, "Validation", 1, 0, "C" );
		$pdf->Cell( $width/3	, $line*2, "Product", 1, 0, "C" );
		$pdf->Cell( $width/3	, $line*2, "Qty", 1, 1, "C" );
		// 
		$pdf->SetFont('Arial', '', $content_font_size);
		$pdf->Cell( $width/3	, $line, "Delivery Order Oil", 1, 0, "C" );
		$pdf->Cell( $width/3	, $line, ucwords( $this->data[ "material" ]->name ), 1, 0, "C" );
		$pdf->Cell( $width/3	, $line, number_format( $this->data[ "delivery_order" ]->quantity )." ".ucwords( $this->data[ "material" ]->unit )  , 1, 1, "C" );
		// 
		$pdf->SetFont('Arial', '', $content_font_size);
		$pdf->Cell( $width/3	, $line, "Delivery Date \t: ".date( "d/m/Y" , $this->data[ "delivery_order" ]->create_date ), 1, 0  );
		$pdf->Cell( $width/3	, $line, "Seal Above : ", 1, 0 );
		$pdf->Cell( $width/3	, $line, "Start Discharge Hour : ", 1, 1);
		// 
		$pdf->SetFont('Arial', '', $content_font_size);
		$pdf->Cell( $width/3	, $line, "Delivery Order Number : ".$this->data[ "delivery_order" ]->code, 1, 0  );
		$pdf->Cell( $width/3	, $line, "", 1, 0 );
		$pdf->Cell( $width/3	, $line, "", 1, 1);
		// 
		$pdf->SetFont('Arial', '', $content_font_size);
		$pdf->Cell( $width/3	, $line, "Police Number : ".$this->data[ "car" ]->plat_number, 1, 0  );
		$pdf->Cell( $width/3	, $line, "Seal Down \t: ", 1, 0 );
		$pdf->Cell( $width/3	, $line, "Finished Discharge Hour :", 1, 1);
		// 
		$pdf->Cell( $width	, $line, NULL, 0, 1, "C" );
		// 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->Cell( $width/3 	, $line*8, NULL, 1, 0,NULL,  true );
		$pdf->Cell( $width/3 	, $line*8, NULL, 1, 0, NULL,  true );
		$pdf->Cell( $width/3	, $line*8, NULL, 1, 1,NULL,  true );
		// 
		// 
		$pdf->setY( $line*( 20 - 2.12  )+ $line*32 );
		$pdf->SetFont('Arial', '', $content_font_size);
		$pdf->Cell( $width/3, $line, "Acknowledge By,", 0, 0, "C" );
		$pdf->Cell( $width/3, $line, "Received By,", 0, 0, "C" );
		$pdf->Cell( $width/3, $line, "Driver,", 0, 0, "C" );
		// 
		$pdf->setY( $line*( 20 - 2.12  )+ $line*5 +  $line*32);
		$pdf->Cell( $width/3, $line, "(...........................................)", 0, 0, "C" );
		$pdf->Cell( $width/3, $line, "(...........................................)", 0, 0, "C" );
		$pdf->Cell( $width/3, $line, "(".ucwords( $this->data[ "delivery_order" ]->driver_name ).")", 0, 1, "C" );
		$pdf->Cell( $width/3, $line, "Office Head", 0, 0, "C" );
		#################################################################################################################################################################
		#################################################################################################################################################################
		#################################################################################################################################################################

		$pdf->Output(  );
		// $pdf->Output( "laporan.pdf", "D" );
	}
}