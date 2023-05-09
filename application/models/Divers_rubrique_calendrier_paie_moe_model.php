<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Divers_rubrique_calendrier_paie_moe_model extends CI_Model {
    protected $table = 'divers_rubrique_calendrier_paie_moe';

    public function add($rubrique) {
        $this->db->set($this->_set($rubrique))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $rubrique) {
        $this->db->set($this->_set($rubrique))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($rubrique) {
        return array(
            'libelle'       =>      $rubrique['libelle'],
            'description'   =>      $rubrique['description']                      
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
     public function getrubriquewithmontant_prevubycontrat($id_contrat_bureau_etude) {
        $sql="
                select detail.id as id,  
                        detail.libelle as libelle,
                        sum(detail.montant_prevu) as montant_prevu 

                    from
                (
                select 
                        rubrique_calendrier.id as id, 
                        rubrique_calendrier.libelle as libelle,
                        sum(calendrier_paie_moe_prevu.montant_prevu) as montant_prevu   

                    from divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu
            
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique
                        left join divers_rubrique_calendrier_paie_moe as rubrique_calendrier on rubrique_calendrier.id = sousrubrique_calendrier.id_rubrique  
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude."
            
                        group by rubrique_calendrier.id 
                UNION 

                
                select 
                        rubrique_calendrier.id as id,
                        rubrique_calendrier.libelle as libelle,
                        0 as montant_prevu   

                    from divers_rubrique_calendrier_paie_moe as rubrique_calendrier
            
                        group by rubrique_calendrier.id) detail
                group by detail.id order by detail.id ";
        return $this->db->query($sql)->result();                
    }
    public function getrubrique_calendrier_moewithmontantByentetecontrat($id_contrat_bureau_etude,$id_facture_moe_entete) {
        $sql="
                select detail.id as id,  
                        detail.libelle as libelle,
                        sum(detail.montant_prevu) as montant_prevu ,
                        sum(detail.pourcentage) as pourcentage,
                        sum(detail.montant_periode) as montant_periode ,
                        sum(detail.montant_anterieur) as montant_anterieur,
                        sum(detail.montant_anterieur)+sum(detail.montant_periode) as montant_cumul,
                        ((sum(detail.montant_periode)*(sum(detail.pourcentage)))/sum(detail.montant_prevu)) as pourcentage_periode,
                        ((sum(detail.montant_anterieur)*(sum(detail.pourcentage)))/sum(detail.montant_prevu)) as pourcentage_anterieur,
                        (((sum(detail.montant_anterieur)+sum(detail.montant_periode))*(sum(detail.pourcentage)))/sum(detail.montant_prevu)) as pourcentage_cumul

                    from
                (
                select 
                        rubrique_calendrier.id as id, 
                        rubrique_calendrier.libelle as libelle,
                        sum(calendrier_paie_moe_prevu.montant_prevu) as montant_prevu,
                        0 as pourcentage,
                        0 as montant_periode,
                        0 as montant_anterieur

                    from divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu
            
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique
                        left join divers_rubrique_calendrier_paie_moe as rubrique_calendrier on rubrique_calendrier.id = sousrubrique_calendrier.id_rubrique  
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude."
            
                        group by rubrique_calendrier.id 
                UNION 

                select 
                        rubrique_calendrier.id as id, 
                        rubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        sum(sousrubrique_calendrier_detail.pourcentage) as pourcentage,
                        0 as montant_periode,
                        0 as montant_anterieur  

                    from divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail
            
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique
                        left join divers_rubrique_calendrier_paie_moe as rubrique_calendrier on rubrique_calendrier.id = sousrubrique_calendrier.id_rubrique  
            
                        group by rubrique_calendrier.id 
                UNION 

                select 
                        rubrique_calendrier.id as id, 
                        rubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        0 as pourcentage, 
                        sum(fact_detail.montant_periode) as montant_periode,
                        0 as montant_anterieur 

                    from facture_moe_detail as fact_detail
                        left join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique
                        left join divers_rubrique_calendrier_paie_moe as rubrique_calendrier on rubrique_calendrier.id = sousrubrique_calendrier.id_rubrique
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and fact_detail.id_facture_moe_entete = ".$id_facture_moe_entete."
            
                        group by rubrique_calendrier.id 
                UNION

                select 
                        rubrique_calendrier.id as id, 
                        rubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        0 as pourcentage, 
                        0 as montant_periode, 
                        sum(fact_detail.montant_periode) as montant_anterieur 

                    from facture_moe_detail as fact_detail
                        inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        inner join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique
                        inner join divers_rubrique_calendrier_paie_moe as rubrique_calendrier on rubrique_calendrier.id = sousrubrique_calendrier.id_rubrique
                        inner join facture_moe_entete as fact_entete on fact_entete.id=fact_detail.id_facture_moe_entete
                
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and fact_entete.id<".$id_facture_moe_entete." and fact_entete.validation=2 
            
                        group by rubrique_calendrier.id 
                UNION

                
                select 
                        rubrique_calendrier.id as id,
                        rubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        0 as pourcentage,
                        0 as montant_periode,
                        0 as montant_anterieur   

                    from divers_rubrique_calendrier_paie_moe as rubrique_calendrier
            
                        group by rubrique_calendrier.id) detail
                group by detail.id order by detail.id ";
        return $this->db->query($sql)->result();                
    }
     /*public function getrubrique_calendrier_moewithmontantByentetecontrat($id_contrat_bureau_etude,$id_facture_moe_entete) {
        $sql="
                select detail.id as id,  
                        detail.libelle as libelle,
                        sum(detail.montant_prevu) as montant_prevu ,
                        sum(detail.pourcentage) as pourcentage,
                        sum(detail.montant_periode) as montant_periode ,
                        sum(detail.montant_anterieur) as montant_anterieur,
                        sum(detail.montant_anterieur)+sum(detail.montant_periode) as montant_cumul,
                        ((sum(detail.montant_periode)*100)/sum(detail.montant_prevu)) as pourcentage_periode,
                        ((sum(detail.montant_anterieur)*100)/sum(detail.montant_prevu)) as pourcentage_anterieur,
                        (((sum(detail.montant_anterieur)+sum(detail.montant_periode))*100)/sum(detail.montant_prevu)) as pourcentage_cumul

                    from
                (
                select 
                        rubrique_calendrier.id as id, 
                        rubrique_calendrier.libelle as libelle,
                        sum(calendrier_paie_moe_prevu.montant_prevu) as montant_prevu,
                        0 as pourcentage,
                        0 as montant_periode,
                        0 as montant_anterieur

                    from divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu
            
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique
                        left join divers_rubrique_calendrier_paie_moe as rubrique_calendrier on rubrique_calendrier.id = sousrubrique_calendrier.id_rubrique  
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude."
            
                        group by rubrique_calendrier.id 
                UNION 

                select 
                        rubrique_calendrier.id as id, 
                        rubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        sum(sousrubrique_calendrier_detail.pourcentage) as pourcentage,
                        0 as montant_periode,
                        0 as montant_anterieur  

                    from divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail
            
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique
                        left join divers_rubrique_calendrier_paie_moe as rubrique_calendrier on rubrique_calendrier.id = sousrubrique_calendrier.id_rubrique  
            
                        group by rubrique_calendrier.id 
                UNION 

                select 
                        rubrique_calendrier.id as id, 
                        rubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        0 as pourcentage, 
                        sum(fact_detail.montant_periode) as montant_periode,
                        0 as montant_anterieur 

                    from facture_moe_detail as fact_detail
                        left join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique
                        left join divers_rubrique_calendrier_paie_moe as rubrique_calendrier on rubrique_calendrier.id = sousrubrique_calendrier.id_rubrique
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and fact_detail.id_facture_moe_entete = ".$id_facture_moe_entete."
            
                        group by rubrique_calendrier.id 
                UNION

                select 
                        rubrique_calendrier.id as id, 
                        rubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        0 as pourcentage, 
                        0 as montant_periode, 
                        sum(fact_detail.montant_periode) as montant_anterieur 

                    from facture_moe_detail as fact_detail
                        inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        inner join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique
                        inner join divers_rubrique_calendrier_paie_moe as rubrique_calendrier on rubrique_calendrier.id = sousrubrique_calendrier.id_rubrique
                        inner join facture_moe_entete as fact_entete on fact_entete.id=fact_detail.id_facture_moe_entete
                
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and fact_entete.id<".$id_facture_moe_entete." and fact_entete.validation=4 
            
                        group by rubrique_calendrier.id 
                UNION

                
                select 
                        rubrique_calendrier.id as id,
                        rubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        0 as pourcentage,
                        0 as montant_periode,
                        0 as montant_anterieur   

                    from divers_rubrique_calendrier_paie_moe as rubrique_calendrier
            
                        group by rubrique_calendrier.id) detail
                group by detail.id order by detail.id ";
        return $this->db->query($sql)->result();                
    }*/
     public function getrubrique_attachement_withmontantbycontrat($id_contrat_prestataire,$id_demande_batiment) {
        $sql="
                select detail.id as id, 
                        detail.numero as numero, 
                        detail.libelle as libelle,
                        sum(detail.montant_prevu) as montant_prevu,
                        sum(detail.montant_periode) as montant_periode,
                        sum(detail.montant_anterieur) as montant_anterieur,
                        (sum(detail.montant_anterieur)+sum(detail.montant_periode)) as montant_cumul,
                        (((sum(detail.montant_anterieur)+sum(detail.montant_periode))*100)/sum(detail.montant_prevu)) as pourcentage,
                        ((sum(detail.montant_periode)*100)/sum(detail.montant_prevu)) as pourcentage_periode,
                        ((sum(detail.montant_anterieur)*100)/sum(detail.montant_prevu)) as pourcentage_anterieur 

                    from
                (
                select 
                        attache_batiment.id as id, 
                        attache_batiment.numero as numero, 
                        attache_batiment.libelle as libelle,
                        sum(attache_batiment_prevu.montant_prevu) as montant_prevu,
                        0 as montant_periode,
                        0 as montant_anterieur,
                        0 as montant_cumul   

                    from divers_attachement_batiment_prevu as attache_batiment_prevu
            
                        inner join divers_attachement_batiment_detail as attache_batiment_detail on attache_batiment_detail.id = attache_batiment_prevu.id_attachement_batiment_detail
                        inner join divers_attachement_batiment as attache_batiment on attache_batiment.id = attache_batiment_detail.id_attachement_batiment 
            
                        where attache_batiment_prevu.id_contrat_prestataire = ".$id_contrat_prestataire."
            
                        group by attache_batiment.id
                UNION 

                select 
                        attache_batiment.id as id, 
                        attache_batiment.numero as numero, 
                        attache_batiment.libelle as libelle,
                        0 as montant_prevu,
                        sum(attache_batiment_travaux.montant_periode) as montant_periode,
                        0 as montant_anterieur,
                        0 as montant_cumul   

                    from demande_batiment_presta as demande
            
                        inner join divers_attachement_batiment_travaux as attache_batiment_travaux  on demande.id = attache_batiment_travaux .id_demande_batiment_mpe
                        inner join divers_attachement_batiment_prevu as attache_batiment_prevu on attache_batiment_prevu.id = attache_batiment_travaux.id_attachement_batiment_prevu
                        inner join divers_attachement_batiment_detail as attache_batiment_detail on attache_batiment_detail.id = attache_batiment_prevu.id_attachement_batiment_detail
                        inner join divers_attachement_batiment as attache_batiment on attache_batiment.id = attache_batiment_detail.id_attachement_batiment 
            
                        where attache_batiment_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and demande.id = ".$id_demande_batiment."
            
                        group by attache_batiment.id
                UNION

                select 
                        attache_batiment.id as id, 
                        attache_batiment.numero as numero, 
                        attache_batiment.libelle as libelle,
                        0 as montant_prevu,
                        0 as montant_periode,
                        sum(attache_batiment_travaux.montant_periode) as montant_anterieur,
                        0 as montant_cumul   

                    from demande_batiment_presta as demande
            
                        inner join divers_attachement_batiment_travaux as attache_batiment_travaux  on demande.id = attache_batiment_travaux .id_demande_batiment_mpe
                        inner join divers_attachement_batiment_prevu as attache_batiment_prevu on attache_batiment_prevu.id = attache_batiment_travaux.id_attachement_batiment_prevu
                        inner join divers_attachement_batiment_detail as attache_batiment_detail on attache_batiment_detail.id = attache_batiment_prevu.id_attachement_batiment_detail
                        inner join divers_attachement_batiment as attache_batiment on attache_batiment.id = attache_batiment_detail.id_attachement_batiment 
                        inner join attachement_travaux as atta_tra on atta_tra.id=demande.id_attachement_travaux
                        inner join facture_mpe as fact_mpe on fact_mpe.id_attachement_travaux=atta_tra.id
                        where attache_batiment_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and fact_mpe.validation=4 and demande.id= (select max(dem_batiment.id) from demande_batiment_presta as dem_batiment 
                            inner join attachement_travaux as atta_tra on atta_tra.id=dem_batiment.id_attachement_travaux
                            inner join facture_mpe as fact_mpe on fact_mpe.id_attachement_travaux=atta_tra.id where attache_batiment_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and fact_mpe.validation=4 and dem_batiment.id<".$id_demande_batiment.") 
            
                        group by attache_batiment.id
                UNION

                select 
                        attache_batiment.id as id, 
                        attache_batiment.numero as numero, 
                        attache_batiment.libelle as libelle,
                        0 as montant_prevu,
                        0 as montant_periode,
                        0 as montant_anterieur,
                        0 as montant_cumul  

                    from divers_attachement_batiment as attache_batiment
            
                        group by attache_batiment.id) detail
                group by detail.id  ";
        return $this->db->query($sql)->result();                
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
