<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_latrine_moe_model extends CI_Model {
    protected $table = 'demande_latrine_moe';

    public function add($demande_latrine_moe) {
        $this->db->set($this->_set($demande_latrine_moe))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_latrine_moe) {
        $this->db->set($this->_set($demande_latrine_moe))
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
    public function _set($demande_latrine_moe) {
        return array(
            'objet'          =>      $demande_latrine_moe['objet'],
            'description'   =>      $demande_latrine_moe['description'],
            'ref_facture'   =>      $demande_latrine_moe['ref_facture'],
            'montant'   =>      $demande_latrine_moe['montant'],
            'id_tranche_demande_latrine_moe' => $demande_latrine_moe['id_tranche_demande_latrine_moe'],
            'anterieur' => $demande_latrine_moe['anterieur'],
            'cumul' => $demande_latrine_moe['cumul'],
            'reste' => $demande_latrine_moe['reste'],
            'date'          =>      $demande_latrine_moe['date'],
            'id_contrat_bureau_etude'    =>  $demande_latrine_moe['id_contrat_bureau_etude'],
            'validation'    =>  $demande_latrine_moe['validation']                       
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
            public function finddemandeBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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
     public function finddemandeinvalideBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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
     public function finddemandevalidebcafBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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


    

    public function finddemandevalidedaafByIdcontrat($id_contrat_bureau_etude) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)                        
                        ->where("validation",7)
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

    public function finddemandeemidpfiByIdcontrat($id_contrat_bureau_etude) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)                        
                        ->where("validation IN(1,2,3)")
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
   public function findallByIdcontrat($id_contrat_bureau_etude) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
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
    public function findcreerByIdcontrat($id_contrat_bureau_etude) {           //mande    
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)                        
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

    public function finddemandedisponibleBycontrat($id_contrat_bureau_etude) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("validation >", 0)
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
