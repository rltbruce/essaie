<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Participant_sep_model extends CI_Model {
    protected $table = 'participant_sep';

    public function add($participant_sep) {
        $this->db->set($this->_set($participant_sep))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $participant_sep) {
        $this->db->set($this->_set($participant_sep))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($participant_sep) {
        return array(
            'nom'       =>      $participant_sep['nom'],
            'prenom'   =>      $participant_sep['prenom'],
            'sexe'   =>      $participant_sep['sexe'],
            'id_situation_participant_sep'   => $participant_sep['id_situation_participant_sep'],
            'id_module_sep'    => $participant_sep['id_module_sep']                       
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

    public function findBymodule_sep($id_module_sep) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_module_sep", $id_module_sep)
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
        ->where("id_module_sep", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    public function Count_femininbyId($id) 
    {
        $this->db->select('count(DISTINCT(id)) as nbr_feminin')
        ->where("id_module_sep", $id)
        ->where("sexe", 2);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    public function getparticipantBymodulefonction($id_module_sep,$id_fonction) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_module_sep", $id_module_sep)
                        ->where("id_situation_participant_sep", $id_fonction)
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
