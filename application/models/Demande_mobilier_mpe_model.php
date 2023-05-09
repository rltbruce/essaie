<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_mobilier_mpe_model extends CI_Model {
    protected $table = 'demande_mobilier_mpe';

    public function add($demande_mobilier_mpe) {
        $this->db->set($this->_set($demande_mobilier_mpe))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_mobilier_mpe) {
        $this->db->set($this->_set($demande_mobilier_mpe))
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
    public function _set($demande_mobilier_mpe) {
        return array(
            'montant'   =>      $demande_mobilier_mpe['montant'],
            'id_tranche_demande_mpe' => $demande_mobilier_mpe['id_tranche_demande_mpe'],
            'id_pv_consta_entete_travaux'    =>  $demande_mobilier_mpe['id_pv_consta_entete_travaux']                       
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
        $result =  $this->db->select('demande_mobilier_mpe.*')
                        ->from($this->table)
                        ->join('pv_consta_entete_travaux','pv_consta_entete_travaux.id = demande_mobilier_mpe.id_pv_consta_entete_travaux')
                        ->where("demande_mobilier_mpe.id_tranche_demande_mpe", $id_tranche_demande_mpe)
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
        $result =  $this->db->select('demande_mobilier_mpe.*')
                        ->from($this->table)
                        ->join('pv_consta_entete_travaux','pv_consta_entete_travaux.id = demande_mobilier_mpe.id_pv_consta_entete_travaux')
                        ->join('tranche_demande_mpe','tranche_demande_mpe.id = demande_mobilier_mpe.id_tranche_demande_mpe')
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
    public function getdemandevalideById($id_demande_mobilier_mpe) {               
        $result =  $this->db->select('demande_mobilier_mpe.*')
                        ->from($this->table)
                        ->join('pv_consta_entete_travaux','pv_consta_entete_travaux.id = demande_mobilier_mpe.id_pv_consta_entete_travaux')                        
                        ->join('facture_mpe','facture_mpe.id_pv_consta_entete_travaux = pv_consta_entete_travaux.id')
                        ->where("demande_mobilier_mpe.id", $id_demande_mobilier_mpe)
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

     

}
