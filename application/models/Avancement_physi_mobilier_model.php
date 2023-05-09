<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avancement_physi_mobilier_model extends CI_Model {
    protected $table = 'avancement_physi_mobilier';

    public function add($avancement_physi_mobilier) {
        $this->db->set($this->_set($avancement_physi_mobilier))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $avancement_physi_mobilier) {
        $this->db->set($this->_set($avancement_physi_mobilier))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($avancement_physi_mobilier) {
        return array(

            'pourcentage' => $avancement_physi_mobilier['pourcentage'],
            'date'   => $avancement_physi_mobilier['date'],
            'pourcentage_prevu' => $avancement_physi_mobilier['pourcentage_prevu'],
            'id_contrat_prestataire' => $avancement_physi_mobilier['id_contrat_prestataire']                    
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
                        ->order_by('date')
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

    public function findavancementBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
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

}
