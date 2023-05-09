<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Piece_justificatif_frais_fonction_feffi_model extends CI_Model {
    protected $table = 'piece_justificatif_frais_fonction_feffi';

    public function add($piece_justificatif_frais_fonction_feffi) {
        $this->db->set($this->_set($piece_justificatif_frais_fonction_feffi))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $piece_justificatif_frais_fonction_feffi) {
        $this->db->set($this->_set($piece_justificatif_frais_fonction_feffi))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($piece_justificatif_frais_fonction_feffi) {
        return array(
            'fichier'   =>      $piece_justificatif_frais_fonction_feffi['fichier'],
            'id_justificatif_prevu'          =>      $piece_justificatif_frais_fonction_feffi['id_justificatif_prevu'],
            'id_addition_frais'    =>  $piece_justificatif_frais_fonction_feffi['id_addition_frais']                       
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

   /* public function findAllBydemande($id_addition_frais) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_addition_frais", $id_addition_frais)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    } */

     public function findAllByjustificatif($id_addition_frais) {
        $sql=" 

                select detail.id as id, 
                        detail.code as code,
                        detail.intitule as intitule,
                        detail.id_justificatif_prevu as id_justificatif_prevu, 
                        detail.fichier as fichier

                    from
                (select 
                        justificatif_prevu.id as id_justificatif_prevu,
                        justificatif_prevu.code as code, 
                        justificatif_prevu.intitule as intitule,
                        piece_justificatif.id as id, 
                        piece_justificatif.fichier as fichier

                    from piece_justificatif_frais_fonction_feffi as piece_justificatif
            
                        right join piece_justificatif_frais_fonction_feffi_prevu as justificatif_prevu on piece_justificatif.id_justificatif_prevu = justificatif_prevu.id 
            
                        where piece_justificatif.id_addition_frais = ".$id_addition_frais."
            
                        group by justificatif_prevu.id 
                UNION 

                select 
                        justificatif_prevu.id as id_justificatif_prevu,
                        justificatif_prevu.code as code, 
                        justificatif_prevu.intitule as intitule,
                        null as id, 
                        null as fichier 

                    from piece_justificatif_frais_fonction_feffi_prevu as justificatif_prevu
                        group by justificatif_prevu.id) detail
                group by detail.id_justificatif_prevu ";
        return $this->db->query($sql)->result();                
    }

}
