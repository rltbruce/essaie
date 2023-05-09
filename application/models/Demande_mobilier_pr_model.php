<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_mobilier_pr_model extends CI_Model {
    protected $table = 'demande_mobilier_pr';

    public function add($demande_mobilier_pr) {
        $this->db->set($this->_set($demande_mobilier_pr))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_mobilier_pr) {
        $this->db->set($this->_set($demande_mobilier_pr))
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
    public function _set($demande_mobilier_pr) {
        return array(
            'objet'          =>      $demande_mobilier_pr['objet'],
            'description'   =>      $demande_mobilier_pr['description'],
            'ref_facture'   =>      $demande_mobilier_pr['ref_facture'],
            'montant'   =>      $demande_mobilier_pr['montant'],
            'id_tranche_demande_mobilier_pr' => $demande_mobilier_pr['id_tranche_demande_mobilier_pr'],
            'anterieur' => $demande_mobilier_pr['anterieur'],
            'cumul' => $demande_mobilier_pr['cumul'],
            'reste' => $demande_mobilier_pr['reste'],
            'date'          =>      $demande_mobilier_pr['date'],
            'id_mobilier_construction'    =>  $demande_mobilier_pr['id_mobilier_construction'],
            'validation'    =>  $demande_mobilier_pr['validation']                       
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
}
