<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taxe_marche_public_model extends CI_Model {
    protected $table = 'taxe_marche_public';

    public function add($taxe_marche_public) {
        $this->db->set($this->_set($taxe_marche_public))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $taxe_marche_public) {
        $this->db->set($this->_set($taxe_marche_public))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($taxe_marche_public) {
        return array(
            'pourcentage'       =>      $taxe_marche_public['pourcentage'],
            'description'   =>      $taxe_marche_public['description']                       
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
