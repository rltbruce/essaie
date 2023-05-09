<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transfert_ufp_model extends CI_Model {
    protected $table = 'transfert_ufp';

    public function add($transfert_ufp) {
        $this->db->set($this->_set($transfert_ufp))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $transfert_ufp) {
        $this->db->set($this->_set($transfert_ufp))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($transfert_ufp) {
        return array(
            'montant_transfert'       =>      $transfert_ufp['montant_transfert'],
            'frais_bancaire'       =>      $transfert_ufp['frais_bancaire'],
            'montant_total'   =>      $transfert_ufp['montant_total'],
            'date'       =>      $transfert_ufp['date'],
            'observation'       =>      $transfert_ufp['observation'],
            'id_demande_deblocage_daaf'    => $transfert_ufp['id_demande_deblocage_daaf'],
            'validation'    => $transfert_ufp['validation']                       
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

    public function gettransfertvalidebyid_demande($id_demande_deblocage_daaf) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_deblocage_daaf", $id_demande_deblocage_daaf)
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

    public function findBydemande_deblocage_daaf($id_demande_deblocage_daaf) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_deblocage_daaf", $id_demande_deblocage_daaf)
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
    public function gettransfert_ufpvalideById($id_transfert_ufp) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_transfert_ufp)
                        ->where("validation", 1)
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
