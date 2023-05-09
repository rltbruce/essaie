<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Convention_ufp_daaf_entete_model extends CI_Model {
    protected $table = 'convention_ufp_daaf_entete';

    public function add($convention_ufp_daaf_entete) {
        $this->db->set($this->_set($convention_ufp_daaf_entete))
                            ->set('date_creation', 'NOW()', false)
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $convention_ufp_daaf_entete) {
        $this->db->set($this->_set($convention_ufp_daaf_entete))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($convention_ufp_daaf_entete) {
        return array(
            'ref_convention' => $convention_ufp_daaf_entete['ref_convention'],
            'objet' =>    $convention_ufp_daaf_entete['objet'],
            'ref_financement'    => $convention_ufp_daaf_entete['ref_financement'],
            'montant_convention' => $convention_ufp_daaf_entete['montant_convention'],
            'montant_trans_comm' => $convention_ufp_daaf_entete['montant_trans_comm'],
            'frais_bancaire' => $convention_ufp_daaf_entete['frais_bancaire'],
            'num_vague' => $convention_ufp_daaf_entete['num_vague'],
            'nbr_beneficiaire' => $convention_ufp_daaf_entete['nbr_beneficiaire'],
            'validation' => $convention_ufp_daaf_entete['validation']                      
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
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findconventionByfiltre($requete)
    {               
        $result =  $this->db->select('convention_ufp_daaf_entete.*')
                        ->from($this->table)
                        ->join('convention_ufp_daaf_detail','convention_ufp_daaf_detail.id_convention_ufp_daaf_entete=convention_ufp_daaf_entete.id')
                        ->where($requete)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findetatconventionwithpourcenfinancByfiltre($date_debut,$date_fin)
    {               
        $sql="

        select 
                niveau1.id as id,
                niveau1.num_vague as num_vague,
                niveau1.ref_convention as ref_convention,
                niveau1.objet as objet,
                niveau1.ref_financement as ref_financement,
                niveau1.montant_trans_comm as montant_trans_comm,
                niveau1.frais_bancaire as frais_bancaire,
                niveau1.nbr_beneficiaire as nbr_beneficiaire,
                niveau1.montant_convention as montant_convention,
                niveau1.validation as validation,
                ((sum(niveau1.montant_total)*100)/niveau1.montant_convention) as avancement_financ

            from( 

            (select 
                    conv_ufp.id as id,
                    conv_ufp.num_vague as num_vague,
                    conv_ufp.ref_convention as ref_convention,
                    conv_ufp.objet as objet,
                    conv_ufp.ref_financement as ref_financement,
                    conv_ufp.montant_trans_comm as montant_trans_comm,
                    conv_ufp.frais_bancaire as frais_bancaire,
                    conv_ufp.nbr_beneficiaire as nbr_beneficiaire,
                    conv_ufp.montant_convention as montant_convention,
                    conv_ufp.validation as validation,
                    sum(trans_ufp.montant_total) as montant_total

                            from convention_ufp_daaf_entete as conv_ufp
                                inner join convention_ufp_daaf_detail as conv_ufp_de on conv_ufp_de.id_convention_ufp_daaf_entete = conv_ufp.id

                                left join demande_deblocage_daaf as demand_daaf on demand_daaf.id_convention_ufp_daaf_entete = conv_ufp.id
                                left join transfert_ufp as trans_ufp on trans_ufp.id_demande_deblocage_daaf = demand_daaf.id
                                where conv_ufp.validation = 1 and trans_ufp.validation=1 and conv_ufp_de.date_signature BETWEEN '".$date_debut."' AND '".$date_fin."'
                                group by conv_ufp.id
                )
                UNION
                (select 
                    conv_ufp.id as id,
                    conv_ufp.num_vague as num_vague,
                    conv_ufp.ref_convention as ref_convention,
                    conv_ufp.objet as objet,
                    conv_ufp.ref_financement as ref_financement,
                    conv_ufp.montant_trans_comm as montant_trans_comm,
                    conv_ufp.frais_bancaire as frais_bancaire,
                    conv_ufp.nbr_beneficiaire as nbr_beneficiaire,
                    conv_ufp.montant_convention as montant_convention,
                    conv_ufp.validation as validation,
                    0 as montant_total

                            from convention_ufp_daaf_entete as conv_ufp
                                inner join convention_ufp_daaf_detail as conv_ufp_de on conv_ufp_de.id_convention_ufp_daaf_entete = conv_ufp.id
                                
                            where conv_ufp.validation = 1 and conv_ufp_de.date_signature BETWEEN '".$date_debut."' AND '".$date_fin."'
                                group by conv_ufp.id
                )
            ) niveau1

                group by niveau1.id
            ";
            return $this->db->query($sql)->result();             
    }

    public function findconvention_creerinvalideByfiltre($requete)
    {               
        $result =  $this->db->select('convention_ufp_daaf_entete.*')
                        ->from($this->table)
                        ->where('validation',0)
                        ->where($requete)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findconvention_invalideByfiltre($requete)
    {               
        $result =  $this->db->select('convention_ufp_daaf_entete.*')
                        ->from($this->table)
                        ->join('convention_ufp_daaf_detail','convention_ufp_daaf_detail.id_convention_ufp_daaf_entete=convention_ufp_daaf_entete.id')
                        ->where('validation',0)
                        ->where($requete)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findconventionBydemandevalidedaaf()
    {               
        $result =  $this->db->select('convention_ufp_daaf_entete.*')
                        ->from($this->table)
                        ->join('demande_deblocage_daaf','demande_deblocage_daaf.id_convention_ufp_daaf_entete=convention_ufp_daaf_entete.id')
                        ->where('demande_deblocage_daaf.validation',1)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findConventionByinvalidedemande()
    {               
        $result =  $this->db->select('convention_ufp_daaf_entete.*')
                        ->from($this->table)
                        ->join('demande_deblocage_daaf','demande_deblocage_daaf.id_convention_ufp_daaf_entete=convention_ufp_daaf_entete.id')
                        ->where('demande_deblocage_daaf.validation',0)
                        //->where("DATE_FORMAT(convention_ufp_daaf_detail.date_signature,'%Y')",$annee)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findConvention_now($annee)
    {               
        $result =  $this->db->select('convention_ufp_daaf_entete.*')
                        ->from($this->table)
                        ->join('convention_ufp_daaf_detail','convention_ufp_daaf_detail.id_convention_ufp_daaf_entete=convention_ufp_daaf_entete.id')
                        ->where("DATE_FORMAT(convention_ufp_daaf_detail.date_signature,'%Y')",$annee)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findtestconventionByIfvalide($id_convention_ufp_daaf_entete)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('validation',1)
                        ->where('id',$id_convention_ufp_daaf_entete)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findConvention_creerinvalide_now($annee)
    {               
        $result =  $this->db->select('convention_ufp_daaf_entete.*')
                        ->from($this->table)
                        ->where('validation',0)
                        ->where("DATE_FORMAT(date_creation,'%Y')",$annee)
                        ->order_by('ref_convention')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findConvention_invalide_now($annee)
    {               
        $result =  $this->db->select('convention_ufp_daaf_entete.*')
                        ->from($this->table)
                        ->join('convention_ufp_daaf_detail','convention_ufp_daaf_detail.id_convention_ufp_daaf_entete=convention_ufp_daaf_entete.id')
                        ->where('validation',0)
                        ->where("DATE_FORMAT(convention_ufp_daaf_detail.date_signature,'%Y')",$annee)
                        ->order_by('ref_convention')
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
    public function findByIdObjet($id) {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findconventionmaxBydate($date_today)
    {               
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id=(select max(id) from convention_ufp_daaf_entete)")
                        ->where("date_creation",$date_today)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    
    public function findetatconventionByfiltre($date_debut,$date_fin)
    {               
        $sql = " CALL avancement_phy_stockbyconv_ufp_date('".$date_debut."','".$date_fin."') " ;

        return $this->db->query($sql)->result();            
    } 
    /*public function findetatconventionByfiltre($date_debut,$date_fin)
    {               
        $sql="

        select 
                niveau1.id_conv_ufp as id,
                sum(niveau1.avancement_bat) as avancement_batiment,
                sum(niveau1.avancement_lat) as avancement_latrine,
                sum(niveau1.avancement_mob) as avancement_mobilier,
                count(niveau1.id_conv) as nbr_conv_cf,
                (((sum(niveau1.avancement_mob) + sum(niveau1.avancement_lat) + sum(niveau1.avancement_bat))/3)/count(DISTINCT(niveau1.id_conv))) as avancement_physi,
                niveau1.num_vague as num_vague,
                niveau1.ref_convention as ref_convention,
                niveau1.objet as objet,
                niveau1.ref_financement as ref_financement,
                niveau1.montant_trans_comm as montant_trans_comm,
                niveau1.frais_bancaire as frais_bancaire,
                niveau1.nbr_beneficiaire as nbr_beneficiaire,
                niveau1.montant_convention as montant_convention,
                niveau1.validation as validation

            from(
               
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        conv_ufp.num_vague as num_vague,
                        conv_ufp.ref_convention as ref_convention,
                        conv_ufp.objet as objet,
                        conv_ufp.ref_financement as ref_financement,
                        conv_ufp.montant_trans_comm as montant_trans_comm,
                        conv_ufp.frais_bancaire as frais_bancaire,
                        conv_ufp.nbr_beneficiaire as nbr_beneficiaire,
                        conv_ufp.montant_convention as montant_convention,
                        conv_ufp.validation as validation,
                        conv.id as id_conv,
                         max(avanc_bat.pourcentage) as avancement_bat,
                         0 as avancement_lat,
                         0 as avancement_mob

                        from avancement_physi_batiment as avanc_bat

                            inner join contrat_prestataire as cont_pres on cont_pres.id=avanc_bat.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = cont_pres.id_convention_entete
                            right join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf 
                            right join convention_ufp_daaf_detail as conv_ufp_de on conv_ufp_de.id_convention_ufp_daaf_entete = conv_ufp.id
                            where conv_ufp.validation = 1 and conv_ufp_de.date_signature BETWEEN '".$date_debut."' AND '".$date_fin."'
                            group by conv_ufp.id,conv.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        conv_ufp.num_vague as num_vague,
                        conv_ufp.ref_convention as ref_convention,
                        conv_ufp.objet as objet,
                        conv_ufp.ref_financement as ref_financement,
                        conv_ufp.montant_trans_comm as montant_trans_comm,
                        conv_ufp.frais_bancaire as frais_bancaire,
                        conv_ufp.nbr_beneficiaire as nbr_beneficiaire,
                        conv_ufp.montant_convention as montant_convention,
                        conv_ufp.validation as validation,
                        conv.id as id_conv,
                         0 as avancement_bat,
                         max(avanc_lat.pourcentage) as avancement_lat,
                         0 as avancement_mob

                        from avancement_physi_latrine as avanc_lat

                            inner join contrat_prestataire as cont_pres on cont_pres.id=avanc_lat.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = cont_pres.id_convention_entete
                            right join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf  
                            right join convention_ufp_daaf_detail as conv_ufp_de on conv_ufp_de.id_convention_ufp_daaf_entete = conv_ufp.id
                            where conv_ufp.validation = 1 and conv_ufp_de.date_signature BETWEEN '".$date_debut."' AND '".$date_fin."'                    

                            group by conv_ufp.id,conv.id
                )
                UNION
                (
                    select
                        conv_ufp.id as id_conv_ufp,
                        conv_ufp.num_vague as num_vague,
                        conv_ufp.ref_convention as ref_convention,
                        conv_ufp.objet as objet,
                        conv_ufp.ref_financement as ref_financement,
                        conv_ufp.montant_trans_comm as montant_trans_comm,
                        conv_ufp.frais_bancaire as frais_bancaire,
                        conv_ufp.nbr_beneficiaire as nbr_beneficiaire,
                        conv_ufp.montant_convention as montant_convention,
                        conv_ufp.validation as validation,
                        conv.id as id_conv,
                         0 as avancement_bat,
                         0 as avancement_lat,
                         max(avanc_mob.pourcentage) as avancement_mob

                        from avancement_physi_mobilier as avanc_mob

                            inner join contrat_prestataire as cont_pres on cont_pres.id=avanc_mob.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = cont_pres.id_convention_entete
                            right join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf  
                            right join convention_ufp_daaf_detail as conv_ufp_de on conv_ufp_de.id_convention_ufp_daaf_entete = conv_ufp.id
                            where conv_ufp.validation = 1 and conv_ufp_de.date_signature BETWEEN '".$date_debut."' AND '".$date_fin."'                  

                            group by conv_ufp.id,conv.id
                )

                ) niveau1

                group by niveau1.id_conv_ufp

            ";
            return $this->db->query($sql)->result();             
    }*/
    public function findetatConvention_now($annee)
    {               
        $sql = " CALL avancement_phy_stockbyconv_ufp_annee('".$annee."') " ;

        return $this->db->query($sql)->result();            
    }
    public function avancement_physi_stockconv_ufp_all()
    {               
        $sql = " CALL avancement_physi_stockconv_ufp_all() " ;
        $query = $this->db->query($sql);
        $rep = $query->result();
        $query->next_result();
        $query->free_result();
        return $rep;            
    }
   /* public function findetatConvention_now($annee)
    {               
        $sql="

        select 
                niveau1.id_conv_ufp as id,
                sum(niveau1.avancement_bat) as avancement_batiment,
                sum(niveau1.avancement_lat) as avancement_latrine,
                sum(niveau1.avancement_mob) as avancement_mobilier,
                count(niveau1.id_conv) as nbr_conv_cf,
                (((sum(niveau1.avancement_mob) + sum(niveau1.avancement_lat) + sum(niveau1.avancement_bat))/3)/count(DISTINCT(niveau1.id_conv))) as avancement_physi,
                niveau1.num_vague as num_vague,
                niveau1.ref_convention as ref_convention,
                niveau1.objet as objet,
                niveau1.ref_financement as ref_financement,
                niveau1.montant_trans_comm as montant_trans_comm,
                niveau1.frais_bancaire as frais_bancaire,
                niveau1.nbr_beneficiaire as nbr_beneficiaire,
                niveau1.montant_convention as montant_convention,
                niveau1.validation as validation

            from(
               
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        conv_ufp.num_vague as num_vague,
                        conv_ufp.ref_convention as ref_convention,
                        conv_ufp.objet as objet,
                        conv_ufp.ref_financement as ref_financement,
                        conv_ufp.montant_trans_comm as montant_trans_comm,
                        conv_ufp.frais_bancaire as frais_bancaire,
                        conv_ufp.nbr_beneficiaire as nbr_beneficiaire,
                        conv_ufp.montant_convention as montant_convention,
                        conv_ufp.validation as validation,
                        conv.id as id_conv,
                         max(avanc_bat.pourcentage) as avancement_bat,
                         0 as avancement_lat,
                         0 as avancement_mob

                        from avancement_physi_batiment as avanc_bat

                            inner join contrat_prestataire as cont_pres on cont_pres.id=avanc_bat.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = cont_pres.id_convention_entete
                            right join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf 
                            right join convention_ufp_daaf_detail as conv_ufp_de on conv_ufp_de.id_convention_ufp_daaf_entete = conv_ufp.id
                            where DATE_FORMAT(conv_ufp_de.date_signature,'%Y') = '".$annee."' and conv_ufp.validation = 1
                            group by conv_ufp.id,conv.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        conv_ufp.num_vague as num_vague,
                        conv_ufp.ref_convention as ref_convention,
                        conv_ufp.objet as objet,
                        conv_ufp.ref_financement as ref_financement,
                        conv_ufp.montant_trans_comm as montant_trans_comm,
                        conv_ufp.frais_bancaire as frais_bancaire,
                        conv_ufp.nbr_beneficiaire as nbr_beneficiaire,
                        conv_ufp.montant_convention as montant_convention,
                        conv_ufp.validation as validation,
                        conv.id as id_conv,
                         0 as avancement_bat,
                         max(avanc_lat.pourcentage) as avancement_lat,
                         0 as avancement_mob

                        from avancement_physi_latrine as avanc_lat

                            inner join contrat_prestataire as cont_pres on cont_pres.id=avanc_lat.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = cont_pres.id_convention_entete
                            right join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf  
                            right join convention_ufp_daaf_detail as conv_ufp_de on conv_ufp_de.id_convention_ufp_daaf_entete = conv_ufp.id
                            where DATE_FORMAT(conv_ufp_de.date_signature,'%Y') = '".$annee."' and conv_ufp.validation = 1                    

                            group by conv_ufp.id,conv.id
                )
                UNION
                (
                    select
                        conv_ufp.id as id_conv_ufp,
                        conv_ufp.num_vague as num_vague,
                        conv_ufp.ref_convention as ref_convention,
                        conv_ufp.objet as objet,
                        conv_ufp.ref_financement as ref_financement,
                        conv_ufp.montant_trans_comm as montant_trans_comm,
                        conv_ufp.frais_bancaire as frais_bancaire,
                        conv_ufp.nbr_beneficiaire as nbr_beneficiaire,
                        conv_ufp.montant_convention as montant_convention,
                        conv_ufp.validation as validation,
                        conv.id as id_conv,
                         0 as avancement_bat,
                         0 as avancement_lat,
                         max(avanc_mob.pourcentage) as avancement_mob

                        from avancement_physi_mobilier as avanc_mob

                            inner join contrat_prestataire as cont_pres on cont_pres.id=avanc_mob.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = cont_pres.id_convention_entete
                            right join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf  
                            right join convention_ufp_daaf_detail as conv_ufp_de on conv_ufp_de.id_convention_ufp_daaf_entete = conv_ufp.id
                            where DATE_FORMAT(conv_ufp_de.date_signature,'%Y') = '".$annee."' and conv_ufp.validation = 1                   

                            group by conv_ufp.id,conv.id
                )

                ) niveau1

                group by niveau1.id_conv_ufp

            ";
            return $this->db->query($sql)->result();             
    }*/
    public function avancement_convention()
    {               
        $sql="
        select 
                       niveau1.id_conv_ufp as id_conv_ufp,
                       sum(niveau1.avancement_bat) as avancement_batiment,
                       sum(niveau1.avancement_lat) as avancement_latrine,
                       sum(niveau1.avancement_mob) as avancement_mobilier,
                       count(DISTINCT(niveau1.id_conv)) as nbr_conv

            from(
               
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        conv.id as id_conv,
                         max(avanc_bat.pourcentage) as avancement_bat,
                         0 as avancement_lat,
                         0 as avancement_mob

                        from avancement_physi_batiment as avanc_bat

                            inner join contrat_prestataire as cont_pres on cont_pres.id=avanc_bat.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = cont_pres.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf                     

                            group by conv_ufp.id,conv.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        conv.id as id_conv,
                         0 as avancement_bat,
                         max(avanc_lat.pourcentage) as avancement_lat,
                         0 as avancement_mob

                        from avancement_physi_latrine as avanc_lat

                            inner join contrat_prestataire as cont_pres on cont_pres.id=avanc_lat.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = cont_pres.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf                     

                            group by conv_ufp.id,conv.id
                )
                UNION
                (
                    select
                        conv_ufp.id as id_conv_ufp,
                        conv.id as id_conv,
                         0 as avancement_bat,
                         0 as avancement_lat,
                         max(avanc_mob.pourcentage) as avancement_mob

                        from avancement_physi_mobilier as avanc_mob

                            inner join contrat_prestataire as cont_pres on cont_pres.id=avanc_mob.id_contrat_prestataire
                            inner join convention_cisco_feffi_entete as conv on conv.id = cont_pres.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf                     

                            group by conv_ufp.id,conv.id
                ) 

                ) niveau1

                group by niveau1.id_conv_ufp
            ";
            return $this->db->query($sql)->result();             
    }

    public function findDetailcoutByConvention($id_convention_ufp_daaf_entete)
    {               
        $sql="
        select 
                       niveau1.id_conv_ufp as id_conv_ufp,
                        sum(niveau1.cout_batiment) as cout_batiment,
                        sum(niveau1.cout_latrine) as cout_latrine,
                        sum(niveau1.cout_mobilier) as cout_mobilier,
                        sum(niveau1.cout_divers) as cout_divers,
                        sum(niveau1.cout_divers) as montant_divers,
                        (sum(niveau1.cout_batiment) + sum(niveau1.cout_latrine) + sum(niveau1.cout_mobilier)) as montant_trav_mob

            from(

                    select 
                        detail.id_conv_ufp as id_conv_ufp,
                        detail.id_conv as id_conv,
                        sum(detail.cout_batiment) as cout_batiment,
                        sum(detail.cout_latrine) as cout_latrine,
                        sum(detail.cout_mobilier) as cout_mobilier,
                        (sum(detail.cout_maitrise)+sum(detail.cout_sous)) as cout_divers
               from (

               (
                select 
                        conv_ufp.id as id_conv_ufp,
                        conv.id as id_conv,
                        sum(bat_const.cout_unitaire) as cout_batiment,
                        0 as cout_latrine,
                        0 as cout_mobilier,
                        0 as cout_maitrise,
                        0 as cout_sous

                        from batiment_construction as bat_const
                            inner join convention_cisco_feffi_entete as conv on conv.id = bat_const.id_convention_entete 
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf                     
                             where conv_ufp.id = '".$id_convention_ufp_daaf_entete."'
                            group by conv_ufp.id,conv.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        conv.id as id_conv,
                        0 as cout_batiment,
                        sum(lat_const.cout_unitaire) as cout_latrine,
                        0 as cout_mobilier,
                        0 as cout_maitrise,
                        0 as cout_sous

                        from latrine_construction as lat_const
                            inner join convention_cisco_feffi_entete as conv on conv.id = lat_const.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf                     
                             where conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id, conv.id
                )
                UNION
                (
                    select
                        conv_ufp.id as id_conv_ufp, 
                        conv.id as id_conv,
                        0 as cout_batiment,
                        0 as cout_latrine,
                        sum(mob_const.cout_unitaire) as cout_mobilier,
                        0 as cout_maitrise,
                        0 as cout_sous

                        from mobilier_construction as mob_const
                            inner join convention_cisco_feffi_entete as conv on conv.id = mob_const.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf                      
                            where conv_ufp.id = '".$id_convention_ufp_daaf_entete."'

                            group by conv_ufp.id, conv.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        conv.id as id_conv,
                        0 as cout_batiment,
                        0 as cout_latrine,
                        0 as cout_mobilier,
                        sum(cout_di_const.cout) as cout_maitrise,
                        0 as cout_sous

                        from cout_maitrise_construction as cout_di_const
                            inner join convention_cisco_feffi_entete as conv on conv.id = cout_di_const.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf 

                            where conv_ufp.id = '".$id_convention_ufp_daaf_entete."'
                            group by conv_ufp.id, conv.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        conv.id as id_conv,
                        0 as cout_batiment,
                        0 as cout_latrine,
                        0 as cout_mobilier,
                        0 as cout_divers,
                        sum(cout_sou_const.cout) as cout_sous

                        from cout_sousprojet_construction as cout_sou_const
                            inner join convention_cisco_feffi_entete as conv on conv.id = cout_sou_const.id_convention_entete
                            inner join convention_ufp_daaf_entete as conv_ufp on conv_ufp.id = conv.id_convention_ufpdaaf 

                            where conv_ufp.id = '".$id_convention_ufp_daaf_entete."'
                            group by conv_ufp.id, conv.id
                ) 

                )detail

                group by detail.id_conv_ufp,detail.id_conv

                ) niveau1

                group by niveau1.id_conv_ufp
            ";
            return $this->db->query($sql)->result();             
    }

    public function findindicateurByconvention($id_convention_ufp_daaf_entete)
    {               
        $sql="
               select 
                        detail.id_conv_ufp as id_conv_ufp,
                        sum(detail.nbr_beneficiaire_prevu) as nbr_beneficiaire_prevu,
                        sum(detail.nbr_beneficiaire) as nbr_beneficiaire,
                        sum(detail.nbr_ecole_construite) as nbr_ecole_construite,
                        sum(nbr_salle_prevu) as nbr_salle_prevu,
                        sum(nbr_box_latrine_prevu) as nbr_box_latrine_prevu,
                        sum(nbr_point_eau_prevu) as nbr_point_eau_prevu,
                        sum(nbr_table_banc_prevu) as nbr_table_banc_prevu,
                        sum(nbr_table_maitre_prevu) as nbr_table_maitre_prevu,
                        sum(nbr_chaise_maitre_prevu) as nbr_chaise_maitre_prevu,
                        sum(nbr_salle_construite) as nbr_salle_construite,
                        sum(nbr_box_latrine_construite) as nbr_box_latrine_construite,
                        sum(nbr_point_eau_construite) as nbr_point_eau_construite,
                        sum(nbr_table_banc_construite) as nbr_table_banc_construite,
                        sum(nbr_table_maitre_construite) as nbr_table_maitre_construite,
                        sum(nbr_chaise_maitre_construite) as nbr_chaise_maitre_construite
               from (

               (
                select 
                        conv_ufp.id as id_conv_ufp,
                        sum(conv_ufp.nbr_beneficiaire) as nbr_beneficiaire_prevu,
                        0 as nbr_beneficiaire,
                        0 as nbr_ecole_construite,
                        0 as nbr_salle_prevu,
                        0 as nbr_box_latrine_prevu,
                        0 as nbr_point_eau_prevu,
                        0 as nbr_table_banc_prevu,
                        0 as nbr_table_maitre_prevu,
                        0 as nbr_chaise_maitre_prevu,
                        0 as nbr_salle_construite,
                        0 as nbr_box_latrine_construite,
                        0 as nbr_point_eau_construite,
                        0 as nbr_table_banc_construite,
                        0 as nbr_table_maitre_construite,
                        0 as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp                    
                        where conv_ufp.id = '".$id_convention_ufp_daaf_entete."'
                            group by conv_ufp.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        0 as nbr_beneficiaire_prevu,
                        count(conv.id) as nbr_beneficiaire,
                        0 as nbr_ecole_construite,
                        0 as nbr_salle_prevu,
                        0 as nbr_box_latrine_prevu,
                        0 as nbr_point_eau_prevu,
                        0 as nbr_table_banc_prevu,
                        0 as nbr_table_maitre_prevu,
                        0 as nbr_chaise_maitre_prevu,
                        0 as nbr_salle_construite,
                        0 as nbr_box_latrine_construite,
                        0 as nbr_point_eau_construite,
                        0 as nbr_table_banc_construite,
                        0 as nbr_table_maitre_construite,
                        0 as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp
                            inner join convention_cisco_feffi_entete as conv on conv.id_convention_ufpdaaf=conv_ufp.id                     
                             where conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id
                ) 
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        0 as nbr_beneficiaire_prevu,
                        0 as nbr_beneficiaire,
                        count(conv.id) as nbr_ecole_construite,
                        0 as nbr_salle_prevu,
                        0 as nbr_box_latrine_prevu,
                        0 as nbr_point_eau_prevu,
                        0 as nbr_table_banc_prevu,
                        0 as nbr_table_maitre_prevu,
                        0 as nbr_chaise_maitre_prevu,
                        0 as nbr_salle_construite,
                        0 as nbr_box_latrine_construite,
                        0 as nbr_point_eau_construite,
                        0 as nbr_table_banc_construite,
                        0 as nbr_table_maitre_construite,
                        0 as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp
                            inner join convention_cisco_feffi_entete as conv on conv.id_convention_ufpdaaf=conv_ufp.id 
                            inner join batiment_construction as bat_const on bat_const.id_convention_entete = conv.id
                            inner join avancement_batiment as avance_bat on avance_bat.id_batiment_construction = bat_const.id
                            inner join attachement_batiment as atta_bat on atta_bat.id = avance_bat.id_attachement_batiment
                            
                            inner join latrine_construction as lat_const on lat_const.id_batiment_construction = bat_const.id
                            inner join avancement_latrine as avance_lat on avance_lat.id_latrine_construction = lat_const.id
                            inner join attachement_latrine as atta_lat on atta_lat.id = avance_lat.id_attachement_latrine

                            inner join mobilier_construction as mob_const on mob_const.id_batiment_construction = bat_const.id
                            inner join avancement_mobilier as avance_mob on avance_mob.id_mobilier_construction = mob_const.id
                            inner join attachement_mobilier as atta_mob on atta_mob.id = avance_mob.id_attachement_mobilier                   
                             
                             where atta_bat.ponderation_batiment=100 
                                    and atta_lat.ponderation_latrine=100
                                    and atta_mob.ponderation_mobilier=100 
                                    and conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        0 as nbr_beneficiaire_prevu,
                        0 as nbr_beneficiaire,
                        0 as nbr_ecole_construite,
                        sum(type_bat.nbr_salle) as nbr_salle_prevu,
                        0 as nbr_box_latrine_prevu,
                        0 as nbr_point_eau_prevu,
                        0 as nbr_table_banc_prevu,
                        0 as nbr_table_maitre_prevu,
                        0 as nbr_chaise_maitre_prevu,
                        0 as nbr_salle_construite,
                        0 as nbr_box_latrine_construite,
                        0 as nbr_point_eau_construite,
                        0 as nbr_table_banc_construite,
                        0 as nbr_table_maitre_construite,
                        0 as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp
                            inner join convention_cisco_feffi_entete as conv on conv.id_convention_ufpdaaf=conv_ufp.id 
                            inner join batiment_construction as bat_const on bat_const.id_convention_entete = conv.id
                            inner join type_batiment as type_bat on type_bat.id = bat_const.id_type_batiment                  
                             
                             where conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        0 as nbr_beneficiaire_prevu,
                        0 as nbr_beneficiaire,
                        0 as nbr_ecole_construite,
                        0 as nbr_salle_prevu,
                        sum(type_lat.nbr_box_latrine) as nbr_box_latrine_prevu,
                        sum(type_lat.nbr_point_eau) as nbr_point_eau_prevu,
                        0 as nbr_table_banc_prevu,
                        0 as nbr_table_maitre_prevu,
                        0 as nbr_chaise_maitre_prevu,
                        0 as nbr_salle_construite,
                        0 as nbr_box_latrine_construite,
                        0 as nbr_point_eau_construite,
                        0 as nbr_table_banc_construite,
                        0 as nbr_table_maitre_construite,
                        0 as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp
                            inner join convention_cisco_feffi_entete as conv on conv.id_convention_ufpdaaf=conv_ufp.id 
                            inner join batiment_construction as bat_const on bat_const.id_convention_entete = conv.id
                            inner join latrine_construction as lat_const on lat_const.id_batiment_construction = bat_const.id 
                            inner join type_latrine as type_lat on type_lat.id = lat_const.id_type_latrine                  
                             
                             where conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        0 as nbr_beneficiaire_prevu,
                        0 as nbr_beneficiaire,
                        0 as nbr_ecole_construite,
                        0 as nbr_salle_prevu,
                        0 as nbr_box_latrine_prevu,
                        0 as nbr_point_eau_prevu,
                        sum(type_mob.nbr_table_banc) as nbr_table_banc_prevu,
                        sum(type_mob.nbr_table_maitre) as nbr_table_maitre_prevu,
                        sum(type_mob.nbr_chaise_maitre) as nbr_chaise_maitre_prevu,
                        0 as nbr_salle_construite,
                        0 as nbr_box_latrine_construite,
                        0 as nbr_point_eau_construite,
                        0 as nbr_table_banc_construite,
                        0 as nbr_table_maitre_construite,
                        0 as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp
                            inner join convention_cisco_feffi_entete as conv on conv.id_convention_ufpdaaf=conv_ufp.id 
                            inner join batiment_construction as bat_const on bat_const.id_convention_entete = conv.id
                            inner join mobilier_construction as mob_const on mob_const.id_batiment_construction = bat_const.id 
                            inner join type_mobilier as type_mob on type_mob.id = mob_const.id_type_mobilier                  
                             
                             where conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        0 as nbr_beneficiaire_prevu,
                        0 as nbr_beneficiaire,
                        0 as nbr_ecole_construite,
                        0 as nbr_salle_prevu,
                        0 as nbr_box_latrine_prevu,
                        0 as nbr_point_eau_prevu,
                        0 as nbr_table_banc_prevu,
                        0 as nbr_table_maitre_prevu,
                        0 as nbr_chaise_maitre_prevu,
                        sum(type_bat.nbr_salle) as nbr_salle_construite,
                        0 as nbr_box_latrine_construite,
                        0 as nbr_point_eau_construite,
                        0 as nbr_table_banc_construite,
                        0 as nbr_table_maitre_construite,
                        0 as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp
                            inner join convention_cisco_feffi_entete as conv on conv.id_convention_ufpdaaf=conv_ufp.id 
                            inner join batiment_construction as bat_const on bat_const.id_convention_entete = conv.id
                            inner join type_batiment as type_bat on type_bat.id = bat_const.id_type_batiment
                            inner join avancement_batiment as avance_bat on avance_bat.id_batiment_construction = bat_const.id
                            inner join attachement_batiment as atta_bat on atta_bat.id = avance_bat.id_attachement_batiment                  
                             
                             where atta_bat.ponderation_batiment=100 
                                    and conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        0 as nbr_beneficiaire_prevu,
                        0 as nbr_beneficiaire,
                        0 as nbr_ecole_construite,
                        0 as nbr_salle_prevu,
                        0 as nbr_box_latrine_prevu,
                        0 as nbr_point_eau_prevu,
                        0 as nbr_table_banc_prevu,
                        0 as nbr_table_maitre_prevu,
                        0 as nbr_chaise_maitre_prevu,
                        0 as nbr_salle_construite,
                        sum(type_lat.nbr_box_latrine) as nbr_box_latrine_construite,
                        sum(type_lat.nbr_point_eau) as nbr_point_eau_construite,
                        0 as nbr_table_banc_construite,
                        0 as nbr_table_maitre_construite,
                        0 as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp
                            inner join convention_cisco_feffi_entete as conv on conv.id_convention_ufpdaaf=conv_ufp.id 
                            inner join batiment_construction as bat_const on bat_const.id_convention_entete = conv.id
                            inner join latrine_construction as lat_const on lat_const.id_batiment_construction = bat_const.id 
                            inner join type_latrine as type_lat on type_lat.id = lat_const.id_type_latrine
                            inner join avancement_latrine as avance_lat on avance_lat.id_latrine_construction = lat_const.id
                            inner join attachement_latrine as atta_lat on atta_lat.id = avance_lat.id_attachement_latrine                  
                             
                             where atta_lat.ponderation_latrine=100
                                    and conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id
                )
                UNION
                (
                    select 
                        conv_ufp.id as id_conv_ufp,
                        0 as nbr_beneficiaire_prevu,
                        0 as nbr_beneficiaire,
                        0 as nbr_ecole_construite,
                        0 as nbr_salle_prevu,
                        0 as nbr_box_latrine_prevu,
                        0 as nbr_point_eau_prevu,
                        0 as nbr_table_banc_prevu,
                        0 as nbr_table_maitre_prevu,
                        0 as nbr_chaise_maitre_prevu,
                        0 as nbr_salle_construite,
                        0 as nbr_box_latrine_construite,
                        0 as nbr_point_eau_construite,                        
                        sum(type_mob.nbr_table_banc) as nbr_table_banc_construite,
                        sum(type_mob.nbr_table_maitre) as nbr_table_maitre_construite,
                        sum(type_mob.nbr_chaise_maitre) as nbr_chaise_maitre_construite

                        from convention_ufp_daaf_entete as conv_ufp
                            inner join convention_cisco_feffi_entete as conv on conv.id_convention_ufpdaaf=conv_ufp.id 
                            inner join batiment_construction as bat_const on bat_const.id_convention_entete = conv.id
                            inner join mobilier_construction as mob_const on mob_const.id_batiment_construction = bat_const.id 
                            inner join type_mobilier as type_mob on type_mob.id = mob_const.id_type_mobilier
                            inner join avancement_mobilier as avance_mob on avance_mob.id_mobilier_construction = mob_const.id
                            inner join attachement_mobilier as atta_mob on atta_mob.id = avance_mob.id_attachement_mobilier                  
                             
                             where atta_mob.ponderation_mobilier=100 
                                    and conv_ufp.id = '".$id_convention_ufp_daaf_entete."' 
                       
                            group by conv_ufp.id
                )

                )detail

                group by detail.id_conv_ufp
            ";
            return $this->db->query($sql)->result();             
    } 
    public function findByRef_convention($nom) {
        $requete="select * from site where lower(code_sous_projet)='".$nom."'";
        $query = $this->db->query($requete);
        return $query->result();                
    }

}
