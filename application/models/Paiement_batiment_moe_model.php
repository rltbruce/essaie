<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paiement_batiment_moe_model extends CI_Model {
    protected $table = 'paiement_batiment_moe';

    public function add($paiement_batiment_moe) {
        $this->db->set($this->_set($paiement_batiment_moe))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $paiement_batiment_moe) {
        $this->db->set($this->_set($paiement_batiment_moe))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($paiement_batiment_moe) {
        return array(
            'montant_paiement'       =>      $paiement_batiment_moe['montant_paiement'],
            'validation'       =>      $paiement_batiment_moe['validation'],
            //'pourcentage_paiement'   =>      $paiement_batiment_moe['pourcentage_paiement'],
            'date_paiement'       =>      $paiement_batiment_moe['date_paiement'],
            'observation'       =>      $paiement_batiment_moe['observation'],
            'id_demande_batiment_moe'    => $paiement_batiment_moe['id_demande_batiment_moe']                       
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

    public function findpaiementBydemande($id_demande_batiment_moe) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_batiment_moe", $id_demande_batiment_moe)
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
    public function findpaiementvalideBydemande($id_demande_batiment_moe) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_batiment_moe", $id_demande_batiment_moe)
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
    public function findpaiementinvalideBydemande($id_demande_batiment_moe) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_batiment_moe", $id_demande_batiment_moe)
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
