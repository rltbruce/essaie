<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Situation_participant_sep_model extends CI_Model {
    protected $table = 'situation_participant_sep';

    public function add($situation_participant_sep) {
        $this->db->set($this->_set($situation_participant_sep))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $situation_participant_sep) {
        $this->db->set($this->_set($situation_participant_sep))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($situation_participant_sep) {
        return array(
            'libelle'       =>      $situation_participant_sep['libelle'],
            'description'   =>      $situation_participant_sep['description']                       
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


    public function findByFonction($libelle) {
        $requete="select * from situation_participant_sep where lower(libelle)='".$libelle."'";
        $query = $this->db->query($requete);
        return $query->result();                
    }


}
