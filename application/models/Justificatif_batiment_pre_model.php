<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Justificatif_batiment_pre_model extends CI_Model {
    protected $table = 'justificatif_batiment_pre';

    public function add($justificatif_batiment_pre) {
        $this->db->set($this->_set($justificatif_batiment_pre))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $justificatif_batiment_pre) {
        $this->db->set($this->_set($justificatif_batiment_pre))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($justificatif_batiment_pre) {
        return array(
            'description'   =>      $justificatif_batiment_pre['description'],
            'fichier'   =>      $justificatif_batiment_pre['fichier'],
            'id_demande_pay_pre'    =>  $justificatif_batiment_pre['id_demande_pay_pre']                       
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

    public function findAllBydemande($id_demande_pay_pre) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_pay_pre", $id_demande_pay_pre)
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
