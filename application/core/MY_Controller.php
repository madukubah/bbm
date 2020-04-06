<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    protected $data = array();
    public function __construct()
    {
       parent::__construct();
    }
    protected function render($the_view = NULL, $template = NULL)
	{
		if($template == 'json' || $this->input->is_ajax_request())
		{
			header('Content-Type: application/json');
			echo json_encode($this->data);
		}
		elseif(is_null($template))
		{
			$this->load->view($the_view, $this->data );
		}
		else
		{
			$this->data['the_view_content'] = (is_null($the_view)) ? '' : $this->load->view($the_view, $this->data, TRUE);
			$this->load->view('templates/V_' . $template . '', $this->data);
		}
	}

	protected function _get_pagination( $limit, $record_count, $uri_segment, $base_url )
	{
		$this->load->library("pagination");
		#Config for pagination...
		$config                = array();
		$config["base_url"]    = $base_url . $limit;
		$config["total_rows"]  = $record_count;
		$config["per_page"]    = $limit;
		$config["uri_segment"] = $uri_segment;
		
		#Config css for pagination...
		$config['full_tag_open']   = '<ul class="pagination">';
		$config['full_tag_close']  = '</ul>';
		$config['first_link']      = "First";
		$config['last_link']       = "Last";
		$config['first_tag_open']  = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link']       = '&laquo';
		$config['prev_tag_open']   = '<li class="prev">';
		$config['prev_tag_close']  = '</li>';
		$config['next_link']       = '&raquo';
		$config['next_tag_open']   = '<li>';
		$config['next_tag_close']  = '</li>';
		$config['last_tag_open']   = '<li>';
		$config['last_tag_close']  = '</li>';
		$config['cur_tag_open']    = '<li class="active"><a href="#">';
		$config['cur_tag_close']   = '</a></li>';
		$config['num_tag_open']    = '<li>';
		$config['num_tag_close']   = '</li>';
		$this->pagination->initialize($config);

		return $this->pagination->create_links();
	}
}

class User_Controller extends MY_Controller
{
    public function __construct()
    {
	   parent::__construct();
	   if( !$this->ion_auth->logged_in() ) 
	   {
		$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER,  $this->lang->line('login_not_login')  ) );
		   redirect(site_url('/auth/login'));
	   }
    }
    protected function render($the_view = NULL, $template = 'user_master')
	{
		parent::render($the_view, ( $this->ion_auth->is_admin() ? 'admin_master' : $template ) );
	}
}

class Admin_Controller extends User_Controller
{
    public function __construct()
    {
	   parent::__construct();
		if(!$this->ion_auth->is_admin()) 
		{
			// redirect(site_url('/auth/logout'));
			
			$this->ion_auth->logout();
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->lang->line('login_must_admin') ) );
			redirect(site_url('/auth/login'));
		}
    }
    protected function render($the_view = NULL, $template = 'admin_master')
	{
		parent::render($the_view, $template);
	}
}
class Driver_Controller extends User_Controller
{
    public function __construct()
    {
	   parent::__construct();
		if(! $this->ion_auth->in_group("driver" ) ) 
		{
			redirect(site_url('/user'));
		}
    }
    protected function render($the_view = NULL, $template = 'user_master')
	{
		parent::render($the_view, ( $this->ion_auth->is_admin() ? 'admin_master' : $template ) );
	}
}

class Public_Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
    }
    protected function render($the_view = NULL, $template = 'public_master')
	{
		parent::render($the_view, $template);
	}
}