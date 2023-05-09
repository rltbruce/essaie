<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fonction_feffi_model extends CI_Model {
    protected $table = 'fonction_feffi';

    public function add($fonction_feffi) {
        $this->db->set($this->_set($fonction_feffi))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $fonction_feffi) {
        $this->db->set($this->_set($fonction_feffi))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fonction_feffi) {
        return array(
            'libelle'            =>      $fonction_feffi['libelle'],
            'description'            =>      $fonction_feffi['description'],
            'id_organe_feffi'    =>      $fonction_feffi['id_organe_feffi']                       
        );
    }
    public function delete($id) {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('libelle')
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
    public function findByIdTable($id) {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findByorgane_feffi($id_organe_feffi) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_organe_feffi',$id_organe_feffi)
                        ->order_by('libelle')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function getfonction_feffitest($organe_feffi,$fonction_feffi) {               
        $result =  $this->db->select('fonction_feffi.*')
                        ->from($this->table)
                        ->join('organe_feffi','organe_feffi.id=fonction_feffi.id_organe_feffi')
                        ->where('lower(organe_feffi.libelle)=',$organe_feffi)
                        ->where('lower(fonction_feffi.libelle)=',$fonction_feffi)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }	
    
}
