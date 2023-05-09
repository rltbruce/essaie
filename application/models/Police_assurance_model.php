<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Police_assurance_model extends CI_Model {
    protected $table = 'police_assurance';

    public function add($police_assurance) {
        $this->db->set($this->_set($police_assurance))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $police_assurance) {
        $this->db->set($this->_set($police_assurance))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($police_assurance) {
        return array(
            'description'   =>      $police_assurance['description'],
            //'fichier'   =>      $police_assurance['fichier'],
            'date_expiration'    =>  $police_assurance['date_expiration'],
            'observation'   =>      $police_assurance['observation'],
            'id_contrat_bureau_etude'    =>  $police_assurance['id_contrat_bureau_etude'],
            'validation'    =>  $police_assurance['validation']                       
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
                        ->order_by('date_expiration')
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
    function findpoliceBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
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
    function findpolicevalideBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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
    function findpolicevalideById($id_police_assurance_moe) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_police_assurance_moe)
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
    function findpoliceinvalideBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("validation", 0)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

     function getpolice_assuranceBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return $result=array();
        }                 
    }
   /* public function findAllBycontrat($id_contrat_bureau_etude,$validation) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("validation", $validation)
                        ->order_by('date_expiration')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/ 
      /*  public function findAllByvalidation($validation) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", $validation)
                        ->order_by('date_expiration')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
        public function findAllvalidationBycisco($validation,$id_cisco)
    {               
        $result =  $this->db->select('police_assurance.*')
                        ->from($this->table)
                        ->join('contrat_bureau_etude','contrat_bureau_etude.id= police_assurance.id_contrat_bureau_etude')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id", $id_cisco)
                        ->where("police_assurance.validation", $validation)
                        ->order_by('date_expiration')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

        public function getpolice_assuranceBycontrat($id_contrat_bureau_etude,$validation) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("validation", $validation)
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
