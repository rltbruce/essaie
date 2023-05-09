<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document_moe_scan_model extends CI_Model {
    protected $table = 'document_moe_scan';

    public function add($document_moe_scan) {
        $this->db->set($this->_set($document_moe_scan))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $document_moe_scan) {
        $this->db->set($this->_set($document_moe_scan))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($document_moe_scan) {
        return array(
            'fichier'   =>      $document_moe_scan['fichier'],
            'date_elaboration'   =>      $document_moe_scan['date_elaboration'],
            'observation'   =>      $document_moe_scan['observation'],
            'id_contrat_bureau_etude'    =>  $document_moe_scan['id_contrat_bureau_etude'],
            'id_document_moe'    =>  $document_moe_scan['id_document_moe'],
            'validation'    =>  $document_moe_scan['validation']                       
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

   /* public function findAllBycontrat($id_contrat_bureau_etude,$validation) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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
    } */

    /*public function findAllByvalidation($validation)
    {               
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
    }*/
    public function getdocumentvalideById($id_document_moe_scan)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table) 
                        ->where("id", $id_document_moe_scan)
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
    public function getdocumentBycontratdossier_prevu($id_document_moe,$id_contrat_bureau_etude)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table) 
                        ->where("id_document_moe", $id_document_moe)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    /*public function finddocumentinvalideBycisco($id_cisco)
    {               
        $result =  $this->db->select('document_moe_scan.*')
                        ->from($this->table)                        
                        ->join('contrat_bureau_etude','contrat_bureau_etude.id= document_moe_scan.id_contrat_bureau_etude')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id", $id_cisco)
                        ->where("document_moe_scan.validation", 0)
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
    public function finddocumentvalideBycisco($id_cisco)
    {               
        $result =  $this->db->select('document_moe_scan.*')
                        ->from($this->table)                        
                        ->join('contrat_bureau_etude','contrat_bureau_etude.id= document_moe_scan.id_contrat_bureau_etude')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id", $id_cisco)
                        ->where("document_moe_scan.validation", 1)
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
