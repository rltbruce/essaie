<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Note_agence_acc_model extends CI_Model {
    protected $table = 'note_agence_acc';

    public function add($note_agence_acc) {
        $this->db->set($this->_set($note_agence_acc))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $note_agence_acc) {
        $this->db->set($this->_set($note_agence_acc))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($note_agence_acc) {
        return array( 

            'annee' =>      $note_agence_acc['annee'],
            'id_agence_acc' =>  $note_agence_acc['id_agence_acc'],
            'observation' =>    $note_agence_acc['observation'],
            'note' =>      $note_agence_acc['note']                     
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
                        ->order_by('id')
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

     public function findnote_agence_accByfiltre($requete) {               
        $result =  $this->db->select('note_agence_acc.*')
                        ->from($this->table)
                        ->join('agence_acc','agence_acc.id=note_agence_acc.id_agence_acc')
                        ->where($requete)
                        ->order_by('agence_acc.nom')
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
