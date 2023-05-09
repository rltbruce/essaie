<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Justificatif_debut_travaux_pr_model extends CI_Model {
    protected $table = 'justificatif_debut_travaux_pr';

    public function add($justificatif_debut_travaux_pr) {
        $this->db->set($this->_set($justificatif_debut_travaux_pr))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $justificatif_debut_travaux_pr) {
        $this->db->set($this->_set($justificatif_debut_travaux_pr))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($justificatif_debut_travaux_pr) {
        return array(
            'description'   =>      $justificatif_debut_travaux_pr['description'],
            'fichier'   =>      $justificatif_debut_travaux_pr['fichier'],
            'id_demande_debut_travaux_pr'    =>  $justificatif_debut_travaux_pr['id_demande_debut_travaux_pr']                       
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
                        ->order_by('description')
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

    public function findAllBydemande($id_demande_debut_travaux_pr) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_debut_travaux_pr", $id_demande_debut_travaux_pr)
                        ->order_by('description')
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
