<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Designation_infrastructure_model extends CI_Model {
    protected $table = 'designation_infrastructure';

    public function add($designation_infrastructure) {
        $this->db->set($this->_set($designation_infrastructure))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $designation_infrastructure) {
        $this->db->set($this->_set($designation_infrastructure))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($designation_infrastructure) {
        return array(
            'designation'       =>      $designation_infrastructure['designation'],
            'description'   =>      $designation_infrastructure['description'],
            'id_infrastructure'    => $designation_infrastructure['id_infrastructure']                       
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

    public function findByinfrastructure($id_infrastructure) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_infrastructure", $id_infrastructure)
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
