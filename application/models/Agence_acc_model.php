<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agence_acc_model extends CI_Model {
    protected $table = 'agence_acc';

    public function add($agence_acc) {
        $this->db->set($this->_set($agence_acc))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $agence_acc) {
        $this->db->set($this->_set($agence_acc))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($agence_acc) {
        return array(
            'telephone'  => $agence_acc['telephone'],
            'nom'   => $agence_acc['nom'],
            'siege' => $agence_acc['siege']                       
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
                        ->order_by('nom')
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
    
    public function getagencetest($agence) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('lower(nom)=',$agence)
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
