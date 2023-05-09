<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Divers_sousrubrique_calendrier_paie_moe_detail_model extends CI_Model {
    protected $table = 'divers_sousrubrique_calendrier_paie_moe_detail';

    public function add($sousrubrique) {
        $this->db->set($this->_set($sousrubrique))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $sousrubrique) {
        $this->db->set($this->_set($sousrubrique))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($sousrubrique) {
        return array(
            'libelle'       =>      $sousrubrique['libelle'],
            'description'   =>      $sousrubrique['description'],
            'pourcentage'   =>      $sousrubrique['pourcentage'],
            'condition_paiement'   =>      $sousrubrique['condition_paiement'],
            'id_sousrubrique'    => $sousrubrique['id_sousrubrique']                      
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
    public function getdetailsousrubriquebysousrubrique($id_sousrubrique) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_sousrubrique',$id_sousrubrique)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
     public function findattachementBycontrat($id_contrat_prestataire,$id_type_batiment) {
        $sql="
                select detail.id as id, 
                        detail.description as description, 
                        detail.libelle as libelle,
                        detail.id_divers_attachement_batiment_prevu as id_divers_attachement_batiment_prevu,
                        detail.id_contrat_prestataire as id_contrat_prestataire,
                        detail.montant_prevu as montant_prevu

                    from
                (select 
                        attache_batiment.id as id, 
                        attache_batiment.description as description, 
                        attache_batiment.libelle as libelle,
                        attache_prevu.id as id_divers_attachement_batiment_prevu,
                        attache_prevu.id_contrat_prestataire as id_contrat_prestataire,
                        attache_prevu.montant_prevu as montant_prevu 

                    from divers_attachement_batiment_prevu as attache_prevu
            
                        right join divers_attachement_batiment as attache_batiment on attache_prevu.id_divers_attachement_batiment = attache_batiment.id 
            
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and attache_batiment.id_type_batiment = ".$id_type_batiment."
            
                        group by attache_batiment.id 
                UNION 

                select 
                        attache_batiment.id as id, 
                        attache_batiment.description as description, 
                        attache_batiment.libelle as libelle,
                        null as id_divers_attachement_batiment_prevu,
                        null as id_contrat_prestataire,
                        null as montant_prevu  

                    from divers_attachement_batiment as attache_batiment
                        where attache_batiment.id_type_batiment = ".$id_type_batiment."
                        group by attache_batiment.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
    }



}
