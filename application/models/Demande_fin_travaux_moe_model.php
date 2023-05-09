<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_fin_travaux_moe_model extends CI_Model {
    protected $table = 'demande_fin_travaux_moe';

    public function add($demande_fin_travaux_moe) {
        $this->db->set($this->_set($demande_fin_travaux_moe))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_fin_travaux_moe) {
        $this->db->set($this->_set($demande_fin_travaux_moe))
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
    public function _set($demande_fin_travaux_moe) {
        return array(
            'objet'          =>      $demande_fin_travaux_moe['objet'],
            'description'   =>      $demande_fin_travaux_moe['description'],
            'ref_facture'   =>      $demande_fin_travaux_moe['ref_facture'],
            'montant'   =>      $demande_fin_travaux_moe['montant'],
            'id_tranche_d_fin_travaux_moe' => $demande_fin_travaux_moe['id_tranche_d_fin_travaux_moe'],
            'anterieur' => $demande_fin_travaux_moe['anterieur'],
            'cumul' => $demande_fin_travaux_moe['cumul'],
            'reste' => $demande_fin_travaux_moe['reste'],
            'date'          =>      $demande_fin_travaux_moe['date'],
            'id_contrat_bureau_etude'    =>  $demande_fin_travaux_moe['id_contrat_bureau_etude'],
            'validation'    =>  $demande_fin_travaux_moe['validation']                       
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
    public function summePourcentageCurrent($id_contrat_bureau_etude)
    {               
        $this->db->select("contrat_bureau_etude.id as id_contr");
        
        $this->db ->select("(select sum(tranche_demande_batiment_moe.pourcentage) from tranche_demande_batiment_moe
            inner join demande_batiment_moe on demande_batiment_moe.id_tranche_demande_batiment_moe = tranche_demande_batiment_moe.id
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_batiment_moe.id_contrat_bureau_etude
            where contrat_bureau_etude.id = id_contr and demande_batiment_moe.validation=3 ) as pourcentage_bat",FALSE);
        
        $this->db ->select("(select sum(tranche_demande_latrine_moe.pourcentage) from tranche_demande_latrine_moe
            inner join demande_latrine_moe on demande_latrine_moe.id_tranche_demande_latrine_moe = tranche_demande_latrine_moe.id
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_latrine_moe.id_contrat_bureau_etude
            where contrat_bureau_etude.id = id_contr and demande_latrine_moe.validation=3 ) as pourcentage_lat",FALSE);

        $this->db ->select("(select sum(tranche_demande_mobilier_moe.pourcentage) from tranche_demande_mobilier_moe
            inner join demande_mobilier_moe on demande_mobilier_moe.id_tranche_demande_mobilier_moe = tranche_demande_mobilier_moe.id            
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_mobilier_moe.id
            where contrat_bureau_etude.id = id_contr and demande_mobilier_moe.validation=3) as pourcentage_mob",FALSE);
        $this->db ->select("(select sum(tranche_d_debut_travaux_moe.pourcentage) from tranche_d_debut_travaux_moe
            inner join demande_debut_travaux_moe on demande_debut_travaux_moe.id_tranche_d_debut_travaux_moe = tranche_d_debut_travaux_moe.id            
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_debut_travaux_moe.id_contrat_bureau_etude
            where contrat_bureau_etude.id = id_contr and demande_debut_travaux_moe.validation=3) as pourcentage_debut_travaux",FALSE);
        $this->db ->select("(select sum(tranche_d_fin_travaux_moe.pourcentage) from tranche_d_fin_travaux_moe
            inner join demande_fin_travaux_moe on demande_fin_travaux_moe.id_tranche_d_fin_travaux_moe = tranche_d_fin_travaux_moe.id            
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_fin_travaux_moe.id_contrat_bureau_etude
            where contrat_bureau_etude.id = id_contr and demande_fin_travaux_moe.validation=3) as pourcentage_fin_travaux",FALSE);

        $this->db ->select("(select sum(tranche_d_fin_travaux_moe.pourcentage) from tranche_d_fin_travaux_moe) as pourcentage_tranche_fin_travaux",FALSE); 

        

        $result =  $this->db->from('contrat_bureau_etude')
                    
                    ->where('contrat_bureau_etude.id',$id_contrat_bureau_etude)
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
        public function finddemandeBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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
     public function finddemandeinvalideBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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
     public function finddemandevalidebcafBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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

    

    public function finddemandevalidedaafByIdcontrat($id_contrat_bureau_etude) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)                        
                        ->where("validation",7)
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

    public function finddemandeemidpfiByIdcontrat($id_contrat_bureau_etude) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)                        
                        ->where("validation IN(1,2,3)")
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
   public function findallByIdcontrat($id_contrat_bureau_etude) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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
    public function findcreerByIdcontrat($id_contrat_bureau_etude) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)                        
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
    public function finddemandedisponibleBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("validation >", 0)
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

   /* public function findAllInvalideBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 0)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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
   

    public function findAllBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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
        public function finddemandedisponibleBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("validation >", 0)
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
    
    public function findAllInvalideBycisco($id_cisco)
    {               
        $result =  $this->db->select('demande_fin_travaux_moe.*')
                        ->from($this->table)
                        ->join('contrat_bureau_etude','contrat_bureau_etude.id= demande_fin_travaux_moe.id_contrat_bureau_etude')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id", $id_cisco)
                        ->where("demande_fin_travaux_moe.validation", 0)
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
    public function findAllValideBycisco($id_cisco)
    {               
        $result =  $this->db->select('demande_fin_travaux_moe.*')
                        ->from($this->table)
                        ->join('contrat_bureau_etude','contrat_bureau_etude.id= demande_fin_travaux_moe.id_contrat_bureau_etude')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id", $id_cisco)
                        ->where("demande_fin_travaux_moe.validation", 3)
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
   /*  public function summePourcentageCurrent($id_contrat_bureau_etude)
    {               
        $this->db->select("contrat_bureau_etude.id as id_contr");
        
        $this->db ->select("(select sum(tranche_demande_batiment_moe.pourcentage) from tranche_demande_batiment_moe
            inner join demande_batiment_moe on demande_batiment_moe.id_tranche_demande_batiment_moe = tranche_demande_batiment_moe.id
            inner join batiment_construction on batiment_construction.id=demande_batiment_moe.id_batiment_construction
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id= batiment_construction.id_convention_entete
            inner join contrat_bureau_etude on contrat_bureau_etude.id_convention_entete = convention_cisco_feffi_entete.id
            where contrat_bureau_etude.id = id_contr and demande_batiment_moe.validation=3 ) as pourcentage_bat",FALSE);
        
        $this->db ->select("(select sum(tranche_demande_latrine_moe.pourcentage) from tranche_demande_latrine_moe
            inner join demande_latrine_moe on demande_latrine_moe.id_tranche_demande_latrine_moe = tranche_demande_latrine_moe.id
            inner join latrine_construction on latrine_construction.id=demande_latrine_moe.id_latrine_construction
            inner join batiment_construction on batiment_construction.id=latrine_construction.id_batiment_construction
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id= batiment_construction.id_convention_entete
            inner join contrat_bureau_etude on contrat_bureau_etude.id_convention_entete = convention_cisco_feffi_entete.id
            where contrat_bureau_etude.id = id_contr and demande_latrine_moe.validation=3 ) as pourcentage_lat",FALSE);

        $this->db ->select("(select sum(tranche_demande_mobilier_moe.pourcentage) from tranche_demande_mobilier_moe
            inner join demande_mobilier_moe on demande_mobilier_moe.id_tranche_demande_mobilier_moe = tranche_demande_mobilier_moe.id
            inner join mobilier_construction on mobilier_construction.id=demande_mobilier_moe.id_mobilier_construction
            inner join batiment_construction on batiment_construction.id=mobilier_construction.id_batiment_construction
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id= batiment_construction.id_convention_entete
            inner join contrat_bureau_etude on contrat_bureau_etude.id_convention_entete = convention_cisco_feffi_entete.id
            where contrat_bureau_etude.id = id_contr and demande_mobilier_moe.validation=3) as pourcentage_mob",FALSE);

        $this->db ->select("(select sum(tranche_d_fin_travaux_moe.pourcentage) from tranche_d_fin_travaux_moe) as pourcentage_tranche_fin_travaux",FALSE); 

        

        $result =  $this->db->from('contrat_bureau_etude,batiment_construction,latrine_construction')
                    
                    ->where('contrat_bureau_etude.id',$id_contrat_bureau_etude)
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
    
    }*/
 


}
