<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avenant_partenaire_relai_model extends CI_Model {
    protected $table = 'avenant_partenaire_relai';

    public function add($avenant_partenaire_relai) {
        $this->db->set($this->_set($avenant_partenaire_relai))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $avenant_partenaire_relai) {
        $this->db->set($this->_set($avenant_partenaire_relai))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($avenant_partenaire_relai) {
        return array(

            'description' => $avenant_partenaire_relai['description'],
            'ref_avenant'    => $avenant_partenaire_relai['ref_avenant'],
            'montant'   => $avenant_partenaire_relai['montant'],
            'date_signature' => $avenant_partenaire_relai['date_signature'],
            'validation' => $avenant_partenaire_relai['validation'],
            'id_contrat_partenaire_relai' => $avenant_partenaire_relai['id_contrat_partenaire_relai']                      
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

    public function findAllByContrat_partenaire_relai($id_contrat_partenaire_relai) {               
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

    public function getavenantBycontrat($id_contrat_partenaire_relai) {               
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

    public function findavenantByContrat($id_contrat_partenaire_relai) {               
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

    public function findavenantvalideByContrat($id_contrat_partenaire_relai) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_partenaire_relai", $id_contrat_partenaire_relai)
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

    public function findavenantvalideById($id_avenant_partenaire) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_avenant_partenaire)
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

    public function findavenantinvalideByContrat($id_contrat_partenaire_relai) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_partenaire_relai", $id_contrat_partenaire_relai)
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

}
