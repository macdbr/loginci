<?php
defined('BASEPATH') OR exit('Ação não permitida :(');

class Home extends CI_Controller {

	function __construct(){
    	parent::__construct();   	

    	$this->load->library('session');

  	}
	
	public function index(){
		$data = array(
			'titulo' => 'LOGINCI',
			'error' =>  $this->session->flashdata('error')
        );

		$this->load->view('home',$data);
	}


	public function teste()
	{
		$this->load->view('teste');
	}
}
