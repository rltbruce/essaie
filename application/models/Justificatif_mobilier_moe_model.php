<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Justificatif_mobilier_moe_model extends CI_Model {
    protected $table = 'justificatif_mobilier_moe';

    public function add($justificatif_mobilier_moe) {
        $this->db->set($this->_set($justificatif_mobilier_moe))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $justificatif_mobilier_moe) {
        $this->db->set($this->_set($justificatif_mobilier_moe))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($justificatif_mobilier_moe) {
        return array(
            'description'   =>      $justificatif_mobilier_moe['description'],
            'fichier'   =>      $justificatif_mobilier_moe['fichier'],
            'id_demande_mobilier_moe'    =>  $justificatif_mobilier_moe['id_demande_mobilier_moe']                       
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

    public function findAllBydemande($id_demande_mobilier_moe) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_mobilier_moe", $id_demande_mobilier_moe)
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
