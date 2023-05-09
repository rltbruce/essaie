<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zap_commune_model extends CI_Model {
    protected $table = 'zap_commune';

    public function add($zap) {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($zap))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $zap) {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($zap))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($zap) {
		// Affectation des valeurs
        return array(
            'id_zap'        =>  $zap['id_zap'],
            'id_commune' =>  $zap['id_commune']                       
        );
    }
    public function delete($id) {
		// Suppression d'un enregitrement
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {
		// Selection de tous les enregitrements
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('id_zap')
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
    public function findAllByCommune($id_commune) {
        // Selection de tous les enregitrements
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_commune',$id_commune)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findzapByCommune($id_commune) {
        // Selection de tous les enregitrements
        $result =  $this->db->select('zap.*')
                        ->from($this->table)
                        ->join('zap','zap_commune.id_zap=zap.id')
                        ->where('id_commune',$id_commune)
                        ->group_by('zap.id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    
    public function getzap_communetest($id_zap,$id_commune) {               
        $result =  $this->db->select('zap_commune.*')
                        ->from($this->table)
                        ->join('commune','commune.id=zap_commune.id_commune')
                        ->join('zap','zap.id=zap_commune.id_zap')
                        ->where('commune.id',$id_commune)
                        ->where("zap.id", $id_zap)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }
    public function getzap_communetestnom($zap,$id_commune) {               
        $result =  $this->db->select('zap.*')
                        ->from($this->table)
                        ->join('commune','commune.id=zap_commune.id_commune')
                        ->join('zap','zap.id=zap_commune.id_zap')
                        ->where('commune.id',$id_commune)
                        ->where("zap.nom", $zap)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }
    public function getzapbyzapcisco($zap,$cisco) {               
        $result =  $this->db->select('zap.*')
                        ->from($this->table)
                        ->join('zap','zap.id=zap_commune.id_zap')
                        ->join('commune','commune.id=zap_commune.id_commune')
                        ->join('district','district.id=commune.id_district')
                        ->join('cisco','cisco.id_district=district.id')
                        ->where("lower(zap.nom)", $zap)
                        ->where("lower(cisco.description)", $cisco)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }
}
?>