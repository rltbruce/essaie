<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Addition_frais_fonctionnement_model extends CI_Model {
    protected $table = 'addition_frais_fonctionnement';

    public function add($addition_frais_fonctionnement) {
        $this->db->set($this->_set($addition_frais_fonctionnement))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $addition_frais_fonctionnement) {
        $this->db->set($this->_set($addition_frais_fonctionnement))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($addition_frais_fonctionnement) {
        return array(

            'observation' => $addition_frais_fonctionnement['observation'],
            'montant'   => $addition_frais_fonctionnement['montant'],
            'validation' => $addition_frais_fonctionnement['validation'],
            'id_rubrique_addition' => $addition_frais_fonctionnement['id_rubrique_addition'] ,
            'id_convention_entete' => $addition_frais_fonctionnement['id_convention_entete']                      
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

    public function getaddition_frais_fonctionnementById($id_addition) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_addition)
                        ->where("validation",1)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function getaddition_invalideByconvention($id_convention_entete) {               
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
    public function getaddition_valideByconvention($id_convention_entete) {               
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

}
