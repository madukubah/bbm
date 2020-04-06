<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_model extends MY_Model
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
		parent::__construct("invoice");
        $this->tables['name'] = "invoice";
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
			$this->set_message('berhasil ');
			return $id;
		}
		$this->set_error('gagal');
        return FALSE;
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

			foreach( $this->invoices( )->result() as $item )
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
		
	}
	/**
	 * invoices_limit
	 *
	 * @return static
	 * @author madukubah
	 */
	public function invoices_limit( $limit ,  $start = 0,  $company_id = NULL )
    {

		$this->limit( $limit );
		$this->offset( $start );
		
		// $this->order_by($this->tables['name'].'.id asc, ', NULL);
		$this->order_by($this->tables['name'].'.status asc,'.$this->tables['name'].'.id desc', "");
		$this->by_company_id( $company_id );
		// $this->invoices();

		return $this;
	}
	/**
	 * search
	 *
	 * @return static
	 * @author madukubah
	 */
	public function search( $query, $company_id = NULL )
    {

		$this->like( $this->tables['name'].'.code', $query );
		$this->order_by( $this->tables['name'].'.status asc,'.$this->tables['name'].'.id desc', "");
		// $this->invoices();	
		$this->by_company_id( $company_id );

		return $this;
	}
	
	/**
	 * invoice
	 *
	 * @param int|array|null $id = id_categories
	 * @return static
	 * @author madukubah
	 */
	public function invoice( $id = NULL  )
    {
		if (isset($id))
		{
			$this->where($this->tables['name'].'.id', $id);
        }

		$this->limit(1);
        $this->order_by($this->tables['name'].'.id', 'desc');

		$this->invoices();

		return $this;
	}
	/**
	 * exist
	 *
	 * @param int| purchase_order_id
	 * @return static
	 * @author madukubah
	 */
	public function exist(  $purchase_order_id  )
    {
		return $this->db->where( $this->tables['name'].".purchase_order_id", $purchase_order_id)
						->count_all_results( $this->tables['name'] ) > 0;
	}
	/**
	 * count_unprocess
	 *
	 *
	 * @return int
	 * @author madukubah
	 */
	public function count_unprocess(  )
	{

		return $this->db->where( "status" , 0 )
						->count_all_results($this->tables['name']) ;
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
		// $this->db->distinct();
		$this->db->join(
			"purchase_order",
			"purchase_order.id = ".$this->tables['name'].'.purchase_order_id',
			'inner'
		);
		$this->db->join(
			"material",
			"material.id = purchase_order.material_id",
			'inner'
		);
		$this->db->join( 
			"delivery_address",
			"delivery_address.id = purchase_order.delivery_address_id",
			'inner'
		);
		$this->db->join( 
			"company",
			"company.id = "."delivery_address".'.company_id',
			'inner'
		);
		$this->db->join( 
			"users",
			"users.id = company.user_id",
			'inner'
		);
		
		return $this->db->where( $this->tables['name'].".status" , 0 )
						->where( "users.id" , $user_id )
						->count_all_results($this->tables['name']) ;
	}
	/**
	 * categories
	 *
	 *
	 * @return static
	 * @author madukubah
	 */
    public function by_company_id( $company_id = NULL )
    {
		$this->join( 
			"delivery_address",
			"delivery_address.id = purchase_order.delivery_address_id",
			'inner'
		);
		$this->join( 
			"company",
			"company.id = "."delivery_address".'.company_id',
			'inner'
		);
		
		if (isset($company_id))
		{
			$this->where( 'company.id', $company_id );
        }
		$this->invoices(  );
		return $this;

	}
	/**
	 * categories
	 *
	 *
	 * @return static
	 * @author madukubah
	 */
    public function invoices( $purchase_order_id = NULL )
    {
		// $this->join( 
		// 	"purchase_order",
		// 	"purchase_order.id = ".$this->tables['name'].'.purchase_order_id',
		// 	'inner'
		// );
		// $this->join( 
		// 	"material",
		// 	"material.id = purchase_order.material_id",
		// 	'inner'
		// );
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
				'purchase_order.code as purchase_order_code',
				'material.name as material_name',
			));
			$this->db->distinct();
			$this->db->join(
				"purchase_order",
				"purchase_order.id = ".$this->tables['name'].'.purchase_order_id',
				'inner'
			);
			$this->db->join(
				"material",
				"material.id = purchase_order.material_id",
				'inner'
			);
		}
		// join
		if (isset($this->_ion_join) && !empty($this->_ion_join))
		{
			$this->db->distinct();
			foreach ($this->_ion_join as $join)
			{
				$this->db->join(
					$join[ "join" ],
					$join[ "on_join" ],
					$join[ "position" ]
				);
			}

			$this->_ion_join = array();
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
}