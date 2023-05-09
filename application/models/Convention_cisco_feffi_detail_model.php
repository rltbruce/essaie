<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Convention_cisco_feffi_detail_model extends CI_Model {
    protected $table = 'convention_cisco_feffi_detail';

    public function add($convention) {
        $this->db->set($this->_set($convention))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $convention) {
        $this->db->set($this->_set($convention))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function update_det($id, $convention) {
        $this->db->set($this->_set($convention))
                            ->where('id_convention_entete', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($convention) {
        return array(
            'intitule' => $convention['intitule'],
            'id_convention_entete'=> $convention['id_convention_entete'],            
            'date_signature' => $convention['date_signature'],            
            'prev_beneficiaire' => $convention['prev_beneficiaire'],            
            'prev_nbr_ecole' => $convention['prev_nbr_ecole'],
            'delai' => $convention['delai'],
            'observation' => $convention['observation'] );
                   
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
    public function delete_detail($id) {
         $this->db->where('id_convention_entete', (int) $id)->delete($this->table);
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
                        ->order_by('intitule')
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
    public function getconvention_detailBytete($id_convention_entete) {               
        $this->db->select('*')
                        ->where("id_convention_entete",$id_convention_entete);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }                
    }

    public function findAllByEntete($id_convention_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete",$id_convention_entete)
                        ->order_by('intitule')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

        public function supressionBytete($id) {
        $this->db->from($this->table)
                //->join('convention_cisco_feffi_detail', 'convention_cisco_feffi_detail.id_convention_entete = convention_cisco_feffi_entete.id')
               // ->join('mobilier_construction', 'mobilier_construction.id_batiment_construction = batiment_construction.id')
                ->where('id_convention_entete', (int) $id)
        ->delete($this->table);
                    ;
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }

}
