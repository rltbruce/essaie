<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bureau_etude_model extends CI_Model {
    protected $table = 'bureau_etude';

    public function add($bureau_etude) {
        $this->db->set($this->_set($bureau_etude))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $bureau_etude) {
        $this->db->set($this->_set($bureau_etude))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($bureau_etude) {
        return array(
            'telephone'  => $bureau_etude['telephone'],
            'nom'   => $bureau_etude['nom'],
            'nif'   => $bureau_etude['nif'],
            'stat'  => $bureau_etude['stat'],
            'siege' => $bureau_etude['siege']                       
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
        $requete="select * from bureau_etude where lower(nom)='".$nom."'";
        $query = $this->db->query($requete);
        return $query->result();                
    }
    
    public function getbureau_etudetest($nom_consu) {               
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
    public function getbureau_etudebylike($nom) {
		$requete="select * from bureau_etude where lower(nom) like '%".$nom."%'";
		$query = $this->db->query($requete);
        return $query->result();				
	}

}
