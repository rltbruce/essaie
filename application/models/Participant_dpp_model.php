<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Participant_dpp_model extends CI_Model {
    protected $table = 'participant_dpp';

    public function add($participant_dpp) {
        $this->db->set($this->_set($participant_dpp))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $participant_dpp) {
        $this->db->set($this->_set($participant_dpp))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($participant_dpp) {
        return array(
            'nom'       =>      $participant_dpp['nom'],
            'prenom'   =>      $participant_dpp['prenom'],
            'sexe'   =>      $participant_dpp['sexe'],
            'id_situation_participant_dpp'   => $participant_dpp['id_situation_participant_dpp'],
            'id_module_dpp'    => $participant_dpp['id_module_dpp']                       
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

    public function findBymodule_dpp($id_module_dpp) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_module_dpp", $id_module_dpp)
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
        ->where("id_module_dpp", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    public function Count_femininbyId($id) 
    {
        $this->db->select('count(DISTINCT(id)) as nbr_feminin')
        ->where("id_module_dpp", $id)
        ->where("sexe", 2);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    public function getparticipantBymodulefonction($id_module_dpp,$id_fonction) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_module_dpp", $id_module_dpp)
                        ->where("id_situation_participant_dpp", $id_fonction)
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
