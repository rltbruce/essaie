<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type_mobilier_model extends CI_Model {
    protected $table = 'type_mobilier';

    public function add($type_mobilier) {
        $this->db->set($this->_set($type_mobilier))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $type_mobilier) {
        $this->db->set($this->_set($type_mobilier))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($type_mobilier) {
        return array(
            'code'       =>      $type_mobilier['code'],
            'libelle'       =>      $type_mobilier['libelle'],
            'description'   =>      $type_mobilier['description'],
            'nbr_table_banc'       =>      $type_mobilier['nbr_table_banc'],
            'nbr_table_maitre'       =>      $type_mobilier['nbr_table_maitre'],
            'nbr_chaise_maitre'       =>      $type_mobilier['nbr_chaise_maitre'],
            'cout_mobilier'   =>      $type_mobilier['cout_mobilier'],
            'id_acces_zone' => $type_mobilier['id_acces_zone'],
            'id_zone_subvention' => $type_mobilier['id_zone_subvention']                        
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
