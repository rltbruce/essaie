<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Phase_sous_projet_model extends CI_Model {
    protected $table = 'phase_sous_projet';

    public function add($phase_sous_projet) {
        $this->db->set($this->_set($phase_sous_projet))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $phase_sous_projet) {
        $this->db->set($this->_set($phase_sous_projet))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($phase_sous_projet) {
        return array(

            'id_etape_sousprojet' => $phase_sous_projet['id_etape_sousprojet'],
            'id_delai_travaux'   => $phase_sous_projet['id_delai_travaux'],
            'validation' => $phase_sous_projet['validation'],
            'date_travaux' => $phase_sous_projet['date_travaux']                       
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

    public function findphasesousprojetBydelai($id_delai_travaux) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_delai_travaux", $id_delai_travaux)
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
    public function findphasesousprojetvalideBydelai($id_delai_travaux) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_delai_travaux", $id_delai_travaux)
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
    public function getphase_sous_projetvalideById($id_phase_sous_projet) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id_phase_sous_projet)
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
    public function findphasesousprojetinvalideBydelai($id_delai_travaux) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_delai_travaux", $id_delai_travaux)
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
