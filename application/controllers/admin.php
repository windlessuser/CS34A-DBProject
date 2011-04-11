<?php
include('Controller.php');

class Admin extends Controller{
    
    function __construct()
	{
		parent::__construct();
        if($this->session->userdata('is_admin') != 1)
        {
            redirect('welcome');
        }
	}
	
    
    function index($sort_by = 'name', $sort_order = 'asc', $offset = 0)
    {
    	$limit = 20;
    	$data['fields'] = array(
			'image' => 'image',
			'name' => 'name',
			'brand' => 'brand',
			'category' => 'category',
			'price' =>'price',
			'quantity' => 'quantity',
			'description' => 'description'
		);

        $data['title'] = 'Admin';
		$data['error'] = "";
        $data['main_content'] = 'manage_inventory';
		$this->load->model('inventory_CRUD');
		
				
		$results = $this->inventory_CRUD->search($limit, $offset, $sort_by, $sort_order);	
		//$results = $this->inventory_CRUD->get_inventory($limit,$offset);		
		$data['records'] = $results['rows'];
		//$data['records'] = $results->result();
		$data['num_results'] = $results['num_rows'];
		//$data['num_results'] = $this->inventory_CRUD->inventory_count();
		
		$config['base_url'] = site_url("admin/index/$sort_by/$sort_order");
		$config['total_rows'] = $data['num_results'];
		$config['per_page'] = $limit;
		$config['num_links'] = 20;
		$config['uri_segment'] = 5;
		$config['full_tag_open'] = '<div id="inventory">';
		$config['full_tag_close'] = '</div>';
		
		$this->pagination->initialize($config);
		
		$data['sort_by'] = $sort_by;
		$data['sort_order'] = $sort_order;
		
		$data['Brand_table_category_options'] = $this->inventory_CRUD->get_brand_options();
		$data['Category_table_category_options'] = $this->inventory_CRUD->get_category_options();

        $this->load->view('includes/template', $data);
    }
	
	function search(){
		
		$query_array = array(
			'name' => $this->input->post('name'),
			'category' => $this->input->post('category'),
			'brand'	=> $this->input->post('brand'),
			'price_comparison' => $this->input->post('price_comparison'),
			'price' => $this->input->post('price'),
			'quantity_comparison' => $this->input->post('quantity_comparison'),
			'quantity' => $this->input->post('quantity')
		);
		$this->session->set_flashdata('search',$query_array);
		redirect('admin/index/');
	}
	
	function update_form($barcode){
		$this->load->model('inventory_CRUD');
		$temp = $this->inventory_CRUD->get_item($barcode);
		$data['item'] = $temp[0];
		$data['title'] = 'Admin';
		$data['main_content'] = 'update_item';
		$this->load->view('includes/template', $data);
	}
	
	function update(){
		
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
			$this->inventory_CRUD->insert_csv();
			redirect('admin');
		}
	}

}
/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
