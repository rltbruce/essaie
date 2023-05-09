<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Convention_ufp_daaf_detail_model extends CI_Model {
    protected $table = 'convention_ufp_daaf_detail';

    public function add($convention_ufp_daaf_detail) {
        $this->db->set($this->_set($convention_ufp_daaf_detail))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $convention_ufp_daaf_detail) {
        $this->db->set($this->_set($convention_ufp_daaf_detail))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($convention_ufp_daaf_detail) {
        return array(
            'id_convention_ufp_daaf_entete'=> $convention_ufp_daaf_detail['id_convention_ufp_daaf_entete'],            
            'date_signature' => $convention_ufp_daaf_detail['date_signature'],
            'delai' => $convention_ufp_daaf_detail['delai'],
            'observation' => $convention_ufp_daaf_detail['observation'],
            'id_compte_daaf' => $convention_ufp_daaf_detail['id_compte_daaf'] );
                   
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

    public function findAllByEntete($id_convention_ufp_daaf_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_ufp_daaf_entete",$id_convention_ufp_daaf_entete)
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
        public function findByIdligne($id_convention_ufp_daaf_entete)  {
        $this->db->select('convention_ufp_daaf_detail.delai as delai,convention_ufp_daaf_detail.id_convention_ufp_daaf_entete as id_convention_ufp_daaf_entete, convention_ufp_daaf_detail.date_signature as date_signature,convention_ufp_daaf_detail.observation as observation, compte_daaf.compte as compte,compte_daaf.intitule as intitule, compte_daaf.agence as agence')
        ->join('compte_daaf','compte_daaf.id=convention_ufp_daaf_detail.id_compte_daaf')
        ->where("id_convention_ufp_daaf_entete", $id_convention_ufp_daaf_entete);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

}
