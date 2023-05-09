<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Detail_subvention_model extends CI_Model {
    protected $table = 'detail_subvention';

    public function add($detail_subvention) {
        $this->db->set($this->_set($detail_subvention))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $detail_subvention) {
        $this->db->set($this->_set($detail_subvention))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($detail_subvention) {
        return array(
            'id_acces_zone'     => $detail_subvention['id_acces_zone'],
            'id_zone_subvention' => $detail_subvention['id_zone_subvention'],
            'id_detail_ouvrage' => $detail_subvention['id_detail_ouvrage'],
            'cout_maitrise_oeuvre' => $detail_subvention['cout_maitrise_oeuvre'],
            'cout_batiment'     => $detail_subvention['cout_batiment'],
            'cout_latrine'      => $detail_subvention['cout_latrine'],
            'cout_mobilier'     => $detail_subvention['cout_mobilier'],
            'cout_sousprojet'   => $detail_subvention['cout_sousprojet']                       
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
                        ->order_by('cout_batiment')
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
