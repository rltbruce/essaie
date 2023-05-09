<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type_latrine_model extends CI_Model {
    protected $table = 'type_latrine';

    public function add($type_latrine) {
        $this->db->set($this->_set($type_latrine))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $type_latrine) {
        $this->db->set($this->_set($type_latrine))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($type_latrine) {
        return array(
            'code'       =>      $type_latrine['code'],
            'libelle'       =>      $type_latrine['libelle'],
            'description'   =>      $type_latrine['description'],
            'nbr_box_latrine'       =>      $type_latrine['nbr_box_latrine'],
            'nbr_point_eau'       =>      $type_latrine['nbr_point_eau'],
            'cout_latrine'   =>      $type_latrine['cout_latrine'],
            'id_acces_zone' => $type_latrine['id_acces_zone'],
            'id_zone_subvention' => $type_latrine['id_zone_subvention']                       
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

    public function findByZone($id_zone_subvention,$id_acces_zone)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_zone_subvention',$id_zone_subvention)
                        ->where('id_acces_zone',$id_acces_zone)
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
}
