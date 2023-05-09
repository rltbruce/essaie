<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tranche_demande_latrine_pr_model extends CI_Model {
    protected $table = 'tranche_demande_latrine_pr';

    public function add($tranche_demande_latrine_pr) {
        $this->db->set($this->_set($tranche_demande_latrine_pr))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $tranche_demande_latrine_pr) {
        $this->db->set($this->_set($tranche_demande_latrine_pr))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($tranche_demande_latrine_pr) {
        return array(
            'code'      =>  $tranche_demande_latrine_pr['code'],
            'libelle'      =>  $tranche_demande_latrine_pr['libelle'],
            'periode'      =>  $tranche_demande_latrine_pr['periode'],
            'pourcentage'  =>  $tranche_demande_latrine_pr['pourcentage'],
            'description'  =>  $tranche_demande_latrine_pr['description']                       
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
