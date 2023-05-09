<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paiement_latrine_moe_model extends CI_Model {
    protected $table = 'paiement_latrine_moe';

    public function add($paiement_latrine_moe) {
        $this->db->set($this->_set($paiement_latrine_moe))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $paiement_latrine_moe) {
        $this->db->set($this->_set($paiement_latrine_moe))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($paiement_latrine_moe) {
        return array(
            'montant_paiement'       =>      $paiement_latrine_moe['montant_paiement'],
            'date_paiement'       =>      $paiement_latrine_moe['date_paiement'],
            'observation'       =>      $paiement_latrine_moe['observation'],
            'validation'       =>      $paiement_latrine_moe['validation'],
            'id_demande_latrine_moe'    => $paiement_latrine_moe['id_demande_latrine_moe']                       
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

       public function findpaiementBydemande($id_demande_latrine_moe) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_latrine_moe", $id_demande_latrine_moe)
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
    public function findpaiementvalideBydemande($id_demande_latrine_moe) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_latrine_moe", $id_demande_latrine_moe)
                        ->where("validation", 1)
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
    public function findpaiementinvalideBydemande($id_demande_latrine_moe) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_latrine_moe", $id_demande_latrine_moe)
                        ->where("validation", 0)
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
}
