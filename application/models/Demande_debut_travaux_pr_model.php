<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_debut_travaux_pr_model extends CI_Model {
    protected $table = 'demande_debut_travaux_pr';

    public function add($demande_debut_travaux_pr) {
        $this->db->set($this->_set($demande_debut_travaux_pr))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_debut_travaux_pr) {
        $this->db->set($this->_set($demande_debut_travaux_pr))
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
    public function _set($demande_debut_travaux_pr) {
        return array(
            'objet'          =>      $demande_debut_travaux_pr['objet'],
            'description'   =>      $demande_debut_travaux_pr['description'],
            'ref_facture'   =>      $demande_debut_travaux_pr['ref_facture'],
            'montant'   =>      $demande_debut_travaux_pr['montant'],
            'id_tranche_d_debut_travaux_pr' => $demande_debut_travaux_pr['id_tranche_d_debut_travaux_pr'],
            'anterieur' => $demande_debut_travaux_pr['anterieur'],
            'cumul' => $demande_debut_travaux_pr['cumul'],
            'reste' => $demande_debut_travaux_pr['reste'],
            'date'          =>      $demande_debut_travaux_pr['date'],
            'id_contrat_partenaire_relai'    =>  $demande_debut_travaux_pr['id_contrat_partenaire_relai'],
            'validation'    =>  $demande_debut_travaux_pr['validation']                       
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

    public function findAllInvalideBycontrat($id_contrat_partenaire_relai) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 0)
                        ->where("id_contrat_partenaire_relai", $id_contrat_partenaire_relai)
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
    public function findAllBycontrat($id_contrat_partenaire_relai) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_partenaire_relai", $id_contrat_partenaire_relai)
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
     public function finddemandedisponibleBycontrat($id_contrat_partenaire_relai) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_partenaire_relai", $id_contrat_partenaire_relai)
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

   /* public function findAllInvalide() {               
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

        public function findAllInvalideBybatiment($id_contrat_partenaire_relai) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 0)
                        ->where("id_contrat_partenaire_relai", $id_contrat_partenaire_relai)
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

        public function findAllValide() {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 3)
                        ->order_by('date_approbation')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

            public function findAllValidetechnique() {               
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
    } */



}
