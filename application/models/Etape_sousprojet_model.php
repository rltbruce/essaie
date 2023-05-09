<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Etape_sousprojet_model extends CI_Model {
    protected $table = 'etape_sousprojet';

    public function add($etape_sousprojet) {
        $this->db->set($this->_set($etape_sousprojet))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $etape_sousprojet) {
        $this->db->set($this->_set($etape_sousprojet))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($etape_sousprojet) {
        return array(
            'code'      =>  $etape_sousprojet['code'],
            'libelle'      =>  $etape_sousprojet['libelle'],
            'description'  =>  $etape_sousprojet['description']                       
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
                        ->order_by('code')
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

}
