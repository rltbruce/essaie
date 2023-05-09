<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cout_sousprojet_construction_model extends CI_Model {
    protected $table = 'cout_sousprojet_construction';

    public function add($cout_sousprojet_construction) {
        $this->db->set($this->_set($cout_sousprojet_construction))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $cout_sousprojet_construction) {
        $this->db->set($this->_set($cout_sousprojet_construction))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($cout_sousprojet_construction) {
        return array(
            'id_convention_entete'      =>      $cout_sousprojet_construction['id_convention_entete'],
            'id_type_cout_sousprojet'      =>      $cout_sousprojet_construction['id_type_cout_sousprojet'],
            'cout'                      =>      $cout_sousprojet_construction['cout']                       
        );
    }
    public function delete_detail($id) {
         $this->db->where('id_convention_entete', (int) $id)->delete($this->table);
         if($this->db->affected_rows() === 1)
         {
             return true;
         }else{
             return null;
         }  
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

    public function findAll_by_convention_detail($id_convention_entete) 
    {               
        $this->db->select("*");
                        
        $q =  $this->db->from($this->table)  
                    ->where("id_convention_entete", $id_convention_entete)    
                    ->get()
                    ->result();

            if($q)
            {
                return $q;
            }
            else
            {
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

    public function getmontantByconvention($id_convention_entete)
    {               
        $result =  $this->db->select('sum(cout) as montant')
                        ->from($this->table)
                        ->where('id_convention_entete',$id_convention_entete)
                       
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
