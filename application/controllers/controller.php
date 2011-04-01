<?php

class Controller extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
            
        if(!$this->session->userdata('is_logged_in'))
        {
            redirect('welcome');
	    }   
    }
}

/* End of file controller.php */
/* Location: ./application/controllers/controller.php */