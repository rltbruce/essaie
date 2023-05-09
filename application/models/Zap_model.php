<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zap_model extends CI_Model {
    protected $table = 'zap';

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
            'code'       =>  $zap['code'],
            'nom'        =>  $zap['nom']                      
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
                        ->order_by('nom')
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


   /* public function getzapbynom($nom) {
        $requete="select * from zap
         where lower(nom)=".$nom."";
        $query = $this->db->query($requete)->result();
        //return $query->result(); 

        if($query) {
            return $query;
        }else{
            return null;
        }               
    }*/
    public function getzapbynom($nom) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("lower(nom)=", $nom)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }

    public function getcommunebynom($nom) {               
        $result =  $this->db->select('*')
                        ->from('commune')
                        ->where("lower(nom)=", $nom)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }

    public function getdistrictbynom($nom) {               
        $result =  $this->db->select('*')
                        ->from('district')
                        ->where("lower(nom)=", $nom)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }

    public function getdistricttest($nom) {               
        $result =  $this->db->select('*')
                        ->from('district')
                        ->where("lower(nom)=", $nom)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }

    public function getzapbycommune($nom) {               
        $result =  $this->db->select('*')
                        ->from('commune')
                        ->where("lower(nom)=", $nom)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }

    public function getzap_commune_districtbyid($id_zap, $id_commune,$id_district) {               
        $result =  $this->db->select('zap_commune.*')
                        ->from('zap_commune')
                        ->join('commune','commune.id=zap_commune.id_commune')
                        ->join('district','district.id=commune.id_district')
                        ->where("id_zap", $id_zap)
                        ->where("id_commune", $id_commune)
                        ->where("district.id", $id_district)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }
    public function getzaptest($nom) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("lower(nom)=", $nom)
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