<?php

class Membership_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}

	function validate()
	{
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', $this->myHash($this->input->post('password')));
		$query = $this->db->get('UsersLog');
		if($query->num_rows == 1)
		{
            $query = $this->db->get('UsersInfo')->where('username',$this->input->post('username'))
			$data = $query->result_array();
			return array(
							'is_user' => true,
							'is_admin' => $data[0]['is_admin']
							);
		}
		
	}
	
	function create_member()
	{
		
		$Usersinfo_new_member_insert_data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email' => $this->input->post('email_address'),
			'username' => $this->input->post('username'),
			'password' => $this->myHash($this->input->post('password'))	,
            'is_admin' => 0
		);
        
        $UsersLog_new_member_insert_data['username'] = $Usersinfo_new_member_insert_data['username'];
        $UsersLog_new_member_insert_data['password'] = $Usersinfo_new_member_insert_data['password'];		
		return ($this->db->insert('UsersInfo', $new_member_insert_data) and $this->db->insert('UsersLog',$UsersLog_new_member_insert_data));
		
	}
	
	function myHash($toHash)
	{
		$password = str_split($toHash,(strlen($toHash)/2)+1);
		return hash('sha1', $this->input->post('username').$password[0].'Alashfdas'.$password[1]);  
	}
}