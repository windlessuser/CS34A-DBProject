<?php

class Admin extends CI_Controller{
    
    function __construct()
	{
		parent::__construct();
        /*
		if($this->session->userdata('is_logged_in') != true)
        {
            redirect('welcome');
	    }
        if($this->session->userdata('is_admin') != 1)
        {
            redirect('welcome');
        }
		 * 
		 */
        
	}
    
    function index()
    {
        $data['title'] = 'Admin';
		$data['error'] = "";
        $data['main_content'] = 'manage_inventory';
		$this->load->model('inventory_CRUD');
		$config['base_url'] = site_url().'admin/index';
		$config['total_rows'] = $this->inventory_CRUD->inventory_count();
		$config['per_page'] = 10;
		$config['num_links'] = 20;
		$config['full_tag_open'] = '<div id="inventory">';
		$config['full_tag_close'] = '</div>';
		
		$this->pagination->initialize($config);		
		$data['records'] = $this->inventory_CRUD->get_inventory($config['per_page'],$this->uri->segment(3));
		
        $this->load->view('includes/template', $data);
    }
	
	function upload_csv()
	{
		$config['upload_path'] = 'csv/';
		$config['allowed_types'] = 'csv';
		$config['file_name'] = 'inventory.csv';
		$config['overwrite'] = TRUE;
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('CSV'))
		{
			$data['error'] = $this->upload->display_errors();
			redirect('admin');
		}
		else
		{
			$this->load->model('inventory_CRUD');
			$this->manage_inventory->insert_csv();
			redirect('admin');
		}
	}

}