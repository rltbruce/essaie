<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paiement_mobilier_pr_model extends CI_Model {
    protected $table = 'paiement_mobilier_pr';

    public function add($paiement_mobilier_pr) {
        $this->db->set($this->_set($paiement_mobilier_pr))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $paiement_mobilier_pr) {
        $this->db->set($this->_set($paiement_mobilier_pr))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($paiement_mobilier_pr) {
        return array(
            'montant_paiement'       =>      $paiement_mobilier_pr['montant_paiement'],
            //'cumul'       =>      $paiement_mobilier_pr['cumul'],
            //'pourcentage_paiement'   =>      $paiement_mobilier_pr['pourcentage_paiement'],
            'date_paiement'       =>      $paiement_mobilier_pr['date_paiement'],
            'observation'       =>      $paiement_mobilier_pr['observation'],
            'id_demande_mobilier_pr'    => $paiement_mobilier_pr['id_demande_mobilier_pr']                       
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

    public function findBydemande_mobilier_pr($id_demande_mobilier_pr) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_mobilier_pr", $id_demande_mobilier_pr)
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
