<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reception_mpe_model extends CI_Model {
    protected $table = 'reception_mpe';

    public function add($reception_mpe) {
        $this->db->set($this->_set($reception_mpe))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $reception_mpe) {
        $this->db->set($this->_set($reception_mpe))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($reception_mpe) {
        return array(
            'id' => $reception_mpe['id'],
            'date_previ_recep_tech' => $reception_mpe['date_previ_recep_tech'],
            'date_reel_tech'        => $reception_mpe['date_reel_tech'],
            'date_leve_recep_tech'  => $reception_mpe['date_leve_recep_tech'],
            'date_previ_recep_prov' => $reception_mpe['date_previ_recep_prov'],
            'date_reel_recep_prov' => $reception_mpe['date_reel_recep_prov'],
            'date_previ_leve'      => $reception_mpe['date_previ_leve'],
            'date_reel_lev_ava_rd' => $reception_mpe['date_reel_lev_ava_rd'],
            'date_previ_recep_defi'   => $reception_mpe['date_previ_recep_defi'],
            'date_reel_recep_defi'    => $reception_mpe['date_reel_recep_defi'],
            'observation'      => $reception_mpe['observation'],
            'id_contrat_prestataire' => $reception_mpe['id_contrat_prestataire'],
            'validation' => $reception_mpe['validation']                       
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
    public function findreception_mpeBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('reception_mpe.*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findreception_mpevalideBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('reception_mpe.*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
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
    public function findreception_mpevalideById($id_reception_mpe) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_reception_mpe)
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
    public function findreception_mpeinvalideBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('reception_mpe.*')
                        ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
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

   /* public function findAllByContrat_prestataire($id_contrat_prestataire) {               
        $result =  $this->db->select('reception_mpe.*')
                            ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id=reception_mpe.id_contrat_prestataire')
                        ->where("contrat_prestataire.id", $id_contrat_prestataire)
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

    public function getreceptionBycontrat($id_contrat_prestataire) {               
        $result =  $this->db->select('*')
                            ->from($this->table)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
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

    public function findAllByCisco($id_cisco) {               
        $result =  $this->db->select('reception_mpe.*')
                            ->from($this->table)
                        ->join('contrat_prestataire','contrat_prestataire.id=reception_mpe.id_contrat_prestataire')
                        ->join('convention_cisco_feffi_entete','convention_cisco_feffi_entete.id=contrat_prestataire.id_convention_entete')
                        ->join('cisco','cisco.id=convention_cisco_feffi_entete.id_cisco')
                        ->where("cisco.id", $id_cisco)
                        ->where("reception_mpe.validation", 0)
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
