<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Passation_marches_be_model extends CI_Model {
    protected $table = 'passation_marches_be';

    public function add($passation_marches_be) {
        $this->db->set($this->_set($passation_marches_be))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $passation_marches_be) {
        $this->db->set($this->_set($passation_marches_be))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($passation_marches_be) {
        return array(

            'date_lancement_dp' => $passation_marches_be['date_lancement_dp'],
            'date_remise'   => $passation_marches_be['date_remise'],
            'nbr_offre_recu'    => $passation_marches_be['nbr_offre_recu'],
            'date_rapport_evaluation' => $passation_marches_be['date_rapport_evaluation'],
            'date_demande_ano_dpfi' => $passation_marches_be['date_demande_ano_dpfi'],
            'date_ano_dpfi' => $passation_marches_be['date_ano_dpfi'],
            'notification_intention'   => $passation_marches_be['notification_intention'],
            'date_notification_attribution'    => $passation_marches_be['date_notification_attribution'],
            'date_signature_contrat'   => $passation_marches_be['date_signature_contrat'],
            'date_os' => $passation_marches_be['date_os'],
            'observation' => $passation_marches_be['observation'],

            'date_shortlist'   => $passation_marches_be['date_shortlist'],
            'date_manifestation' => $passation_marches_be['date_manifestation'],
            'statut' => $passation_marches_be['statut'],

            'id_convention_entete' => $passation_marches_be['id_convention_entete'],
            'validation' => $passation_marches_be['validation']                       
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
    public function findpassationarrayByconvention($id)  {
        $this->db->where("id_convention_entete", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
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
    
    public function findpassationByconvention($id_convention_entete)
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
    
    public function getpassationByconvention($id_convention_entete)
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
            return null;
        }                 
    }
    public function getpassationvalideByconvention($id_convention_entete)
    {               
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
    public function getpassationvalideById($id_passation_moe)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_passation_moe)
                        ->where("validation", 1)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function getpassationinvalideByconvention($id_convention_entete)
    {               
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

 /*   public function findAllByConvention($id_convention_entete) {               
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
    public function findpassationBycontrat_be($id_contrat_bureau_etude) {               
        $result =  $this->db->select('
            passation_marches_be.*')
                        ->from($this->table)
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=passation_marches_be.id_convention_entete')
                        ->join('contrat_bureau_etude','contrat_bureau_etude.id_convention_entete=convention_cisco_feffi_entete.id')
                        ->where("contrat_bureau_etude.id", $id_contrat_bureau_etude)
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

        public function findAllByContrat_be($id_contrat_bureau_etude) {               
        $result =  $this->db->select('
            passation_marches_be.id as id, passation_marches_be.id_convention_entete as id_convention_entete, passation_marches_be.date_lancement as date_lancement, passation_marches_be.date_remise as date_remise, passation_marches_be.montant_moin_chere as montant_moin_chere, passation_marches_be.date_rapport_evaluation as date_rapport_evaluation, passation_marches_be.date_demande_ano_dpfi as date_demande_ano_dpfi, passation_marches_be.date_ano_dpfi as date_ano_dpfi, passation_marches_be.notification_intention as notification_intention, passation_marches_be.date_notification_attribution as date_notification_attribution, passation_marches_be.date_os as date_os,passation_marches_be.observation as observation')
                        ->from($this->table)
                        ->join('convention_ufp_daaf_entete','convention_ufp_daaf_entete.id=passation_marches_be.id_convention_entete')
                        ->join('contrat_bureau_etude','contrat_bureau_etude.id_convention_entete=convention_ufp_daaf_entete.id')
                        ->where("contrat_bureau_etude.id", $id_contrat_bureau_etude)
                        ->order_by('id')
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
