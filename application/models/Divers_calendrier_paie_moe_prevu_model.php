<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Divers_calendrier_paie_moe_prevu_model extends CI_Model {
    protected $table = 'divers_calendrier_paie_moe_prevu';

    public function add($attachement) {
        $this->db->set($this->_set($attachement))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id_contrat_bureau_etude,$id_sousrubrique_detail, $attachement) {
        $this->db->set($this->_set($attachement))
                            ->where('id_contrat_bureau_etude', (int) $id_contrat_bureau_etude)
                            ->where('id_sousrubrique_detail', (int) $id_sousrubrique_detail)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($attachement) {
        return array(
            'montant_prevu'    =>      $attachement['montant_prevu'],
            'id_contrat_bureau_etude'   =>      $attachement['id_contrat_bureau_etude'],
            'id_sousrubrique_detail'    => $attachement['id_sousrubrique_detail']                       
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
    public function deletebycontrat($id) {
        $this->db->where('id_contrat_bureau_etude', (int) $id)->delete($this->table);
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
            return array();
        }                 
    }
    public function finddetailcontrat($id_contrat_bureau_etude,$id_sousrubrique_detail) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_contrat_bureau_etude',$id_contrat_bureau_etude)
                        ->where('id_sousrubrique_detail',$id_sousrubrique_detail)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }
    public function findById($id)  {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }
    public function findByIdlibelle($id)  {
        $this->db->select("divers_attachement_batiment_prevu.*, divers_attachement_batiment_detail.libelle as libelle, divers_attachement_batiment_detail.numero as numero");
        $this->db->join("divers_attachement_batiment_detail", 'divers_attachement_batiment_detail.id=divers_attachement_batiment_prevu.id_attachement_batiment_detail');

        $this->db->where("divers_attachement_batiment_prevu.id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

   /* public function getrubriquewithmontant_prevubycontrat($id_contrat_prestataire,$id_rubrique) {               
        $result =  $this->db->select('divers_calendrier_paie_moe_prevu.*,divers_calendrier_paie_moe_detail.libelle as libelle')
                        ->from($this->table)
                        ->join('divers_calendrier_paie_moe_detail','divers_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_attachement_batiment_detail')
                        ->where("id_rubrique", $id_rubrique)
                        ->where("id_contrat_prestataire", $id_contrat_prestataire)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }*/
    public function getcalendrier_paie_moe_prevuwithdetailbycontrat($id_contrat_bureau_etude,$id_sousrubrique) {               
        $result =  $this->db->select('divers_sousrubrique_calendrier_paie_moe_detail.libelle as libelle,divers_sousrubrique_calendrier_paie_moe_detail.pourcentage as pourcentage, divers_calendrier_paie_moe_prevu.montant_prevu as montant_prevu')
                        ->from($this->table)
                        ->join('divers_sousrubrique_calendrier_paie_moe_detail','divers_sousrubrique_calendrier_paie_moe_detail.id=divers_calendrier_paie_moe_prevu.id_sousrubrique_detail')
                        ->where("divers_calendrier_paie_moe_prevu.id_contrat_bureau_etude", $id_contrat_bureau_etude)
                        ->where("divers_sousrubrique_calendrier_paie_moe_detail.id_sousrubrique", $id_sousrubrique)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }


    /* public function getrubriquewithmontant_prevubycontrat1($id_contrat_prestataire,$id_rubrique) {
        $sql="
                select 
                        detail.id as id,
                        detail.id_sousrubrique_detail as id_sousrubrique_detail,
                        detail.description as description, 
                        detail.libelle as libelle,
                        detail.id_contrat_prestataire as id_contrat_prestataire,
                        detail.montant_prevu as montant_prevu

                    from
                (select 
                        attache_batiment_detail.id as id_attachement_batiment_detail, 
                        attache_batiment_detail.numero as numero, 
                        attache_batiment_detail.description as description, 
                        attache_batiment_detail.libelle as libelle,
                        attache_prevu.id as id,
                        attache_prevu.id_contrat_prestataire as id_contrat_prestataire,
                        attache_prevu.unite as unite,
                        attache_prevu.quantite_prevu as quantite_prevu,
                        attache_prevu.prix_unitaire as prix_unitaire,
                        attache_prevu.montant_prevu as montant_prevu  

                    from divers_calendrier_paie_moe_prevu as divers_calendrier_prevu
            
                        right join divers_sousrubrique_calendrier_paie_moe_detail as divers_calendrier_detail on divers_calendrier_prevu.id_sousrubrique_detail = divers_calendrier_detail.id 
                        inner join divers_sousrubrique_calendrier_paie_moe as divers_sousrubrique_calendrier on divers_calendrier_detail.id_sousrubrique = divers_sousrubrique_calendrier.id
            
                        where divers_calendrier_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and divers_sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
            
                        group by attache_batiment_detail.id 
                UNION 

                select 
                        attache_batiment_detail.id as id_attachement_batiment_detail, 
                        attache_batiment_detail.numero as numero, 
                        attache_batiment_detail.description as description, 
                        attache_batiment_detail.libelle as libelle,
                        0 as id,
                        0 as id_contrat_prestataire,
                        null as unite,
                        0 as quantite_prevu,
                        0 as prix_unitaire,
                        0 as montant_prevu 

                    from divers_attachement_batiment_detail as attache_batiment_detail
                        where attache_batiment_detail.id_attachement_batiment = ".$id_attachement_batiment."
                        group by attache_batiment_detail.id) detail
                group by detail.id_attachement_batiment_detail  ";
        return $this->db->query($sql)->result();                
    }*/

     /*public function getmontant_total_prevubycontrat($id_contrat_prestataire) {
        $sql="
                select detail.id as id,
                        sum(detail.montant_bat_prevu) as montant_bat_prevu,
                        sum(detail.montant_lat_prevu) as montant_lat_prevu,
                        sum(detail.montant_mob_prevu) as montant_mob_prevu,
                        (sum(detail.montant_bat_prevu) + sum(detail.montant_lat_prevu) + sum(detail.montant_mob_prevu)) as montant_total_prevu
                    from
                    (    
                        (select 
                                contrat_mpe.id as id,
                                sum(attache_bat_prevu.montant_prevu) as montant_bat_prevu, 
                                0 as montant_lat_prevu,
                                0 as montant_mob_prevu   

                            from divers_attachement_batiment_prevu as attache_bat_prevu
                    
                                inner join contrat_prestataire as contrat_mpe on attache_bat_prevu.id_contrat_prestataire = contrat_mpe.id 
                    
                               where contrat_mpe.id = ".$id_contrat_prestataire."
                        )
                        UNION 

                        (select 
                                contrat_mpe.id as id,
                                0 as montant_bat_prevu,
                                sum(attache_lat_prevu.montant_prevu) as montant_lat_prevu,
                                0 as montant_mob_prevu  

                            from divers_attachement_latrine_prevu as attache_lat_prevu
                    
                                inner join contrat_prestataire as contrat_mpe on attache_lat_prevu.id_contrat_prestataire = contrat_mpe.id 
                                where contrat_mpe.id = ".$id_contrat_prestataire."
                                group by contrat_mpe.id
                         )
                        UNION 

                        (select 
                                contrat_mpe.id as id,
                                0 as montant_bat_prevu,
                                0 as montant_lat_prevu,
                                sum(attache_mob_prevu.montant_prevu) as montant_mob_prevu   

                            from divers_attachement_mobilier_prevu as attache_mob_prevu
                    
                                inner join contrat_prestataire as contrat_mpe on attache_mob_prevu.id_contrat_prestataire = contrat_mpe.id 
                                where contrat_mpe.id = ".$id_contrat_prestataire."
                                group by contrat_mpe.id
                    
                         ) 
                    ) detail
                        group by detail.id";
        return $this->db->query($sql)->result();                
    }*/

    /* public function getcalendrier_paie_moe_prevuwithdetailbycontrat($id_contrat_prestataire,$id_sousrubrique) {
        $sql="
                select detail.id_attachement_batiment_detail as id_attachement_batiment_detail, 
                        detail.description as description, 
                        detail.libelle as libelle,
                        detail.id as id,
                        detail.id_contrat_prestataire as id_contrat_prestataire,
                        detail.unite as unite,
                        detail.quantite_prevu as quantite_prevu,
                        detail.prix_unitaire as prix_unitaire,
                        detail.montant_prevu as montant_prevu

                    from
                (select 
                        attache_batiment_detail.id as id_attachement_batiment_detail, 
                        attache_batiment_detail.description as description, 
                        attache_batiment_detail.libelle as libelle,
                        attache_prevu.id as id,
                        attache_prevu.id_contrat_prestataire as id_contrat_prestataire,
                        attache_prevu.unite as unite,
                        attache_prevu.quantite_prevu as quantite_prevu,
                        attache_prevu.prix_unitaire as prix_unitaire,
                        attache_prevu.montant_prevu as montant_prevu  

                    from divers_attachement_batiment_prevu as attache_prevu
            
                        right join divers_attachement_batiment_detail as attache_batiment_detail on attache_prevu.id_attachement_batiment_detail = attache_batiment_detail.id 
            
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and attache_batiment_detail.id_attachement_batiment = ".$id_attachement_batiment."
            
                        group by attache_batiment_detail.id 
                UNION 

                select 
                        attache_batiment_detail.id as id_attachement_batiment_detail, 
                        attache_batiment_detail.numero as numero, 
                        attache_batiment_detail.description as description, 
                        attache_batiment_detail.libelle as libelle,
                        null as id,
                        null as id_contrat_prestataire,
                        null as unite,
                        0 as quantite_prevu,
                        0 as prix_unitaire,
                        0 as montant_prevu 

                    from divers_attachement_batiment_detail as attache_batiment_detail
                        where attache_batiment_detail.id_attachement_batiment = ".$id_attachement_batiment."
                        group by attache_batiment_detail.id) detail
                group by detail.id_attachement_batiment_detail  ";
        return $this->db->query($sql)->result();                
    }*/



}
