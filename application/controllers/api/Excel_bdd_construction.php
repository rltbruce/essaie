<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//harizo
// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Excel_bdd_construction extends REST_Controller
{

    public function __construct() {
        parent::__construct();
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        
    }
   
    public function index_get() 
    {
        $menu = $this->get('menu');
        
        $id_cisco = $this->get('id_cisco');
        $id_ecole = $this->get('id_ecole');
        $id_convention_entete = $this->get('id_convention_entete');
        $date_today = $this->get('date_today');
        $date_signature = $this->get('date_signature');
        $date_debut = $this->get('date_debut');
        $date_fin = $this->get('date_fin');
        $lot = $this->get('lot');
        $id_region = $this->get('id_region');
        $id_commune = $this->get('id_commune');
        $repertoire = $this->get('repertoire');

        $data = array() ;


        //*********************************** Nombre echantillon *************************
        
 
                    
            
        
        
        //********************************* fin Nombre echantillon *****************************
        if ($menu=='getdonneeexporter') //mande       
        {   
            $tmp = $this->Convention_cisco_feffi_enteteManager->finddonneeexporter($this->generer_requete($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot));
            if ($tmp) 
            {
                $data =$tmp;
            } 
            else
            {
                    $data = array();
            }

            if (count($data)>0) 
            {
            
                $export=$this->export_excel($repertoire,$data);

            } else {
                $this->response([
                    'status' => FALSE,
                    'response' => array(),
                    'message' => 'No data were found'
                ], REST_Controller::HTTP_OK);
            }
        }
        else
        {   
            $tmp = $this->Convention_cisco_feffi_enteteManager->finddonneeexporter($this->generer_requete($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {  

        //donnee globale             
                    $data[$key]['nom_agence']= $value->nom_agence;
                    $data[$key]['nom_ecole']= $value->nom_ecole;
                    $data[$key]['nom_commune']= $value->nom_commune;
                    $data[$key]['nom_cisco']= $value->nom_cisco;
                    $data[$key]['nom_region']= $value->nom_region;
                    $data[$key]['type_convention']= $value->libelle_zone.$value->libelle_acces;

        //estimation convention

                    $data[$key]['nom_feffi']= $value->nom_feffi;
                    $data[$key]['date_signature_convention']= $value->date_signature_convention;

                    $data[$key]['cout_batiment']= $value->cout_batiment;

                    $data[$key]['cout_latrine']= $value->cout_latrine;

                    $data[$key]['cout_mobilier']= $value->cout_mobilier;

                    $data[$key]['cout_maitrise']= $value->cout_maitrise;

                    $data[$key]['soustotaldepense']= $value->soustotaldepense;

                    $data[$key]['cout_sousprojet']= $value->cout_sousprojet;

                    $data[$key]['montant_convention']= $value->montant_convention;

                    $data[$key]['cout_avenant']= $value->cout_avenant;

                    $data[$key]['montant_apres_avenant']= $value->montant_convention + $value->cout_avenant;

        //suivi financier

                    $data[$key]['transfert_tranche1']= $value->transfert_tranche1;

                    $data[$key]['date_approbation1']= $value->date_approbation1;

                    $data[$key]['transfert_tranche2']= $value->transfert_tranche2;

                    $data[$key]['date_approbation2']= $value->date_approbation2;

                    $data[$key]['transfert_tranche3']= $value->transfert_tranche3;

                    $data[$key]['date_approbation3']= $value->date_approbation3;

                
                    $data[$key]['transfert_tranche4']=  $value->transfert_tranche4;
                
                    $data[$key]['date_approbation4']=$value->date_approbation4;
                
                    $data[$key]['total_transfert']= $value->transfert_tranche1 + $value->transfert_tranche2 + $value->transfert_tranche3 + $value->transfert_tranche4;

                    if ($value->montant_convention) {
                        $data[$key]['decaissement_transfert']=  (($value->transfert_tranche1 + $value->transfert_tranche2 + $value->transfert_tranche3 + $value->transfert_tranche4)*100)/$value->montant_convention;
                    }
                    

        //SUIVI FINANCIER FEFFI -PRESTATAIRE

                $data[$key]['montant_decaiss_feffi_pre']= $value->montant_paiement_mpe1 + $value->montant_paiement_mpe2 + $value->montant_paiement_mpe3 + $value->montant_paiement_mpe4 +$value->montant_paiement_mpe5 + $value->montant_paiement_mpe6+ $value->montant_paiement_mpe7+ $value->montant_paiement_mpe8+ $value->montant_paiement_mpe9+ $value->montant_paiement_mpe10 + $value->montant_paiement_debut_moe + $value->montant_paiement_batiment_moe + $value->montant_paiement_latrine_moe + $value->montant_paiement_fin_moe;

                if ($value->soustotaldepense) {
                    $data[$key]['pourcentage_decaiss_feffi_pre']= (($value->montant_paiement_mpe1 + $value->montant_paiement_mpe2 + $value->montant_paiement_mpe3 + $value->montant_paiement_mpe4 +$value->montant_paiement_mpe5 + $value->montant_paiement_mpe6+ $value->montant_paiement_mpe7+ $value->montant_paiement_mpe8+ $value->montant_paiement_mpe9+ $value->montant_paiement_mpe10 + $value->montant_paiement_debut_moe + $value->montant_paiement_batiment_moe + $value->montant_paiement_latrine_moe + $value->montant_paiement_fin_moe)*100)/$value->soustotaldepense;
                }
                


        //SUIVI FINANCIER FEFFI FONCTIONNEMENT

                $data[$key]['montant_decaiss_fonct_feffi']= $value->montant_decaiss_fonct_feffi;

                if ($value->cout_sousprojet) {
                    $data[$key]['pourcentage_decaiss_fonct_feffi']= ($value->montant_decaiss_fonct_feffi*100)/$value->cout_sousprojet;
                }
                


                $data[$key]['total_convention_decaiss']= $value->montant_decaiss_fonct_feffi + $value->montant_paiement_mpe1 + $value->montant_paiement_mpe2 + $value->montant_paiement_mpe3 + $value->montant_paiement_mpe4 +$value->montant_paiement_mpe5 + $value->montant_paiement_mpe6+ $value->montant_paiement_mpe7+ $value->montant_paiement_mpe8+ $value->montant_paiement_mpe9+ $value->montant_paiement_mpe10 + $value->montant_paiement_debut_moe + $value->montant_paiement_batiment_moe + $value->montant_paiement_latrine_moe + $value->montant_paiement_fin_moe;

                $data[$key]['reliqua_fond']= $value->montant_convention - ($value->montant_decaiss_fonct_feffi + $value->montant_paiement_mpe1 + $value->montant_paiement_mpe2 + $value->montant_paiement_mpe3 + $value->montant_paiement_mpe4 +$value->montant_paiement_mpe5 + $value->montant_paiement_mpe6+ $value->montant_paiement_mpe7+ $value->montant_paiement_mpe8+ $value->montant_paiement_mpe9+ $value->montant_paiement_mpe10 + $value->montant_paiement_debut_moe + $value->montant_paiement_batiment_moe + $value->montant_paiement_latrine_moe + $value->montant_paiement_fin_moe);

        //Suivi Passation des marchés PR

                $data[$key]['date_manifestation_pr']= $value->date_manifestation_pr;

                $data[$key]['date_lancement_dp_pr']= $value->date_lancement_dp_pr;

                $data[$key]['date_remise_pr']= $value->date_remise_pr;

                $data[$key]['nbr_offre_recu_pr']= $value->nbr_offre_recu_pr;

                $data[$key]['date_os_pr']= $value->date_os_pr;

                $data[$key]['nom_pr']= $value->nom_pr;

                $data[$key]['montant_contrat_pr']= $value->montant_contrat_pr;



        //module dpp        

                $data[$key]['date_debut_previ_form_dpp_pr']= $value->date_debut_previ_form_dpp_pr;

                $data[$key]['date_fin_previ_form_dpp_pr']= $value->date_fin_previ_form_dpp_pr;

                $data[$key]['date_previ_resti_dpp_pr']= $value->date_previ_resti_dpp_pr;

                $data[$key]['date_debut_reel_form_dpp_pr']= $value->date_debut_reel_form_dpp_pr;

                $data[$key]['date_fin_reel_form_dpp_pr']= $value->date_fin_reel_form_dpp_pr;

                $data[$key]['date_reel_resti_dpp_pr']= $value->date_reel_resti_dpp_pr;

                $data[$key]['nbr_previ_parti_dpp_pr']= $value->nbr_previ_parti_dpp_pr;

                $data[$key]['nbr_parti_dpp_pr']= $value->nbr_parti_dpp_pr;

                $data[$key]['nbr_previ_fem_parti_dpp_pr']= $value->nbr_previ_fem_parti_dpp_pr;

                $data[$key]['nbr_reel_fem_parti_dpp_pr']= $value->nbr_reel_fem_parti_dpp_pr;

                $data[$key]['lieu_formation_dpp_pr']= $value->lieu_formation_dpp_pr;

                $data[$key]['observation_dpp_pr']= $value->observation_dpp_pr;

        //modeule odc        

                $data[$key]['date_debut_previ_form_odc_pr']= $value->date_debut_previ_form_odc_pr;

                $data[$key]['date_fin_previ_form_odc_pr']= $value->date_fin_previ_form_odc_pr;

                $data[$key]['date_previ_resti_odc_pr']= $value->date_previ_resti_odc_pr;

                $data[$key]['date_debut_reel_form_odc_pr']= $value->date_debut_reel_form_odc_pr;

                $data[$key]['date_fin_reel_form_odc_pr']= $value->date_fin_reel_form_odc_pr;

                $data[$key]['date_reel_resti_odc_pr']= $value->date_reel_resti_odc_pr;

                $data[$key]['nbr_previ_parti_odc_pr']= $value->nbr_previ_parti_odc_pr;

                $data[$key]['nbr_parti_odc_pr']= $value->nbr_parti_odc_pr;

                $data[$key]['nbr_previ_fem_parti_odc_pr']= $value->nbr_previ_fem_parti_odc_pr;

                $data[$key]['nbr_reel_fem_parti_odc_pr']= $value->nbr_reel_fem_parti_odc_pr;

                $data[$key]['lieu_formation_odc_pr']= $value->lieu_formation_odc_pr;

                $data[$key]['observation_odc_pr']= $value->observation_odc_pr;

        //modeule pmc        

                $data[$key]['date_debut_previ_form_pmc_pr']= $value->date_debut_previ_form_pmc_pr;

                $data[$key]['date_fin_previ_form_pmc_pr']= $value->date_fin_previ_form_pmc_pr;

                $data[$key]['date_previ_resti_pmc_pr']= $value->date_previ_resti_pmc_pr;

                $data[$key]['date_debut_reel_form_pmc_pr']= $value->date_debut_reel_form_pmc_pr;

                $data[$key]['date_fin_reel_form_pmc_pr']= $value->date_fin_reel_form_pmc_pr;

                $data[$key]['date_reel_resti_pmc_pr']= $value->date_reel_resti_pmc_pr;

                $data[$key]['nbr_previ_parti_pmc_pr']= $value->nbr_previ_parti_pmc_pr;

                $data[$key]['nbr_parti_pmc_pr']= $value->nbr_parti_pmc_pr;

                $data[$key]['nbr_previ_fem_parti_pmc_pr']= $value->nbr_previ_fem_parti_pmc_pr;

                $data[$key]['nbr_reel_fem_parti_pmc_pr']= $value->nbr_reel_fem_parti_pmc_pr;

                $data[$key]['lieu_formation_pmc_pr']= $value->lieu_formation_pmc_pr;

                $data[$key]['observation_pmc_pr']= $value->observation_pmc_pr;

        //modeule gfpc         

                $data[$key]['date_debut_previ_form_gfpc_pr']= $value->date_debut_previ_form_gfpc_pr;

                $data[$key]['date_fin_previ_form_gfpc_pr']= $value->date_fin_previ_form_gfpc_pr;

                $data[$key]['date_previ_resti_gfpc_pr']= $value->date_previ_resti_gfpc_pr;

                $data[$key]['date_debut_reel_form_gfpc_pr']= $value->date_debut_reel_form_gfpc_pr;

                $data[$key]['date_fin_reel_form_gfpc_pr']= $value->date_fin_reel_form_gfpc_pr;

                $data[$key]['date_reel_resti_gfpc_pr']= $value->date_reel_resti_gfpc_pr;

                $data[$key]['nbr_previ_parti_gfpc_pr']= $value->nbr_previ_parti_gfpc_pr;

                $data[$key]['nbr_parti_gfpc_pr']= $value->nbr_parti_gfpc_pr;

                $data[$key]['nbr_previ_fem_parti_gfpc_pr']= $value->nbr_previ_fem_parti_gfpc_pr;

                $data[$key]['nbr_reel_fem_parti_gfpc_pr']= $value->nbr_reel_fem_parti_gfpc_pr;

                $data[$key]['lieu_formation_gfpc_pr']= $value->lieu_formation_gfpc_pr;

                $data[$key]['observation_gfpc_pr']= $value->observation_gfpc_pr;

        //modeule sep         

                $data[$key]['date_debut_previ_form_sep_pr']= $value->date_debut_previ_form_sep_pr;

                $data[$key]['date_fin_previ_form_sep_pr']= $value->date_fin_previ_form_sep_pr;

                $data[$key]['date_previ_resti_sep_pr']= $value->date_previ_resti_sep_pr;

                $data[$key]['date_debut_reel_form_sep_pr']= $value->date_debut_reel_form_sep_pr;

                $data[$key]['date_fin_reel_form_sep_pr']= $value->date_fin_reel_form_sep_pr;

                $data[$key]['date_reel_resti_sep_pr']= $value->date_reel_resti_sep_pr;

                $data[$key]['nbr_previ_parti_sep_pr']= $value->nbr_previ_parti_sep_pr;

                $data[$key]['nbr_parti_sep_pr']= $value->nbr_parti_sep_pr;

                $data[$key]['nbr_previ_fem_parti_sep_pr']= $value->nbr_previ_fem_parti_sep_pr;

                $data[$key]['nbr_reel_fem_parti_sep_pr']= $value->nbr_reel_fem_parti_sep_pr;

                $data[$key]['lieu_formation_sep_pr']= $value->lieu_formation_sep_pr;

                $data[$key]['observation_sep_pr']= $value->observation_sep_pr;

        //modeule emies        

                $data[$key]['date_debut_previ_form_emies_pr']= $value->date_debut_previ_form_emies_pr;

                $data[$key]['date_fin_previ_form_emies_pr']= $value->date_fin_previ_form_emies_pr;

                $data[$key]['date_previ_resti_emies_pr']= $value->date_previ_resti_emies_pr;

                $data[$key]['date_debut_reel_form_emies_pr']= $value->date_debut_reel_form_emies_pr;

                $data[$key]['date_fin_reel_form_emies_pr']= $value->date_fin_reel_form_emies_pr;

                $data[$key]['date_reel_resti_emies_pr']= $value->date_reel_resti_emies_pr;

                $data[$key]['nbr_previ_parti_emies_pr']= $value->nbr_previ_parti_emies_pr;

                $data[$key]['nbr_parti_emies_pr']= $value->nbr_parti_emies_pr;

                $data[$key]['nbr_previ_fem_parti_emies_pr']= $value->nbr_previ_fem_parti_emies_pr;

                $data[$key]['nbr_reel_fem_parti_emies_pr']= $value->nbr_reel_fem_parti_emies_pr;

                $data[$key]['lieu_formation_emies_pr']= $value->lieu_formation_emies_pr;

                $data[$key]['observation_emies_pr']= $value->observation_emies_pr;

        //passation moe

                $data[$key]['date_shortlist_moe']= $value->date_shortlist_moe;

                $data[$key]['date_manifestation_moe']= $value->date_manifestation_moe;

                $data[$key]['date_lancement_dp_moe']= $value->date_lancement_dp_moe;

                $data[$key]['date_remise_moe']= $value->date_remise_moe;

                $data[$key]['nbr_offre_recu_moe']= $value->nbr_offre_recu_moe;

                $data[$key]['date_rapport_evaluation_moe']= $value->date_rapport_evaluation_moe;

                $data[$key]['date_demande_ano_dpfi_moe']= $value->date_demande_ano_dpfi_moe;

                $data[$key]['date_ano_dpfi_moe']= $value->date_ano_dpfi_moe;

                $data[$key]['notification_intention_moe']= $value->notification_intention_moe;

                $data[$key]['date_notification_attribution_moe']= $value->date_notification_attribution_moe;

                $data[$key]['date_signature_contrat_moe']= $value->date_signature_contrat_moe;

                $data[$key]['date_os_moe']= $value->date_os_moe;

                $data[$key]['nom_bureau_etude_moe']= $value->nom_bureau_etude_moe;

                $data[$key]['statut_moe']= $value->statut_moe;

                $data[$key]['montant_contrat_moe']= $value->montant_contrat_moe;

                $data[$key]['montant_avenant_moe']= $value->montant_avenant_moe;

                $data[$key]['montant_apres_avenant_moe']= $value->montant_avenant_moe + $value->montant_contrat_moe;

                $data[$key]['observation_moe']= $value->observation_moe;


        //PRESTATIO MOE
                $data[$key]['date_livraison_mt']= $value->date_livraison_mt;

                $data[$key]['date_approbation_mt']= $value->date_approbation_mt;

                $data[$key]['date_livraison_dao']= $value->date_livraison_dao;

                $data[$key]['date_approbation_dao']= $value->date_approbation_dao;

                $data[$key]['date_livraison_rp1']= $value->date_livraison_rp1;

                $data[$key]['date_livraison_rp2']= $value->date_livraison_rp2;

                $data[$key]['date_livraison_rp3']= $value->date_livraison_rp3;

                $data[$key]['date_livraison_rp4']= $value->date_livraison_rp4;

                $data[$key]['date_livraison_mg']= $value->date_livraison_mg;

                $data[$key]['cumule_paiement_be']= $value->montant_paiement_debut_moe +$value->montant_paiement_batiment_moe + $value->montant_paiement_latrine_moe + $value->montant_paiement_fin_moe;

                if ($value->montant_contrat_moe) {
                    $data[$key]['pourcentage_paiement_be']= (($value->montant_paiement_debut_moe +$value->montant_paiement_batiment_moe + $value->montant_paiement_latrine_moe + $value->montant_paiement_fin_moe)*100)/$value->montant_contrat_moe;
                }
                

                $data[$key]['date_expiration_poli_moe']= $value->date_expiration_poli_moe;

        //passation mpe

                $data[$key]['date_lancement_pme']= $value->date_lancement_pme;

                $data[$key]['date_remise_pme']= $value->date_remise_pme;

                $data[$key]['nbr_mpe_soumissionaire_pme']= $value->nbr_mpe_soumissionaire_pme;
                
                $data[$key]['nbr_mpe_soumissionaire_pme']= $value->nbr_mpe_soumissionaire_pme;

                $data[$key]['montant_moin_chere_pme']= $value->montant_moin_chere_pme;

                $data[$key]['date_rapport_evaluation_pme']= $value->date_rapport_evaluation_pme;

                $data[$key]['date_demande_ano_dpfi_pme']= $value->date_demande_ano_dpfi_pme;

                $data[$key]['date_ano_dpfi_pme']= $value->date_ano_dpfi_pme;

                $data[$key]['notification_intention_pme']= $value->notification_intention_pme;

                $data[$key]['date_notification_attribution_pme']= $value->date_notification_attribution_pme;

                $data[$key]['date_signature_pme']= $value->date_signature_pme;

                $data[$key]['date_os_pme']= $value->date_os_pme;

                $data[$key]['nom_prestataire']= $value->nom_prestataire;

                $data[$key]['observation_passation_pme']= $value->observation_passation_pme;

                $data[$key]['cout_batiment_pme']= $value->cout_batiment_pme;

                $data[$key]['cout_latrine_pme']= $value->cout_latrine_pme;
                $data[$key]['cout_mobilier_pme']= $value->cout_mobilier_pme;

                $data[$key]['montant_total_mpe']= $value->cout_mobilier_pme + $value->cout_latrine_pme + $value->cout_batiment_pme;

                $data[$key]['avenant_mpe']= $value->cout_latrine_avenant_mpe + $value->cout_batiment_avenant_mpe + $value->cout_mobilier_avenant_mpe;
                $data[$key]['montant_apres_avenant']= $value->cout_mobilier_pme + $value->cout_latrine_pme + $value->cout_batiment_pme + $value->cout_latrine_avenant_mpe + $value->cout_batiment_avenant_mpe + $value->cout_mobilier_avenant_mpe;

                $data[$key]['phase_sousprojet_mpe']= $value->phase_sousprojet_mpe;

                $data[$key]['date_prev_debu_travau_mpe']= $value->date_prev_debu_travau_mpe;

                $data[$key]['date_reel_debu_travau_mpe']= $value->date_reel_debu_travau_mpe;

                $data[$key]['delai_execution_mpe']= $value->delai_execution_mpe;

        //reception

                $data[$key]['date_previ_recep_tech_mpe']= $value->date_previ_recep_tech_mpe;

                $data[$key]['date_reel_tech_mpe']= $value->date_reel_tech_mpe;

                $data[$key]['date_leve_recep_tech_mpe']= $value->date_leve_recep_tech_mpe;

                $data[$key]['date_previ_recep_prov_mpe']= $value->date_previ_recep_prov_mpe;

                $data[$key]['date_reel_recep_prov_mpe']= $value->date_reel_recep_prov_mpe;

                $data[$key]['date_previ_leve_mpe']= $value->date_previ_leve_mpe;

                $data[$key]['date_reel_lev_ava_rd_mpe']= $value->date_reel_lev_ava_rd_mpe;

                $data[$key]['date_previ_recep_defi_mpe']= $value->date_previ_recep_defi_mpe;

                $data[$key]['date_reel_recep_defi_mpe']= $value->date_reel_recep_defi_mpe;

                $data[$key]['avancement_physique']= (($value->avancement_batiment_mpe + $value->avancement_latrine_mpe +$value->avancement_mobilier_mpe)/3).' %';

                $data[$key]['observation_recep_mpe']= $value->observation_recep_mpe;

                $data[$key]['date_expiration_police_mpe']= $value->date_expiration_police_mpe;

                $data[$key]['date_approbation_mpe1']= $value->date_approbation_mpe1;

                $data[$key]['montant_paiement_mpe1']= $value->montant_paiement_mpe1;

                $data[$key]['date_approbation_mpe2']= $value->date_approbation_mpe2;

                $data[$key]['montant_paiement_mpe2']= $value->montant_paiement_mpe2;

                $data[$key]['date_approbation_mpe3']= $value->date_approbation_mpe3;

                $data[$key]['montant_paiement_mpe3']= $value->montant_paiement_mpe3;

                $data[$key]['date_approbation_mpe4']= $value->date_approbation_mpe4;

                $data[$key]['montant_paiement_mpe4']= $value->montant_paiement_mpe4;

                $data[$key]['date_approbation_mpe5']= $value->date_approbation_mpe5;

                $data[$key]['montant_paiement_mpe5']= $value->montant_paiement_mpe5;

                $data[$key]['date_approbation_mpe6']= $value->date_approbation_mpe6;

                $data[$key]['montant_paiement_mpe6']= $value->montant_paiement_mpe6;

                $data[$key]['date_approbation_mpe7']= $value->date_approbation_mpe7;

                $data[$key]['montant_paiement_mpe7']= $value->montant_paiement_mpe7;

                $data[$key]['date_approbation_mpe8']= $value->date_approbation_mpe8;

                $data[$key]['montant_paiement_mpe8']= $value->montant_paiement_mpe8;

                $data[$key]['date_approbation_mpe9']= $value->date_approbation_mpe9;

                $data[$key]['montant_paiement_mpe9']= $value->montant_paiement_mpe9;

                $data[$key]['date_approbation_mpe10']= $value->date_approbation_mpe10;

                $data[$key]['montant_paiement_mpe10']= $value->montant_paiement_mpe10;

                $data[$key]['anterieur_mpe']= $value->anterieur_mpe;

                $data[$key]['periode_mpe']= $value->periode_mpe;

                $data[$key]['cumul_mpe']= $value->cumul_mpe;

                $data[$key]['montant_transfert_reliquat']= $value->montant_transfert_reliquat;

                $data[$key]['objet_utilisation_reliquat']= $value->objet_utilisation_reliquat;

                $data[$key]['situation_utilisation_reliquat']= $value->situation_utilisation_reliquat;

                $data[$key]['observation_reliquat']= $value->observation_reliquat;

                $data[$key]['prev_nbr_salle']= $value->prev_nbr_salle;

                $data[$key]['nbr_salle_const_indicateur']= $value->nbr_salle_const_indicateur;

                $data[$key]['prev_beneficiaire']= $value->prev_beneficiaire;

                $data[$key]['nbr_beneficiaire_indicateur']= $value->nbr_beneficiaire_indicateur;

                $data[$key]['prev_nbr_ecole']= $value->prev_nbr_ecole;
                $data[$key]['nbr_ecole_indicateur']= $value->nbr_ecole_indicateur;

                $data[$key]['prev_nbr_box_latrine']= $value->prev_nbr_box_latrine;

                $data[$key]['nbr_box_indicateur']= $value->nbr_box_indicateur;

                $data[$key]['prev_nbr_point_eau']= $value->prev_nbr_point_eau;

                $data[$key]['nbr_point_eau_indicateur']= $value->nbr_point_eau_indicateur;

                $data[$key]['prev_nbr_table_banc']= $value->prev_nbr_table_banc;

                $data[$key]['nbr_banc_indicateur']= $value->nbr_banc_indicateur;

                $data[$key]['prev_nbr_table_maitre']= $value->prev_nbr_table_maitre;

                $data[$key]['nbr_table_maitre_indicateur']= $value->nbr_table_maitre_indicateur;

                $data[$key]['prev_nbr_chaise_maitre']= $value->prev_nbr_chaise_maitre;

                $data[$key]['nbr_chaise_indicateur']= $value->nbr_chaise_indicateur;

                $data[$key]['observation_indicateur']= $value->observation_indicateur;

                }
            } 
            else
            {
                    $data = array();
            }

            if (count($data)>0) {
        
            $this->response([
                'status' => TRUE,
                'response' => $data,
                'message' => 'Get data success',
            ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'response' => array(),
                    'message' => 'No data were found'
                ], REST_Controller::HTTP_OK);
            }
        }
    }

   
    public function export_excel($repertoire,$data)
    {
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';      

        $nom_file='bdd_construction';
        $directoryName = dirname(__FILE__) ."/../../../../../../assets/excel/".$repertoire;
            
            //Check if the directory already exists.
        if(!is_dir($directoryName))
        {
            mkdir($directoryName, 0777,true);
        }
            
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Myexcel")
                    ->setLastModifiedBy("Me")
                    ->setTitle("suivi FEFFI")
                    ->setSubject("suivi FEFFI")
                    ->setDescription("suivi FEFFI")
                    ->setKeywords("suivi FEFFI")
                    ->setCategory("suivi FEFFI");

        $ligne=1;            
            // Set Orientation, size and scaling
            // Set Orientation, size and scaling
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
        $objPHPExcel->getActiveSheet()->getPageMargins()->SetLeft(0.64); //***pour marge gauche
        $objPHPExcel->getActiveSheet()->getPageMargins()->SetRight(0.64); //***pour marge droite
        $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AZ')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BI')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BJ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BK')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BL')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BM')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BN')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BO')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BP')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BQ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BR')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BS')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setWidth(20);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BI')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BJ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BK')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BL')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BM')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BN')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BO')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BP')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BQ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BR')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BS')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BI')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BJ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BK')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BL')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BM')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BN')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BO')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BP')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BQ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BR')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BS')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BV')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BW')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BX')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BY')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BZ')->setWidth(20);


        $objPHPExcel->getActiveSheet()->getColumnDimension('CA')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CB')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CC')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CD')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CE')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CF')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CG')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CH')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CI')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CJ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CK')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CL')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CM')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CN')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CO')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CP')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CQ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CR')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CS')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CT')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CU')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CV')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CW')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CX')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CY')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('CZ')->setWidth(20);


        $objPHPExcel->getActiveSheet()->getColumnDimension('DA')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DB')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DC')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DD')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DE')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DF')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DG')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DH')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DI')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DJ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DK')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DL')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DM')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DN')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DO')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DP')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DQ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DR')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DS')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DT')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DU')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DV')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DW')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DX')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DY')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('DZ')->setWidth(20);


        $objPHPExcel->getActiveSheet()->getColumnDimension('EA')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EB')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EC')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('ED')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EE')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EF')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EG')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EH')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EI')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EJ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EK')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EL')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EM')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EN')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EO')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EP')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EQ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('ER')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('ES')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('ET')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EU')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EV')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EW')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EX')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EY')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('EZ')->setWidth(20);


        $objPHPExcel->getActiveSheet()->getColumnDimension('FA')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FB')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FC')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FD')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FE')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FF')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FG')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FH')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FI')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FJ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FK')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FL')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FM')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FN')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FO')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FP')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FQ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FR')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FS')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FT')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FU')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FV')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FW')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FX')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FY')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('FZ')->setWidth(20);


        $objPHPExcel->getActiveSheet()->getColumnDimension('GA')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GB')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GC')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GD')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GE')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GF')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GG')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GH')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GI')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GJ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GK')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GL')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GM')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GN')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GO')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GP')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GQ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GR')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GS')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GT')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GU')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GV')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GW')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GX')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GY')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('GZ')->setWidth(20);


        $objPHPExcel->getActiveSheet()->getColumnDimension('HA')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HB')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HC')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HD')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HE')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HF')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HG')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HH')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HI')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HJ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HK')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HL')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HM')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HN')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HO')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HP')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HQ')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HR')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HS')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HT')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HU')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HV')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HW')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HX')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HY')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('HZ')->setWidth(20);


        $objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getRowDimension('8')->setRowHeight(30);

           
       /* $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);*/
            
        $objPHPExcel->getActiveSheet()->setTitle("suivi FEFFI");

        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

        $styleGras = array
        (
        'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
            ),
        'font' => array
            (
                'name'  => 'Arial Narrow',
                'bold'  => true,
                'size'  => 12
            ),
        );
        $styleTitre = array
        (

            'borders' => array
            (
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
        'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
            ),
        'font' => array
            (
                'name'  => 'Arial Narrow',
                'bold'  => true,
                'size'  => 8
            ),
        );
        $stylesousTitre = array
        (
            'borders' => array
            (
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            
            'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
            ),
            'font' => array
            (
                'name'  => 'Arial Narrow',
                //'bold'  => true,
                'size'  => 8
            ),
        );
            
        $stylecontenu = array
        (
            'borders' => array
            (
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array
            (
                'name'  => 'Calibri',
                //'bold'  => true,
                'size'  => 10
            )
        );

        $stylepied = array
        (
            'borders' => array
            (
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            
            'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
            ),
            'font' => array
            (
                    //'name'  => 'Times New Roman',
                'bold'  => true,
                'size'  => 11
            ),
        );

        $ligne++;
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":B".$ligne)->applyFromArray($styleGras);
        //$objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":B".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "PROJET D'APPUI A L'EDUCATION DE BASE (PAEB)");

        $ligne++;
        //$objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($styleGras);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "TABLEAU DE SUIVI ");

        $ligne=$ligne+2;
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":F".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":F".($ligne+1))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "(1) DONNEES GLOBALES");

        $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":AJ".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":AJ".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "(2) CONVENTIONFEFFI");

        $objPHPExcel->getActiveSheet()->mergeCells("AK".$ligne.":DO".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AK".$ligne.":DO".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI'.$ligne, "(3) PARTENAIRES RELAIS");

        $objPHPExcel->getActiveSheet()->mergeCells("DP".$ligne.":ET".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("DP".$ligne.":ET".($ligne+1))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DP'.$ligne, "(4) MAITRISE D'ŒUVRE");

        $objPHPExcel->getActiveSheet()->mergeCells("EU".$ligne.":HB".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("EU".$ligne.":HB".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EU'.$ligne, "(5) ENTREPRISE");

        $objPHPExcel->getActiveSheet()->mergeCells("HC".$ligne.":HF".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("HC".$ligne.":HF".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HC'.$ligne, "(6) GESTION RELIQUATS DE FONDS");//4287f5

        $objPHPExcel->getActiveSheet()->mergeCells("HG".$ligne.":HW".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("HG".$ligne.":HW".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HG'.$ligne, "(7) INDICATEUR");
//GLOBAL
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":F".($ligne+1))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'bed4ed')
        )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("A".($ligne+2).":F".($ligne+3))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'dce6f1')
        )
        ));
//CONVENTION FEFFI

        $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":AJ".$ligne)->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '9ead95')
        )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("G".($ligne+1).":AJ".($ligne+1))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'bfcfb6')
        )
        ));

        $objPHPExcel->getActiveSheet()->getStyle("G".($ligne+2).":AJ".($ligne+3))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'e2efda')
        )
        ));

//PARTENAIRE RELAI

        $objPHPExcel->getActiveSheet()->getStyle("AK".$ligne.":DO".$ligne)->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '8096bd')
        )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("AK".($ligne+1).":DO".($ligne+1))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '99abcc')
        )
        ));

        $objPHPExcel->getActiveSheet()->getStyle("AK".($ligne+2).":DO".($ligne+3))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'b4c6e7')
        )
        ));

//MAITRISE D4OEUVRE

        $objPHPExcel->getActiveSheet()->getStyle("DP".$ligne.":ET".($ligne+1))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'ed7c31')
        )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("DP".($ligne+2).":ET".($ligne+2))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'fa8f48')
        )
        ));

        $objPHPExcel->getActiveSheet()->getStyle("DP".($ligne+3).":ET".($ligne+3))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'faa770')
        )
        ));

//ENTREPRISE

        $objPHPExcel->getActiveSheet()->getStyle("EU".$ligne.":HI".$ligne)->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4f81bd')
        )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("EU".($ligne+1).":HB".($ligne+1))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '5e99bd')
        )
        ));

        $objPHPExcel->getActiveSheet()->getStyle("EU".($ligne+2).":HB".($ligne+3))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '97c8e6')
        )
        ));

//reliquat

        $objPHPExcel->getActiveSheet()->getStyle("HC".$ligne.":HF".$ligne)->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '9266e3')
        )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("HC".($ligne+1).":HF".($ligne+3))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'b08df2')
        )
        ));

//indicateur

        $objPHPExcel->getActiveSheet()->getStyle("HG".$ligne.":HW".$ligne)->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'f5e4bf')
        )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("HG".($ligne+1).":HW".($ligne+3))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'fff2cc')
        )
        ));
        

        $ligne++;

        $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":Q".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":Q".$ligne)->applyFromArray($styleTitre);
        //$objPHPExcel->getActiveSheet()->setColor(rgb(200,200,200));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "ESTIMATION DE LA CONVENTION");

        $objPHPExcel->getActiveSheet()->mergeCells("R".$ligne.":AB".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("R".$ligne.":AB".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$ligne, "SUIVI FINANCIER DAAF FEFFI");

        $objPHPExcel->getActiveSheet()->mergeCells("AC".$ligne.":AE".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AC".$ligne.":AE".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.$ligne, "SUIVI FINANCIER FEFFI -PRESTATAIRE");

        $objPHPExcel->getActiveSheet()->mergeCells("AF".$ligne.":AH".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AF".$ligne.":AH".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF'.$ligne, "SUIVI FINANCIER FEFFI FONCTIONNEMENT");

        //$objPHPExcel->getActiveSheet()->mergeCells("AG".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AI".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI'.$ligne, "TOTAL CONVENTION DECAISSEE");

       // $objPHPExcel->getActiveSheet()->mergeCells("AH".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AJ".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ'.$ligne, "Reliquat des fonds");

        $objPHPExcel->getActiveSheet()->mergeCells("AK".$ligne.":AS".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AK".$ligne.":AS".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK'.$ligne, "Suivi Passation des marchés PR");

        $objPHPExcel->getActiveSheet()->mergeCells("AT".$ligne.":AU".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AT".$ligne.":AU".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AT'.$ligne, "");

        $objPHPExcel->getActiveSheet()->mergeCells("AV".$ligne.":DO".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AV".$ligne.":DO".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AV'.$ligne, "Suivi Prestation par PR");

        $objPHPExcel->getActiveSheet()->mergeCells("EU".$ligne.":FN".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("EU".$ligne.":FN".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EU'.$ligne, "Passation des marchés");

        $objPHPExcel->getActiveSheet()->mergeCells("FO".$ligne.":GD".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("FO".$ligne.":GD".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FO'.$ligne, "Suivi de l'exécution de chaque contrat des travaux");

        $objPHPExcel->getActiveSheet()->mergeCells("GE".$ligne.":HB".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GE".$ligne.":HB".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GE'.$ligne, "Suivi de paiement de chaque contrat des travaux");

       $objPHPExcel->getActiveSheet()->mergeCells("HC".$ligne.":HC".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HC".$ligne.":HC".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HC'.$ligne, "Montant du reliquat de fonds");

        $objPHPExcel->getActiveSheet()->mergeCells("HD".$ligne.":HD".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HD".$ligne.":HD".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HD'.$ligne, "Objet de l'utilisation du reliquat");

        $objPHPExcel->getActiveSheet()->mergeCells("HE".$ligne.":HE".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HE".$ligne.":HE".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HE'.$ligne, "Situation de l'utilisation du reliquat");

        $objPHPExcel->getActiveSheet()->mergeCells("HF".$ligne.":HF".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HF".$ligne.":HF".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HF'.$ligne, "OBSERVATIONS");

//INDICATEUR

        $objPHPExcel->getActiveSheet()->mergeCells("HG".$ligne.":HG".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HG".$ligne.":HG".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HG'.$ligne, "Prevision nombre de salles de classe construites");
        
        $objPHPExcel->getActiveSheet()->mergeCells("HH".$ligne.":HH".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HH".$ligne.":HH".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HH'.$ligne, "Nombre de salles de classe construites");
        
        $objPHPExcel->getActiveSheet()->mergeCells("HI".$ligne.":HI".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HI".$ligne.":HI".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HI'.$ligne, "Prevision Bénéficiaires directs du programme deconstruction (nombre)");
        
        $objPHPExcel->getActiveSheet()->mergeCells("HJ".$ligne.":HJ".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HJ".$ligne.":HJ".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HJ'.$ligne, "Bénéficiaires directs du programme de construction (nombre)");
        
        $objPHPExcel->getActiveSheet()->mergeCells("HK".$ligne.":HK".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HK".$ligne.":HK".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HK'.$ligne, "Prevision Nombre d'Ecoles construites");
        
        $objPHPExcel->getActiveSheet()->mergeCells("HL".$ligne.":HL".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HL".$ligne.":HL".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HL'.$ligne, "Nombre d'Ecoles construites");
        
        $objPHPExcel->getActiveSheet()->mergeCells("HM".$ligne.":HM".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HM".$ligne.":HM".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HM'.$ligne, "Prévision nombre de box de latrine");
        
        $objPHPExcel->getActiveSheet()->mergeCells("HN".$ligne.":HN".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HN".$ligne.":HN".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HN'.$ligne, "Réalisation box de latrine");
        
        $objPHPExcel->getActiveSheet()->mergeCells("HO".$ligne.":HO".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HO".$ligne.":HO".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HO'.$ligne, "Prevision Nombre de systèmes de point d'Eau installé");
        
        $objPHPExcel->getActiveSheet()->mergeCells("HP".$ligne.":HP".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HP".$ligne.":HP".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HP'.$ligne, "Nombre de système de point d'eau  installé");
        
        $objPHPExcel->getActiveSheet()->mergeCells("HQ".$ligne.":HQ".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HQ".$ligne.":HQ".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HQ'.$ligne, "PREVISION NOMBRE TABLES BANC ");
        
        $objPHPExcel->getActiveSheet()->mergeCells("HR".$ligne.":HR".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HR".$ligne.":HR".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HR'.$ligne, "REALISATION NOMBRE TABLES BANC ");
        
        $objPHPExcel->getActiveSheet()->mergeCells("HS".$ligne.":HS".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HS".$ligne.":HS".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HS'.$ligne, "PREVISION NOMBRE TABLES DU MAITRE ");
        
        $objPHPExcel->getActiveSheet()->mergeCells("HT".$ligne.":HT".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HT".$ligne.":HT".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HT'.$ligne, "REALISATION NOMBRE TABLES DU MAITRE");
        
        $objPHPExcel->getActiveSheet()->mergeCells("HU".$ligne.":HU".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HU".$ligne.":HU".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HU'.$ligne, "PREVISION NOMBRE CHAISE DU MAITRE");
        
        $objPHPExcel->getActiveSheet()->mergeCells("HV".$ligne.":HV".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HV".$ligne.":HV".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HV'.$ligne, "REALISATION NOMBRE CHAISE DU MAITRE");
        
        $objPHPExcel->getActiveSheet()->mergeCells("HW".$ligne.":HW".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HW".$ligne.":HW".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HW'.$ligne, "OBSERVATIONS SUR LES INDICATEURS");

        $ligne++;

        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":A".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":A".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":A".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "AGENCE");

        $objPHPExcel->getActiveSheet()->mergeCells("B".$ligne.":B".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("B".$ligne.":B".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, "ECOLE");

        $objPHPExcel->getActiveSheet()->mergeCells("C".$ligne.":C".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("C".$ligne.":C".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, "COMMUNE");

        $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":D".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("D".$ligne.":D".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "CISCO");

        $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":E".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":E".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "REGION");


        //$objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":F".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("F".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("F".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "TYPE DE CONVENTION");

        $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":G".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":G".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->getActiveSheet()->getStyle("G".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "NOM FEFFI");

        $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":H".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":H".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->getActiveSheet()->getStyle("H".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Date de signature convention CISCO FEFFI");

        $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":I".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":I".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, "Bâtiment");

        $objPHPExcel->getActiveSheet()->mergeCells("J".$ligne.":J".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("J".$ligne.":J".($ligne+1))->applyFromArray($stylesousTitre);
       // $objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, "Latrine");

        $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":K".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":K".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, "Mobilier scolaire");

        $objPHPExcel->getActiveSheet()->mergeCells("L".$ligne.":L".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("L".$ligne.":L".($ligne+1))->applyFromArray($stylesousTitre);
       // $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, "Maitrise d'œuvre");

        $objPHPExcel->getActiveSheet()->mergeCells("M".$ligne.":M".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("M".$ligne.":M".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("M".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, "Sous total Dépenses TAVAUX");

        $objPHPExcel->getActiveSheet()->mergeCells("N".$ligne.":N".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("N".$ligne.":N".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("N".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, "Frais de fonctionnement FEFFI");

        $objPHPExcel->getActiveSheet()->mergeCells("O".$ligne.":O".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("O".$ligne.":O".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("O".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$ligne, "Montant convention");

        $objPHPExcel->getActiveSheet()->mergeCells("P".$ligne.":P".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("P".$ligne.":P".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$ligne, "AVENANT A LA CONVENTION");

        $objPHPExcel->getActiveSheet()->mergeCells("Q".$ligne.":Q".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("Q".$ligne.":Q".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("Q".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$ligne, "MONTANT CONVENTION APRES AVENANT");

        //$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(TRUE);
        $objPHPExcel->getActiveSheet()->mergeCells("R".$ligne.":R".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("R".$ligne.":R".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("R".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("R".$ligne, "Montant 1ère tranche");

        $objPHPExcel->getActiveSheet()->mergeCells("S".$ligne.":S".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("S".$ligne.":S".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("S".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("S".$ligne, "Date d'approbation 1ère tranche");

        $objPHPExcel->getActiveSheet()->mergeCells("T".$ligne.":T".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("T".$ligne.":T".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("T".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("T".$ligne, "Montant 2ème tranche");

        $objPHPExcel->getActiveSheet()->mergeCells("U".$ligne.":U".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("U".$ligne.":U".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("U".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("U".$ligne, "Date d'approbation 2ème tranche");

        $objPHPExcel->getActiveSheet()->mergeCells("V".$ligne.":V".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("V".$ligne.":V".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("V".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("V".$ligne, "Montant 3ème tranche");

        $objPHPExcel->getActiveSheet()->mergeCells("W".$ligne.":W".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("W".$ligne.":W".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("W".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("W".$ligne, "Date d'approbation 3ème tranche");

        $objPHPExcel->getActiveSheet()->mergeCells("X".$ligne.":X".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("X".$ligne.":X".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("X".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("X".$ligne, "Montant 4ème tranche");

        $objPHPExcel->getActiveSheet()->mergeCells("Y".$ligne.":Y".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("Y".$ligne.":Y".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("Y".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Y".$ligne, "Date d'approbation 4ème tranche");

        $objPHPExcel->getActiveSheet()->mergeCells("Z".$ligne.":Z".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("Z".$ligne.":Z".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("Z".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Z".$ligne, "Total");

        $objPHPExcel->getActiveSheet()->mergeCells("AA".$ligne.":AA".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AA".$ligne.":AA".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AA".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AA".$ligne, "% décaissement");

        $objPHPExcel->getActiveSheet()->mergeCells("AB".$ligne.":AB".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AB".$ligne.":AB".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AB".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AB".$ligne, "OBSERVATIONS");

//SUIVI FINANCIER FEFFI -PRESTATAIRE
        $objPHPExcel->getActiveSheet()->mergeCells("AC".$ligne.":AC".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AC".$ligne.":AC".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AC".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AC".$ligne, "Montant décaissé");

        $objPHPExcel->getActiveSheet()->mergeCells("AD".$ligne.":AD".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AD".$ligne.":AD".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AD".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AD".$ligne, "% décaissement");

        $objPHPExcel->getActiveSheet()->mergeCells("AE".$ligne.":AE".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AE".$ligne.":AE".($ligne+1))->applyFromArray($stylesousTitre);
       // $objPHPExcel->getActiveSheet()->getStyle("AE".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AE".$ligne, "OBSERVATIONS");

//SUIVI FINANCIER FEFFI FONCTIONNEMENT
       $objPHPExcel->getActiveSheet()->mergeCells("AF".$ligne.":AF".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AF".$ligne.":AF".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AD".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AF".$ligne, "Montant décaissé");

        $objPHPExcel->getActiveSheet()->mergeCells("AG".$ligne.":AG".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AG".$ligne.":AG".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AE".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AG".$ligne, "% décaissement");

        $objPHPExcel->getActiveSheet()->mergeCells("AH".$ligne.":AH".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AH".$ligne.":AH".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AF".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AH".$ligne, "OBSERVATIONS");


        $objPHPExcel->getActiveSheet()->mergeCells("AI".$ligne.":AI".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AI".$ligne.":AI".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AG".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AI".$ligne, "MONTANT");

        $objPHPExcel->getActiveSheet()->mergeCells("AJ".$ligne.":AJ".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AJ".$ligne.":AJ".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AH".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AJ".$ligne, "MONTANT");

        $objPHPExcel->getActiveSheet()->mergeCells("AK".$ligne.":AK".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AK".$ligne.":AK".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AK".$ligne, "Appel manifestation");

        $objPHPExcel->getActiveSheet()->mergeCells("AL".$ligne.":AL".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AL".$ligne.":AL".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AL".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AL".$ligne, "Lancement D.P.");

        $objPHPExcel->getActiveSheet()->mergeCells("AM".$ligne.":AM".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AM".$ligne.":AM".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AM".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AM".$ligne, "Remise proposition");

        $objPHPExcel->getActiveSheet()->mergeCells("AN".$ligne.":AN".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AL".$ligne.":AN".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AL".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AN".$ligne, "Nbre plis reçu");

        $objPHPExcel->getActiveSheet()->mergeCells("AO".$ligne.":AO".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AO".$ligne.":AO".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AM".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AO".$ligne, "Date O.S. commencement");

        $objPHPExcel->getActiveSheet()->mergeCells("AP".$ligne.":AP".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AP".$ligne.":AP".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AN".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AP".$ligne, "Nom du Consultant");

        $objPHPExcel->getActiveSheet()->mergeCells("AQ".$ligne.":AQ".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne.":AQ".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AO".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AQ".$ligne, "Montant contrat");

        $objPHPExcel->getActiveSheet()->mergeCells("AR".$ligne.":AR".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AR".$ligne.":AR".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AR".$ligne, "Cumul paiement");

        $objPHPExcel->getActiveSheet()->mergeCells("AS".$ligne.":AS".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AS".$ligne.":AS".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AS".$ligne, "% paiement");

        $objPHPExcel->getActiveSheet()->mergeCells("AT".$ligne.":AT".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AT".$ligne.":AT".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AR".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AT".$ligne, "Avenant contrat PR");

        $objPHPExcel->getActiveSheet()->mergeCells("AU".$ligne.":AU".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("AU".$ligne.":AU".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AS".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AU".$ligne, "Montant contrat après avenant");

        $objPHPExcel->getActiveSheet()->mergeCells("AV".$ligne.":BG".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AV".$ligne.":BG".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("AT".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AV".$ligne, "MODULE DPP");

        $objPHPExcel->getActiveSheet()->mergeCells("BH".$ligne.":BS".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("BH".$ligne.":BS".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("BF".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BH".$ligne, "MODULE ODC");

        $objPHPExcel->getActiveSheet()->mergeCells("BT".$ligne.":CE".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("BT".$ligne.":CE".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("BR".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BT".$ligne, "MODULE PMC");

        $objPHPExcel->getActiveSheet()->mergeCells("CF".$ligne.":CQ".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("CF".$ligne.":CQ".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("CD".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CF".$ligne, "MODULE GFPC");

        $objPHPExcel->getActiveSheet()->mergeCells("CR".$ligne.":DC".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("CR".$ligne.":DC".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("CP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CR".$ligne, "MODULE SEP");
        $objPHPExcel->getActiveSheet()->mergeCells("DD".$ligne.":DO".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("DD".$ligne.":DO".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("DB".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DD".$ligne, "MODULE EMIES");

        $objPHPExcel->getActiveSheet()->mergeCells("DP".$ligne.":EG".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("DP".$ligne.":EG".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("DN".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DP".$ligne, "Passation des marchés BE");

        $objPHPExcel->getActiveSheet()->mergeCells("EH".$ligne.":EQ".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("EH".$ligne.":EQ".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EF".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EH".$ligne, "Suivi préstation BE");

        $objPHPExcel->getActiveSheet()->mergeCells("ER".$ligne.":ES".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("ER".$ligne.":ES".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("ER".$ligne, "Suivi paiement");

        $objPHPExcel->getActiveSheet()->mergeCells("ET".$ligne.":ET".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("ET".$ligne.":ET".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("ET".$ligne, "DATE D'EXPIRATION POLICE D'ASSURANCE BE");

        $objPHPExcel->getActiveSheet()->mergeCells("EU".$ligne.":EU".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("EU".$ligne.":EU".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EU".$ligne, "Date lancement de l'Appel d'Offres de travaux");

        $objPHPExcel->getActiveSheet()->mergeCells("EV".$ligne.":EV".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("EV".$ligne.":EV".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EV".$ligne, "Date remise des Offres");

        $objPHPExcel->getActiveSheet()->mergeCells("EW".$ligne.":EW".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("EW".$ligne.":EW".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EW".$ligne, "Nombre offres recues");

        $objPHPExcel->getActiveSheet()->mergeCells("EX".$ligne.":EX".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("EX".$ligne.":EX".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EX".$ligne, "MPE soumissionaires (liste)");

        $objPHPExcel->getActiveSheet()->mergeCells("EY".$ligne.":EY".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("EY".$ligne.":EY".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EY".$ligne, "Montant TTC offre moins chere");

        $objPHPExcel->getActiveSheet()->mergeCells("EZ".$ligne.":EZ".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("EZ".$ligne.":EZ".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EZ".$ligne, "Datte rapport d'évaluation");

        $objPHPExcel->getActiveSheet()->mergeCells("FA".$ligne.":FA".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("FA".$ligne.":FA".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FA".$ligne, "Demande ANO DPFI");

        $objPHPExcel->getActiveSheet()->mergeCells("FB".$ligne.":FB".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("FB".$ligne.":FB".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FB".$ligne, "ANO DPFI");

        $objPHPExcel->getActiveSheet()->mergeCells("FC".$ligne.":FC".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("FC".$ligne.":FC".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FC".$ligne, "Notification d'intention");

        $objPHPExcel->getActiveSheet()->mergeCells("FD".$ligne.":FD".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("FD".$ligne.":FD".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FD".$ligne, "Date notification d'attribution");

        $objPHPExcel->getActiveSheet()->mergeCells("FE".$ligne.":FE".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("FE".$ligne.":FE".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FE".$ligne, "Date signature contrat de travaux");

        $objPHPExcel->getActiveSheet()->mergeCells("FF".$ligne.":FF".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("FF".$ligne.":FF".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FF".$ligne, "Date OS");

        $objPHPExcel->getActiveSheet()->mergeCells("FG".$ligne.":FG".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("FG".$ligne.":FG".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FG".$ligne, "Titulaire des travaux");

        $objPHPExcel->getActiveSheet()->mergeCells("FH".$ligne.":FH".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("FH".$ligne.":FH".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FH".$ligne, "OBSERVATIONS");

        $objPHPExcel->getActiveSheet()->mergeCells("FI".$ligne.":FN".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("FI".$ligne.":FN".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FI".$ligne, "Montant contrat");

        $objPHPExcel->getActiveSheet()->mergeCells("FO".$ligne.":FR".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("FO".$ligne.":FR".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FO".$ligne, " ");

        $objPHPExcel->getActiveSheet()->mergeCells("FS".$ligne.":GC".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("FS".$ligne.":GC".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FS".$ligne, "Réception");
//eto
        $objPHPExcel->getActiveSheet()->mergeCells("GD".$ligne.":GD".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("GD".$ligne.":GD".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GD".$ligne, "SUIVI DATE D'EXPIRATION POLICE D'ASSURANCE MPE");

        $objPHPExcel->getActiveSheet()->mergeCells("GE".$ligne.":GF".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GE".$ligne.":GF".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GE".$ligne, "Premier paiement");

        $objPHPExcel->getActiveSheet()->mergeCells("GG".$ligne.":GH".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GG".$ligne.":GH".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GG".$ligne, "Deuxième paiement");

        $objPHPExcel->getActiveSheet()->mergeCells("GI".$ligne.":GJ".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GI".$ligne.":GJ".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GI".$ligne, "Troisième paiement");

        $objPHPExcel->getActiveSheet()->mergeCells("GK".$ligne.":GL".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GK".$ligne.":GL".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GK".$ligne, "Quatrième paiement");

        $objPHPExcel->getActiveSheet()->mergeCells("GM".$ligne.":GN".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GM".$ligne.":GN".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GM".$ligne, "Cinquième paiement");


       /* $objPHPExcel->getActiveSheet()->mergeCells("GO".$ligne.":GQ".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GO".$ligne.":GQ".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GO".$ligne, "Taux d'avancement financier (%)");*/

        $objPHPExcel->getActiveSheet()->mergeCells("GO".$ligne.":GP".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GO".$ligne.":GP".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GO".$ligne, "Sixième paiement");

        $objPHPExcel->getActiveSheet()->mergeCells("GQ".$ligne.":GR".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GQ".$ligne.":GR".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GQ".$ligne, "Septième paiement");

        $objPHPExcel->getActiveSheet()->mergeCells("GS".$ligne.":GT".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GS".$ligne.":GT".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GS".$ligne, "Huitème paiement");

       /* $objPHPExcel->getActiveSheet()->mergeCells("GX".$ligne.":GZ".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GX".$ligne.":GZ".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GX".$ligne, "Taux d'avancement financier (%)");*/

        $objPHPExcel->getActiveSheet()->mergeCells("GU".$ligne.":GV".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GU".$ligne.":GV".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GU".$ligne, "Neuvième paiement");

        $objPHPExcel->getActiveSheet()->mergeCells("GW".$ligne.":GX".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GW".$ligne.":GX".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GW".$ligne, "Deuxième paiement");

        $objPHPExcel->getActiveSheet()->mergeCells("GY".$ligne.":HA".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GY".$ligne.":HA".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GY".$ligne, "Taux d'avancement financier (%)");

        $objPHPExcel->getActiveSheet()->mergeCells("HB".$ligne.":HB".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("HB".$ligne.":HB".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HB".$ligne, "Observation");

        $ligne++;
        //$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(FALSE);

        $objPHPExcel->getActiveSheet()->getStyle("F".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("F".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "Zone Côtière:C01/C02/C03/ ou Zone Hauts plateaux Rurale HPR1/HPR2/HPR3/ ou Zone Hauts plateaux Urbaine:HPU1/HPU2/HPU3");

        $objPHPExcel->getActiveSheet()->getStyle("AV".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("AV".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AV'.$ligne, "Date début prévisionnelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("AW".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("AW".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AW'.$ligne, "Date fin prévisionnelle formation");

        $objPHPExcel->getActiveSheet()->getStyle("AX".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("AX".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AX'.$ligne, "Date prévisionnelle de la restitution");

        $objPHPExcel->getActiveSheet()->getStyle("AY".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("AY".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AY'.$ligne, "Date début réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("AZ".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("AZ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AZ'.$ligne, "Date fin réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("BA".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BA".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BA'.$ligne, "Date réelle de restitution");

        $objPHPExcel->getActiveSheet()->getStyle("BB".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BB".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BB'.$ligne, "Nombre prévisionnel participant");

        $objPHPExcel->getActiveSheet()->getStyle("BC".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BC".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BC'.$ligne, "Nombre de participant");

        $objPHPExcel->getActiveSheet()->getStyle("BD".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BD".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BD'.$ligne, "Nombre prévisionnel de femme participant");

        $objPHPExcel->getActiveSheet()->getStyle("BE".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BE".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BE'.$ligne, "Nombre réel de femme  participant");

        $objPHPExcel->getActiveSheet()->getStyle("BF".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BF".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BF'.$ligne, "Lieu de formation");
        
        $objPHPExcel->getActiveSheet()->getStyle("BG".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BG".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BG'.$ligne, "observations");


        $objPHPExcel->getActiveSheet()->getStyle("BH".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BH".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BH'.$ligne, "Date début prévisionnelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("BI".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BI".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BI'.$ligne, "Date fin prévisionnelle formation");

        $objPHPExcel->getActiveSheet()->getStyle("BJ".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BJ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BJ'.$ligne, "Date prévisionnelle de la restitution");

        $objPHPExcel->getActiveSheet()->getStyle("BK".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BK'.$ligne, "Date début réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("BL".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BL".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BL'.$ligne, "Date fin réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("BM".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BM".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BM'.$ligne, "Date réelle de restitution");

        $objPHPExcel->getActiveSheet()->getStyle("BN".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BN".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BN'.$ligne, "Nombre prévisionnel   participant");

        $objPHPExcel->getActiveSheet()->getStyle("BO".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BN".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BO'.$ligne, "Nombre de participant");

        $objPHPExcel->getActiveSheet()->getStyle("BP".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BP".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BP'.$ligne, "Nombre prévisionnel de femme  participant");

        $objPHPExcel->getActiveSheet()->getStyle("BQ".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BQ".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BQ'.$ligne, "Nombre réel de femme  participant ");

        $objPHPExcel->getActiveSheet()->getStyle("BR".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BR'.$ligne, "Lieu de formation");
        
        $objPHPExcel->getActiveSheet()->getStyle("BS".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BS'.$ligne, "observations");


        $objPHPExcel->getActiveSheet()->getStyle("BT".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BT".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BT'.$ligne, "Date début prévisionnelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("BU".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BU".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BU'.$ligne, "Date fin prévisionnelle formation");

        $objPHPExcel->getActiveSheet()->getStyle("BV".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BV".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BV'.$ligne, "Date prévisionnelle de la restitution");

        $objPHPExcel->getActiveSheet()->getStyle("BW".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BW".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BW'.$ligne, "Date début réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("BX".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("BX".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BX'.$ligne, "Date fin réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("BY".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BY'.$ligne, "Date réelle de restitution");

        $objPHPExcel->getActiveSheet()->getStyle("BZ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('BZ'.$ligne, "Nombre prévisionnel   participant");

        $objPHPExcel->getActiveSheet()->getStyle("CA".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CA'.$ligne, "Nombre de participant");

        $objPHPExcel->getActiveSheet()->getStyle("CB".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CB'.$ligne, "Nombre prévisionnel de femme participant");

        $objPHPExcel->getActiveSheet()->getStyle("CC".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CC'.$ligne, "Nombre réel de femme  participant");
        
        $objPHPExcel->getActiveSheet()->getStyle("CD".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CD'.$ligne, "Lieu de formation");


        $objPHPExcel->getActiveSheet()->getStyle("CE".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CE'.$ligne, "observations");
        
        $objPHPExcel->getActiveSheet()->getStyle("CF".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CF'.$ligne, "Date début prévisionnelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("CG".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CG'.$ligne, "Date fin prévisionnelle formation");
        
        $objPHPExcel->getActiveSheet()->getStyle("CH".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CH'.$ligne, "Date prévisionnelle de la restitution");


        $objPHPExcel->getActiveSheet()->getStyle("CI".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CI'.$ligne, "Date début réelle de la formation");
        
        $objPHPExcel->getActiveSheet()->getStyle("CJ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CJ'.$ligne, "Date fin réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("CK".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CK'.$ligne, "Date réelle de restitution");
        
        $objPHPExcel->getActiveSheet()->getStyle("CL".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CL'.$ligne, "Nombre prévisionnel   participant");

        $objPHPExcel->getActiveSheet()->getStyle("CM".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CM'.$ligne, "Nombre de participant");
        
        $objPHPExcel->getActiveSheet()->getStyle("CN".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CN'.$ligne, "Nombre prévisionnel de femme  participant");

        $objPHPExcel->getActiveSheet()->getStyle("CO".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CO'.$ligne, "Nombre réel de femme  participant");
        
        $objPHPExcel->getActiveSheet()->getStyle("CP".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CP'.$ligne, "Lieu de formation");

        $objPHPExcel->getActiveSheet()->getStyle("CQ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CQ'.$ligne, "observations");
        
        $objPHPExcel->getActiveSheet()->getStyle("CR".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CR'.$ligne, "Date début prévisionnelle de la formation");
        
        $objPHPExcel->getActiveSheet()->getStyle("CS".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CS'.$ligne, "Date fin prévisionnelle formation");

        $objPHPExcel->getActiveSheet()->getStyle("CT".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CT'.$ligne, "Date prévisionnelle de la restitution");
        
        $objPHPExcel->getActiveSheet()->getStyle("CU".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CU'.$ligne, "Date début réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("CV".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CV'.$ligne, "Date fin réelle de la formation");
        
        $objPHPExcel->getActiveSheet()->getStyle("CW".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CW'.$ligne, "Date réelle de restitution");
        
        $objPHPExcel->getActiveSheet()->getStyle("CX".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CX'.$ligne, "Nombre prévisionnel   participant");


        $objPHPExcel->getActiveSheet()->getStyle("CY".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CY'.$ligne, "Nombre de participant");
        
        $objPHPExcel->getActiveSheet()->getStyle("CZ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('CZ'.$ligne, "Nombre prévisionnel de femme  participant ");


        $objPHPExcel->getActiveSheet()->getStyle("DA".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DA'.$ligne, "Nombre réel de femme  participant");
        
        $objPHPExcel->getActiveSheet()->getStyle("DB".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DB'.$ligne, "Lieu de formation");

        $objPHPExcel->getActiveSheet()->getStyle("DC".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DC'.$ligne, "observations");
        
        $objPHPExcel->getActiveSheet()->getStyle("DD".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DD'.$ligne, "Date début prévisionnelle de la formation");


        $objPHPExcel->getActiveSheet()->getStyle("DE".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DE'.$ligne, "Date fin prévisionnelle formation");
        
        $objPHPExcel->getActiveSheet()->getStyle("DF".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DF'.$ligne, "Date prévisionnelle de la restitution");


        $objPHPExcel->getActiveSheet()->getStyle("DG".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DG'.$ligne, "Date début réelle de la formation");
        
        $objPHPExcel->getActiveSheet()->getStyle("DH".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DH'.$ligne, "Date fin réelle de la formation");

        $objPHPExcel->getActiveSheet()->getStyle("DI".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DI'.$ligne, "Date réelle de restitution");
        
        $objPHPExcel->getActiveSheet()->getStyle("DJ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DJ'.$ligne, "Nombre prévisionnel   participant");

        $objPHPExcel->getActiveSheet()->getStyle("DK".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DK'.$ligne, "Nombre de participant");
        
        $objPHPExcel->getActiveSheet()->getStyle("DL".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DL'.$ligne, "Nombre prévisionnel de femme  participant");

        $objPHPExcel->getActiveSheet()->getStyle("DM".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DM'.$ligne, "Nombre réel de femme  participant ");
        
        $objPHPExcel->getActiveSheet()->getStyle("DN".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DN'.$ligne, "Lieu de formation");

        $objPHPExcel->getActiveSheet()->getStyle("DO".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DO'.$ligne, "observations");


        $objPHPExcel->getActiveSheet()->getStyle("DP".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DP'.$ligne, "Date établissement shortlist");
        
        $objPHPExcel->getActiveSheet()->getStyle("DQ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DQ'.$ligne, "Appel à manifestation d'interêt");

        $objPHPExcel->getActiveSheet()->getStyle("DR".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DR'.$ligne, "Lancement D.P.");
        
        $objPHPExcel->getActiveSheet()->getStyle("DS".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DS'.$ligne, "Remise proposition");

        $objPHPExcel->getActiveSheet()->getStyle("DT".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DT'.$ligne, "Nbre plis reçu");
        
        $objPHPExcel->getActiveSheet()->getStyle("DU".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DU'.$ligne, "Date du rapport d'évaluation");

        $objPHPExcel->getActiveSheet()->getStyle("DV".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DV'.$ligne, "Date demande ANO DPFI");
        
        $objPHPExcel->getActiveSheet()->getStyle("DW".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DW'.$ligne, "DANO DPFI");

        $objPHPExcel->getActiveSheet()->getStyle("DX".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DX'.$ligne, "Notification d'intention");

        $objPHPExcel->getActiveSheet()->getStyle("DY".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DY'.$ligne, "Notification d'attribution");
        
        $objPHPExcel->getActiveSheet()->getStyle("DZ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('DZ'.$ligne, "Date signature de contrat");

        $objPHPExcel->getActiveSheet()->getStyle("EA".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EA'.$ligne, "Date O.S. commencement");
        
        $objPHPExcel->getActiveSheet()->getStyle("EB".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EB'.$ligne, "Raison sociale ou nom Consultant");

        $objPHPExcel->getActiveSheet()->getStyle("EC".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EC'.$ligne, "Statut (BE/CI)");
        
        $objPHPExcel->getActiveSheet()->getStyle("ED".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('ED'.$ligne, "Montant contrat ");

        $objPHPExcel->getActiveSheet()->getStyle("EE".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EE'.$ligne, "Avenant");
        
        $objPHPExcel->getActiveSheet()->getStyle("EF".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EF'.$ligne, "Montant après avenant");
        
        $objPHPExcel->getActiveSheet()->getStyle("EG".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EG'.$ligne, "Observations");

        $objPHPExcel->getActiveSheet()->getStyle("EH".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EH'.$ligne, "Livraison Mémoire technique (MT)");
        
        $objPHPExcel->getActiveSheet()->getStyle("EI".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EI'.$ligne, "Date d'approbation MT par FEFFI");

        $objPHPExcel->getActiveSheet()->getStyle("EJ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EJ'.$ligne, "Date livraison DAO");
        
        $objPHPExcel->getActiveSheet()->getStyle("EK".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EK'.$ligne, "Date d'approbation DAO par FEFFI");
        
        
       // $objPHPExcel->getActiveSheet()->mergeCells("EL".$ligne.":EM".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("EL".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EL'.$ligne, "Livraison Rapport mensuel 01 ");

        $objPHPExcel->getActiveSheet()->getStyle("EM".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EM'.$ligne, "Livraison Rapport mensuel 02 ");

        $objPHPExcel->getActiveSheet()->getStyle("EN".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EN'.$ligne, "Livraison Rapport mensuel 03 ");

        $objPHPExcel->getActiveSheet()->getStyle("EO".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EO'.$ligne, "Livraison Rapport mensuel 04 ");
        
        $objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EP'.$ligne, "Livraison manuel de gestion et d'entretien");
        
        $objPHPExcel->getActiveSheet()->getStyle("EQ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('EQ'.$ligne, "Observations");

        
        $objPHPExcel->getActiveSheet()->getStyle("ER".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('ER'.$ligne, "Cumul Paiement effectué");
        
        $objPHPExcel->getActiveSheet()->getStyle("ES".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('ES'.$ligne, "% paiement");
 //FIN MOE        
        $objPHPExcel->getActiveSheet()->getStyle("FI".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FI'.$ligne, "bloc  de 2 sdc");
        
        $objPHPExcel->getActiveSheet()->getStyle("FJ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FJ'.$ligne, " latrines");
        
        $objPHPExcel->getActiveSheet()->getStyle("FK".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FK'.$ligne, "Mobiliers");
        
        $objPHPExcel->getActiveSheet()->getStyle("FL".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FL'.$ligne, "Montant total");
        
        $objPHPExcel->getActiveSheet()->getStyle("FM".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FM'.$ligne, "Avenant");
        
        $objPHPExcel->getActiveSheet()->getStyle("FN".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FN'.$ligne, "Montant après avenant");
        
        $objPHPExcel->getActiveSheet()->getStyle("FO".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FO'.$ligne, "Phase du sous-projet");
        
        $objPHPExcel->getActiveSheet()->getStyle("FP".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FP'.$ligne, "Date prévisionnelle début travaux");
        
        $objPHPExcel->getActiveSheet()->getStyle("FQ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FQ'.$ligne, "Date réelle début travaux");
        
        $objPHPExcel->getActiveSheet()->getStyle("FR".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FR'.$ligne, "Délai d'exécution (jours)");
        
        $objPHPExcel->getActiveSheet()->getStyle("FS".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FS'.$ligne, "Date prévisionnelle réception technique");
        
        $objPHPExcel->getActiveSheet()->getStyle("FT".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FT'.$ligne, "Date réeelle  réception technique");
        
        $objPHPExcel->getActiveSheet()->getStyle("FU".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FU'.$ligne, "Date levée des réserves de la réception technique");
        
        $objPHPExcel->getActiveSheet()->getStyle("FV".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FV'.$ligne, "Date ptévisionnelle reception provisoire");
        
        $objPHPExcel->getActiveSheet()->getStyle("FW".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FW'.$ligne, "Date réelle reception provisoire");
        
        $objPHPExcel->getActiveSheet()->getStyle("FX".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FX'.$ligne, "Date prévisionnelle de levee des reserves avant RD");
        
        $objPHPExcel->getActiveSheet()->getStyle("FY".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FY'.$ligne, "Date réelle de levee des reserves avant RD");
        
        $objPHPExcel->getActiveSheet()->getStyle("FZ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FZ'.$ligne, "Dateprévisionnelle  reception définitive");
        
        $objPHPExcel->getActiveSheet()->getStyle("GA".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GA'.$ligne, "Date réelle  reception définitive");
        
        $objPHPExcel->getActiveSheet()->getStyle("GB".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GB'.$ligne, "Avancement physique");
        
        $objPHPExcel->getActiveSheet()->getStyle("GC".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GC'.$ligne, "OBSERVATIONS");

        $objPHPExcel->getActiveSheet()->getStyle("GE".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GE'.$ligne, "Date d'approbation");
        
        $objPHPExcel->getActiveSheet()->getStyle("GF".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GF'.$ligne, "montant en Ar");

        $objPHPExcel->getActiveSheet()->getStyle("GG".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GG'.$ligne, "Date d'approbation");
        
        $objPHPExcel->getActiveSheet()->getStyle("GH".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GH'.$ligne, "montant en Ar");

        $objPHPExcel->getActiveSheet()->getStyle("GI".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GI'.$ligne, "Date d'approbation");
        
        $objPHPExcel->getActiveSheet()->getStyle("GJ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GJ'.$ligne, "montant en Ar");

        $objPHPExcel->getActiveSheet()->getStyle("GK".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GK'.$ligne, "Date d'approbation");
        
        $objPHPExcel->getActiveSheet()->getStyle("GL".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GL'.$ligne, "montant en Ar");

        $objPHPExcel->getActiveSheet()->getStyle("GM".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GM'.$ligne, "Date d'approbation");
        
        $objPHPExcel->getActiveSheet()->getStyle("GN".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GN'.$ligne, "montant en Ar");

        /*$objPHPExcel->getActiveSheet()->getStyle("GO".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GO'.$ligne, "Anterieur");
        
        $objPHPExcel->getActiveSheet()->getStyle("GP".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GP'.$ligne, "Période");

        $objPHPExcel->getActiveSheet()->getStyle("GQ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GQ'.$ligne, "Cumulé");*/
        
        $objPHPExcel->getActiveSheet()->getStyle("GO".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GO'.$ligne, "Date d'approbation");

        $objPHPExcel->getActiveSheet()->getStyle("GP".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GP'.$ligne, "montant en Ar");
        
        $objPHPExcel->getActiveSheet()->getStyle("GQ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GQ'.$ligne, "Date d'approbation");

        $objPHPExcel->getActiveSheet()->getStyle("GR".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GR'.$ligne, "montant en Ar");
        
        $objPHPExcel->getActiveSheet()->getStyle("GS".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GS'.$ligne, "Date d'approbation");

        $objPHPExcel->getActiveSheet()->getStyle("GT".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GT'.$ligne, "montant en Ar");
        
       /* $objPHPExcel->getActiveSheet()->getStyle("GX".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GX'.$ligne, "Anterieur");

        $objPHPExcel->getActiveSheet()->getStyle("GY".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GY'.$ligne, "Période");

        $objPHPExcel->getActiveSheet()->getStyle("GZ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GZ'.$ligne, "Cumulé");*/
        
        $objPHPExcel->getActiveSheet()->getStyle("GU".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GU'.$ligne, "Date d'approbation");

        $objPHPExcel->getActiveSheet()->getStyle("GV".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GV'.$ligne, "montant en Ar");
        
        $objPHPExcel->getActiveSheet()->getStyle("GW".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GW'.$ligne, "Date d'approbation");

        $objPHPExcel->getActiveSheet()->getStyle("GX".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GX'.$ligne, "montant en Ar");
        
        $objPHPExcel->getActiveSheet()->getStyle("GY".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GY'.$ligne, "Anterieur");

        $objPHPExcel->getActiveSheet()->getStyle("GZ".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GZ'.$ligne, "Période");
        
        $objPHPExcel->getActiveSheet()->getStyle("HA".$ligne)->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HA'.$ligne, "Cumulé");
        
        //$objPHPExcel->getActiveSheet()->getStyle("GZ".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('GZ'.$ligne, "% decaissement");

        $ligne++;
        foreach ($data as $key => $value)
        {  

//donnee globale             
            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->nom_agence);
            $objPHPExcel->getActiveSheet()->getStyle("B".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, $value->nom_ecole);
            $objPHPExcel->getActiveSheet()->getStyle("C".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, $value->nom_commune);
            $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->nom_cisco);
            $objPHPExcel->getActiveSheet()->getStyle("E".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $value->nom_region);
            $objPHPExcel->getActiveSheet()->getStyle("F".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $value->libelle_zone.$value->libelle_acces);

//estimation convention

            $objPHPExcel->getActiveSheet()->getStyle("G".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("G".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->nom_feffi);

            $objPHPExcel->getActiveSheet()->getStyle("H".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("H".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $value->date_signature_convention);

            $objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $value->cout_batiment);

            $objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, $value->cout_latrine);

             $objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $value->cout_mobilier);

            $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("L".$ligne, $value->cout_maitrise);

            $objPHPExcel->getActiveSheet()->getStyle("M".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("M".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("M".$ligne, $value->soustotaldepense);

            $objPHPExcel->getActiveSheet()->getStyle("N".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("N".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("N".$ligne, $value->cout_sousprojet);

            $objPHPExcel->getActiveSheet()->getStyle("O".$ligne)->applyFromArray($stylecontenu);
           //$objPHPExcel->getActiveSheet()->getStyle("O".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("O".$ligne, $value->montant_convention);

            $objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("P".$ligne, $value->cout_avenant);

            $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle("Q".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("Q".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Q".$ligne, $value->montant_convention + $value->cout_avenant);

//suivi financier

            $objPHPExcel->getActiveSheet()->getStyle("R".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("R".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("R".$ligne, $value->transfert_tranche1);

            $objPHPExcel->getActiveSheet()->getStyle("S".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("S".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("S".$ligne, $value->date_approbation1);

            $objPHPExcel->getActiveSheet()->getStyle("T".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("R".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("T".$ligne, $value->transfert_tranche2);

            $objPHPExcel->getActiveSheet()->getStyle("U".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("S".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("U".$ligne, $value->date_approbation2);

            $objPHPExcel->getActiveSheet()->getStyle("V".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("V".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("V".$ligne, $value->transfert_tranche3);

            $objPHPExcel->getActiveSheet()->getStyle("W".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("W".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("W".$ligne, $value->date_approbation3);

        
            $objPHPExcel->getActiveSheet()->getStyle("X".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("X".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("X".$ligne,  $value->transfert_tranche4);
        
            $objPHPExcel->getActiveSheet()->getStyle("Y".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("Y".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Y".$ligne,$value->date_approbation4);
        
            $objPHPExcel->getActiveSheet()->getStyle("Z".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("Z".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Z".$ligne, $value->transfert_tranche1 + $value->transfert_tranche2 + $value->transfert_tranche3 + $value->transfert_tranche4);

            $objPHPExcel->getActiveSheet()->getStyle("AA".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("AA".$ligne)->getAlignment()->setWrapText(true);
            if ($value->montant_convention) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AA".$ligne,  (($value->transfert_tranche1 + $value->transfert_tranche2 + $value->transfert_tranche3 + $value->transfert_tranche4)*100)/$value->montant_convention);
            }
            


        $objPHPExcel->getActiveSheet()->getStyle("AB".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AB".$ligne)->getAlignment()->setWrapText(true);
        //$objPHPExcel->setActiveSheetIndex(0)->setCellValue("AB".$ligne, );

//SUIVI FINANCIER FEFFI -PRESTATAIRE

        $objPHPExcel->getActiveSheet()->getStyle("AC".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AB".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AC".$ligne, $value->montant_paiement_mpe1 + $value->montant_paiement_mpe2 + $value->montant_paiement_mpe3 + $value->montant_paiement_mpe4 +$value->montant_paiement_mpe5 + $value->montant_paiement_mpe6+ $value->montant_paiement_mpe7+ $value->montant_paiement_mpe8+ $value->montant_paiement_mpe9+ $value->montant_paiement_mpe10 + $value->montant_paiement_debut_moe + $value->montant_paiement_batiment_moe + $value->montant_paiement_latrine_moe + $value->montant_paiement_fin_moe);

        $objPHPExcel->getActiveSheet()->getStyle("AD".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AB".$ligne)->getAlignment()->setWrapText(true);
        if ($value->soustotaldepense) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AD".$ligne, (($value->montant_paiement_mpe1 + $value->montant_paiement_mpe2 + $value->montant_paiement_mpe3 + $value->montant_paiement_mpe4 +$value->montant_paiement_mpe5 + $value->montant_paiement_mpe6+ $value->montant_paiement_mpe7+ $value->montant_paiement_mpe8+ $value->montant_paiement_mpe9+ $value->montant_paiement_mpe10 + $value->montant_paiement_debut_moe + $value->montant_paiement_batiment_moe + $value->montant_paiement_latrine_moe + $value->montant_paiement_fin_moe)*100)/$value->soustotaldepense);
        }
        

        $objPHPExcel->getActiveSheet()->getStyle("AE".$ligne)->applyFromArray($stylecontenu);


//SUIVI FINANCIER FEFFI FONCTIONNEMENT

        $objPHPExcel->getActiveSheet()->getStyle("AF".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AF".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AF".$ligne, $value->montant_decaiss_fonct_feffi);

        $objPHPExcel->getActiveSheet()->getStyle("AG".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AG".$ligne)->getAlignment()->setWrapText(true);
        if ($value->cout_sousprojet) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AG".$ligne, ($value->montant_decaiss_fonct_feffi*100)/$value->cout_sousprojet);
        }
        


        $objPHPExcel->getActiveSheet()->getStyle("AH".$ligne)->applyFromArray($stylecontenu);

        $objPHPExcel->getActiveSheet()->getStyle("AI".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AG".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AI".$ligne, $value->montant_decaiss_fonct_feffi + $value->montant_paiement_mpe1 + $value->montant_paiement_mpe2 + $value->montant_paiement_mpe3 + $value->montant_paiement_mpe4 +$value->montant_paiement_mpe5 + $value->montant_paiement_mpe6+ $value->montant_paiement_mpe7+ $value->montant_paiement_mpe8+ $value->montant_paiement_mpe9+ $value->montant_paiement_mpe10 + $value->montant_paiement_debut_moe + $value->montant_paiement_batiment_moe + $value->montant_paiement_latrine_moe + $value->montant_paiement_fin_moe);

        $objPHPExcel->getActiveSheet()->getStyle("AJ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AG".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AJ".$ligne, $value->montant_convention - ($value->montant_decaiss_fonct_feffi + $value->montant_paiement_mpe1 + $value->montant_paiement_mpe2 + $value->montant_paiement_mpe3 + $value->montant_paiement_mpe4 +$value->montant_paiement_mpe5 + $value->montant_paiement_mpe6+ $value->montant_paiement_mpe7+ $value->montant_paiement_mpe8+ $value->montant_paiement_mpe9+ $value->montant_paiement_mpe10 + $value->montant_paiement_debut_moe + $value->montant_paiement_batiment_moe + $value->montant_paiement_latrine_moe + $value->montant_paiement_fin_moe));

//Suivi Passation des marchés PR

        $objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AK".$ligne, $value->date_manifestation_pr);

        $objPHPExcel->getActiveSheet()->getStyle("AL".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AL".$ligne, $value->date_lancement_dp_pr);

        $objPHPExcel->getActiveSheet()->getStyle("AM".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AM".$ligne, $value->date_remise_pr);

        $objPHPExcel->getActiveSheet()->getStyle("AN".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AN".$ligne, $value->nbr_offre_recu_pr);

        $objPHPExcel->getActiveSheet()->getStyle("AO".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AO".$ligne, $value->date_os_pr);

        $objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AP".$ligne, $value->nom_pr);

        $objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AQ".$ligne, $value->montant_contrat_pr);


        $objPHPExcel->getActiveSheet()->getStyle("AR".$ligne)->applyFromArray($stylecontenu);
        $objPHPExcel->getActiveSheet()->getStyle("AS".$ligne)->applyFromArray($stylecontenu);
        $objPHPExcel->getActiveSheet()->getStyle("AT".$ligne)->applyFromArray($stylecontenu);
        $objPHPExcel->getActiveSheet()->getStyle("AU".$ligne)->applyFromArray($stylecontenu);

//module dpp        

        $objPHPExcel->getActiveSheet()->getStyle("AV".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AV".$ligne, $value->date_debut_previ_form_dpp_pr);

        $objPHPExcel->getActiveSheet()->getStyle("AW".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AW".$ligne, $value->date_fin_previ_form_dpp_pr);

        $objPHPExcel->getActiveSheet()->getStyle("AX".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AX".$ligne, $value->date_previ_resti_dpp_pr);

        $objPHPExcel->getActiveSheet()->getStyle("AY".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AY".$ligne, $value->date_debut_reel_form_dpp_pr);

        $objPHPExcel->getActiveSheet()->getStyle("AZ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AZ".$ligne, $value->date_fin_reel_form_dpp_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BA".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BA".$ligne, $value->date_reel_resti_dpp_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BB".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BB".$ligne, $value->nbr_previ_parti_dpp_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BC".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BC".$ligne, $value->nbr_parti_dpp_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BD".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BD".$ligne, $value->nbr_previ_fem_parti_dpp_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BE".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BE".$ligne, $value->nbr_reel_fem_parti_dpp_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BF".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BF".$ligne, $value->lieu_formation_dpp_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BG".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BG".$ligne, $value->observation_dpp_pr);

//modeule odc       

        $objPHPExcel->getActiveSheet()->getStyle("BH".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BH".$ligne, $value->date_debut_previ_form_odc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BI".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BI".$ligne, $value->date_fin_previ_form_odc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BJ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BJ".$ligne, $value->date_previ_resti_odc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BK".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BK".$ligne, $value->date_debut_reel_form_odc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BL".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BL".$ligne, $value->date_fin_reel_form_odc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BM".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BM".$ligne, $value->date_reel_resti_odc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BN".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BN".$ligne, $value->nbr_previ_parti_odc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BO".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BO".$ligne, $value->nbr_parti_odc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BP".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BP".$ligne, $value->nbr_previ_fem_parti_odc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BQ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BQ".$ligne, $value->nbr_reel_fem_parti_odc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BR".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BR".$ligne, $value->lieu_formation_odc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BS".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BS".$ligne, $value->observation_odc_pr);

//modeule pmc       

        $objPHPExcel->getActiveSheet()->getStyle("BT".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BT".$ligne, $value->date_debut_previ_form_pmc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BU".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BU".$ligne, $value->date_fin_previ_form_pmc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BV".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BV".$ligne, $value->date_previ_resti_pmc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BW".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BW".$ligne, $value->date_debut_reel_form_pmc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BX".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BX".$ligne, $value->date_fin_reel_form_pmc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BY".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BY".$ligne, $value->date_reel_resti_pmc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("BZ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("BZ".$ligne, $value->nbr_previ_parti_pmc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CA".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CA".$ligne, $value->nbr_parti_pmc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CB".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CB".$ligne, $value->nbr_previ_fem_parti_pmc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CC".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CC".$ligne, $value->nbr_reel_fem_parti_pmc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CD".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CD".$ligne, $value->lieu_formation_pmc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CE".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CE".$ligne, $value->observation_pmc_pr);

//modeule gfpc       

        $objPHPExcel->getActiveSheet()->getStyle("CF".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CF".$ligne, $value->date_debut_previ_form_gfpc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CG".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CG".$ligne, $value->date_fin_previ_form_gfpc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CH".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CH".$ligne, $value->date_previ_resti_gfpc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CI".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CI".$ligne, $value->date_debut_reel_form_gfpc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CJ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CJ".$ligne, $value->date_fin_reel_form_gfpc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CK".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CK".$ligne, $value->date_reel_resti_gfpc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CL".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CL".$ligne, $value->nbr_previ_parti_gfpc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CM".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CM".$ligne, $value->nbr_parti_gfpc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CN".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CN".$ligne, $value->nbr_previ_fem_parti_gfpc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CO".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CO".$ligne, $value->nbr_reel_fem_parti_gfpc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CP".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CP".$ligne, $value->lieu_formation_gfpc_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CQ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CQ".$ligne, $value->observation_gfpc_pr);

//modeule sep       

        $objPHPExcel->getActiveSheet()->getStyle("CR".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CR".$ligne, $value->date_debut_previ_form_sep_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CS".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CS".$ligne, $value->date_fin_previ_form_sep_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CT".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CT".$ligne, $value->date_previ_resti_sep_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CU".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CU".$ligne, $value->date_debut_reel_form_sep_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CV".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CV".$ligne, $value->date_fin_reel_form_sep_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CW".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CW".$ligne, $value->date_reel_resti_sep_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CX".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CX".$ligne, $value->nbr_previ_parti_sep_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CY".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CY".$ligne, $value->nbr_parti_sep_pr);

        $objPHPExcel->getActiveSheet()->getStyle("CZ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("CZ".$ligne, $value->nbr_previ_fem_parti_sep_pr);

        $objPHPExcel->getActiveSheet()->getStyle("DA".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DA".$ligne, $value->nbr_reel_fem_parti_sep_pr);

        $objPHPExcel->getActiveSheet()->getStyle("DB".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DB".$ligne, $value->lieu_formation_sep_pr);

        $objPHPExcel->getActiveSheet()->getStyle("DC".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DC".$ligne, $value->observation_sep_pr);

//modeule emies       

        $objPHPExcel->getActiveSheet()->getStyle("DD".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DD".$ligne, $value->date_debut_previ_form_emies_pr);

        $objPHPExcel->getActiveSheet()->getStyle("DE".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DE".$ligne, $value->date_fin_previ_form_emies_pr);

        $objPHPExcel->getActiveSheet()->getStyle("DF".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DF".$ligne, $value->date_previ_resti_emies_pr);

        $objPHPExcel->getActiveSheet()->getStyle("DG".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DG".$ligne, $value->date_debut_reel_form_emies_pr);

        $objPHPExcel->getActiveSheet()->getStyle("DH".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DH".$ligne, $value->date_fin_reel_form_emies_pr);

        $objPHPExcel->getActiveSheet()->getStyle("DI".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DI".$ligne, $value->date_reel_resti_emies_pr);

        $objPHPExcel->getActiveSheet()->getStyle("DJ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DJ".$ligne, $value->nbr_previ_parti_emies_pr);

        $objPHPExcel->getActiveSheet()->getStyle("DK".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DK".$ligne, $value->nbr_parti_emies_pr);

        $objPHPExcel->getActiveSheet()->getStyle("DL".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DL".$ligne, $value->nbr_previ_fem_parti_emies_pr);

        $objPHPExcel->getActiveSheet()->getStyle("DM".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DM".$ligne, $value->nbr_reel_fem_parti_emies_pr);

        $objPHPExcel->getActiveSheet()->getStyle("DN".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DN".$ligne, $value->lieu_formation_emies_pr);

        $objPHPExcel->getActiveSheet()->getStyle("DO".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DO".$ligne, $value->observation_emies_pr);

//passation moe

        $objPHPExcel->getActiveSheet()->getStyle("DP".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DP".$ligne, $value->date_shortlist_moe);

        $objPHPExcel->getActiveSheet()->getStyle("DQ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DQ".$ligne, $value->date_manifestation_moe);

        $objPHPExcel->getActiveSheet()->getStyle("DR".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DR".$ligne, $value->date_lancement_dp_moe);

        $objPHPExcel->getActiveSheet()->getStyle("DS".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DS".$ligne, $value->date_remise_moe);

        $objPHPExcel->getActiveSheet()->getStyle("DT".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DT".$ligne, $value->nbr_offre_recu_moe);

        $objPHPExcel->getActiveSheet()->getStyle("DU".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DU".$ligne, $value->date_rapport_evaluation_moe);

        $objPHPExcel->getActiveSheet()->getStyle("DV".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DV".$ligne, $value->date_demande_ano_dpfi_moe);

        $objPHPExcel->getActiveSheet()->getStyle("DW".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DW".$ligne, $value->date_ano_dpfi_moe);

        $objPHPExcel->getActiveSheet()->getStyle("DX".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DX".$ligne, $value->notification_intention_moe);

        $objPHPExcel->getActiveSheet()->getStyle("DY".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DY".$ligne, $value->date_notification_attribution_moe);

        $objPHPExcel->getActiveSheet()->getStyle("DZ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("DZ".$ligne, $value->date_signature_contrat_moe);

        $objPHPExcel->getActiveSheet()->getStyle("EA".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EA".$ligne, $value->date_os_moe);

        $objPHPExcel->getActiveSheet()->getStyle("EB".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EB".$ligne, $value->nom_bureau_etude_moe);

        $objPHPExcel->getActiveSheet()->getStyle("EC".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EC".$ligne, $value->statut_moe);

        $objPHPExcel->getActiveSheet()->getStyle("ED".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("ED".$ligne, $value->montant_contrat_moe);

        $objPHPExcel->getActiveSheet()->getStyle("EE".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EE".$ligne, $value->montant_avenant_moe);

        $objPHPExcel->getActiveSheet()->getStyle("EF".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EF".$ligne, $value->montant_avenant_moe + $value->montant_contrat_moe);

        $objPHPExcel->getActiveSheet()->getStyle("EG".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EG".$ligne, $value->observation_moe);


//PRESTATIO MOE
        $objPHPExcel->getActiveSheet()->getStyle("EH".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EH".$ligne, $value->date_livraison_mt);

        $objPHPExcel->getActiveSheet()->getStyle("EI".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EI".$ligne, $value->date_approbation_mt);

        $objPHPExcel->getActiveSheet()->getStyle("EJ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EJ".$ligne, $value->date_livraison_dao);

        $objPHPExcel->getActiveSheet()->getStyle("EK".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EK".$ligne, $value->date_approbation_dao);

        $objPHPExcel->getActiveSheet()->getStyle("EL".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EL".$ligne, $value->date_livraison_rp1);

        $objPHPExcel->getActiveSheet()->getStyle("EM".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EM".$ligne, $value->date_livraison_rp2);

        $objPHPExcel->getActiveSheet()->getStyle("EN".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EN".$ligne, $value->date_livraison_rp3);

        $objPHPExcel->getActiveSheet()->getStyle("EO".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EO".$ligne, $value->date_livraison_rp4);

        $objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EP".$ligne, $value->date_livraison_mg);

        $objPHPExcel->getActiveSheet()->getStyle("EQ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        //$objPHPExcel->setActiveSheetIndex(0)->setCellValue("EQ".$ligne, $value->);

        $objPHPExcel->getActiveSheet()->getStyle("ER".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
           /* $this->db ->select("(select sum(paiement_batiment_moe.montant_paiement) from paiement_batiment_moe,demande_batiment_moe, contrat_bureau_etude, convention_cisco_feffi_entete where paiement_batiment_moe.id_demande_batiment_moe=demande_batiment_moe.id and demande_batiment_moe.id_contrat_bureau_etude=contrat_bureau_etude.id and contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and paiement_batiment_moe.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as montant_paiement_batiment_moe",FALSE);*/
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("ER".$ligne, $value->montant_paiement_debut_moe +$value->montant_paiement_batiment_moe + $value->montant_paiement_latrine_moe + $value->montant_paiement_fin_moe);

        $objPHPExcel->getActiveSheet()->getStyle("ES".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        if ($value->montant_contrat_moe) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("ES".$ligne, (($value->montant_paiement_debut_moe +$value->montant_paiement_batiment_moe + $value->montant_paiement_latrine_moe + $value->montant_paiement_fin_moe)*100)/$value->montant_contrat_moe);
        }
        

        $objPHPExcel->getActiveSheet()->getStyle("ET".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("ET".$ligne, $value->date_expiration_poli_moe);

//passation mpe

        $objPHPExcel->getActiveSheet()->getStyle("EU".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EU".$ligne, $value->date_lancement_pme);

        $objPHPExcel->getActiveSheet()->getStyle("EV".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EV".$ligne, $value->date_remise_pme);

        $objPHPExcel->getActiveSheet()->getStyle("EW".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EW".$ligne, $value->nbr_mpe_soumissionaire_pme);
        
        $objPHPExcel->getActiveSheet()->getStyle("EX".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EX".$ligne, $value->nbr_mpe_soumissionaire_pme);

        $objPHPExcel->getActiveSheet()->getStyle("EY".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EY".$ligne, $value->montant_moin_chere_pme);

        $objPHPExcel->getActiveSheet()->getStyle("EZ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("EZ".$ligne, $value->date_rapport_evaluation_pme);

        $objPHPExcel->getActiveSheet()->getStyle("FA".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FA".$ligne, $value->date_demande_ano_dpfi_pme);

        $objPHPExcel->getActiveSheet()->getStyle("FB".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FB".$ligne, $value->date_ano_dpfi_pme);

        $objPHPExcel->getActiveSheet()->getStyle("FC".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FC".$ligne, $value->notification_intention_pme);

        $objPHPExcel->getActiveSheet()->getStyle("FD".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FD".$ligne, $value->date_notification_attribution_pme);

        $objPHPExcel->getActiveSheet()->getStyle("FE".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FE".$ligne, $value->date_signature_pme);

        $objPHPExcel->getActiveSheet()->getStyle("FF".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FF".$ligne, $value->date_os_pme);

        $objPHPExcel->getActiveSheet()->getStyle("FG".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FG".$ligne, $value->nom_prestataire);

        $objPHPExcel->getActiveSheet()->getStyle("FH".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FH".$ligne, $value->observation_passation_pme);

        $objPHPExcel->getActiveSheet()->getStyle("FI".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FI".$ligne, $value->cout_batiment_pme);

        $objPHPExcel->getActiveSheet()->getStyle("FJ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FJ".$ligne, $value->cout_latrine_pme);

        $objPHPExcel->getActiveSheet()->getStyle("FK".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FK".$ligne, $value->cout_mobilier_pme);

        $objPHPExcel->getActiveSheet()->getStyle("FL".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FL".$ligne, $value->cout_mobilier_pme + $value->cout_latrine_pme + $value->cout_batiment_pme);

        $objPHPExcel->getActiveSheet()->getStyle("FM".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FM".$ligne, $value->cout_latrine_avenant_mpe + $value->cout_batiment_avenant_mpe + $value->cout_mobilier_avenant_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("FN".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FN".$ligne, $value->cout_mobilier_pme + $value->cout_latrine_pme + $value->cout_batiment_pme + $value->cout_latrine_avenant_mpe + $value->cout_batiment_avenant_mpe + $value->cout_mobilier_avenant_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("FO".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FO".$ligne, $value->phase_sousprojet_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("FP".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FP".$ligne, $value->date_prev_debu_travau_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("FQ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FQ".$ligne, $value->date_reel_debu_travau_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("FR".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FR".$ligne, $value->delai_execution_mpe);

//reception

        $objPHPExcel->getActiveSheet()->getStyle("FS".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FS".$ligne, $value->date_previ_recep_tech_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("FT".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FT".$ligne, $value->date_reel_tech_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("FU".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FU".$ligne, $value->date_leve_recep_tech_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("FV".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FV".$ligne, $value->date_previ_recep_prov_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("FW".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FW".$ligne, $value->date_reel_recep_prov_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("FX".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FX".$ligne, $value->date_previ_leve_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("FY".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FY".$ligne, $value->date_reel_lev_ava_rd_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("FZ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("FZ".$ligne, $value->date_previ_recep_defi_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("GA".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GA".$ligne, $value->date_reel_recep_defi_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("GB".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GB".$ligne, (($value->avancement_batiment_mpe + $value->avancement_latrine_mpe +$value->avancement_mobilier_mpe)/3).' %');

        $objPHPExcel->getActiveSheet()->getStyle("GC".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GC".$ligne, $value->observation_recep_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("GD".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GD".$ligne, $value->date_expiration_police_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("GE".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GE".$ligne, $value->date_approbation_mpe1);

        $objPHPExcel->getActiveSheet()->getStyle("GF".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GF".$ligne, $value->montant_paiement_mpe1);

        $objPHPExcel->getActiveSheet()->getStyle("GG".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GG".$ligne, $value->date_approbation_mpe2);

        $objPHPExcel->getActiveSheet()->getStyle("GH".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GH".$ligne, $value->montant_paiement_mpe2);

        $objPHPExcel->getActiveSheet()->getStyle("GI".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GI".$ligne, $value->date_approbation_mpe3);

        $objPHPExcel->getActiveSheet()->getStyle("GJ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GJ".$ligne, $value->montant_paiement_mpe3);

        $objPHPExcel->getActiveSheet()->getStyle("GK".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GK".$ligne, $value->date_approbation_mpe4);

        $objPHPExcel->getActiveSheet()->getStyle("GL".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GL".$ligne, $value->montant_paiement_mpe4);

        $objPHPExcel->getActiveSheet()->getStyle("GM".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GM".$ligne, $value->date_approbation_mpe5);

        $objPHPExcel->getActiveSheet()->getStyle("GN".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GN".$ligne, $value->montant_paiement_mpe5);

       /* $objPHPExcel->getActiveSheet()->getStyle("GO".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GO".$ligne, $value->anterieur_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("GP".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GP".$ligne, $value->periode_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("GQ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GQ".$ligne, $value->cumul_mpe);*/

        $objPHPExcel->getActiveSheet()->getStyle("GO".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GO".$ligne, $value->date_approbation_mpe6);

        $objPHPExcel->getActiveSheet()->getStyle("GP".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GP".$ligne, $value->montant_paiement_mpe6);

        $objPHPExcel->getActiveSheet()->getStyle("GQ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GQ".$ligne, $value->date_approbation_mpe7);

        $objPHPExcel->getActiveSheet()->getStyle("GR".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GR".$ligne, $value->montant_paiement_mpe7);

        $objPHPExcel->getActiveSheet()->getStyle("GS".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GS".$ligne, $value->date_approbation_mpe8);

        $objPHPExcel->getActiveSheet()->getStyle("GT".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GT".$ligne, $value->montant_paiement_mpe8);

        /*$objPHPExcel->getActiveSheet()->getStyle("GX".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GX".$ligne, $value->anterieur_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("GY".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GY".$ligne, $value->periode_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("GZ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GZ".$ligne, $value->cumul_mpe);*/

        $objPHPExcel->getActiveSheet()->getStyle("GU".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GU".$ligne, $value->date_approbation_mpe9);

        $objPHPExcel->getActiveSheet()->getStyle("GV".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GV".$ligne, $value->montant_paiement_mpe9);

        $objPHPExcel->getActiveSheet()->getStyle("GW".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GW".$ligne, $value->date_approbation_mpe10);

        $objPHPExcel->getActiveSheet()->getStyle("GX".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GX".$ligne, $value->montant_paiement_mpe10);

        $objPHPExcel->getActiveSheet()->getStyle("GY".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GY".$ligne, $value->anterieur_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("GZ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GZ".$ligne, $value->periode_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("HA".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HA".$ligne, $value->cumul_mpe);

        $objPHPExcel->getActiveSheet()->getStyle("HB".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        //$objPHPExcel->setActiveSheetIndex(0)->setCellValue("HH".$ligne, $value->);

        $objPHPExcel->getActiveSheet()->getStyle("HC".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HC".$ligne, $value->montant_transfert_reliquat);

        $objPHPExcel->getActiveSheet()->getStyle("HD".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HD".$ligne, $value->objet_utilisation_reliquat);

        $objPHPExcel->getActiveSheet()->getStyle("HE".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HE".$ligne, $value->situation_utilisation_reliquat);

        $objPHPExcel->getActiveSheet()->getStyle("HF".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HF".$ligne, $value->observation_reliquat);

        $objPHPExcel->getActiveSheet()->getStyle("HG".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HG".$ligne, $value->prev_nbr_salle);

        $objPHPExcel->getActiveSheet()->getStyle("HH".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HH".$ligne, $value->nbr_salle_const_indicateur);

        $objPHPExcel->getActiveSheet()->getStyle("HI".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HI".$ligne, $value->prev_beneficiaire);

        $objPHPExcel->getActiveSheet()->getStyle("HJ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HJ".$ligne, $value->nbr_beneficiaire_indicateur);

        $objPHPExcel->getActiveSheet()->getStyle("HK".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HK".$ligne, $value->prev_nbr_ecole);

        $objPHPExcel->getActiveSheet()->getStyle("HL".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HL".$ligne, $value->nbr_ecole_indicateur);

        $objPHPExcel->getActiveSheet()->getStyle("HM".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HM".$ligne, $value->prev_nbr_box_latrine);

        $objPHPExcel->getActiveSheet()->getStyle("HN".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HN".$ligne, $value->nbr_box_indicateur);

        $objPHPExcel->getActiveSheet()->getStyle("HO".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HO".$ligne, $value->prev_nbr_point_eau);

        $objPHPExcel->getActiveSheet()->getStyle("HP".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HP".$ligne, $value->nbr_point_eau_indicateur);

        $objPHPExcel->getActiveSheet()->getStyle("HQ".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HQ".$ligne, $value->prev_nbr_table_banc);

        $objPHPExcel->getActiveSheet()->getStyle("HR".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HR".$ligne, $value->nbr_banc_indicateur);

        $objPHPExcel->getActiveSheet()->getStyle("HS".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HS".$ligne, $value->prev_nbr_table_maitre);

        $objPHPExcel->getActiveSheet()->getStyle("HT".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HT".$ligne, $value->nbr_table_maitre_indicateur);

        $objPHPExcel->getActiveSheet()->getStyle("HU".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HU".$ligne, $value->prev_nbr_chaise_maitre);

        $objPHPExcel->getActiveSheet()->getStyle("HV".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HV".$ligne, $value->nbr_chaise_indicateur);

        $objPHPExcel->getActiveSheet()->getStyle("HW".$ligne)->applyFromArray($stylecontenu);
        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("HW".$ligne, $value->observation_indicateur);

            $ligne++;
        }
        
        
    

        try
        {
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save(dirname(__FILE__) . "/../../../../../../assets/excel/bdd_construction/".$nom_file.".xlsx");
            
            $this->response([
                'status' => TRUE,
                'nom_file' =>$nom_file.".xlsx",
                'data' =>$data,
                'message' => 'Get file success',
            ], REST_Controller::HTTP_OK);
          
        } 
        catch (PHPExcel_Writer_Exception $e)
        {
            $this->response([
                  'status' => FALSE,
                   'nom_file' => $paiement_batiment_pre,
                   'message' => "Something went wrong: ". $e->getMessage(),
                ], REST_Controller::HTTP_OK);
        }

    }

    public function conversion_kg_tonne($val)
    {   
        if ($val > 1000) 
        {
          $res = $val/1000 ;
          $res=number_format(($val/1000),3,","," ");

          return $res." t" ;
        }
        else
        { 
            $res=number_format($val,3,","," ");

            return $res." Kg" ;
        }
    }
    public function generer_requete($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot)
    {
            $requete = "Convention_cisco_feffi_detail.date_signature BETWEEN '".$date_debut."' AND '".$date_fin."' " ;
        
            

            if (($id_region!='*')&&($id_region!='undefined')&&($id_region!='null')) 
            {
                $requete = $requete." AND region.id='".$id_region."'" ;
            }

            if (($id_cisco!='*')&&($id_cisco!='undefined')&&($id_cisco!='null')) 
            {
                $requete = $requete." AND Convention_cisco_feffi_entete.id_cisco='".$id_cisco."'" ;
            }

            if (($id_commune!='*')&&($id_commune!='undefined')&&($id_commune!='null')) 
            {
                $requete = $requete." AND commune.id='".$id_commune."'" ;
            }

            if (($id_ecole!='*')&&($id_ecole!='undefined')&&($id_ecole!='null')) 
            {
                $requete = $requete." AND ecole.id='".$id_ecole."'" ;
            }

            if (($id_convention_entete!='*')&&($id_convention_entete!='undefined')&&($id_convention_entete!='null')) 
            {
                $requete = $requete." AND Convention_cisco_feffi_entete.id='".$id_convention_entete."'" ;
            }
            if (($lot!='*')&&($lot!='undefined')&&($lot!='null')) 
            {
                $requete = $requete." AND site.lot='".$lot."'" ;
            }
            
        return $requete ;
    }    

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
?>