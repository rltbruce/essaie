<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Site extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('site_model', 'SiteManager');
        $this->load->model('region_model', 'RegionManager');
        $this->load->model('cisco_model', 'CiscoManager');
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('zap_model', 'ZapManager');
        $this->load->model('ecole_model', 'EcoleManager');
        $this->load->model('classification_site_model', 'Classification_siteManager');
        $this->load->model('agence_acc_model', 'Agence_accManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');

        $lot = $this->get('lot');
        $id_region = $this->get('id_region');
        $id_cisco = $this->get('id_cisco');
        $id_commune = $this->get('id_commune');
        $id_zap = $this->get('id_zap');
        $id_ecole = $this->get('id_ecole');
        $id_feffi = $this->get('id_feffi');
        $menu = $this->get('menu');
        $id_site = $this->get('id_site');

        
        if ($menu=='testIfinvalide') 
        {   $data = array();
            $tmp = $this->SiteManager->findsiteByIdandvalide($id_site);
            if ($tmp) 
            {
                $data=$tmp;
            }
        }
        elseif ($menu=='getsiteByenpreparationinvalide') 
        {   $data = array();
            $tmp = $this->SiteManager->findsiteByenpreparationinvalide($this->generer_requete($id_region,$id_cisco,$id_commune,$id_ecole,$lot,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $classification_site = $this->Classification_siteManager->findById($value->id_classification_site);
                    $agence_acc = $this->Agence_accManager->findById($value->id_agence_acc);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $zap = $this->ZapManager->findById($value->id_zap);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code_sous_projet'] = $value->code_sous_projet;
                    $data[$key]['objet_sous_projet'] = $value->objet_sous_projet;
                   // //$data[$key]['denomination_epp'] = $value->denomination_epp;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['statu_convention'] = $value->statu_convention;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['classification_site'] = $classification_site;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['acces'] = $value->acces;
                    $data[$key]['agence_acc'] = $agence_acc;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['commune'] = $commune;
                    $data[$key]['zap'] = $zap;
                }
            }
        }
        elseif ($menu=='getsiteByenpreparationandinvalide') 
        {   $data = array();
            $tmp = $this->SiteManager->findsiteByenpreparationandinvalide($this->generer_requete($id_region,$id_cisco,$id_commune,$id_ecole,$lot,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $classification_site = $this->Classification_siteManager->findById($value->id_classification_site);
                    $agence_acc = $this->Agence_accManager->findById($value->id_agence_acc);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $zap = $this->ZapManager->findById($value->id_zap);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code_sous_projet'] = $value->code_sous_projet;
                    $data[$key]['objet_sous_projet'] = $value->objet_sous_projet;
                   // //$data[$key]['denomination_epp'] = $value->denomination_epp;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['statu_convention'] = $value->statu_convention;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['classification_site'] = $classification_site;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['acces'] = $value->acces;
                    $data[$key]['agence_acc'] = $agence_acc;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['commune'] = $commune;
                    $data[$key]['zap'] = $zap;
                }
            }
        }        
        elseif ($menu=='getsitecreeByfeffi') 
        {   $data = array();
            $tmp = $this->SiteManager->findsitecreeByfeffi($id_feffi);
            if ($tmp) 
            {
                $data=$tmp;
                
            }
        }
        elseif ($menu=='getsite_etat') 
        {   $data = array();
            $tmp = $this->SiteManager->findsite_etat($this->generer_requete2($id_region,$id_cisco,$id_commune,$id_ecole,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $classification_site = $this->Classification_siteManager->findById($value->id_classification_site);
                    $agence_acc = $this->Agence_accManager->findById($value->id_agence_acc);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $zap = $this->ZapManager->findById($value->id_zap);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code_sous_projet'] = $value->code_sous_projet;
                    $data[$key]['objet_sous_projet'] = $value->objet_sous_projet;
                   // //$data[$key]['denomination_epp'] = $value->denomination_epp;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['statu_convention'] = $value->statu_convention;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['classification_site'] = $classification_site;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['acces'] = $value->acces;
                    $data[$key]['agence_acc'] = $agence_acc;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['commune'] = $commune;
                    $data[$key]['zap'] = $zap;
                
                }
            }else $data = array();
        }        
        elseif ($menu=='getsiteByfiltre') 
        {   $data = array();
            $tmp = $this->SiteManager->findsiteByfiltre($this->generer_requete($id_region,$id_cisco,$id_commune,$id_ecole,$lot,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $classification_site = $this->Classification_siteManager->findById($value->id_classification_site);
                    $agence_acc = $this->Agence_accManager->findById($value->id_agence_acc);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $zap = $this->ZapManager->findById($value->id_zap);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code_sous_projet'] = $value->code_sous_projet;
                    $data[$key]['objet_sous_projet'] = $value->objet_sous_projet;
                   // //$data[$key]['denomination_epp'] = $value->denomination_epp;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['statu_convention'] = $value->statu_convention;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['classification_site'] = $classification_site;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['acces'] = $value->acces;
                    $data[$key]['agence_acc'] = $agence_acc;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['commune'] = $commune;
                    $data[$key]['zap'] = $zap;
                
                }
            }else $data=array();
        }
            
      /*  if ($menu=='getsite_disponible') 
        {   $data = array();
            $tmp = $this->SiteManager->findsite_disponible($this->generer_requete2($id_region,$id_cisco,$id_commune,$id_ecole,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $classification_site = $this->Classification_siteManager->findById($value->id_classification_site);
                    $agence_acc = $this->Agence_accManager->findById($value->id_agence_acc);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $zap = $this->ZapManager->findById($value->id_zap);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code_sous_projet'] = $value->code_sous_projet;
                    $data[$key]['objet_sous_projet'] = $value->objet_sous_projet;
                   // //$data[$key]['denomination_epp'] = $value->denomination_epp;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['statu_convention'] = $value->statu_convention;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['classification_site'] = $classification_site;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['acces'] = $value->acces;
                    $data[$key]['agence_acc'] = $agence_acc;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['commune'] = $commune;
                    $data[$key]['zap'] = $zap;
                
                }
            }else $data = array();
        }
        elseif ($menu=='getsiteByfiltreinvalide') 
        {   $data = array();
            $tmp = $this->SiteManager->findsiteByfiltreinvalide($this->generer_requete($id_region,$id_cisco,$id_commune,$id_ecole,$lot,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $classification_site = $this->Classification_siteManager->findById($value->id_classification_site);
                    $agence_acc = $this->Agence_accManager->findById($value->id_agence_acc);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $zap = $this->ZapManager->findById($value->id_zap);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code_sous_projet'] = $value->code_sous_projet;
                    $data[$key]['objet_sous_projet'] = $value->objet_sous_projet;
                    ////$data[$key]['denomination_epp'] = $value->denomination_epp;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['statu_convention'] = $value->statu_convention;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['classification_site'] = $classification_site;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['acces'] = $value->acces;
                    $data[$key]['agence_acc'] = $agence_acc;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['commune'] = $commune;
                    $data[$key]['zap'] = $zap;
                
                }
            }else $data[0]=$this->generer_requete($id_region,$id_cisco,$id_commune,$id_ecole,$lot,$id_zap);
        }
        elseif ($menu=='getsiteByfiltre') 
        {   $data = array();
            $tmp = $this->SiteManager->findsiteByfiltre($this->generer_requete($id_region,$id_cisco,$id_commune,$id_ecole,$lot,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $classification_site = $this->Classification_siteManager->findById($value->id_classification_site);
                    $agence_acc = $this->Agence_accManager->findById($value->id_agence_acc);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $zap = $this->ZapManager->findById($value->id_zap);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code_sous_projet'] = $value->code_sous_projet;
                    $data[$key]['objet_sous_projet'] = $value->objet_sous_projet;
                   // //$data[$key]['denomination_epp'] = $value->denomination_epp;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['statu_convention'] = $value->statu_convention;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['classification_site'] = $classification_site;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['acces'] = $value->acces;
                    $data[$key]['agence_acc'] = $agence_acc;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['commune'] = $commune;
                    $data[$key]['zap'] = $zap;
                
                }
            }else $data[0]=$this->generer_requete($id_region,$id_cisco,$id_commune,$id_ecole,$lot,$id_zap);
        }
        else*/
      /*  elseif ($menu=='getsiteInvalide') 
        {   $data = array();
            $tmp = $this->SiteManager->findsiteInvalide();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $classification_site = $this->Classification_siteManager->findById($value->id_classification_site);
                    $agence_acc = $this->Agence_accManager->findById($value->id_agence_acc);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $zap = $this->ZapManager->findById($value->id_zap);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code_sous_projet'] = $value->code_sous_projet;
                    $data[$key]['objet_sous_projet'] = $value->objet_sous_projet;
                    //$data[$key]['denomination_epp'] = $value->denomination_epp;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['statu_convention'] = $value->statu_convention;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['classification_site'] = $classification_site;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['acces'] = $value->acces;
                    $data[$key]['agence_acc'] = $agence_acc;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['commune'] = $commune;
                    $data[$key]['zap'] = $zap;
                
                }
            }
        }
        elseif ($menu=='getsiteByenpreparation') 
        {   $data = array();
            $tmp = $this->SiteManager->findsiteByenpreparation($id_feffi);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $classification_site = $this->Classification_siteManager->findById($value->id_classification_site);
                    $agence_acc = $this->Agence_accManager->findById($value->id_agence_acc);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $zap = $this->ZapManager->findById($value->id_zap);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code_sous_projet'] = $value->code_sous_projet;
                    $data[$key]['objet_sous_projet'] = $value->objet_sous_projet;
                    //$data[$key]['denomination_epp'] = $value->denomination_epp;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['statu_convention'] = $value->statu_convention;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['classification_site'] = $classification_site;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['acces'] = $value->acces;
                    $data[$key]['agence_acc'] = $agence_acc;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['commune'] = $commune;
                    $data[$key]['zap'] = $zap;
                
                }
            }
        }
        elseif ($id_ecole) 
        {   $data = array();
            $tmp = $this->SiteManager->findByecole($id_ecole);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = array();
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $classification_site = $this->Classification_siteManager->findById($value->id_classification_site);
                    $agence_acc = $this->Agence_accManager->findById($value->id_agence_acc);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $zap = $this->ZapManager->findById($value->id_zap);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code_sous_projet'] = $value->code_sous_projet;
                    $data[$key]['objet_sous_projet'] = $value->objet_sous_projet;
                    //$data[$key]['denomination_epp'] = $value->denomination_epp;
                    $data[$key]['statu_convention'] = $value->statu_convention;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['classification_site'] = $classification_site;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['acces'] = $value->acces;
                    $data[$key]['agence_acc'] = $agence_acc;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['commune'] = $commune;
                    $data[$key]['zap'] = $zap;
                }
            }
        }*/
        elseif ($id)
        {
            $data = array();
            $site = $this->SiteManager->findById($id);
            $ecole = $this->EcoleManager->findById($site->id_ecole);
            $classification_site = $this->Classification_siteManager->findById($site->id_classification_site);
            $agence_acc = $this->Agence_accManager->findById($site->id_agence_acc);
            $region = $this->RegionManager->findById($site->id_region);
            $cisco = $this->CiscoManager->findById($site->id_cisco);
            $commune = $this->CommuneManager->findById($site->id_commune);
            $zap = $this->ZapManager->findById($site->id_zap);
            $data['id'] = $site->id;
            $data['code_sous_projet'] = $site->code_sous_projet;
            $data['objet_sous_projet'] = $site->objet_sous_projet;
            //$data['denomination_epp'] = $site->denomination_epp;
            $data['statu_convention'] = $site->statu_convention;
            $data['observation'] = $site->observation;
            $data['ecole'] = $ecole;
            $data['classification_site'] = $classification_site;
            $data['lot'] = $site->lot;
            $data['validation'] = $site->validation;
            $data['acces'] = $site->acces;
            $data['agence_acc'] = $agence_acc;
            $data['region'] = $region;
            $data['cisco'] = $cisco;
            $data['commune'] = $commune;
            $data['zap'] = $zap;
        } 
        else 
        {
            $tmp = $this->SiteManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = array();
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $classification_site = $this->Classification_siteManager->findById($value->id_classification_site);
                    $agence_acc = $this->Agence_accManager->findById($value->id_agence_acc);
                    $region = $this->RegionManager->findById($value->id_region);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $zap = $this->ZapManager->findById($value->id_zap);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code_sous_projet'] = $value->code_sous_projet;
                    $data[$key]['objet_sous_projet'] = $value->objet_sous_projet;
                    //$data[$key]['denomination_epp'] = $value->denomination_epp;
                    $data[$key]['statu_convention'] = $value->statu_convention;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                    $data[$key]['classification_site'] = $classification_site;
                    $data[$key]['lot'] = $value->lot;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['acces'] = $value->acces;
                    $data[$key]['agence_acc'] = $agence_acc;
                    $data[$key]['region'] = $region;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['commune'] = $commune;
                    $data[$key]['zap'] = $zap;
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
                    'code_sous_projet' => $this->post('code_sous_projet'),
                    'objet_sous_projet' => $this->post('objet_sous_projet'),
                    //'denomination_epp' => $this->post('denomination_epp'),
                    'id_agence_acc' => $this->post('id_agence_acc'),
                    'statu_convention' => $this->post('statu_convention'),
                    'observation' => $this->post('observation'),
                    'id_region' => $this->post('id_region'),
                    'id_cisco' => $this->post('id_cisco'),
                    'id_commune' => $this->post('id_commune'),
                    'id_zap' => $this->post('id_zap'),
                    'id_ecole' => $this->post('id_ecole'),
                    'id_classification_site' => $this->post('id_classification_site'),
                    'lot' => $this->post('lot'),
                    'validation' => $this->post('validation'),
                    'acces' => $this->post('acces')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->SiteManager->add($data);
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
                    'code_sous_projet' => $this->post('code_sous_projet'),
                    'objet_sous_projet' => $this->post('objet_sous_projet'),
                    //'denomination_epp' => $this->post('denomination_epp'),
                    'id_agence_acc' => $this->post('id_agence_acc'),
                    'statu_convention' => $this->post('statu_convention'),
                    'observation' => $this->post('observation'),
                    'id_region' => $this->post('id_region'),
                    'id_cisco' => $this->post('id_cisco'),
                    'id_commune' => $this->post('id_commune'),
                    'id_zap' => $this->post('id_zap'),
                    'id_ecole' => $this->post('id_ecole'),
                    'id_classification_site' => $this->post('id_classification_site'),
                    'lot' => $this->post('lot'),
                    'validation' => $this->post('validation'),
                    'acces' => $this->post('acces')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->SiteManager->update($id, $data);
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
            $delete = $this->SiteManager->delete($id);         
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
    public function generer_requete2($id_region,$id_cisco,$id_commune,$id_ecole,$id_zap)
    {            
        
            $requete = "id_region='".$id_region."'" ;
           

            if (($id_cisco!='*')&&($id_cisco!='undefined')&&($id_cisco!='null')) 
            {
                $requete = $requete." AND id_cisco='".$id_cisco."'" ;
            }

            if (($id_commune!='*')&&($id_commune!='undefined')&&($id_commune!='null')) 
            {
                $requete = $requete." AND id_commune='".$id_commune."'" ;
            }

            if (($id_ecole!='*')&&($id_ecole!='undefined')&&($id_ecole!='null')) 
            {
                $requete = $requete." AND id_ecole='".$id_ecole."'" ;
            }

            if (($id_zap!='*')&&($id_zap!='undefined')&&($id_zap!='null')) 
            {
                $requete = $requete." AND id_zap='".$id_zap."'" ;
            }
            
        return $requete ;
    }

    public function generer_requete($id_region,$id_cisco,$id_commune,$id_ecole,$lot,$id_zap)
    {            
        
            $requete = "id_region='".$id_region."'" ;
           

            if (($id_cisco!='*')&&($id_cisco!='undefined')&&($id_cisco!='null')) 
            {
                $requete = $requete." AND id_cisco='".$id_cisco."'" ;
            }

            if (($id_commune!='*')&&($id_commune!='undefined')&&($id_commune!='null')) 
            {
                $requete = $requete." AND id_commune='".$id_commune."'" ;
            }

            if (($id_ecole!='*')&&($id_ecole!='undefined')&&($id_ecole!='null')) 
            {
                $requete = $requete." AND id_ecole='".$id_ecole."'" ;
            }
            if (($lot!='*')&&($lot!='undefined')&&($lot!='null')) 
            {
                $requete = $requete." AND lot='".$lot."'" ;
            }

            if (($id_zap!='*')&&($id_zap!='undefined')&&($id_zap!='null')) 
            {
                $requete = $requete." AND id_zap='".$id_zap."'" ;
            }
            
        return $requete ;
    }
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
