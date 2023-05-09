<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rubrique_phase_sous_projet_model extends CI_Model {
    protected $table = 'rubrique_phase_sous_projet';

    public function add($rubrique_phase_sous_projet) {
        $this->db->set($this->_set($rubrique_phase_sous_projet))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $rubrique_phase_sous_projet) {
        $this->db->set($this->_set($rubrique_phase_sous_projet))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($rubrique_phase_sous_projet) {
        return array(
            'designation'       =>      $rubrique_phase_sous_projet['designation'],
            'element_verifier'   =>      $rubrique_phase_sous_projet['element_verifier'],
            'id_phase_sous_projet'   =>      $rubrique_phase_sous_projet['id_phase_sous_projet']                       
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
                        ->order_by('element_verifier')
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
