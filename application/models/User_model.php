<?php
defined('BASEPATH') OR exit('Ação não permitida :(');

class User_model extends CI_Model {

  public function get_all() {
    $this->db->select([
      'users.id',
      'users.name',
      'users.email'
    ]);      
    return $this->db->get('users')->result();
  }

  public function user_existe($email = '') {
    $this->db->select([
      'users.email'
    ]);
    $this->db->where('users.email', $email);
    return $this->db->get('users')->row();
  }

  public function get_user_email($email = '') {
    $this->db->select([
      'users.id',
      'users.name',
      'users.email'
    ]);
    $this->db->where('users.email', $email);
    return $this->db->get('users')->row();
  }

  public function user_auth($email = '', $senha = '') {
    $data = array('name' => '', 'id' => 0,'msg' => 'Usuário não encontrado.');

    $query = $this->db->get_where('users', ['email' => $email]); 

    if ($query->num_rows() === 1) {
      $user = $query->row();
      if (password_verify($senha, $user->password)){
        $data['id'] = $user->id;
        $data['name'] = $user->name; 
      }
    }

    return $data;
  }

  public function user_logout(){
    $this->load->library('session');
    $this->session->sess_destroy();
    return true;
  }

}
