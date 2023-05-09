<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_fin_travaux_pr_model extends CI_Model {
    protected $table = 'demande_fin_travaux_pr';

    public function add($demande_fin_travaux_pr) {
        $this->db->set($this->_set($demande_fin_travaux_pr))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_fin_travaux_pr) {
        $this->db->set($this->_set($demande_fin_travaux_pr))
                ->set('date_approbation', 'NOW()', false)
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($demande_fin_travaux_pr) {
        return array(
            'objet'          =>      $demande_fin_travaux_pr['objet'],
            'description'   =>      $demande_fin_travaux_pr['description'],
            'ref_facture'   =>      $demande_fin_travaux_pr['ref_facture'],
            'montant'   =>      $demande_fin_travaux_pr['montant'],
            'id_tranche_d_fin_travaux_pr' => $demande_fin_travaux_pr['id_tranche_d_fin_travaux_pr'],
            'anterieur' => $demande_fin_travaux_pr['anterieur'],
            'cumul' => $demande_fin_travaux_pr['cumul'],
            'reste' => $demande_fin_travaux_pr['reste'],
            'date'          =>      $demande_fin_travaux_pr['date'],
            'id_contrat_partenaire_relai'    =>  $demande_fin_travaux_pr['id_contrat_partenaire_relai'],
            'validation'    =>  $demande_fin_travaux_pr['validation']                       
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

    public function findAllInvalideBycontrat($id_contrat_partenaire_relai) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 0)
                        ->where("id_contrat_partenaire_relai", $id_contrat_partenaire_relai)
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

    public function findAllInvalide()
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
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
    public function findAllValidedpfi() {               
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
    }
    public function findAllValide() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 3)
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
    public function countAllByInvalide($invalide)
    {
        $result = $this->db->select('COUNT(*) as nombre')
                        ->from($this->table)
                        ->where("validation", $invalide)
                        ->order_by('id', 'desc')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    }

    public function findAllBycontrat($id_contrat_partenaire_relai) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_partenaire_relai", $id_contrat_partenaire_relai)
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
     public function summePourcentageCurrent($id_contrat_partenaire_relai)
    {               
        $this->db->select("contrat_partenaire_relai.id as id_contr");
        
        $this->db ->select("(select sum(tranche_demande_batiment_pr.pourcentage) from tranche_demande_batiment_pr
            inner join demande_batiment_pr on demande_batiment_pr.id_tranche_demande_batiment_pr = tranche_demande_batiment_pr.id
            inner join batiment_construction on batiment_construction.id=demande_batiment_pr.id_batiment_construction
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id= batiment_construction.id_convention_entete
            inner join contrat_partenaire_relai on contrat_partenaire_relai.id_convention_entete = convention_cisco_feffi_entete.id
            where contrat_partenaire_relai.id = id_contr and demande_batiment_pr.validation=3 ) as pourcentage_bat",FALSE);
        
        $this->db ->select("(select sum(tranche_demande_latrine_pr.pourcentage) from tranche_demande_latrine_pr
            inner join demande_latrine_pr on demande_latrine_pr.id_tranche_demande_latrine_pr = tranche_demande_latrine_pr.id
            inner join latrine_construction on latrine_construction.id=demande_latrine_pr.id_latrine_construction
            inner join batiment_construction on batiment_construction.id=latrine_construction.id_batiment_construction
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id= batiment_construction.id_convention_entete
            inner join contrat_partenaire_relai on contrat_partenaire_relai.id_convention_entete = convention_cisco_feffi_entete.id
            where contrat_partenaire_relai.id = id_contr and demande_latrine_pr.validation=3 ) as pourcentage_lat",FALSE);

        $this->db ->select("(select sum(tranche_demande_mobilier_pr.pourcentage) from tranche_demande_mobilier_pr
            inner join demande_mobilier_pr on demande_mobilier_pr.id_tranche_demande_mobilier_pr = tranche_demande_mobilier_pr.id
            inner join mobilier_construction on mobilier_construction.id=demande_mobilier_pr.id_mobilier_construction
            inner join batiment_construction on batiment_construction.id=mobilier_construction.id_batiment_construction
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id= batiment_construction.id_convention_entete
            inner join contrat_partenaire_relai on contrat_partenaire_relai.id_convention_entete = convention_cisco_feffi_entete.id
            where contrat_partenaire_relai.id = id_contr and demande_mobilier_pr.validation=3) as pourcentage_mob",FALSE);

        $this->db ->select("(select sum(tranche_d_fin_travaux_pr.pourcentage) from tranche_d_fin_travaux_pr) as pourcentage_tranche_fin_travaux",FALSE); 

        

        $result =  $this->db->from('contrat_partenaire_relai,batiment_construction,latrine_construction')
                    
                    ->where('contrat_partenaire_relai.id',$id_contrat_partenaire_relai)
                    ->group_by('id_contr')
                                       
                    ->get()
                    ->result();


        if($result)
        {   
            return $result;
        }
        else
        {
            return null;
        }               
    
    }
 


}
