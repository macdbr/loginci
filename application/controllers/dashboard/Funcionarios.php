<?php
defined('BASEPATH') OR exit('Ação não permitida :(');

// Controlador 'Home' da área restrita

class Funcionarios extends CI_Controller {

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
			'titulo' => 'Funcionários(as) cadastrados(as)',
			'styles' => array(
				'assets/datatables/datatables.min.css',
				'assets/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css',
			),
			'scripts' => array(
				'assets/datatables/datatables.min.js',
				'assets/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js',
				'assets/jquery-ui/jquery-ui.min.js',
				'js/datatables.js',
			),
			'funcionarios' => $this->funcionarios_model->get_all()
		);		

		$this->load->view('dashboard/layout/header', $data);  
		$this->load->view('dashboard/funcionarios/index', $data);
	}

    public function cadastro() {
        $data = array(
            'titulo' => 'Cadastrar Funcionário(a)',
            'mensagem' => ''            
        );    

        
        $this->load->view('dashboard/layout/header', $data); 
        $this->load->view('dashboard/funcionarios/cadastro', $data);
    }

    public function cadastro_submit() {
        $response = [];
        $response['csrf_token'] = $this->security->get_csrf_hash(); // Retorna novo token CSRF

        // Validar formulário -----------------------------------------------------------
        $this->form_validation->set_rules('name', 'Nome', 'trim|required|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]|valid_email');
        $this->form_validation->set_rules('position', 'Cargo', 'trim|required|min_length[2]|max_length[50]');        
        $this->form_validation->set_rules('salary', 'Salário', 'trim|required');
        $this->form_validation->set_rules('admission_date', 'Data admissão', 'trim|required');

        if ($this->form_validation->run() == FALSE) { 
            // Erro na validação do formulário
            $response = array(
                'status' => 'error',
                'mensagem' => 'Erro de validação',
                'csrf_token' => $this->security->get_csrf_hash(),
                'errors' => array(
                    'name' => form_error('name'),
                    'email' => form_error('email'),
                    'position' => form_error('position'),
                    'salary' => form_error('salary'),
                    'admission_date' => form_error('admission_date')
                )
            );    

        }else{
            // Validação OK
            // Recebe os dados via POST
            $dados_form = $this->input->post();

            $salary = str_replace(".", "", $dados_form['salary']);
            $salary = str_replace(",", ".", $salary);

            $dados_insert['name'] = to_dbase($dados_form['name']); // Converter para salvar
            $dados_insert['email'] = to_dbase($dados_form['email']); 
            $dados_insert['position'] = to_dbase($dados_form['position']);
            $dados_insert['salary'] = to_dbase($salary); 
            $dados_insert['admission_date'] = to_dbase($dados_form['admission_date']);   
  
            // Salvar no banco de dados
            $id = $this->funcionarios_model->create($dados_insert);
            if($id > 0){
                $response['status'] = 'sucesso';
                $response['mensagem'] = 'Funcionário(a) cadastrado(a) com sucesso!';

            }else{
                $response['status'] = 'error';
                $response['mensagem'] = 'Erro ao cadastrar o(a) funcionário(a).';
            }
                                  
        }          

        // Retorna resposta JSON
        echo json_encode($response);        
    }

    public function editar($funcionario_id=null) {
        $data = array(
            'titulo' => 'Editar Funcionário(a)',
            'mensagem' => '',
            'funcionario_id' => 0,
            'funcionario' => null            
        ); 

        if($funcionario = $this->funcionarios_model->read(array('id' => intval($funcionario_id)))){
            $data['funcionario_id'] = $funcionario_id;
            $data['funcionario'] = $funcionario; 
            
        }else{
            $data['mensagem'] = "O(A) Funcionário(a) não foi encontrado(a)."; 
        }
        
        $this->load->view('dashboard/layout/header', $data);   
        $this->load->view('dashboard/funcionarios/editar', $data); 
    }

    public function editar_submit() {
        $response = [];
        $response['csrf_token'] = $this->security->get_csrf_hash();  // Retorna novo token CSRF

        // Validar formulário -----------------------------------------------------------
        $this->form_validation->set_rules('name', 'Nome', 'trim|required|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]|valid_email');
        $this->form_validation->set_rules('position', 'Cargo', 'trim|required|min_length[2]|max_length[50]');        
        $this->form_validation->set_rules('salary', 'Salário', 'trim|required');
        $this->form_validation->set_rules('admission_date', 'Data admissão', 'trim|required');

        if ($this->form_validation->run() == FALSE) { 
            // Erro na validação do formulário
            $response = array(
                'status' => 'error',
                'mensagem' => 'Erro de validação',
                'csrf_token' => $this->security->get_csrf_hash(),
                'errors' => array(
                    'name' => form_error('name'),
                    'email' => form_error('email'),
                    'position' => form_error('position'),
                    'salary' => form_error('salary'),
                    'admission_date' => form_error('admission_date')
                )
            );   
        }else{
            // Validação OK
            // Recebe os dados via POST
            $dados_form = $this->input->post();
            $funcionario_id = $dados_form['id'];

            /* Importante: Validar a ID do funcionário e verificar permissões.            
            * A id do funcionário veio de um campo hidden do formulário e por questão de segurança
            * temos que garantir que essa id é de um funcionário que existe.
            * Uma melhoria para o teste ou caso fosse um sistema maior, seria garantir que o usuário 
            * logado possui permissão para editar funcionários */

            // verificar se funcionário existe
            $funcionario = $this->funcionarios_model->read(array('id' => $funcionario_id));
            if (!$funcionario) {                
                $response['status'] = 'error';
                $response['mensagem'] = 'Acesso não permitido. O(A) funcionário(a) não foi encontrado(a).';               
            }else{
                //ele existe
                $salary = str_replace(".", "", $dados_form['salary']);
                $salary = str_replace(",", ".", $salary);
                
                $dados_update['name'] = to_dbase($dados_form['name']); // Converter para salvar
                $dados_update['email'] = to_dbase($dados_form['email']); 
                $dados_update['position'] = to_dbase($dados_form['position']);
                $dados_update['salary'] = to_dbase($salary); 
      
                // Salvar no banco de dados
                if($this->funcionarios_model->update($dados_update, array('id' => $funcionario_id))){
                    $response['status'] = 'sucesso';
                    $response['mensagem'] = 'Funcionário(a) editado(a) com sucesso!';
                }else{
                    $response['status'] = 'error';
                    $response['mensagem'] = 'Erro ao editar o(a) funcionário(a).';
                }             
            }                    
        }          

        // Retorna resposta JSON
        echo json_encode($response);        
    }	

    public function excluir() {
        if ($this->input->method() === 'post') {
            // Recebe os dados via POST
            $funcionario_id = intval($this->input->post('id'));


          /* Importante: Validar a ID do funcionário e verificar permissões.            
          * A id do funcionário veio do e por questão de segurança
          * temos que garantir que essa id é de um funcionário que existe.
          * Uma melhoria para o teste ou caso fosse um sistema maior, seria garantir que o usuário 
          * logado possui permissão para excluir funcionários */
          
            // faz a exclusão do funcionário no model
            $this->funcionarios_model->delete(array('id' => $funcionario_id));

            // Retorna JSON com novo hash CSRF
            $response = [
                'status' => 'ok',
                'csrf_hash' => $this->security->get_csrf_hash()
            ];
            echo json_encode($response);
        }

    }

	public function debug($value=null){		
		echo "<pre>";
		print_r($value);
		echo "</pre>";
		exit();
	}	

}