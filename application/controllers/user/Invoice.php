<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends User_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model( array( 'delivery_order_model', 'purchase_order_model', 'delivery_address_model', 'company_model', 'vendor_model', 'material_model','invoice_model' ) ); 
		$this->load->library( array( 'form_validation' ) ); 

		
		if(!$this->ion_auth->is_admin()) 
		{
			$company = $this->company_model->companies( $this->ion_auth->get_user_id() )->row();
			if( $company == NULL ) redirect( site_url("user/") );
		}
		
	} 
	public function index()
	{
		$this->data[ "page_title" ] = "Invoice";
		$_limit_segment 	= 4;
		$_number_segment 	= 5;
		#set Limit
		if ($this->uri->segment( $_limit_segment ) != "") {
			$limit = $this->uri->segment( $_limit_segment );
		} else {
			$limit = 10;
		}

		$page              		= ($this->uri->segment( $_number_segment )) ? $this->uri->segment( $_number_segment ) : 0;

		$base_url = base_url() . "user/invoice/index/";
		$this->data["links"]    = $this->_get_pagination( $limit, $this->invoice_model->record_count(), $_number_segment, $base_url );
		$company					= $this->company_model->companies(  $this->ion_auth->get_user_id()  )->row();

		$this->data[ "invoices" ]  = $this->invoice_model->invoices_limit( $limit , $page, $company->id  )->result();

		$search = $this->input->get("search", FALSE);
		// echo $search;return;
		if( $search != FALSE )
		{
			$this->data[ "invoices" ]  	= $this->invoice_model->search( $search, $company->id  )->result();
		}
		$this->data[ "search" ]  			= trim( $search );

		// $this->data[ "invoices" ] 	=  $this->invoice_model->by_company_id( $company->id )->result();
		// echo var_dump( $this->data[ "invoices" ]  );return;

		$this->render( "user/invoice/V_list" );
	}

	public function detail( $invoice_id = NULL )
	{	
		$this->data[ "page_title" ] = "Detail Invoice";
		$invoice  = $this->invoice_model->invoice( $invoice_id )->row();
		if( $invoice_id == NULL || $invoice == NULL ) redirect(site_url('user/invoice')); 
		$this->data[ "delivery_orders" ] = $this->delivery_order_model->delivery_orders_and_report( $invoice->purchase_order_id )->result();
		$this->data[ "purchase_order" ]  = $this->purchase_order_model->purchase_order( $invoice->purchase_order_id )->row();
		$this->data[ "delivery_address" ] 	= $this->delivery_address_model->delivery_address( $this->data[ "purchase_order" ]->delivery_address_id )->row();
		$this->data[ "company" ] 			= $this->company_model->company(  $this->data[ "purchase_order" ]->company_id  )->row();
		$this->data[ "vendor" ] 			= $this->vendor_model->vendor( $this->data[ "purchase_order" ]->vendor_id )->row();
		$this->data[ "material" ] 			= $this->material_model->material( $this->data[ "purchase_order" ]->material_id )->row();

		$this->data[ "invoice" ] 		= 	$invoice;
		$this->data[ "price" ] = $invoice->price;
		$this->data[ "quantity" ] =  $invoice->quantity ;
		$this->data[ "subtotal" ] =  $invoice->sub_total  ;
		$this->data[ "ppn" ] =  $invoice->ppn;
		$this->data[ "pph" ] =  $invoice->pph;
		$this->data[ "pbbkb" ] =  $invoice->pbbkb ;
		$this->data[ "total" ] = $invoice->total ;
		$this->data[ "date" ] =  date( "d/m/Y" , $invoice->date )  ;

		$this->render( "user/invoice/V_detail" );
	}
	public function generate_invoice_pdf( $invoice_id )
	{
		$invoice  = $this->invoice_model->invoice( $invoice_id )->row();
		if( $invoice_id == NULL || $invoice == NULL ) redirect(site_url('admin/invoice')); 

		$this->data[ "delivery_orders" ] = $this->delivery_order_model->delivery_orders( $invoice->purchase_order_id )->result();

		$this->data[ "page_title" ] = "Detail ";
		$purchase_order = $this->purchase_order_model->purchase_order( $invoice->purchase_order_id )->row();
		$this->data[ "purchase_order" ]  = $purchase_order;

		$this->data[ "company" ] = $this->company_model->company(  $purchase_order->company_id  )->row();
		$this->data[ "vendor" ] = $this->vendor_model->vendor( $purchase_order->vendor_id )->row();
		$delivery_address = $this->delivery_address_model->delivery_address( $purchase_order->delivery_address_id )->row();
		$this->data[ "delivery_address" ] = $delivery_address;
		
		$material = $this->material_model->material( $purchase_order->material_id )->row();
		$this->data[ "material" ] = $material;
		
		$this->data[ "invoice" ] 		= 	$invoice;

		// ////////////////////////////////////////////
		$width = 190;
		// $width = 280-5;
		$line = 5-0.3;
		$content_font_size = 8;
		$border = 0;
		$border_a = 1;

		$this->load->library('pdf');
		// $pdf = new FPDF();
		$pdf = new FPDF('p','mm','A4');
		$pdf->AddPage();
		// $pdf->Image( base_url().BACKGROUND_PDF, 0, 0, 300, 300 );
		$pdf->Image( base_url().FAVICON_IMAGE, 10, 10, 50/2, 35/2 );
		$pdf->Image( base_url().'assets/images/logo/pertamina.png', 190-15, 10, 50/2, 35/2 );
		$pdf->Cell( $width/3-15 	, $line*4, NULL, 0, 0 );
		$pdf->SetFont('Arial', 'B', 18);
		$pdf->Cell( $width/3+15+15 	, $line*4, NULL, 0, 0, "C" );
		$pdf->Cell( $width/3 -15	, $line*4, NULL, 0, 1 );

		// 
		$pdf->Cell( $width/3 	, $line*2, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line*2, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3	, $line*2, NULL, $border, 1 );
		// 
		// 
		$pdf->SetFont('Arial', 'B', 18);
		$pdf->Cell( $width/3 	, $line*2, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line*2, "INVOICE", $border, 0, "C" );
		$pdf->Cell( $width/3	, $line*2, NULL, $border, 1 );
		// 
		// 
		$pdf->Cell( $width/3 	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3	, $line, NULL, $border, 1 );
		// 
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell( $width/3 +2	, $line, "Bill To : ", $border, 0 );
		$pdf->Cell( $width/3 -4	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3+2	, $line, "Customer Info : ", $border, 1 );
		// 
		// 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->Cell( $width/3 +10, $line*4, NULL, $border_a, 0 ,NULL, true);
		$pdf->Cell( $width/3 -24, $line*4, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3+14	, $line*4, NULL, $border_a, 1 ,NULL, true);
		// 
		// 
		$pdf->setY( $line*12 + 1/3 );
		$pdf->SetFont('Arial', '', $content_font_size);
		$pdf->Cell( $width/3 +10	, $line, "Company : ".$this->data[ "company" ] ->name, $border, 0 );
		$pdf->Cell( $width/3 -24	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3 +14	, $line, "Date : ".date( "d/m/Y" , $this->data[ "invoice" ]->date ), $border, 1 );
		// 
		$pdf->Cell( $width/3 +10	, $line, "Address : ".$this->data[ "company" ] ->address, $border, 0 );
		$pdf->Cell( $width/3 -24	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3 +14	, $line, "Customer : ".$this->data[ "delivery_address" ]->name, $border, 1 );
		// 
		$pdf->Cell( $width/3 +10	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3 -24	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3 +14	, $line, "Invoice # : ".$this->data[ "invoice" ]->code, $border, 1 );
		// 
		$pdf->Cell( $width/3 +10	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3 -24	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3 +14	, $line, "Page : ", $border, 1 );
		// 
		// 
		$pdf->Cell( $width/3 	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3	, $line, NULL, $border, 1 );
		// 
		// 
		$pdf->SetFillColor(255, 255, 255);
		
		$pdf->Cell( $width/7 -15, $line, "No", $border_a, 0, "C" , true);
		$pdf->Cell( $width/7 +15	, $line, "NO. Purchase Order", $border_a, 0 , 'C', true);
		$pdf->Cell( $width/7 +15	, $line, "Product / Material", $border_a, 0 , 'C', true);
		$pdf->Cell( $width/7 -10, $line, "Quantity", $border_a, 0, 'C' , true);
		$pdf->Cell( $width/7 -10	, $line, "Unit", $border_a, 0, 'C' , true);
		$pdf->Cell( $width/7 + 32	, $line, "Price", $border_a, 1 , "C", true);
		// 
		// 
		$pdf->Cell( $width/7 -15	, $line*2, "1", $border_a, 0, "C" , true);
		$pdf->Cell( $width/7 +15	, $line*2, $this->data[ "purchase_order" ]->code, $border_a, 0 , 'C', true);
		$pdf->Cell( $width/7 +15	, $line*2, $this->data[ "material" ]->name, $border_a, 0 , 'C', true);
		$pdf->Cell( $width/7 -10	, $line*2, number_format( $this->data[ "invoice" ]->quantity ), $border_a, 0, 'C' , true);
		$pdf->Cell( $width/7 -10	, $line*2, $this->data[ "material" ]->unit, $border_a, 0, 'C' , true);
		$pdf->Cell( $width/7 + 32	, $line*2, 'Rp. '.number_format( $this->data[ "invoice" ]->price ), $border_a, 1 , "C", true);
		// 
		// 
		$pdf->Cell( $width/7 -15	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/7 +15	, $line, NULL, $border, 0 , 'C');
		$pdf->Cell( $width/7 +15	, $line, NULL, $border, 0 , 'C');
		$pdf->Cell( $width/7 -10	, $line, NULL, $border, 0, 'C') ;
		$pdf->Cell( $width/7 -10	, $line, "Total ", $border_a, 0, 'C' , true);
		$pdf->Cell( $width/7 + 32	, $line, 'Rp. '.number_format( $this->data[ "invoice" ]->total ), $border_a, 1 , "C", true);
		// 
		// 
		$pdf->Cell( $width/3 	, $line*2, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line*2, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3	, $line*2, NULL, $border, 1 );
		// 
		//
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell( $width/3 +50	, $line*2, 'Other Comments or Special Instructions', $border_a, 0, 'C', true );
		$pdf->Cell( $width/3 -60	, $line*2, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3 +10	, $line*2, "In Words", $border_a, 1, 'C' , true);
		// 
		$pdf->Cell( $width/3 +50	, $line*7, NULL, $border_a, 0, 'C', true );
		$pdf->Cell( $width/3 -60	, $line*7, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3 +10	, $line*7, NULL, $border_a, 1, 'C' , true);
		// 
		$pdf->setY( $line*25 + 1/3 );
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell( $width/3 +2	, $line, "Make All Payment Payable To", $border, 1 );
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell( $width/3 +2	, $line, strtoupper($this->data[ "vendor" ]->name ), $border, 1 );
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell( $width/3 -30	, $line, "Bank Account", $border, 0 );
		$pdf->Cell( $width/3 +15	, $line, ":".$this->data[ "vendor" ]->bank_account, $border, 1 );
		$pdf->Cell( $width/3 -30	, $line, "Bank Name ", $border, 0 );
		$pdf->Cell( $width/3 +15	, $line, ":".$this->data[ "vendor" ]->bank_name, $border, 1 );
		$pdf->Cell( $width/3 -30	, $line, "Bank Branch ", $border, 0 );
		$pdf->Cell( $width/3 +15	, $line, ":".$this->data[ "vendor" ]->bank_branch, $border, 1 );
		$pdf->Cell( $width/3 -30	, $line, "Swift Code", $border, 0 );
		$pdf->Cell( $width/3 +15	, $line, ":".$this->data[ "vendor" ]->swift_code, $border, 1 );
		$pdf->Cell( $width/3 +15	, $line, NULL, $border, 1 );
		// 
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell( $width/3 +50	, $line, NULL, $border, 0, 'C' );
		$pdf->Cell( $width/3 -60	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3 +10	, $line, "If you have question about this invoice", $border, 1, NULL);
		$pdf->Cell( $width/3 +50	, $line, NULL, $border, 0, 'C' );
		$pdf->Cell( $width/3 -60	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3 +10	, $line, "Please Contact to : ", $border, 1, NULL);
		// 
		// 
		$pdf->Cell( $width/3 	, $line*2, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line*2, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3	, $line*2, NULL, $border, 1 );
		// 
		// 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->Cell( $width/3 	, $line*8, NULL, $border, 1,NULL );
		// 
		// 
		$pdf->setY( $line*37 );
		$pdf->SetFont('Arial', 'B', $content_font_size);
		$pdf->Cell( $width/3, $line, strtoupper($this->data[ "vendor" ]->name), 0, 1, "C" );
		$pdf->Cell( $width/3, $line, "Manager Accounting,", 0, 1, "C" );
		// 
		$pdf->setY( $line*37+ $line*5);
		$pdf->Cell( $width/3, $line, "(...........................................)", 0, 1, "C" );
		// 
		// 
		$pdf->Cell( $width/3	, $line*2, NULL, $border, 1 );
		// 
		// 
		$pdf->Cell( $width/3 	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line, NULL, $border, 0, "C" );
		$pdf->Cell( $width/3	, $line, NULL, $border, 1 );
		// 
		// 
		$pdf->Cell( $width/7 -5	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line, "Customer Service : ", $border, 0);
		$pdf->Cell( $width/3	, $line, NULL, $border, 1 );
		// 
		// 
		$pdf->Cell( $width/7 -5	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3 	, $line, strtoupper($this->data[ "vendor" ]->name), $border, 0);
		$pdf->Cell( $width/3	, $line, NULL, $border, 1 );
		// 
		// 
		$pdf->Cell( $width/7 -5	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/30, $line, NULL, $border, 0 );
		$pdf->Cell( $width/7 + 2 	, $line, $this->data[ "vendor" ]->address, $border, 0);
		$pdf->Cell( $width/30, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3	, $line, $this->data[ "vendor" ]->email, $border, 1 );
		// 
		// 
		$pdf->Cell( $width/7 -5	, $line, NULL, $border, 0 );
		$pdf->Cell( $width/30, $line, NULL, $border, 0 );
		$pdf->Cell( $width/7 + 2 	, $line, $this->data[ "vendor" ]->phone, $border, 0);
		$pdf->Cell( $width/30, $line, NULL, $border, 0 );
		$pdf->Cell( $width/3	, $line, $this->data[ "vendor" ]->phone_2, $border, 1 );
		// 

		$pdf->Image( base_url()."assets/images/avatars/CS.png", 10, 215, 4*5, 4*5 );
		$pdf->Image( base_url()."assets/images/icon/home.png", 33, 226, 4, 4 );
		$pdf->Image( base_url()."assets/images/icon/mail.png", 33 + 37, 226, 4, 4 );
		$pdf->Image( base_url()."assets/images/icon/telephone.png", 33, 226 + 5, 4, 4 );
		$pdf->Image( base_url()."assets/images/icon/bbm.png", 33 + 37, 226 + 5, 4, 4 );

		$pdf->Output(  );
	}
}