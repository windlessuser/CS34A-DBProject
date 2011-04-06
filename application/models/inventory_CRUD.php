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
	
	function insert_csv(){
		
		$handle = fopen('csv/inventory.csv','r');
			while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
    			
				if($this->db->get_where('brands',array('brand' =>$data[3]))->num_rows() < 1){
					$this->db-insert('brands', $data[3]);
				}
				if($this->db->get_where('categories',array('category' =>$data[4]))->num_rows() < 1){
					$this->db-insert('categories', $data[4]);
				}			
    			$entry = array(
    					'name' => $data[0],    
    					'quantity' =>$data[1],
						'price' =>$data[2],
						'brand' => $data[3],
						'category' => $data[4],
						'image' => 'images/'.$data[0].'jpg',
						'i_size' => $data[5],
						'i_colour' => $data[6],
						'description' => $data[7]
						);	
				$this->db->insert('inventory',$entry);
                $this->generate_barcode($data[0]);
				$feed_data = array(
									'title' => $data[0],
									'description' => $data[8]			
							);
				$this->db->insert('rss',$feed_data);	
			}			
	}
		
	function generate_barcode($name){
		return passthru('support\barcode.bat '.'"'.$name.'"');
	}
	
	
}
