<?php

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$data['title'] = 'Welcome!';
		$data['main_content'] = 'login_form';
		$this->load->view('includes/template', $data);	
	}
	
	function validate_credentials()
	{		
		$this->load->model('membership_model');
		$query = $this->membership_model->validate();
		
		if($query['is_user']) // if the user's credentials validated...
		{
			echo $query['is_admin'];
			$data = array(
				'username' => $this->input->post('username'),
				'is_logged_in' => true,
                'is_admin' => $query['is_admin']
			);
			$this->session->set_userdata($data);
            if($query['is_admin'] == 1)
            {
			    redirect('admin');
            }
			else{
				
			}
		}
		else // incorrect username or password
		{
			$this->index();
		}
	}	
	
	function signup()
	{
		$data['title'] = 'Sign Up';
		$data['main_content'] = 'signup_form';
		$this->load->view('includes/template', $data);
	}
	
	function create_member()
	{
		$this->load->library('form_validation');
		
		if($this->form_validation->run() == FALSE)
		{
			redirect('welcome/signup');
		}
		
		else
		{			
			$this->load->model('membership_model');
			
			if($query = $this->membership_model->create_member())
			{
				redirect('welcome/index');
			}
			else
			{
				redirect('welcome/signup');		
			}
		}
		
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		$this->index();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */