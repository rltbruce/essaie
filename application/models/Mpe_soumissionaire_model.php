<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mpe_soumissionaire_model extends CI_Model {
    protected $table = 'mpe_soumissionaire';

    public function add($ouvrage_construction) {
        $this->db->set($this->_set($ouvrage_construction))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $ouvrage_construction) {
        $this->db->set($this->_set($ouvrage_construction))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($ouvrage_construction) {
        return array(
            'id_passation_marches' => $ouvrage_construction['id_passation_marches'],
            'id_prestataire' => $ouvrage_construction['id_prestataire']);
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

    public function findAllByPassation($id_passation_marches) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_passation_marches",$id_passation_marches)
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
    public function countAllBympe_soumissionnaire($id_passation_marches) {               
        $result =  $this->db->select('count(id) as nbr')
                        ->from($this->table)
                        ->where("id_passation_marches",$id_passation_marches)
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
    public function getmpe_soumissionnairebypass($id_passation_marches) {               
        $result =  $this->db->select('prestataire.*')
                        ->from($this->table)
                        ->join('prestataire','prestataire.id=mpe_soumissionaire.id_prestataire')
                        ->where("id_passation_marches",$id_passation_marches)
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


    public function getmpesoumissionaireBypassationpres($id_passation_marches,$id_prestataire) {
        $requete="select * from mpe_soumissionaire where id_passation_marches='".$id_passation_marches."' and id_prestataire='".$id_prestataire."'";
        $query = $this->db->query($requete);
        return $query->result();                
    }

}
