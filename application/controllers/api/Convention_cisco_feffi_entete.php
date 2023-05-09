<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Convention_cisco_feffi_entete extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('region_model', 'RegionManager');
        $this->load->model('cisco_model', 'CiscoManager');
        $this->load->model('feffi_model', 'FeffiManager');
        $this->load->model('Site_model', 'SiteManager');
        $this->load->model('ecole_model', 'EcoleManager');

        $this->load->model('convention_cisco_feffi_detail_model', 'Convention_cisco_feffi_detailManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');        
        $this->load->model('convention_ufp_daaf_entete_model', 'Convention_ufp_daaf_enteteManager');

        $this->load->model('batiment_construction_model', 'Batiment_constructionManager');
        $this->load->model('latrine_construction_model', 'Latrine_constructionManager');
        $this->load->model('mobilier_construction_model', 'Mobilier_constructionManager');
        
        $this->load->model('avancement_physi_batiment_model', 'Avancement_physi_batimentManager');
        $this->load->model('avancement_physi_latrine_model', 'Avancement_physi_latrineManager');
        $this->load->model('avancement_physi_mobilier_model', 'Avancement_physi_mobilierManager');

        $this->load->model('demande_realimentation_feffi_model', 'Demande_realimentation_feffiManager');

        $this->load->model('decaiss_fonct_feffi_model', 'Decaiss_fonct_feffiManager');
        $this->load->model('utilisateurs_model', 'UserManager');
        $this->load->model('transfert_daaf_model', 'Transfert_daafManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');       
        $menu = $this->get('menu');
        $id_convention_ufpdaaf = $this->get('id_convention_ufpdaaf');
        $id_feffi = $this->get('id_feffi');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_region = $this->get('id_region');
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
        $id_zap = $this->get('id_zap');
        $annee = $this->get('annee');
        $id_utilisateur = $this->get('id_utilisateur');
        $id_cisco_user = $this->get('id_cisco_user');
        $id_district = $this->get('id_district');

        $now =intVal( date('Y'));
        $date_last= date('Y')-1;

        if ($menu=='getconventionByracourci') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->getconventionByracourci($id_convention_entete);
            if ($tmp) 
            {
               //$data=$tmp;
                 foreach ($tmp as $key => $value) 
                {
                    $region = array();
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    //$data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['user'] = $user;                  
                    //$data[$key]['montant_contrat'] = $value->montant_contrat;


                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getconventionvalidepresence_reliquat') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->getconventionvalidepresence_reliquat();
            if ($tmp) 
            {
               //$data=$tmp;
                 foreach ($tmp as $key => $value) 
                {
                    $region = array();
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    //$data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['user'] = $user;                  
                    $data[$key]['montant_contrat'] = $value->montant_contrat;


                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getconventionvalideneedavenant') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->getconventionvalideneedavenant();
            if ($tmp) 
            {
               //$data=$tmp;
                 foreach ($tmp as $key => $value) 
                {
                    $region = array();
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    //$data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['user'] = $user;                  
                    $data[$key]['montant_contrat'] = $value->montant_contrat;


                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getconventioncreerinvalideByutilisateurnow') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findcreerInvalideByutilisateurnow($id_utilisateur,$annee);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $region = array();
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    //$avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                   /* if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }*/
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    //$data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getconventioncreerinvalidenow') //mande       
         {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findcreerInvalidenow($annee);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $region = array();
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    //$avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                   /* if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }*/
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                   // $data[$key]['avancement'] = "avancement" ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['validation'] = $value->validation;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getconventioncreerinvalideByutilisateurfiltre') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findcreerInvalideByutilisateurfiltre($id_utilisateur,$this->generer_requete_convention_cisco_feffi($id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $region = array();
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    //$avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                   /* if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }*/
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    //$data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getconventioncreerinvalidefiltre') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findconventioncreerinvalidefiltre($this->generer_requete_convention_creer($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $region = array();
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    //$avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                   /* if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }*/
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    //$data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
                   //$data['user'] = $this->generer_requete2($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap);
        }
        elseif ($menu=='testconventionByIfvalide')       
         {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->testconventionByIfvalide($id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;                
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getconventionvalidedaaf')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllValidedaaf();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $region = array();
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                   // $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                   /* if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }*/
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                   // $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['user'] = $user;
                   
                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getconventionFeffietatByconvention_ufpdaaf')     //mande
       {
           $tmp = $this->Convention_cisco_feffi_enteteManager->convention_cisco_feffi_avancement($id_convention_ufpdaaf);
           if ($tmp) 
           {
               foreach ($tmp as $key => $value) 
               {
                   $cisco = array();
                   $region = array();
                   $feffi = array();
                   $site = array();
                   $avancement = 0;
                   $montant = 0;
                   $montant_trav_mob =0;
                   $montant_divers =0;
                   
                   $user = $this->UserManager->findById($value->id_user);
                   $region = $this->RegionManager->findById($value->id_region);
                   $cisco = $this->CiscoManager->findById($value->id_cisco);
                   $feffi = $this->FeffiManager->findById($value->id_feffi);
                   $site = $this->SiteManager->findById($value->id_site);
                   $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                  // $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                   $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                  /* if (count($avancement_detail)>0)
                  {
                     $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                   }*/
                   if (count($montant_detail)>0)
                   {
                       $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                       $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                       $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                   }
                   
                   $data[$key]['id'] = $value->id;
                   $data[$key]['region'] = $region;
                   $data[$key]['cisco'] = $cisco;
                   $data[$key]['feffi'] = $feffi;

                   $data[$key]['site'] = $site;
                   $data[$key]['ref_convention'] = $value->ref_convention;
                   $data[$key]['objet'] = $value->objet;                    
                   $data[$key]['ref_financement'] = $value->ref_financement;
                   $data[$key]['montant_total'] = $montant;
                   $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                   $data[$key]['montant_divers'] = $montant_divers;
                   //$data[$key]['avancement'] = $avancement ; 
                   $data[$key]['ecole'] = $ecole;
                   $data[$key]['user'] = $user;                   
                   $data[$key]['date_creation'] = $value->date_creation;
                   $data[$key]['validation'] = $value->validation;                   
                   $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                   $data[$key]['avancement_physique'] =0;
                   if ($value->montant_contrat!=null)
                   {
                    $periode_batiment =0;
                    $periode_latrine =0;
                    $periode_mobilier =0;
                    if ($value->periode_bat)
                    {
                        $periode_batiment = $value->periode_bat;
                    }
                    if ($value->periode_lat)
                    {
                        $periode_latrine = $value->periode_lat;
                    }
                    if ($value->periode_mob)
                    {
                        $periode_mobilier = $value->periode_mob;
                    }

                    $anterieur_batiment =0;
                    $anterieur_latrine =0;
                    $anterieur_mobilier =0;
                    if ($value->anterieur_bat)
                    {
                        $anterieur_batiment = $value->anterieur_bat;
                    }
                    if ($value->anterieur_lat)
                    {
                        $anterieur_latrine = $value->anterieur_lat;
                    }
                    if ($value->anterieur_mob)
                    {
                        $anterieur_mobilier = $value->anterieur_mob;
                    }
                    $data[$key]['avancement_physique'] =((((($value->cout_batiment*100)/$value->montant_contrat)*$anterieur_batiment)/100)+(((($value->cout_batiment*100)/$value->montant_contrat)*$periode_batiment)/100)
                    )+((((($value->cout_latrine*100)/$value->montant_contrat)*$anterieur_latrine)/100)+(((($value->cout_latrine*100)/$value->montant_contrat)*$periode_latrine)/100)
                    )+((((($value->cout_mobilier*100)/$value->montant_contrat)*$anterieur_mobilier)/100)+(((($value->cout_mobilier*100)/$value->montant_contrat)*$periode_mobilier)/100));
                   }

                   
                   
               }
           } 
               else
                   $data = array();
       }

         elseif ($menu=='getconventionFeffiByconvention_ufpdaaf')     //mande
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findconventionFeffiByconvention_ufpdaaf($id_convention_ufpdaaf);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $region = array();
                    $feffi = array();
                    $site = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;
                    
                    $user = $this->UserManager->findById($value->id_user);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                   // $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                   /* if (count($avancement_detail)>0)
                   {
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }*/
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                    
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;
                    //$data[$key]['avancement'] = $avancement ; 
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['user'] = $user;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                    $data[$key]['validation'] = $value->validation;                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    if($value->id_convention_ufpdaaf)
                    {
                      $convention_ufp_daaf_entete = $this->Convention_ufp_daaf_enteteManager->findById($value->id_convention_ufpdaaf);
                      $data[$key]['convention_ufp_daaf_entete'] = $convention_ufp_daaf_entete;

                    }
                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getconventionvalideufpBydateutilisateur') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findconventionvalideufpBydateutilisateur($this->generer_requete_convention_cisco_feffi($id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap),$id_utilisateur);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $region = array();
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    //$avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                   /* if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }*/
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                   // $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getconventionNeeddemandefeffivalidationbcaf') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->getconventionNeeddemandefeffivalidationbcaf();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    //$avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                   // $countdemande_feffi_creer = $this->Facture_mpeManager->countdemandeByconvention($value->id,0);

                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    //$data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    //$data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;


                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getconventionNeeddemandefeffivalidationdpfi') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->getconventionNeeddemandefeffivalidationdpfi();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);                    
                    $region = $this->RegionManager->findById($value->id_region);
                    //$avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                   // $countdemande_feffi_creer = $this->Facture_mpeManager->countdemandeByconvention($value->id,0);

                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['region'] = $region;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    //$data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    //$data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;


                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getconventionNeeddemandefeffivalidationufp') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->getconventionNeeddemandefeffivalidationufp();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    //$avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);                    
                    $region = $this->RegionManager->findById($value->id_region);
                    //$avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                   // $countdemande_feffi_creer = $this->Facture_mpeManager->countdemandeByconvention($value->id,0);
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['region'] = $region;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    //$data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    //$data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;


                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getconventionNeeddemandefeffivalidationdaaf') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->getconventionNeeddemandefeffivalidationdaaf();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);                    
                    $region = $this->RegionManager->findById($value->id_region);
                    //$avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                   // $countdemande_feffi_creer = $this->Facture_mpeManager->countdemandeByconvention($value->id,0);

                    /*if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }*/
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['region'] = $region;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    //$data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    //$data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventionneedfacturevalidation') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->getconventionneedfacturevalidation();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);                    
                    $region = $this->RegionManager->findById($value->id_region);
                    //$avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                   // $countdemande_feffi_creer = $this->Facture_mpeManager->countdemandeByconvention($value->id,0);

                    /*if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }*/
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['region'] = $region;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    //$data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    //$data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;


                }
            } 
                else
                    $data = array();
        }       
       
        elseif ($menu=='conventionmaxBydate')  //mande
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findconventionmaxBydate($date_today);
            if ($tmp) 
            {
                $data = $tmp;

            } 
                else
                    $data = array();
        }
        
        elseif ($menu=='getconventionvalidedaafBydate') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findconventionvalidedaafBydate($this->generer_requete_convention_cisco_feffi($id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap));
            //findconventionvalidedaafBydate($this->generer_requete($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);                    
                    $region = $this->RegionManager->findById($value->id_region);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['region'] = $region;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['user'] = $user;

                   // $data[$key]['nbr_decaiss_feffi'] = $countdecai_fonct_feffi[0]->nbr_decaiss;
                   // $data[$key]['ato'] = $avancement_detail;


                }
            } 
                else
                    $data = array();
        } 
        
        elseif ($menu=='getconventionvalideufp_avancement_financBydate') //mande       
        {          
            $tmp = $this->Convention_cisco_feffi_enteteManager->findconventionvalideufpBydate($this->generer_requete_convention_cisco_feffi($id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;
                    $transfert_daaf = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);                    
                    $region = $this->RegionManager->findById($value->id_region);
                    $transfert = $this->Transfert_daafManager->gettransfertByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }
                    if($transfert)
                    {
                        $transfert_daaf = $transfert;
                        if ($montant_divers!=0 && $montant_trav_mob!=0)
                        {
                            $avancement = ($transfert_daaf[0]->montant_transfert*100)/($montant_divers + $montant_trav_mob);
                        }
                        
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['region'] = $region;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement_financ'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                                       
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }
        
        elseif ($menu=='getconventionNeeddecaissfeffivalidation') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->getconventionNeeddecaissfeffivalidationbcaf();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);                    
                    $region = $this->RegionManager->findById($value->id_region);
                    //$avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                   // $countdemande_feffi_creer = $this->Facture_mpeManager->countdemandeByconvention($value->id,0);

                  /*  if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }*/
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['region'] = $region;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    //$data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                                       
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    //$data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;


                }
            } 
                else
                    $data = array();
        }
        
        elseif ($menu=='getconventionfiltre')        
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllByfiltre($this->generer_requete_convention_cisco_feffi($id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);                    
                    $region = $this->RegionManager->findById($value->id_region);
                   // $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                                       
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['region'] = $region;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['ato'] = 'ato';
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                  
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['type_convention'] = $value->type_convention;                   
                    $data[$key]['date_creation'] = $value->date_creation;                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
                   //$data['user'] = $this->generer_requete2($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap);
        }
        
        elseif ($menu=='getconventionvalideufpBydate') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findconventionvalideufpBydate($this->generer_requete_convention_cisco_feffi($id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);                    
                    $region = $this->RegionManager->findById($value->id_region);
                   // $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                                       
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    $data[$key]['region'] = $region;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['ato'] = 'ato';
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                  
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['type_convention'] = $value->type_convention;                   
                    $data[$key]['date_creation'] = $value->date_creation;                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='reportingvuecarte') //mande       
        {
                   
           $tmp = $this->Convention_cisco_feffi_enteteManager->findreporting($now,$date_last, $id_district);
           if ($tmp) 
           {   
               foreach ($tmp as $key => $value) 
               {
                    if ($value->montant_contrat!=null)
                    {
                        $cisco = $this->CiscoManager->findById($value->id_cisco);
                        $feffi = $this->FeffiManager->findById($value->id_feffi);
                        $periode_batiment =0;
                        $periode_latrine =0;
                        $periode_mobilier =0;
                        if ($value->periode_bat)
                        {
                            $periode_batiment = $value->periode_bat;
                        }
                        if ($value->periode_lat)
                        {
                            $periode_latrine = $value->periode_lat;
                        }
                        if ($value->periode_mob)
                        {
                            $periode_mobilier = $value->periode_mob;
                        }

                        $anterieur_batiment =0;
                        $anterieur_latrine =0;
                        $anterieur_mobilier =0;
                        if ($value->anterieur_bat)
                        {
                            $anterieur_batiment = $value->anterieur_bat;
                        }
                        if ($value->anterieur_lat)
                        {
                            $anterieur_latrine = $value->anterieur_lat;
                        }
                        if ($value->anterieur_mob)
                        {
                            $anterieur_mobilier = $value->anterieur_mob;
                        }
                        $data[$key]['id'] = $value->id_conv;
                        $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['prevu_batiment'] = ($value->cout_batiment*100)/$value->montant_contrat;
                    $data[$key]['prevu_latrine'] = ($value->cout_latrine*100)/$value->montant_contrat;
                    $data[$key]['prevu_mobilier'] = ($value->cout_mobilier*100)/$value->montant_contrat;

                    
                    $data[$key]['periode_batiment'] = ((($value->cout_batiment*100)/$value->montant_contrat)*$periode_batiment)/100;
                    $data[$key]['periode_latrine'] = ((($value->cout_latrine*100)/$value->montant_contrat)*$periode_latrine)/100;
                    $data[$key]['periode_mobilier'] = ((($value->cout_mobilier*100)/$value->montant_contrat)*$periode_mobilier)/100;

                    
                    $data[$key]['anterieur_batiment'] = ((($value->cout_batiment*100)/$value->montant_contrat)*$anterieur_batiment)/100;
                    $data[$key]['anterieur_latrine'] = ((($value->cout_latrine*100)/$value->montant_contrat)*$anterieur_latrine)/100;
                    $data[$key]['anterieur_mobilier'] = ((($value->cout_mobilier*100)/$value->montant_contrat)*$anterieur_mobilier)/100;

                    $data[$key]['cumul_batiment'] = (((($value->cout_batiment*100)/$value->montant_contrat)*$anterieur_batiment)/100)+(((($value->cout_batiment*100)/$value->montant_contrat)*$periode_batiment)/100);
                    $data[$key]['cumul_latrine'] = (((($value->cout_latrine*100)/$value->montant_contrat)*$anterieur_latrine)/100)+(((($value->cout_latrine*100)/$value->montant_contrat)*$periode_latrine)/100);
                    $data[$key]['cumul_mobilier'] = (((($value->cout_mobilier*100)/$value->montant_contrat)*$anterieur_mobilier)/100)+(((($value->cout_mobilier*100)/$value->montant_contrat)*$periode_mobilier)/100);
                    $data[$key]['avancement_total'] =((((($value->cout_batiment*100)/$value->montant_contrat)*$anterieur_batiment)/100)+(((($value->cout_batiment*100)/$value->montant_contrat)*$periode_batiment)/100)
                    )+((((($value->cout_latrine*100)/$value->montant_contrat)*$anterieur_latrine)/100)+(((($value->cout_latrine*100)/$value->montant_contrat)*$periode_latrine)/100)
                    )+((((($value->cout_mobilier*100)/$value->montant_contrat)*$anterieur_mobilier)/100)+(((($value->cout_mobilier*100)/$value->montant_contrat)*$periode_mobilier)/100));
                    /* $data[$key]['avancement_latrine'] = $value->avancement_latrine;                   
                    $data[$key]['avancement_mobilier'] = $value->avancement_mobilier;                  
                    $data[$key]['avancement_tot'] = $value->avancement_mobilier+$value->avancement_latrine+$value->avancement_batiment;*/
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;
                    }
                    
                }
               //$data =$tmp;
              // (sum(detail.cout_batiment)*100)/(sum(detail.cout_batiment) + sum( detail.cout_mobilier) + sum(detail.cout_latrine))
           } 
           else $data = array();
           //$data[0] = $date_last;
          //$data[1] = $now;
       }
       
        elseif ($menu=='getdonneeexporter') //mande       
         {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->finddonneeexporter($this->generer_requete($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot));
            if ($tmp) 
            {
                $data =$tmp;
            } 
            else
                    $data = array();
        }
        elseif ($menu=='getconventionNeeddemandefeffivalidationbcafwithcisco') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->getconventionNeeddemandefeffivalidationbcafwithcisco($id_cisco_user);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                   // $countdemande_feffi_creer = $this->Facture_mpeManager->countdemandeByconvention($value->id,0);

                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    //$data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventionNeeddecaissfeffivalidationbcafwithcisco') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->getconventionNeeddecaissfeffivalidationbcafwithcisco($id_cisco_user);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                   // $countdemande_feffi_creer = $this->Facture_mpeManager->countdemandeByconvention($value->id,0);

                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    //$data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;


                }
            } 
                else
                    $data = array();
        }
       /* elseif ($menu=='getconventionNeeddemandefeffivalidationufp') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->getconventionNeeddemandefeffivalidationufp();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                   // $countdemande_feffi_creer = $this->Facture_mpeManager->countdemandeByconvention($value->id,0);

                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    //$data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;


                }
            } 
                else
                    $data = array();
        }*/
        elseif ($menu=='getconventionNeeddemandefeffivalidationpdfi') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->getconventionNeeddemandefeffivalidationpdfi();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                   // $countdemande_feffi_creer = $this->Facture_mpeManager->countdemandeByconvention($value->id,0);

                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    //$data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventionNeedvalidationpdfi') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->getconventionNeedvalidationpdfi();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                   // $countdemande_feffi_creer = $this->Facture_mpeManager->countdemandeByconvention($value->id,0);

                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    //$data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;


                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getconventionneedfacturevalidationBycisco') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->getconventionneedfacturevalidationBycisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                   // $countdemande_feffi_creer = $this->Facture_mpeManager->countdemandeByconvention($value->id,0);

                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    //$data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getfiltre_convention')       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findconventionvalidefiltre($this->generer_requete2($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                    $countdemande_feffi_creer = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,0);
                    $countdemande_feffi_emidpfi = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,1);
                    $countdemande_feffi_encourdpfi = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,2);

                    $countdemande_feffi_emidaaf = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,4);
                    $countdemande_feffi_encourdaaf = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,5);
                    $countdecai_fonct_feffi = $this->Decaiss_fonct_feffiManager->countdecaissByconvention($value->id);
                    $countdecai_fonct_feffi = $this->Decaiss_fonct_feffiManager->countdecaissByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    $data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_emidpfi'] = $countdemande_feffi_emidpfi[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_encourdpfi'] = $countdemande_feffi_encourdpfi[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_emidaaf'] = $countdemande_feffi_emidaaf[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_encourdaaf'] = $countdemande_feffi_encourdaaf[0]->nbr_demande_feffi;

                    $data[$key]['nbr_decaiss_feffi'] = $countdecai_fonct_feffi[0]->nbr_decaiss;
                    $data[$key]['ato'] = $avancement_detail;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventionvalideufpByfiltrecisco') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findconventionvalideufpByfiltrecisco($this->generer_requete($date_debut,$date_fin,$id_region,'*',$id_commune,$id_ecole,$id_convention_entete,$lot),$id_cisco_user);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                    $countdemande_feffi_creer = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,0);
                    $countdemande_feffi_emidpfi = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,1);
                    $countdemande_feffi_encourdpfi = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,2);

                    $countdemande_feffi_emidaaf = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,4);
                    $countdemande_feffi_encourdaaf = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,5);
                    $countdecai_fonct_feffi = $this->Decaiss_fonct_feffiManager->countdecaissByconvention($value->id);
                    $countdecai_fonct_feffi = $this->Decaiss_fonct_feffiManager->countdecaissByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    $data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_emidpfi'] = $countdemande_feffi_emidpfi[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_encourdpfi'] = $countdemande_feffi_encourdpfi[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_emidaaf'] = $countdemande_feffi_emidaaf[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_encourdaaf'] = $countdemande_feffi_encourdaaf[0]->nbr_demande_feffi;

                    $data[$key]['nbr_decaiss_feffi'] = $countdecai_fonct_feffi[0]->nbr_decaiss;
                    $data[$key]['ato'] = $avancement_detail;


                }
            } 
                else
                    $data = array();
        }
       /* elseif ($menu=='getconventionvalidedaafBydate') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findconventionvalidedaafBydate($this->generer_requete($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                    $countdemande_feffi_creer = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,0);
                    $countdemande_feffi_emidpfi = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,1);
                    $countdemande_feffi_encourdpfi = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,2);

                    $countdemande_feffi_emidaaf = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,4);
                    $countdemande_feffi_encourdaaf = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,5);
                    $countdecai_fonct_feffi = $this->Decaiss_fonct_feffiManager->countdecaissByconvention($value->id);
                    $countdecai_fonct_feffi = $this->Decaiss_fonct_feffiManager->countdecaissByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    $data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_emidpfi'] = $countdemande_feffi_emidpfi[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_encourdpfi'] = $countdemande_feffi_encourdpfi[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_emidaaf'] = $countdemande_feffi_emidaaf[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_encourdaaf'] = $countdemande_feffi_encourdaaf[0]->nbr_demande_feffi;

                    $data[$key]['nbr_decaiss_feffi'] = $countdecai_fonct_feffi[0]->nbr_decaiss;
                    $data[$key]['ato'] = $avancement_detail;


                }
            } 
                else
                    $data = array();
        }*/
        elseif ($menu=='getconventionvalideufpBydate') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findconventionvalideufpBydate($this->generer_requete($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    
                    $countdemande_feffi_creer = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,0);
                    $countdemande_feffi_emidpfi = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,1);
                    $countdemande_feffi_encourdpfi = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,2);

                    $countdemande_feffi_emidaaf = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,4);
                    $countdemande_feffi_encourdaaf = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,5);
                    $countdecai_fonct_feffi = $this->Decaiss_fonct_feffiManager->countdecaissByconvention($value->id);
                    $countdecai_fonct_feffi = $this->Decaiss_fonct_feffiManager->countdecaissByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    $data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_emidpfi'] = $countdemande_feffi_emidpfi[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_encourdpfi'] = $countdemande_feffi_encourdpfi[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_emidaaf'] = $countdemande_feffi_emidaaf[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_encourdaaf'] = $countdemande_feffi_encourdaaf[0]->nbr_demande_feffi;

                    $data[$key]['nbr_decaiss_feffi'] = $countdecai_fonct_feffi[0]->nbr_decaiss;
                    $data[$key]['ato'] = $avancement_detail;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventioncreerfiltre') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findcreerByfiltre($this->generer_requete_convention_creer($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                  
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['type_convention'] = $value->type_convention;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
                   //$data['user'] = $this->generer_requete2($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap);
        }
       /* elseif ($menu=='getconventionfiltre') //tsy mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllByfiltre($this->generer_requete2($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                  
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['type_convention'] = $value->type_convention;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
                   //$data['user'] = $this->generer_requete2($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap);
        }*/
        elseif ($menu=='getconventioninvalidefiltre') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllInvalideByfiltre($this->generer_requete2($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
                   //$data['user'] = $this->generer_requete2($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap);
        }
        elseif ($menu=='getconventionByciscofiltre') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllByid_ciscofiltre($id_cisco,$this->generer_requete_date($date_debut,$date_fin));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                  
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['type_convention'] = $value->type_convention;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventioninvalideByutilisateurfiltre') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllInvalideByutilisateurfiltre($id_utilisateur,$this->generer_requete2($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventioninvalideByecole') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllInvalideByecole($id_ecole);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventionBycisconow') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllByid_cisconow($id_cisco,$annee);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['type_convention'] = $value->type_convention;                   
                    $data[$key]['date_creation'] = $value->date_creation;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventioncreerinvalideBycisconow') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findcreerInvalideByid_cisconow($id_cisco,$annee);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;                  
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventioninvalideBycisconow')       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllInvalideByid_cisconow($id_cisco,$annee);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventioninvalideByutilisateurnow') //mande       
        {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllInvalideByutilisateurnow($id_utilisateur,$annee);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventionnow') //mande       
         {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllnow($annee);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;                   
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventioninvalidenow')      
         {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllInvalidenow($annee);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['validation'] = $value->validation;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        }elseif ($menu=='getconventionvalideufpBycisco')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllValideByid_cisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;


                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='getconventionvalideufpByciscodate')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAllValideufpByid_ciscodate($id_cisco,$date_debut,$date_fin);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $montant_detail = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob = 0;
                    $montant_divers = 0;

                    $user = $this->UserManager->findById($value->id_user);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    $countdemande_feffi_creer = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,0);
                    $countdemande_feffi_emidpfi = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,1);
                    $countdemande_feffi_encourdpfi = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,2);

                    $countdemande_feffi_emidaaf = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,4);
                    $countdemande_feffi_encourdaaf = $this->Demande_realimentation_feffiManager->countdemandeByconvention($value->id,5);
                    $countdecai_fonct_feffi = $this->Decaiss_fonct_feffiManager->countdecaissByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
       
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)/3),4) ; 
                    }
                     
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['avancement'] = $avancement ;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;                   
                    $data[$key]['date_creation'] = $value->date_creation;

                    $data[$key]['type_convention'] = $value->type_convention;
                    $data[$key]['user'] = $user;

                    $data[$key]['nbr_demande_feffi_creer'] = $countdemande_feffi_creer[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_emidpfi'] = $countdemande_feffi_emidpfi[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_encourdpfi'] = $countdemande_feffi_encourdpfi[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_emidaaf'] = $countdemande_feffi_emidaaf[0]->nbr_demande_feffi;
                    $data[$key]['nbr_demande_feffi_encourdaaf'] = $countdemande_feffi_encourdaaf[0]->nbr_demande_feffi;

                    $data[$key]['nbr_decaiss_feffi'] = $countdecai_fonct_feffi[0]->nbr_decaiss;


                }
            } 
                else
                    $data = array();
        } 
       /* elseif ($menu=='getconventionByecole')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findconventionByid_ecole($id_ecole);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        } */
         
        elseif ($menu=='getconventionByecole')
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findconventionByid_ecole($id_ecole);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        }
        else 
        {
            $tmp = $this->Convention_cisco_feffi_enteteManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $region = array();
                    $cisco = array();
                    $feffi = array();
                    $site = array();
                    $avancement = 0;
                    $montant = 0;
                    $montant_trav_mob =0;
                    $montant_divers =0;

                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $site = $this->SiteManager->findById($value->id_site);
                    $ecole = $this->EcoleManager->findByIdZone($feffi->id_ecole);
                    $avancement_detail = $this->Avancement_physi_batimentManager->getavancementByconvention($value->id);
                    $montant_detail = $this->Batiment_constructionManager->getmontantByconvention($value->id);
                    if (count($avancement_detail)>0)
                   {
                      $avancement =  round((($avancement_detail[0]->avancement_physi_batiment+$avancement_detail[0]->avancement_physi_latrine+$avancement_detail[0]->avancement_physi_mobilier)),4) ; 
                    }
                    if (count($montant_detail)>0)
                    {
                        $montant =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob+$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet; 
                        $montant_trav_mob =  $montant_detail[0]->montant_bat+ $montant_detail[0]->montant_lat+$montant_detail[0]->montant_mob;
                        $montant_divers =$montant_detail[0]->montant_maitrise+$montant_detail[0]->montant_sousprojet;
                    }
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['feffi'] = $feffi;

                    $data[$key]['site'] = $site;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;                   
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_total'] = $montant;
                    $data[$key]['montant_trav_mob'] = $montant_trav_mob;
                    $data[$key]['montant_divers'] = $montant_divers;
                    $data[$key]['avancement'] = $avancement;                   
                    $data[$key]['date_creation'] = $value->date_creation;                   
                    $data[$key]['id_convention_ufpdaaf'] = $value->id_convention_ufpdaaf;
                    $data[$key]['ecole'] = $ecole;
                    
                }
            } 
                else
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
    public function index_post() 
    {
        $id = $this->post('id') ;
        $supprimer = $this->post('supprimer') ;
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'ref_convention' => $this->post('ref_convention'),
                    'objet' => $this->post('objet'),
                    'id_region' => $this->post('id_region'),
                    'id_cisco' => $this->post('id_cisco'),
                    'id_feffi' => $this->post('id_feffi'),
                    'id_site' => $this->post('id_site'),
                    'ref_financement' => $this->post('ref_financement'),
                    'montant_total' => $this->post('montant_total'),
                    //'avancement' => $this->post('avancement'),
                    'validation' => $this->post('validation'),
                    'id_convention_ufpdaaf' => null,
                    'type_convention' => $this->post('type_convention'),
                    'id_user' => $this->post('id_user')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Convention_cisco_feffi_enteteManager->add($data);
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
                $id_conv_ufp=null;
                if ($this->post('id_convention_ufpdaaf'))
                {
                    $id_conv_ufp=$this->post('id_convention_ufpdaaf');
                }
                $data = array(
                    'ref_convention' => $this->post('ref_convention'),
                    'objet' => $this->post('objet'),
                    'id_region' => $this->post('id_region'),
                    'id_cisco' => $this->post('id_cisco'),
                    'id_feffi' => $this->post('id_feffi'), 
                    'id_site' => $this->post('id_site'),
                    'ref_financement' => $this->post('ref_financement'),
                    'validation' => $this->post('validation'),
                    'id_convention_ufpdaaf' => $id_conv_ufp,
                    'montant_total' => $this->post('montant_total'),
                    //'avancement' => $this->post('avancement'),
                    'type_convention' => $this->post('type_convention'),
                    'id_user' => $this->post('id_user')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Convention_cisco_feffi_enteteManager->update($id, $data);
                if(!is_null($update)) {
                    $this->response([
                        'status' => TRUE,
                        'response' => 1,
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
            $delete = $this->Convention_cisco_feffi_enteteManager->delete($id);         
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

    public function generer_requete_date($date_debut,$date_fin)
    {
            $requete = "date_creation BETWEEN '".$date_debut."' AND '".$date_fin."' " ;
            
        return $requete ;
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
    public function generer_requete_convention_creer($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap)
    {
            $requete = "date_creation BETWEEN '".$date_debut."' AND '".$date_fin."' " ;
        
            

            if (($id_region!='*')&&($id_region!='undefined')&&($id_region!='null')) 
            {
                $requete = $requete." AND region.id='".$id_region."'" ;
            }

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

    public function generer_requete_date_signature($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap)
    {
            $requete = "convention_cisco_feffi_detail.date_signature BETWEEN '".$date_debut."' AND '".$date_fin."' " ;
        
            

            if (($id_region!='*')&&($id_region!='undefined')&&($id_region!='null')) 
            {
                $requete = $requete." AND region.id='".$id_region."'" ;
            }

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

    public function generer_requete2($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap)
    {
            $requete = "date_creation BETWEEN '".$date_debut."' AND '".$date_fin."' " ;
        
            

            if (($id_region!='*')&&($id_region!='undefined')&&($id_region!='null')) 
            {
                $requete = $requete." AND region.id='".$id_region."'" ;
            }

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
            $requete = "date_creation BETWEEN '".$date_debut."' AND '".$date_fin."' " ;
        
            

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
