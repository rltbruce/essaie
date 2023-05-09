<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobilier_construction_model extends CI_Model {
    protected $table = 'mobilier_construction';

    public function add($mobilier_construction)
    {
        $this->db->set($this->_set($mobilier_construction))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $mobilier_construction)
    {
        $this->db->set($this->_set($mobilier_construction))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($mobilier_construction)
    {
        return array(
            'id_type_mobilier' => $mobilier_construction['id_type_mobilier'],
            'id_convention_entete'=> $mobilier_construction['id_convention_entete'],
            'cout_unitaire'=> $mobilier_construction['cout_unitaire']
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

    public function findMobilierByconvention($id_convention_entete)
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

  /*  public function findAllByBatiment($id_batiment_construction) {               
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
    /*    public function findAllByContrat_bureau_etude($id_contrat_bureau_etude) {               
        $result =  $this->db->select('mobilier_construction.id as id, mobilier_construction.id_batiment_construction as id_batiment_construction, mobilier_construction.nbr_mobilier as nbr_mobilier,mobilier_construction.cout_unitaire,mobilier_construction.id_type_mobilier as id_type_mobilier')
                        ->from($this->table)
                        ->join("batiment_construction",'mobilier_construction.id_batiment_construction=batiment_construction.id')
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
        $result =  $this->db->select('mobilier_construction.id as id, mobilier_construction.id_batiment_construction as id_batiment_construction, mobilier_construction.nbr_mobilier as nbr_mobilier,mobilier_construction.cout_unitaire,mobilier_construction.id_type_mobilier as id_type_mobilier')
                        ->from($this->table)
                        ->join("batiment_construction",'mobilier_construction.id_batiment_construction=batiment_construction.id')
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
        $result =  $this->db->select('mobilier_construction.id as id, mobilier_construction.id_batiment_construction as id_batiment_construction, mobilier_construction.nbr_mobilier as nbr_mobilier,mobilier_construction.cout_unitaire,mobilier_construction.id_type_mobilier as id_type_mobilier')
                        ->from($this->table)
                        ->join("batiment_construction",'mobilier_construction.id_batiment_construction=batiment_construction.id')
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

}
