<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document_feffi_scan_model extends CI_Model {
    protected $table = 'document_feffi_scan';

    public function add($document_feffi_scan) {
        $this->db->set($this->_set($document_feffi_scan))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $document_feffi_scan) {
        $this->db->set($this->_set($document_feffi_scan))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($document_feffi_scan) {
        return array(
            'fichier'   =>      $document_feffi_scan['fichier'],
            'date_elaboration'   =>      $document_feffi_scan['date_elaboration'],
            'observation'   =>      $document_feffi_scan['observation'],
            'id_convention_entete'    =>  $document_feffi_scan['id_convention_entete'],
            'id_document_feffi'    =>  $document_feffi_scan['id_document_feffi'],
            'validation'    =>  $document_feffi_scan['validation'],
            'id_convention_entete'    =>  $document_feffi_scan['id_convention_entete'],                       
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
                        ->order_by('date_elaboration')
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

    public function findAllByconvention($id_convention_entete,$validation) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
                        ->where("validation", $validation)
                        ->order_by('date_elaboration')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function getdocument_feffi_scanvalideById($id_document_feffi_scan) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_document_feffi_scan)
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

        public function findAllByvalidation($validation) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", $validation)
                        ->order_by('date_elaboration')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
        public function findAllinvalideBycisco($id_cisco) {               
        $result =  $this->db->select('document_feffi_scan.*')
                        ->from($this->table)
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=document_feffi_scan.id_convention_entete')
                        ->join('feffi','feffi.id=convention_cisco_feffi_entete.id_feffi')
                        ->join('ecole','ecole.id=feffi.id_ecole')
                        ->join('fokontany','fokontany.id=ecole.id_fokontany')
                        ->join('commune','commune.id=fokontany.id_commune')
                        ->join('district','district.id=commune.id_district')
                        ->join('cisco','district.id=cisco.id_district')
                        ->where("cisco.id", $id_cisco)
                        ->where("document_feffi_scan.validation", 0)
                        ->order_by('date_elaboration')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findAllvalideBycisco($id_cisco) {               
        $result =  $this->db->select('document_feffi_scan.*')
                        ->from($this->table)
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=document_feffi_scan.id_convention_entete')
                        ->join('feffi','feffi.id=convention_cisco_feffi_entete.id_feffi')
                        ->join('ecole','ecole.id=feffi.id_ecole')
                        ->join('fokontany','fokontany.id=ecole.id_fokontany')
                        ->join('commune','commune.id=fokontany.id_commune')
                        ->join('district','district.id=commune.id_district')
                        ->join('cisco','district.id=cisco.id_district')
                        ->where("cisco.id", $id_cisco)
                        ->where("document_feffi_scan.validation", 1)
                        ->order_by('date_elaboration')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

}
