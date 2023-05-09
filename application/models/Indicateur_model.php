<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Indicateur_model extends CI_Model {
    protected $table = 'indicateur';

    public function add($indicateur) {
        $this->db->set($this->_set($indicateur))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $indicateur) {
        $this->db->set($this->_set($indicateur))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($indicateur) {
        return array(

            'id' => $indicateur['id'],
            'nbr_salle_const' => $indicateur['nbr_salle_const'],
            'nbr_beneficiaire'   => $indicateur['nbr_beneficiaire'],
            'nbr_ecole'    => $indicateur['nbr_ecole'],
            'nbr_box'   => $indicateur['nbr_box'],
            'nbr_point_eau' => $indicateur['nbr_point_eau'],
            'nbr_banc' => $indicateur['nbr_banc'],
            'nbr_table_maitre' => $indicateur['nbr_table_maitre'],
            'id_convention_entete' => $indicateur['id_convention_entete'],
            'nbr_chaise' => $indicateur['nbr_chaise'],
            'observation' => $indicateur['observation'],
            'validation' => $indicateur['validation']

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
    public function findindicateurinvalideByConvention($id_convention_entete) {               
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
    public function findindicateurvalideByConvention($id_convention_entete) {               
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
    public function findindicateurvalideById($id_indicateur) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_indicateur)
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
    public function findindicateurByConvention($id_convention_entete) {               
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

}
