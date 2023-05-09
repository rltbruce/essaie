<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Participant_pmc_model extends CI_Model {
    protected $table = 'participant_pmc';

    public function add($participant_pmc) {
        $this->db->set($this->_set($participant_pmc))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $participant_pmc) {
        $this->db->set($this->_set($participant_pmc))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($participant_pmc) {
        return array(
            'nom'       =>      $participant_pmc['nom'],
            'prenom'   =>      $participant_pmc['prenom'],
            'sexe'   =>      $participant_pmc['sexe'],
            'id_situation_participant_pmc'   => $participant_pmc['id_situation_participant_pmc'],
            'id_module_pmc'    => $participant_pmc['id_module_pmc']                       
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

    public function findBymodule_pmc($id_module_pmc) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_module_pmc", $id_module_pmc)
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
        ->where("id_module_pmc", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    public function Count_femininbyId($id) 
    {
        $this->db->select('count(DISTINCT(id)) as nbr_feminin')
        ->where("id_module_pmc", $id)
        ->where("sexe", 2);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    public function getparticipantBymodulefonction($id_module_pmc,$id_fonction) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_module_pmc", $id_module_pmc)
                        ->where("id_situation_participant_pmc", $id_fonction)
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
