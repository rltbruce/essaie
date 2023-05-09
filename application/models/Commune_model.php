<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Commune_model extends CI_Model {
    protected $table = 'commune';

    public function add($commune) {
        $this->db->set($this->_set($commune))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $commune) {
        $this->db->set($this->_set($commune))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($commune) {
        return array(
            'code'           =>      $commune['code'],
            'nom'            =>      $commune['nom'],
            'id_district'    =>      $commune['id_district']                       
        );
    }
    public function delete($id) {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {
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
    public function findByIdTable($id) {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findBydistrict($id_district) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_district',$id_district)
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
    public function findBycisco($id_cisco) {               
        $result =  $this->db->select('commune.*')
                        ->from($this->table)
                        ->join('district','district.id=commune.id_district')
                        ->join('cisco','cisco.id_district=district.id')
                        ->where('cisco.id',$id_cisco)
                        ->order_by('commune.nom')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findByIdcisco($id_cisco){
        $this->db->select('commune.*')
        ->join('district','district.id=commune.id_district')
                    ->join('cisco','cisco.id_district=district.id')
                    ->where('cisco.id',$id_cisco);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    public function getcommunetest($region,$district,$commune) {               
        $result =  $this->db->select('commune.*')
                        ->from($this->table)
                        ->join('district','district.id=commune.id_district')
                        ->join('region','region.id=district.id_region')
                        ->where('lower(commune.nom)=',$commune)
                        ->where("lower(region.nom)=", $region)
                        ->where("lower(district.nom)=", $district)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }
    public function getcommunetest2($commune) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('lower(commune.nom)=',$commune)
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
