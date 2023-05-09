<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pv_consta_statu_lat_travaux_model extends CI_Model {
    protected $table = 'pv_consta_statu_lat_travaux';

    public function add($pv_consta_statu_lat_travaux) {
        $this->db->set($this->_set($pv_consta_statu_lat_travaux))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $pv_consta_statu_lat_travaux) {
        $this->db->set($this->_set($pv_consta_statu_lat_travaux))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($pv_consta_statu_lat_travaux) {
        return array(
            'id_pv_consta_entete_travaux'       =>      $pv_consta_statu_lat_travaux['id_pv_consta_entete_travaux'],
            'id_rubrique_designation'   =>      $pv_consta_statu_lat_travaux['id_rubrique_designation'],
            'status'    => $pv_consta_statu_lat_travaux['status']                     
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
                        ->order_by('numero')
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
    public function getcount_desination_statubyphasecontrat($id_rubrique_phase,$id_pv_consta_entete_travaux,$id_contrat_prestataire)
    {
        $result = $this->db->select('COUNT(*) as nombre')
                        ->from($this->table)
                        ->join('pv_consta_rubrique_designation_lat','pv_consta_rubrique_designation_lat.id=pv_consta_statu_lat_travaux.id_rubrique_designation')
                        //->join('pv_consta_rubrique_phase_lat','pv_consta_rubrique_phase_lat.id=pv_consta_rubrique_designation_lat.id_rubrique_phase')
                        ->where("pv_consta_statu_lat_travaux.status", 1)
                        ->where("pv_consta_statu_lat_travaux.id_pv_consta_entete_travaux", $id_pv_consta_entete_travaux)
                        ->where("pv_consta_rubrique_designation_lat.id_rubrique_phase", $id_rubrique_phase)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    }
    
    public function getcount_desination_inferieur6byphasecontrat($id_rubrique_phase,$id_pv_consta_entete_travaux,$id_contrat_prestataire)
    {
        $result = $this->db->select('COUNT(*) as nombre')
                        ->from($this->table)
                        ->join('pv_consta_rubrique_designation_lat','pv_consta_rubrique_designation_lat.id=pv_consta_statu_lat_travaux.id_rubrique_designation')
                        //->join('pv_consta_rubrique_phase_lat','pv_consta_rubrique_phase_lat.id=pv_consta_rubrique_designation_lat.id_rubrique_phase')
                        ->where("pv_consta_statu_lat_travaux.status", 1)
                        ->where("pv_consta_statu_lat_travaux.id_pv_consta_entete_travaux", $id_pv_consta_entete_travaux)
                        ->where("pv_consta_rubrique_designation_lat.id_rubrique_phase", $id_rubrique_phase)
                        ->where("pv_consta_rubrique_designation_lat.numero <", 6)
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
