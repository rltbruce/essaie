<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paiement_batiment_prestataire_model extends CI_Model {
    protected $table = 'paiement_batiment_prestataire';

    public function add($paiement_batiment_prestataire) {
        $this->db->set($this->_set($paiement_batiment_prestataire))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $paiement_batiment_prestataire) {
        $this->db->set($this->_set($paiement_batiment_prestataire))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($paiement_batiment_prestataire) {
        return array(
            'montant_paiement'       =>      $paiement_batiment_prestataire['montant_paiement'],
            'validation'       =>      $paiement_batiment_prestataire['validation'],
            //'pourcentage_paiement'   =>      $paiement_batiment_prestataire['pourcentage_paiement'],
            'date_paiement'       =>      $paiement_batiment_prestataire['date_paiement'],
            'observation'       =>      $paiement_batiment_prestataire['observation'],
            'id_demande_batiment_pre'    => $paiement_batiment_prestataire['id_demande_batiment_pre']                       
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

    public function findpaiementBydemande($id_demande_batiment_pre) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_batiment_pre", $id_demande_batiment_pre)
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
    public function findpaiementvalideBydemande($id_demande_batiment_pre) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_batiment_pre", $id_demande_batiment_pre)
                        ->where("validation", 1)
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
    public function findpaiementinvalideBydemande($id_demande_batiment_pre) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_batiment_pre", $id_demande_batiment_pre)
                        ->where("validation", 0)
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

    public function findBydemande_batiment_prestataire($id_demande_batiment_pre) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_demande_batiment_pre", $id_demande_batiment_pre)
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
         public function getpaiementByconvention($id_convention_entete)
    {               
        $sql="       
                
            select 
                    detail.id_conv as id_conv,
                    sum(detail.montant_bat_mpe) as montant_bat_mpe,
                    sum(detail.montant_lat_mpe) as montant_lat_mpe,
                    sum(detail.montant_mob_mpe) as montant_mob_mpe,
                    sum(detail.montant_d_moe) as montant_d_moe,
                    sum(detail.montant_bat_moe) as montant_bat_moe,
                    sum(detail.montant_lat_moe) as montant_lat_moe,
                    sum(detail.montant_f_moe) as montant_f_moe,
                    (sum(detail.montant_bat_mpe)+sum(detail.montant_lat_mpe)+sum(detail.montant_mob_mpe)+sum(detail.montant_d_moe)+sum(detail.montant_bat_moe)+sum(detail.montant_lat_moe)+sum(detail.montant_f_moe)) as montant_total,
                    sum(detail.montant_fonct_feffi) as montant_fonct_feffi,
                    sum(detail.montant_pr) as montant_pr

            from(

                (select 
                        conv.id as id_conv,
                        sum(p_bat_presta.montant_paiement) as montant_bat_mpe,
                        0 as montant_lat_mpe,
                        0 as montant_mob_mpe,
                        0 as montant_d_moe,
                        0 as montant_bat_moe,
                        0 as montant_lat_moe,
                        0 as montant_f_moe,
                        0 as montant_fonct_feffi,
                        0 as montant_pr 
                        
                        from paiement_batiment_prestataire as p_bat_presta
                    
                            inner join demande_batiment_presta as d_bat_presta on d_bat_presta.id = p_bat_presta.id_demande_batiment_pre 
                            inner join contrat_prestataire as contrat_presta on contrat_presta.id = d_bat_presta.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = contrat_presta.id_convention_entete
                            
                        where conv.id = '".$id_convention_entete."' )
                UNION
            
                (select 
                        conv.id as id_conv,
                        0 as montant_bat_mpe,
                        sum(p_lat_presta.montant_paiement) as montant_lat_mpe,
                        0 as montant_mob_mpe,
                        0 as montant_d_moe,
                        0 as montant_bat_moe,
                        0 as montant_lat_moe,
                        0 as montant_f_moe,
                        0 as montant_fonct_feffi,
                        0 as montant_pr

                        from paiement_latrine_prestataire as p_lat_presta

                            inner join demande_latrine_presta as d_lat_presta on d_lat_presta.id = p_lat_presta.id_demande_latrine_pre 
                            inner join contrat_prestataire as contrat_presta on contrat_presta.id = d_lat_presta.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = contrat_presta.id_convention_entete
                        
                        where conv.id = '".$id_convention_entete."' )

                UNION

                (select 
                        conv.id as id_conv,
                        0 as montant_bat_mpe,
                        0 as montant_lat_mpe,
                        sum(p_mob_presta.montant_paiement) as montant_mob_mpe,
                        0 as montant_d_moe,
                        0 as montant_bat_moe,
                        0 as montant_lat_moe,
                        0 as montant_f_moe,
                        0 as montant_fonct_feffi,
                        0 as montant_pr

                        from paiement_mobilier_prestataire as p_mob_presta
                            
                            inner join demande_mobilier_presta as d_mob_presta on d_mob_presta.id = p_mob_presta.id_demande_mobilier_pre 
                            inner join contrat_prestataire as contrat_presta on contrat_presta.id = d_mob_presta.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = contrat_presta.id_convention_entete
                        
                        where conv.id = '".$id_convention_entete."' )

                UNION

                (select 
                        conv.id as id_conv,
                        0 as montant_bat_mpe,
                        0 as montant_lat_mpe,
                        0 as montant_mob_mpe,
                        sum(p_d_tra_moe.montant_paiement) as montant_d_moe,
                        0 as montant_bat_moe,
                        0 as montant_lat_moe,
                        0 as montant_f_moe,
                        0 as montant_fonct_feffi,
                        0 as montant_pr

                        from paiement_debut_travaux_moe as p_d_tra_moe

                            inner join demande_debut_travaux_moe as d_deb_trav_moe on d_deb_trav_moe.id = p_d_tra_moe.id_demande_debut_travaux 
                            inner join contrat_bureau_etude as contrat_moe on contrat_moe.id = d_deb_trav_moe.id_contrat_bureau_etude
                            inner join convention_cisco_feffi_entete as conv on conv.id = contrat_moe.id_convention_entete
                        
                        where conv.id = '".$id_convention_entete."' )
                UNION
                
                (select 
                        conv.id as id_conv,
                        0 as montant_bat_mpe,
                        0 as montant_lat_mpe,
                        0 as montant_mob_mpe,
                        0 as montant_d_moe,
                        sum(p_bat_moe.montant_paiement) as montant_bat_moe,
                        0 as montant_lat_moe,
                        0 as montant_f_moe,
                        0 as montant_fonct_feffi,
                        0 as montant_pr 

                        from paiement_batiment_moe as p_bat_moe
                            
                            inner join demande_batiment_moe as d_bat_moe on d_bat_moe.id = p_bat_moe.id_demande_batiment_moe 
                            inner join contrat_bureau_etude contrat_moe on contrat_moe.id = d_bat_moe.id_contrat_bureau_etude
                            inner join convention_cisco_feffi_entete as conv on conv.id = contrat_moe.id_convention_entete
                        
                        where conv.id = '".$id_convention_entete."' )
                UNION

               (select 
                        conv.id as id_conv,
                        0 as montant_bat_mpe,
                        0 as montant_lat_mpe,
                        0 as montant_mob_mpe,
                        0 as montant_d_moe,
                        0 as montant_bat_moe,
                        sum(p_lat_moe.montant_paiement) as montant_lat_moe,
                        0 as montant_f_moe,
                        0 as montant_fonct_feffi,
                        0 as montant_pr

                        from paiement_latrine_moe as p_lat_moe
                            
                            inner join demande_latrine_moe as d_lat_moe on d_lat_moe.id = p_lat_moe.id_demande_latrine_moe 
                            inner join contrat_bureau_etude as contrat_moe on contrat_moe.id = d_lat_moe.id_contrat_bureau_etude
                            inner join convention_cisco_feffi_entete as conv on conv.id = contrat_moe.id_convention_entete
                            
                        where conv.id = '".$id_convention_entete."' )

                UNION
                (select 
                        conv.id as id_conv,
                        0 as montant_bat_mpe,
                        0 as montant_lat_mpe,
                        0 as montant_mob_mpe,
                        0 as montant_d_moe,
                        0 as montant_bat_moe,
                        0 as montant_lat_moe,
                        sum(p_f_trava_moe.montant_paiement) as montant_f_moe,
                        0 as montant_fonct_feffi,
                        0 as montant_pr
                        
                        from paiement_fin_travaux_moe as p_f_trava_moe
                        
                            inner join demande_fin_travaux_moe as d_f_trava_moe on d_f_trava_moe.id = p_f_trava_moe.id_demande_fin_travaux 
                            inner join contrat_bureau_etude as contrat_moe on contrat_moe.id = d_f_trava_moe.id_contrat_bureau_etude
                            inner join convention_cisco_feffi_entete as conv on conv.id = contrat_moe.id_convention_entete
                            
                        where conv.id = '".$id_convention_entete."' )
                UNION
                (select 
                        conv.id as id_conv,
                        0 as montant_bat_mpe,
                        0 as montant_lat_mpe,
                        0 as montant_mob_mpe,
                        0 as montant_d_moe,
                        0 as montant_bat_moe,
                        0 as montant_lat_moe,
                        0 as montant_f_moe,
                        sum(sum_decai_feffi.montant) as montant_fonct_feffi,
                        0 as montant_pr
                        
                        from decaiss_fonct_feffi as sum_decai_feffi
                        
                            inner join convention_cisco_feffi_entete as conv on conv.id = sum_decai_feffi.id_convention_entete
                            
                        where conv.id = '".$id_convention_entete."' )
                UNION
                (select 
                        conv.id as id_conv,
                        0 as montant_bat_mpe,
                        0 as montant_lat_mpe,
                        0 as montant_mob_mpe,
                        0 as montant_d_moe,
                        0 as montant_bat_moe,
                        0 as montant_lat_moe,
                        0 as montant_f_moe,
                        0 as montant_fonct_feffi,
                        sum(p_d_trava_pr.montant_paiement) as montant_pr

                        from paiement_debut_travaux_pr as p_d_trava_pr
                            
                            inner join demande_debut_travaux_pr as d_d_trava_pr on d_d_trava_pr.id = p_d_trava_pr.id_demande_debut_travaux 
                            inner join contrat_partenaire_relai as contrat_pr on contrat_pr.id = d_d_trava_pr.id_contrat_partenaire_relai
                            inner join convention_cisco_feffi_entete as conv on conv.id = contrat_pr.id_convention_entete
                        
                        where conv.id = '".$id_convention_entete."')

            )detail

                group by id_conv";
        

        return $this->db->query($sql)->result();               
    
    }

     /*    public function getpaiementByconvention($id_convention_entete)
    {               
        $this->db->select("convention_cisco_feffi_entete.id as id_conv");
        
        $this->db ->select("(select sum(paiement_batiment_prestataire.montant_paiement) from paiement_batiment_prestataire 
            inner join demande_batiment_presta on demande_batiment_presta.id = paiement_batiment_prestataire.id_demande_batiment_pre 
            inner join contrat_prestataire on contrat_prestataire.id = demande_batiment_presta.id_contrat_prestataire
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_prestataire.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_bat_pre",FALSE);
        
        $this->db ->select("(select sum(tranche_demande_mpe.pourcentage) from tranche_demande_mpe

            inner join demande_batiment_presta on demande_batiment_presta.id_tranche_demande_mpe = tranche_demande_mpe.id
            inner join paiement_batiment_prestataire on paiement_batiment_prestataire.id_demande_batiment_pre = demande_batiment_presta.id  
            inner join contrat_prestataire on contrat_prestataire.id = demande_batiment_presta.id_contrat_prestataire
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_prestataire.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as pourcentage_bat_pre",FALSE);

        $this->db ->select("(select sum(paiement_latrine_prestataire.montant_paiement) from paiement_latrine_prestataire 
            inner join demande_latrine_presta on demande_latrine_presta.id = paiement_latrine_prestataire.id_demande_latrine_pre 
            inner join contrat_prestataire on contrat_prestataire.id = demande_latrine_presta.id_contrat_prestataire
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_prestataire.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_lat_pre",FALSE);

        $this->db ->select("(select sum(tranche_demande_latrine_mpe.pourcentage) from tranche_demande_latrine_mpe

            inner join demande_latrine_presta on demande_latrine_presta.id_tranche_demande_mpe = tranche_demande_latrine_mpe.id
            inner join paiement_latrine_prestataire on paiement_latrine_prestataire.id_demande_latrine_pre = demande_latrine_presta.id  
            inner join contrat_prestataire on contrat_prestataire.id = demande_latrine_presta.id_contrat_prestataire
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_prestataire.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as pourcentage_lat_pre",FALSE);

        $this->db ->select("(select sum(paiement_mobilier_prestataire.montant_paiement) from paiement_mobilier_prestataire 
            inner join demande_mobilier_presta on demande_mobilier_presta.id = paiement_mobilier_prestataire.id_demande_mobilier_pre 
            inner join contrat_prestataire on contrat_prestataire.id = demande_mobilier_presta.id_contrat_prestataire
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_prestataire.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_mob_pre",FALSE);

        $this->db ->select("(select sum(tranche_demande_mobilier_mpe.pourcentage) from tranche_demande_mobilier_mpe

            inner join demande_mobilier_presta on demande_mobilier_presta.id_tranche_demande_mpe = tranche_demande_mobilier_mpe.id
            inner join paiement_mobilier_prestataire on paiement_mobilier_prestataire.id_demande_mobilier_pre = demande_mobilier_presta.id  
            inner join contrat_prestataire on contrat_prestataire.id = demande_mobilier_presta.id_contrat_prestataire
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_prestataire.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as pourcentage_mob_pre",FALSE);



        $this->db ->select("(select sum(paiement_debut_travaux_moe.montant_paiement) from paiement_debut_travaux_moe 
            inner join demande_debut_travaux_moe on demande_debut_travaux_moe.id = paiement_debut_travaux_moe.id_demande_debut_travaux 
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_debut_travaux_moe.id_contrat_bureau_etude
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_debut_moe",FALSE);
        
        $this->db ->select("(select sum(tranche_d_debut_travaux_moe.pourcentage) from tranche_d_debut_travaux_moe

            inner join demande_debut_travaux_moe on demande_debut_travaux_moe.id_tranche_d_debut_travaux_moe = tranche_d_debut_travaux_moe.id
            inner join paiement_debut_travaux_moe on paiement_debut_travaux_moe.id_demande_debut_travaux = demande_debut_travaux_moe.id  
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_debut_travaux_moe.id_contrat_bureau_etude
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as pourcentage_deb_moe",FALSE);

        $this->db ->select("(select sum(paiement_batiment_moe.montant_paiement) from paiement_batiment_moe 
            inner join demande_batiment_moe on demande_batiment_moe.id = paiement_batiment_moe.id_demande_batiment_moe 
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_batiment_moe.id_contrat_bureau_etude
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_bat_moe",FALSE);

        $this->db ->select("(select sum(tranche_demande_batiment_moe.pourcentage) from tranche_demande_batiment_moe

            inner join demande_batiment_moe on demande_batiment_moe.id_tranche_demande_batiment_moe = tranche_demande_batiment_moe.id
            inner join paiement_batiment_moe on paiement_batiment_moe.id_demande_batiment_moe = demande_batiment_moe.id  
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_batiment_moe.id_contrat_bureau_etude
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as pourcentage_bat_moe",FALSE);

       $this->db ->select("(select sum(paiement_latrine_moe.montant_paiement) from paiement_latrine_moe 
            inner join demande_latrine_moe on demande_latrine_moe.id = paiement_latrine_moe.id_demande_latrine_moe 
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_latrine_moe.id_contrat_bureau_etude
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_lat_moe",FALSE);

        $this->db ->select("(select sum(tranche_demande_latrine_moe.pourcentage) from tranche_demande_latrine_moe

            inner join demande_latrine_moe on demande_latrine_moe.id_tranche_demande_latrine_moe = tranche_demande_latrine_moe.id
            inner join paiement_latrine_moe on paiement_latrine_moe.id_demande_latrine_moe = demande_latrine_moe.id  
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_latrine_moe.id_contrat_bureau_etude
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as pourcentage_lat_moe",FALSE);

        $this->db ->select("(select sum(paiement_fin_travaux_moe.montant_paiement) from paiement_fin_travaux_moe 
            inner join demande_fin_travaux_moe on demande_fin_travaux_moe.id = paiement_fin_travaux_moe.id_demande_fin_travaux 
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_fin_travaux_moe.id_contrat_bureau_etude
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_fin_moe",FALSE);
        
        $this->db ->select("(select sum(tranche_d_fin_travaux_moe.pourcentage) from tranche_d_fin_travaux_moe

            inner join demande_fin_travaux_moe on demande_fin_travaux_moe.id_tranche_d_fin_travaux_moe = tranche_d_fin_travaux_moe.id
            inner join paiement_fin_travaux_moe on paiement_fin_travaux_moe.id_demande_fin_travaux = demande_fin_travaux_moe.id  
            inner join contrat_bureau_etude on contrat_bureau_etude.id = demande_fin_travaux_moe.id_contrat_bureau_etude
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_bureau_etude.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as pourcentage_fin_moe",FALSE);

        $this->db ->select("(select sum(paiement_debut_travaux_pr.montant_paiement) from paiement_debut_travaux_pr 
            inner join demande_debut_travaux_pr on demande_debut_travaux_pr.id = paiement_debut_travaux_pr.id_demande_debut_travaux 
            inner join contrat_partenaire_relai on contrat_partenaire_relai.id = demande_debut_travaux_pr.id_contrat_partenaire_relai
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_partenaire_relai.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_debut_pr",FALSE);
        
        $this->db ->select("(select sum(tranche_d_debut_travaux_pr.pourcentage) from tranche_d_debut_travaux_pr

            inner join demande_debut_travaux_pr on demande_debut_travaux_pr.id_tranche_d_debut_travaux_pr = tranche_d_debut_travaux_pr.id
            inner join paiement_debut_travaux_pr on paiement_debut_travaux_pr.id_demande_debut_travaux = demande_debut_travaux_pr.id  
            inner join contrat_partenaire_relai on contrat_partenaire_relai.id = demande_debut_travaux_pr.id_contrat_partenaire_relai
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = contrat_partenaire_relai.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as pourcentage_deb_pr",FALSE);
        
        $this->db ->select("(select sum(decaiss_fonct_feffi.montant) from decaiss_fonct_feffi
            
            inner join convention_cisco_feffi_entete on convention_cisco_feffi_entete.id = decaiss_fonct_feffi.id_convention_entete
            where convention_cisco_feffi_entete.id = id_conv ) as montant_foncti_feffi",FALSE);
        

        $result =  $this->db->from('convention_cisco_feffi_entete')
                    
                    ->where('convention_cisco_feffi_entete.id',$id_convention_entete)
                    ->group_by('id_conv')
                                       
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

    public function getpaiementbat_mpeBycontrat($id_contrat_prestataire)
    {               
        $result =  $this->db->select('demande_batiment_presta.date_approbation as date_approbation,tranche_demande_mpe.code as code,tranche_demande_mpe.pourcentage as pourcentage,paiement_batiment_prestataire.montant_paiement as montant_paiement')
                        ->from($this->table)
                        ->join('demande_batiment_presta','demande_batiment_presta.id=paiement_batiment_prestataire.id_demande_batiment_pre')
                        ->join('tranche_demande_mpe','tranche_demande_mpe.id=demande_batiment_presta.id_tranche_demande_mpe')
                        ->join('contrat_prestataire','contrat_prestataire.id=demande_batiment_presta.id_contrat_prestataire')
                        
                        ->where("contrat_prestataire.id",$id_contrat_prestataire )
                        ->where("demande_batiment_presta.validation",3 )
                       //->order_by('code')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
}
