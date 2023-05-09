<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Region_model extends CI_Model
{
    protected $table = 'region';


    public function add($region)
    {
        $this->db->set($this->_set($region))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $region)
    {
        $this->db->set($this->_set($region))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($region)
    {
        return array(
            'code'       =>      $region['code'],
            'nom'        =>      $region['nom'],                       
        );
    }


    public function delete($id)
    {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }

    public function findAll()
    {
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

    public function findById($id)
    {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
    public function findByIdtab($id)
    {   $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }
        else
        {
            return null;
        }                 
    }
    public function findByIdcisco($id_cisco){
        $this->db->select('region.*')
        ->join('district','district.id_region=region.id')
                    ->join('cisco','cisco.id_district=district.id')
                    ->where('cisco.id',$id_cisco);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
        


    public function getregionbycisco($id_cisco)
    {
        $result =  $this->db->select('region.*')
                        ->from($this->table)
                         ->join('district','district.id_region=region.id')
                        ->join('cisco','cisco.id_district=district.id')
                        ->where('cisco.id',$id_cisco)
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
    public function getregiontest($nom) {               
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
