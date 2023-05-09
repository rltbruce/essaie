<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pv_consta_entete_travaux_model extends CI_Model {
    protected $table = 'pv_consta_entete_travaux';

    public function add($pv_consta_entete_travaux) {
        $this->db->set($this->_set($pv_consta_entete_travaux))                
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $pv_consta_entete_travaux) {
        $this->db->set($this->_set($pv_consta_entete_travaux))
                //->set('date_approbation', 'NOW()', false)
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($pv_consta_entete_travaux) {
        return array(
            'numero' => $pv_consta_entete_travaux['numero'],
            'date_etablissement' => $pv_consta_entete_travaux['date_etablissement'],
            'montant_travaux' => $pv_consta_entete_travaux['montant_travaux'],
            'avancement_global_periode' => $pv_consta_entete_travaux['avancement_global_periode'],
            'avancement_global_cumul' => $pv_consta_entete_travaux['avancement_global_cumul'],
            'id_contrat_prestataire' => $pv_consta_entete_travaux['id_contrat_prestataire']                      
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
    public function getpv_consta_entete_valideBycontrat($id_contrat_prestataire)
    {

        $sql="select 
                    pv_consta_entete_trav.*

                    from pv_consta_entete_travaux as pv_consta_entete_trav
            
                        inner join facture_mpe as fact on pv_consta_entete_trav.id = fact.id_pv_consta_entete_travaux 
            
                        where pv_consta_entete_trav.id_contrat_prestataire = ".$id_contrat_prestataire." and fact.validation IN(1,2)
            
                        group by pv_consta_entete_trav.id ";
        return $this->db->query($sql)->result();               
    }
    
    public function getpv_consta_factureById($id_pv_consta_entete_travaux) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id',$id_pv_consta_entete_travaux)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    
    public function getpv_consta_rubrique_phase_pourcentagebycontrat($id_contrat_prestataire,$id_pv_consta_entete_travaux) {
        $this->db->select("pv_consta_entete_travaux.id as id_entete");
    
        $this->db ->select("(select pv_consta_detail_bat_travaux.id 
                                        
                                        from pv_consta_detail_bat_travaux,pv_consta_entete_travaux 
                                            
                                            where pv_consta_detail_bat_travaux.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id 
                                                    and pv_consta_detail_bat_travaux.id_pv_consta_entete_travaux=id_entete  
                                ) as id",FALSE);
            $this->db ->select("(select pv_consta_detail_bat_travaux.periode 
                                        
                                        from pv_consta_detail_bat_travaux,pv_consta_entete_travaux 
                                            
                                            where pv_consta_detail_bat_travaux.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id 
                                                    and pv_consta_detail_bat_travaux.id_rubrique_phase=id_phase  
                                                    and pv_consta_detail_bat_travaux.id_pv_consta_entete_travaux='".$id_pv_consta_entete_travaux."'
                                ) as periode",FALSE);
            
            $this->db ->select("(select pv_consta_detail_bat_travaux.observation 
                                        
                                from pv_consta_detail_bat_travaux,pv_consta_entete_travaux 
                                    
                                    where pv_consta_detail_bat_travaux.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id 
                                            and pv_consta_detail_bat_travaux.id_rubrique_phase=id_phase  
                                            and pv_consta_detail_bat_travaux.id_pv_consta_entete_travaux='".$id_pv_consta_entete_travaux."'
                        ) as observation",FALSE);

            $this->db ->select("(select sum(pv_consta_detail_bat_travaux.periode) 
                                        
                                from pv_consta_detail_bat_travaux,pv_consta_entete_travaux,facture_mpe 
                                    
                                    where pv_consta_detail_bat_travaux.id_pv_consta_entete_travaux=pv_consta_entete_travaux.id
                                            and pv_consta_entete_travaux.id=facture_mpe.id_pv_consta_entete_travaux 
                                            and pv_consta_entete_travaux.id_contrat_prestataire = '".$id_contrat_prestataire."' 
                                            and pv_consta_detail_bat_travaux.id_rubrique_phase=id_phase 
                                            and facture_mpe.validation=2 
                                            and pv_consta_detail_bat_travaux.id_pv_consta_entete_travaux<'".$id_pv_consta_entete_travaux."'
                                             
                        ) as anterieur",FALSE);
                
    
        $result =  $this->db->from('pv_consta_rubrique_phase_bat')
                            ->order_by('numero')
                            ->get()
                            ->result();
            if($result)
            {
                return $result;
            }else{
                return null;
            }                 
        }
    public function getpv_consta_entete_travauxvalideById($id_pv_consta_entete)
    {

        $sql="select 
                    pv_consta_entete_trav.*

                    from pv_consta_entete_travaux as pv_consta_entete_trav
            
                        inner join facture_mpe as fact on pv_consta_entete_trav.id = fact.id_pv_consta_entete_travaux 
            
                        where pv_consta_entete_trav.id = ".$id_pv_consta_entete." and fact.validation IN(1,2)
            
                        group by pv_consta_entete_trav.id ";
        return $this->db->query($sql)->result();               
    }
   /* public function findetatattachement_travauxBycontrat($id_contrat_prestataire)
    {  

        $sql="select 
                        attachement_trav.id as id, 
                        attachement_trav.numero as numero, 
                        attachement_trav.date_debut as date_debut, 
                        attachement_trav.date_fin as date_fin, 
                        attachement_trav.total_prevu as total_prevu, 
                        attachement_trav.total_periode as total_periode, 
                        attachement_trav.total_anterieur as total_anterieur, 
                        attachement_trav.total_cumul as total_cumul, 
                        attachement_trav.id_contrat_prestataire as id_contrat_prestataire, 
                        attachement_trav.validation as validation,
                        fact.id as id_fact,
                        fact.validation as validation_fact 

                    from attachement_travaux as attachement_trav
            
                        inner join facture_mpe as fact on attachement_trav.id = fact.id_attachement_travaux 
            
                        where attachement_trav.id_contrat_prestataire = ".$id_contrat_prestataire." and fact.validation>0
            
                        group by attachement_trav.id ";
        return $this->db->query($sql)->result();               
    }/*
   /* public function findattachement_travauxBycontrat($id_contrat_prestataire) {

        $sql="select 
                        attachement_trav.id as id, 
                        attachement_trav.numero as numero, 
                        attachement_trav.date_etablissement as date_etablissement, 
                        attachement_trav.avancement_global_periode as avancement_global_periode, 
                        attachement_trav.avancement_global_cumul as avancement_global_cumul, 
                        attachement_trav.id_contrat_prestataire as id_contrat_prestataire, 
                        attachement_trav.validation as validation,
                        fact.id as id_fact,
                        fact.validation as validation_fact 

                    from attachement_travaux as attachement_trav
            
                        left join facture_mpe as fact on attachement_trav.id = fact.id_attachement_travaux 
            
                        where attachement_trav.id_contrat_prestataire = ".$id_contrat_prestataire."
            
                        group by attachement_trav.id ";
        return $this->db->query($sql)->result();               
    }*/

    public function getpv_consta_entete_travauxBycontrat($id_contrat_prestataire)
    { 

        $sql="select 
                        pv_consta_entete_trav.id as id, 
                        pv_consta_entete_trav.numero as numero,
                        pv_consta_entete_trav.montant_travaux as montant_travaux,  
                        pv_consta_entete_trav.date_etablissement as date_etablissement, 
                        pv_consta_entete_trav.avancement_global_periode as avancement_global_periode, 
                        pv_consta_entete_trav.avancement_global_cumul as avancement_global_cumul, 
                        pv_consta_entete_trav.id_contrat_prestataire as id_contrat_prestataire, 
                        fact.id as id_fact,
                        fact.validation as validation_fact 

                    from pv_consta_entete_travaux as pv_consta_entete_trav
            
                        left join facture_mpe as fact on pv_consta_entete_trav.id = fact.id_pv_consta_entete_travaux 
            
                        where pv_consta_entete_trav.id_contrat_prestataire = ".$id_contrat_prestataire."
            ";
        return $this->db->query($sql)->result();               
    }
    public function getpv_consta_entete_travauxvalideBycontrat($id_contrat_prestataire)
    { 

        $sql="select 
                        pv_consta_entete_trav.id as id, 
                        pv_consta_entete_trav.numero as numero,
                        pv_consta_entete_trav.montant_travaux as montant_travaux,  
                        pv_consta_entete_trav.date_etablissement as date_etablissement, 
                        pv_consta_entete_trav.avancement_global_periode as avancement_global_periode, 
                        pv_consta_entete_trav.avancement_global_cumul as avancement_global_cumul, 
                        pv_consta_entete_trav.id_contrat_prestataire as id_contrat_prestataire, 
                        fact.id as id_fact,
                        fact.validation as validation_fact 

                    from pv_consta_entete_travaux as pv_consta_entete_trav
            
                        inner join facture_mpe as fact on pv_consta_entete_trav.id = fact.id_pv_consta_entete_travaux 
            
                        where pv_consta_entete_trav.id_contrat_prestataire = ".$id_contrat_prestataire." and fact.validation IN(1,2)
            ";
        return $this->db->query($sql)->result();               
    }
    public function getanvance_global_contrat($id_pv_consta_entete_travaux,$id_contrat_prestataire)
    {               
        $sql=" select 
                        detail.id as id,
                        detail.id_contrat as id_contrat_prestataire,
                     ((((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_bat))/100)+((((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_lat))/100)+((((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_mob))/100)  as periode_cumul,
                     (((((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_bat))/100)+((((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_bat))/100))+(((((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_lat))/100)+((((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_lat))/100))+(((((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_mob))/100)+((((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_mob))/100))  as total_cumul

               from (
               
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         sum(detail_bat_travaux.periode) as periode_bat,
                         0 as periode_lat,
                         0 as periode_mob,
                         0 as anterieur_bat,
                         0 as anterieur_lat,
                         0 as anterieur_mob,
                         contrat_mpe.cout_batiment as cout_batiment,
                         contrat_mpe.cout_latrine as cout_latrine,
                         contrat_mpe.cout_mobilier as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_bat_travaux as detail_bat_travaux on detail_bat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        inner join contrat_prestataire as contrat_mpe on contrat_mpe.id= entete_travaux.id_contrat_prestataire
                        where 
                        entete_travaux.id= '".$id_pv_consta_entete_travaux."'
                )
                UNION
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         0 as periode_bat,
                         sum(detail_lat_travaux.periode) as periode_lat,
                         0 as periode_mob,
                         0 as anterieur_bat,
                         0 as anterieur_lat,
                         0 as anterieur_mob,
                         0 as cout_batiment,
                         0 as cout_latrine,
                         0 as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_lat_travaux as detail_lat_travaux on detail_lat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        where 
                        entete_travaux.id= '".$id_pv_consta_entete_travaux."'
                )
                UNION
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         0 as periode_bat,
                         0 as periode_lat,
                         sum(detail_mob_travaux.periode) as periode_mob,
                         0 as anterieur_bat,
                         0 as anterieur_lat,
                         0 as anterieur_mob,
                         0 as cout_batiment,
                         0 as cout_latrine,
                         0 as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_mob_travaux as detail_mob_travaux on detail_mob_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        where 
                        entete_travaux.id= '".$id_pv_consta_entete_travaux."'
                )
                UNION
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         0 as periode_bat,
                         0 as periode_lat,
                         0 as periode_mob,
                         sum(detail_bat_travaux.periode) as anterieur_bat,
                         0 as anterieur_lat,
                         0 as anterieur_mob,
                         0 as cout_batiment,
                         0 as cout_latrine,
                         0 as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_bat_travaux as detail_bat_travaux on detail_bat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                        where 
                        entete_travaux.id< '".$id_pv_consta_entete_travaux."' and
                        entete_travaux.id_contrat_prestataire= '".$id_contrat_prestataire."' and
                        fact_mpe.validation=2
                ) 
                UNION
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         0 as periode_bat,
                         0 as periode_lat,
                         0 as periode_mob,
                         0 as anterieur_bat,
                         sum(detail_lat_travaux.periode) as anterieur_lat,
                         0 as anterieur_mob,
                         0 as cout_batiment,
                         0 as cout_latrine,
                         0 as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_lat_travaux as detail_lat_travaux on detail_lat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                        where 
                        entete_travaux.id< '".$id_pv_consta_entete_travaux."' and
                        entete_travaux.id_contrat_prestataire= '".$id_contrat_prestataire."' and
                        fact_mpe.validation=2
                )
                UNION
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         0 as periode_bat,
                         0 as periode_lat,
                         0 as periode_mob,
                         0 as anterieur_bat,
                         0 as anterieur_lat,
                         sum(detail_mob_travaux.periode) as anterieur_mob,
                         0 as cout_batiment,
                         0 as cout_latrine,
                         0 as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_mob_travaux as detail_mob_travaux on detail_mob_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                        where 
                        entete_travaux.id< '".$id_pv_consta_entete_travaux."' and
                        entete_travaux.id_contrat_prestataire= '".$id_contrat_prestataire."' and
                        fact_mpe.validation=2
                )  

                )detail

            ";
            return $this->db->query($sql)->result();             
    }
    public function getrecapByentete_travauxcontrat($id_pv_consta_entete_travaux,$id_contrat_prestataire)
    {               
        $sql=" select 
                        detail.id as id,
                        detail.id_contrat as id_contrat,
                       sum(detail.periode_bat) as cumul_periode_batiment,
                       sum( detail.periode_lat) as cumul_periode_latrine,
                       sum(detail.periode_mob) as cumul_periode_mobilier,
                       sum(detail.anterieur_bat) as cumul_anterieur_batiment,
                       sum( detail.anterieur_lat) as cumul_anterieur_latrine,
                       sum(detail.anterieur_mob) as cumul_anterieur_mobilier,
                       sum(detail.cout_batiment) as cout_bat,
                       sum(detail.cout_latrine) as cout_lat,
                       sum(detail.cout_mobilier) as cout_mob,
                       (sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)) as prevu_batiment,
                       (sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)) as prevu_latrine,
                       (sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)) as prevu_mobilier,
                       (((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_bat))/100  as periode_batiment,
                       (((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_lat))/100  as periode_latrine,
                       (((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_mob))/100  as periode_mobilier,
                       (((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_bat))/100  as anterieur_batiment,
                       (((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_lat))/100  as anterieur_latrine,
                       (((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_mob))/100  as anterieur_mobilier,                      
                       
                       ((((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_bat))/100)+((((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_bat))/100)  as batiment_cumul,
                       ((((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_lat))/100)+((((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_lat))/100)  as latrine_cumul,
                       ((((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_mob))/100)+((((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_mob))/100)  as mobilier_cumul,
                       
                     ((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))+((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))+((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine))) as prevu_cumul,
                     ((((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_bat))/100)+((((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_lat))/100)+((((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_mob))/100)  as periode_cumul,                     
                     ((((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_bat))/100)+((((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_lat))/100)+((((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_mob))/100)  as anterieur_cumul,

                     (((((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_bat))/100)+((((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_bat))/100))+(((((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_lat))/100)+((((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_lat))/100))+(((((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_mob))/100)+((((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_mob))/100))  as total_cumul

               from (
               
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         sum(detail_bat_travaux.periode) as periode_bat,
                         0 as periode_lat,
                         0 as periode_mob,
                         0 as anterieur_bat,
                         0 as anterieur_lat,
                         0 as anterieur_mob,
                         contrat_mpe.cout_batiment as cout_batiment,
                         contrat_mpe.cout_latrine as cout_latrine,
                         contrat_mpe.cout_mobilier as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_bat_travaux as detail_bat_travaux on detail_bat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        inner join contrat_prestataire as contrat_mpe on contrat_mpe.id= entete_travaux.id_contrat_prestataire
                        where 
                        entete_travaux.id= '".$id_pv_consta_entete_travaux."'
                )
                UNION
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         0 as periode_bat,
                         sum(detail_lat_travaux.periode) as periode_lat,
                         0 as periode_mob,
                         0 as anterieur_bat,
                         0 as anterieur_lat,
                         0 as anterieur_mob,
                         0 as cout_batiment,
                         0 as cout_latrine,
                         0 as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_lat_travaux as detail_lat_travaux on detail_lat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        where 
                        entete_travaux.id= '".$id_pv_consta_entete_travaux."'
                )
                UNION
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         0 as periode_bat,
                         0 as periode_lat,
                         sum(detail_mob_travaux.periode) as periode_mob,
                         0 as anterieur_bat,
                         0 as anterieur_lat,
                         0 as anterieur_mob,
                         0 as cout_batiment,
                         0 as cout_latrine,
                         0 as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_mob_travaux as detail_mob_travaux on detail_mob_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        where 
                        entete_travaux.id= '".$id_pv_consta_entete_travaux."'
                )
                UNION
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         0 as periode_bat,
                         0 as periode_lat,
                         0 as periode_mob,
                         sum(detail_bat_travaux.periode) as anterieur_bat,
                         0 as anterieur_lat,
                         0 as anterieur_mob,
                         0 as cout_batiment,
                         0 as cout_latrine,
                         0 as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_bat_travaux as detail_bat_travaux on detail_bat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                        where 
                        entete_travaux.id< '".$id_pv_consta_entete_travaux."' and
                        entete_travaux.id_contrat_prestataire= '".$id_contrat_prestataire."' and
                        fact_mpe.validation=2
                ) 
                UNION
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         0 as periode_bat,
                         0 as periode_lat,
                         0 as periode_mob,
                         0 as anterieur_bat,
                         sum(detail_lat_travaux.periode) as anterieur_lat,
                         0 as anterieur_mob,
                         0 as cout_batiment,
                         0 as cout_latrine,
                         0 as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_lat_travaux as detail_lat_travaux on detail_lat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                        where 
                        entete_travaux.id< '".$id_pv_consta_entete_travaux."' and
                        entete_travaux.id_contrat_prestataire= '".$id_contrat_prestataire."' and
                        fact_mpe.validation=2
                )
                UNION
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         0 as periode_bat,
                         0 as periode_lat,
                         0 as periode_mob,
                         0 as anterieur_bat,
                         0 as anterieur_lat,
                         sum(detail_mob_travaux.periode) as anterieur_mob,
                         0 as cout_batiment,
                         0 as cout_latrine,
                         0 as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_mob_travaux as detail_mob_travaux on detail_mob_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                        where 
                        entete_travaux.id< '".$id_pv_consta_entete_travaux."' and
                        entete_travaux.id_contrat_prestataire= '".$id_contrat_prestataire."' and
                        fact_mpe.validation=2
                )  

                )detail

            ";
            return $this->db->query($sql)->result();             
    }
    public function getrecapBymax_travauxcontrat($id_contrat_prestataire)
    {               
        $sql=" select 
                        detail.id as id,
                        detail.id_contrat as id_contrat,
                       sum(detail.periode_bat) as cumul_periode_batiment,
                       sum( detail.periode_lat) as cumul_periode_latrine,
                       sum(detail.periode_mob) as cumul_periode_mobilier,
                       sum(detail.anterieur_bat) as cumul_anterieur_batiment,
                       sum( detail.anterieur_lat) as cumul_anterieur_latrine,
                       sum(detail.anterieur_mob) as cumul_anterieur_mobilier,
                       sum(detail.cout_batiment) as cout_bat,
                       sum(detail.cout_latrine) as cout_lat,
                       sum(detail.cout_mobilier) as cout_mob,
                       (sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)) as prevu_batiment,
                       (sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)) as prevu_latrine,
                       (sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)) as prevu_mobilier,
                       (((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_bat))/100  as periode_batiment,
                       (((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_lat))/100  as periode_latrine,
                       (((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_mob))/100  as periode_mobilier,
                       (((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_bat))/100  as anterieur_batiment,
                       (((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_lat))/100  as anterieur_latrine,
                       (((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_mob))/100  as anterieur_mobilier,                      
                       
                       ((((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_bat))/100)+((((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_bat))/100)  as batiment_cumul,
                       ((((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_lat))/100)+((((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_lat))/100)  as latrine_cumul,
                       ((((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_mob))/100)+((((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_mob))/100)  as mobilier_cumul,
                       
                     ((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))+((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))+((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine))) as prevu_cumul,
                     ((((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_bat))/100)+((((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_lat))/100)+((((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_mob))/100)  as periode_cumul,                     
                     ((((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_bat))/100)+((((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_lat))/100)+((((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_mob))/100)  as anterieur_cumul,

                     (((((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_bat))/100)+((((sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_bat))/100))+(((((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_lat))/100)+((((sum(detail.cout_latrine)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_lat))/100))+(((((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.periode_mob))/100)+((((sum(detail.cout_mobilier)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine)))*sum(detail.anterieur_mob))/100))  as total_cumul

               from (
               
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         sum(detail_bat_travaux.periode) as periode_bat,
                         0 as periode_lat,
                         0 as periode_mob,
                         0 as anterieur_bat,
                         0 as anterieur_lat,
                         0 as anterieur_mob,
                         contrat_mpe.cout_batiment as cout_batiment,
                         contrat_mpe.cout_latrine as cout_latrine,
                         contrat_mpe.cout_mobilier as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_bat_travaux as detail_bat_travaux on detail_bat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        inner join contrat_prestataire as contrat_mpe on contrat_mpe.id= entete_travaux.id_contrat_prestataire
                        where 
                        entete_travaux.id= (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                        inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id 
                        where tete_trav.id_contrat_prestataire='".$id_contrat_prestataire."' and fac_mpe.validation=2)
                )
                UNION
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         0 as periode_bat,
                         sum(detail_lat_travaux.periode) as periode_lat,
                         0 as periode_mob,
                         0 as anterieur_bat,
                         0 as anterieur_lat,
                         0 as anterieur_mob,
                         0 as cout_batiment,
                         0 as cout_latrine,
                         0 as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_lat_travaux as detail_lat_travaux on detail_lat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        where 
                        entete_travaux.id= (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                                        inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id 
                                        where tete_trav.id_contrat_prestataire='".$id_contrat_prestataire."' and fac_mpe.validation=2)
                )
                UNION
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         0 as periode_bat,
                         0 as periode_lat,
                         sum(detail_mob_travaux.periode) as periode_mob,
                         0 as anterieur_bat,
                         0 as anterieur_lat,
                         0 as anterieur_mob,
                         0 as cout_batiment,
                         0 as cout_latrine,
                         0 as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_mob_travaux as detail_mob_travaux on detail_mob_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        where 
                        entete_travaux.id= (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                        inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id 
                        where tete_trav.id_contrat_prestataire='".$id_contrat_prestataire."' and fac_mpe.validation=2)
                )
                UNION
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         0 as periode_bat,
                         0 as periode_lat,
                         0 as periode_mob,
                         sum(detail_bat_travaux.periode) as anterieur_bat,
                         0 as anterieur_lat,
                         0 as anterieur_mob,
                         0 as cout_batiment,
                         0 as cout_latrine,
                         0 as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_bat_travaux as detail_bat_travaux on detail_bat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                        where 
                        entete_travaux.id< (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                        inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id 
                        where tete_trav.id_contrat_prestataire='".$id_contrat_prestataire."' and fac_mpe.validation=2) and
                        entete_travaux.id_contrat_prestataire= '".$id_contrat_prestataire."' and
                        fact_mpe.validation=2
                ) 
                UNION
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         0 as periode_bat,
                         0 as periode_lat,
                         0 as periode_mob,
                         0 as anterieur_bat,
                         sum(detail_lat_travaux.periode) as anterieur_lat,
                         0 as anterieur_mob,
                         0 as cout_batiment,
                         0 as cout_latrine,
                         0 as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_lat_travaux as detail_lat_travaux on detail_lat_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                        where 
                        entete_travaux.id< (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                        inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id 
                        where tete_trav.id_contrat_prestataire='".$id_contrat_prestataire."' and fac_mpe.validation=2) and
                        entete_travaux.id_contrat_prestataire= '".$id_contrat_prestataire."' and
                        fact_mpe.validation=2
                )
                UNION
                (
                    select 
                        entete_travaux.id as id,
                        entete_travaux.id_contrat_prestataire as id_contrat,
                         0 as periode_bat,
                         0 as periode_lat,
                         0 as periode_mob,
                         0 as anterieur_bat,
                         0 as anterieur_lat,
                         sum(detail_mob_travaux.periode) as anterieur_mob,
                         0 as cout_batiment,
                         0 as cout_latrine,
                         0 as cout_mobilier

                        from pv_consta_entete_travaux as entete_travaux
                        inner join pv_consta_detail_mob_travaux as detail_mob_travaux on detail_mob_travaux.id_pv_consta_entete_travaux= entete_travaux.id
                        inner join facture_mpe as fact_mpe on fact_mpe.id_pv_consta_entete_travaux=entete_travaux.id
                        where 
                        entete_travaux.id< (select max(tete_trav.id) from pv_consta_entete_travaux as tete_trav 
                        inner join facture_mpe as fac_mpe on fac_mpe.id_pv_consta_entete_travaux=tete_trav.id 
                        where tete_trav.id_contrat_prestataire='".$id_contrat_prestataire."' and fac_mpe.validation=2) and
                        entete_travaux.id_contrat_prestataire= '".$id_contrat_prestataire."' and
                        fact_mpe.validation=2
                )  

                )detail

            ";
            return $this->db->query($sql)->result();             
    }

    public function getavance_a_inserer($id_attachement_travaux)
    {               
        $this->db->select("attachement_travaux.id as id_attachement_travaux,attachement_travaux.id_contrat_prestataire as id_contrat_prestataire");
        
        $this->db ->select("(
            select sum(atta_bat_tra.quantite_cumul) from divers_attachement_batiment_travaux as atta_bat_tra
            
            inner join demande_batiment_presta as demande_bat_mpe on demande_bat_mpe.id= atta_bat_tra.id_demande_batiment_mpe
            inner join attachement_travaux as atta_tra on atta_tra.id= demande_bat_mpe.id_attachement_travaux
            where 
                atta_tra.id= id_attachement_travaux) as sum_quantite_cumul_bat",FALSE);
        
        $this->db ->select("(
            select sum(atta_lat_tra.quantite_cumul) from divers_attachement_latrine_travaux as atta_lat_tra
            
            inner join demande_latrine_presta as demande_lat_mpe on demande_lat_mpe.id= atta_lat_tra.id_demande_latrine_mpe
            inner join attachement_travaux as atta_tra on atta_tra.id= demande_lat_mpe.id_attachement_travaux
            where 
                atta_tra.id= id_attachement_travaux) as sum_quantite_cumul_lat",FALSE);

        $this->db ->select("(
            select sum(atta_mob_tra.quantite_cumul) from divers_attachement_mobilier_travaux as atta_mob_tra
            
            inner join demande_mobilier_presta as demande_mob_mpe on demande_mob_mpe.id= atta_mob_tra.id_demande_mobilier_mpe
            inner join attachement_travaux as atta_tra on atta_tra.id= demande_mob_mpe.id_attachement_travaux
            where 
                atta_tra.id= id_attachement_travaux) as sum_quantite_cumul_mob",FALSE);
        
        $this->db ->select("(
            select sum(atta_bat_prevu.quantite_prevu) from divers_attachement_batiment_prevu as atta_bat_prevu
            
            where 
                atta_bat_prevu.id_contrat_prestataire= id_contrat_prestataire) as sum_quantite_prevu_bat",FALSE);

        $this->db ->select("(
            select sum(atta_lat_prevu.quantite_prevu) from divers_attachement_latrine_prevu as atta_lat_prevu
            
            where 
                atta_lat_prevu.id_contrat_prestataire= id_contrat_prestataire) as sum_quantite_prevu_lat",FALSE);

        $this->db ->select("(
            select sum(atta_mob_prevu.quantite_prevu) from divers_attachement_mobilier_prevu as atta_mob_prevu
            
            where 
                atta_mob_prevu.id_contrat_prestataire= id_contrat_prestataire) as sum_quantite_prevu_mob",FALSE);

        $this->db ->select("(
            select max(atta_bat_prevu.id_attachement_batiment_detail)
                
                from divers_attachement_batiment_prevu as atta_bat_prevu
                
                inner join divers_attachement_batiment_travaux as atta_bat_trav on atta_bat_trav.id_attachement_batiment_prevu= atta_bat_prevu.id
                
                inner join demande_batiment_presta as demande_bat_mpe on demande_bat_mpe.id=atta_bat_trav.id_demande_batiment_mpe
                        where 
                         demande_bat_mpe.id_attachement_travaux= id_attachement_travaux ) as id_attachement_bat_detail",FALSE);

        $this->db ->select("(
            select max(atta_lat_prevu.id_attachement_latrine_detail)
                
                from divers_attachement_latrine_prevu as atta_lat_prevu
                
                inner join divers_attachement_latrine_travaux as atta_lat_trav on atta_lat_trav.id_attachement_latrine_prevu= atta_lat_prevu.id
                
                inner join demande_latrine_presta as demande_lat_mpe on demande_lat_mpe.id=atta_lat_trav.id_demande_latrine_mpe
                        where 
                         demande_lat_mpe.id_attachement_travaux= id_attachement_travaux ) as id_attachement_lat_detail",FALSE);

        $this->db ->select("(
            select max(atta_mob_prevu.id_attachement_mobilier_detail)
                
                from divers_attachement_mobilier_prevu as atta_mob_prevu
                
                inner join divers_attachement_mobilier_travaux as atta_mob_trav on atta_mob_trav.id_attachement_mobilier_prevu= atta_mob_prevu.id
                
                inner join demande_mobilier_presta as demande_mob_mpe on demande_mob_mpe.id=atta_mob_trav.id_demande_mobilier_mpe
                        where 
                         demande_mob_mpe.id_attachement_travaux= id_attachement_travaux ) as id_attachement_mob_detail",FALSE);
        
        $this->db ->select("(
            select attachement_travaux.date_fin
                
                from attachement_travaux
                where 
                         attachement_travaux.id= id_attachement_travaux ) as date",FALSE);

        $result =  $this->db->from('attachement_travaux')
                    
                    ->where('attachement_travaux.id',$id_attachement_travaux)
                    ->group_by('id_attachement_travaux')
                                       
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

   /* public function getavance_a_inserer($id_attachement_travaux)
    {               
        $this->db->select("attachement_travaux.id as id_attachement_travaux,attachement_travaux.id_contrat_prestataire as id_contrat_prestataire");
        
        $this->db ->select("(
            select sum(atta_bat_tra.pourcentage) from divers_attachement_batiment_travaux as atta_bat_tra
            
            inner join demande_batiment_presta as demande_bat_mpe on demande_bat_mpe.id= atta_bat_tra.id_demande_batiment_mpe
            inner join attachement_travaux as atta_tra on atta_tra.id= demande_bat_mpe.id_attachement_travaux
            where 
                atta_tra.id= id_attachement_travaux) as pourcentage_bat",FALSE);
        
        $this->db ->select("(
            select sum(atta_lat_tra.pourcentage) from divers_attachement_latrine_travaux as atta_lat_tra
            
            inner join demande_latrine_presta as demande_lat_mpe on demande_lat_mpe.id= atta_lat_tra.id_demande_latrine_mpe
            inner join attachement_travaux as atta_tra on atta_tra.id= demande_lat_mpe.id_attachement_travaux
            where 
                atta_tra.id= id_attachement_travaux) as pourcentage_lat",FALSE);

        $this->db ->select("(
            select sum(atta_mob_tra.pourcentage) from divers_attachement_mobilier_travaux as atta_mob_tra
            
            inner join demande_mobilier_presta as demande_mob_mpe on demande_mob_mpe.id= atta_mob_tra.id_demande_mobilier_mpe
            inner join attachement_travaux as atta_tra on atta_tra.id= demande_mob_mpe.id_attachement_travaux
            where 
                atta_tra.id= id_attachement_travaux) as pourcentage_mob",FALSE);

         $this->db ->select("(
            select count(atta_bat_prevu.id) from divers_attachement_batiment_prevu as atta_bat_prevu                    
            
            where 
                    atta_bat_prevu.id_contrat_prestataire = (select atta_trava.id_contrat_prestataire from attachement_travaux as atta_trava where atta_trava.id= '".$id_attachement_travaux."') ) as nbr_attache_bat_prevu ",FALSE);


         $this->db ->select("(
            select count(atta_lat_prevu.id) from divers_attachement_latrine_prevu as atta_lat_prevu                    
            
            where 
                    atta_lat_prevu.id_contrat_prestataire = (select atta_trava.id_contrat_prestataire from attachement_travaux as atta_trava where atta_trava.id= '".$id_attachement_travaux."') ) as nbr_attache_lat_prevu ",FALSE);

         $this->db ->select("(
            select count(atta_mob_prevu.id) from divers_attachement_mobilier_prevu as atta_mob_prevu                    
            
            where 
                    atta_mob_prevu.id_contrat_prestataire = (select atta_trava.id_contrat_prestataire from attachement_travaux as atta_trava where atta_trava.id= '".$id_attachement_travaux."') ) as nbr_attache_mob_prevu ",FALSE);

        $this->db ->select("(
            select max(atta_bat_prevu.id_attachement_batiment_detail)
                
                from divers_attachement_batiment_prevu as atta_bat_prevu
                
                inner join divers_attachement_batiment_travaux as atta_bat_trav on atta_bat_trav.id_attachement_batiment_prevu= atta_bat_prevu.id
                
                inner join demande_batiment_presta as demande_bat_mpe on demande_bat_mpe.id=atta_bat_trav.id_demande_batiment_mpe
                        where 
                         demande_bat_mpe.id_attachement_travaux= id_attachement_travaux ) as id_attachement_bat_detail",FALSE);

        $this->db ->select("(
            select max(atta_lat_prevu.id_attachement_latrine_detail)
                
                from divers_attachement_latrine_prevu as atta_lat_prevu
                
                inner join divers_attachement_latrine_travaux as atta_lat_trav on atta_lat_trav.id_attachement_latrine_prevu= atta_lat_prevu.id
                
                inner join demande_latrine_presta as demande_lat_mpe on demande_lat_mpe.id=atta_lat_trav.id_demande_latrine_mpe
                        where 
                         demande_lat_mpe.id_attachement_travaux= id_attachement_travaux ) as id_attachement_lat_detail",FALSE);

        $this->db ->select("(
            select max(atta_mob_prevu.id_attachement_mobilier_detail)
                
                from divers_attachement_mobilier_prevu as atta_mob_prevu
                
                inner join divers_attachement_mobilier_travaux as atta_mob_trav on atta_mob_trav.id_attachement_mobilier_prevu= atta_mob_prevu.id
                
                inner join demande_mobilier_presta as demande_mob_mpe on demande_mob_mpe.id=atta_mob_trav.id_demande_mobilier_mpe
                        where 
                         demande_mob_mpe.id_attachement_travaux= id_attachement_travaux ) as id_attachement_mob_detail",FALSE);
        
        $this->db ->select("(
            select attachement_travaux.date_fin
                
                from attachement_travaux
                where 
                         attachement_travaux.id= id_attachement_travaux ) as date",FALSE);

        $result =  $this->db->from('attachement_travaux')
                    
                    ->where('attachement_travaux.id',$id_attachement_travaux)
                    ->group_by('id_attachement_travaux')
                                       
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
    
    }*/

        

}
