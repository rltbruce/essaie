<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Decaiss_fonct_feffi_model extends CI_Model {
    protected $table = 'decaiss_fonct_feffi';

    public function add($decaiss_fonct_feffi) {
        $this->db->set($this->_set($decaiss_fonct_feffi))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $decaiss_fonct_feffi) {
        $this->db->set($this->_set($decaiss_fonct_feffi))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($decaiss_fonct_feffi) {
        return array(
            'montant'       =>      $decaiss_fonct_feffi['montant'],
            //'cumul'       =>      $decaiss_fonct_feffi['cumul'],
            //'pourcentage_paiement'   =>      $decaiss_fonct_feffi['pourcentage_paiement'],
            'date_decaissement'       =>      $decaiss_fonct_feffi['date_decaissement'],
            'observation'       =>      $decaiss_fonct_feffi['observation'],
            'id_convention_entete'    => $decaiss_fonct_feffi['id_convention_entete'],
            'validation'    => $decaiss_fonct_feffi['validation']                       
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

    public function findinvalideBycisco($id_cisco) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=decaiss_fonct_feffi.id_convention_entete')
                        ->where("id_cisco", $id_cisco)
                        ->where("decaiss_fonct_feffi.validation", 0)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function getddecaiss_fonct_feffiById($id_decaiss_fonct_feffi) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_decaiss_fonct_feffi)
                        ->where("validation", 1)
                        //->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findinvalideByconvention($id_convention_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
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

    public function findvalideByconvention($id_convention_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
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
    public function findallByconvention($id_convention_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
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
    public function countdecaissByconvention($id_convention_entete) {           //mande    
        $result =  $this->db->select('count(decaiss_fonct_feffi.id) as nbr_decaiss')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)                        
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
