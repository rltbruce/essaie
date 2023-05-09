<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Divers_attachement_mobilier_travaux_model extends CI_Model {
    protected $table = 'divers_attachement_mobilier_travaux';

    public function add($attachement) {
        $this->db->set($this->_set($attachement))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $attachement) {
        $this->db->set($this->_set($attachement))
                            ->where('id', (int) $id)
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
            'quantite_periode'       =>      $attachement['quantite_periode'],
            'quantite_anterieur'       =>      $attachement['quantite_anterieur'],
            'quantite_cumul'       =>      $attachement['quantite_cumul'],
            'montant_periode'       =>      $attachement['montant_periode'],
            'montant_anterieur'       =>      $attachement['montant_anterieur'],
            'montant_cumul'       =>      $attachement['montant_cumul'],
            'pourcentage'       =>      $attachement['pourcentage'],
            'id_demande_mobilier_mpe'   =>      $attachement['id_demande_mobilier_mpe'],
            'id_attachement_mobilier_prevu'    => $attachement['id_attachement_mobilier_prevu']                       
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


 public function finddivers_attachementByDemande($id_contrat_prestataire,$id_demande_mobilier_mpe,$id_attache_mobilier)
    {               
        $this->db->select("
            attache_detail.id as id_attache_mobilier_detail,
            attache_detail.libelle as libelle,
            attache_detail.numero as numero,
            divers_attachement_mobilier_prevu.id as id_attachement_mobilier_prevu,
            divers_attachement_mobilier_prevu.unite as unite,
            divers_attachement_mobilier_prevu.montant_prevu as montant_prevu,
            divers_attachement_mobilier_prevu.quantite_prevu as quantite_prevu,
            divers_attachement_mobilier_prevu.prix_unitaire as prix_unitaire,
            divers_attachement_mobilier_prevu.id_contrat_prestataire as id_contra_prestataire,
            divers_attachement_mobilier.id as id_attachemen_mobilier");
        
              $this->db ->select("(
                    select 
                        attache_travauxgene.id

                        from 
                            divers_attachement_mobilier_travaux as attache_travauxgene
                           
                                inner join divers_attachement_mobilier_prevu as attache_prevugene 
                                        on attache_travauxgene.id_attachement_mobilier_prevu = attache_prevugene.id
                                inner join divers_attachement_mobilier_detail as attache_detailgene 
                                        on attache_prevugene.id_attachement_mobilier_detail = attache_detailgene.id 
                                inner join divers_attachement_mobilier as attache_mobiliergene 
                                        on attache_detailgene.id_attachement_mobilier = attache_mobiliergene.id
            
                            where 
                                attache_detailgene.id=id_attache_mobilier_detail
                                and attache_prevugene.id_contrat_prestataire = ".$id_contrat_prestataire." 
                                and attache_travauxgene.id_demande_mobilier_mpe =".$id_demande_mobilier_mpe."
                                and attache_mobiliergene.id=id_attachemen_mobilier
                        ) as id",FALSE);

              $this->db ->select("(
                    select 
                        attache_travauxmp.montant_periode 

                        from 
                            divers_attachement_mobilier_travaux as attache_travauxmp
                           
                                inner join divers_attachement_mobilier_prevu as attache_prevump 
                                        on attache_travauxmp.id_attachement_mobilier_prevu = attache_prevump.id
                                inner join divers_attachement_mobilier_detail as attache_detailmp 
                                        on attache_prevump.id_attachement_mobilier_detail = attache_detailmp.id 
                                inner join divers_attachement_mobilier as attache_mobiliermp 
                                        on attache_detailmp.id_attachement_mobilier = attache_mobiliermp.id
            
                            where 
                                attache_detailmp.id=id_attache_mobilier_detail
                                and attache_prevump.id_contrat_prestataire = ".$id_contrat_prestataire." 
                                and attache_travauxmp.id_demande_mobilier_mpe =".$id_demande_mobilier_mpe."
                                and attache_mobiliermp.id=id_attachemen_mobilier
                        ) as montant_periode",FALSE);

                $this->db ->select("(
                    select 
                        attache_travauxqp.quantite_periode 

                        from 
                            divers_attachement_mobilier_travaux as attache_travauxqp
                                
                                inner join divers_attachement_mobilier_prevu as attache_prevuqp 
                                        on attache_travauxqp.id_attachement_mobilier_prevu = attache_prevuqp.id
                                inner join divers_attachement_mobilier_detail as attache_detailqp 
                                        on attache_prevuqp.id_attachement_mobilier_detail = attache_detailqp.id 
                                inner join divers_attachement_mobilier as attache_mobilierqp 
                                        on attache_detailqp.id_attachement_mobilier = attache_mobilierqp.id
            
                        where 
                            attache_detailqp.id=id_attache_mobilier_detail
                            and attache_prevuqp.id_contrat_prestataire = ".$id_contrat_prestataire." 
                            and attache_travauxqp.id_demande_mobilier_mpe = ".$id_demande_mobilier_mpe."
                            and attache_mobilierqp.id=id_attachemen_mobilier

                        ) as quantite_periode",FALSE);

                $this->db ->select("(
                    select 
                        sum(attache_travaux_mobma.montant_periode) 

                        from 
                            divers_attachement_mobilier_travaux as attache_travaux_mobma
                                
                                inner join divers_attachement_mobilier_prevu as attache_prevuma 
                                        on attache_travaux_mobma.id_attachement_mobilier_prevu = attache_prevuma.id
                                inner join divers_attachement_mobilier_detail as attache_detailma 
                                        on attache_prevuma.id_attachement_mobilier_detail = attache_detailma.id 
                                inner join divers_attachement_mobilier as attache_mobilierma 
                                        on attache_detailma.id_attachement_mobilier = attache_mobilierma.id
                                inner join demande_mobilier_presta as demande_mob_prestama 
                                        on demande_mob_prestama.id=attache_travaux_mobma.id_demande_mobilier_mpe
                                inner join attachement_travaux as atta_tra_ma 
                                        on atta_tra_ma.id=demande_mob_prestama.id_attachement_travaux
                                inner join facture_mpe as fact_ma on fact_ma.id_attachement_travaux = atta_tra_ma.id
            
                        where 
                            attache_detailma.id=id_attache_mobilier_detail
                            and attache_prevuma.id_contrat_prestataire = ".$id_contrat_prestataire."
                            and fact_ma.validation=4 
                            and attache_travaux_mobma.id_demande_mobilier_mpe < ".$id_demande_mobilier_mpe."
                            and attache_mobilierma.id=".$id_attache_mobilier."
                        ) as montant_anterieur",FALSE);
                
                $this->db ->select("(
                    select 
                        sum(attache_travaux_mobqa.quantite_periode) 

                        from 
                            divers_attachement_mobilier_travaux as attache_travaux_mobqa
                                
                                inner join divers_attachement_mobilier_prevu as attache_prevuqa 
                                        on attache_travaux_mobqa.id_attachement_mobilier_prevu = attache_prevuqa.id
                                inner join divers_attachement_mobilier_detail as attache_detailqa 
                                        on attache_prevuqa.id_attachement_mobilier_detail = attache_detailqa.id 
                                inner join divers_attachement_mobilier as attache_mobilierqa 
                                        on attache_detailqa.id_attachement_mobilier = attache_mobilierqa.id
                                inner join demande_mobilier_presta as demande_mob_prestaqa 
                                        on demande_mob_prestaqa.id=attache_travaux_mobqa.id_demande_mobilier_mpe
                                inner join attachement_travaux as atta_tra_qa 
                                        on atta_tra_qa.id=demande_mob_prestaqa.id_attachement_travaux
                                inner join facture_mpe as fact_qa on fact_qa.id_attachement_travaux = atta_tra_qa.id
            
                        where 
                            attache_detailqa.id=id_attache_mobilier_detail
                            and attache_prevuqa.id_contrat_prestataire = ".$id_contrat_prestataire." 
                            and attache_travaux_mobqa.id_demande_mobilier_mpe < ".$id_demande_mobilier_mpe."
                            and attache_mobilierqa.id=id_attachemen_mobilier and fact_qa.validation=4
                        ) as quantite_anterieur",FALSE);

            $result =  $this->db->from('divers_attachement_mobilier_detail as attache_detail')
                    
                    ->join('divers_attachement_mobilier_prevu','attache_detail.id= divers_attachement_mobilier_prevu.id_attachement_mobilier_detail')
                    ->join('divers_attachement_mobilier','attache_detail.id_attachement_mobilier = divers_attachement_mobilier.id')
                    ->where('divers_attachement_mobilier_prevu.id_contrat_prestataire',$id_contrat_prestataire)
                    ->where('divers_attachement_mobilier.id',$id_attache_mobilier)
                    ->group_by('id_attachement_mobilier_detail')
                                       
                    ->get()
                    ->result();


        if($result)
        {   
            return $result;
        }
        else
        {
            return $data=array();
        }               
    
    }
   /* public function finddivers_attachementByDemande($id_contrat_prestataire,$id_demande_mobilier_mpe,$id_attache_mobilier) {
        $sql="
                select  detail.libelle as libelle,
                        detail.numero as numero,
                        detail.id_attachement_mobilier_detail as id_attachement_mobilier_detail,
                        detail.id_attachement_mobilier_prevu as id_attachement_mobilier_prevu,
                        detail.id as id,
                        sum(detail.montant_periode) as montant_periode,
                        ((sum(detail.montant_periode) *100)/sum(detail.montant_prevu)) as pourcentage_periode,
                        sum(detail.montant_anterieur) as montant_anterieur,
                        ((sum(detail.montant_anterieur) *100)/sum(detail.montant_prevu)) as pourcentage_anterieur,
                        (sum(detail.montant_cumul)+sum(detail.montant_periode)) as montant_cumul,
                        (((sum(detail.montant_cumul)+sum(detail.montant_periode)) *100)/sum(detail.montant_prevu)) as pourcentage_cumul,
                        sum(detail.quantite_periode) as quantite_periode,
                        sum(detail.quantite_anterieur) as quantite_anterieur,
                        (sum(detail.quantite_cumul)+sum(detail.quantite_periode)) as quantite_cumul,
                        sum(detail.montant_prevu) as montant_prevu,
                        sum(detail.prix_unitaire) as prix_unitaire,
                        sum(detail.quantite_prevu) as quantite_prevu,
                        detail.unite as unite 

                    from
                (select  
                        attache_detail.id as id_attachement_mobilier_detail,
                        attache_prevu.id as id_attachement_mobilier_prevu,
                        attache_detail.libelle as libelle,
                        attache_detail.numero as numero,
                        attache_travaux.id as id,
                        attache_travaux.montant_periode as montant_periode,
                        attache_travaux.quantite_periode as quantite_periode,
                        0 as montant_anterieur,
                        0 as quantite_anterieur,
                        0 as montant_cumul,
                        0 as quantite_cumul,
                        0 as montant_prevu,
                        0 as quantite_prevu,
                        0 as prix_unitaire,                        
                        attache_prevu.unite as unite

                    from divers_attachement_mobilier_travaux as attache_travaux
            
                        inner join divers_attachement_mobilier_prevu as attache_prevu on attache_travaux.id_attachement_mobilier_prevu = attache_prevu.id
                        inner join divers_attachement_mobilier_detail as attache_detail on attache_prevu.id_attachement_mobilier_detail = attache_detail.id 
                        inner join divers_attachement_mobilier as attache_mobilier on attache_detail.id_attachement_mobilier = attache_mobilier.id
            
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and attache_travaux.id_demande_mobilier_mpe = ".$id_demande_mobilier_mpe." and attache_mobilier.id = ".$id_attache_mobilier."
            
                        group by attache_detail.id 
                UNION 

                select  
                         
                        attache_detail.id as id_attachement_mobilier_detail,
                        attache_prevu.id as id_attachement_mobilier_prevu,
                        attache_detail.libelle as libelle,
                        attache_detail.numero as numero,
                        attache_travaux.id as id,
                        0 as montant_periode,
                        0 as quantite_periode,
                        attache_travaux.montant_periode as montant_anterieur,
                        attache_travaux.quantite_periode as quantite_anterieur,
                        0 as montant_cumul,
                        0 as quantite_cumul,
                        0 as montant_prevu,
                        0 as quantite_prevu,
                        0 as prix_unitaire,
                        attache_prevu.unite as unite

                    from divers_attachement_mobilier_travaux as attache_travaux
            
                        inner join divers_attachement_mobilier_prevu as attache_prevu on attache_travaux.id_attachement_mobilier_prevu = attache_prevu.id
                        inner join divers_attachement_mobilier_detail as attache_detail on attache_prevu.id_attachement_mobilier_detail = attache_detail.id 
                        inner join divers_attachement_mobilier as attache_mobilier on attache_detail.id_attachement_mobilier = attache_mobilier.id
                        inner join facture_mpe as fact on fact.id_attachement_travaux = attache_travaux.id
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and attache_mobilier.id = ".$id_attache_mobilier." and attache_travaux.id_demande_mobilier_mpe =(select max(id) from divers_attachement_mobilier_travaux as div_atta_bat_tra where div_atta_bat_tra.id_demande_mobilier_mpe <".$id_demande_mobilier_mpe.") and fact.validation=4
            
                        group by attache_detail.id
                UNION 

                select  
                         
                        attache_detail.id as id_attachement_mobilier_detail,
                        attache_prevu.id as id_attachement_mobilier_prevu,
                        attache_detail.libelle as libelle,
                        attache_detail.numero as numero,
                        attache_travaux.id as id,
                        0 as montant_periode,
                        0 as quantite_periode,
                        0 as montant_anterieur,
                        0 as quantite_anterieur,
                        sum(attache_travaux.montant_periode) as montant_cumul,
                        sum(attache_travaux.quantite_periode) as quantite_cumul,
                        0 as montant_prevu,
                        0 as quantite_prevu,
                        0 as prix_unitaire,
                        attache_prevu.unite as unite

                    from divers_attachement_mobilier_travaux as attache_travaux
            
                        inner join divers_attachement_mobilier_prevu as attache_prevu on attache_travaux.id_attachement_mobilier_prevu = attache_prevu.id
                        inner join divers_attachement_mobilier_detail as attache_detail on attache_prevu.id_attachement_mobilier_detail = attache_detail.id 
                        inner join divers_attachement_mobilier as attache_mobilier on attache_detail.id_attachement_mobilier = attache_mobilier.id
                        inner join facture_mpe as fact on fact.id_attachement_travaux = attache_travaux.id
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and attache_mobilier.id = ".$id_attache_mobilier." and attache_travaux.id_demande_mobilier_mpe <".$id_demande_mobilier_mpe." and fact.validation=4
            
                        group by attache_detail.id
                UNION 

                select  
                         
                        attache_detail.id as id_attachement_mobilier_detail,
                        attache_prevu.id as id_attachement_mobilier_prevu,
                        attache_detail.libelle as libelle,
                        attache_detail.numero as numero,
                        0 as id,
                        0 as montant_periode,
                        0 as quantite_periode,
                        0 as montant_anterieur,
                        0 as quantite_anterieur,
                        0 as montant_cumul,
                        0 as quantite_cumul,
                        attache_prevu.montant_prevu as montant_prevu,
                        attache_prevu.quantite_prevu as quantite_prevu,
                        attache_prevu.prix_unitaire as prix_unitaire,
                        attache_prevu.unite as unite

                    from divers_attachement_mobilier_prevu as attache_prevu
                        inner join divers_attachement_mobilier_detail as attache_detail on attache_prevu.id_attachement_mobilier_detail = attache_detail.id 
                        inner join divers_attachement_mobilier as attache_mobilier on attache_detail.id_attachement_mobilier = attache_mobilier.id
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and attache_mobilier.id = ".$id_attache_mobilier."
            
                        group by attache_detail.id
                UNION 

                select  
                         
                        attache_detail.id as id_attachement_mobilier_detail,
                        attache_prevu.id as id_attachement_mobilier_prevu,
                        attache_detail.libelle as libelle,
                        attache_detail.numero as numero,
                        0 as id,
                        0 as montant_periode,
                        0 as quantite_periode,
                        0 as montant_anterieur,
                        0 as quantite_anterieur,
                        0 as montant_cumul,
                        0 as quantite_cumul,
                        0 as montant_prevu,
                        0 as quantite_prevu,
                        0 as prix_unitaire,
                        attache_prevu.unite as unite

                    from divers_attachement_mobilier_detail as attache_detail
                        inner join divers_attachement_mobilier as attache_mobilier on attache_detail.id_attachement_mobilier = attache_mobilier.id
                        inner join divers_attachement_mobilier_prevu as attache_prevu on attache_detail.id= attache_prevu.id_attachement_mobilier_detail
                        where attache_mobilier.id = ".$id_attache_mobilier."
            
                        group by attache_detail.id) detail
                group by detail.id_attachement_mobilier_detail  ";
        return $this->db->query($sql)->result();                
    }*/
   /* public function findmaxattachement_travauxByattachement_prevu($id_attachement_mobilier_prevu,$id_contrat_prestataire)
    {               
        $sql = "select divers_attachement_mobilier_travaux.*
                        from divers_attachement_mobilier_travaux
                        inner join divers_attachement_mobilier_prevu on divers_attachement_mobilier_prevu.id=divers_attachement_mobilier_travaux.id_attachement_mobilier_prevu
                        where divers_attachement_mobilier_travaux.id=(select max(id) from divers_attachement_mobilier_travaux) and divers_attachement_mobilier_prevu.id =".$id_attachement_mobilier_prevu." and divers_attachement_mobilier_prevu.id_contrat_prestataire =".$id_contrat_prestataire."";
        return $this->db->query($sql)->result();                  
    }
    public function findmax_1attachement_travauxByattachement_prevu($id_attachement_mobilier_prevu,$id_contrat_prestataire)
    {               
        $sql = "select divers_attachement_mobilier_travaux.*
                        from divers_attachement_mobilier_travaux
                        inner join divers_attachement_mobilier_prevu on divers_attachement_mobilier_prevu.id=divers_attachement_mobilier_travaux.id_attachement_mobilier_prevu
                        where divers_attachement_mobilier_travaux.id=(select max(id) from divers_attachement_mobilier_travaux as attache_mob where attache_mob.id <(select max(id) from divers_attachement_mobilier_travaux)) and divers_attachement_mobilier_prevu.id =".$id_attachement_mobilier_prevu." and divers_attachement_mobilier_prevu.id_contrat_prestataire =".$id_contrat_prestataire."";
        return $this->db->query($sql)->result();                  
    }*/

}
