<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_batiment_mpe_model extends CI_Model {
    protected $table = 'demande_batiment_mpe';

    public function add($demande_batiment_mpe) {
        $this->db->set($this->_set($demande_batiment_mpe))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_batiment_mpe) {
        $this->db->set($this->_set($demande_batiment_mpe))
                //->set('date_approbation', 'NOW()', false)
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($demande_batiment_mpe) {
        return array(
            'montant'   =>      $demande_batiment_mpe['montant'],
            'id_tranche_demande_mpe' => $demande_batiment_mpe['id_tranche_demande_mpe'],
            'id_pv_consta_entete_travaux'    =>  $demande_batiment_mpe['id_pv_consta_entete_travaux']                       
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
                        ->order_by('objet')
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
    public function finddemandeBypv_consta_entete($id_pv_consta_entete_travaux) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_pv_consta_entete_travaux", $id_pv_consta_entete_travaux)
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
    public function getdemandeByContratTranche($id_tranche_demande_mpe,$id_contrat_prestataire) {               
        $result =  $this->db->select('demande_batiment_mpe.*')
                        ->from($this->table)
                        ->join('pv_consta_entete_travaux','pv_consta_entete_travaux.id = demande_batiment_mpe.id_pv_consta_entete_travaux')
                        ->where("demande_batiment_mpe.id_tranche_demande_mpe", $id_tranche_demande_mpe)
                        ->where("pv_consta_entete_travaux.id_contrat_prestataire", $id_contrat_prestataire)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function getdemandeByContratTranchenumero($tranche_numero,$id_contrat_prestataire) {               
        $result =  $this->db->select('demande_batiment_mpe.*')
                        ->from($this->table)
                        ->join('pv_consta_entete_travaux','pv_consta_entete_travaux.id = demande_batiment_mpe.id_pv_consta_entete_travaux')
                        ->join('tranche_demande_mpe','tranche_demande_mpe.id = demande_batiment_mpe.id_tranche_demande_mpe')
                        ->where("tranche_demande_mpe.code", $tranche_numero)
                        ->where("pv_consta_entete_travaux.id_contrat_prestataire", $id_contrat_prestataire)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function getdemandevalideById($id_demande_batiment_mpe) {               
        $result =  $this->db->select('demande_batiment_mpe.*')
                        ->from($this->table)
                        ->join('pv_consta_entete_travaux','pv_consta_entete_travaux.id = demande_batiment_mpe.id_pv_consta_entete_travaux')                        
                        ->join('facture_mpe','facture_mpe.id_pv_consta_entete_travaux = pv_consta_entete_travaux.id')
                        ->where("demande_batiment_mpe.id", $id_demande_batiment_mpe)
                        ->where("facture_mpe.validation", 2)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    /*public function finddemandeBycontrat($id_contrat_prestataire) {               
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
     public function finddemandeinvalideBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
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
     public function finddemandevalidebcafBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
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
    public function finddemandevalideBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
                        ->where("validation", 2)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/
    public function countAllfactureByvalidation($validation)
    {
        $sql=" select 
                       sum(detail.nbr_facture_mpe) + sum( detail.nbr_facture_moe) + sum( detail.avance_dem) as nombre
               from (
               
                (
                    select 
                        count(fact_mpe.id) as nbr_facture_mpe,
                        0 as nbr_facture_moe,
                        0 as avance_dem

                        from facture_mpe as fact_mpe
                        where 
                            fact_mpe.validation= '".$validation."'
                )
                UNION
                (
                    select 
                        0 as nbr_facture_mpe,
                        count(fact_moe.id) as nbr_facture_moe,
                        0 as avance_dem

                        from facture_moe_entete as fact_moe

                        where 
                            fact_moe.validation= '".$validation."'
                )
                UNION
                (
                    select 
                        0 as nbr_facture_mpe,
                        0 as nbr_facture_moe,
                        count(avance.id) as avance_dem

                        from avance_demarrage as avance

                        where 
                            avance.validation= '".$validation."'
                )

                )detail

            ";
            return $this->db->query($sql)->result();                  
    }
   /*  public function countAllfactureByvalidation($validation)
    {
        $sql=" select 
                       sum(detail.nbr_facture_mpe) as nbr_facture_mpe,
                       sum( detail.nbr_facture_debut_moe) as nbr_facture_debut_moe,
                       sum(detail.nbr_facture_batiment_moe) as nbr_facture_batiment_moe,
                       sum( detail.nbr_facture_latrine_moe) as nbr_facture_latrine_moe,
                       sum(detail.nbr_facture_fin_moe) as nbr_facture_fin_moe,
                       sum(detail.nbr_facture_mpe) + sum( detail.nbr_facture_debut_moe) + sum(detail.nbr_facture_batiment_moe)
                        + sum( detail.nbr_facture_latrine_moe) + sum(detail.nbr_facture_fin_moe) as nombre
               from (
               
                (
                    select 
                        count(fact_mpe.id) as nbr_facture_mpe,
                        0 as nbr_facture_debut_moe,
                        0 as nbr_facture_batiment_moe,
                        0 as nbr_facture_latrine_moe,
                        0 as nbr_facture_fin_moe

                        from facture_mpe as fact_mpe
                        where 
                            fact_mpe.validation= '".$validation."'
                )
                UNION
                (
                    select 
                        0 as nbr_facture_mpe,
                        count(demande_debut_moe.id) as nbr_facture_debut_moe,
                        0 as nbr_facture_batiment_moe,
                        0 as nbr_facture_latrine_moe,
                        0 as nbr_facture_fin_moe

                        from demande_debut_travaux_moe as demande_debut_moe

                        where 
                            demande_debut_moe.validation= '".$validation."'
                )
                UNION
                (
                    select 
                        0 as nbr_facture_mpe,
                        0 as nbr_facture_debut_moe,
                        count(demande_batiment_moe.id) as nbr_facture_batiment_moe,
                        0 as nbr_facture_latrine_moe,
                        0 as nbr_facture_fin_moe

                        from demande_batiment_moe as demande_batiment_moe

                        where 
                            demande_batiment_moe.validation= '".$validation."'
                )
                UNION
                (
                    select 
                        0 as nbr_facture_mpe,
                        0 as nbr_facture_debut_moe,
                        0 as nbr_facture_batiment_moe,
                        count(demande_latrine_moe.id) as nbr_facture_latrine_moe,
                        0 as nbr_facture_fin_moe

                        from demande_latrine_moe as demande_latrine_moe

                        where 
                            demande_latrine_moe.validation= '".$validation."'
                )
                UNION
                (
                    select 
                        0 as nbr_facture_mpe,
                        0 as nbr_facture_debut_moe,
                        0 as nbr_facture_batiment_moe,
                        0 as nbr_facture_latrine_moe,
                        count(demande_fin_moe.id) as nbr_facture_fin_moe

                        from demande_fin_travaux_moe as demande_fin_moe

                        where 
                            demande_fin_moe.validation= '".$validation."'
                )

                )detail

            ";
            return $this->db->query($sql)->result();                  
    }*/

   /* public function findAllInvalideBycisco($id_cisco) {               
        $result =  $this->db->select('demande_batiment_mpe.*')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id = demande_batiment_mpe.id_contrat_prestataire')
                        ->join('convention_cisco_feffi_entete','contrat_prestataire.id_convention_entete = convention_cisco_feffi_entete.id')
                        
                        ->where("demande_batiment_mpe.validation", 0)
                        ->where("convention_cisco_feffi_entete.id_cisco", $id_cisco)
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

        public function findAllValideBycisco($id_cisco) {               
        $result =  $this->db->select('demande_batiment_mpe.*, contrat_prestataire.id as id_contrat')
                        ->from($this->table)
                        ->join('batiment_construction','batiment_construction.id = demande_batiment_mpe.id_batiment_construction')
                        ->join('convention_cisco_feffi_entete','batiment_construction.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->join('contrat_prestataire','contrat_prestataire.id_convention_entete = convention_cisco_feffi_entete.id')
                        ->where("demande_batiment_mpe.validation", 3)
                        ->where("convention_cisco_feffi_entete.id_cisco", $id_cisco)
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
            public function findValideBycisco($id_cisco) {               
        $result =  $this->db->select('demande_batiment_mpe.*, contrat_prestataire.id as id_contrat')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id = demande_batiment_mpe.id_contrat_prestataire')
                        ->join('convention_cisco_feffi_entete','contrat_prestataire.id_convention_entete = convention_cisco_feffi_entete.id')
                        
                        ->where("demande_batiment_mpe.validation", 3)
                        ->where("convention_cisco_feffi_entete.id_cisco", $id_cisco)
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

    public function findAllValidebcaf() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
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

        public function findAllValide() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 3)
                        ->order_by('date_approbation')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

            public function findAllValidetechnique() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 2)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/

   
    /*public function findAlldemandeBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('demande_batiment_mpe.*')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id = demande_batiment_mpe.id_contrat_prestataire')
                        ->where("contrat_prestataire.id", $id_contrat_prestataire)
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

    public function finddemandedisponibleBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('demande_batiment_mpe.*')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id = demande_batiment_mpe.id_contrat_prestataire')
                        ->where("contrat_prestataire.id", $id_contrat_prestataire)
                        ->where("demande_batiment_mpe.validation >", 0)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/
     

}
