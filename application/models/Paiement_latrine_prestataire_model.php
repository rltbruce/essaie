<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paiement_latrine_prestataire_model extends CI_Model {
    protected $table = 'paiement_latrine_prestataire';

    public function add($paiement_latrine_prestataire) {
        $this->db->set($this->_set($paiement_latrine_prestataire))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $paiement_latrine_prestataire) {
        $this->db->set($this->_set($paiement_latrine_prestataire))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($paiement_latrine_prestataire) {
        return array(
            'montant_paiement'       =>      $paiement_latrine_prestataire['montant_paiement'],
            'validation'       =>      $paiement_latrine_prestataire['validation'],
            //'pourcentage_paiement'   =>      $paiement_latrine_prestataire['pourcentage_paiement'],
            'date_paiement'       =>      $paiement_latrine_prestataire['date_paiement'],
            'observation'       =>      $paiement_latrine_prestataire['observation'],
            'id_demande_latrine_pre'    => $paiement_latrine_prestataire['id_demande_latrine_pre']                       
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

    public function findpaiementBydemande($id_demande_latrine_pre) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_latrine_pre", $id_demande_latrine_pre)
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
    public function findpaiementvalideBydemande($id_demande_latrine_pre) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_latrine_pre", $id_demande_latrine_pre)
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
    public function findpaiementinvalideBydemande($id_demande_latrine_pre) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_latrine_pre", $id_demande_latrine_pre)
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

    public function findBydemande_latrine_prestataire($id_demande_latrine_pre) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_latrine_pre", $id_demande_latrine_pre)
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
    public function getpaiementlat_mpeBycontrat($id_contrat_prestataire)
    {               
        $result =  $this->db->select('demande_latrine_presta.date_approbation as date_approbation,tranche_demande_latrine_mpe.code as code,tranche_demande_latrine_mpe.pourcentage as pourcentage,paiement_latrine_prestataire.montant_paiement as montant_paiement')
                        ->from($this->table)
                        ->join('demande_latrine_presta','demande_latrine_presta.id=paiement_latrine_prestataire.id_demande_latrine_pre')
                        ->join('tranche_demande_latrine_mpe','tranche_demande_latrine_mpe.id=demande_latrine_presta.id_tranche_demande_mpe')
                        ->join('contrat_prestataire','contrat_prestataire.id=demande_latrine_presta.id_contrat_prestataire')
                        
                        ->where("contrat_prestataire.id",$id_contrat_prestataire )
                        ->where("demande_latrine_presta.validation",3 )
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
