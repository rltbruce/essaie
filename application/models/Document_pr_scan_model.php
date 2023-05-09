<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document_pr_scan_model extends CI_Model {
    protected $table = 'document_pr_scan';

    public function add($document_pr_scan) {
        $this->db->set($this->_set($document_pr_scan))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $document_pr_scan) {
        $this->db->set($this->_set($document_pr_scan))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($document_pr_scan) {
        return array(
            'fichier'   =>      $document_pr_scan['fichier'],
            'date_elaboration'   =>      $document_pr_scan['date_elaboration'],
            'observation'   =>      $document_pr_scan['observation'],
            'id_contrat_partenaire_relai'    =>  $document_pr_scan['id_contrat_partenaire_relai'],
            'id_document_pr'    =>  $document_pr_scan['id_document_pr'],
            'validation'    =>  $document_pr_scan['validation'],
            //'id_convention_entete'    =>  $document_pr_scan['id_convention_entete'],                       
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

    public function getdocumentBycontratdossier_prevu($id_document_pr,$id_contrat_partenaire_relai)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table) 
                        ->where("id_document_pr", $id_document_pr)
                        ->where("id_contrat_partenaire_relai", $id_contrat_partenaire_relai)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function getdocumentvalideById($id_document_pr_scan)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table) 
                        ->where("id", $id_document_pr_scan)
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

}
