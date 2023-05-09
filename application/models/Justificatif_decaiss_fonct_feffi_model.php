<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Justificatif_decaiss_fonct_feffi_model extends CI_Model {
    protected $table = 'justificatif_decaiss_fonct_feffi';

    public function add($justificatif_decaiss_fonct_feffi) {
        $this->db->set($this->_set($justificatif_decaiss_fonct_feffi))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $justificatif_decaiss_fonct_feffi) {
        $this->db->set($this->_set($justificatif_decaiss_fonct_feffi))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($justificatif_decaiss_fonct_feffi) {
        return array(
            'description'   =>      $justificatif_decaiss_fonct_feffi['description'],
            'fichier'   =>      $justificatif_decaiss_fonct_feffi['fichier'],
            'id_decaiss_fonct_feffi'    =>  $justificatif_decaiss_fonct_feffi['id_decaiss_fonct_feffi']                       
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

    public function findAllBytransfert($id_decaiss_fonct_feffi) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_decaiss_fonct_feffi", $id_decaiss_fonct_feffi)
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
