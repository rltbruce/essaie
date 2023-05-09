<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Piece_justificatif_frais_fonction_feffi_prevu_model extends CI_Model {
    protected $table = 'Piece_justificatif_frais_fonction_feffi_prevu';

    public function add($Piece_justificatif_frais_fonction_feffi_prevu) {
        $this->db->set($this->_set($Piece_justificatif_frais_fonction_feffi_prevu))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $Piece_justificatif_frais_fonction_feffi_prevu) {
        $this->db->set($this->_set($Piece_justificatif_frais_fonction_feffi_prevu))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($Piece_justificatif_frais_fonction_feffi_prevu) {
        return array(
            'code'       =>      $Piece_justificatif_frais_fonction_feffi_prevu['code'],
            'intitule'   =>      $Piece_justificatif_frais_fonction_feffi_prevu['intitule']                       
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
                        ->order_by('intitule')
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

}
