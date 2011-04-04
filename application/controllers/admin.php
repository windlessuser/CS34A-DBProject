<?php

class Admin extends Controller{
    
    function __construct()
	{
		parent::__construct();
        
        if(!$this->session->userdata('is_admin'))
        {
            redirect('member');
        }
        
	}
    
    function index()
    {
        $data['title'] = 'Admin';
        $data['main_content'] = 'admin';
        $this->load->view('includes/template', $data);
        $this->output-cache(60);
    }

}
/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
