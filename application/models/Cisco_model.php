<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cisco_model extends CI_Model {
    protected $table = 'cisco';

    public function add($cisco) {
        $this->db->set($this->_set($cisco))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $cisco) {
        $this->db->set($this->_set($cisco))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($cisco) {
        return array(
            'code'          =>      $cisco['code'],
            'description'           =>      $cisco['description'],
            'id_district'     =>      $cisco['id_district']                       
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

    public function findBydistrict($id_district) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_district',$id_district)
                        ->order_by('description')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findByregion($id_region) {               
        $result =  $this->db->select('cisco.*')
                        ->from($this->table)
                        ->join('district','district.id=cisco.id_district')
                        ->join('region','region.id=district.id_region')
                        ->where('region.id',$id_region)
                        ->order_by('cisco.description')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findByNom($nom) {
        $requete="select * from cisco where lower(description)='".$nom."'";
        $query = $this->db->query($requete);
        return $query->result();                
    }
    
    public function getciscotest($cisco,$region) {               
        $result =  $this->db->select('cisco.*')
                        ->from($this->table)
                        ->join('district','district.id=cisco.id_district')
                        ->join('region','region.id=district.id_region')
                        ->where('lower(cisco.description)=',$cisco)
                        ->where('lower(district.nom)=',$cisco)
                        ->where('lower(region.nom)=',$region)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    } 
    
    public function getciscobynomcisco($cisco) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('lower(cisco.description)=',$cisco)
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
