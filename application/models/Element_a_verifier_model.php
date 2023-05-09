<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Element_a_verifier_model extends CI_Model {
    protected $table = 'element_a_verifier';

    public function add($element_a_verifier) {
        $this->db->set($this->_set($element_a_verifier))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $element_a_verifier) {
        $this->db->set($this->_set($element_a_verifier))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($element_a_verifier) {
        return array(
            'element_verifier'       =>      $element_a_verifier['element_verifier'],
            'description'   =>      $element_a_verifier['description'],
            'id_designation_infrastructure'    => $element_a_verifier['id_designation_infrastructure']                       
        );
    }
    public function delete($id) {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('description')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findById($id)  {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

    public function findBydesignation_infrastructure($id_designation_infrastructure) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_designation_infrastructure", $id_designation_infrastructure)
                        ->order_by('description')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
}
