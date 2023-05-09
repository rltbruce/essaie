<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rubrique_addition_fonct_feffi_model extends CI_Model {
    protected $table = 'rubrique_addition_fonct_feffi';

    public function add($rubrique_addition_fonct_feffi) {
        $this->db->set($this->_set($rubrique_addition_fonct_feffi))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $rubrique_addition_fonct_feffi) {
        $this->db->set($this->_set($rubrique_addition_fonct_feffi))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($rubrique_addition_fonct_feffi) {
        return array(
            'libelle'       =>      $rubrique_addition_fonct_feffi['libelle'],
            'description'   =>      $rubrique_addition_fonct_feffi['description']                       
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

}
