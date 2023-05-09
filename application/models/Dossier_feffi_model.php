<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dossier_feffi_model extends CI_Model {
    protected $table = 'dossier_feffi';

    public function add($dossier_feffi) {
        $this->db->set($this->_set($dossier_feffi))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $dossier_feffi) {
        $this->db->set($this->_set($dossier_feffi))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($dossier_feffi) {
        return array(
            'code'   =>      $dossier_feffi['code'],
            'intitule'   =>      $dossier_feffi['intitule'],
            'fichier'   =>      $dossier_feffi['fichier'],
            'observation'   =>      $dossier_feffi['observation'],
            'date_elaboration'   =>      $dossier_feffi['date_elaboration'],
            'id_convention_entete'    =>  $dossier_feffi['id_convention_entete']                       
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
                        ->order_by('code')
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

    public function findAllByconvention($id_convention_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
                        ->order_by('code')
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
