<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//harizo
// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Excel_bdd_construction_detail extends REST_Controller
{

    public function __construct() {
        parent::__construct();
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        
    }
   
    public function index_get() 
    {   
        set_time_limit(0);
        ini_set ('memory_limit', '4000M');
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
        $id_zap = $this->get('id_zap');


        $suivi_financier_daaf_feffi= $this->get('suivi_financier_daaf_feffi');
        $suivi_financier_feffi_prestataire= $this->get('suivi_financier_feffi_prestataire');
        $suivi_financier_feffi_fonctionnement= $this->get('suivi_financier_feffi_fonctionnement');
        $total_convention_decaissee= $this->get('total_convention_decaissee');
        $reliquat_des_fonds= $this->get('reliquat_des_fonds');

        $partenaire_relais= $this->get('partenaire_relais');
        $suivi_passation_marches_pr= $this->get('suivi_passation_marches_pr');
        $suivi_prestation_pr= $this->get('suivi_prestation_pr');

        $maitrise_oeuvre= $this->get('maitrise_oeuvre');
        $suivi_passation_marches_moe= $this->get('suivi_passation_marches_moe');
        $suivi_prestation_moe= $this->get('suivi_prestation_moe');
        $suivi_paiement_moe= $this->get('suivi_paiement_moe');
        $police_assurance_moe= $this->get('police_assurance_moe');

        $entreprise= $this->get('entreprise');
        $suivi_passation_marches_mpe= $this->get('suivi_passation_marches_mpe');
        $suivi_execution_travau_mpe= $this->get('suivi_execution_travau_mpe');
        $suivi_paiement_mpe= $this->get('suivi_paiement_mpe');
        

        $indicateur= $this->get('indicateur');
        $transfert_reliquat= $this->get('transfert_reliquat');

        $data = array() ;


        //*********************************** Nombre echantillon *************************
        
 
                    
            
        
        
        //********************************* fin Nombre echantillon *****************************
        if ($menu=='getdonneeexporter') //mande       
        {   
            $params['suivi_financier_daaf_feffi']= $suivi_financier_daaf_feffi;
            $params['suivi_financier_feffi_prestataire']= $suivi_financier_feffi_prestataire;
            $params['suivi_financier_feffi_fonctionnement']= $suivi_financier_feffi_fonctionnement;
            $params['total_convention_decaissee']= $total_convention_decaissee;
            $params['reliquat_des_fonds']= $reliquat_des_fonds;

            $params['partenaire_relais']= $partenaire_relais;
            $params['suivi_passation_marches_pr']= $suivi_passation_marches_pr;
            $params['suivi_prestation_pr']= $suivi_prestation_pr;

            $params['maitrise_oeuvre']= $maitrise_oeuvre;
            $params['suivi_passation_marches_moe']= $suivi_passation_marches_moe;
            $params['suivi_prestation_moe']= $suivi_prestation_moe;
            $params['suivi_paiement_moe']= $suivi_paiement_moe;
            $params['police_assurance_moe']= $police_assurance_moe;

            $params['entreprise']= $entreprise;
            $params['suivi_passation_marches_mpe']= $suivi_passation_marches_mpe;
            $params['suivi_execution_travau_mpe']= $suivi_execution_travau_mpe;
            $params['suivi_paiement_mpe']= $suivi_paiement_mpe;
                    

            $params['indicateur']= $indicateur;
            $params['transfert_reliquat']= $transfert_reliquat;

            $tmp = $this->Convention_cisco_feffi_enteteManager->finddonneeexporter($this->generer_requete_convention_cisco_feffi($id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap));
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
            
                $export=$this->export_excel($repertoire,$data,$params);

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
            $tmp = $this->Convention_cisco_feffi_enteteManager->finddonneeexporter($this->generer_requete_convention_cisco_feffi($id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {                   
                    $periode_batiment_avance_phy =0;
                    $periode_latrine_avance_phy =0;
                    $periode_mobilier_avance_phy =0;
                    $anterieur_batiment_avance_phy =0;
                    $anterieur_latrine_avance_phy =0;
                    $anterieur_mobilier_avance_phy =0;

                    $data[$key]['suivi_financier_daaf_feffi']= $suivi_financier_daaf_feffi;
                    $data[$key]['suivi_financier_feffi_prestataire']= $suivi_financier_feffi_prestataire;
                    $data[$key]['suivi_financier_feffi_fonctionnement']= $suivi_financier_feffi_fonctionnement;
                    $data[$key]['total_convention_decaissee']= $total_convention_decaissee;
                    $data[$key]['reliquat_des_fonds']= $reliquat_des_fonds;

                    $data[$key]['partenaire_relais']= $partenaire_relais;
                    $data[$key]['suivi_passation_marches_pr']= $suivi_passation_marches_pr;
                    $data[$key]['suivi_prestation_pr']= $suivi_prestation_pr;

                    $data[$key]['maitrise_oeuvre']= $maitrise_oeuvre;
                    $data[$key]['suivi_passation_marches_moe']= $suivi_passation_marches_moe;
                    $data[$key]['suivi_prestation_moe']= $suivi_prestation_moe;
                    $data[$key]['suivi_paiement_moe']= $suivi_paiement_moe;
                    $data[$key]['police_assurance_moe']= $police_assurance_moe;

                    $data[$key]['entreprise']= $entreprise;
                    $data[$key]['suivi_passation_marches_mpe']= $suivi_passation_marches_mpe;
                    $data[$key]['suivi_execution_travau_mpe']= $suivi_execution_travau_mpe;
                    $data[$key]['suivi_paiement_mpe']= $suivi_paiement_mpe;
        //donnee globale             
                    $data[$key]['nom_agence']= $value->nom_agence;
                    $data[$key]['nom_ecole']= $value->nom_ecole;
                    $data[$key]['code_ecole']= $value->code_ecole;                    
                    $data[$key]['village']= $value->village;
                    $data[$key]['nom_fokontany']= $value->nom_fokontany;
                    $data[$key]['nom_commune']= $value->nom_commune;
                    $data[$key]['nom_cisco']= $value->nom_cisco;
                    $data[$key]['nom_region']= $value->nom_region;
                    $data[$key]['type_convention']= $value->libelle_zone.$value->libelle_acces;
                    $data[$key]['ref_convention']= $value->ref_convention;

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

                $data[$key]['montant_decaiss_feffi_pre']= $value->montant_paiement_mpe1 + $value->montant_paiement_mpe2 + $value->montant_paiement_mpe3 + $value->montant_paiement_mpe4 +$value->montant_paiement_mpe5 + $value->montant_paiement_mpe6+ $value->montant_paiement_mpe7+ $value->montant_paiement_mpe8+ $value->montant_paiement_mpe9+ $value->montant_paiement_mpe10 + $value->montant_paiement_moe;

                if ($value->soustotaldepense) {
                    $data[$key]['pourcentage_decaiss_feffi_pre']= (($value->montant_paiement_mpe1 + $value->montant_paiement_mpe2 + $value->montant_paiement_mpe3 + $value->montant_paiement_mpe4 +$value->montant_paiement_mpe5 + $value->montant_paiement_mpe6+ $value->montant_paiement_mpe7+ $value->montant_paiement_mpe8+ $value->montant_paiement_mpe9+ $value->montant_paiement_mpe10 + $value->montant_paiement_moe)*100)/$value->soustotaldepense;
                }
                


        //SUIVI FINANCIER FEFFI FONCTIONNEMENT

                $data[$key]['montant_decaiss_fonct_feffi']= $value->montant_decaiss_fonct_feffi;

                if ($value->cout_sousprojet) {
                    $data[$key]['pourcentage_decaiss_fonct_feffi']= ($value->montant_decaiss_fonct_feffi*100)/$value->cout_sousprojet;
                }
                


                $data[$key]['total_convention_decaiss']= $value->montant_decaiss_fonct_feffi + $value->montant_paiement_mpe1 + $value->montant_paiement_mpe2 + $value->montant_paiement_mpe3 + $value->montant_paiement_mpe4 +$value->montant_paiement_mpe5 + $value->montant_paiement_mpe6+ $value->montant_paiement_mpe7+ $value->montant_paiement_mpe8+ $value->montant_paiement_mpe9+ $value->montant_paiement_mpe10 + $value->montant_paiement_moe;

                //$data[$key]['reliqua_fond']= $value->montant_convention - ($value->montant_decaiss_fonct_feffi + $value->montant_paiement_mpe1 + $value->montant_paiement_mpe2 + $value->montant_paiement_mpe3 + $value->montant_paiement_mpe4 +$value->montant_paiement_mpe5 + $value->montant_paiement_mpe6+ $value->montant_paiement_mpe7+ $value->montant_paiement_mpe8+ $value->montant_paiement_mpe9+ $value->montant_paiement_mpe10 + $value->montant_paiement_moe);
                $data[$key]['reliqua_fond']= ($value->montant_convention + $value->cout_avenant) - ($value->montant_contrat_moe + $value->cout_mobilier_pme + $value->cout_latrine_pme + $value->cout_batiment_pme);
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

                $data[$key]['cumule_paiement_be']= $value->montant_paiement_moe;

                if ($value->montant_contrat_moe) {
                    $data[$key]['pourcentage_paiement_be']= (($value->montant_paiement_moe)*100)/$value->montant_contrat_moe;
                }
                

                $data[$key]['date_expiration_poli_moe']= $value->date_expiration_poli_moe;

        //passation mpe

                $data[$key]['date_lancement_pme']= $value->date_lancement_pme;

                $data[$key]['date_remise_pme']= $value->date_remise_pme;

                $data[$key]['nbr_mpe_soumissionaire_pme']= $value->nbr_mpe_soumissionaire_pme;
                
                $data[$key]['liste_mpe_soumissionaire']= $value->liste_mpe_soumissionaire;

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
                $data[$key]['montant_apres_avenant_mpe']= $value->cout_mobilier_pme + $value->cout_latrine_pme + $value->cout_batiment_pme + $value->cout_latrine_avenant_mpe + $value->cout_batiment_avenant_mpe + $value->cout_mobilier_avenant_mpe;

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

               // $data[$key]['avancement_physique']= round(($value->avancement_batiment_mpe + $value->avancement_latrine_mpe +$value->avancement_mobilier_mpe),2).' %';
               $avancement_phisique= 0;
               if ($value->montant_contrat_avance_phy!=null)
               {
                   if ($value->periode_bat_avance_phy)
                       {
                           $periode_batiment_avance_phy = $value->periode_bat_avance_phy;
                       }
                       if ($value->periode_lat_avance_phy)
                       {
                           $periode_latrine_avance_phy = $value->periode_lat_avance_phy;
                       }
                       if ($value->periode_mob_avance_phy)
                       {
                           $periode_mobilier_avance_phy = $value->periode_mob_avance_phy;
                       }
                       if ($value->anterieur_bat_avance_phy)
                       {
                           $anterieur_batiment_avance_phy = $value->anterieur_bat_avance_phy;
                       }
                       if ($value->anterieur_lat_avance_phy)
                       {
                           $anterieur_latrine_avance_phy = $value->anterieur_lat_avance_phy;
                       }
                       if ($value->anterieur_mob_avance_phy)
                       {
                           $anterieur_mobilier_avance_phy = $value->anterieur_mob_avance_phy;
                       }
                       $avancement_phisique =((((($value->cout_batiment_avance_phy*100)/$value->montant_contrat_avance_phy)*$anterieur_batiment_avance_phy)/100)+(((($value->cout_batiment_avance_phy*100)/$value->montant_contrat_avance_phy)*$periode_batiment_avance_phy)/100)
                   )+((((($value->cout_latrine_avance_phy*100)/$value->montant_contrat_avance_phy)*$anterieur_latrine_avance_phy)/100)+(((($value->cout_latrine_avance_phy*100)/$value->montant_contrat_avance_phy)*$periode_latrine_avance_phy)/100)
                   )+((((($value->cout_mobilier_avance_phy*100)/$value->montant_contrat_avance_phy)*$anterieur_mobilier_avance_phy)/100)+(((($value->cout_mobilier_avance_phy*100)/$value->montant_contrat_avance_phy)*$periode_mobilier_avance_phy)/100));
               }
               $data[$key]['avancement_physique']= $avancement_phisique;
                $data[$key]['observation_recep_mpe']= $value->observation_recep_mpe;

                $data[$key]['date_expiration_police_mpe']= $value->date_expiration_police_mpe;

                $data[$key]['date_approbation_avance_mpe']= $value->date_approbation_avance_mpe;

                $data[$key]['montant_paiement_avance_mpe']= $value->montant_paiement_avance_mpe;

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
                if ($value->montant_paiement_mpe2)
                {
                    $data[$key]['anterieur_mpe']= $value->anterieur_mpe;

                    $data[$key]['periode_mpe']= $value->periode_mpe;

                    $data[$key]['cumul_mpe']= $value->cumul_mpe + $value->montant_paiement_avance_mpe;
                }
                else
                {
                    if ($value->montant_paiement_mpe1)
                    {
                        $data[$key]['anterieur_mpe']= $value->montant_paiement_avance_mpe;

                        $data[$key]['periode_mpe']= $value->periode_mpe;

                        $data[$key]['cumul_mpe']= $value->cumul_mpe + $value->montant_paiement_avance_mpe;
                    }
                    else
                    {

                        $data[$key]['anterieur_mpe']= $value->anterieur_mpe;

                        $data[$key]['periode_mpe']= $value->montant_paiement_avance_mpe;

                        $data[$key]['cumul_mpe']=$value->montant_paiement_avance_mpe;
                    }
                }

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

   
    public function export_excel($repertoire,$data,$params)
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
        $colonne=65;            
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
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A".$ligne, "PROJET D'APPUI A L'EDUCATION DE BASE (PAEB)");

        $ligne++;
        //$objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($styleGras);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "TABLEAU DE SUIVI ");

        $ligne=$ligne+2;
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":J".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".($ligne+1))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "(1) DONNEES GLOBALES");

        $colonne = 74;
        $col_convetion_feffi= 11;

        if ($params['suivi_financier_daaf_feffi']=="true")
        {
           $col_convetion_feffi = $col_convetion_feffi + 11;
        }

        if ($params['suivi_financier_feffi_prestataire']=="true")
        {
           $col_convetion_feffi = $col_convetion_feffi + 3;
        }

        if ($params['suivi_financier_feffi_fonctionnement']=="true")
        {
           $col_convetion_feffi = $col_convetion_feffi + 3;
        }

        if ($params['total_convention_decaissee']=="true")
        {
           $col_convetion_feffi = $col_convetion_feffi + 1;
        }

        if ($params['reliquat_des_fonds']=="true")
        {
           $col_convetion_feffi = $col_convetion_feffi + 1;
        }

        //$col_total_convetion_feffi = $col_convetion_feffi + $colonne;

        $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne+1).$ligne.":".$this->colonne($col_convetion_feffi + $colonne).$ligne);
        $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne+1).$ligne.":".$this->colonne($col_convetion_feffi + $colonne).$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne+1).$ligne, "(2) CONVENTIONFEFFI");

        $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne+1).$ligne.":".$this->colonne($col_convetion_feffi + $colonne).$ligne)->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '9ead95')
        )
        ));

        $colonne = $col_convetion_feffi + $colonne;
        $col_partenaire_relais = 0;

        if ($params['partenaire_relais']=="true")
        {
            if ($params['suivi_passation_marches_pr']=="true")
            {
               $col_partenaire_relais = $col_partenaire_relais + 11;
            }

            if ($params['suivi_prestation_pr']=="true")
            {
               $col_partenaire_relais = $col_partenaire_relais + 72;
            }

            //$col_total_partenaire = $col_partenaire_relais + $colonne; 

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne+1).$ligne.":".$this->colonne($col_partenaire_relais + $colonne).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne+1).$ligne.":".$this->colonne($col_partenaire_relais + $colonne).$ligne)->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne+1).$ligne, "(3) PARTENAIRES RELAIS");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne+1).$ligne.":".$this->colonne($col_partenaire_relais + $colonne).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '8096bd')
            )
            ));
        }

        

        $colonne = $col_partenaire_relais + $colonne;
        $col_maitrise_oeuvre= 0;

        if ($params['maitrise_oeuvre']=="true")
        {
            if ($params['suivi_passation_marches_moe']=="true")
            {
               $col_maitrise_oeuvre = $col_maitrise_oeuvre + 18;
            }

            if ($params['suivi_prestation_moe']=="true")
            {
               $col_maitrise_oeuvre = $col_maitrise_oeuvre + 10;
            }

            if ($params['suivi_paiement_moe']=="true")
            {
               $col_maitrise_oeuvre = $col_maitrise_oeuvre + 2;
            }

            if ($params['police_assurance_moe']=="true")
            {
               $col_maitrise_oeuvre = $col_maitrise_oeuvre + 1;
            }

            //$col_total_maitrise_oeuvre = $col_maitrise_oeuvre + $colonne;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne+1).$ligne.":".$this->colonne($col_maitrise_oeuvre + $colonne).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne+1).$ligne.":".$this->colonne($col_maitrise_oeuvre + $colonne).($ligne+1))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne+1).$ligne, "(4) MAITRISE D'ŒUVRE");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne+1).$ligne.":".$this->colonne($col_maitrise_oeuvre + $colonne).($ligne+1))->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'ed7c31')
            )
            ));
        }

        
        $colonne = $col_maitrise_oeuvre + $colonne;
        $col_entreprise= 0;

        if ($params['entreprise']=="true")
        {
            if ($params['suivi_passation_marches_mpe']=="true")
            {
               $col_entreprise = $col_entreprise + 20;
            }

            if ($params['suivi_execution_travau_mpe']=="true")
            {
               $col_entreprise = $col_entreprise + 16;
            }

            if ($params['suivi_paiement_mpe']=="true")
            {
               $col_entreprise = $col_entreprise + 26;
            }

            //$col_total_entreprise = $col_entreprise + $colonne;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne+1).$ligne.":".$this->colonne($col_entreprise + $colonne).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne+1).$ligne.":".$this->colonne($col_entreprise + $colonne).$ligne)->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne+1).$ligne, "(5) ENTREPRISE");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne+1).$ligne.":".$this->colonne($col_entreprise + $colonne).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '4f81bd')
            )
            ));
            
        }
        
        $colonne = $col_entreprise + $colonne;
        $col_transfert_reliquat= 0;

        if ($params['transfert_reliquat']=="true")
        {
            
            $col_transfert_reliquat = $col_transfert_reliquat + 4;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne+1).$ligne.":".$this->colonne($col_transfert_reliquat + $colonne).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne+1).$ligne.":".$this->colonne($col_transfert_reliquat + $colonne).$ligne)->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne+1).$ligne, "(6) GESTION RELIQUATS DE FONDS");//4287f5  

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne+1).$ligne.":".$this->colonne($col_transfert_reliquat + $colonne).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '9266e3')
            )
            ));
            
        }

        $colonne = $colonne + $col_transfert_reliquat;
        $col_indicateur= 0;

        if ($params['indicateur']=="true")
        {
            
            $col_indicateur = $colonne + $col_indicateur + 17;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne+1).$ligne.":".$this->colonne($col_indicateur).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne+1).$ligne.":".$this->colonne($col_indicateur).$ligne)->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne+1).$ligne, "(7) INDICATEUR"); 

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne+1).$ligne.":".$this->colonne($col_indicateur).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'f5e4bf')
            )
            ));
            
        }
//GLOBAL
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":J".($ligne+1))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'bed4ed')
        )
        ));
        $objPHPExcel->getActiveSheet()->getStyle("A".($ligne+2).":J".($ligne+3))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'dce6f1')
        )
        ));
//CONVENTION FEFFI

        
        

        

//PARTENAIRE RELAI

        
       /* $objPHPExcel->getActiveSheet()->getStyle("AK".($ligne+1).":DO".($ligne+1))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '99abcc')
        )
        ));*/

        

//MAITRISE D4OEUVRE

        
        

        

//ENTREPRISE

        /*$objPHPExcel->getActiveSheet()->getStyle("EU".$ligne.":HI".$ligne)->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4f81bd')
        )
        ));*/
       /* $objPHPExcel->getActiveSheet()->getStyle("EU".($ligne+1).":HB".($ligne+1))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '5e99bd')
        )
        ));*/

        

//reliquat

        
       /*$objPHPExcel->getActiveSheet()->getStyle("HC".($ligne+1).":HF".($ligne+3))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'b08df2')
        )
        ));*/

//indicateur

        
      /*  $objPHPExcel->getActiveSheet()->getStyle("HG".($ligne+1).":HW".($ligne+3))->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'fff2cc')
        )
        ));*/
        

        $ligne++;

        $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":U".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":U".$ligne)->applyFromArray($styleTitre);
        //$objPHPExcel->getActiveSheet()->setColor(rgb(200,200,200));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, "ESTIMATION DE LA CONVENTION");

        $colonne_soustitre = 74;
        $col_convetion_feffi_soustitre= 11;
        
        if ($params['suivi_financier_daaf_feffi']=="true")
        {   

           $col_suivi_financier_daaf_feffi = $col_convetion_feffi_soustitre + $colonne_soustitre;
           $col_convetion_feffi_soustitre = $col_convetion_feffi_soustitre  + 11;

           $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_suivi_financier_daaf_feffi+1).$ligne.":".$this->colonne($col_convetion_feffi_soustitre + $colonne_soustitre).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_suivi_financier_daaf_feffi+1).$ligne.":".$this->colonne($col_convetion_feffi_soustitre + $colonne_soustitre).$ligne)->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_suivi_financier_daaf_feffi+1).$ligne, "SUIVI FINANCIER DAAF FEFFI");
        }

        if ($params['suivi_financier_feffi_prestataire']=="true")
        {   

           $col_suivi_financier_feffi_prestataire = $col_convetion_feffi_soustitre + $colonne_soustitre;
           $col_convetion_feffi_soustitre = $col_convetion_feffi_soustitre + 3;

           $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_suivi_financier_feffi_prestataire+1).$ligne.":".$this->colonne($col_convetion_feffi_soustitre + $colonne_soustitre).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_suivi_financier_feffi_prestataire+1).$ligne.":".$this->colonne($col_convetion_feffi_soustitre + $colonne_soustitre).$ligne)->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_suivi_financier_feffi_prestataire+1).$ligne, "SUIVI FINANCIER FEFFI -PRESTATAIRE");
        }

        if ($params['suivi_financier_feffi_fonctionnement']=="true")
        {   

           $col_suivi_financier_feffi_fonctionnement = $col_convetion_feffi_soustitre + $colonne_soustitre;
           $col_convetion_feffi_soustitre = $col_convetion_feffi_soustitre + 3;

           $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_suivi_financier_feffi_fonctionnement+1).$ligne.":".$this->colonne($col_convetion_feffi_soustitre + $colonne_soustitre).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_suivi_financier_feffi_fonctionnement+1).$ligne.":".$this->colonne($col_convetion_feffi_soustitre + $colonne_soustitre).$ligne)->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_suivi_financier_feffi_fonctionnement+1).$ligne, "SUIVI FINANCIER FEFFI FONCTIONNEMENT");
        }

        if ($params['total_convention_decaissee']=="true")
        {   

           $col_total_convention_decaissee = $col_convetion_feffi_soustitre + $colonne_soustitre;
           $col_convetion_feffi_soustitre = $col_convetion_feffi_soustitre + 1;

           $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_total_convention_decaissee+1).$ligne.":".$this->colonne($col_convetion_feffi_soustitre + $colonne_soustitre).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_total_convention_decaissee+1).$ligne.":".$this->colonne($col_convetion_feffi_soustitre + $colonne_soustitre).$ligne)->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_total_convention_decaissee+1).$ligne, "TOTAL CONVENTION DECAISSEE");
        }

        if ($params['reliquat_des_fonds']=="true")
        {   

           $col_reliquat_des_fonds = $col_convetion_feffi_soustitre + $colonne_soustitre;
           $col_convetion_feffi_soustitre = $col_convetion_feffi_soustitre + 1;

           $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_reliquat_des_fonds+1).$ligne.":".$this->colonne($col_convetion_feffi_soustitre + $colonne_soustitre).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_reliquat_des_fonds+1).$ligne.":".$this->colonne($col_convetion_feffi_soustitre + $colonne_soustitre).$ligne)->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_reliquat_des_fonds+1).$ligne, "Reliquat des fonds");
        }

        $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre+1).$ligne.":".$this->colonne($col_convetion_feffi_soustitre + $colonne_soustitre).$ligne)->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'bfcfb6')
        )
        ));
        
/*
        $objPHPExcel->getActiveSheet()->mergeCells("AC".$ligne.":AE".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AC".$ligne.":AE".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.$ligne, "SUIVI FINANCIER FEFFI -PRESTATAIRE");

        $objPHPExcel->getActiveSheet()->mergeCells("AF".$ligne.":AH".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AF".$ligne.":AH".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF'.$ligne, "SUIVI FINANCIER FEFFI FONCTIONNEMENT");*/

        //$objPHPExcel->getActiveSheet()->mergeCells("AG".$ligne);
       /* $objPHPExcel->getActiveSheet()->getStyle("AI".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI'.$ligne, "TOTAL CONVENTION DECAISSEE");

       // $objPHPExcel->getActiveSheet()->mergeCells("AH".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AJ".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ'.$ligne, "Reliquat des fonds");*/

       $colonne_soustitre = $colonne_soustitre + $col_convetion_feffi_soustitre;
        $col_partenaire_soustitre= 0;
        
        if ($params['partenaire_relais']=="true")
        {   

            if ($params['suivi_passation_marches_pr']=="true")
            { 
                $col_suivi_passation_marches_pr = $col_partenaire_soustitre + $colonne_soustitre;
               $col_partenaire_soustitre = $col_partenaire_soustitre + 9;

               $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_suivi_passation_marches_pr+1).$ligne.":".$this->colonne($col_partenaire_soustitre + $colonne_soustitre).$ligne);
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_suivi_passation_marches_pr+1).$ligne.":".$this->colonne($col_partenaire_soustitre + $colonne_soustitre).$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_suivi_passation_marches_pr+1).$ligne, "Suivi Passation des marchés PR");

                $col_banga_passation = $col_partenaire_soustitre + $colonne_soustitre;
                $col_partenaire_soustitre = $col_partenaire_soustitre + 2;
                $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_banga_passation+1).$ligne.":".$this->colonne($col_partenaire_soustitre + $colonne_soustitre).$ligne);
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_banga_passation+1).$ligne.":".$this->colonne($col_partenaire_soustitre + $colonne_soustitre).$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_banga_passation+1).$ligne, "");
            }

            if ($params['suivi_prestation_pr']=="true")
            { 
                $col_suivi_prestation_pr = $col_partenaire_soustitre + $colonne_soustitre;
               $col_partenaire_soustitre = $col_partenaire_soustitre + 72;

               $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_suivi_prestation_pr+1).$ligne.":".$this->colonne($col_partenaire_soustitre + $colonne_soustitre).$ligne);
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_suivi_prestation_pr+1).$ligne.":".$this->colonne($col_partenaire_soustitre + $colonne_soustitre).$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_suivi_prestation_pr+1).$ligne, "Suivi Prestation par PR");
            }

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre+1).$ligne.":".$this->colonne($col_partenaire_soustitre + $colonne_soustitre).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '99abcc')
            )
            ));
           
        }

       /*$objPHPExcel->getActiveSheet()->mergeCells("AK".$ligne.":AS".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AK".$ligne.":AS".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK'.$ligne, "Suivi Passation des marchés PR");*/

       /* $objPHPExcel->getActiveSheet()->mergeCells("AT".$ligne.":AU".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AT".$ligne.":AU".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AT'.$ligne, "");*/

       /* $objPHPExcel->getActiveSheet()->mergeCells("AV".$ligne.":DO".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("AV".$ligne.":DO".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AV'.$ligne, "Suivi Prestation par PR");*/
        $colonne_soustitre = $colonne_soustitre + $col_partenaire_soustitre;
        $col_maitrise_oeuvre_soustitre= 0;

        if ($params['maitrise_oeuvre']=="true")
        {   

            if ($params['suivi_passation_marches_moe']=="true")
            { 
               $col_maitrise_oeuvre_soustitre = $col_maitrise_oeuvre_soustitre + 18;
            }

            if ($params['suivi_prestation_moe']=="true")
            { 
               $col_maitrise_oeuvre_soustitre = $col_maitrise_oeuvre_soustitre + 10;
            }

            if ($params['suivi_paiement_moe']=="true")
            { 
               $col_maitrise_oeuvre_soustitre = $col_maitrise_oeuvre_soustitre + 2;
            }

            if ($params['police_assurance_moe']=="true")
            { 
               $col_maitrise_oeuvre_soustitre = $col_maitrise_oeuvre_soustitre + 1;
            }
           
        }

        $colonne_soustitre = $colonne_soustitre + $col_maitrise_oeuvre_soustitre;
        $col_entreprise_soustitre= 0;

        if ($params['entreprise']=="true")
        {
            if ($params['suivi_passation_marches_mpe']=="true")
            {
               $col_suivi_passation_marches_mpe = $col_entreprise_soustitre + $colonne_soustitre;
               $col_entreprise_soustitre = $col_entreprise_soustitre + 20;

               $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_suivi_passation_marches_mpe+1).$ligne.":".$this->colonne($col_entreprise_soustitre + $colonne_soustitre).$ligne);
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_suivi_passation_marches_mpe+1).$ligne.":".$this->colonne($col_entreprise_soustitre + $colonne_soustitre).$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_suivi_passation_marches_mpe+1).$ligne, "Passation des marchés");
            }

            if ($params['suivi_execution_travau_mpe']=="true")
            {
               $col_suivi_execution_travau_mpe = $col_entreprise_soustitre + $colonne_soustitre;
               $col_entreprise_soustitre = $col_entreprise_soustitre + 16;
               $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_suivi_execution_travau_mpe+1).$ligne.":".$this->colonne($col_entreprise_soustitre + $colonne_soustitre).$ligne);
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_suivi_execution_travau_mpe+1).$ligne.":".$this->colonne($col_entreprise_soustitre + $colonne_soustitre).$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_suivi_execution_travau_mpe+1).$ligne, "Suivi de l'exécution de chaque contrat des travaux");
            }

            if ($params['suivi_paiement_mpe']=="true")
            {
               $col_suivi_paiement_mpe = $col_entreprise_soustitre + $colonne_soustitre;
               $col_entreprise_soustitre = $col_entreprise_soustitre + 26;

               $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_suivi_paiement_mpe+1).$ligne.":".$this->colonne($col_entreprise_soustitre + $colonne_soustitre).$ligne);
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_suivi_paiement_mpe+1).$ligne.":".$this->colonne($col_entreprise_soustitre + $colonne_soustitre).$ligne)->applyFromArray($styleTitre);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_suivi_paiement_mpe+1).$ligne, "Suivi de paiement de chaque contrat des travaux");
            }

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre+1).$ligne.":".$this->colonne($col_entreprise_soustitre + $colonne_soustitre).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '5e99bd')
            )
            ));
            
        }

        

       /* $objPHPExcel->getActiveSheet()->mergeCells("FO".$ligne.":GD".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("FO".$ligne.":GD".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('FO'.$ligne, "Suivi de l'exécution de chaque contrat des travaux");
*/
 /*       $objPHPExcel->getActiveSheet()->mergeCells("GE".$ligne.":HB".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("GE".$ligne.":HB".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GE'.$ligne, "Suivi de paiement de chaque contrat des travaux");
*/

        $colonne_soustitre = $colonne_soustitre + $col_entreprise_soustitre;
        $col_transfert_reliquat_soustitre= 0;

        if ($params['transfert_reliquat']=="true")
        {
            $col_montant_transfert = $col_transfert_reliquat_soustitre + $colonne_soustitre;
            $col_transfert_reliquat_soustitre = $col_transfert_reliquat_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_montant_transfert+1).$ligne.":".$this->colonne($col_transfert_reliquat_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_montant_transfert+1).$ligne.":".$this->colonne($col_transfert_reliquat_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_montant_transfert+1).$ligne, "Montant du reliquat de fonds");

            $col_utilisation_reliquat = $col_transfert_reliquat_soustitre + $colonne_soustitre;
            $col_transfert_reliquat_soustitre = $col_transfert_reliquat_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_utilisation_reliquat+1).$ligne.":".$this->colonne($col_transfert_reliquat_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_utilisation_reliquat+1).$ligne.":".$this->colonne($col_transfert_reliquat_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_utilisation_reliquat+1).$ligne, "Montant du reliquat de fonds");

            $col_situation_reliquat = $col_transfert_reliquat_soustitre + $colonne_soustitre;
            $col_transfert_reliquat_soustitre = $col_transfert_reliquat_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_situation_reliquat+1).$ligne.":".$this->colonne($col_transfert_reliquat_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_situation_reliquat+1).$ligne.":".$this->colonne($col_transfert_reliquat_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_situation_reliquat+1).$ligne, "Montant du reliquat de fonds");

            $col_observation_reliquat = $col_transfert_reliquat_soustitre + $colonne_soustitre;
            $col_transfert_reliquat_soustitre = $col_transfert_reliquat_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_observation_reliquat+1).$ligne.":".$this->colonne($col_transfert_reliquat_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_observation_reliquat+1).$ligne.":".$this->colonne($col_transfert_reliquat_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_observation_reliquat+1).$ligne, "Montant du reliquat de fonds");


            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre+1).$ligne.":".$this->colonne($col_transfert_reliquat_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'b08df2')
            )
            ));
            
        }

      /* $objPHPExcel->getActiveSheet()->mergeCells("HC".$ligne.":HC".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HC".$ligne.":HC".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HC'.$ligne, "Montant du reliquat de fonds");*/

       /* $objPHPExcel->getActiveSheet()->mergeCells("HD".$ligne.":HD".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HD".$ligne.":HD".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HD'.$ligne, "Objet de l'utilisation du reliquat");*/

       /* $objPHPExcel->getActiveSheet()->mergeCells("HE".$ligne.":HE".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HE".$ligne.":HE".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HE'.$ligne, "Situation de l'utilisation du reliquat");*/

      /*  $objPHPExcel->getActiveSheet()->mergeCells("HF".$ligne.":HF".($ligne+2));
        $objPHPExcel->getActiveSheet()->getStyle("HF".$ligne.":HF".($ligne+2))->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HF'.$ligne, "OBSERVATIONS");*/

//INDICATEUR

        $colonne_soustitre = $colonne_soustitre + $col_transfert_reliquat_soustitre;
        $col_indicateur_soustitre= 0;

        if ($params['indicateur']=="true")
        {
            $col_prev_nbr_salle_titre = $col_indicateur_soustitre + $colonne_soustitre;
            $col_indicateur_soustitre = $col_indicateur_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_prev_nbr_salle_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_prev_nbr_salle_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_prev_nbr_salle_titre+1).$ligne, "Prevision nombre de salles de classe construites");

            $col_nbr_salle_const_indicateur_titre = $col_indicateur_soustitre + $colonne_soustitre;
            $col_indicateur_soustitre = $col_indicateur_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_nbr_salle_const_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_nbr_salle_const_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_nbr_salle_const_indicateur_titre+1).$ligne, "Nombre de salles de classe construites");

            $col_nprev_beneficiaire_titre = $col_indicateur_soustitre + $colonne_soustitre;
            $col_indicateur_soustitre = $col_indicateur_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_nprev_beneficiaire_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_nprev_beneficiaire_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_nprev_beneficiaire_titre+1).$ligne, "Prevision Bénéficiaires directs du programme deconstruction (nombre)");

            $col_nbr_beneficiaire_indicateur_titre = $col_indicateur_soustitre + $colonne_soustitre;
            $col_indicateur_soustitre = $col_indicateur_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_nbr_beneficiaire_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_nbr_beneficiaire_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_nbr_beneficiaire_indicateur_titre+1).$ligne, "Bénéficiaires directs du programme de construction (nombre)");

            $col_prev_nbr_ecole_titre = $col_indicateur_soustitre + $colonne_soustitre;
            $col_indicateur_soustitre = $col_indicateur_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_prev_nbr_ecole_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_prev_nbr_ecole_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_prev_nbr_ecole_titre+1).$ligne, "Prevision Nombre d'Ecoles construites");

            $col_nbr_ecole_indicateur_titre = $col_indicateur_soustitre + $colonne_soustitre;
            $col_indicateur_soustitre = $col_indicateur_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_nbr_ecole_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_nbr_ecole_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_nbr_ecole_indicateur_titre+1).$ligne, "Nombre d'Ecoles construites");

            $col_prev_nbr_box_latrine_titre = $col_indicateur_soustitre + $colonne_soustitre;
            $col_indicateur_soustitre = $col_indicateur_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_prev_nbr_box_latrine_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_prev_nbr_box_latrine_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_prev_nbr_box_latrine_titre+1).$ligne, "Prévision nombre de box de latrine");

            $col_nbr_box_indicateur_titre = $col_indicateur_soustitre + $colonne_soustitre;
            $col_indicateur_soustitre = $col_indicateur_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_nbr_box_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_nbr_box_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_nbr_box_indicateur_titre+1).$ligne, "Réalisation box de latrine");

            $col_prev_nbr_point_eau_titre = $col_indicateur_soustitre + $colonne_soustitre;
            $col_indicateur_soustitre = $col_indicateur_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_prev_nbr_point_eau_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_prev_nbr_point_eau_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_prev_nbr_point_eau_titre+1).$ligne, "Prevision Nombre de systèmes de point d'Eau installé");

            $col_nbr_point_eau_indicateur_titre = $col_indicateur_soustitre + $colonne_soustitre;
            $col_indicateur_soustitre = $col_indicateur_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_nbr_point_eau_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_nbr_point_eau_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_nbr_point_eau_indicateur_titre+1).$ligne, "Nombre de système de point d'eau  installé");

            $col_prev_nbr_table_banc_titre = $col_indicateur_soustitre + $colonne_soustitre;
            $col_indicateur_soustitre = $col_indicateur_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_prev_nbr_table_banc_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_prev_nbr_table_banc_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_prev_nbr_table_banc_titre+1).$ligne, "PREVISION NOMBRE TABLES BANC");

            $col_nbr_banc_indicateur_titre = $col_indicateur_soustitre + $colonne_soustitre;
            $col_indicateur_soustitre = $col_indicateur_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_nbr_banc_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_nbr_banc_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_nbr_banc_indicateur_titre+1).$ligne, "REALISATION NOMBRE TABLES BANC");

            $col_prev_nbr_table_maitre_titre = $col_indicateur_soustitre + $colonne_soustitre;
            $col_indicateur_soustitre = $col_indicateur_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_prev_nbr_table_maitre_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_prev_nbr_table_maitre_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_prev_nbr_table_maitre_titre+1).$ligne, "PREVISION NOMBRE TABLES DU MAITRE");

            $col_nbr_table_maitre_indicateur_titre = $col_indicateur_soustitre + $colonne_soustitre;
            $col_indicateur_soustitre = $col_indicateur_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_nbr_table_maitre_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_nbr_table_maitre_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_nbr_table_maitre_indicateur_titre+1).$ligne, "REALISATION NOMBRE TABLES DU MAITRE");

            $col_prev_nbr_chaise_maitre_titre = $col_indicateur_soustitre + $colonne_soustitre;
            $col_indicateur_soustitre = $col_indicateur_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_prev_nbr_chaise_maitre_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_prev_nbr_chaise_maitre_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_prev_nbr_chaise_maitre_titre+1).$ligne, "PREVISION NOMBRE CHAISE DU MAITRE");

            $col_nbr_chaise_indicateur_titre = $col_indicateur_soustitre + $colonne_soustitre;
            $col_indicateur_soustitre = $col_indicateur_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_nbr_chaise_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_nbr_chaise_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_nbr_chaise_indicateur_titre+1).$ligne, "REALISATION NOMBRE CHAISE DU MAITRE");

            $col_observation_indicateur_titre = $col_indicateur_soustitre + $colonne_soustitre;
            $col_indicateur_soustitre = $col_indicateur_soustitre + 1;

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($col_observation_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($col_observation_indicateur_titre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray($styleTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($col_observation_indicateur_titre+1).$ligne, "OBSERVATIONS SUR LES INDICATEURS");


            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre+1).$ligne.":".$this->colonne($col_indicateur_soustitre + $colonne_soustitre).($ligne+2))->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'fff2cc')
            )
            ));
            
        }

       /*$objPHPExcel->getActiveSheet()->mergeCells("HG".$ligne.":HG".($ligne+2));
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
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('HW'.$ligne, "OBSERVATIONS SUR LES INDICATEURS");*/

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
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, "CODE ETABLISSEMENT");

        $objPHPExcel->getActiveSheet()->mergeCells("D".$ligne.":D".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("D".$ligne.":D".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "CODE CONVENTION");

        $objPHPExcel->getActiveSheet()->mergeCells("E".$ligne.":E".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("E".$ligne.":E".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "VILLAGE");

        $objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":F".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("F".$ligne.":F".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "FOKONTANY");

        $objPHPExcel->getActiveSheet()->mergeCells("G".$ligne.":G".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("G".$ligne.":G".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "COMMUNE");

        $objPHPExcel->getActiveSheet()->mergeCells("H".$ligne.":H".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("H".$ligne.":H".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "CISCO");

        $objPHPExcel->getActiveSheet()->mergeCells("I".$ligne.":I".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("I".$ligne.":I".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, "REGION");


        //$objPHPExcel->getActiveSheet()->mergeCells("F".$ligne.":F".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("F".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, "TYPE DE CONVENTION");

        $objPHPExcel->getActiveSheet()->mergeCells("K".$ligne.":K".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("K".$ligne.":K".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, "NOM FEFFI");

        $objPHPExcel->getActiveSheet()->mergeCells("L".$ligne.":L".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("L".$ligne.":L".($ligne+1))->applyFromArray($stylesousTitre);
        $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, "Date de signature convention CISCO FEFFI");

        $objPHPExcel->getActiveSheet()->mergeCells("M".$ligne.":M".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("M".$ligne.":M".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, "Bâtiment");

        $objPHPExcel->getActiveSheet()->mergeCells("N".$ligne.":N".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("N".$ligne.":N".($ligne+1))->applyFromArray($stylesousTitre);
       // $objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, "Latrine");

        $objPHPExcel->getActiveSheet()->mergeCells("O".$ligne.":O".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("O".$ligne.":O".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$ligne, "Mobilier scolaire");

        $objPHPExcel->getActiveSheet()->mergeCells("P".$ligne.":P".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("P".$ligne.":P".($ligne+1))->applyFromArray($stylesousTitre);
       // $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$ligne, "Maitrise d'œuvre");

        $objPHPExcel->getActiveSheet()->mergeCells("Q".$ligne.":Q".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("Q".$ligne.":Q".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("M".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$ligne, "Sous total Dépenses TAVAUX");

        $objPHPExcel->getActiveSheet()->mergeCells("R".$ligne.":R".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("R".$ligne.":R".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("N".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$ligne, "Frais de fonctionnement FEFFI");

        $objPHPExcel->getActiveSheet()->mergeCells("S".$ligne.":S".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("S".$ligne.":S".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("O".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$ligne, "Montant convention");

        $objPHPExcel->getActiveSheet()->mergeCells("T".$ligne.":T".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("T".$ligne.":T".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("T".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$ligne, "AVENANT A LA CONVENTION");

        $objPHPExcel->getActiveSheet()->mergeCells("U".$ligne.":U".($ligne+1));
        $objPHPExcel->getActiveSheet()->getStyle("U".$ligne.":U".($ligne+1))->applyFromArray($stylesousTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("Q".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$ligne, "MONTANT CONVENTION APRES AVENANT");

        $objPHPExcel->getActiveSheet()->getStyle("K".($ligne).":U".($ligne+1))->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'e2efda')
            )
            ));

        $colonne_soustitre2 = 85;

        if ($params['suivi_financier_daaf_feffi']=="true")
        {

            //$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(TRUE);
            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+1).$ligne, "Montant 1ère tranche");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+2).$ligne.":".$this->colonne($colonne_soustitre2+2).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+2).$ligne.":".$this->colonne($colonne_soustitre2+2).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+2).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+2).$ligne, "Date d'approbation 1ère tranche");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+3).$ligne.":".$this->colonne($colonne_soustitre2+3).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+3).$ligne.":".$this->colonne($colonne_soustitre2+3).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+3).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+3).$ligne, "Montant 2ème tranche");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+4).$ligne.":".$this->colonne($colonne_soustitre2+4).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+4).$ligne.":".$this->colonne($colonne_soustitre2+4).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+4).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+4).$ligne, "Date d'approbation 2ème tranche");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+5).$ligne.":".$this->colonne($colonne_soustitre2+5).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+5).$ligne.":".$this->colonne($colonne_soustitre2+5).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+5).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+5).$ligne, "Montant 3ème tranche");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+6).$ligne.":".$this->colonne($colonne_soustitre2+6).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+6).$ligne.":".$this->colonne($colonne_soustitre2+6).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+6).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+6).$ligne, "Date d'approbation 3ème tranche");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+7).$ligne.":".$this->colonne($colonne_soustitre2+7).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+7).$ligne.":".$this->colonne($colonne_soustitre2+7).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+7).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+7).$ligne, "Montant 4ème tranche");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+8).$ligne.":".$this->colonne($colonne_soustitre2+8).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+8).$ligne.":".$this->colonne($colonne_soustitre2+8).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+8).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+8).$ligne, "Date d'approbation 4ème tranche");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+9).$ligne.":".$this->colonne($colonne_soustitre2+9).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+9).$ligne.":".$this->colonne($colonne_soustitre2+9).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+9).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+9).$ligne, "Total");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+10).$ligne.":".$this->colonne($colonne_soustitre2+10).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+10).$ligne.":".$this->colonne($colonne_soustitre2+10).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+10).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+10).$ligne, "% décaissement");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+11).$ligne.":".$this->colonne($colonne_soustitre2+11).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+11).$ligne.":".$this->colonne($colonne_soustitre2+11).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+11).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+11).$ligne, "OBSERVATIONS");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+11).($ligne+1))->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'e2efda')
            )
            ));

            $colonne_soustitre2 = $colonne_soustitre2 +11;
        }
//SUIVI FINANCIER FEFFI -PRESTATAIRE

        if ($params['suivi_financier_feffi_prestataire']=="true")
        {
            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+1).$ligne, "Montant décaissé");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+2).$ligne.":".$this->colonne($colonne_soustitre2+2).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+2).$ligne.":".$this->colonne($colonne_soustitre2+2).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+2).$ligne, "% décaissement");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+3).$ligne.":".$this->colonne($colonne_soustitre2+3).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+3).$ligne.":".$this->colonne($colonne_soustitre2+3).($ligne+1))->applyFromArray($stylesousTitre);
           // $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+3).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+3).$ligne, "OBSERVATIONS");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+3).($ligne+1))->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'e2efda')
            )
            ));
            
            $colonne_soustitre2 = $colonne_soustitre2 + 3;
        }

//SUIVI FINANCIER FEFFI FONCTIONNEMENT

        if ($params['suivi_financier_feffi_fonctionnement']=="true")
        {
           $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("AD".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+1).$ligne, "Montant décaissé");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+2).$ligne.":".$this->colonne($colonne_soustitre2+2).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+2).$ligne.":".$this->colonne($colonne_soustitre2+2).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("AE".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+2).$ligne, "% décaissement");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+3).$ligne.":".$this->colonne($colonne_soustitre2+3).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+3).$ligne.":".$this->colonne($colonne_soustitre2+3).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("AF".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+3).$ligne, "OBSERVATIONS");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+3).($ligne+1))->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'e2efda')
            )
            ));

            $colonne_soustitre2 = $colonne_soustitre2 + 3;
        }

        if ($params['total_convention_decaissee']=="true")
        {

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("AG".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+1).$ligne, "MONTANT");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1))->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'e2efda')
            )
            ));

            $colonne_soustitre2 = $colonne_soustitre2 + 1;
        }
        if ($params['reliquat_des_fonds']=="true")
        {
            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("AH".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+1).$ligne, "MONTANT");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1))->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'e2efda')
            )
            ));

            $colonne_soustitre2 = $colonne_soustitre2 + 1;
        }

        if ($params['suivi_passation_marches_pr']=="true")
        {
            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+1).$ligne, "Appel manifestation");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+2).$ligne.":".$this->colonne($colonne_soustitre2+2).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+2).$ligne.":".$this->colonne($colonne_soustitre2+2).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+2).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+2).$ligne, "Lancement D.P.");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+3).$ligne.":".$this->colonne($colonne_soustitre2+3).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+3).$ligne.":".$this->colonne($colonne_soustitre2+3).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+3).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+3).$ligne, "Remise proposition");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+4).$ligne.":".$this->colonne($colonne_soustitre2+4).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+4).$ligne.":".$this->colonne($colonne_soustitre2+4).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("AL".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+4).$ligne, "Nbre plis reçu");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+5).$ligne.":".$this->colonne($colonne_soustitre2+5).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+5).$ligne.":".$this->colonne($colonne_soustitre2+5).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("AM".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+5).$ligne, "Date O.S. commencement");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+6).$ligne.":".$this->colonne($colonne_soustitre2+6).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+6).$ligne.":".$this->colonne($colonne_soustitre2+6).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("AN".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+6).$ligne, "Nom du Consultant");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+7).$ligne.":".$this->colonne($colonne_soustitre2+7).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+7).$ligne.":".$this->colonne($colonne_soustitre2+7).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("AO".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+7).$ligne, "Montant contrat");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+8).$ligne.":".$this->colonne($colonne_soustitre2+8).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+8).$ligne.":".$this->colonne($colonne_soustitre2+8).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("AP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+8).$ligne, "Cumul paiement");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+9).$ligne.":".$this->colonne($colonne_soustitre2+9).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+9).$ligne.":".$this->colonne($colonne_soustitre2+9).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("AQ".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+9).$ligne, "% paiement");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+10).$ligne.":".$this->colonne($colonne_soustitre2+10).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+10).$ligne.":".$this->colonne($colonne_soustitre2+10).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("AR".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+10).$ligne, "Avenant contrat PR");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+11).$ligne.":".$this->colonne($colonne_soustitre2+11).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+11).$ligne.":".$this->colonne($colonne_soustitre2+11).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("AS".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+11).$ligne, "Montant contrat après avenant");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+11).($ligne+1))->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'b4c6e7')
            )
            ));

            $colonne_soustitre2 = $colonne_soustitre2 + 11;
        }

        if ($params['suivi_prestation_pr']=="true")
        {

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+12).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+12).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("AT".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+1).$ligne, "MODULE DPP");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+13).$ligne.":".$this->colonne($colonne_soustitre2+24).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+13).$ligne.":".$this->colonne($colonne_soustitre2+24).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("BF".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+13).$ligne, "MODULE ODC");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+25).$ligne.":".$this->colonne($colonne_soustitre2+36).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+25).$ligne.":".$this->colonne($colonne_soustitre2+36).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("BR".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+25).$ligne, "MODULE PMC");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+37).$ligne.":".$this->colonne($colonne_soustitre2+48).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+37).$ligne.":".$this->colonne($colonne_soustitre2+48).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("CD".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+37).$ligne, "MODULE GFPC");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+49).$ligne.":".$this->colonne($colonne_soustitre2+60).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+49).$ligne.":".$this->colonne($colonne_soustitre2+60).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("CP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+49).$ligne, "MODULE SEP");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+61).$ligne.":".$this->colonne($colonne_soustitre2+72).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+61).$ligne.":".$this->colonne($colonne_soustitre2+72).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("DB".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+61).$ligne, "MODULE EMIES");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+72).($ligne+1))->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'b4c6e7')
            )
            ));

            $colonne_soustitre2 = $colonne_soustitre2 + 72;
        }

        if ($params['suivi_passation_marches_moe']=="true")
        {

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+18).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+18).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("DN".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+1).$ligne, "Passation des marchés BE");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+18).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'fa8f48')
            )
            ));

            $colonne_soustitre2 = $colonne_soustitre2 + 18;
        }

        if ($params['suivi_prestation_moe']=="true")
        {

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+10).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+10).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EF".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+1).$ligne, "Suivi préstation BE");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+10).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'fa8f48')
            )
            ));

            $colonne_soustitre2 = $colonne_soustitre2 + 10;

        }

        if ($params['suivi_paiement_moe']=="true")
        {

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+2).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+2).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+1).$ligne, "Suivi paiement");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+2).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'fa8f48')
            )
            ));

            $colonne_soustitre2 = $colonne_soustitre2 + 2;

        }

        if ($params['police_assurance_moe']=="true")
        {

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+1).$ligne, "DATE D'EXPIRATION POLICE D'ASSURANCE BE");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'fa8f48')
            )
            ));

            $colonne_soustitre2 = $colonne_soustitre2 + 1;

        }

        if ($params['suivi_passation_marches_mpe']=="true")
        {

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+1).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+1).$ligne, "Date lancement de l'Appel d'Offres de travaux");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+2).$ligne.":".$this->colonne($colonne_soustitre2+2).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+2).$ligne.":".$this->colonne($colonne_soustitre2+2).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+2).$ligne, "Date remise des Offres");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+3).$ligne.":".$this->colonne($colonne_soustitre2+3).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+3).$ligne.":".$this->colonne($colonne_soustitre2+3).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+3).$ligne, "Nombre offres recues");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+4).$ligne.":".$this->colonne($colonne_soustitre2+4).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+4).$ligne.":".$this->colonne($colonne_soustitre2+4).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+4).$ligne, "MPE soumissionaires (liste)");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+5).$ligne.":".$this->colonne($colonne_soustitre2+5).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+5).$ligne.":".$this->colonne($colonne_soustitre2+5).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+5).$ligne, "Montant TTC offre moins chere");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+6).$ligne.":".$this->colonne($colonne_soustitre2+6).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+6).$ligne.":".$this->colonne($colonne_soustitre2+6).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+6).$ligne, "Datte rapport d'évaluation");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+7).$ligne.":".$this->colonne($colonne_soustitre2+7).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+7).$ligne.":".$this->colonne($colonne_soustitre2+7).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+7).$ligne, "Demande ANO DPFI");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+8).$ligne.":".$this->colonne($colonne_soustitre2+8).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+8).$ligne.":".$this->colonne($colonne_soustitre2+8).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+8).$ligne, "ANO DPFI");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+9).$ligne.":".$this->colonne($colonne_soustitre2+9).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+9).$ligne.":".$this->colonne($colonne_soustitre2+9).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+9).$ligne, "Notification d'intention");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+10).$ligne.":".$this->colonne($colonne_soustitre2+10).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+10).$ligne.":".$this->colonne($colonne_soustitre2+10).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+10).$ligne, "Date notification d'attribution");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+11).$ligne.":".$this->colonne($colonne_soustitre2+11).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+11).$ligne.":".$this->colonne($colonne_soustitre2+11).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+11).$ligne, "Date signature contrat de travaux");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+12).$ligne.":".$this->colonne($colonne_soustitre2+12).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+12).$ligne.":".$this->colonne($colonne_soustitre2+12).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+12).$ligne, "Date OS");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+13).$ligne.":".$this->colonne($colonne_soustitre2+13).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+13).$ligne.":".$this->colonne($colonne_soustitre2+13).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+13).$ligne, "Titulaire des travaux");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+14).$ligne.":".$this->colonne($colonne_soustitre2+14).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+14).$ligne.":".$this->colonne($colonne_soustitre2+14).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+14).$ligne, "OBSERVATIONS");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+15).$ligne.":".$this->colonne($colonne_soustitre2+20).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+15).$ligne.":".$this->colonne($colonne_soustitre2+20).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+15).$ligne, "Montant contrat");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+20).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '97c8e6')
            )
            ));

            $colonne_soustitre2 = $colonne_soustitre2 + 20;

        }



        if ($params['suivi_execution_travau_mpe']=="true")
        {

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+4).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+4).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+1).$ligne, " ");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+5).$ligne.":".$this->colonne($colonne_soustitre2+15).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+5).$ligne.":".$this->colonne($colonne_soustitre2+15).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+5).$ligne, "Réception");
    //eto
            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+16).$ligne.":".$this->colonne($colonne_soustitre2+16).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+16).$ligne.":".$this->colonne($colonne_soustitre2+16).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+16).$ligne, "SUIVI DATE D'EXPIRATION POLICE D'ASSURANCE MPE");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+16).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '97c8e6')
            )
            ));

            $colonne_soustitre2 = $colonne_soustitre2 + 16;

        }

        if ($params['suivi_paiement_mpe']=="true")
        {

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+2).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+2).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+1).$ligne, "Avance démarrage");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+3).$ligne.":".$this->colonne($colonne_soustitre2+4).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+3).$ligne.":".$this->colonne($colonne_soustitre2+4).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+3).$ligne, "Premier paiement");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+5).$ligne.":".$this->colonne($colonne_soustitre2+6).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+5).$ligne.":".$this->colonne($colonne_soustitre2+6).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+5).$ligne, "Deuxième paiement");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+7).$ligne.":".$this->colonne($colonne_soustitre2+8).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+7).$ligne.":".$this->colonne($colonne_soustitre2+8).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+7).$ligne, "Troisième paiement");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+9).$ligne.":".$this->colonne($colonne_soustitre2+10).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+9).$ligne.":".$this->colonne($colonne_soustitre2+10).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+9).$ligne, "Quatrième paiement");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+11).$ligne.":".$this->colonne($colonne_soustitre2+12).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+11).$ligne.":".$this->colonne($colonne_soustitre2+12).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+11).$ligne, "Cinquième paiement");


           /* $objPHPExcel->getActiveSheet()->mergeCells("GO".$ligne.":GQ".$ligne);
            $objPHPExcel->getActiveSheet()->getStyle("GO".$ligne.":GQ".$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GO".$ligne, "Taux d'avancement financier (%)");*/

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+13).$ligne.":".$this->colonne($colonne_soustitre2+14).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+13).$ligne.":".$this->colonne($colonne_soustitre2+14).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+13).$ligne, "Sixième paiement");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+15).$ligne.":".$this->colonne($colonne_soustitre2+16).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+15).$ligne.":".$this->colonne($colonne_soustitre2+16).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+15).$ligne, "Septième paiement");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+17).$ligne.":".$this->colonne($colonne_soustitre2+18).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+17).$ligne.":".$this->colonne($colonne_soustitre2+18).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+17).$ligne, "Huitème paiement");

           /* $objPHPExcel->getActiveSheet()->mergeCells("GX".$ligne.":GZ".$ligne);
            $objPHPExcel->getActiveSheet()->getStyle("GX".$ligne.":GZ".$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GX".$ligne, "Taux d'avancement financier (%)");*/

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+19).$ligne.":".$this->colonne($colonne_soustitre2+20).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+19).$ligne.":".$this->colonne($colonne_soustitre2+20).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+19).$ligne, "Neuvième paiement");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+21).$ligne.":".$this->colonne($colonne_soustitre2+22).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+21).$ligne.":".$this->colonne($colonne_soustitre2+22).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+21).$ligne, "Dixième paiement");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+23).$ligne.":".$this->colonne($colonne_soustitre2+25).$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+23).$ligne.":".$this->colonne($colonne_soustitre2+25).$ligne)->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+23).$ligne, "Taux d'avancement financier (%)");

            $objPHPExcel->getActiveSheet()->mergeCells($this->colonne($colonne_soustitre2+26).$ligne.":".$this->colonne($colonne_soustitre2+26).($ligne+1));
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+26).$ligne.":".$this->colonne($colonne_soustitre2+26).($ligne+1))->applyFromArray($stylesousTitre);
            //$objPHPExcel->getActiveSheet()->getStyle("EP".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre2+26).$ligne, "Observation");



            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre2+1).$ligne.":".$this->colonne($colonne_soustitre2+26).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '97c8e6')
            )
            ));

            $colonne_soustitre2 = $colonne_soustitre2 + 24;

        }

        $ligne++;
        //$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(FALSE);

        $objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->applyFromArray($stylesousTitre);
       $objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, "Zone Côtière:C01/C02/C03/ ou Zone Hauts plateaux Rurale HPR1/HPR2/HPR3/ ou Zone Hauts plateaux Urbaine:HPU1/HPU2/HPU3");

        $colonne_soustitre3 = 85;

        if ($params['suivi_financier_daaf_feffi']=="true")
        {
            $colonne_soustitre3 = $colonne_soustitre3 +11;
        }
//SUIVI FINANCIER FEFFI -PRESTATAIRE

        if ($params['suivi_financier_feffi_prestataire']=="true")
        {            
            $colonne_soustitre3 = $colonne_soustitre3 + 3;
        }

//SUIVI FINANCIER FEFFI FONCTIONNEMENT

        if ($params['suivi_financier_feffi_fonctionnement']=="true")
        {
            $colonne_soustitre3 = $colonne_soustitre3 + 3;
        }

        if ($params['total_convention_decaissee']=="true")
        {
            $colonne_soustitre3 = $colonne_soustitre3 + 1;
        }
        if ($params['reliquat_des_fonds']=="true")
        {
            $colonne_soustitre3 = $colonne_soustitre3 + 1;
        }

        if ($params['suivi_passation_marches_pr']=="true")
        {
            $colonne_soustitre3 = $colonne_soustitre3 + 11;
        }

        if ($params['suivi_prestation_pr']=="true")
        {
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+1).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+1).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+1).$ligne, "Date début prévisionnelle de la formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+2).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+2).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+2).$ligne, "Date fin prévisionnelle formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+3).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+3).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+3).$ligne, "Date prévisionnelle de la restitution");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+4).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+4).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+4).$ligne, "Date début réelle de la formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+5).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+5).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+5).$ligne, "Date fin réelle de la formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+6).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+6).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+6).$ligne, "Date réelle de restitution");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+7).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+7).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+7).$ligne, "Nombre prévisionnel participant");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+8).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+8).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+8).$ligne, "Nombre de participant");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+9).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+9).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+9).$ligne, "Nombre prévisionnel de femme participant");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+10).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+10).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+10).$ligne, "Nombre réel de femme  participant");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+11).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+11).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+11).$ligne, "Lieu de formation");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+12).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+12).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+12).$ligne, "observations");


            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+13).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+13).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+13).$ligne, "Date début prévisionnelle de la formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+14).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+14).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+14).$ligne, "Date fin prévisionnelle formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+15).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+15).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+15).$ligne, "Date prévisionnelle de la restitution");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+16).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+16).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+16).$ligne, "Date début réelle de la formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+17).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+17).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+17).$ligne, "Date fin réelle de la formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+18).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+18).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+18).$ligne, "Date réelle de restitution");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+19).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+19).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+19).$ligne, "Nombre prévisionnel   participant");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+20).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+20).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+20).$ligne, "Nombre de participant");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+21).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+21).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+21).$ligne, "Nombre prévisionnel de femme  participant");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+22).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+22).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+22).$ligne, "Nombre réel de femme  participant ");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+23).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+23).$ligne, "Lieu de formation");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+24).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+24).$ligne, "observations");


            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+25).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+25).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+25).$ligne, "Date début prévisionnelle de la formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+26).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+26).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+26).$ligne, "Date fin prévisionnelle formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+27).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+27).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+27).$ligne, "Date prévisionnelle de la restitution");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+28).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+28).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+28).$ligne, "Date début réelle de la formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+29).$ligne)->applyFromArray($stylesousTitre);
           $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+29).$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+29).$ligne, "Date fin réelle de la formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+30).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+30).$ligne, "Date réelle de restitution");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+31).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+31).$ligne, "Nombre prévisionnel   participant");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+32).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+32).$ligne, "Nombre de participant");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+33).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+33).$ligne, "Nombre prévisionnel de femme participant");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+34).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+34).$ligne, "Nombre réel de femme  participant");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+35).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+35).$ligne, "Lieu de formation");


            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+36).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+36).$ligne, "observations");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+37).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+37).$ligne, "Date début prévisionnelle de la formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+38).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+38).$ligne, "Date fin prévisionnelle formation");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+39).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+39).$ligne, "Date prévisionnelle de la restitution");


            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+40).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+40).$ligne, "Date début réelle de la formation");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+41).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+41).$ligne, "Date fin réelle de la formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+42).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+42).$ligne, "Date réelle de restitution");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+43).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+43).$ligne, "Nombre prévisionnel   participant");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+44).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+44).$ligne, "Nombre de participant");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+45).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+45).$ligne, "Nombre prévisionnel de femme  participant");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+46).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+46).$ligne, "Nombre réel de femme  participant");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+47).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+47).$ligne, "Lieu de formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+48).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+48).$ligne, "observations");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+49).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+49).$ligne, "Date début prévisionnelle de la formation");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+50).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+50).$ligne, "Date fin prévisionnelle formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+51).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+51).$ligne, "Date prévisionnelle de la restitution");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+52).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+52).$ligne, "Date début réelle de la formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+53).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+53).$ligne, "Date fin réelle de la formation");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+54).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+54).$ligne, "Date réelle de restitution");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+55).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+55).$ligne, "Nombre prévisionnel   participant");


            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+56).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+56).$ligne, "Nombre de participant");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+57).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+57).$ligne, "Nombre prévisionnel de femme  participant ");


            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+58).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+58).$ligne, "Nombre réel de femme  participant");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+59).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+59).$ligne, "Lieu de formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+60).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+60).$ligne, "observations");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+61).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+61).$ligne, "Date début prévisionnelle de la formation");


            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+62).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+62).$ligne, "Date fin prévisionnelle formation");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+63).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+63).$ligne, "Date prévisionnelle de la restitution");


            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+64).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+64).$ligne, "Date début réelle de la formation");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+65).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+65).$ligne, "Date fin réelle de la formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+66).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+66).$ligne, "Date réelle de restitution");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+67).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+67).$ligne, "Nombre prévisionnel   participant");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+68).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+68).$ligne, "Nombre de participant");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+69).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+69).$ligne, "Nombre prévisionnel de femme  participant");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+70).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+70).$ligne, "Nombre réel de femme  participant ");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+71).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+71).$ligne, "Lieu de formation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+72).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+72).$ligne, "observations");

            $colonne_soustitre3 = $colonne_soustitre3 + 72;


        }

        if ($params['suivi_passation_marches_moe']=="true")
        {

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+1).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+1).$ligne, "Date établissement shortlist");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+2).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+2).$ligne, "Appel à manifestation d'interêt");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+3).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+3).$ligne, "Lancement D.P.");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+4).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+4).$ligne, "Remise proposition");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+5).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+5).$ligne, "Nbre plis reçu");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+6).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+6).$ligne, "Date du rapport d'évaluation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+7).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+7).$ligne, "Date demande ANO DPFI");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+8).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+8).$ligne, "DANO DPFI");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+9).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+9).$ligne, "Notification d'intention");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+10).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+10).$ligne, "Notification d'attribution");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+11).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+11).$ligne, "Date signature de contrat");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+12).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+12).$ligne, "Date O.S. commencement");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+13).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+13).$ligne, "Raison sociale ou nom Consultant");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+14).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+14).$ligne, "Statut (BE/CI)");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+15).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+15).$ligne, "Montant contrat ");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+16).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+16).$ligne, "Avenant");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+17).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+17).$ligne, "Montant après avenant");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+18).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+18).$ligne, "Observations");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+1).$ligne.":".$this->colonne($colonne_soustitre3+18).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'faa770')
            )
            ));

            $colonne_soustitre3 = $colonne_soustitre3 + 18;

        }
        

        if ($params['suivi_prestation_moe']=="true")
        {

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+1).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+1).$ligne, "Livraison Mémoire technique (MT)");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+2).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+2).$ligne, "Date d'approbation MT par FEFFI");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+3).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+3).$ligne, "Date livraison DAO");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+4).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+4).$ligne, "Date d'approbation DAO par FEFFI");
            
            
           // $objPHPExcel->getActiveSheet()->mergeCells("EL".$ligne.":EM".$ligne);
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+5).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+5).$ligne, "Livraison Rapport mensuel 01 ");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+6).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+6).$ligne, "Livraison Rapport mensuel 02 ");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+7).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+7).$ligne, "Livraison Rapport mensuel 03 ");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+8).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+8).$ligne, "Livraison Rapport mensuel 04 ");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+9).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+9).$ligne, "Livraison manuel de gestion et d'entretien");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+10).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+10).$ligne, "Observations");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+1).$ligne.":".$this->colonne($colonne_soustitre3+10).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'faa770')
            )
            ));

            $colonne_soustitre3 = $colonne_soustitre3 + 10;

        }


        if ($params['suivi_paiement_moe']=="true")
        {
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+1).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+1).$ligne, "Cumul Paiement effectué");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+2).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+2).$ligne, "% paiement");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+1).$ligne.":".$this->colonne($colonne_soustitre3+2).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'faa770')
            )
            ));

            $colonne_soustitre3 = $colonne_soustitre3 + 2;
        }


        if ($params['police_assurance_moe']=="true")
        {

            $colonne_soustitre3 = $colonne_soustitre3 + 1;
        }



        if ($params['suivi_passation_marches_mpe']=="true")
        {   
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+15).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+15).$ligne, "bloc  de 2 sdc");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+16).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+16).$ligne, " latrines");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+17).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+17).$ligne, "Mobiliers");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+18).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+18).$ligne, "Montant total");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+19).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+19).$ligne, "Avenant");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+20).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+20).$ligne, "Montant après avenant");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+1).$ligne.":".$this->colonne($colonne_soustitre3+20).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '97c8e6')
            )
            ));

            $colonne_soustitre3 = $colonne_soustitre3 + 20;
        }
       /* if ($params['suivi']=="true")
        {
            $colonne_soustitre3 = $colonne_soustitre3 + 1;
        }*/
        
        if ($params['suivi_execution_travau_mpe']=="true")
        {

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+1).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+1).$ligne, "Phase du sous-projet");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+2).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+2).$ligne, "Date prévisionnelle début travaux");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+3).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+3).$ligne, "Date réelle début travaux");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+4).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+4).$ligne, "Délai d'exécution (jours)");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+5).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+5).$ligne, "Date prévisionnelle réception technique");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+6).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+6).$ligne, "Date réeelle  réception technique");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+7).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+7).$ligne, "Date levée des réserves de la réception technique");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+8).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+8).$ligne, "Date ptévisionnelle reception provisoire");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+9).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+9).$ligne, "Date réelle reception provisoire");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+10).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+10).$ligne, "Date prévisionnelle de levee des reserves avant RD");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+11).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+11).$ligne, "Date réelle de levee des reserves avant RD");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+12).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+12).$ligne, "Dateprévisionnelle  reception définitive");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+13).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+13).$ligne, "Date réelle  reception définitive");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+14).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+14).$ligne, "Avancement physique");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+15).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+15).$ligne, "OBSERVATIONS");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+1).$ligne.":".$this->colonne($colonne_soustitre3+15).$ligne)->applyFromArray(array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '97c8e6')
            )
            ));

            $colonne_soustitre3 = $colonne_soustitre3 + 16;
        }

        if ($params['suivi_paiement_mpe']=="true")
        {


            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+1).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+1).$ligne, "Date d'approbation");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+2).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+2).$ligne, "montant en Ar");


            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+3).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+3).$ligne, "Date d'approbation");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+4).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+4).$ligne, "montant en Ar");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+5).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+5).$ligne, "Date d'approbation");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+6).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+6).$ligne, "montant en Ar");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+7).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+7).$ligne, "Date d'approbation");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+8).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+8).$ligne, "montant en Ar");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+9).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+9).$ligne, "Date d'approbation");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+10).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+10).$ligne, "montant en Ar");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+11).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+11).$ligne, "Date d'approbation");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+12).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+12).$ligne, "montant en Ar");

            /*$objPHPExcel->getActiveSheet()->getStyle("GO".$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GO'.$ligne, "Anterieur");
            
            $objPHPExcel->getActiveSheet()->getStyle("GP".$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GP'.$ligne, "Période");

            $objPHPExcel->getActiveSheet()->getStyle("GQ".$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GQ'.$ligne, "Cumulé");*/
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+13).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+13).$ligne, "Date d'approbation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+14).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+14).$ligne, "montant en Ar");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+15).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+15).$ligne, "Date d'approbation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+16).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+16).$ligne, "montant en Ar");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+17).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+17).$ligne, "Date d'approbation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+18).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+18).$ligne, "montant en Ar");
            
           /* $objPHPExcel->getActiveSheet()->getStyle("GX".$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GX'.$ligne, "Anterieur");

            $objPHPExcel->getActiveSheet()->getStyle("GY".$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GY'.$ligne, "Période");

            $objPHPExcel->getActiveSheet()->getStyle("GZ".$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('GZ'.$ligne, "Cumulé");*/
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+19).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+19).$ligne, "Date d'approbation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+20).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+20).$ligne, "montant en Ar");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+21).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+21).$ligne, "Date d'approbation");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+22).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+22).$ligne, "montant en Ar");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+23).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+23).$ligne, "Anterieur");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+24).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+24).$ligne, "Période");
            
            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+25).$ligne)->applyFromArray($stylesousTitre);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_soustitre3+25).$ligne, "Cumulé");

            $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_soustitre3+1).$ligne.":".$this->colonne($colonne_soustitre3+25).$ligne)->applyFromArray(array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '97c8e6')
                )
                ));

            $colonne_soustitre3 = $colonne_soustitre3 + 25;
        }
        
        //$objPHPExcel->getActiveSheet()->getStyle("GZ".$ligne)->applyFromArray($stylesousTitre);
        //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('GZ'.$ligne, "% decaissement");

        $ligne++;
        
        foreach ($data as $key => $value)
        {  
            $periode_batiment_avance_phy =0;
            $periode_latrine_avance_phy =0;
            $periode_mobilier_avance_phy =0;
            $anterieur_batiment_avance_phy =0;
            $anterieur_latrine_avance_phy =0;
            $anterieur_mobilier_avance_phy =0;

//donnee globale             
            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->nom_agence);
            $objPHPExcel->getActiveSheet()->getStyle("B".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, $value->nom_ecole);
            $objPHPExcel->getActiveSheet()->getStyle("C".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, $value->code_ecole);
            $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->ref_convention);
            $objPHPExcel->getActiveSheet()->getStyle("E".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $value->village);
            $objPHPExcel->getActiveSheet()->getStyle("F".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $value->nom_fokontany);
            $objPHPExcel->getActiveSheet()->getStyle("G".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->nom_commune);
            $objPHPExcel->getActiveSheet()->getStyle("H".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $value->nom_cisco);
            $objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $value->nom_region);
            $objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, $value->libelle_zone.$value->libelle_acces);

//estimation convention

            $objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("G".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K".$ligne, $value->nom_feffi);

            $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("H".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("L".$ligne, $value->date_signature_convention);

            $objPHPExcel->getActiveSheet()->getStyle("M".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("M".$ligne, $value->cout_batiment);

            $objPHPExcel->getActiveSheet()->getStyle("N".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("N".$ligne, $value->cout_latrine);

             $objPHPExcel->getActiveSheet()->getStyle("O".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("O".$ligne, $value->cout_mobilier);

            $objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("P".$ligne, $value->cout_maitrise);

            $objPHPExcel->getActiveSheet()->getStyle("Q".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("M".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Q".$ligne, $value->soustotaldepense);

            $objPHPExcel->getActiveSheet()->getStyle("R".$ligne)->applyFromArray($stylecontenu);
           // $objPHPExcel->getActiveSheet()->getStyle("R".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("R".$ligne, $value->cout_sousprojet);

            $objPHPExcel->getActiveSheet()->getStyle("S".$ligne)->applyFromArray($stylecontenu);
           //$objPHPExcel->getActiveSheet()->getStyle("S".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("S".$ligne, $value->montant_convention);

            $objPHPExcel->getActiveSheet()->getStyle("T".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("T".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("T".$ligne, $value->cout_avenant);

            $objPHPExcel->getActiveSheet()->getColumnDimension("U")->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle("U".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("U".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("U".$ligne, $value->montant_convention + $value->cout_avenant);

            $colonne_value = 85;
//suivi financier
            if ($params['suivi_financier_daaf_feffi']=="true")
            {
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+1).$ligne, $value->transfert_tranche1);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+2).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+2).$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+2).$ligne, $value->date_approbation1);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+3).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("R".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+3).$ligne, $value->transfert_tranche2);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+4).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("S".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+4).$ligne, $value->date_approbation2);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+5).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+5).$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+5).$ligne, $value->transfert_tranche3);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+6).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+6).$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+6).$ligne, $value->date_approbation3);

            
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+7).$ligne)->applyFromArray($stylecontenu);
               // $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+7).$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+7).$ligne,  $value->transfert_tranche4);
            
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+8).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+8).$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+8).$ligne,$value->date_approbation4);
            
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+9).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+9).$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+9).$ligne, $value->transfert_tranche1 + $value->transfert_tranche2 + $value->transfert_tranche3 + $value->transfert_tranche4);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+10).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+10).$ligne)->getAlignment()->setWrapText(true);
                if ($value->montant_convention) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+10).$ligne,  (($value->transfert_tranche1 + $value->transfert_tranche2 + $value->transfert_tranche3 + $value->transfert_tranche4)*100)/$value->montant_convention);
                }
                


                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+11).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AB".$ligne)->getAlignment()->setWrapText(true);
                //$objPHPExcel->setActiveSheetIndex(0)->setCellValue("AB".$ligne, );
                $colonne_value = $colonne_value +11;
            }

            

//SUIVI FINANCIER FEFFI -PRESTATAIRE

            if ($params['suivi_financier_feffi_prestataire']=="true")
            {
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AB".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+1).$ligne, $value->montant_paiement_mpe1 + $value->montant_paiement_mpe2 + $value->montant_paiement_mpe3 + $value->montant_paiement_mpe4 +$value->montant_paiement_mpe5 + $value->montant_paiement_mpe6+ $value->montant_paiement_mpe7+ $value->montant_paiement_mpe8+ $value->montant_paiement_mpe9+ $value->montant_paiement_mpe10 + $value->montant_paiement_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+2).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AB".$ligne)->getAlignment()->setWrapText(true);
                if ($value->soustotaldepense) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+2).$ligne, (($value->montant_paiement_mpe1 + $value->montant_paiement_mpe2 + $value->montant_paiement_mpe3 + $value->montant_paiement_mpe4 +$value->montant_paiement_mpe5 + $value->montant_paiement_mpe6+ $value->montant_paiement_mpe7+ $value->montant_paiement_mpe8+ $value->montant_paiement_mpe9+ $value->montant_paiement_mpe10 + $value->montant_paiement_moe)*100)/$value->soustotaldepense);
                }
                

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+3).$ligne)->applyFromArray($stylecontenu);
                
                $colonne_value = $colonne_value + 3;
            }

        


//SUIVI FINANCIER FEFFI FONCTIONNEMENT

            if ($params['suivi_financier_feffi_fonctionnement']=="true")
            {
               $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+1).$ligne, $value->montant_decaiss_fonct_feffi);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+2).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+2).$ligne)->getAlignment()->setWrapText(true);
                if ($value->cout_sousprojet) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+2).$ligne, ($value->montant_decaiss_fonct_feffi*100)/$value->cout_sousprojet);
                }
                


                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+3).$ligne)->applyFromArray($stylecontenu);

                

                

                $colonne_value = $colonne_value + 3;
            }

            if ($params['total_convention_decaissee']=="true")
            {

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AG".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+1).$ligne, $value->montant_decaiss_fonct_feffi + $value->montant_paiement_mpe1 + $value->montant_paiement_mpe2 + $value->montant_paiement_mpe3 + $value->montant_paiement_mpe4 +$value->montant_paiement_mpe5 + $value->montant_paiement_mpe6+ $value->montant_paiement_mpe7+ $value->montant_paiement_mpe8+ $value->montant_paiement_mpe9+ $value->montant_paiement_mpe10 + $value->montant_paiement_moe);

                $colonne_value = $colonne_value + 1;
            }

            if ($params['reliquat_des_fonds']=="true")
            {
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AG".$ligne)->getAlignment()->setWrapText(true);
                //$objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+1).$ligne, $value->montant_convention - ($value->montant_decaiss_fonct_feffi + $value->montant_paiement_mpe1 + $value->montant_paiement_mpe2 + $value->montant_paiement_mpe3 + $value->montant_paiement_mpe4 +$value->montant_paiement_mpe5 + $value->montant_paiement_mpe6+ $value->montant_paiement_mpe7+ $value->montant_paiement_mpe8+ $value->montant_paiement_mpe9+ $value->montant_paiement_mpe10 + $value->montant_paiement_moe));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+1).$ligne, ($value->montant_convention + $value->cout_avenant) - ($value->montant_contrat_moe + $value->cout_mobilier_pme + $value->cout_latrine_pme + $value->cout_batiment_pme));

                $colonne_value = $colonne_value + 1;
            }

//Suivi Passation des marchés PR

            if ($params['suivi_passation_marches_pr']=="true")
            {
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+1).$ligne, $value->date_manifestation_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+2).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+2).$ligne, $value->date_lancement_dp_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+3).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+3).$ligne, $value->date_remise_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+4).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+4).$ligne, $value->nbr_offre_recu_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+5).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+5).$ligne, $value->date_os_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+6).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+6).$ligne, $value->nom_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+7).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+7).$ligne, $value->montant_contrat_pr);


                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+8).$ligne)->applyFromArray($stylecontenu);
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+9).$ligne)->applyFromArray($stylecontenu);
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+10).$ligne)->applyFromArray($stylecontenu);
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+11).$ligne)->applyFromArray($stylecontenu);

                $colonne_value = $colonne_value + 11;
            }


//module dpp  

            if ($params['suivi_prestation_pr']=="true")
            {
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+1).$ligne, $value->date_debut_previ_form_dpp_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+2).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+2).$ligne, $value->date_fin_previ_form_dpp_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+3).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+3).$ligne, $value->date_previ_resti_dpp_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+4).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+4).$ligne, $value->date_debut_reel_form_dpp_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+5).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+5).$ligne, $value->date_fin_reel_form_dpp_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+6).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+6).$ligne, $value->date_reel_resti_dpp_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+7).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+7).$ligne, $value->nbr_previ_parti_dpp_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+8).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+8).$ligne, $value->nbr_parti_dpp_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+9).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+9).$ligne, $value->nbr_previ_fem_parti_dpp_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+10).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+10).$ligne, $value->nbr_reel_fem_parti_dpp_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+11).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+11).$ligne, $value->lieu_formation_dpp_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+12).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+12).$ligne, $value->observation_dpp_pr);

        //modeule odc       

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+13).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+13).$ligne, $value->date_debut_previ_form_odc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+14).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+14).$ligne, $value->date_fin_previ_form_odc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+15).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+15).$ligne, $value->date_previ_resti_odc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+16).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+16).$ligne, $value->date_debut_reel_form_odc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+17).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+17).$ligne, $value->date_fin_reel_form_odc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+18).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+18).$ligne, $value->date_reel_resti_odc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+19).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+19).$ligne, $value->nbr_previ_parti_odc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+20).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+20).$ligne, $value->nbr_parti_odc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+21).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+21).$ligne, $value->nbr_previ_fem_parti_odc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+22).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+22).$ligne, $value->nbr_reel_fem_parti_odc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+23).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+23).$ligne, $value->lieu_formation_odc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+24).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+24).$ligne, $value->observation_odc_pr);

        //modeule pmc       

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+25).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+25).$ligne, $value->date_debut_previ_form_pmc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+26).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+26).$ligne, $value->date_fin_previ_form_pmc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+27).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+27).$ligne, $value->date_previ_resti_pmc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+28).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+28).$ligne, $value->date_debut_reel_form_pmc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+29).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+29).$ligne, $value->date_fin_reel_form_pmc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+30).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+30).$ligne, $value->date_reel_resti_pmc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+31).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+31).$ligne, $value->nbr_previ_parti_pmc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+32).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+32).$ligne, $value->nbr_parti_pmc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+33).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+33).$ligne, $value->nbr_previ_fem_parti_pmc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+34).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+34).$ligne, $value->nbr_reel_fem_parti_pmc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+35).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+35).$ligne, $value->lieu_formation_pmc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+36).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+36).$ligne, $value->observation_pmc_pr);

        //modeule gfpc       

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+37).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+37).$ligne, $value->date_debut_previ_form_gfpc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+38).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+38).$ligne, $value->date_fin_previ_form_gfpc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+39).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+39).$ligne, $value->date_previ_resti_gfpc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+40).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+40).$ligne, $value->date_debut_reel_form_gfpc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+41).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+41).$ligne, $value->date_fin_reel_form_gfpc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+42).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+42).$ligne, $value->date_reel_resti_gfpc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+43).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+43).$ligne, $value->nbr_previ_parti_gfpc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+44).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+44).$ligne, $value->nbr_parti_gfpc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+45).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+45).$ligne, $value->nbr_previ_fem_parti_gfpc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+46).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+46).$ligne, $value->nbr_reel_fem_parti_gfpc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+47).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+47).$ligne, $value->lieu_formation_gfpc_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+48).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+48).$ligne, $value->observation_gfpc_pr);

        //modeule sep       

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+49).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+49).$ligne, $value->date_debut_previ_form_sep_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+50).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+50).$ligne, $value->date_fin_previ_form_sep_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+51).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+51).$ligne, $value->date_previ_resti_sep_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+52).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+52).$ligne, $value->date_debut_reel_form_sep_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+53).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+53).$ligne, $value->date_fin_reel_form_sep_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+54).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+54).$ligne, $value->date_reel_resti_sep_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+55).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+55).$ligne, $value->nbr_previ_parti_sep_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+56).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+56).$ligne, $value->nbr_parti_sep_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+57).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+57).$ligne, $value->nbr_previ_fem_parti_sep_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+58).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+58).$ligne, $value->nbr_reel_fem_parti_sep_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+59).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+59).$ligne, $value->lieu_formation_sep_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+60).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+60).$ligne, $value->observation_sep_pr);

        //modeule emies       

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+61).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+61).$ligne, $value->date_debut_previ_form_emies_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+62).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+62).$ligne, $value->date_fin_previ_form_emies_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+63).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+63).$ligne, $value->date_previ_resti_emies_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+64).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+64).$ligne, $value->date_debut_reel_form_emies_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+65).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+65).$ligne, $value->date_fin_reel_form_emies_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+66).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+66).$ligne, $value->date_reel_resti_emies_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+67).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+67).$ligne, $value->nbr_previ_parti_emies_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+68).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+68).$ligne, $value->nbr_parti_emies_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+69).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+69).$ligne, $value->nbr_previ_fem_parti_emies_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+70).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+70).$ligne, $value->nbr_reel_fem_parti_emies_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+71).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+71).$ligne, $value->lieu_formation_emies_pr);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+72).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+72).$ligne, $value->observation_emies_pr);

                $colonne_value = $colonne_value + 72;
            }      

            

    //passation moe

            if ($params['suivi_passation_marches_moe']=="true")
            {

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+1).$ligne, $value->date_shortlist_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+2).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+2).$ligne, $value->date_manifestation_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+3).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+3).$ligne, $value->date_lancement_dp_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+4).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+4).$ligne, $value->date_remise_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+5).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+5).$ligne, $value->nbr_offre_recu_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+6).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+6).$ligne, $value->date_rapport_evaluation_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+7).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+7).$ligne, $value->date_demande_ano_dpfi_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+8).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+8).$ligne, $value->date_ano_dpfi_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+9).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+9).$ligne, $value->notification_intention_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+10).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+10).$ligne, $value->date_notification_attribution_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+11).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+11).$ligne, $value->date_signature_contrat_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+12).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+12).$ligne, $value->date_os_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+13).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+13).$ligne, $value->nom_bureau_etude_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+14).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                if (isset($value->statut_moe))
                {   
                    $statut_moe = "";
                    if (intval($value->statut_moe) == 1)
                    {
                        $statut_moe = "BE";
                    }
                    else
                    {
                        $statut_moe = "CI";
                    }

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+14).$ligne, $statut_moe);
                }
                

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+15).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+15).$ligne, $value->montant_contrat_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+16).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+16).$ligne, $value->montant_avenant_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+17).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+17).$ligne, $value->montant_avenant_moe + $value->montant_contrat_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+18).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+18).$ligne, $value->observation_moe);

                $colonne_value = $colonne_value + 18;
            }

            


    //PRESTATIO MOE

            if ($params['suivi_prestation_moe']=="true")
            {           
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+1).$ligne, $value->date_livraison_mt);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+2).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+2).$ligne, $value->date_approbation_mt);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+3).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+3).$ligne, $value->date_livraison_dao);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+4).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+4).$ligne, $value->date_approbation_dao);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+5).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+5).$ligne, $value->date_livraison_rp1);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+6).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+6).$ligne, $value->date_livraison_rp2);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+7).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+7).$ligne, $value->date_livraison_rp3);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+8).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+8).$ligne, $value->date_livraison_rp4);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+9).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+9).$ligne, $value->date_livraison_mg);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+10).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                //$objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+10).$ligne, $value->);

                
                $colonne_value = $colonne_value + 10;

            }

            if ($params['suivi_paiement_moe']=="true")
            {   
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                   /* $this->db ->select("(select sum(paiement_batiment_moe.montant_paiement) from paiement_batiment_moe,demande_batiment_moe, contrat_bureau_etude, convention_cisco_feffi_entete where paiement_batiment_moe.id_demande_batiment_moe=demande_batiment_moe.id and demande_batiment_moe.id_contrat_bureau_etude=contrat_bureau_etude.id and contrat_bureau_etude.id_convention_entete= convention_cisco_feffi_entete.id and paiement_batiment_moe.validation = '1' and convention_cisco_feffi_entete.id = id_conv) as montant_paiement_batiment_moe",FALSE);*/
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+1).$ligne, $value->montant_paiement_moe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+2).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                if ($value->montant_contrat_moe) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+2).$ligne, (($value->montant_paiement_moe)*100)/$value->montant_contrat_moe);
                }
                $colonne_value = $colonne_value + 2;

            }

            if ($params['police_assurance_moe']=="true")
            {            
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+1).$ligne, $value->date_expiration_poli_moe);
                $colonne_value = $colonne_value + 1;

            }
            

    //passation mpe

            if ($params['suivi_passation_marches_mpe']=="true")
            {
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+1).$ligne, $value->date_lancement_pme);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+2).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+2).$ligne, $value->date_remise_pme);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+3).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+3).$ligne, $value->nbr_mpe_soumissionaire_pme);
                
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+4).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+4).$ligne, $value->liste_mpe_soumissionaire);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+5).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+5).$ligne, $value->montant_moin_chere_pme);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+6).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+6).$ligne, $value->date_rapport_evaluation_pme);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+7).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+7).$ligne, $value->date_demande_ano_dpfi_pme);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+8).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+8).$ligne, $value->date_ano_dpfi_pme);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+9).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+9).$ligne, $value->notification_intention_pme);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+10).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+10).$ligne, $value->date_notification_attribution_pme);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+11).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+11).$ligne, $value->date_signature_pme);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+12).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+12).$ligne, $value->date_os_pme);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+13).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+13).$ligne, $value->nom_prestataire);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+14).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+14).$ligne, $value->observation_passation_pme);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+15).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+15).$ligne, $value->cout_batiment_pme);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+16).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+16).$ligne, $value->cout_latrine_pme);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+17).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+17).$ligne, $value->cout_mobilier_pme);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+18).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+18).$ligne, $value->cout_mobilier_pme + $value->cout_latrine_pme + $value->cout_batiment_pme);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+19).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+19).$ligne, $value->cout_latrine_avenant_mpe + $value->cout_batiment_avenant_mpe + $value->cout_mobilier_avenant_mpe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+20).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+20).$ligne, $value->cout_mobilier_pme + $value->cout_latrine_pme + $value->cout_batiment_pme + $value->cout_latrine_avenant_mpe + $value->cout_batiment_avenant_mpe + $value->cout_mobilier_avenant_mpe);

                $colonne_value = $colonne_value + 20;

            }

            if ($params['suivi_execution_travau_mpe']=="true")
            {
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+1).$ligne, $value->phase_sousprojet_mpe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+2).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+2).$ligne, $value->date_prev_debu_travau_mpe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+3).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+3).$ligne, $value->date_reel_debu_travau_mpe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+4).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+4).$ligne, $value->delai_execution_mpe);

        //reception

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+5).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+5).$ligne, $value->date_previ_recep_tech_mpe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+6).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+6).$ligne, $value->date_reel_tech_mpe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+7).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+7).$ligne, $value->date_leve_recep_tech_mpe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+8).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+8).$ligne, $value->date_previ_recep_prov_mpe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+9).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+9).$ligne, $value->date_reel_recep_prov_mpe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+10).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+10).$ligne, $value->date_previ_leve_mpe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+11).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+11).$ligne, $value->date_reel_lev_ava_rd_mpe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+12).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+12).$ligne, $value->date_previ_recep_defi_mpe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+13).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+13).$ligne, $value->date_reel_recep_defi_mpe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+14).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $avancement_phisique= 0;
                if ($value->montant_contrat_avance_phy!=null)
                {
                    if ($value->periode_bat_avance_phy)
                        {
                            $periode_batiment_avance_phy = $value->periode_bat_avance_phy;
                        }
                        if ($value->periode_lat_avance_phy)
                        {
                            $periode_latrine_avance_phy = $value->periode_lat_avance_phy;
                        }
                        if ($value->periode_mob_avance_phy)
                        {
                            $periode_mobilier_avance_phy = $value->periode_mob_avance_phy;
                        }
                        if ($value->anterieur_bat_avance_phy)
                        {
                            $anterieur_batiment_avance_phy = $value->anterieur_bat_avance_phy;
                        }
                        if ($value->anterieur_lat_avance_phy)
                        {
                            $anterieur_latrine_avance_phy = $value->anterieur_lat_avance_phy;
                        }
                        if ($value->anterieur_mob_avance_phy)
                        {
                            $anterieur_mobilier_avance_phy = $value->anterieur_mob_avance_phy;
                        }
                        $avancement_phisique =((((($value->cout_batiment_avance_phy*100)/$value->montant_contrat_avance_phy)*$anterieur_batiment_avance_phy)/100)+(((($value->cout_batiment_avance_phy*100)/$value->montant_contrat_avance_phy)*$periode_batiment_avance_phy)/100)
                    )+((((($value->cout_latrine_avance_phy*100)/$value->montant_contrat_avance_phy)*$anterieur_latrine_avance_phy)/100)+(((($value->cout_latrine_avance_phy*100)/$value->montant_contrat_avance_phy)*$periode_latrine_avance_phy)/100)
                    )+((((($value->cout_mobilier_avance_phy*100)/$value->montant_contrat_avance_phy)*$anterieur_mobilier_avance_phy)/100)+(((($value->cout_mobilier_avance_phy*100)/$value->montant_contrat_avance_phy)*$periode_mobilier_avance_phy)/100));
                }
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+14).$ligne, $avancement_phisique.' %');

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+15).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+15).$ligne, $value->observation_recep_mpe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+16).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+16).$ligne, $value->date_expiration_police_mpe);
                $colonne_value = $colonne_value + 16;

            }

            if ($params['suivi_paiement_mpe']=="true")
            {
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+1).$ligne, $value->date_approbation_avance_mpe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+2).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+2).$ligne, $value->montant_paiement_avance_mpe);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+3).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+3).$ligne, $value->date_approbation_mpe1);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+4).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+4).$ligne, $value->montant_paiement_mpe1);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+5).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+5).$ligne, $value->date_approbation_mpe2);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+6).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+6).$ligne, $value->montant_paiement_mpe2);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+7).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+7).$ligne, $value->date_approbation_mpe3);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+8).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+8).$ligne, $value->montant_paiement_mpe3);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+9).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+9).$ligne, $value->date_approbation_mpe4);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+10).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+10).$ligne, $value->montant_paiement_mpe4);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+11).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+11).$ligne, $value->date_approbation_mpe5);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+12).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+12).$ligne, $value->montant_paiement_mpe5);

               /* $objPHPExcel->getActiveSheet()->getStyle("GO".$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GO".$ligne, $value->anterieur_mpe);

                $objPHPExcel->getActiveSheet()->getStyle("GP".$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GP".$ligne, $value->periode_mpe);

                $objPHPExcel->getActiveSheet()->getStyle("GQ".$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GQ".$ligne, $value->cumul_mpe);*/

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+13).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+13).$ligne, $value->date_approbation_mpe6);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+14).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+14).$ligne, $value->montant_paiement_mpe6);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+15).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+15).$ligne, $value->date_approbation_mpe7);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+16).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+16).$ligne, $value->montant_paiement_mpe7);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+17).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+17).$ligne, $value->date_approbation_mpe8);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+18).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+18).$ligne, $value->montant_paiement_mpe8);

                /*$objPHPExcel->getActiveSheet()->getStyle("GX".$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GX".$ligne, $value->anterieur_mpe);

                $objPHPExcel->getActiveSheet()->getStyle("GY".$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GY".$ligne, $value->periode_mpe);

                $objPHPExcel->getActiveSheet()->getStyle("GZ".$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("GZ".$ligne, $value->cumul_mpe);*/

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+19).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+19).$ligne, $value->date_approbation_mpe9);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+20).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+20).$ligne, $value->montant_paiement_mpe9);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+21).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+21).$ligne, $value->date_approbation_mpe10);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+22).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+22).$ligne, $value->montant_paiement_mpe10);

                if ($value->montant_paiement_mpe2) 
                {
                    
                    $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+23).$ligne)->applyFromArray($stylecontenu);
                    //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+23).$ligne, $value->anterieur_mpe);

                    $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+24).$ligne)->applyFromArray($stylecontenu);
                    //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+24).$ligne, $value->periode_mpe);

                    $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+25).$ligne)->applyFromArray($stylecontenu);
                    //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+25).$ligne, $value->cumul_mpe + $value->montant_paiement_avance_mpe);
                }
                else
                {
                    if ($value->montant_paiement_mpe1) 
                    {
                    
                        $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+23).$ligne)->applyFromArray($stylecontenu);
                        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+23).$ligne, $value->montant_paiement_avance_mpe);

                        $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+24).$ligne)->applyFromArray($stylecontenu);
                        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+24).$ligne, $value->periode_mpe);

                        $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+25).$ligne)->applyFromArray($stylecontenu);
                        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+25).$ligne, $value->cumul_mpe + $value->montant_paiement_avance_mpe);
                    }
                    else
                    {

                        $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+23).$ligne)->applyFromArray($stylecontenu);
                        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+23).$ligne, ''); // anterieur

                        $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+24).$ligne)->applyFromArray($stylecontenu);
                        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+24).$ligne, $value->montant_paiement_avance_mpe); //periode

                        $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+25).$ligne)->applyFromArray($stylecontenu);
                        //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+25).$ligne, $value->cumul_mpe + $value->montant_paiement_avance_mpe); 
                    }
                }


                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+26).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                //$objPHPExcel->setActiveSheetIndex(0)->setCellValue("HH".$ligne, $value->);
                
                $colonne_value = $colonne_value + 26;

            }



            if ($params['transfert_reliquat']=="true")
            {
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+1).$ligne, $value->montant_transfert_reliquat);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+2).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+2).$ligne, $value->objet_utilisation_reliquat);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+3).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+3).$ligne, $value->situation_utilisation_reliquat);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+4).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+4).$ligne, $value->observation_reliquat);
                $colonne_value = $colonne_value + 4;

            }

            if ($params['indicateur']=="true")
            {
                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+1).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+1).$ligne, $value->prev_nbr_salle);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+2).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+2).$ligne, $value->nbr_salle_const_indicateur);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+3).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+3).$ligne, $value->prev_beneficiaire);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+4).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+4).$ligne, $value->nbr_beneficiaire_indicateur);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+5).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+5).$ligne, $value->prev_nbr_ecole);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+6).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+6).$ligne, $value->nbr_ecole_indicateur);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+7).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+7).$ligne, $value->prev_nbr_box_latrine);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+8).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+8).$ligne, $value->nbr_box_indicateur);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+9).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+9).$ligne, $value->prev_nbr_point_eau);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+10).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+10).$ligne, $value->nbr_point_eau_indicateur);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+11).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+11).$ligne, $value->prev_nbr_table_banc);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+12).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+12).$ligne, $value->nbr_banc_indicateur);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+13).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+13).$ligne, $value->prev_nbr_table_maitre);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+14).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+14).$ligne, $value->nbr_table_maitre_indicateur);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+15).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+15).$ligne, $value->prev_nbr_chaise_maitre);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+16).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+16).$ligne, $value->nbr_chaise_indicateur);

                $objPHPExcel->getActiveSheet()->getStyle($this->colonne($colonne_value+17).$ligne)->applyFromArray($stylecontenu);
                //$objPHPExcel->getActiveSheet()->getStyle("AK".$ligne)->getAlignment()->setWrapText(true);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->colonne($colonne_value+17).$ligne, $value->observation_indicateur);
                $colonne_value = $colonne_value + 17;

            }        

            $ligne++;
        }
        
    

        try
        {
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save(dirname(__FILE__) . "/../../../../../../assets/excel/bdd_construction/".$nom_file.".xlsx");
            //$data['c']=$this->colonne($col_total_maitrise_oeuvre);
            //$data['nc'] = $da['vo'];
            $data['colo'] = $colonne;
            /*if ($col_total_convetion_feffi >90 && $col_total_convetion_feffi<181)
            {
                $col_sup= $col_total_convetion_feffi - 90;
                                
                $data['forc'] ="A".chr($col_sup+65);
                $data['nbrforc'] =$col_sup;
                $data['nbrforc65'] =$col_sup+64;
            }*/
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
    public function generer_requete_convention_cisco_feffi($id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap)
    {
            //$requete = "date_creation BETWEEN '".$date_debut."' AND '".$date_fin."' " ;
            $requete ="region.id='".$id_region."'" ;
            
            if (($id_cisco!='*')&&($id_cisco!='undefined')&&($id_cisco!='null')) 
            {
                $requete = $requete." AND convention_cisco_feffi_entete.id_cisco='".$id_cisco."'" ;
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
                $requete = $requete." AND convention_cisco_feffi_entete.id='".$id_convention_entete."'" ;
            }
            if (($lot!='*')&&($lot!='undefined')&&($lot!='null')) 
            {
                $requete = $requete." AND site.lot='".$lot."'" ;
            }

            if (($id_zap!='*')&&($id_zap!='undefined')&&($id_zap!='null')) 
            {
                $requete = $requete." AND zap.id='".$id_zap."'" ;
            }
            
        return $requete ;
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

    public function colonne($col)  
    {   
        $column='';

        if ($col >90 && $col<117)
        {
            $col_sup= $col - 90;
            
            $column ="A".chr($col_sup+64);
        }
        elseif ($col >116 && $col<143)
        {
            $col_sup= $col - 116;
            
            $column ="B".chr($col_sup+64);
        }
        elseif ($col >142 && $col<169)
        {
            $col_sup= $col - 142;
            
            $column ="C".chr($col_sup+64);
        }
        elseif ($col >168 && $col<195)
        {
            $col_sup= $col - 168;
            
            $column ="D".chr($col_sup+64);
        }

        elseif ($col >194 && $col<221)
        {
            $col_sup= $col - 194;
            
            $column ="E".chr($col_sup+64);
        }
        elseif ($col >220 && $col<247)
        {
            $col_sup= $col - 220;
            
            $column ="F".chr($col_sup+64);
        }

        elseif ($col >246 && $col<273)
        {
            $col_sup= $col - 246;
            
            $column ="G".chr($col_sup+64);
        }
        elseif ($col >272 && $col<299)
        {
            $col_sup= $col - 272;
            
            $column ="H".chr($col_sup+64);
        }
        elseif ($col >298 && $col<325)
        {
            $col_sup= $col - 298;
            
            $column ="I".chr($col_sup+64);
        }
        else
        {
            $column = chr($col);
        }

        //var_dump($column); 
        return $column;
    }

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
?>