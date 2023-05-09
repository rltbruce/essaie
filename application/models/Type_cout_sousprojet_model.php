<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type_cout_sousprojet_model extends CI_Model {
    protected $table = 'type_cout_sousprojet';

    public function add($type_cout_sousprojet) {
        $this->db->set($this->_set($type_cout_sousprojet))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $type_cout_sousprojet) {
        $this->db->set($this->_set($type_cout_sousprojet))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($type_cout_sousprojet) {
        return array(
            'code'   =>      $type_cout_sousprojet['code'],
            'libelle'       =>      $type_cout_sousprojet['libelle'],
            'description'   =>      $type_cout_sousprojet['description'],
            'cout_sousprojet' =>      $type_cout_sousprojet['cout_sousprojet'],
            'id_acces_zone' => $type_cout_sousprojet['id_acces_zone'],
            'id_zone_subvention' => $type_cout_sousprojet['id_zone_subvention']                       
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
