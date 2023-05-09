<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Piece_justificatif_feffi_model extends CI_Model {
    protected $table = 'piece_justificatif_feffi';

    public function add($piece_justificatif_feffi) {
        $this->db->set($this->_set($piece_justificatif_feffi))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $piece_justificatif_feffi) {
        $this->db->set($this->_set($piece_justificatif_feffi))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($piece_justificatif_feffi) {
        return array(
            'fichier'   =>      $piece_justificatif_feffi['fichier'],
            'id_justificatif_prevu'          =>      $piece_justificatif_feffi['id_justificatif_prevu'],
            'id_demande_rea_feffi'    =>  $piece_justificatif_feffi['id_demande_rea_feffi']                       
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

   /* public function findAllBydemande($id_demande_rea_feffi) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_rea_feffi", $id_demande_rea_feffi)
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

     public function findAllBydemande($id_demande_rea_feffi,$id_tranche) {
        $sql=" 

                select detail.id as id, 
                        detail.code as code,
                        detail.id_tranche as id_tranche, 
                        detail.intitule as intitule,
                        detail.id_justificatif_prevu as id_justificatif_prevu, 
                        detail.fichier as fichier,  
                        detail.id_demande_rea_feffi as id_demande_rea_feffi

                    from
                (select 
                        justificatif_prevu.id as id_justificatif_prevu,
                        justificatif_prevu.id_tranche as id_tranche, 
                        justificatif_prevu.code as code, 
                        justificatif_prevu.intitule as intitule,
                        piece_justificatif.id as id, 
                        piece_justificatif.fichier as fichier, 
                        piece_justificatif.id_demande_rea_feffi as id_demande_rea_feffi 

                    from piece_justificatif_feffi as piece_justificatif
            
                        right join piece_justificatif_feffi_prevu as justificatif_prevu on piece_justificatif.id_justificatif_prevu = justificatif_prevu.id 
            
                        where piece_justificatif.id_demande_rea_feffi = ".$id_demande_rea_feffi." and justificatif_prevu.id_tranche = ".$id_tranche."
            
                        group by justificatif_prevu.id 
                UNION 

                select 
                        justificatif_prevu.id as id_justificatif_prevu,
                        justificatif_prevu.id_tranche as id_tranche, 
                        justificatif_prevu.code as code, 
                        justificatif_prevu.intitule as intitule,
                        null as id, 
                        null as fichier, 
                        null as id_demande_rea_feffi  

                    from piece_justificatif_feffi_prevu as justificatif_prevu
                        where justificatif_prevu.id_tranche = ".$id_tranche."
                        group by justificatif_prevu.id) detail
                group by detail.id_justificatif_prevu ";
        return $this->db->query($sql)->result();                
    }

}
