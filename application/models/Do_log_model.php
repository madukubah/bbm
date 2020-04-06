<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Do_log_model extends MY_Model
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
		parent::__construct("do_log");
        $this->tables['name'] = "do_log";
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
	 * has_delivery_order
	 *
	 * @param int| purchase_order_id
	 * @return static
	 * @author madukubah
	 */
	public function exist( $flag, $delivery_order_id  )
    {
		return $this->db->where( $this->tables['name'].".flag", $flag)
						->where( $this->tables['name'].".delivery_order_id", $delivery_order_id)
						->count_all_results( $this->tables['name'] ) > 0;
	}
	/**
	 * do_log
	 *
	 * @param int|array|null $id = id_categories
	 * @return static
	 * @author madukubah
	 */
	public function do_log( $id = NULL  )
    {
		if (isset($id))
		{
			$this->where($this->tables['name'].'.id', $id);
        }

		$this->limit(1);
        $this->order_by($this->tables['name'].'.id', 'desc');
		$this->do_logs();

		return $this;
	}
	
	public function logs(  $delivery_order_id )
    {
        $this->order_by($this->tables['name'].'.flag', 'asc');
		$this->do_logs( $delivery_order_id );
		return $this;
	}

	/**
	 * categories
	 *
	 *
	 * @return static
	 * @author madukubah
	 */
    public function do_logs( $delivery_order_id = NULL )
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
			));
		}
		// filter 
		if( isset( $delivery_order_id ) )
		{
			$this->db->where_in( $this->tables['name'].".delivery_order_id" ,  ( $delivery_order_id ) ) ;
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
				$this->db->or_like($like['like'], $like['value'], $like['position']);
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