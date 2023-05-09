<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Facture_mpe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('facture_mpe_model', 'Facture_mpeManager');
        $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        $this->load->model('pv_consta_entete_travaux_model', 'Pv_consta_entete_travauxManager');
        $this->load->model('avancement_physi_batiment_model', 'Avancement_physi_batimentManager');
        $this->load->model('avancement_physi_latrine_model', 'Avancement_physi_latrineManager');
        $this->load->model('avancement_physi_mobilier_model', 'Avancement_physi_mobilierManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');        
        $id_pv_consta_entete_travaux = $this->get('id_pv_consta_entete_travaux');
        $id_facture_mpe = $this->get('id_facture_mpe');
        $menu = $this->get('menu');        
        $statu_incomplete = false;
        $id_convention_entete = $this->get('id_convention_entete');
        $validation = $this->get('validation');

        if ($menu=="count_facture_prestatairebyconventionvalidation")
        {
            $tmp = $this->Facture_mpeManager->count_facture_prestatairebyconventionvalidation($id_convention_entete,$validation);            
            $data = $tmp;
        }
        elseif ($menu=="getdecompte_mpeBycontratandfacture")
        {
            $tmp = $this->Facture_mpeManager->finddecompte_mpeBycontratandfacture($id_contrat_prestataire,$id_facture_mpe);
            if ($tmp) 
            {
               //$data=intVal($tmp[0]->id_contrat);
               if (intVal($tmp[0]->numero_fact)==1 )
               {
                $data['montant_travaux_to'] = $tmp[0]->montant_travaux_to ;
                $data['montant_rabais_to'] = $tmp[0]->montant_rabais_to ;
                $data['montant_ht_to'] = $tmp[0]->montant_ht_to ;
                $data['montant_tva_to'] = $tmp[0]->montant_tva_to ;
                $data['montant_ttc_to'] = $tmp[0]->montant_ttc_to ;
                $data['remboursement_acompte_to'] = $tmp[0]->remboursement_acompte_to;
                $data['penalite_retard_to'] = $tmp[0]->penalite_retard_to ;
                $data['retenue_garantie_to'] = $tmp[0]->retenue_garantie_to ;
                $data['remboursement_plaque_to'] = $tmp[0]->remboursement_plaque_to;
                $data['taxe_marche_public_to'] = $tmp[0]->taxe_marche_public_to;
                $data['net_payer_to'] = $tmp[0]->net_payer_to ;
                $data['net_payer_avanc_to'] = $tmp[0]->net_payer_avance ;

                $data['montant_travaux_pe'] = $tmp[0]->montant_travaux_pe ;
                $data['montant_rabais_pe'] = $tmp[0]->montant_rabais_pe ;
                $data['montant_ht_pe'] = $tmp[0]->montant_ht_pe ;
                $data['montant_tva_pe'] = $tmp[0]->montant_tva_pe ;
                $data['montant_ttc_pe'] = $tmp[0]->montant_ttc_pe ;
                $data['remboursement_acompte_pe'] = $tmp[0]->remboursement_acompte_pe;
                $data['penalite_retard_pe'] = $tmp[0]->penalite_retard_pe ;
                $data['retenue_garantie_pe'] = $tmp[0]->retenue_garantie_pe;
                $data['remboursement_plaque_pe'] = $tmp[0]->remboursement_plaque_pe;
                $data['taxe_marche_public_pe'] = $tmp[0]->taxe_marche_public_pe;
                $data['net_payer_pe'] = $tmp[0]->net_payer_pe ;
                $data['net_payer_avanc_pe'] = 0;

                $data['montant_travaux_ante'] = 0 ;
                $data['montant_rabais_ante'] = $tmp[0]->montant_rabais_avance ;
                $data['montant_ht_ante'] = 0 ;
                $data['montant_tva_ante'] = 0 ;
                $data['montant_ttc_ante'] = 0 ;
                $data['remboursement_acompte_ante'] = 0;
                $data['penalite_retard_ante'] = 0 ;
                $data['retenue_garantie_ante'] = 0;
                $data['remboursement_plaque_ante'] = 0;
                $data['taxe_marche_public_ante'] = $tmp[0]->taxe_marche_public_avance;
                $data['net_payer_ante'] =  $tmp[0]->net_payer_avance;
               }
               else
               {
                $data['montant_travaux_to'] = $tmp[0]->montant_travaux_to ;
                $data['montant_rabais_to'] = $tmp[0]->montant_rabais_to ;
                $data['montant_ht_to'] = $tmp[0]->montant_ht_to ;
                $data['montant_tva_to'] = $tmp[0]->montant_tva_to ;
                $data['montant_ttc_to'] = $tmp[0]->montant_ttc_to ;
                $data['remboursement_acompte_to'] = $tmp[0]->remboursement_acompte_to;
                $data['penalite_retard_to'] = $tmp[0]->penalite_retard_to ;
                $data['retenue_garantie_to'] = $tmp[0]->retenue_garantie_to ;
                $data['remboursement_plaque_to'] = $tmp[0]->remboursement_plaque_to;
                $data['taxe_marche_public_to'] = $tmp[0]->taxe_marche_public_to;
                $data['net_payer_to'] = $tmp[0]->net_payer_to ;
                $data['net_payer_avanc_to'] = $tmp[0]->net_payer_avance ;

                $data['montant_travaux_pe'] = $tmp[0]->montant_travaux_pe ;
                $data['montant_rabais_pe'] = $tmp[0]->montant_rabais_pe ;
                $data['montant_ht_pe'] = $tmp[0]->montant_ht_pe ;
                $data['montant_tva_pe'] = $tmp[0]->montant_tva_pe ;
                $data['montant_ttc_pe'] = $tmp[0]->montant_ttc_pe ;
                $data['remboursement_acompte_pe'] = $tmp[0]->remboursement_acompte_pe;
                $data['penalite_retard_pe'] = $tmp[0]->penalite_retard_pe ;
                $data['retenue_garantie_pe'] = $tmp[0]->retenue_garantie_pe;
                $data['remboursement_plaque_pe'] = $tmp[0]->remboursement_plaque_pe;
                $data['taxe_marche_public_pe'] = $tmp[0]->taxe_marche_public_pe;
                $data['net_payer_pe'] = $tmp[0]->net_payer_pe ;
                $data['net_payer_avanc_pe'] = 0;

                $data['montant_travaux_ante'] = $tmp[0]->montant_travaux_ante ;
                $data['montant_rabais_ante'] = $tmp[0]->montant_rabais_ante ;
                $data['montant_ht_ante'] = $tmp[0]->montant_ht_ante ;
                $data['montant_tva_ante'] = $tmp[0]->montant_tva_ante ;
                $data['montant_ttc_ante'] = $tmp[0]->montant_ttc_ante ;
                $data['remboursement_acompte_ante'] = $tmp[0]->remboursement_acompte_ante;
                $data['penalite_retard_ante'] = $tmp[0]->penalite_retard_ante ;
                $data['retenue_garantie_ante'] = $tmp[0]->retenue_garantie_ante;
                $data['remboursement_plaque_ante'] = $tmp[0]->remboursement_plaque_ante;
                $data['taxe_marche_public_ante'] = $tmp[0]->taxe_marche_public_ante;
                $data['net_payer_ante'] = $tmp[0]->net_payer_ante ;
                $data['net_payer_avanc_ante'] = 0 ;
               }
                /* foreach ($tmp as $key => $value)
                {
                    if (intval($value->nbr_fact)==1 )
                    {
                        
                             
                            $data[$key]['montant_travaux_to'] = $value->montant_travaux_to ;
                            $data[$key]['montant_rabais_to'] = $value->montant_rabais_to ;
                            $data[$key]['montant_ht_to'] = $value->montant_ht_to ;
                            $data[$key]['montant_tva_to'] = $value->montant_tva_to ;
                            $data[$key]['montant_ttc_to'] = $value->montant_ttc_to ;
                            $data[$key]['remboursement_acompte_to'] = $value->remboursement_acompte_to;
                            $data[$key]['penalite_retard_to'] = $value->penalite_retard_to ;
                            $data[$key]['retenue_garantie_to'] = $value->retenue_garantie_to ;
                            $data[$key]['remboursement_plaque_to'] = $value->remboursement_plaque_to;
                            $data[$key]['taxe_marche_public_to'] = $value->taxe_marche_public_to;
                            $data[$key]['net_payer_to'] = $value->net_payer_to + $value->net_payer_avanc ;
                            $data[$key]['net_payer_avanc_to'] = $value->net_payer_avanc ;

                            $data[$key]['montant_travaux_pe'] = $value->montant_travaux_pe ;
                            $data[$key]['montant_rabais_pe'] = $value->montant_rabais_pe ;
                            $data[$key]['montant_ht_pe'] = $value->montant_ht_pe ;
                            $data[$key]['montant_tva_pe'] = $value->montant_tva_pe ;
                            $data[$key]['montant_ttc_pe'] = $value->montant_ttc_pe ;
                            $data[$key]['remboursement_acompte_pe'] = $value->remboursement_acompte_pe;
                            $data[$key]['penalite_retard_pe'] = $value->penalite_retard_pe ;
                            $data[$key]['retenue_garantie_pe'] = $value->retenue_garantie_pe;
                            $data[$key]['remboursement_plaque_pe'] = $value->remboursement_plaque_pe;
                            $data[$key]['taxe_marche_public_pe'] = $value->taxe_marche_public_pe;
                            $data[$key]['net_payer_pe'] = $value->net_payer_pe ;
                            $data[$key]['net_payer_avanc_pe'] = 0;

                            $data[$key]['montant_travaux_ante'] = $value->montant_travaux_ante ;
                            $data[$key]['montant_rabais_ante'] = $value->montant_rabais_ante ;
                            $data[$key]['montant_ht_ante'] = $value->montant_ht_ante ;
                            $data[$key]['montant_tva_ante'] = $value->montant_tva_ante ;
                            $data[$key]['montant_ttc_ante'] = $value->montant_ttc_ante ;
                            $data[$key]['remboursement_acompte_ante'] = $value->remboursement_acompte_ante;
                            $data[$key]['penalite_retard_ante'] = $value->penalite_retard_ante ;
                            $data[$key]['retenue_garantie_ante'] = $value->retenue_garantie_ante;
                            $data[$key]['remboursement_plaque_ante'] = $value->remboursement_plaque_ante;
                            $data[$key]['taxe_marche_public_ante'] = $value->taxe_marche_public_ante;
                            $data[$key]['net_payer_ante'] = $value->net_payer_ante + $value->net_payer_avanc;
                            $data[$key]['net_payer_avanc_ante'] = $value->net_payer_avanc ;
                        
                    }
                    else
                    {
                        $data[$key]['montant_travaux_to'] = $value->montant_travaux_to ;
                            $data[$key]['montant_rabais_to'] = $value->montant_rabais_to ;
                            $data[$key]['montant_ht_to'] = $value->montant_ht_to ;
                            $data[$key]['montant_tva_to'] = $value->montant_tva_to ;
                            $data[$key]['montant_ttc_to'] = $value->montant_ttc_to ;
                            $data[$key]['remboursement_acompte_to'] = $value->remboursement_acompte_to;
                            $data[$key]['penalite_retard_to'] = $value->penalite_retard_to ;
                            $data[$key]['retenue_garantie_to'] = $value->retenue_garantie_to ;
                            $data[$key]['remboursement_plaque_to'] = $value->remboursement_plaque_to;
                            $data[$key]['taxe_marche_public_to'] = $value->taxe_marche_public_to;
                            $data[$key]['net_payer_to'] = $value->net_payer_to + $value->net_payer_avanc ;
                            $data[$key]['net_payer_avanc_to'] = $value->net_payer_avanc ;

                            $data[$key]['montant_travaux_pe'] = $value->montant_travaux_pe ;
                            $data[$key]['montant_rabais_pe'] = $value->montant_rabais_pe ;
                            $data[$key]['montant_ht_pe'] = $value->montant_ht_pe ;
                            $data[$key]['montant_tva_pe'] = $value->montant_tva_pe ;
                            $data[$key]['montant_ttc_pe'] = $value->montant_ttc_pe ;
                            $data[$key]['remboursement_acompte_pe'] = $value->remboursement_acompte_pe;
                            $data[$key]['penalite_retard_pe'] = $value->penalite_retard_pe ;
                            $data[$key]['retenue_garantie_pe'] = $value->retenue_garantie_pe;
                            $data[$key]['remboursement_plaque_pe'] = $value->remboursement_plaque_pe;
                            $data[$key]['taxe_marche_public_pe'] = $value->taxe_marche_public_pe;
                            $data[$key]['net_payer_pe'] = $value->net_payer_pe ;
                            $data[$key]['net_payer_avanc_pe'] = 0;

                            $data[$key]['montant_travaux_ante'] = $value->montant_travaux_ante ;
                            $data[$key]['montant_rabais_ante'] = $value->montant_rabais_ante ;
                            $data[$key]['montant_ht_ante'] = $value->montant_ht_ante ;
                            $data[$key]['montant_tva_ante'] = $value->montant_tva_ante ;
                            $data[$key]['montant_ttc_ante'] = $value->montant_ttc_ante ;
                            $data[$key]['remboursement_acompte_ante'] = $value->remboursement_acompte_ante;
                            $data[$key]['penalite_retard_ante'] = $value->penalite_retard_ante ;
                            $data[$key]['retenue_garantie_ante'] = $value->retenue_garantie_ante;
                            $data[$key]['remboursement_plaque_ante'] = $value->remboursement_plaque_ante;
                            $data[$key]['taxe_marche_public_ante'] = $value->taxe_marche_public_ante;
                            $data[$key]['net_payer_ante'] = $value->net_payer_ante ;
                            $data[$key]['net_payer_avanc_ante'] = 0 ;
                    }
                }*/            
            } 
                else
                    $data = array();
        }/*
        elseif ($menu=="getdecompte_mpeBycontrat")
        {
            $tmp = $this->Facture_mpeManager->finddecompte_mpeBycontrat($id_contrat_prestataire,$id_facture_mpe);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {
                    if (intval($value->nbr_fact)==1 )
                    {
                        
                             
                            $data[$key]['montant_travaux_to'] = $value->montant_travaux_to ;
                            $data[$key]['montant_rabais_to'] = $value->montant_rabais_to ;
                            $data[$key]['montant_ht_to'] = $value->montant_ht_to ;
                            $data[$key]['montant_tva_to'] = $value->montant_tva_to ;
                            $data[$key]['montant_ttc_to'] = $value->montant_ttc_to ;
                            $data[$key]['remboursement_acompte_to'] = $value->remboursement_acompte_to;
                            $data[$key]['penalite_retard_to'] = $value->penalite_retard_to ;
                            $data[$key]['retenue_garantie_to'] = $value->retenue_garantie_to ;
                            $data[$key]['remboursement_plaque_to'] = $value->remboursement_plaque_to;
                            $data[$key]['taxe_marche_public_to'] = $value->taxe_marche_public_to;
                            $data[$key]['net_payer_to'] = $value->net_payer_to + $value->net_payer_avanc ;
                            $data[$key]['net_payer_avanc_to'] = $value->net_payer_avanc ;

                            $data[$key]['montant_travaux_pe'] = $value->montant_travaux_pe ;
                            $data[$key]['montant_rabais_pe'] = $value->montant_rabais_pe ;
                            $data[$key]['montant_ht_pe'] = $value->montant_ht_pe ;
                            $data[$key]['montant_tva_pe'] = $value->montant_tva_pe ;
                            $data[$key]['montant_ttc_pe'] = $value->montant_ttc_pe ;
                            $data[$key]['remboursement_acompte_pe'] = $value->remboursement_acompte_pe;
                            $data[$key]['penalite_retard_pe'] = $value->penalite_retard_pe ;
                            $data[$key]['retenue_garantie_pe'] = $value->retenue_garantie_pe;
                            $data[$key]['remboursement_plaque_pe'] = $value->remboursement_plaque_pe;
                            $data[$key]['taxe_marche_public_pe'] = $value->taxe_marche_public_pe;
                            $data[$key]['net_payer_pe'] = $value->net_payer_pe ;
                            $data[$key]['net_payer_avanc_pe'] = 0;

                            $data[$key]['montant_travaux_ante'] = $value->montant_travaux_ante ;
                            $data[$key]['montant_rabais_ante'] = $value->montant_rabais_ante ;
                            $data[$key]['montant_ht_ante'] = $value->montant_ht_ante ;
                            $data[$key]['montant_tva_ante'] = $value->montant_tva_ante ;
                            $data[$key]['montant_ttc_ante'] = $value->montant_ttc_ante ;
                            $data[$key]['remboursement_acompte_ante'] = $value->remboursement_acompte_ante;
                            $data[$key]['penalite_retard_ante'] = $value->penalite_retard_ante ;
                            $data[$key]['retenue_garantie_ante'] = $value->retenue_garantie_ante;
                            $data[$key]['remboursement_plaque_ante'] = $value->remboursement_plaque_ante;
                            $data[$key]['taxe_marche_public_ante'] = $value->taxe_marche_public_ante;
                            $data[$key]['net_payer_ante'] = $value->net_payer_ante + $value->net_payer_avanc;
                            $data[$key]['net_payer_avanc_ante'] = $value->net_payer_avanc ;
                        
                    }
                    else
                    {
                        $data[$key]['montant_travaux_to'] = $value->montant_travaux_to ;
                            $data[$key]['montant_rabais_to'] = $value->montant_rabais_to ;
                            $data[$key]['montant_ht_to'] = $value->montant_ht_to ;
                            $data[$key]['montant_tva_to'] = $value->montant_tva_to ;
                            $data[$key]['montant_ttc_to'] = $value->montant_ttc_to ;
                            $data[$key]['remboursement_acompte_to'] = $value->remboursement_acompte_to;
                            $data[$key]['penalite_retard_to'] = $value->penalite_retard_to ;
                            $data[$key]['retenue_garantie_to'] = $value->retenue_garantie_to ;
                            $data[$key]['remboursement_plaque_to'] = $value->remboursement_plaque_to;
                            $data[$key]['taxe_marche_public_to'] = $value->taxe_marche_public_to;
                            $data[$key]['net_payer_to'] = $value->net_payer_to + $value->net_payer_avanc ;
                            $data[$key]['net_payer_avanc_to'] = $value->net_payer_avanc ;

                            $data[$key]['montant_travaux_pe'] = $value->montant_travaux_pe ;
                            $data[$key]['montant_rabais_pe'] = $value->montant_rabais_pe ;
                            $data[$key]['montant_ht_pe'] = $value->montant_ht_pe ;
                            $data[$key]['montant_tva_pe'] = $value->montant_tva_pe ;
                            $data[$key]['montant_ttc_pe'] = $value->montant_ttc_pe ;
                            $data[$key]['remboursement_acompte_pe'] = $value->remboursement_acompte_pe;
                            $data[$key]['penalite_retard_pe'] = $value->penalite_retard_pe ;
                            $data[$key]['retenue_garantie_pe'] = $value->retenue_garantie_pe;
                            $data[$key]['remboursement_plaque_pe'] = $value->remboursement_plaque_pe;
                            $data[$key]['taxe_marche_public_pe'] = $value->taxe_marche_public_pe;
                            $data[$key]['net_payer_pe'] = $value->net_payer_pe ;
                            $data[$key]['net_payer_avanc_pe'] = 0;

                            $data[$key]['montant_travaux_ante'] = $value->montant_travaux_ante ;
                            $data[$key]['montant_rabais_ante'] = $value->montant_rabais_ante ;
                            $data[$key]['montant_ht_ante'] = $value->montant_ht_ante ;
                            $data[$key]['montant_tva_ante'] = $value->montant_tva_ante ;
                            $data[$key]['montant_ttc_ante'] = $value->montant_ttc_ante ;
                            $data[$key]['remboursement_acompte_ante'] = $value->remboursement_acompte_ante;
                            $data[$key]['penalite_retard_ante'] = $value->penalite_retard_ante ;
                            $data[$key]['retenue_garantie_ante'] = $value->retenue_garantie_ante;
                            $data[$key]['remboursement_plaque_ante'] = $value->remboursement_plaque_ante;
                            $data[$key]['net_payer_ante'] = $value->net_payer_ante ;
                            $data[$key]['net_payer_avanc_ante'] = 0 ;
                    }
                }            
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getfacture_mpevalidebcafBycontrat")
        {
            $tmp = $this->Facture_mpeManager->findfacture_mpevalidebcafBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                $data = $tmp;            
            } 
                else
                    $data = array();
        }
        else*/
        
        elseif ($menu=="getfacture_mpevalideBycontrat")
        {
            $tmp = $this->Facture_mpeManager->getfacture_mpevalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                $data = $tmp;            
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getfacturevalideById")
        {
            $tmp = $this->Facture_mpeManager->getfacturevalideById($id_facture_mpe);
            if ($tmp) 
            {
                $data = $tmp;            
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getfacture_mpeBypv_consta_entete")
        {
            $tmp = $this->Facture_mpeManager->findfacture_mpeBypv_consta_entete($id_pv_consta_entete_travaux);
            if ($tmp) 
            {
                $data = $tmp;           
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getcount_statubyfacture")
        {
            $tmp_bat = $this->Facture_mpeManager->getcount_statu_batbyfacture($id_pv_consta_entete_travaux);
            $tmp_lat = $this->Facture_mpeManager->getcount_statu_latbyfacture($id_pv_consta_entete_travaux);
            $tmp_mob = $this->Facture_mpeManager->getcount_statu_mobbyfacture($id_pv_consta_entete_travaux);
            $data_statu =array();
            if ($tmp_bat || $tmp_lat || $tmp_mob) 
            {
                if ($tmp_bat)
                {$indice=0;
                    foreach ($tmp_bat as $key => $value)
                    {  
                        if ($value->nombre_rubrique_designation > $value->nombre_statu_designation && $value->nombre_statu_designation!=0)
                        {
                            $statu_incomplete = true;
                            $data_statu[$indice] ="batiment :". $value->libelle;
                        } 
                        /*$data_statu[$indice]["batiment"] = $value->nombre_rubrique_designation;
                        $data_statu[$indice]["batiment_sta"] = $value->nombre_statu_designation;*/
                        $indice = $indice +1;
                    }
                }
                if ($tmp_lat)
                {
                    foreach ($tmp_lat as $key2 => $value2)
                    {  
                        if ($value2->nombre_rubrique_designation > $value2->nombre_statu_designation && $value2->nombre_statu_designation!=0)
                        {
                            $statu_incomplete = true;
                            $data_statu[$indice] ="latrine :".$value2->libelle;
                        } 
                        
                        /*$data_statu[$indice]["latrine"] = $value2->nombre_rubrique_designation;
                        $data_statu[$indice]["latrine_stat"] = $value2->nombre_statu_designation;*/
                        $indice = $indice +1;
                    }
                }
                if ($tmp_mob)
                {
                    foreach ($tmp_mob as $key3 => $value3)
                    {  
                        if ($value3->nombre_rubrique_designation > $value3->nombre_statu_designation && $value3->nombre_statu_designation!=0)
                        {
                            $statu_incomplete = true;
                            $data_statu[$indice] ="mobilier :".$value3->libelle;
                        } 
                        
                        /*$data_statu[$indice]["mobilier"] = $value3->nombre_rubrique_designation;
                        $data_statu[$indice]["mobilier_stat"] = $value3->nombre_statu_designation;*/
                        $indice = $indice +1;
                    }
                }
                if (count($data_statu)>0)
                {
                    $data =$data_statu; 
                }
                else
                {
                    $data=array();
                }
                           
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $facture_mpe = $this->Facture_mpeManager->findById($id);

            $data['id'] = $facture_mpe->id;
            $data['numero'] = $facture_mpe->numero ;
            $data['montant_rabais'] = $facture_mpe->montant_rabais ;
            $data['pourcentage_rabais'] = $facture_mpe->pourcentage_rabais ;
            $data['montant_travaux'] = $facture_mpe->montant_travaux ;
            $data['montant_ht'] = $facture_mpe->montant_ht ;
            $data['montant_tva'] = $facture_mpe->montant_tva ;
            $data['montant_ttc'] = $facture_mpe->montant_ttc ;
            $data['remboursement_acompte'] = $facture_mpe->remboursement_acompte;
            $data['penalite_retard'] = $facture_mpe->penalite_retard ;
            $data['retenue_garantie'] = $facture_mpe->retenue_garantie ;
            $data['remboursement_plaque'] = $facture_mpe->remboursement_plaque;
            $data['taxe_marche_public'] = $facture_mpe->taxe_marche_public;
            $data['net_payer'] = $facture_mpe->net_payer ;
            $data['date_signature'] = $facture_mpe->date_signature ;
            $data['id_contrat_prestataire'] = $facture_mpe->id_contrat_prestataire;
            $data['validation'] = $facture_mpe->validation ;
        } 
        else 
        {
            $tmp = $this->Facture_mpeManager->findAll();
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
    
        
        if (count($data)>0) {
            $this->response([
                'status' => TRUE,
                'response' => $data,
                'message' => 'Get data success',
                'statu_pv' => $statu_incomplete,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'response' => array(),
                'message' => 'No data were found',
                'statu_pv' => $statu_incomplete,
            ], REST_Controller::HTTP_OK);
        }
    }
    public function index_post() 
    {
        $id = $this->post('id') ;
        $supprimer = $this->post('supprimer') ;
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'numero' => $this->post('numero'),
                    'montant_rabais' => $this->post('montant_rabais'),
                    'pourcentage_rabais' => $this->post('pourcentage_rabais'),
                    'montant_travaux' => $this->post('montant_travaux'),
                    'montant_ht' => $this->post('montant_ht'),
                    'montant_tva' => $this->post('montant_tva'),
                    'montant_ttc' => $this->post('montant_ttc'),
                    'remboursement_acompte' => $this->post('remboursement_acompte'),
                    'penalite_retard' => $this->post('penalite_retard'),
                    'retenue_garantie' => $this->post('retenue_garantie'),
                    'remboursement_plaque' => $this->post('remboursement_plaque'),
                    'taxe_marche_public' => $this->post('taxe_marche_public'),
                    'net_payer' => $this->post('net_payer'),
                    'date_signature' => $this->post('date_signature'),
                    'id_pv_consta_entete_travaux' => $this->post('id_pv_consta_entete_travaux'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Facture_mpeManager->add($data);
                if (!is_null($dataId)) {
                    $this->response([
                        'status' => TRUE,
                        'response' => $dataId,
                        'message' => 'Data insert success'
                            ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $data = array(
                    'numero' => $this->post('numero'),
                    'montant_rabais' => $this->post('montant_rabais'),
                    'pourcentage_rabais' => $this->post('pourcentage_rabais'),
                    'montant_travaux' => $this->post('montant_travaux'),
                    'montant_ht' => $this->post('montant_ht'),
                    'montant_tva' => $this->post('montant_tva'),
                    'montant_ttc' => $this->post('montant_ttc'),
                    'remboursement_acompte' => $this->post('remboursement_acompte'),
                    'penalite_retard' => $this->post('penalite_retard'),
                    'retenue_garantie' => $this->post('retenue_garantie'),
                    'remboursement_plaque' => $this->post('remboursement_plaque'),
                    'taxe_marche_public' => $this->post('taxe_marche_public'),
                    'net_payer' => $this->post('net_payer'),
                    'date_signature' => $this->post('date_signature'),
                    'id_pv_consta_entete_travaux' => $this->post('id_pv_consta_entete_travaux'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Facture_mpeManager->update($id, $data);
                $data_inser= array();
                if (strval($this->post('validation')) =='2')
                {
                    $id_pv_consta_entete_travaux = $this->post('id_pv_consta_entete_travaux');
                    $avancement_a_inserer = $this->Pv_consta_entete_travauxManager->getrecapByentete_travauxcontrat($id_pv_consta_entete_travaux,$this->post('id_contrat_prestataire'));
                    //$data_inser=$avancement_a_inserer;
                    $max_avancement = $this->Facture_mpeManager->getmax_avancementbycontrat($this->post('id_contrat_prestataire'));
                    $data_inser=$max_avancement;
                    if ($avancement_a_inserer)
                    {
                        if ($max_avancement)
                        {
                           if (Round($avancement_a_inserer[0]->batiment_cumul,2)>Round($max_avancement[0]->max_avance_bat,2))
                           {
                                $data_bat = array(
                                'pourcentage' => $avancement_a_inserer[0]->batiment_cumul,
                                'pourcentage_prevu' => $avancement_a_inserer[0]->prevu_batiment,
                                'date'   => $this->post('date_signature'),
                                'id_contrat_prestataire' => $this->post('id_contrat_prestataire')
                                );
                                $data_bat = $this->Avancement_physi_batimentManager->add($data_bat);
                           }
                           if (Round($avancement_a_inserer[0]->latrine_cumul,2)>Round($max_avancement[0]->max_avance_lat,2))
                           {
                                $data_lat = array(
                                'pourcentage' => $avancement_a_inserer[0]->latrine_cumul,
                                'pourcentage_prevu' => $avancement_a_inserer[0]->prevu_latrine,
                                'date'   => $this->post('date_signature'),
                                'id_contrat_prestataire' => $this->post('id_contrat_prestataire')
                                );
                                $data_lat = $this->Avancement_physi_latrineManager->add($data_lat);
                           }
                           if (Round($avancement_a_inserer[0]->mobilier_cumul,2)>Round($max_avancement[0]->max_avance_mob,2))
                           {
                                $data_mob = array(
                                'pourcentage' => $avancement_a_inserer[0]->mobilier_cumul,
                                'pourcentage_prevu' => $avancement_a_inserer[0]->prevu_mobilier,
                                'date'   => $this->post('date_signature'),
                                'id_contrat_prestataire' => $this->post('id_contrat_prestataire')
                                );
                                $data_mob = $this->Avancement_physi_batimentManager->add($data_mob);
                           }
                        }
                    }
                }
                if(!is_null($update)) {
                    $this->response([
                        'status' => TRUE,
                        'response' => 1,
                        'data' => $data_inser,
                        'message' => 'Update data success'
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_OK);
                }
            }
        } else {
            if (!$id) {
                $this->response([
                    'status' => FALSE,
                    'response' => 0,
                    'message' => 'No request found'
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $delete = $this->Facture_mpeManager->delete($id);         
            if (!is_null($delete)) {
                $this->response([
                    'status' => TRUE,
                    'response' => 1,
                    'message' => "Delete data success"
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'response' => 0,
                    'message' => 'No request found'
                        ], REST_Controller::HTTP_OK);
            }
        }        
    }
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
