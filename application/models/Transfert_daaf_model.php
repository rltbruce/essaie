<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transfert_daaf_model extends CI_Model {
    protected $table = 'transfert_daaf';

    public function add($transfert_daaf) {
        $this->db->set($this->_set($transfert_daaf))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $transfert_daaf) {
        $this->db->set($this->_set($transfert_daaf))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($transfert_daaf) {
        return array(
            'montant_transfert'       =>      $transfert_daaf['montant_transfert'],
            'frais_bancaire'       =>      $transfert_daaf['frais_bancaire'],
            'montant_total'   =>      $transfert_daaf['montant_total'],
            'date'       =>      $transfert_daaf['date'],
            'observation'       =>      $transfert_daaf['observation'],
            'validation'       =>      $transfert_daaf['validation'],
            'id_demande_rea_feffi'    =>  $transfert_daaf['id_demande_rea_feffi']                       
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
                        ->order_by('date')
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

    public function findAllByprogramme($id_demande_rea_feffi) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_rea_feffi", $id_demande_rea_feffi)
                        ->order_by('date')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findtransfertBydemande($id_demande_rea_feffi) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_rea_feffi", $id_demande_rea_feffi)
                        ->order_by('date')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findinvalideBydemande($id_demande_rea_feffi) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_rea_feffi", $id_demande_rea_feffi)
                        ->where("validation",0)
                        ->order_by('date')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findvalideBydemande($id_demande_rea_feffi) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_rea_feffi", $id_demande_rea_feffi)
                        ->where("validation",1)
                        ->order_by('date')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function gettransfert_daafvalideById($id_transfert_daaf) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_transfert_daaf)
                        ->where("validation",1)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function getpaiementByconvention($id_convention_entete)
    {               
        $result =  $this->db->select('demande_realimentation_feffi.date_approbation as date_approbation,tranche_deblocage_feffi.code as code,tranche_deblocage_feffi.pourcentage as pourcentage,transfert_daaf.montant_transfert as montant_transfert')
                        ->from($this->table)
                        ->join('demande_realimentation_feffi','demande_realimentation_feffi.id=transfert_daaf.id_demande_rea_feffi')
                        ->join('convention_cisco_feffi_entete','demande_realimentation_feffi.id_convention_cife_entete=convention_cisco_feffi_entete.id')
                        ->join('tranche_deblocage_feffi','tranche_deblocage_feffi.id=demande_realimentation_feffi.id_tranche_deblocage_feffi')
                        ->where("convention_cisco_feffi_entete.id",$id_convention_entete )
                        ->where("demande_realimentation_feffi.validation",3 )
                       //->order_by('code')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function gettransfertByconvention($id_convention_entete)
    {               
        $result =  $this->db->select('sum(transfert_daaf.montant_transfert) as montant_transfert')
                        ->from($this->table)
                        ->join('demande_realimentation_feffi','demande_realimentation_feffi.id=transfert_daaf.id_demande_rea_feffi')
                        ->join('convention_cisco_feffi_entete','demande_realimentation_feffi.id_convention_cife_entete=convention_cisco_feffi_entete.id')
                        ->where("convention_cisco_feffi_entete.id",$id_convention_entete)
                        ->where("transfert_daaf.validation",1)
                       //->order_by('code')
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
