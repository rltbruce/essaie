<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Justificatif_pv_consta_entete_travaux_mpe_model extends CI_Model {
    protected $table = 'justificatif_pv_consta_entete_travaux_mpe';

    public function add($justificatif_pv_consta_entete_travaux_mpe) {
        $this->db->set($this->_set($justificatif_pv_consta_entete_travaux_mpe))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $justificatif_pv_consta_entete_travaux_mpe) {
        $this->db->set($this->_set($justificatif_pv_consta_entete_travaux_mpe))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($justificatif_pv_consta_entete_travaux_mpe) {
        return array(
            'description'   =>      $justificatif_pv_consta_entete_travaux_mpe['description'],
            'fichier'   =>      $justificatif_pv_consta_entete_travaux_mpe['fichier'],
            'id_pv_consta_entete_travaux'    =>  $justificatif_pv_consta_entete_travaux_mpe['id_pv_consta_entete_travaux']                       
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

    public function findAllBydemande($id_pv_consta_entete_travaux) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_pv_consta_entete_travaux", $id_pv_consta_entete_travaux)
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
