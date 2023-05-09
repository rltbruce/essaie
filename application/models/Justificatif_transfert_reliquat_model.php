<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Justificatif_transfert_reliquat_model extends CI_Model {
    protected $table = 'justificatif_transfert_reliquat';

    public function add($justificatif_transfert_reliquat) {
        $this->db->set($this->_set($justificatif_transfert_reliquat))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $justificatif_transfert_reliquat) {
        $this->db->set($this->_set($justificatif_transfert_reliquat))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($justificatif_transfert_reliquat) {
        return array(
            'description'   =>      $justificatif_transfert_reliquat['description'],
            'fichier'   =>      $justificatif_transfert_reliquat['fichier'],
            'id_transfert_reliquat'    =>  $justificatif_transfert_reliquat['id_transfert_reliquat']                       
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

    public function findAllBytransfert($id_transfert_reliquat) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_transfert_reliquat", $id_transfert_reliquat)
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
