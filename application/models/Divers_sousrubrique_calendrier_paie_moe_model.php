<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Divers_sousrubrique_calendrier_paie_moe_model extends CI_Model {
    protected $table = 'divers_sousrubrique_calendrier_paie_moe';

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
            'id_rubrique'    => $sousrubrique['id_rubrique']                      
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
    public function getsousrubriquebyrubrique($id_rubrique) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_rubrique',$id_rubrique)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
     public function getsousrubriquewithmontant_prevubycontrat($id_contrat_bureau_etude,$id_rubrique) {
        $sql="
                select detail.id as id,  
                        detail.libelle as libelle,
                        sum(detail.montant_prevu) as montant_prevu 

                    from
                (
                select 
                        sousrubrique_calendrier.id as id, 
                        sousrubrique_calendrier.libelle as libelle,
                        sum(calendrier_paie_moe_prevu.montant_prevu) as montant_prevu   

                    from divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu
            
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique  
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
            
                        group by sousrubrique_calendrier.id 
                UNION 

                
                select 
                        sousrubrique_calendrier.id as id,
                        sousrubrique_calendrier.libelle as libelle,
                        0 as montant_prevu   

                    from divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier 
                    where sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
            
                        group by sousrubrique_calendrier.id) detail
                group by detail.id order by detail.id ";
        return $this->db->query($sql)->result();                
    }

    
    public function getsousrubrique_calendrier_moewithmontantByentetecontrat($id_contrat_bureau_etude,$id_facture_moe_entete,$id_rubrique) {
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
                        sousrubrique_calendrier.id as id, 
                        sousrubrique_calendrier.libelle as libelle,
                        sum(calendrier_paie_moe_prevu.montant_prevu) as montant_prevu,
                        0 as pourcentage,
                        0 as montant_periode,
                        0 as montant_anterieur 

                    from divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu
            
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique  
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
            
                        group by sousrubrique_calendrier.id 
                UNION 

                select 
                        sousrubrique_calendrier.id as id, 
                        sousrubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        sum(sousrubrique_calendrier_detail.pourcentage) as pourcentage,
                        0 as montant_periode,
                        0 as montant_anterieur  

                    from divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail
            
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique  
                        where sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
                        group by sousrubrique_calendrier.id 
                UNION 

                select 
                        sousrubrique_calendrier.id as id, 
                        sousrubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        0 as pourcentage, 
                        sum(fact_detail.montant_periode) as montant_periode,
                        0 as montant_anterieur 

                    from facture_moe_detail as fact_detail
                        left join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and fact_detail.id_facture_moe_entete = ".$id_facture_moe_entete." and sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
            
                        group by sousrubrique_calendrier.id 
                UNION

                select 
                        sousrubrique_calendrier.id as id, 
                        sousrubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        0 as pourcentage, 
                        0 as montant_periode, 
                        sum(fact_detail.montant_periode) as montant_anterieur

                    from facture_moe_detail as fact_detail
                        inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        inner join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique
                        inner join facture_moe_entete as fact_entete on fact_entete.id=fact_detail.id_facture_moe_entete

                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and fact_entete.id<".$id_facture_moe_entete." and fact_entete.validation=2 and sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
            
                        group by sousrubrique_calendrier.id 
                UNION
                
                select 
                        sousrubrique_calendrier.id as id,
                        sousrubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        0 as pourcentage,
                        0 as montant_periode,
                        0 as montant_anterieur  

                    from divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier 
                    where sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
            
                        group by sousrubrique_calendrier.id) detail
                group by detail.id order by detail.id ";
        return $this->db->query($sql)->result();                
    }
/*
     public function getsousrubrique_calendrier_moewithmontantByentetecontrat($id_contrat_bureau_etude,$id_facture_moe_entete,$id_rubrique) {
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
                        sousrubrique_calendrier.id as id, 
                        sousrubrique_calendrier.libelle as libelle,
                        sum(calendrier_paie_moe_prevu.montant_prevu) as montant_prevu,
                        0 as pourcentage,
                        0 as montant_periode,
                        0 as montant_anterieur 

                    from divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu
            
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique  
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
            
                        group by sousrubrique_calendrier.id 
                UNION 

                select 
                        sousrubrique_calendrier.id as id, 
                        sousrubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        sum(sousrubrique_calendrier_detail.pourcentage) as pourcentage,
                        0 as montant_periode,
                        0 as montant_anterieur  

                    from divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail
            
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique  
                        where sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
                        group by sousrubrique_calendrier.id 
                UNION 

                select 
                        sousrubrique_calendrier.id as id, 
                        sousrubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        0 as pourcentage, 
                        sum(fact_detail.montant_periode) as montant_periode,
                        0 as montant_anterieur 

                    from facture_moe_detail as fact_detail
                        left join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and fact_detail.id_facture_moe_entete = ".$id_facture_moe_entete." and sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
            
                        group by sousrubrique_calendrier.id 
                UNION

                select 
                        sousrubrique_calendrier.id as id, 
                        sousrubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        0 as pourcentage, 
                        0 as montant_periode, 
                        sum(fact_detail.montant_periode) as montant_anterieur

                    from facture_moe_detail as fact_detail
                        inner join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        inner join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        inner join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique
                        inner join facture_moe_entete as fact_entete on fact_entete.id=fact_detail.id_facture_moe_entete

                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and fact_entete.id<".$id_facture_moe_entete." and fact_entete.validation=4 and sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
            
                        group by sousrubrique_calendrier.id 
                UNION
                
                select 
                        sousrubrique_calendrier.id as id,
                        sousrubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        0 as pourcentage,
                        0 as montant_periode,
                        0 as montant_anterieur  

                    from divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier 
                    where sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
            
                        group by sousrubrique_calendrier.id) detail
                group by detail.id order by detail.id ";
        return $this->db->query($sql)->result();                
    }*/



  /*   public function getsousrubrique_calendrier_moewithmontantByentetecontrat($id_contrat_bureau_etude,$id_facture_moe_entete,$id_rubrique) {
        $sql="
                select detail.id as id,  
                        detail.libelle as libelle,
                        sum(detail.montant_prevu) as montant_prevu ,
                        sum(detail.pourcentage) as pourcentage,
                        sum(detail.montant_periode) as montant_periode ,
                        sum(detail.montant_anterieur) as montant_anterieur,
                        sum(detail.montant_cumul)+sum(detail.montant_periode) as montant_cumul,
                        ((sum(detail.montant_periode)*100)/sum(detail.montant_prevu)) as pourcentage_periode,
                        ((sum(detail.montant_anterieur)*100)/sum(detail.montant_prevu)) as pourcentage_anterieur,
                        ((sum(detail.montant_cumul)*100)/sum(detail.montant_prevu)) as pourcentage_cumul

                    from
                (
                select 
                        sousrubrique_calendrier.id as id, 
                        sousrubrique_calendrier.libelle as libelle,
                        sum(calendrier_paie_moe_prevu.montant_prevu) as montant_prevu,
                        0 as pourcentage,
                        0 as montant_periode,
                        0 as montant_anterieur,
                        0 as montant_cumul  

                    from divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu
            
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique  
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
            
                        group by sousrubrique_calendrier.id 
                UNION 

                select 
                        sousrubrique_calendrier.id as id, 
                        sousrubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        sum(sousrubrique_calendrier_detail.pourcentage) as pourcentage,
                        0 as montant_periode,
                        0 as montant_anterieur,
                        0 as montant_cumul   

                    from divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail
            
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique  
                        where sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
                        group by sousrubrique_calendrier.id 
                UNION 

                select 
                        sousrubrique_calendrier.id as id, 
                        sousrubrique_calendrier.libelle as libelle,
                        sum(calendrier_paie_moe_prevu.montant_prevu) as montant_prevu,
                        0 as pourcentage, 
                        sum(fact_detail.montant_periode) as montant_periode,
                        0 as montant_anterieur,
                        0 as montant_cumul  

                    from facture_moe_detail as fact_detail
                        left join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and fact_detail.id_facture_moe_entete = ".$id_facture_moe_entete." and sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
            
                        group by sousrubrique_calendrier.id 
                UNION

                select 
                        sousrubrique_calendrier.id as id, 
                        sousrubrique_calendrier.libelle as libelle,
                        sum(calendrier_paie_moe_prevu.montant_prevu) as montant_prevu,
                        0 as pourcentage, 
                        0 as montant_periode, 
                        sum(fact_detail.montant_periode) as montant_anterieur,
                        0 as montant_cumul  

                    from facture_moe_detail as fact_detail
                        left join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and fact_detail.id_facture_moe_entete = (select max(f_entete.id) from facture_moe_entete as f_entete where f_entete.id<".$id_facture_moe_entete." and f_entete.id_contrat_bureau_etude = ".$id_contrat_bureau_etude.") and sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
            
                        group by sousrubrique_calendrier.id 
                UNION

                select 
                        sousrubrique_calendrier.id as id, 
                        sousrubrique_calendrier.libelle as libelle,
                        sum(calendrier_paie_moe_prevu.montant_prevu) as montant_prevu,
                        0 as pourcentage, 
                        0 as montant_periode, 
                        0 as montant_anterieur, 
                        sum(fact_detail.montant_periode) as montant_cumul  

                    from facture_moe_detail as fact_detail
                        left join divers_calendrier_paie_moe_prevu as calendrier_paie_moe_prevu on calendrier_paie_moe_prevu.id = fact_detail.id_calendrier_paie_moe_prevu
                        left join divers_sousrubrique_calendrier_paie_moe_detail as sousrubrique_calendrier_detail on sousrubrique_calendrier_detail.id = calendrier_paie_moe_prevu.id_sousrubrique_detail
                        left join divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier on sousrubrique_calendrier.id = sousrubrique_calendrier_detail.id_sousrubrique
            
                        where calendrier_paie_moe_prevu.id_contrat_bureau_etude = ".$id_contrat_bureau_etude." and fact_detail.id_facture_moe_entete<".$id_facture_moe_entete." and sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
            
                        group by sousrubrique_calendrier.id 
                UNION

                
                select 
                        sousrubrique_calendrier.id as id,
                        sousrubrique_calendrier.libelle as libelle,
                        0 as montant_prevu,
                        0 as pourcentage,
                        0 as montant_periode,
                        0 as montant_anterieur,
                        0 as montant_cumul   

                    from divers_sousrubrique_calendrier_paie_moe as sousrubrique_calendrier 
                    where sousrubrique_calendrier.id_rubrique = ".$id_rubrique."
            
                        group by sousrubrique_calendrier.id) detail
                group by detail.id order by detail.id ";
        return $this->db->query($sql)->result();                
    }
*/


}
