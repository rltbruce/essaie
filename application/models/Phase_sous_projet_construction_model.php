<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Phase_sous_projet_construction_model extends CI_Model {
    protected $table = 'phase_sous_projet_construction';

    public function add($phase_sous_projet_construction) {
        $this->db->set($this->_set($phase_sous_projet_construction))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $phase_sous_projet_construction) {
        $this->db->set($this->_set($phase_sous_projet_construction))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($phase_sous_projet_construction) {
        return array(
            'id_phase_sous_projet'       =>      $phase_sous_projet_construction['id_phase_sous_projet'],
            'id_contrat_prestataire'       =>      $phase_sous_projet_construction['id_contrat_prestataire'],
            'validation'       =>      $phase_sous_projet_construction['validation']                       
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

    public function findphaseinvalideBycisco($id_cisco)
    {               
        $result =  $this->db->select('phase_sous_projet_construction.*')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id=phase_sous_projet_construction.id_contrat_prestataire')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=contrat_prestataire.id_convention_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id", $id_cisco)
                        ->where("phase_sous_projet_construction.validation", 0)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findphaseBycontrat($id_contrat_prestataire)
    {               
        $result =  $this->db->select('phase_sous_projet_construction.*')
                        ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id=phase_sous_projet_construction.id_contrat_prestataire')                       
                        ->where("contrat_prestataire.id", $id_contrat_prestataire)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

   /* public function getmax_phaseBycontrat($id_contrat_prestataire)
    {
        $sql = "select *
                        from phase_sous_projet_construction
                        where id=(select max(id) from phase_sous_projet_construction) and id_contrat_prestataire =".$id_contrat_prestataire."";
        return $this->db->query($sql)->result();                  
    }*/

}
