<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Delai_travaux_model extends CI_Model {
    protected $table = 'delai_travaux';

    public function add($delai_travaux) {
        $this->db->set($this->_set($delai_travaux))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $delai_travaux) {
        $this->db->set($this->_set($delai_travaux))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($delai_travaux) {
        return array(

            'date_prev_debu_travau' => $delai_travaux['date_prev_debu_travau'],
            'date_reel_debu_travau'   => $delai_travaux['date_reel_debu_travau'],
            'delai_execution'    => $delai_travaux['delai_execution'],
            'date_expiration_police'   => $delai_travaux['date_expiration_police'],
            'id_contrat_prestataire' => $delai_travaux['id_contrat_prestataire'],
            'validation' => $delai_travaux['validation']                     
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
    public function finddelai_travauxBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('delai_travaux.*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function finddelai_travauxvalideBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('delai_travaux.*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
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
    public function finddelai_travauxvalideById($id_delai_travaux) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_delai_travaux)
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
    public function finddelai_travauxinvalideBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('delai_travaux.*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
                        ->where("validation", 0)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

   /* public function findAllByContrat($id_contrat_prestataire) {               
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
        $result =  $this->db->select('delai_travaux.*')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id=delai_travaux.id_contrat_prestataire')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=contrat_prestataire.id_convention_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id", $id_cisco)
                        ->where("delai_travaux.validation", 0)
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
        $result =  $this->db->select('delai_travaux.*')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id=delai_travaux.id_contrat_prestataire')
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
    
    public function getdelai_travauxBycontrat($id_contrat_prestataire) {               
        $result = " 
        select 
                delai_travaux.date_pre_debu_trav as date_pre_debu_trav, 
                delai_travaux.date_reel_debu_trav as date_reel_debu_trav,
                delai_travaux.delai_travaux as delai_travaux, 
                delai_travaux.date_expiration_assurance_mpe as date_expiration_assurance_mpe,
                phase_sous_projets.libelle as libelle

            from delai_travaux
                inner join contrat_prestataire on contrat_prestataire.id=delai_travaux.id_contrat_prestataire
                inner join phase_sous_projet_construction on phase_sous_projet_construction.id_contrat_prestataire = contrat_prestataire.id
                inner join phase_sous_projets on phase_sous_projets.id = phase_sous_projet_construction.id_phase_sous_projet

                where contrat_prestataire.id=".$id_contrat_prestataire." 
                and delai_travaux.validation=1 and phase_sous_projet_construction.validation=1 and phase_sous_projet_construction.id=(select max(id) from phase_sous_projet_construction as phase where phase.validation=1)";
        return $this->db->query($result)->result();                
    }*/

}
