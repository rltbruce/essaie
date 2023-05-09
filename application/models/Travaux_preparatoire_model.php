<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Travaux_preparatoire_model extends CI_Model {
    protected $table = 'travaux_preparatoire';

    public function add($travaux_preparatoire) {
        $this->db->set($this->_set($travaux_preparatoire))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $travaux_preparatoire) {
        $this->db->set($this->_set($travaux_preparatoire))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($travaux_preparatoire) {
        return array(
            'designation'       =>      $travaux_preparatoire['designation'],
            'unite'   =>      $travaux_preparatoire['unite'],
            'qt_prevu'   =>      $travaux_preparatoire['qt_prevu'],
            'numero'   =>      $travaux_preparatoire['numero']                   
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




}
