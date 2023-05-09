<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pv_consta_statu_bat_travaux_model extends CI_Model {
    protected $table = 'pv_consta_statu_bat_travaux';

    public function add($pv_consta_statu_bat_travaux) {
        $this->db->set($this->_set($pv_consta_statu_bat_travaux))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $pv_consta_statu_bat_travaux) {
        $this->db->set($this->_set($pv_consta_statu_bat_travaux))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($pv_consta_statu_bat_travaux) {
        return array(
            'id_pv_consta_entete_travaux'       =>      $pv_consta_statu_bat_travaux['id_pv_consta_entete_travaux'],
            'id_rubrique_designation'   =>      $pv_consta_statu_bat_travaux['id_rubrique_designation'],
            'status'    => $pv_consta_statu_bat_travaux['status']                     
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
                        ->join('pv_consta_rubrique_designation_bat','pv_consta_rubrique_designation_bat.id=pv_consta_statu_bat_travaux.id_rubrique_designation')
                        //->join('pv_consta_rubrique_phase_bat','pv_consta_rubrique_phase_bat.id=pv_consta_rubrique_designation_bat.id_rubrique_phase')
                        ->where("pv_consta_statu_bat_travaux.status", 1)
                        ->where("pv_consta_statu_bat_travaux.id_pv_consta_entete_travaux", $id_pv_consta_entete_travaux)
                        ->where("pv_consta_rubrique_designation_bat.id_rubrique_phase", $id_rubrique_phase)
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
