<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Situation_participant_dpp_model extends CI_Model {
    protected $table = 'situation_participant_dpp';

    public function add($situation_participant_dpp) {
        $this->db->set($this->_set($situation_participant_dpp))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $situation_participant_dpp) {
        $this->db->set($this->_set($situation_participant_dpp))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($situation_participant_dpp) {
        return array(
            'libelle'       =>      $situation_participant_dpp['libelle'],
            'description'   =>      $situation_participant_dpp['description']                       
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
        $requete="select * from situation_participant_dpp where lower(libelle)='".$libelle."'";
        $query = $this->db->query($requete);
        return $query->result();                
    }




}
