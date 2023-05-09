<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paiement_latrine_pr_model extends CI_Model {
    protected $table = 'paiement_latrine_pr';

    public function add($paiement_latrine_pr) {
        $this->db->set($this->_set($paiement_latrine_pr))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $paiement_latrine_pr) {
        $this->db->set($this->_set($paiement_latrine_pr))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($paiement_latrine_pr) {
        return array(
            'montant_paiement'       =>      $paiement_latrine_pr['montant_paiement'],
            'date_paiement'       =>      $paiement_latrine_pr['date_paiement'],
            'observation'       =>      $paiement_latrine_pr['observation'],
            'id_demande_latrine_pr'    => $paiement_latrine_pr['id_demande_latrine_pr']                       
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

    public function findBydemande_latrine_pr($id_demande_latrine_pr) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_latrine_pr", $id_demande_latrine_pr)
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
