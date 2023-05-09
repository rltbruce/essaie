<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avancement_batiment_doc_model extends CI_Model {
    protected $table = 'avancement_batiment_doc';

    public function add($avancement_batiment_doc) {
        $this->db->set($this->_set($avancement_batiment_doc))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $avancement_batiment_doc) {
        $this->db->set($this->_set($avancement_batiment_doc))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($avancement_batiment_doc) {
        return array(
            'description'   =>      $avancement_batiment_doc['description'],
            'fichier'   =>      $avancement_batiment_doc['fichier'],
            'id_avancement_batiment'    =>  $avancement_batiment_doc['id_avancement_batiment']                       
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

    public function findAllBydemande($id_avancement_batiment) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_avancement_batiment", $id_avancement_batiment)
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
