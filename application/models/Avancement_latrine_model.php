<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avancement_latrine_model extends CI_Model {
    protected $table = 'avancement_latrine';

    public function add($avancement_latrine) {
        $this->db->set($this->_set($avancement_latrine))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $avancement_latrine) {
        $this->db->set($this->_set($avancement_latrine))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($avancement_latrine) {
        return array(

            'description' => $avancement_latrine['description'],
            'intitule'   => $avancement_latrine['intitule'],
            'observation'    => $avancement_latrine['observation'],
            'date'   => $avancement_latrine['date'],
            'id_attachement_latrine' => $avancement_latrine['id_attachement_latrine'],
            'id_latrine_construction' => $avancement_latrine['id_latrine_construction'] ,
            'id_contrat_prestataire' => $avancement_latrine['id_contrat_prestataire'] ,
            'validation' => $avancement_latrine['validation']                       
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
    public function findById($id)  {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
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

    public function findAllBylatrine_construction($id_latrine_construction) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_latrine_construction", $id_latrine_construction)
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
  /*      public function getavancementByconvention($id_convention_entete)
    {               
        $result =  $this->db->select('max(attachement_latrine.ponderation_latrine) as avancement')
                        ->from('attachement_latrine')
                        ->join('avancement_latrine','avancement_latrine.id_attachement_latrine=attachement_latrine.id')
                        ->join('latrine_construction','latrine_construction.id=avancement_latrine.id_latrine_construction')
                        ->join('batiment_construction','batiment_construction.id=latrine_construction.id_batiment_construction')
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
