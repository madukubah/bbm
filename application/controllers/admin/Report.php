<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends Admin_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model( array( 'car_model','purchase_order_model' ) ); 
		$this->load->library( array( 'form_validation' ) ); 

	} 
	public function index()
	{
		$this->data[ "page_title" ] = "Rekapitulasi";
		
		
		if( !($_POST) )	
		{
			$data[ "rows" ]  = array();
			$this->data['start_date'] 		= date("m/d/Y");
			$this->data['end_date']		 	= date("m/d/Y");
		}
		else
		{

			$date_1 = $this->input->post("start_date");
			$date_2 = $this->input->post("end_date");
			
			$this->data['start_date'] 		= $date_1;
			$this->data['end_date']		 	= $date_2;
			
			// $str =  date("m/d/Y H:i:s", $data[ "rows" ][0]->date );
			// $date_1 =  date("m/d/Y", $date_1 );
			// $date_2 =  date("m/d/Y", $date_2 );

			$date_1 = $date_1." 00:00:01";
			$date_2 = $date_2." 23:59:00";

			$start 	=  strtotime( $date_1 );
			$end 	=  strtotime( $date_2 );

			$data[ "rows" ]  = $this->purchase_order_model->purchase_orders_period( $start, $end )->result();
		}

		$data["header"] = array(
			'code' => 'Kode',
			'delivery_address_code' => 'Kode Alamat Serah',
			'material_name' => 'Material',
			'quantity' => 'Jumlah',
			'date' => 'Tanggal',
			'total' => 'Total (Rp)',
		);
		$table = $this->load->view('templates/tables/plain_table_1', $data, true);	
		$this->data[ "table" ] = $table;
		$this->render( "admin/report/V_list" );
	}


}