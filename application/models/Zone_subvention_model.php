<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zone_subvention_model extends CI_Model {
    protected $table = 'zone_subvention';

    public function add($zone_subvention) {
        $this->db->set($this->_set($zone_subvention))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $zone_subvention) {
        $this->db->set($this->_set($zone_subvention))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($zone_subvention) {
        return array(
            'libelle'       =>      $zone_subvention['libelle'],
            'description'   =>      $zone_subvention['description']                       
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
    public function getzone_subventionbynom($libelle) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('libelle',$libelle)
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
