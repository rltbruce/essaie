<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Justificatif_daaf_model extends CI_Model {
    protected $table = 'piece_justificatif_daaf';

    public function add($justificatif_daaf) {
        $this->db->set($this->_set($justificatif_daaf))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $justificatif_daaf) {
        $this->db->set($this->_set($justificatif_daaf))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($justificatif_daaf) {
        return array(
            'fichier'   =>      $justificatif_daaf['fichier'],
            'id_demande_deblocage_daaf'    =>  $justificatif_daaf['id_demande_deblocage_daaf'],
            'id_justificatif_prevu'    =>  $justificatif_daaf['id_justificatif_prevu']                       
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
                        ->order_by('description')
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

   /* public function findAllBydemande($id_demande_deblocage_daaf) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_deblocage_daaf", $id_demande_deblocage_daaf)
                        ->order_by('description')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/ 

      public function findAllBydemande($id_demande_deblocage_daaf,$id_tranche) {
        $sql=" 

                select detail.id as id, 
                        detail.code as code,
                        detail.id_tranche as id_tranche, 
                        detail.intitule as intitule,
                        detail.id_justificatif_prevu as id_justificatif_prevu, 
                        detail.fichier as fichier,  
                        detail.id_demande_deblocage_daaf as id_demande_deblocage_daaf

                    from
                ( (select 
                        justificatif_prevu.id as id_justificatif_prevu,
                        justificatif_prevu.id_tranche as id_tranche, 
                        justificatif_prevu.code as code, 
                        justificatif_prevu.intitule as intitule,
                        piece_justificatif.id as id, 
                        piece_justificatif.fichier as fichier, 
                        piece_justificatif.id_demande_deblocage_daaf as id_demande_deblocage_daaf 

                    from piece_justificatif_daaf as piece_justificatif
            
                        right join piece_justificatif_daaf_prevu as justificatif_prevu on piece_justificatif.id_justificatif_prevu = justificatif_prevu.id 
            
                        where piece_justificatif.id_demande_deblocage_daaf = ".$id_demande_deblocage_daaf." and justificatif_prevu.id_tranche = ".$id_tranche."
            
                        group by justificatif_prevu.id )
                UNION 

                (select 
                        justificatif_prevu.id as id_justificatif_prevu,
                        justificatif_prevu.id_tranche as id_tranche, 
                        justificatif_prevu.code as code, 
                        justificatif_prevu.intitule as intitule,
                        null as id, 
                        null as fichier, 
                        null as id_demande_deblocage_daaf  

                    from piece_justificatif_daaf_prevu as justificatif_prevu
                        where justificatif_prevu.id_tranche = ".$id_tranche."
                        group by justificatif_prevu.id)) detail
                group by detail.id_justificatif_prevu ";
        return $this->db->query($sql)->result();                
    }


}
