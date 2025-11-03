<?php
defined('BASEPATH') OR exit('Ação não permitida :(');

class Funcionarios_model extends CI_Model {

    public function create( $data = null) {
        $id=0;
        if (is_array($data)) {            
            $this->db->insert('employees', $data);
            $id = $this->db->insert_id();          
        }
        return $id;
    }

    public function update($data = null, $condicoes = null) {
        if (is_array($data) && is_array($condicoes)) {
            if ($this->db->update('employees', $data, $condicoes)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function delete($condicoes = null) {
        if (is_array($condicoes)) {
            if ($this->db->delete('employees', $condicoes)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function get_all() {   
        $this->db->select([
            'employees.id',
            'employees.name',
            'employees.email',
            'employees.position',
            'employees.salary',
            'employees.admission_date'            
        ]);

        $this->db->order_by('id','asc');

        return $this->db->get('employees')->result();
    }

    public function read( $condicoes = null) {
        // Recebe como parâmetro um array de condições: array('id' => $funcionario_id)
        if (is_array($condicoes)) {
            $this->db->where($condicoes);
            $this->db->limit(1);
            return $this->db->get('employees')->row();
        } else {
            return false;
        }
    }
}
