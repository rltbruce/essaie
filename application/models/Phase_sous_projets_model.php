<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Phase_sous_projets_model extends CI_Model {
    protected $table = 'phase_sous_projets';

    public function add($phase_sous_projets) {
        $this->db->set($this->_set($phase_sous_projets))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $phase_sous_projets) {
        $this->db->set($this->_set($phase_sous_projets))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($phase_sous_projets) {
        return array(
            'libelle'       =>      $phase_sous_projets['libelle'],
            'description'   =>      $phase_sous_projets['description'],
            'code'   =>      $phase_sous_projets['code']                       
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
