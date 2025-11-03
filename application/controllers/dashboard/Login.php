<?php
defined('BASEPATH') OR exit('Ação não permitida :(');

// Controlador 'Login' da área restrita

class Login extends CI_Controller {

	public function index(){
		redirect('home');
	}

	public function autenticar(){
		$this->load->library('session');
		$data = array(
			'titulo' => 'Login',
			'resposta' => '',
			'erro' => 0
        );

        $email    = to_dbase($this->input->post('email'));
        $password = to_dbase($this->input->post('password'));

	    $dadosLogin = $this->user_model->user_auth($email, $password);

	    if($dadosLogin['id'] > 0){
	    	// senha ok, vomos prepara a sessão
	        $this->session->set_userdata('logado', true);
	        $this->session->set_userdata('user_id', $dadosLogin['id']);
	        $this->session->set_userdata('user_name', $dadosLogin['name']);
	        $this->session->set_userdata('user_email', $this->input->post('email'));
	        redirect('dashboard/home','refresh');
	    }
        else{
        	$this->session->set_flashdata('error', 'Usuário ou senha inválido');
        	redirect('home');
        }	

	}

	public function logout(){		
		$this->user_model->user_logout();	 
		redirect('home');    
	}

	public function debug($value=null){		
		echo "<pre>";
		print_r($value);
		echo "</pre>";
	}	
	

}


