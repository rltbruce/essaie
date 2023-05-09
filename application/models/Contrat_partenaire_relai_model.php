<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrat_partenaire_relai_model extends CI_Model {
    protected $table = 'contrat_partenaire_relai';

    public function add($contrat_partenaire_relai) {
        $this->db->set($this->_set($contrat_partenaire_relai))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $contrat_partenaire_relai) {
        $this->db->set($this->_set($contrat_partenaire_relai))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($contrat_partenaire_relai) {
        return array(

            'intitule' => $contrat_partenaire_relai['intitule'],
            'ref_contrat'   => $contrat_partenaire_relai['ref_contrat'],
            'montant_contrat'    => $contrat_partenaire_relai['montant_contrat'],
            'date_signature' => $contrat_partenaire_relai['date_signature'],
            'id_convention_entete' => $contrat_partenaire_relai['id_convention_entete'],
            'id_partenaire_relai' => $contrat_partenaire_relai['id_partenaire_relai'],
            'validation' => $contrat_partenaire_relai['validation']                      
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
                        ->order_by('date_signature')
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
    public function findinvalideByConvention($id_convention_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
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
    public function findvalideByConvention($id_convention_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
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
    public function findvalideById($id_contrat_partenaire) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_contrat_partenaire)
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
    public function findcontratByConvention($id_convention_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
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

    public function getcontratByconvention($id_convention_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return $result=array();
        }

    }
    public function findByRef_convention($ref_convention) {
        $requete="select contrat_partenaire_relai.* from contrat_partenaire_relai
        inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id=contrat_partenaire_relai.id_convention_entete
         where lower(ref_convention)='".$ref_convention."'";
        $query = $this->db->query($requete);
        return $query->result();                
    } 
    

    
    public function getcontrattest($id_convention) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_convention_entete',$id_convention)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    } 

}
