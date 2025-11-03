<?php
defined('BASEPATH') OR exit('Ação não permitida :(');

// Controlador 'Home' da área restrita

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->load->library('session');

		// verificar se existe sessão
        if (!$this->session->userdata('logado')) {
            redirect('home');
        }

	}
	
	public function index(){
		$data = array(
            'titulo' => 'Dashboard',
            'mensagem' => ''            
        ); 
		$this->load->view('dashboard/layout/header', $data);  
		$this->load->view('dashboard/home/index', $data);
	}

}
