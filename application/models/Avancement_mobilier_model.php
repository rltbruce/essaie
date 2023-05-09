<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avancement_mobilier_model extends CI_Model {
    protected $table = 'avancement_mobilier';

    public function add($avancement_mobilier) {
        $this->db->set($this->_set($avancement_mobilier))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $avancement_mobilier) {
        $this->db->set($this->_set($avancement_mobilier))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($avancement_mobilier) {
        return array(

            'description' => $avancement_mobilier['description'],
            'intitule'   => $avancement_mobilier['intitule'],
            'observation'    => $avancement_mobilier['observation'],
            'date'   => $avancement_mobilier['date'],
            'id_attachement_mobilier' => $avancement_mobilier['id_attachement_mobilier'],
            'id_mobilier_construction' => $avancement_mobilier['id_mobilier_construction'] ,
            'id_contrat_prestataire' => $avancement_mobilier['id_contrat_prestataire'] ,
            'validation' => $avancement_mobilier['validation']                       
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
                        ->order_by('date_signature')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findavancementinvalideBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
                        ->where("validation", 0)
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

    public function findavancementvalideBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
                        ->where("validation", 1)
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
    public function findById($id)  {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

    public function findAllBymobilier_construction($id_mobilier_construction) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_mobilier_construction", $id_mobilier_construction)
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
   /*     public function getavancementByconvention($id_convention_entete)
    {               
        $result =  $this->db->select('max(attachement_mobilier.ponderation_mobilier) as avancement')
                        ->from('attachement_mobilier')
                        ->join('avancement_mobilier','avancement_mobilier.id_attachement_mobilier=attachement_mobilier.id')
                        ->join('mobilier_construction','mobilier_construction.id=avancement_mobilier.id_mobilier_construction')
                        ->join('batiment_construction','batiment_construction.id=mobilier_construction.id_batiment_construction')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=batiment_construction.id_convention_entete')
                        ->where('convention_cisco_feffi_entete.id',$id_convention_entete)
                        
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/

}
