<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type_batiment_model extends CI_Model {
    protected $table = 'type_batiment';

    public function add($type_batiment) {
        $this->db->set($this->_set($type_batiment))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $type_batiment) {
        $this->db->set($this->_set($type_batiment))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($type_batiment) {
        return array(
            'code'   =>      $type_batiment['code'],
            'libelle'       =>      $type_batiment['libelle'],
            'description'   =>      $type_batiment['description'],
            'nbr_salle'   =>      $type_batiment['nbr_salle'],
            'cout_batiment' =>      $type_batiment['cout_batiment'],
            'id_acces_zone' => $type_batiment['id_acces_zone'],
            'id_zone_subvention' => $type_batiment['id_zone_subvention']                       
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
                        ->order_by('libelle')
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
