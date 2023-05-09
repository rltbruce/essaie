<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avancement_latrine_doc_model extends CI_Model {
    protected $table = 'avancement_latrine_doc';

    public function add($avancement_latrine_doc) {
        $this->db->set($this->_set($avancement_latrine_doc))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $avancement_latrine_doc) {
        $this->db->set($this->_set($avancement_latrine_doc))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($avancement_latrine_doc) {
        return array(
            'description'   =>      $avancement_latrine_doc['description'],
            'fichier'   =>      $avancement_latrine_doc['fichier'],
            'id_avancement_latrine'    =>  $avancement_latrine_doc['id_avancement_latrine']                       
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

    public function findAllBydemande($id_avancement_latrine) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_avancement_latrine", $id_avancement_latrine)
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
