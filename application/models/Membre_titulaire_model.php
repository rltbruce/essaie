<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Membre_titulaire_model extends CI_Model {
    protected $table = 'membre_titulaire';

    public function add($membre_titulaire) {
        $this->db->set($this->_set($membre_titulaire))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $membre_titulaire) {
        $this->db->set($this->_set($membre_titulaire))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($membre_titulaire) {
        return array(
            'id_membre'   => $membre_titulaire['id_membre'],
            'id_compte'    => $membre_titulaire['id_compte']                       
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
                        ->order_by('id')
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

    public function findBycompte($id_compte) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_compte", $id_compte)
                        ->order_by('id')
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
