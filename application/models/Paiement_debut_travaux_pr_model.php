<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paiement_debut_travaux_pr_model extends CI_Model {
    protected $table = 'paiement_debut_travaux_pr';

    public function add($paiement_debut_travaux_pr) {
        $this->db->set($this->_set($paiement_debut_travaux_pr))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $paiement_debut_travaux_pr) {
        $this->db->set($this->_set($paiement_debut_travaux_pr))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($paiement_debut_travaux_pr) {
        return array(
            'montant_paiement'       =>      $paiement_debut_travaux_pr['montant_paiement'],
            'date_paiement'       =>      $paiement_debut_travaux_pr['date_paiement'],
            'observation'       =>      $paiement_debut_travaux_pr['observation'],
            'id_demande_debut_travaux'    => $paiement_debut_travaux_pr['id_demande_debut_travaux']                       
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

    public function findBydemande_debut_travaux_pr($id_demande_debut_travaux) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_debut_travaux", $id_demande_debut_travaux)
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
