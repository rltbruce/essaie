<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rapport_pmc_model extends CI_Model {
    protected $table = 'rapport_pmc';

    public function add($rapport_pmc) {
        $this->db->set($this->_set($rapport_pmc))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $rapport_pmc) {
        $this->db->set($this->_set($rapport_pmc))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($rapport_pmc) {
        return array(
            'intitule'   =>      $rapport_pmc['intitule'],
            'fichier'   =>      $rapport_pmc['fichier'],
            'id_module_pmc'    =>  $rapport_pmc['id_module_pmc']                       
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
                        ->order_by('intitule')
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

    public function findAllBymodule($id_module_pmc) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_module_pmc", $id_module_pmc)
                        ->order_by('intitule')
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
