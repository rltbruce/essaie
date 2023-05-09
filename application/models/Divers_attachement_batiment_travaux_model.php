<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Divers_attachement_batiment_travaux_model extends CI_Model {
    protected $table = 'divers_attachement_batiment_travaux';

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
            'id_demande_batiment_mpe'   =>      $attachement['id_demande_batiment_mpe'],
            'id_attachement_batiment_prevu'    => $attachement['id_attachement_batiment_prevu']                       
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
   /* public function finddivers_attachementByDemande($id_demande_batiment_mpe,$id_attachement_batiment)
    {               
        $result =  $this->db->select('divers_attachement_batiment_travaux.*')
                        ->from($this->table)
                        ->join('divers_attachement_batiment_prevu','divers_attachement_batiment_prevu.id=divers_attachement_batiment_travaux.id_attachement_batiment_prevu')
                        ->join('divers_attachement_batiment_detail','divers_attachement_batiment_detail.id=divers_attachement_batiment_prevu.id_attachement_batiment_detail')
                        ->where('id_attachement_batiment',$id_attachement_batiment)
                        ->where('id_demande_batiment_mpe',$id_demande_batiment_mpe)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }            
    }*/
   /* public function findmaxattachement_travauxByattachement_prevu($id_attachement_batiment_prevu,$id_contrat_prestataire)
    {               
        $sql = "select divers_attachement_batiment_travaux.*
                        from divers_attachement_batiment_travaux
                        inner join divers_attachement_batiment_prevu on divers_attachement_batiment_prevu.id=divers_attachement_batiment_travaux.id_attachement_batiment_prevu
                        where divers_attachement_batiment_travaux.id<(select max(id) from divers_attachement_batiment_travaux) and divers_attachement_batiment_prevu.id =".$id_attachement_batiment_prevu." and divers_attachement_batiment_prevu.id_contrat_prestataire =".$id_contrat_prestataire."";
        return $this->db->query($sql)->result();                  
    }
    public function findmax_1attachement_travauxByattachement_prevu($id_attachement_batiment_prevu,$id_contrat_prestataire)
    {               
        $sql = "select divers_attachement_batiment_travaux.*
                        from divers_attachement_batiment_travaux
                        inner join divers_attachement_batiment_prevu on divers_attachement_batiment_prevu.id=divers_attachement_batiment_travaux.id_attachement_batiment_prevu
                        where divers_attachement_batiment_travaux.id=(select max(id) from divers_attachement_batiment_travaux as attache_bat where attache_bat.id <(select max(id) from divers_attachement_batiment_travaux)) and divers_attachement_batiment_prevu.id =".$id_attachement_batiment_prevu." and divers_attachement_batiment_prevu.id_contrat_prestataire =".$id_contrat_prestataire."";
        return $this->db->query($sql)->result();                  
    }*/

 public function finddivers_attachementByDemande($id_contrat_prestataire,$id_demande_batiment_mpe,$id_attache_batiment)
    {               
        $this->db->select("
            attache_detail.id as id_attache_batiment_detail,
            attache_detail.libelle as libelle,
            attache_detail.numero as numero,
            divers_attachement_batiment_prevu.id as id_attachement_batiment_prevu,
            divers_attachement_batiment_prevu.unite as unite,
            divers_attachement_batiment_prevu.montant_prevu as montant_prevu,
            divers_attachement_batiment_prevu.quantite_prevu as quantite_prevu,
            divers_attachement_batiment_prevu.prix_unitaire as prix_unitaire,
            divers_attachement_batiment_prevu.id_contrat_prestataire as id_contra_prestataire,
            divers_attachement_batiment.id as id_attachemen_batiment");
        
              $this->db ->select("(
                    select 
                        attache_travauxgene.id

                        from 
                            divers_attachement_batiment_travaux as attache_travauxgene
                           
                                inner join divers_attachement_batiment_prevu as attache_prevugene 
                                        on attache_travauxgene.id_attachement_batiment_prevu = attache_prevugene.id
                                inner join divers_attachement_batiment_detail as attache_detailgene 
                                        on attache_prevugene.id_attachement_batiment_detail = attache_detailgene.id 
                                inner join divers_attachement_batiment as attache_batimentgene 
                                        on attache_detailgene.id_attachement_batiment = attache_batimentgene.id
            
                            where 
                                attache_detailgene.id=id_attache_batiment_detail
                                and attache_prevugene.id_contrat_prestataire = ".$id_contrat_prestataire." 
                                and attache_travauxgene.id_demande_batiment_mpe =".$id_demande_batiment_mpe."
                                and attache_batimentgene.id=id_attachemen_batiment
                        ) as id",FALSE);

              $this->db ->select("(
                    select 
                        attache_travauxmp.montant_periode 

                        from 
                            divers_attachement_batiment_travaux as attache_travauxmp
                           
                                inner join divers_attachement_batiment_prevu as attache_prevump 
                                        on attache_travauxmp.id_attachement_batiment_prevu = attache_prevump.id
                                inner join divers_attachement_batiment_detail as attache_detailmp 
                                        on attache_prevump.id_attachement_batiment_detail = attache_detailmp.id 
                                inner join divers_attachement_batiment as attache_batimentmp 
                                        on attache_detailmp.id_attachement_batiment = attache_batimentmp.id
            
                            where 
                                attache_detailmp.id=id_attache_batiment_detail
                                and attache_prevump.id_contrat_prestataire = ".$id_contrat_prestataire." 
                                and attache_travauxmp.id_demande_batiment_mpe =".$id_demande_batiment_mpe."
                                and attache_batimentmp.id=id_attachemen_batiment
                        ) as montant_periode",FALSE);

                $this->db ->select("(
                    select 
                        attache_travauxqp.quantite_periode 

                        from 
                            divers_attachement_batiment_travaux as attache_travauxqp
                                
                                inner join divers_attachement_batiment_prevu as attache_prevuqp 
                                        on attache_travauxqp.id_attachement_batiment_prevu = attache_prevuqp.id
                                inner join divers_attachement_batiment_detail as attache_detailqp 
                                        on attache_prevuqp.id_attachement_batiment_detail = attache_detailqp.id 
                                inner join divers_attachement_batiment as attache_batimentqp 
                                        on attache_detailqp.id_attachement_batiment = attache_batimentqp.id
            
                        where 
                            attache_detailqp.id=id_attache_batiment_detail
                            and attache_prevuqp.id_contrat_prestataire = ".$id_contrat_prestataire." 
                            and attache_travauxqp.id_demande_batiment_mpe = ".$id_demande_batiment_mpe."
                            and attache_batimentqp.id=id_attachemen_batiment

                        ) as quantite_periode",FALSE);

                $this->db ->select("(
                    select 
                        sum(attache_travaux_batma.montant_periode) 

                        from 
                            divers_attachement_batiment_travaux as attache_travaux_batma
                                
                                inner join divers_attachement_batiment_prevu as attache_prevuma 
                                        on attache_travaux_batma.id_attachement_batiment_prevu = attache_prevuma.id
                                inner join divers_attachement_batiment_detail as attache_detailma 
                                        on attache_prevuma.id_attachement_batiment_detail = attache_detailma.id 
                                inner join divers_attachement_batiment as attache_batimentma 
                                        on attache_detailma.id_attachement_batiment = attache_batimentma.id
                                inner join demande_batiment_presta as demande_bat_prestama 
                                        on demande_bat_prestama.id=attache_travaux_batma.id_demande_batiment_mpe
                                inner join attachement_travaux as atta_tra_ma 
                                        on atta_tra_ma.id=demande_bat_prestama.id_attachement_travaux
                                inner join facture_mpe as fact_ma on fact_ma.id_attachement_travaux = atta_tra_ma.id
            
                        where 
                            attache_detailma.id=id_attache_batiment_detail
                            and attache_prevuma.id_contrat_prestataire = ".$id_contrat_prestataire."
                            and fact_ma.validation=4 
                            and attache_travaux_batma.id_demande_batiment_mpe < ".$id_demande_batiment_mpe."
                            and attache_batimentma.id=".$id_attache_batiment."
                        ) as montant_anterieur",FALSE);
                
                $this->db ->select("(
                    select 
                        sum(attache_travaux_batqa.quantite_periode) 

                        from 
                            divers_attachement_batiment_travaux as attache_travaux_batqa
                                
                                inner join divers_attachement_batiment_prevu as attache_prevuqa 
                                        on attache_travaux_batqa.id_attachement_batiment_prevu = attache_prevuqa.id
                                inner join divers_attachement_batiment_detail as attache_detailqa 
                                        on attache_prevuqa.id_attachement_batiment_detail = attache_detailqa.id 
                                inner join divers_attachement_batiment as attache_batimentqa 
                                        on attache_detailqa.id_attachement_batiment = attache_batimentqa.id
                                inner join demande_batiment_presta as demande_bat_prestaqa 
                                        on demande_bat_prestaqa.id=attache_travaux_batqa.id_demande_batiment_mpe
                                inner join attachement_travaux as atta_tra_qa 
                                        on atta_tra_qa.id=demande_bat_prestaqa.id_attachement_travaux
                                inner join facture_mpe as fact_qa on fact_qa.id_attachement_travaux = atta_tra_qa.id
            
                        where 
                            attache_detailqa.id=id_attache_batiment_detail
                            and attache_prevuqa.id_contrat_prestataire = ".$id_contrat_prestataire." 
                            and attache_travaux_batqa.id_demande_batiment_mpe < ".$id_demande_batiment_mpe."
                            and attache_batimentqa.id=id_attachemen_batiment and fact_qa.validation=4
                        ) as quantite_anterieur",FALSE);

            $result =  $this->db->from('divers_attachement_batiment_detail as attache_detail')
                    
                    ->join('divers_attachement_batiment_prevu','attache_detail.id= divers_attachement_batiment_prevu.id_attachement_batiment_detail')
                    ->join('divers_attachement_batiment','attache_detail.id_attachement_batiment = divers_attachement_batiment.id')
                    ->where('divers_attachement_batiment_prevu.id_contrat_prestataire',$id_contrat_prestataire)
                    ->where('divers_attachement_batiment.id',$id_attache_batiment)
                    ->group_by('id_attachement_batiment_detail')
                                       
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
 /*  public function finddivers_attachementByDemande($id_contrat_prestataire,$id_demande_batiment_mpe,$id_attache_batiment) {
        $sql="
                select  detail.libelle as libelle,
                        detail.numero as numero,
                        detail.id_attachement_batiment_detail as id_attachement_batiment_detail,
                        detail.id_attachement_batiment_prevu as id_attachement_batiment_prevu,
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
                        attache_detail.id as id_attachement_batiment_detail,
                        attache_prevu.id as id_attachement_batiment_prevu,
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

                    from divers_attachement_batiment_travaux as attache_travaux
            
                        inner join divers_attachement_batiment_prevu as attache_prevu on attache_travaux.id_attachement_batiment_prevu = attache_prevu.id
                        inner join divers_attachement_batiment_detail as attache_detail on attache_prevu.id_attachement_batiment_detail = attache_detail.id 
                        inner join divers_attachement_batiment as attache_batiment on attache_detail.id_attachement_batiment = attache_batiment.id
            
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and attache_travaux.id_demande_batiment_mpe = ".$id_demande_batiment_mpe." and attache_batiment.id = ".$id_attache_batiment."
            
                        group by attache_detail.id 
                UNION 

                select  
                         
                        attache_detail.id as id_attachement_batiment_detail,
                        attache_prevu.id as id_attachement_batiment_prevu,
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

                    from divers_attachement_batiment_travaux as attache_travaux
            
                        inner join divers_attachement_batiment_prevu as attache_prevu on attache_travaux.id_attachement_batiment_prevu = attache_prevu.id
                        inner join divers_attachement_batiment_detail as attache_detail on attache_prevu.id_attachement_batiment_detail = attache_detail.id 
                        inner join divers_attachement_batiment as attache_batiment on attache_detail.id_attachement_batiment = attache_batiment.id
                        inner join facture_mpe as fact on fact.id_attachement_travaux = attache_travaux.id
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and attache_batiment.id = ".$id_attache_batiment." and attache_travaux.id_demande_batiment_mpe =(select max(id) from divers_attachement_batiment_travaux as div_atta_bat_tra where div_atta_bat_tra.id_demande_batiment_mpe <".$id_demande_batiment_mpe.") and fact.validation=4
            
                        group by attache_detail.id
                UNION 

                select  
                         
                        attache_detail.id as id_attachement_batiment_detail,
                        attache_prevu.id as id_attachement_batiment_prevu,
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

                    from divers_attachement_batiment_travaux as attache_travaux
            
                        inner join divers_attachement_batiment_prevu as attache_prevu on attache_travaux.id_attachement_batiment_prevu = attache_prevu.id
                        inner join divers_attachement_batiment_detail as attache_detail on attache_prevu.id_attachement_batiment_detail = attache_detail.id 
                        inner join divers_attachement_batiment as attache_batiment on attache_detail.id_attachement_batiment = attache_batiment.id
                        inner join facture_mpe as fact on fact.id_attachement_travaux = attache_travaux.id
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and attache_batiment.id = ".$id_attache_batiment." and attache_travaux.id_demande_batiment_mpe <".$id_demande_batiment_mpe." and fact.validation=4
            
                        group by attache_detail.id
                UNION 

                select  
                         
                        attache_detail.id as id_attachement_batiment_detail,
                        attache_prevu.id as id_attachement_batiment_prevu,
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

                    from divers_attachement_batiment_prevu as attache_prevu
                        inner join divers_attachement_batiment_detail as attache_detail on attache_prevu.id_attachement_batiment_detail = attache_detail.id 
                        inner join divers_attachement_batiment as attache_batiment on attache_detail.id_attachement_batiment = attache_batiment.id
                        where attache_prevu.id_contrat_prestataire = ".$id_contrat_prestataire." and attache_batiment.id = ".$id_attache_batiment."
            
                        group by attache_detail.id
                UNION 

                select  
                         
                        attache_detail.id as id_attachement_batiment_detail,
                        attache_prevu.id as id_attachement_batiment_prevu,
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

                    from divers_attachement_batiment_detail as attache_detail
                        inner join divers_attachement_batiment as attache_batiment on attache_detail.id_attachement_batiment = attache_batiment.id
                        inner join divers_attachement_batiment_prevu as attache_prevu on attache_detail.id= attache_prevu.id_attachement_batiment_detail
                        where attache_batiment.id = ".$id_attache_batiment."
            
                        group by attache_detail.id) detail
                group by detail.id_attachement_batiment_detail  ";
        return $this->db->query($sql)->result();                
    }*/


}
