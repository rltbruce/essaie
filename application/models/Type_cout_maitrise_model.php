<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type_cout_maitrise_model extends CI_Model {
    protected $table = 'type_cout_maitrise';

    public function add($type_cout_maitrise) {
        $this->db->set($this->_set($type_cout_maitrise))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $type_cout_maitrise) {
        $this->db->set($this->_set($type_cout_maitrise))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($type_cout_maitrise) {
        return array(
            'code'   =>      $type_cout_maitrise['code'],
            'libelle'       =>      $type_cout_maitrise['libelle'],
            'description'   =>      $type_cout_maitrise['description'],
            'cout_maitrise' =>      $type_cout_maitrise['cout_maitrise'],
            'id_acces_zone' => $type_cout_maitrise['id_acces_zone'],
            'id_zone_subvention' => $type_cout_maitrise['id_zone_subvention']                       
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
