<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Membre_feffi_model extends CI_Model {
    protected $table = 'membre_feffi';

    public function add($membre_feffi) {
        $this->db->set($this->_set($membre_feffi))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $membre_feffi) {
        $this->db->set($this->_set($membre_feffi))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($membre_feffi) {
        return array(
            'nom'       =>      $membre_feffi['nom'],
            'prenom'   =>      $membre_feffi['prenom'],
            'sexe'   =>      $membre_feffi['sexe'],
            'age'   =>      $membre_feffi['age'],
            'id_organe_feffi'   => $membre_feffi['id_organe_feffi'],
            'id_fonction_feffi'   => $membre_feffi['id_fonction_feffi'],
            'id_feffi'    => $membre_feffi['id_feffi']                       
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
                        ->order_by('nom')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    
    public function findByMembre($id)  {
        $this->db->select('membre_feffi.id as id,membre_feffi.nom as nom,membre_feffi.prenom as prenom,membre_feffi.id_feffi as id_feffi,
        membre_feffi.sexe as sexe,membre_feffi.age as age,organe_feffi.libelle as organe_libelle,fonction_feffi.libelle as fonction_libelle')
        ->join('organe_feffi','organe_feffi.id=membre_feffi.id_organe_feffi')
        ->join('fonction_feffi','fonction_feffi.id=membre_feffi.id_fonction_feffi')
        ->where("membre_feffi.id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    public function findById($id)  {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

    public function findByfeffi($id_feffi) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_feffi", $id_feffi)
                        ->order_by('nom')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function Count_membrebyId($id) 
    {
        $this->db->select('count(DISTINCT(id)) as nbr_membre')
        ->where("id_feffi", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    public function Count_femininbyId($id) 
    {
        $this->db->select('count(DISTINCT(id)) as nbr_feminin')
        ->where("id_feffi", $id)
        ->where("sexe", 2);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    
    public function getmembre_feffitest($id_organe_feffi,$id_fonction_feffi,$nom_membre,$prenom_membre)
    {               
        $result =  $this->db->select('membre_feffi.*')
                        ->from($this->table)
                        ->join('organe_feffi','organe_feffi.id=membre_feffi.id_organe_feffi')
                        ->join('fonction_feffi','fonction_feffi.id=membre_feffi.id_fonction_feffi')
                        ->where("membre_feffi.id_organe_feffi", $id_organe_feffi)
                        ->where("membre_feffi.id_fonction_feffi", $id_fonction_feffi)
                        ->where("lower(membre_feffi.nom)", $nom_membre)
                        ->where("lower(membre_feffi.prenom)", $prenom_membre)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }
}
