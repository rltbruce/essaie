<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrat_be_model extends CI_Model {
    protected $table = 'contrat_bureau_etude';

    public function add($contrat_be) {
        $this->db->set($this->_set($contrat_be))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $contrat_be) {
        $this->db->set($this->_set($contrat_be))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($contrat_be) {
        return array(

            'intitule' => $contrat_be['intitule'],
            'ref_contrat'   => $contrat_be['ref_contrat'],
            'montant_contrat'    => $contrat_be['montant_contrat'],
            'date_signature' => $contrat_be['date_signature'],
            'id_convention_entete' => $contrat_be['id_convention_entete'],
            'id_bureau_etude' => $contrat_be['id_bureau_etude'],
            'validation' => $contrat_be['validation']                       
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

    public function findAllByConvention($id_convention_entete) {               
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

    public function findcontratvalideByConvention($id_convention_entete) {               
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

    public function findcontratvalideById($id_contrat_moe) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_contrat_moe)
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
    public function findcontratinvalideByConvention($id_convention_entete) {               
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

    public function findAllBybe($id_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_bureau_etude", $id_bureau_etude)
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

    public function findByBatiment($id_batiment_construction)  {
        $this->db->select('contrat_bureau_etude.ref_contrat as ref_contrat, contrat_bureau_etude.intitule as intitule, contrat_bureau_etude.montant_contrat as montant_contrat, contrat_bureau_etude.date_signature as date_signature,contrat_bureau_etude.id_bureau_etude as id_bureau_etude, contrat_bureau_etude.id_convention_entete as id_convention_entete')
                ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=contrat_bureau_etude.id_convention_entete')
                ->join('batiment_construction','convention_cisco_feffi_entete.id=batiment_construction.id_convention_entete')
                ->where("batiment_construction.id", $id_batiment_construction);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

    public function findByLatrine($id_latrine_construction)  {
        $this->db->select('contrat_bureau_etude.ref_contrat as ref_contrat, contrat_bureau_etude.intitule as intitule, contrat_bureau_etude.montant_contrat as montant_contrat, contrat_bureau_etude.date_signature as date_signature,contrat_bureau_etude.id_bureau_etude as id_bureau_etude, contrat_bureau_etude.id_convention_entete as id_convention_entete')
                ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=contrat_bureau_etude.id_convention_entete')
                ->join('batiment_construction','convention_cisco_feffi_entete.id=batiment_construction.id_convention_entete')
                ->join('latrine_construction','batiment_construction.id=latrine_construction.id_batiment_construction')
                ->where("latrine_construction.id", $id_latrine_construction);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

    public function findByMobilier($id_mobilier_construction)  {
        $this->db->select('contrat_bureau_etude.ref_contrat as ref_contrat, contrat_bureau_etude.intitule as intitule, contrat_bureau_etude.montant_contrat as montant_contrat, contrat_bureau_etude.date_signature as date_signature,contrat_bureau_etude.id_bureau_etude as id_bureau_etude, contrat_bureau_etude.id_convention_entete as id_convention_entete')
                ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=contrat_bureau_etude.id_convention_entete')
                ->join('batiment_construction','convention_cisco_feffi_entete.id=batiment_construction.id_convention_entete')
                ->join('mobilier_construction','batiment_construction.id=mobilier_construction.id_batiment_construction')
                ->where("mobilier_construction.id", $id_mobilier_construction);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

       public function findAllBycisco($id_cisco) {               
        $result =  $this->db->select('contrat_bureau_etude.*')
                        ->from($this->table)
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id", $id_cisco)
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

    public function getcontratByconvention($id_convention_entete)
    {               
        $result =  $this->db->select('contrat_bureau_etude.*,bureau_etude.nom')
                        ->from($this->table)
                        ->join('bureau_etude','bureau_etude.id=contrat_bureau_etude.id_bureau_etude')
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

    public function findcontratByconvention($id_convention_entete) {               
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
        $result =  $this->db->select('contrat_bureau_etude.*')
                        ->from($this->table)
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=contrat_bureau_etude.id_convention_entete')
                        ->where("ref_convention", $ref_convention)
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
