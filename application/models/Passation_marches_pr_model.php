<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Passation_marches_pr_model extends CI_Model {
    protected $table = 'passation_marches_pr';

    public function add($passation_marches_pr) {
        $this->db->set($this->_set($passation_marches_pr))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $passation_marches_pr) {
        $this->db->set($this->_set($passation_marches_pr))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($passation_marches_pr) {
        return array(

            'date_lancement_dp' => $passation_marches_pr['date_lancement_dp'],
            'date_remise'   => $passation_marches_pr['date_remise'],
            'nbr_offre_recu'    => $passation_marches_pr['nbr_offre_recu'],            
            'date_os' => $passation_marches_pr['date_os'],
            'date_manifestation' => $passation_marches_pr['date_manifestation'],
            'date_signature_contrat' => $passation_marches_pr['date_signature_contrat'],
            'id_convention_entete' => $passation_marches_pr['id_convention_entete'],
            'validation' => $passation_marches_pr['validation']                       
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
                        ->order_by('date_manifestation')
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
    
    public function getdate_contratByconvention($id_convention_entete)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return $result=array();
        }                 
    }

    public function findAllByConvention($id_convention_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
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

        public function findAllByContrat_partenaire_relai($id_contrat_partenaire_relai) {               
        $result =  $this->db->select('
            passation_marches_pr.id as id, passation_marches_pr.id_convention_entete as id_convention_entete, passation_marches_pr.date_lancement as date_lancement, passation_marches_pr.date_remise as date_remise, passation_marches_pr.date_os as date_os')
                        ->from($this->table)
                        ->join('convention_ufp_daaf_entete','convention_ufp_daaf_entete.id=passation_marches_pr.id_convention_entete')
                        ->join('contrat_partenaire_relai','contrat_partenaire_relai.id_convention_entete=convention_ufp_daaf_entete.id')
                        ->where("contrat_partenaire_relai.id", $id_contrat_partenaire_relai)
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
        public function findpassationBycontrat_partenaire_relai($id_contrat_partenaire_relai) {               
        $result =  $this->db->select('passation_marches_pr.*')
                        ->from($this->table)
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=passation_marches_pr.id_convention_entete')
                        ->join('contrat_partenaire_relai','contrat_partenaire_relai.id_convention_entete=convention_cisco_feffi_entete.id')
                        ->where("contrat_partenaire_relai.id", $id_contrat_partenaire_relai)
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
    public function getpassationByconvention($id_convention_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
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

    public function findpassationByconvention($id_convention_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return $result=array();
        }

    }
    public function getpassationinvalideByconvention($id_convention_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
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
    public function getpassationvalideByconvention($id_convention_entete) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
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
    public function getpassationvalideById($id_passation_pr) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_passation_pr)
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
    public function getpassationByconventionarray($id_convention_entete)
    {               
        $this->db->select('*')
                ->where("id_convention_entete", $id_convention_entete);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

    }

    
    public function getpassationtest($id_convention) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_convention_entete',$id_convention)
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
