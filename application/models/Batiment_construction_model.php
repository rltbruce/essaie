<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Batiment_construction_model extends CI_Model {
    protected $table = 'batiment_construction';

    public function add($batiment_construction) {
        $this->db->set($this->_set($batiment_construction))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $batiment_construction) {
        $this->db->set($this->_set($batiment_construction))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($batiment_construction) {
        return array(
            'id_type_batiment' => $batiment_construction['id_type_batiment'],
            'id_convention_entete'=> $batiment_construction['id_convention_entete'],
            'cout_unitaire'=> $batiment_construction['cout_unitaire'],
            //'nbr_batiment'=> $batiment_construction['nbr_batiment']
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
    public function delete_detail($id) {
         $this->db->where('id_convention_entete', (int) $id)->delete($this->table);
         if($this->db->affected_rows() === 1)
         {
             return true;
         }else{
             return null;
         }  
     }

   /* public function delete($id)
    {
        $this->db->from($this->table)
                ->join('latrine_construction', 'latrine_construction.id_batiment_construction = batiment_construction.id')
                ->join('mobilier_construction', 'mobilier_construction.id_batiment_construction = batiment_construction.id')
                ->where('batiment_construction.id', (int) $id)
        ->delete($this->table);
                    ;
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }       
    }*/
    public function findAll()
    {               
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

   /* public function findByIdWithType_batiment($id)  {
        $this->db->select('batiment_construction.*,type_batiment.libelle as libelle_type')
        ->join('type_batiment','type_batiment.id = batiment_construction.id_type_batiment')
        ->where("batiment_construction.id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }*/

    public function findBatimentByconvention($id_convention_entete)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete",$id_convention_entete)
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

     public function getmontantByconvention($id_convention_entete)
    {               
        $this->db->select("convention_cisco_feffi_entete.id as id_conv");
        
        $this->db ->select("(select sum(batiment_construction.cout_unitaire) from batiment_construction
            where batiment_construction.id_convention_entete = id_conv ) as montant_bat",FALSE);
        
        $this->db ->select("(select sum(latrine_construction.cout_unitaire) from latrine_construction
            where latrine_construction.id_convention_entete = id_conv ) as montant_lat ",FALSE);

         $this->db ->select("(select sum(mobilier_construction.cout_unitaire) from mobilier_construction
            where mobilier_construction.id_convention_entete = id_conv ) as montant_mob ",FALSE);

        $this->db ->select("(select sum(cout_maitrise_construction.cout) from cout_maitrise_construction

            where id_convention_entete = id_conv ) as montant_maitrise",FALSE);
        
        $this->db ->select("(select sum(cout_sousprojet_construction.cout) from cout_sousprojet_construction
            where id_convention_entete = id_conv ) as montant_sousprojet",FALSE);
        

        $result =  $this->db->from('convention_cisco_feffi_entete,batiment_construction,latrine_construction')
                    
                    ->where('convention_cisco_feffi_entete.id',$id_convention_entete)
                    ->group_by('id_conv')
                                       
                    ->get()
                    ->result();


        if($result)
        {   
            return $result;
        }
        else
        {
            return $data=array();
        }               
    
    }
/* 
 public function findAllBycontratprestataire($id_contrat_prestataire)
    {               
        $result =  $this->db->select('batiment_construction.id_convention_entete as id_convention_entete, batiment_construction.id_type_batiment as id_type_batiment, batiment_construction.cout_unitaire as cout_unitaire, batiment_construction.nbr_batiment as nbr_batiment, batiment_construction.id as id')
                        ->from('batiment_construction')
                        //->join('mobilier_construction','mobilier_construction.id=avancement_mobilier.id_mobilier_construction')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=batiment_construction.id_convention_entete')
                        ->join('contrat_prestataire','contrat_prestataire.id_convention_entete=convention_cisco_feffi_entete.id')
                        ->where('contrat_prestataire.id',$id_contrat_prestataire)
                       
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findAllBycontratbureau_etude($id_contrat_bureau_etude)
    {               
        $result =  $this->db->select('batiment_construction.id_convention_entete as id_convention_entete, batiment_construction.id_type_batiment as id_type_batiment, batiment_construction.cout_unitaire as cout_unitaire, batiment_construction.nbr_batiment as nbr_batiment, batiment_construction.id as id')
                        ->from('batiment_construction')
                        //->join('mobilier_construction','mobilier_construction.id=avancement_mobilier.id_mobilier_construction')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=batiment_construction.id_convention_entete')
                        ->join('contrat_bureau_etude','contrat_bureau_etude.id_convention_entete=convention_cisco_feffi_entete.id')
                        ->where('contrat_bureau_etude.id',$id_contrat_bureau_etude)
                       
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
        public function findAllBycontratpartenaire_relai($id_contrat_partenaire_relai)
    {               
        $result =  $this->db->select('batiment_construction.id_convention_entete as id_convention_entete, batiment_construction.id_type_batiment as id_type_batiment, batiment_construction.cout_unitaire as cout_unitaire, batiment_construction.nbr_batiment as nbr_batiment, batiment_construction.id as id')
                        ->from('batiment_construction')
                        //->join('mobilier_construction','mobilier_construction.id=avancement_mobilier.id_mobilier_construction')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=batiment_construction.id_convention_entete')
                        ->join('contrat_partenaire_relai','contrat_partenaire_relai.id_convention_entete=convention_cisco_feffi_entete.id')
                        ->where('contrat_partenaire_relai.id',$id_contrat_partenaire_relai)
                       
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    //mbola ts mande
         public function getnombreconstructionBycontrat($id_contrat_bureau_etude)
    {               
        $this->db->select("contrat_bureau_etude.id as id_contra");
        
        $this->db ->select("(select sum(batiment_construction.nbr_batiment) from batiment_construction
            inner join convention_cisco_feffi_entete on batiment_construction.id_convention_entete  =convention_cisco_feffi_entete.id
            inner join contrat_bureau_etude on contrat_bureau_etude.id_convention_entete  = convention_cisco_feffi_entete.id
            where contrat_bureau_etude.id = id_contra ) as nbr_bat

            ",FALSE);
        
        $this->db ->select("(select sum(latrine_construction.nbr_latrine) from latrine_construction
            inner join batiment_construction on batiment_construction.id =latrine_construction.id_batiment_construction
            inner join convention_cisco_feffi_entete on batiment_construction.id_convention_entete  =convention_cisco_feffi_entete.id
            inner join contrat_bureau_etude on contrat_bureau_etude.id_convention_entete  = convention_cisco_feffi_entete.id
            where contrat_bureau_etude.id = id_contra ) as nbr_lat ",FALSE);

         $this->db ->select("(select sum(mobilier_construction.nbr_mobilier) from mobilier_construction
            inner join batiment_construction on batiment_construction.id =mobilier_construction.id_batiment_construction
            inner join convention_cisco_feffi_entete on batiment_construction.id_convention_entete  =convention_cisco_feffi_entete.id
            inner join contrat_bureau_etude on contrat_bureau_etude.id_convention_entete  = convention_cisco_feffi_entete.id
            where contrat_bureau_etude.id = id_contra) as nbr_mob ",FALSE);       
        

        $result =  $this->db->from('convention_cisco_feffi_entete,contrat_bureau_etude,batiment_construction,latrine_construction')
                    
                    ->where('contrat_bureau_etude.id',$id_contrat_bureau_etude)
                    ->group_by('id_contra')
                                       
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
