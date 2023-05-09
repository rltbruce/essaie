<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Demande_latrine_moe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_latrine_moe_model', 'Demande_latrine_moeManager');
        $this->load->model('latrine_construction_model', 'latrine_constructionManager');
        $this->load->model('tranche_demande_latrine_moe_model', 'Tranche_demande_latrine_moeManager');
        $this->load->model('contrat_be_model', 'Contrat_beManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_latrine_construction = $this->get('id_latrine_construction');
        $id_cisco = $this->get('id_cisco');
        $id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');
        $menu = $this->get('menu');
       
        if ($menu=="getdemandedisponibleBycontrat")
        {
            $tmp = $this->Demande_latrine_moeManager->finddemandedisponibleBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_latrine_moe = $this->Tranche_demande_latrine_moeManager->findById($value->id_tranche_demande_latrine_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['latrine_construction'] = $latrine_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeBycontrat")
        {
            $tmp = $this->Demande_latrine_moeManager->finddemandeBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_latrine_moe = $this->Tranche_demande_latrine_moeManager->findById($value->id_tranche_demande_latrine_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['latrine_construction'] = $latrine_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandevalideBycontrat")
        {
            $tmp = $this->Demande_latrine_moeManager->finddemandevalideBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_latrine_moe = $this->Tranche_demande_latrine_moeManager->findById($value->id_tranche_demande_latrine_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['latrine_construction'] = $latrine_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandevalidebcafBycontrat")
        {
            $tmp = $this->Demande_latrine_moeManager->finddemandevalidebcafBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_latrine_moe = $this->Tranche_demande_latrine_moeManager->findById($value->id_tranche_demande_latrine_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['latrine_construction'] = $latrine_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeinvalideBycontrat")
        {
            $tmp = $this->Demande_latrine_moeManager->finddemandeinvalideBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_latrine_moe = $this->Tranche_demande_latrine_moeManager->findById($value->id_tranche_demande_latrine_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['latrine_construction'] = $latrine_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;

                }
            } 
                else
                    $data = array();
        }





        elseif ($menu=='getdemandeemidpfiBycontrat') //mande
        {
            $tmp = $this->Demande_latrine_moeManager->finddemandeemidpfiByIdcontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_latrine_moe = $this->Tranche_demande_latrine_moeManager->findById($value->id_tranche_demande_latrine_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                     $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;
                }
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getdemandecreerBycontrat') //mande
        {
            $tmp = $this->Demande_latrine_moeManager->findcreerByIdcontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_latrine_moe = $this->Tranche_demande_latrine_moeManager->findById($value->id_tranche_demande_latrine_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_d_fin_travaux_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                     $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;
                }
            } 
                else
                    $data = array();
        }
        /*if ($menu=="getdemandedisponibleBycontrat")
        {
            $tmp = $this->Demande_latrine_moeManager->finddemandedisponibleBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                   
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_latrine_moe = $this->Tranche_demande_latrine_moeManager->findById($value->id_tranche_demande_latrine_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                   // $data[$key]['latrine_construction'] = $latrine_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getalldemandevalideBycisco")
        {
            $tmp = $this->Demande_latrine_moeManager->findAlldemandevalideBycisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                   
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_latrine_moe = $this->Tranche_demande_latrine_moeManager->findById($value->id_tranche_demande_latrine_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                   // $data[$key]['latrine_construction'] = $latrine_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getalldemandeinvalideBycisco")
        {
            $tmp = $this->Demande_latrine_moeManager->findAlldemandeinvalideBycisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                     $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_latrine_moe = $this->Tranche_demande_latrine_moeManager->findById($value->id_tranche_demande_latrine_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                   // $data[$key]['latrine_construction'] = $latrine_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeByValide")
        {
            $tmp = $this->Demande_latrine_moeManager->findAllValide();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                     $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_latrine_moe = $this->Tranche_demande_latrine_moeManager->findById($value->id_tranche_demande_latrine_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['latrine_construction'] = $latrine_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeByValidedpfi")
        {
            $tmp = $this->Demande_latrine_moeManager->findAllValidedpfi();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                     $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_latrine_moe = $this->Tranche_demande_latrine_moeManager->findById($value->id_tranche_demande_latrine_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['latrine_construction'] = $latrine_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeByValidebcaf")
        {
            $tmp = $this->Demande_latrine_moeManager->findAllValidebcaf();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                     $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_latrine_moe = $this->Tranche_demande_latrine_moeManager->findById($value->id_tranche_demande_latrine_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['latrine_construction'] = $latrine_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeByInvalide")
        {
            $tmp = $this->Demande_latrine_moeManager->findAllInvalide();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                     $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_latrine_moe = $this->Tranche_demande_latrine_moeManager->findById($value->id_tranche_demande_latrine_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['latrine_construction'] = $latrine_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;


                }
            } 
                else
                    $data = array();
        }*/
       /* elseif ($menu=="getdemandeInvalideBylatrine")
        {
            $tmp = $this->Demande_latrine_moeManager->findAllInvalideBylatrine($id_latrine_construction);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {*/
                    /*$latrine_construction= array();
                    $latrine_construction = $this->latrine_constructionManager->findById($value->id_latrine_construction);*/
                    /*$contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_latrine_moe = $this->Tranche_demande_latrine_moeManager->findById($value->id_tranche_demande_latrine_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;

                }
            } 
                else
                    $data = array();
        }*/
        elseif ($id)
        {
            $data = array();
            $demande_latrine_moe = $this->Demande_latrine_moeManager->findById($id);
            //$latrine_construction = $this->latrine_constructionManager->findById($demande_latrine_moe->id_latrine_construction);
            $contrat_bureau_etude = $this->Contrat_beManager->findById($demande_latrine_moe->id_contrat_bureau_etude);
            $tranche_demande_latrine_moe = $this->Tranche_demande_latrine_moeManager->findById($demande_latrine_moe->id_tranche_demande_latrine_moe);
            $data['id'] = $demande_latrine_moe->id;
            $data['objet'] = $demande_latrine_moe->objet;
            $data['description'] = $demande_latrine_moe->description;
            $data['ref_facture'] = $demande_latrine_moe->ref_facture;
            $data['montant'] = $demande_latrine_moe->montant;
            $data['tranche_demande_latrine_moe'] = $tranche_demande_latrine_moe;
            $data['cumul'] = $demande_latrine_moe->cumul;
            $data['anterieur'] = $demande_latrine_moe->anterieur;
            $data['reste'] = $demande_latrine_moe->reste;
            $data['date'] = $demande_latrine_moe->date;
            $data['validation'] = $demande_latrine_moe->validation;
            $data['contrat_bureau_etude'] = $contrat_bureau_etude;
        } 
        else 
        {
            $menu = $this->Demande_latrine_moeManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    /*$latrine_construction= array();
                    $latrine_construction = $this->latrine_constructionManager->findById($value->id_latrine_construction);*/
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_latrine_moe = $this->Tranche_demande_latrine_moeManager->findById($value->id_tranche_demande_latrine_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_latrine_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;

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
                    'objet' => $this->post('objet'),
                    'description' => $this->post('description'),
                    'ref_facture' => $this->post('ref_facture'),
                    'date' => $this->post('date'),
                    'montant' => $this->post('montant'),
                    'id_tranche_demande_latrine_moe' => $this->post('id_tranche_demande_latrine_moe'),
                    'anterieur' => $this->post('anterieur'),
                    'cumul' => $this->post('cumul'),
                    'reste' => $this->post('reste'),
                    'id_contrat_bureau_etude' => $this->post('id_contrat_bureau_etude'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Demande_latrine_moeManager->add($data);
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
                    'objet' => $this->post('objet'),
                    'description' => $this->post('description'),
                    'ref_facture' => $this->post('ref_facture'),
                    'montant' => $this->post('montant'),
                    'id_tranche_demande_latrine_moe' => $this->post('id_tranche_demande_latrine_moe'),
                    'anterieur' => $this->post('anterieur'),
                    'cumul' => $this->post('cumul'),
                    'reste' => $this->post('reste'),
                    'date' => $this->post('date'),
                    'id_contrat_bureau_etude' => $this->post('id_contrat_bureau_etude'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Demande_latrine_moeManager->update($id, $data);
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
            $delete = $this->Demande_latrine_moeManager->delete($id);         
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
