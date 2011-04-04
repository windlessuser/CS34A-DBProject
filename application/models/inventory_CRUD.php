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
		return $this->db->select('image','name','brand','category','price','quantity','description')->get('inventory',$limit,$offset);
	}
	
	
}
