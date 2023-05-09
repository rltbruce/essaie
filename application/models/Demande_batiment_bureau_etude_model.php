<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demande_batiment_bureau_etude_model extends CI_Model {
    protected $table = 'demande_batiment_bureau';

    public function add($demande_batiment_bureau_etude) {
        $this->db->set($this->_set($demande_batiment_bureau_etude))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $demande_batiment_bureau_etude) {
        $this->db->set($this->_set($demande_batiment_bureau_etude))
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
    public function _set($demande_batiment_bureau_etude) {
        return array(
            'objet'          =>      $demande_batiment_bureau_etude['objet'],
            'description'   =>      $demande_batiment_bureau_etude['description'],
            'ref_facture'   =>      $demande_batiment_bureau_etude['ref_facture'],
            'montant'   =>      $demande_batiment_bureau_etude['montant'],
            'id_tranche_demande_moe' => $demande_batiment_bureau_etude['id_tranche_demande_moe'],
            'anterieur' => $demande_batiment_bureau_etude['anterieur'],
            'cumul' => $demande_batiment_bureau_etude['cumul'],
            'reste' => $demande_batiment_bureau_etude['reste'],
            'date'          =>      $demande_batiment_bureau_etude['date'],
            'id_contrat_bureau_etude'    =>  $demande_batiment_bureau_etude['id_contrat_bureau_etude'],
            'validation'    =>  $demande_batiment_bureau_etude['validation']                       
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

     /*  public function findAllInvalideBybatiment($id_batiment_construction) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("validation", 0)
                        ->where("id_batiment_construction", $id_batiment_construction)
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
    } 

}
