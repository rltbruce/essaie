<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prestataire_model extends CI_Model {
    protected $table = 'prestataire';

    public function add($prestataire) {
        $this->db->set($this->_set($prestataire))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $prestataire) {
        $this->db->set($this->_set($prestataire))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($prestataire) {
        return array(
            'telephone'  => $prestataire['telephone'],
            'nom'   => $prestataire['nom'],
            'nif'   => $prestataire['nif'],
            'stat'  => $prestataire['stat'],
            'siege' => $prestataire['siege']                       
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
    public function prestataireBysousmissionnaire($id_convention_entete) {               
        $result =  $this->db->select('prestataire.*')
                        ->from('mpe_soumissionaire')
                        ->join('prestataire','prestataire.id=mpe_soumissionaire.id_prestataire')
                        ->join('passation_marches','passation_marches.id=mpe_soumissionaire.id_passation_marches')
                        ->where('id_convention_entete',$id_convention_entete)
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
        $requete="select * from prestataire where lower(nom)='".$nom."'";
        $query = $this->db->query($requete);
        return $query->result();                
    }
    
    public function getprestatairetest($nom_consu) {               
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
    public function getprestatairebylike($nom) {
		$requete="select * from prestataire where lower(nom) like '%".$nom."%'";
		$query = $this->db->query($requete);
        return $query->result();				
	}

}
