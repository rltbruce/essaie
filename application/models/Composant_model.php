<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Composant_model extends CI_Model {
    protected $table = 'composant';

    public function add($composant) {
        $this->db->set($this->_set($composant))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $composant) {
        $this->db->set($this->_set($composant))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($composant) {
        return array(
            'cout_maitrise_oeuvre' => $composant['cout_maitrise_oeuvre'],
            'cout_sous_projet' =>    $composant['cout_sous_projet'],
            'id_zone_subvention' => $composant['id_zone_subvention'],
            'id_acces_zone' => $composant['id_acces_zone']);
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
                        ->order_by('id_zone_subvention')
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

    public function findByAcceszone_zonesubvention($id_acces_zone,$id_zone_subvention) {               
        $this->db->where("id_acces_zone", $id_acces_zone)
        ->where("id_zone_subvention", $id_zone_subvention);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }                
    }
   /* public function findByAcceszone_zonesubvention($id_acces_zone,$id_zone_subvention) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_acces_zone",$id_acces_zone)
                        ->where("id_zone_subvention",$id_zone_subvention)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }  */

}
