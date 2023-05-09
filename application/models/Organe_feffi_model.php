<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organe_feffi_model extends CI_Model
{
    protected $table = 'organe_feffi';


    public function add($organe_feffi)
    {
        $this->db->set($this->_set($organe_feffi))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $organe_feffi)
    {
        $this->db->set($this->_set($organe_feffi))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($organe_feffi)
    {
        return array(
            'libelle'        =>      $organe_feffi['libelle'], 
            'description'        =>      $organe_feffi['description'],                       
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
        

    public function getorgane_feffitest($libelle) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("lower(libelle)=", $libelle)
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
