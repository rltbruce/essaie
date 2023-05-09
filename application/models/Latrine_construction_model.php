<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Latrine_construction_model extends CI_Model {
    protected $table = 'latrine_construction';

    public function add($latrine_construction)
    {
        $this->db->set($this->_set($latrine_construction))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $latrine_construction)
    {
        $this->db->set($this->_set($latrine_construction))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($latrine_construction)
    {
        return array(
            'id_type_latrine' => $latrine_construction['id_type_latrine'],            
            'id_convention_entete'=> $latrine_construction['id_convention_entete'],
            'cout_unitaire'=> $latrine_construction['cout_unitaire']
        );
    }
    public function delete($id)
    {
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
    public function findById($id)
    {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    public function findLatrineByconvention($id_convention_entete)
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

     /*  public function findByIdWithType_latrine($id)  {
        $this->db->select('latrine_construction.*,type_latrine.libelle as libelle_type')
        ->join('type_latrine','type_latrine.id = latrine_construction.id_type_latrine')
        ->where("latrine_construction.id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }*/

   /* public function findAllByBatiment($id_batiment_construction) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_batiment_construction",$id_batiment_construction)
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

        public function findAllByContrat_bureau_etude($id_contrat_bureau_etude) {               
        $result =  $this->db->select('latrine_construction.id as id, latrine_construction.id_batiment_construction as id_batiment_construction, latrine_construction.nbr_latrine as nbr_latrine,latrine_construction.cout_unitaire,latrine_construction.id_type_latrine as id_type_latrine')
                        ->from($this->table)
                        ->join("batiment_construction",'latrine_construction.id_batiment_construction=batiment_construction.id')
                        ->join("convention_cisco_feffi_entete",'convention_cisco_feffi_entete.id=batiment_construction.id_convention_entete')
                        ->join("contrat_bureau_etude",'contrat_bureau_etude.id_convention_entete=convention_cisco_feffi_entete.id')
                        ->where("contrat_bureau_etude.id",$id_contrat_bureau_etude)
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
            public function findAllByContrat_partenaire_relai($id_contrat_partenaire_relai) {               
        $result =  $this->db->select('latrine_construction.id as id, latrine_construction.id_batiment_construction as id_batiment_construction, latrine_construction.nbr_latrine as nbr_latrine,latrine_construction.cout_unitaire,latrine_construction.id_type_latrine as id_type_latrine')
                        ->from($this->table)
                        ->join("batiment_construction",'latrine_construction.id_batiment_construction=batiment_construction.id')
                        ->join("convention_cisco_feffi_entete",'convention_cisco_feffi_entete.id=batiment_construction.id_convention_entete')
                        ->join("contrat_partenaire_relai",'contrat_partenaire_relai.id_convention_entete=convention_cisco_feffi_entete.id')
                        ->where("contrat_partenaire_relai.id",$id_contrat_partenaire_relai)
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

    public function findAllByContrat_prestataire($id_contrat_prestataire) {               
        $result =  $this->db->select('latrine_construction.id as id, latrine_construction.id_batiment_construction as id_batiment_construction, latrine_construction.nbr_latrine as nbr_latrine,latrine_construction.cout_unitaire,latrine_construction.id_type_latrine as id_type_latrine')
                        ->from($this->table)
                        ->join("batiment_construction",'latrine_construction.id_batiment_construction=batiment_construction.id')
                        ->join("convention_cisco_feffi_entete",'convention_cisco_feffi_entete.id=batiment_construction.id_convention_entete')
                        ->join("contrat_prestataire",'contrat_prestataire.id_convention_entete=convention_cisco_feffi_entete.id')
                        ->where("contrat_prestataire.id",$id_contrat_prestataire)
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

  /*  public function supressionBydetail($id) {
        $this->db->where('id_convention_detail', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    } */

}
