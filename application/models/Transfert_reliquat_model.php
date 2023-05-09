<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class transfert_reliquat_model extends CI_Model {
    protected $table = 'transfert_reliquat';

    public function add($transfert_reliquat) {
        $this->db->set($this->_set($transfert_reliquat))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $transfert_reliquat) {
        $this->db->set($this->_set($transfert_reliquat))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($transfert_reliquat) {
        return array(            
            'montant' => $transfert_reliquat['montant'],
            'date_transfert' => $transfert_reliquat['date_transfert'],
            'rib' => $transfert_reliquat['rib'],
            'intitule_compte' => $transfert_reliquat['intitule_compte'],
            'id_convention_entete' => $transfert_reliquat['id_convention_entete'],
            'objet_utilisation' => $transfert_reliquat['objet_utilisation'] ,
            'situation_utilisation' => $transfert_reliquat['situation_utilisation'] ,
            'validation' => $transfert_reliquat['validation'],
            'observation' => $transfert_reliquat['observation']                     
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
    
    public function findByIdObjet($id)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findtransfertinvalideByCisco($id_cisco)
    {               
        $result =  $this->db->select('transfert_reliquat.*')
                        ->from($this->table)
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=transfert_reliquat.id_convention_entete')
                        ->join('cisco','convention_cisco_feffi_entete.id_cisco=cisco.id')
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
    public function findtransfertByconvention($id_convention_entete)
    {               
        $result =  $this->db->select('transfert_reliquat.*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    } 
    public function findtransfertvalideByconvention($id_convention_entete)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
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
    public function findtransfertinvalideByconvention($id_convention_entete)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_convention_entete", $id_convention_entete)
                        ->where("validation", 0)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }


    public function getmontantatransfererByconvention($id_convention_entete) {
    $this->db->select("convention_cisco_feffi_entete.id as id_conv");

           /* $this->db ->select("(select (cout_maitrise_construction.cout + mobilier_construction.cout_unitaire + latrine_construction.cout_unitaire + batiment_construction.cout_unitaire + cout_sousprojet_construction.cout) from cout_maitrise_construction, mobilier_construction, latrine_construction, batiment_construction, cout_sousprojet_construction where cout_maitrise_construction.id_convention_entete= convention_cisco_feffi_entete.id and mobilier_construction.id_convention_entete= convention_cisco_feffi_entete.id and latrine_construction.id_convention_entete= convention_cisco_feffi_entete.id and batiment_construction.id_convention_entete= convention_cisco_feffi_entete.id and cout_sousprojet_construction.id_convention_entete= convention_cisco_feffi_entete.id and convention_cisco_feffi_entete.id = id_conv) as montant_convention",FALSE);*/

           

            $this->db ->select("(select sum(decaiss_fonct_feffi.montant) from decaiss_fonct_feffi, convention_cisco_feffi_entete where decaiss_fonct_feffi.id_convention_entete= convention_cisco_feffi_entete.id and decaiss_fonct_feffi.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as montant_decaiss_fonct_feffi",FALSE); 



//PAIEMENT MPE
            $this->db ->select("(select sum(facture_mpe.net_payer) from facture_mpe,pv_consta_entete_travaux,contrat_prestataire, convention_cisco_feffi_entete where facture_mpe.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id and pv_consta_entete_travaux.id_contrat_prestataire = contrat_prestataire.id and contrat_prestataire.id_convention_entete= convention_cisco_feffi_entete.id and facture_mpe.validation = '2' and convention_cisco_feffi_entete.id = id_conv) as montant_paiement_mpe",FALSE);
//PAIEMENT MOE
            $this->db ->select("(select sum(facture_moe_detail.montant_periode) from facture_moe_detail,facture_moe_entete, contrat_bureau_etude, convention_cisco_feffi_entete where facture_moe_detail.id_facture_moe_entete= facture_moe_entete.id and facture_moe_entete.id_contrat_bureau_etude=contrat_bureau_etude.id and contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and facture_moe_entete.validation = '2' and convention_cisco_feffi_entete.id = id_conv) as montant_paiement_moe",FALSE);

    $result =  $this->db->from('convention_cisco_feffi_entete')
                        
                        ->where("convention_cisco_feffi_entete.id",$id_convention_entete)
                        ->group_by('id_conv')
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
