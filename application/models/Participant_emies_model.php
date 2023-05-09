<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Participant_emies_model extends CI_Model {
    protected $table = 'participant_emies';

    public function add($participant_emies) {
        $this->db->set($this->_set($participant_emies))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $participant_emies) {
        $this->db->set($this->_set($participant_emies))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($participant_emies) {
        return array(
            'nom'       =>      $participant_emies['nom'],
            'prenom'   =>      $participant_emies['prenom'],
            'sexe'   =>      $participant_emies['sexe'],
            'id_situation_participant_emies'   => $participant_emies['id_situation_participant_emies'],
            'id_module_emies'    => $participant_emies['id_module_emies']                       
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
                        ->order_by('nom')
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

    public function findBymodule_emies($id_module_emies) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_module_emies", $id_module_emies)
                        ->order_by('nom')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function Count_participantbyId($id) 
    {
        $this->db->select('count(DISTINCT(id)) as nbr_participant')
        ->where("id_module_emies", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    public function Count_femininbyId($id) 
    {
        $this->db->select('count(DISTINCT(id)) as nbr_feminin')
        ->where("id_module_emies", $id)
        ->where("sexe", 2);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    public function getparticipantBymodulefonction($id_module_emies,$id_fonction) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_module_emies", $id_module_emies)
                        ->where("id_situation_participant_emies", $id_fonction)
                        ->order_by('nom')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return $result=array();
        }                 
    }
}
