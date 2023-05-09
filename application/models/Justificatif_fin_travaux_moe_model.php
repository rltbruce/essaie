<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Justificatif_fin_travaux_moe_model extends CI_Model {
    protected $table = 'justificatif_fin_travaux_moe';

    public function add($justificatif_fin_travaux_moe) {
        $this->db->set($this->_set($justificatif_fin_travaux_moe))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $justificatif_fin_travaux_moe) {
        $this->db->set($this->_set($justificatif_fin_travaux_moe))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($justificatif_fin_travaux_moe) {
        return array(
            'description'   =>      $justificatif_fin_travaux_moe['description'],
            'fichier'   =>      $justificatif_fin_travaux_moe['fichier'],
            'id_demande_fin_travaux_moe'    =>  $justificatif_fin_travaux_moe['id_demande_fin_travaux_moe']                       
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

    public function findAllBydemande($id_demande_fin_travaux_moe) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_fin_travaux_moe", $id_demande_fin_travaux_moe)
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
