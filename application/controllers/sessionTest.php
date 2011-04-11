<?php
include('Controller.php');

class SessionTest extends Controller{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index(){
		if($this->session->flashdata('test')){
			echo 'value of test: ' . $this->session->flashdata('test');
		}
		else{
			echo 'There is nothing in test.';
		}

	}
	
	function setSession($text){
		if($this->session->set_flashdata('test',$text)){
			echo 'Session set';
		}
		else{
			echo 'unable to set Session';
		}

	}
}
