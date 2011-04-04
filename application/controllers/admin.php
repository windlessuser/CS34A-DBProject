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
		$offset = 0;
		$config['upload_path'] = 'csv/';
		$config['allowed_types'] = 'csv';
		$config['file_name'] = 'inventory.csv';
		$config['overwrite'] = TRUE;
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('CSV'))
		{
			$data['error'] = $this->upload->display_errors();
			$data['main_content'] = 'manage_inventory';
			$this->load->view('includes/template', $data);
		}
		else
		{
			$handle = fopen(site_url().'csv/inventory.csv','r');
			while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {

    		print_r($this->generate_barcode(mysql_real_escape_string($data[0]),$offset));

    		$entry = array(
    				'barcode' => null,
    				'name' => mysql_real_escape_string($data[0]),    
    				'quantity' => mysql_real_escape_string($data[1]),
					'price' => mysql_real_escape_string($data[2]),
					'brand' => mysql_real_escape_string($data[3]),
					'category' => mysql_real_escape_string($data[4]),
					'image' => 'images/'. mysql_real_escape_string($data[5]),
					'i_size' => mysql_real_escape_string($data[6]),
					'i_colour' => mysql_real_escape_string($data[7]),
					'description' => mysql_real_escape_string($data[8])
					);			
					while(!$this->db->insert('inventory',$entry)){
						$offset++;
						$entry['barcode'] = $this->generate_barcode(mysql_real_escape_string($data[0]),$offset);				
					}
			}
			
			redirect('admin');
		}
	}
	
	function generate_barcode($name,$offset){
		return passthru('support\barcode.bat '.'"'.$name.'" '.'"'.$offset.'"');
	}
}