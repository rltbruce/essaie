<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Participant_gfpc_model extends CI_Model {
    protected $table = 'participant_gfpc';

    public function add($participant_gfpc) {
        $this->db->set($this->_set($participant_gfpc))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $participant_gfpc) {
        $this->db->set($this->_set($participant_gfpc))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($participant_gfpc) {
        return array(
            'nom'       =>      $participant_gfpc['nom'],
            'prenom'   =>      $participant_gfpc['prenom'],
            'sexe'   =>      $participant_gfpc['sexe'],
            'id_situation_participant_gfpc'   => $participant_gfpc['id_situation_participant_gfpc'],
            'id_module_gfpc'    => $participant_gfpc['id_module_gfpc']                       
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

    public function findBymodule_gfpc($id_module_gfpc) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_module_gfpc", $id_module_gfpc)
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
        ->where("id_module_gfpc", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    public function Count_femininbyId($id) 
    {
        $this->db->select('count(DISTINCT(id)) as nbr_feminin')
        ->where("id_module_gfpc", $id)
        ->where("sexe", 2);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    public function getparticipantBymodulefonction($id_module_gfpc,$id_fonction) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_module_gfpc", $id_module_gfpc)
                        ->where("id_situation_participant_gfpc", $id_fonction)
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
