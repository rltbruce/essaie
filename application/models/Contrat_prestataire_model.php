<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrat_prestataire_model extends CI_Model {
    protected $table = 'contrat_prestataire';

    public function add($contrat_prestataire) {
        $this->db->set($this->_set($contrat_prestataire))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $contrat_prestataire) {
        $this->db->set($this->_set($contrat_prestataire))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($contrat_prestataire) {
        return array(

            'description' => $contrat_prestataire['description'],
            'num_contrat'   => $contrat_prestataire['num_contrat'],
            'cout_batiment'    => $contrat_prestataire['cout_batiment'],
            'cout_latrine'   => $contrat_prestataire['cout_latrine'],
            'cout_mobilier' => $contrat_prestataire['cout_mobilier'],
            //'date_signature' => $contrat_prestataire['date_signature'],
            //'date_prev_deb_trav' => $contrat_prestataire['date_prev_deb_trav'],
            //'date_reel_deb_trav' => $contrat_prestataire['date_reel_deb_trav'],
            //'delai_execution' => $contrat_prestataire['delai_execution'],
            'id_convention_entete' => $contrat_prestataire['id_convention_entete'],
            'id_prestataire' => $contrat_prestataire['id_prestataire'],
            //'paiement_recu' => $contrat_prestataire['paiement_recu'],
            'validation' => $contrat_prestataire['validation']                      
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
    public function findinvalideByConvention($id_convention_entete) {               
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
    public function findvalideByConvention($id_convention_entete) {               
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
    public function findcontratvalideById($id_contrat_mpe) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_contrat_mpe)
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
    public function findcontratByConvention($id_convention_entete) {               
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

   /* public function findcontratByConvention($id_convention_entete)
    {               
        $this->db->select("contrat_prestataire.*,contrat_prestataire.id_convention_entete as id_conv");
        
            $this->db ->select("(
                select passation.date_signature_contrat from passation_marches as passation
            where passation.id_convention_entete = id_conv ) as date_signature_contrat",FALSE);        
        
            $this->db ->select("(
                select passation.notification_intention from passation_marches as passation
            where passation.id_convention_entete = id_conv ) as notification_intention",FALSE);

            $this->db ->select("(
                select passation.date_notification_attribution from passation_marches as passation
            where passation.id_convention_entete = id_conv ) as date_notification_attribution",FALSE);

            $this->db ->select("(
                select passation_marches.date_os from passation_marches as passation
            where passation.id_convention_entete = id_conv ) as date_os",FALSE);    

        $result =  $this->db->from('contrat_prestataire')
                    
                    ->where('contrat_prestataire.id_convention_entete',$id_convention_entete)                                       
                    ->get()
                    ->result();


        if($result)
        {   
            return $result;
        }
        else
        {
            return $data=array();
        }               
    
    } */
    public function getcontratByconvention($id_convention_entete) {               
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
    
    
    public function getcontrattest($id_convention) {               
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

  /*  public function findAllByConvention($id_convention_entete) {               
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
    

    public function findcontratconvenBydemande_batiment($id_demande_batiment_pre) {               
        $result =  $this->db->select('convention_cisco_feffi_entete.ref_convention as ref_convention,contrat_prestataire.num_contrat as num_contrat, prestataire.nom as nom_prestataire,feffi.denomination as denomination_feffi, cisco.code as code_cisco')
                        ->from('demande_batiment_presta')
                        ->join('batiment_construction','batiment_construction.id=demande_batiment_presta.id_batiment_construction')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=batiment_construction.id_convention_entete')
                        ->join('feffi','feffi.id=convention_cisco_feffi_entete.id_feffi')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->join('contrat_prestataire','contrat_prestataire.id_convention_entete=contrat_prestataire.id_convention_entete')
                        ->join('prestataire','prestataire.id=contrat_prestataire.id_prestataire')

                        ->where("demande_batiment_presta.id", $id_demande_batiment_pre)                       
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findcontratBydemande_batiment($id_demande_batiment_pre) {               
        $result =  $this->db->select('contrat_prestataire.*')
                        ->from('demande_batiment_presta')
                        ->join('contrat_prestataire','contrat_prestataire.id=demande_batiment_presta.id_contrat_prestataire')
                        ->where("demande_batiment_presta.id", $id_demande_batiment_pre)                       
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findcontratBydemande_latrine($id_demande_latrine_pre) {               
        $result =  $this->db->select('contrat_prestataire.*')
                        ->from('demande_latrine_presta')
                        ->join('contrat_prestataire','contrat_prestataire.id=demande_latrine_presta.id_contrat_prestataire')
                        ->where("demande_latrine_presta.id", $id_demande_latrine_pre)                       
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findcontratBydemande_mobilier($id_demande_mobilier_pre) {               
        $result =  $this->db->select('contrat_prestataire.*')
                        ->from('demande_mobilier_presta')
                        ->join('contrat_prestataire','contrat_prestataire.id=demande_mobilier_presta.id_contrat_prestataire')
                        ->where("demande_mobilier_presta.id", $id_demande_mobilier_pre)                       
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

        public function findcontratconvenBydemande_latrine($id_demande_latrine_pre) {               
        $result =  $this->db->select('convention_cisco_feffi_entete.ref_convention as ref_convention,contrat_prestataire.num_contrat as num_contrat, prestataire.nom as nom_prestataire,feffi.denomination as denomination_feffi, cisco.code as code_cisco')
                        ->from('demande_latrine_presta')
                        ->join('latrine_construction','latrine_construction.id=demande_latrine_presta.id_latrine_construction')
                        ->join('batiment_construction','latrine_construction.id_batiment_construction=batiment_construction.id')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=batiment_construction.id_convention_entete')
                        ->join('feffi','feffi.id=convention_cisco_feffi_entete.id_feffi')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->join('contrat_prestataire','contrat_prestataire.id_convention_entete=contrat_prestataire.id_convention_entete')
                        ->join('prestataire','prestataire.id=contrat_prestataire.id_prestataire')

                        ->where("demande_latrine_presta.id", $id_demande_latrine_pre)                       
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

            public function findcontratconvenBydemande_mobilier($id_demande_mobilier_pre) {               
        $result =  $this->db->select('convention_cisco_feffi_entete.ref_convention as ref_convention,contrat_prestataire.num_contrat as num_contrat, prestataire.nom as nom_prestataire,feffi.denomination as denomination_feffi, cisco.code as code_cisco')
                        ->from('demande_mobilier_presta')
                        ->join('mobilier_construction','mobilier_construction.id=demande_mobilier_presta.id_mobilier_construction')
                        ->join('batiment_construction','mobilier_construction.id_batiment_construction=batiment_construction.id')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=batiment_construction.id_convention_entete')
                        ->join('feffi','feffi.id=convention_cisco_feffi_entete.id_feffi')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->join('contrat_prestataire','contrat_prestataire.id_convention_entete=contrat_prestataire.id_convention_entete')
                        ->join('prestataire','prestataire.id=contrat_prestataire.id_prestataire')

                        ->where("demande_mobilier_presta.id", $id_demande_mobilier_pre)                       
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findcontrat_prestataireBycisco($id_cisco)
    {               
        $result =  $this->db->select('convention_cisco_feffi_entete.ref_convention as ref_convention,contrat_prestataire.*')
                        ->from($this->table)                       
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=contrat_prestataire.id_convention_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id", $id_cisco)                       
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findcontrat_prestataireByecole($id_ecole)
    {               
        $result =  $this->db->select('contrat_prestataire.*')
                        ->from($this->table)                       
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=contrat_prestataire.id_convention_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id", $id_cisco)                       
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function getcontratByconvention($id_convention_entete)
    {               
        $result =  $this->db->select('contrat_prestataire.*,prestataire.nom')
                        ->from($this->table)
                        ->join('prestataire','prestataire.id=contrat_prestataire.id_prestataire')
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
    }*/

}
