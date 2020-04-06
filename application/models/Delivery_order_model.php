<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_order_model extends MY_Model
{
    /**
	 * Holds an array of tables used
	 *
	 * @var array
	 */
	public $tables = array();
    public $join = array();
    public function __construct()
	{
		parent::__construct("delivery_order");
        $this->tables['name'] = "delivery_order";
	}
	/**
	 * create
	 *
	 * @param array  $data
	 * @return static
	 * @author madukubah
	 */
	public function create( $data )
    {
		// Filter the data passed
        $data = $this->_filter_data($this->tables['name'], $data);

        $this->db->insert($this->tables['name'], $data);
        $id = $this->db->insert_id($this->tables['name'] . '_id_seq');
		
		if( isset($id) )
		{
			$this->set_message('berhasil menambah data ');
			return $id;
		}
		$this->set_error('gagal');
        return FALSE;
	}
	/**
	 * create
	 *
	 * @param array  $data
	 * @return static
	 * @author madukubah
	 */
	public function insert_batch( $data_rows )
    {
		$this->order_by($this->tables['name'].'.status', 'asc');
		$this->load->model( array( 'purchase_order_model' ) ); 
		// Filter the data passed
		$data_rows = $this->_filter_data_batch( $this->tables['name'], $data_rows);
		//echo var_dump( $data_rows );

		$this->db->trans_begin();
		$this->db->insert_batch( $this->tables['name'], $data_rows);
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->set_error('gagal');
			return FALSE;
		}
		$data['status']		= 1;
		$data_param["id"]   = $data_rows[0]['purchase_order_id'];
		$this->purchase_order_model->update( $data, $data_param  );

		$this->db->trans_commit();
		$this->set_message('berhasil');
		return TRUE;
	}
	/**
	 * update
	 *
	 * @param array  $data
	 * @param array  $data_param
	 * @return bool
	 * @author madukubah
	 */
	public function update( $data, $data_param  )
    {
		$this->db->trans_begin();
		$data = $this->_filter_data($this->tables['name'], $data);

		$this->db->update($this->tables['name'], $data, $data_param );
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			$this->set_error('gagal');
			return FALSE;
		}

		$this->db->trans_commit();

		$this->set_message('berhasil');
		return TRUE;
	}
	/**
	 * delete
	 *
	 * @param array  $data_param
	 * @return bool
	 * @author madukubah
	 */
	
	public function delete( $data_param  )
    {
		if( array_key_exists( "id", $data_param ) ){
			$_data_param[ $this->tables['name']."_id"] = $data_param["id"];
			$this->delete_foreign( $_data_param  );
		}else{
			foreach( $data_param as $key => $value )
			{
				$this->where($this->tables['name'].'.'.$key , $value );
			}

			foreach( $this->delivery_orders( )->result() as $item )
			{
				$_data_param[ $this->tables['name']."_id"]  = $item->id;
				$this->delete_foreign( $_data_param  );
			}
		}
		
		$this->db->trans_begin();

		$this->db->delete($this->tables['name'], $data_param );
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			$this->set_error('gagal');
			return FALSE;
		}

		$this->db->trans_commit();

		$this->set_message('berhasil');
		return TRUE;
	}
		/**
	 * delete_foreign
	 *
	 * @param array  $data_param
	 * @return bool
	 * @author madukubah
	 */
	public function delete_foreign( $data_param  )
    {
		$this->load->model( array( 'do_log_model', 'do_report_model','do_news_and_tax_model' ) ); 	
		$this->do_log_model->delete( $data_param );
		$this->do_report_model->delete( $data_param );
		$this->do_news_and_tax_model->delete( $data_param );
		
	}
	/**
	 * has_delivery_order
	 *
	 * @param int| purchase_order_id
	 * @return static
	 * @author madukubah
	 */
	public function has_delivery_order( $purchase_order_id  )
    {
		return $this->db->where( "purchase_order_id", $purchase_order_id)
						->count_all_results($this->tables['name']) > 0;
	}
	/**
	 * delivery_orders_limit
	 *
	 * @return static
	 * @author madukubah
	 */
	public function delivery_orders_limit( $limit ,  $start = 0, $user_id = NULL )
    {

		$this->limit( $limit );
		$this->offset( $start );
		
		// $this->order_by($this->tables['name'].'.id asc, ', NULL);
		$this->order_by($this->tables['name'].'.status asc,'.$this->tables['name'].'.id desc', "");
		$this->driver_delivery_order( $user_id );

		return $this;
	}
	/**
	 * search
	 *
	 * @return static
	 * @author madukubah
	 */
	public function search( $query,  $user_id = NULL )
    {

		$this->like( $this->tables['name'].'.code', $query );
		$this->order_by( $this->tables['name'].'.status asc,'.$this->tables['name'].'.id desc', "");
		$this->driver_delivery_order( $user_id );

		return $this;
	}
	/**
	 * driver_delivery_order
	 *
	 * @param int|array|null $id = user_id
	 * @return static
	 * @author madukubah
	 */
	public function driver_delivery_order( $user_id  )
    {
		$this->where($this->tables['name'].'.user_id', $user_id);
        // $this->order_by($this->tables['name'].'.status asc,'.$this->tables['name'].'.id desc', "");

		$this->delivery_orders();

		return $this;
	}
	/**
	 * count_unprocess
	 *
	 *
	 * @return int
	 * @author madukubah
	 */
	public function count_unprocess_by_user_id( $user_id )
	{
		return $this->db->where( "status" , 0 )
						->where($this->tables['name'].'.user_id', $user_id)
						->count_all_results($this->tables['name']) ;
	}
	/**
	 * delivery_order
	 *
	 * @param int|array|null $id = id_categories
	 * @return static
	 * @author madukubah
	 */
	public function delivery_order( $id = NULL  )
    {
		if (isset($id))
		{
			$this->where($this->tables['name'].'.id', $id);
        }

		$this->limit(1);
        $this->order_by($this->tables['name'].'.id', 'desc');

		$this->delivery_orders();

		return $this;
	}
		/**
	 * delivery_order
	 *
	 * @param int|array|null $id = id_categories
	 * @return static
	 * @author madukubah
	 */
	public function delivery_orders_and_report( $purchase_order_id  )
    {
		// default selects
		$this->db->select(array(
			$this->tables['name'].'.*',
			"car".'.plat_number',
			'CONCAT(users.first_name, " ", users.last_name) AS driver_name',
			'do_report.quantity as do_report_quantity',
		));
		$this->db->distinct();
		$this->db->join(
			"users",
			"users.id = ".$this->tables['name'].'.user_id',
			'inner'
		);
		$this->db->join(
			"car",
			"car.id = ".$this->tables['name'].'.car_id',
			'inner'
		);
		$this->db->join(
			"do_report",
			"do_report.delivery_order_id = ".$this->tables['name'].'.id',
			'inner'
		);
		$this->db->where_in( $this->tables['name'].".purchase_order_id" ,  ( $purchase_order_id ) ) ;
		$this->response = $this->db->get($this->tables['name']);
		return $this;

	}

	/**
	 * categories
	 *
	 *
	 * @return static
	 * @author madukubah
	 */
    public function delivery_orders( $purchase_order_id = NULL )
    {
        if (isset($this->_ion_select) && !empty($this->_ion_select))
		{
			foreach ($this->_ion_select as $select)
			{
				$this->db->select($select);
			}

			$this->_ion_select = array();
		}
		else
		{
			// default selects
			$this->db->select(array(
			    $this->tables['name'].'.*',
			    "car".'.plat_number',
			    'CONCAT(users.first_name, " ", users.last_name) AS driver_name',
			));
			$this->db->distinct();
			$this->db->join(
				"users",
				"users.id = ".$this->tables['name'].'.user_id',
				'inner'
			);
			$this->db->join(
				"car",
				"car.id = ".$this->tables['name'].'.car_id',
				'inner'
			);
		}
		// filter 
		if (isset($purchase_order_id))
		{	
			$this->db->where_in( $this->tables['name'].".purchase_order_id" ,  ( $purchase_order_id ) ) ;
		}
        // run each where that was passed
		if ( isset($this->_ion_where) && ! empty($this->_ion_where) )
		{
			foreach ($this->_ion_where as $where)
			{
				$this->db->where($where);
			}
			$this->_ion_where = array();
		}
        // set like
        if (isset($this->_ion_like) && !empty($this->_ion_like))
		{
			foreach ($this->_ion_like as $like)
			{
				$this->db->like($like['like'], $like['value'], $like['position']);
			}

			$this->_ion_like = array();
		}
        //set limit / offset
        if( isset( $this->_ion_limit ) && isset( $this->_ion_offset ) )
		{
			$this->db->limit($this->_ion_limit, $this->_ion_offset);
			$this->_ion_limit  = NULL;
			$this->_ion_offset = NULL;
		}
		else if (isset($this->_ion_limit))
		{
			$this->db->limit($this->_ion_limit);
			$this->_ion_limit  = NULL;
		}
        // set the order
		if (isset($this->_ion_order_by) && isset($this->_ion_order))
		{
			$this->db->order_by($this->_ion_order_by, $this->_ion_order);

			$this->_ion_order    = NULL;
			$this->_ion_order_by = NULL;
		}
        $this->response = $this->db->get($this->tables['name']);
		return $this;
    }
    
	
	// MASSAGES AND ERROR
	/**
	 * set_message
	 *
	 * Set a message
	 *
	 * @param string $message The message
	 *
	 * @return string The given message
	 * @author Ben Edmunds
	 */
	public function set_message($message)
	{
		$messageLang = $this->lang->line($message) ? $this->lang->line($message) : $message;
		parent::set_message( $messageLang );
	}
	/**
	 * set_error
	 *
	 * Set an error message
	 *
	 * @param string $error The error to set
	 *
	 * @return string The given error
	 * @author Ben Edmunds
	 */
	public function set_error( $error )
	{
		$errorLang = $this->lang->line($error) ? $this->lang->line($error) :  $error ;
		parent::set_error( $errorLang );
	}

	protected function _filter_data_batch( $table, $data )
	{
		$filtered_row = array();
		foreach( $data as $row )
		{
			$filtered_row[] = $this->_filter_data($table, $row);
		}
		
		return $filtered_row;
	}
}