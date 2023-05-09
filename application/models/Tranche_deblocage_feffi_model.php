<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tranche_deblocage_feffi_model extends CI_Model {
    protected $table = 'tranche_deblocage_feffi';

    public function add($tranche_deblocage_feffi) {
        $this->db->set($this->_set($tranche_deblocage_feffi))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $tranche_deblocage_feffi) {
        $this->db->set($this->_set($tranche_deblocage_feffi))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($tranche_deblocage_feffi) {
        return array(
            'code'      =>  $tranche_deblocage_feffi['code'],
            'libelle'      =>  $tranche_deblocage_feffi['libelle'],
            'periode'      =>  $tranche_deblocage_feffi['periode'],
            'pourcentage'  =>  $tranche_deblocage_feffi['pourcentage'],
            'description'  =>  $tranche_deblocage_feffi['description']                       
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
                        ->order_by('code')
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
