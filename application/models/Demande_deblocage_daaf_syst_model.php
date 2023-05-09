<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_deblocage_daaf_syst_model extends CI_Model {
    protected $table = 'demande_deblocage_daaf_syst';

    public function add($demande_deblocage_daaf_syst) {
        $this->db->set($this->_set($demande_deblocage_daaf_syst))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_deblocage_daaf_syst) {
        $this->db->set($this->_set($demande_deblocage_daaf_syst))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($demande_deblocage_daaf_syst) {
        return array(
            'objet'        =>$demande_deblocage_daaf_syst['objet'],
            'ref_demande'  =>$demande_deblocage_daaf_syst['ref_demande'],            
            'id_tranche_deblocage_daaf' =>$demande_deblocage_daaf_syst['id_tranche_deblocage_daaf']                                  
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
       // $this->db->reconnect();             
        $result =  $this->db
                            ->select('*')
                        ->from($this->table)
                        ->order_by('id')
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
