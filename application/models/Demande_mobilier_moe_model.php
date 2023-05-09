<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_mobilier_moe_model extends CI_Model {
    protected $table = 'demande_mobilier_moe';

    public function add($demande_mobilier_moe) {
        $this->db->set($this->_set($demande_mobilier_moe))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_mobilier_moe) {
        $this->db->set($this->_set($demande_mobilier_moe))
                ->set('date_approbation', 'NOW()', false)
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($demande_mobilier_moe) {
        return array(
            'objet'          =>      $demande_mobilier_moe['objet'],
            'description'   =>      $demande_mobilier_moe['description'],
            'ref_facture'   =>      $demande_mobilier_moe['ref_facture'],
            'montant'   =>      $demande_mobilier_moe['montant'],
            'id_tranche_demande_mobilier_moe' => $demande_mobilier_moe['id_tranche_demande_mobilier_moe'],
            'anterieur' => $demande_mobilier_moe['anterieur'],
            'cumul' => $demande_mobilier_moe['cumul'],
            'reste' => $demande_mobilier_moe['reste'],
            'date'          =>      $demande_mobilier_moe['date'],
            'id_contrat_bureau_etude'    =>  $demande_mobilier_moe['id_contrat_bureau_etude'],
            'validation'    =>  $demande_mobilier_moe['validation']                       
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
                        ->order_by('objet')
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

    public function findAllInvalideBymobilier($id_mobilier_construction) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 0)
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

        public function findAllInvalide() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
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
        public function findAllValidebcaf() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
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
    public function findAllValidedpfi() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 2)
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
    public function findAllValide() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 3)
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

    public function countAllByInvalide($invalide)
    {
        $result = $this->db->select('COUNT(*) as nombre')
                        ->from($this->table)
                        ->where("validation", $invalide)
                        ->order_by('id', 'desc')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    } 
    public function findAllByMobilier($id_mobilier_construction) {               
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
    public function findAlldemandeinvalideBycisco($id_cisco)
    {               
        $result =  $this->db->select('demande_mobilier_moe.*')
                        ->from($this->table)                        
                        ->join('contrat_bureau_etude','contrat_bureau_etude.id= demande_mobilier_moe.id_contrat_bureau_etude')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id", $id_cisco)
                        ->where("demande_mobilier_moe.validation", 0)
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
    public function findAlldemandevalideBycisco($id_cisco)
    {               
        $result =  $this->db->select('demande_mobilier_moe.*')
                        ->from($this->table)                        
                        ->join('contrat_bureau_etude','contrat_bureau_etude.id= demande_mobilier_moe.id_contrat_bureau_etude')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id", $id_cisco)
                        ->where("demande_mobilier_moe.validation", 3)
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
