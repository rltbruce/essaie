<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partenaire_relai_model extends CI_Model {
    protected $table = 'partenaire_relai';

    public function add($partenaire_relai) {
        $this->db->set($this->_set($partenaire_relai))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $partenaire_relai) {
        $this->db->set($this->_set($partenaire_relai))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($partenaire_relai) {
        return array(
            'telephone'  => $partenaire_relai['telephone'],
            'nom'   => $partenaire_relai['nom'],
            'nif'   => $partenaire_relai['nif'],
            'stat'  => $partenaire_relai['stat'],
            'siege' => $partenaire_relai['siege']                       
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
    public function findById($id)  {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

    public function findByNom($nom) {
        $requete="select * from partenaire_relai where lower(nom)='".$nom."'";
        $query = $this->db->query($requete);
        return $query->result();                
    }
    
    public function getpartenairetest($nom_consu) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('lower(nom)=',$nom_consu)
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
