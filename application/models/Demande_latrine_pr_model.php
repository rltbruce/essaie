<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_latrine_pr_model extends CI_Model {
    protected $table = 'demande_latrine_pr';

    public function add($demande_latrine_pr) {
        $this->db->set($this->_set($demande_latrine_pr))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_latrine_pr) {
        $this->db->set($this->_set($demande_latrine_pr))
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
    public function _set($demande_latrine_pr) {
        return array(
            'objet'          =>      $demande_latrine_pr['objet'],
            'description'   =>      $demande_latrine_pr['description'],
            'ref_facture'   =>      $demande_latrine_pr['ref_facture'],
            'montant'   =>      $demande_latrine_pr['montant'],
            'id_tranche_demande_latrine_pr' => $demande_latrine_pr['id_tranche_demande_latrine_pr'],
            'anterieur' => $demande_latrine_pr['anterieur'],
            'cumul' => $demande_latrine_pr['cumul'],
            'reste' => $demande_latrine_pr['reste'],
            'date'          =>      $demande_latrine_pr['date'],
            'id_latrine_construction'    =>  $demande_latrine_pr['id_latrine_construction'],
            'validation'    =>  $demande_latrine_pr['validation']                       
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

    public function findAllInvalideBylatrine($id_latrine_construction) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 0)
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
    public function findAllByLatrine($id_latrine_construction) {               
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

}
