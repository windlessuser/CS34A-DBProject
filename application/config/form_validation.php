<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	$config = array(
               array(
                     'field'   => 'first_name', 
                     'label'   => 'Name', 
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'last_name', 
                     'label'   => 'Last Name', 
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'email_address', 
                     'label'   => 'Email Address', 
                     'rules'   => 'trim|required|valid_email'
                  ),   
               array(
                     'field'   => 'username', 
                     'label'   => 'Username', 
                     'rules'   => 'trim|required|min_length[4]'
                  ),
			   array(
                     'field'   => 'password', 
                     'label'   => 'Password', 
                     'rules'   => 'trim|required|min_length[4]|max_length[32]'
                  ),
               array(
                     'field'   => 'password2', 
                     'label'   => 'Password Confirmation', 
                     'rules'   => 'trim|required|min_length[4]|max_length[32]'
                  ),
            );
	

