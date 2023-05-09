<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rapport_mensuel_model extends CI_Model {
    protected $table = 'rapport_mensuel';

    public function add($rapport_mensuel) {
        $this->db->set($this->_set($rapport_mensuel))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $rapport_mensuel) {
        $this->db->set($this->_set($rapport_mensuel))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($rapport_mensuel) {
        return array(
            'description'   =>      $rapport_mensuel['description'],
            'numero'   =>      $rapport_mensuel['numero'],
            'date_livraison'    =>  $rapport_mensuel['date_livraison'],
            'observation'   =>      $rapport_mensuel['observation'],
            'id_contrat_bureau_etude'    =>  $rapport_mensuel['id_contrat_bureau_etude'],
            'validation'    =>  $rapport_mensuel['validation']                       
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
                        ->order_by('date_livraison')
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
    function findrapportBycontrat($id_contrat_bureau_etude) {               
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
    function getrapportvalideById($id_rapport_mensuel) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_rapport_mensuel)
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
    function findrapportvalideBycontrat($id_contrat_bureau_etude) {               
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
    function findrapportinvalideBycontrat($id_contrat_bureau_etude) {               
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

     function getrapport_mensuel1Bycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("numero",1)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return $result=array();
        }                 
    }
     function getrapport_mensuel2Bycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("numero",2)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return $result=array();
        }                 
    }
     function getrapport_mensuel3Bycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("numero",3)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return $result=array();
        }                 
    }
     function getrapport_mensuel4Bycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("numero",4)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return $result=array();
        }                 
    }

 /*   public function findAllBycontrat($id_contrat_bureau_etude,$validation) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("validation", $validation)
                        ->order_by('date_livraison')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    } */
   /* public function findAllByvalidation($validation)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", $validation)
                        ->order_by('date_livraison')
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
        $result =  $this->db->select('rapport_mensuel.*')
                        ->from($this->table)
                        ->join('contrat_bureau_etude','contrat_bureau_etude.id= rapport_mensuel.id_contrat_bureau_etude')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id", $id_cisco)
                        ->where("rapport_mensuel.validation", $validation)
                        ->order_by('date_livraison')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
        public function getrapport_mensuelBycontrat($id_contrat_bureau_etude,$validation) {               
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
