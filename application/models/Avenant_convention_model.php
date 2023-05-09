<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avenant_convention_model extends CI_Model {
    protected $table = 'avenant_convention';

    public function add($avenant_convention) {
        $this->db->set($this->_set($avenant_convention))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $avenant_convention) {
        $this->db->set($this->_set($avenant_convention))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($avenant_convention) {
        return array(

            'ref_avenant' => $avenant_convention['ref_avenant'],
            'description' => $avenant_convention['description'],
            'montant'    => $avenant_convention['montant'],
            'date_signature' => $avenant_convention['date_signature'],
            'id_convention_entete' => $avenant_convention['id_convention_entete'],
            'validation' => $avenant_convention['validation']                       
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

    public function findavenantByconvention($id_convention_entete) {               
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

    public function findavenantinvalideByconvention($id_convention_entete) {               
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

    public function findavenantvalideByconvention($id_convention_entete) {               
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

    public function getavenant_conventionvalideById($id_avenant_convention) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_avenant_convention)
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
    public function getdocumentByconventiondossier_prevu($id_document_feffi,$id_convention_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_document_feffi", $id_document_feffi)
                        ->where("id_convention_entete", $id_convention_entete)
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
    public function countAvenantByIdconvention($id_convention_entete)  {
        $this->db->select('count(id) as nbr')
                    ->where("id_convention_entete", $id_convention_entete)
                    ->where("validation", 0);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

    public function getavenantvalideByconvention($id_convention_entete)  {
        $this->db->select('*')
                    ->where("id_convention_entete", $id_convention_entete)
                    ->where("validation", 1);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    public function findByconventionRef_avenant($id_convention_entete,$ref_avenant) {
        $requete="select * from avenant_convention where lower(ref_avenant)='".$ref_avenant."' and id_convention_entete='".$id_convention_entete."'";
        $query = $this->db->query($requete);
        return $query->result();                
    }
    
    
    public function getavenanttest($id_convention) {               
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
