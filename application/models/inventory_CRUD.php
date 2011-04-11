<?php
class Inventory_CRUD extends CI_model{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function inventory_count(){
		return $this->db->count_all('Inventory');
	}
	
	function get_inventory($limit,$offset = 0){
		$this->db->order_by('name','asc');
		return $this->db->select('image,name,brand,category,price,quantity,description')->get('inventory',$limit,$offset);
	}
	
	function get_item($barcode){
		return $this->db->where('barcode', $barcode)->from('Inventory')->get()->result_array();
	}
	
	function get_brand_options(){
		$this->db->order_by('brand','asc');
		$rows = $this->db->get('brands')->result();
		$brand_array= array('' => '');
		foreach($rows as $row){
			$brand_array[$row->brand] = $row->brand;
		}
		return $brand_array;
	}
	
	function get_category_options(){
		$this->db->order_by('category','asc');
		$rows= $this->db->get('categories')->result();
		$category_array = array('' => '');
		foreach($rows as $row){
			$category_array[$row->category] = $row->category;
		}
		return $category_array;		
	}
	
	function search($limit, $offset, $sort_by, $sort_order){
		$query_array = $this->session->flashdata('search');
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('name','brand','category','price','quantity','description');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'name';
		// results query
		$q = $this->db->select('barcode,image,name,brand,category,price,quantity,description')
			->from('inventory')
			->limit($limit, $offset)
			->order_by($sort_by, $sort_order);

		if (strlen($query_array['name'])) {
			$q->like('name', $query_array['name']);
		}
		if (strlen(($query_array['category']))) {
			$q->like('category', $query_array['category']);
		}
		if (strlen($query_array['brand'])) {
			$q->like('brand', $query_array['brand']);
		}
		if (strlen($query_array['price'])) {
			$operators = array('gt' => '>', 'gte' => '>=', 'eq' => '=', 'lte' => '<=', 'lt' => '<');
			$operator = $operators[$query_array['price_comparison']];
						
			$q->where("price $operator", $query_array['price']);
		}
		if (strlen($query_array['quantity'])){
			$operators = array('gt' => '>', 'gte' => '>=', 'eq' => '=', 'lte' => '<=', 'lt' => '<');
			$operator = $operators[$query_array['quantity_comparison']];
						
			$q->where("quantity $operator", $query_array['quantity']);
		}

		$ret['rows'] = $q->get()->result();
		
		// count query
		$q = $this->db->select('COUNT(*) as count', FALSE)
			->from('inventory');

		if (strlen($query_array['name'])) {
			$q->like('name', $query_array['name']);
		}
		if (strlen($query_array['category'])) {
			$q->like('category', $query_array['category']);
		}
		if (strlen($query_array['brand'])) {
			$q->like('brand', $query_array['brand']);
		}
		if (strlen($query_array['price'])) {
			$operators = array('gt' => '>', 'gte' => '>=', 'eq' => '=', 'lte' => '<=', 'lt' => '<');
			$operator = $operators[$query_array['price_comparison']];
						
			$q->where("price $operator", $query_array['price']);
		}
		if (strlen($query_array['quantity'])) {
			$operators = array('gt' => '>', 'gte' => '>=', 'eq' => '=', 'lte' => '<=', 'lt' => '<');
			$operator = $operators[$query_array['quantity_comparison']];
						
			$q->where("quantity $operator", $query_array['quantity']);
		}

		$tmp = $q->get()->result();
		
		$ret['num_rows'] = $tmp[0]->count;
		return $ret;
		
	}
	
	function insert_csv(){
		
		$handle = fopen('csv/inventory.csv','r');
		$current_id = 1;
			while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {

				if($this->db->get_where('brands',array('brand' =>$data[3]))->num_rows()== 0){
					$this->db->set('brand',$data[3]);
					$this->db->insert('brands');
				}
				if($this->db->get_where('categories',array('category' =>$data[4]))->num_rows()== 0){
					$this->db->set('category',$data[4]);
					$this->db->insert('categories');
				}			
    			$entry = array(
    					'name' => $data[0]->trim,    
    					'quantity' =>(int)$data[1],
						'price' => (double)$data[2],
						'brand' => $data[3]->trim,
						'category' => $data[4]->trim,
						'image' => 'images/'.$data[0].'.jpg',
						'i_size' => $data[5]->trim,
						'i_colour' => $data[6]->trim,
						'description' => gzcompress($data[7]->trim)
						);	
				$this->db->insert('inventory',$entry);
                $this->generate_barcode($data[0],$current_id);
                $current_id++;
				$feed_data = array(
									'title' => $data[0],
									'description' => gzcompress($data[7]->trim)			
							);
				$this->db->insert('rss',$feed_data);	
			}			
	}
		
	function generate_barcode($name,$id){
		return passthru('support\barcode.bat '.'"'.$name.'"'.' "'.$id.'"');
	}
	
	
}
