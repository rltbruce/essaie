<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prestation_mpe_model extends CI_Model {
    protected $table = 'prestation_mpe';

    public function add($prestation_mpe) {
        $this->db->set($this->_set($prestation_mpe))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $prestation_mpe) {
        $this->db->set($this->_set($prestation_mpe))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($prestation_mpe) {
        return array(

            'date_pre_debu_trav' => $prestation_mpe['date_pre_debu_trav'],
            'date_reel_debu_trav'   => $prestation_mpe['date_reel_debu_trav'],
            'delai_execution'    => $prestation_mpe['delai_execution'],
            'date_expiration_assurance_mpe'   => $prestation_mpe['date_expiration_assurance_mpe'],
            'id_contrat_prestataire' => $prestation_mpe['id_contrat_prestataire'],
            'validation' => $prestation_mpe['validation']                     
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
                        ->order_by('date_lancement')
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

    public function findAllByContrat($id_contrat_prestataire) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
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

    public function findprestationinvalideBycisco($id_cisco) {               
        $result =  $this->db->select('prestation_mpe.*')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id=prestation_mpe.id_contrat_prestataire')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=contrat_prestataire.id_convention_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id", $id_cisco)
                        ->where("prestation_mpe.validation", 0)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

     public function findprestationBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('prestation_mpe.*')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id=prestation_mpe.id_contrat_prestataire')
                        ->where("contrat_prestataire.id", $id_contrat_prestataire)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    
    public function getprestation_mpeBycontrat($id_contrat_prestataire) {               
        $result = " 
        select 
                prestation_mpe.date_pre_debu_trav as date_pre_debu_trav, 
                prestation_mpe.date_reel_debu_trav as date_reel_debu_trav,
                prestation_mpe.delai_execution as delai_execution, 
                prestation_mpe.date_expiration_assurance_mpe as date_expiration_assurance_mpe,
                phase_sous_projets.libelle as libelle

            from prestation_mpe
                inner join contrat_prestataire on contrat_prestataire.id=prestation_mpe.id_contrat_prestataire
                inner join phase_sous_projet_construction on phase_sous_projet_construction.id_contrat_prestataire = contrat_prestataire.id
                inner join phase_sous_projets on phase_sous_projets.id = phase_sous_projet_construction.id_phase_sous_projet

                where contrat_prestataire.id=".$id_contrat_prestataire." 
                and prestation_mpe.validation=1 and phase_sous_projet_construction.validation=1 and phase_sous_projet_construction.id=(select max(id) from phase_sous_projet_construction as phase where phase.validation=1)";
        return $this->db->query($result)->result();                
    }

}
