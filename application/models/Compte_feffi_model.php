<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Compte_feffi_model extends CI_Model {
    protected $table = 'compte_feffi';

    public function add($compte_feffi) {
        $this->db->set($this->_set($compte_feffi))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $compte_feffi) {
        $this->db->set($this->_set($compte_feffi))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($compte_feffi) {
        return array(
            'rib'          =>      $compte_feffi['rib'],
            'nom_banque'          =>      $compte_feffi['nom_banque'],
            'numero_compte'           =>      $compte_feffi['numero_compte'],
            'adresse_banque'          =>      $compte_feffi['adresse_banque'],
            //'id_membre_feffi'           =>      $compte_feffi['id_membre_feffi'],
            'id_feffi'     =>      $compte_feffi['id_feffi'] ,
            'intitule'     =>      $compte_feffi['intitule']                      
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
                        ->order_by('nom_banque')
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
   /* public function findByIdecole($id)  {
        $this->db->select("ecole.description")
        ->join("ecole", 'ecole.id=feffi.id_ecole')
        ->where("feffi.id", $id);
        $q = $this->db->get('feffi');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }*/

    public function findByfeffi($id_feffi) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_feffi',$id_feffi)
                        ->order_by('nom_banque')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findByfeffiobjet($id_feffi)  {
        $this->db->where('id_feffi',$id_feffi);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

}
