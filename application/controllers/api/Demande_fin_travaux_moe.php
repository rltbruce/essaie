<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Demande_fin_travaux_moe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_fin_travaux_moe_model', 'Demande_fin_travaux_moeManager');
        $this->load->model('contrat_be_model', 'Contrat_beManager');
        $this->load->model('tranche_d_fin_travaux_moe_model', 'Tranche_d_fin_travaux_moeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');
        $id_cisco = $this->get('id_cisco');
        $menu = $this->get('menu');
        
        if ($menu=="getdemandedisponibleBycontrat")
        {
            $tmp = $this->Demande_fin_travaux_moeManager->finddemandedisponibleBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_d_fin_travaux_moe = $this->Tranche_d_fin_travaux_moeManager->findById($value->id_tranche_d_fin_travaux_moe);
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
        elseif ($menu=="getdemandeBycontrat")
        {
            $tmp = $this->Demande_fin_travaux_moeManager->finddemandeBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_d_fin_travaux_moe = $this->Tranche_d_fin_travaux_moeManager->findById($value->id_tranche_d_fin_travaux_moe);
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
        elseif ($menu=="getdemandeinvalideBycontrat")
        {
            $tmp = $this->Demande_fin_travaux_moeManager->finddemandeinvalideBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_d_fin_travaux_moe = $this->Tranche_d_fin_travaux_moeManager->findById($value->id_tranche_d_fin_travaux_moe);
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
        elseif ($menu=="getdemandevalidebcafBycontrat")
        {
            $tmp = $this->Demande_fin_travaux_moeManager->finddemandevalidebcafBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_d_fin_travaux_moe = $this->Tranche_d_fin_travaux_moeManager->findById($value->id_tranche_d_fin_travaux_moe);
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
        elseif ($menu=="summePourcentageCurrent")
        {
            $tmp = $this->Demande_fin_travaux_moeManager->summePourcentageCurrent($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {   
                    $pourcentage_bat=0;
                    $pourcentage_lat=0;
                    //$pourcentage_mob=0;
                    $pourcentage_fin_travaux=0;
                    $ourcentage_tranche_fin_travaux=0;

                    if ($value->pourcentage_fin_travaux)
                    {
                        $pourcentage_fin_travaux = $value->pourcentage_fin_travaux;
                    }
                    /*if ($value->pourcentage_mob)
                    {
                        $pourcentage_mob = $value->pourcentage_mob;
                    }*/
                    if ($value->pourcentage_lat)
                    {
                        $pourcentage_lat = $value->pourcentage_lat;
                    }
                    if ($value->pourcentage_bat)
                    {
                        $pourcentage_bat = $value->pourcentage_bat;
                    }
                    if ($value->pourcentage_tranche_fin_travaux)
                    {
                        $pourcentage_tranche_fin_travaux = $value->pourcentage_tranche_fin_travaux;
                    }

                    $data[$key]['pourcentage_fin_travaux'] = $pourcentage_fin_travaux;
                    $data[$key]['pourcentage_bat'] = $pourcentage_bat;
                    $data[$key]['pourcentage_lat'] = $pourcentage_lat;
                    //$data[$key]['pourcentage_mob'] = $pourcentage_mob;
                    $data[$key]['pourcentage_tranche_fin_travaux'] = $pourcentage_tranche_fin_travaux;

                    $data[$key]['pourcentage_total'] = intval($pourcentage_fin_travaux) +intval($pourcentage_tranche_fin_travaux) + intval($pourcentage_bat) + intval($pourcentage_lat);

                }
            } 
                else
                    $data = array();
        }




        elseif ($menu=='getdemandeemidpfiBycontrat') //mande
        {
            $tmp = $this->Demande_fin_travaux_moeManager->finddemandeemidpfiByIdcontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_d_fin_travaux_moe = $this->Tranche_d_fin_travaux_moeManager->findById($value->id_tranche_d_fin_travaux_moe);
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

        elseif ($menu=='getdemandecreerBycontrat') //mande
        {
            $tmp = $this->Demande_fin_travaux_moeManager->findcreerByIdcontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_d_fin_travaux_moe = $this->Tranche_d_fin_travaux_moeManager->findById($value->id_tranche_d_fin_travaux_moe);
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
       /* if ($menu=="getdemandedisponibleBycontrat")
        {
            $tmp = $this->Demande_fin_travaux_moeManager->finddemandedisponibleBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_d_fin_travaux_moe = $this->Tranche_d_fin_travaux_moeManager->findById($value->id_tranche_d_fin_travaux_moe);
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
        elseif ($menu=="getalldemandevalideBycisco")
        {
            $tmp = $this->Demande_fin_travaux_moeManager->findAllValideBycisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_d_fin_travaux_moe = $this->Tranche_d_fin_travaux_moeManager->findById($value->id_tranche_d_fin_travaux_moe);
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
        elseif ($menu=="getalldemandeinvalideBycisco")
        {
            $tmp = $this->Demande_fin_travaux_moeManager->findAllInvalideBycisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_d_fin_travaux_moe = $this->Tranche_d_fin_travaux_moeManager->findById($value->id_tranche_d_fin_travaux_moe);
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
        
        elseif ($menu=="getalldemandeByContrat")
        {
            $tmp = $this->Demande_fin_travaux_moeManager->findAllBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_d_fin_travaux_moe = $this->Tranche_d_fin_travaux_moeManager->findById($value->id_tranche_d_fin_travaux_moe);
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
        }elseif ($menu=="getdemandeByValide")
        {
            $tmp = $this->Demande_fin_travaux_moeManager->findAllValide();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_d_fin_travaux_moe = $this->Tranche_d_fin_travaux_moeManager->findById($value->id_tranche_d_fin_travaux_moe);
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
        }elseif ($menu=="getdemandeByValidedpfi")
        {
            $tmp = $this->Demande_fin_travaux_moeManager->findAllValidedpfi();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_d_fin_travaux_moe = $this->Tranche_d_fin_travaux_moeManager->findById($value->id_tranche_d_fin_travaux_moe);
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
        }elseif ($menu=="getdemandeByValidebcaf")
        {
            $tmp = $this->Demande_fin_travaux_moeManager->findAllValidebcaf();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_d_fin_travaux_moe = $this->Tranche_d_fin_travaux_moeManager->findById($value->id_tranche_d_fin_travaux_moe);
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
        }elseif ($menu=="getdemandeByInvalide")
        {
            $tmp = $this->Demande_fin_travaux_moeManager->findAllInvalide();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_d_fin_travaux_moe = $this->Tranche_d_fin_travaux_moeManager->findById($value->id_tranche_d_fin_travaux_moe);
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
        }elseif ($menu=="getdemandeByContrat_bureau_etude")
        {
            $tmp = $this->Demande_fin_travaux_moeManager->findAllInvalideBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_d_fin_travaux_moe = $this->Tranche_d_fin_travaux_moeManager->findById($value->id_tranche_d_fin_travaux_moe);
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
        }*/
        elseif ($id)
        {
            $data = array();
            $demande_fin_travaux_moe = $this->Demande_fin_travaux_moeManager->findById($id);
            $contrat_bureau_etude = $this->Contrat_beManager->findById($demande_fin_travaux_moe->id_contrat_bureau_etude);
            $tranche_d_fin_travaux_moe = $this->Tranche_d_fin_travaux_moeManager->findById($demande_fin_travaux_moe->id_tranche_d_fin_travaux_moe);
            $data['id'] = $demande_fin_travaux_moe->id;
            $data['objet'] = $demande_fin_travaux_moe->objet;
            $data['description'] = $demande_fin_travaux_moe->description;
            $data['ref_facture'] = $demande_fin_travaux_moe->ref_facture;
            $data['montant'] = $demande_fin_travaux_moe->montant;
            $data['tranche_d_fin_travaux_moe'] = $tranche_d_fin_travaux_moe;
            $data['cumul'] = $demande_fin_travaux_moe->cumul;
            $data['anterieur'] = $demande_fin_travaux_moe->anterieur;
            $data['reste'] = $demande_fin_travaux_moe->reste;
            $data['date'] = $demande_fin_travaux_moe->date;
            $data['validation'] = $demande_fin_travaux_moe->validation;
            $data['contrat_bureau_etude'] = $contrat_bureau_etude;
        } 
        else 
        {
            $menu = $this->Demande_fin_travaux_moeManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_d_fin_travaux_moe = $this->Tranche_d_fin_travaux_moeManager->findById($value->id_tranche_d_fin_travaux_moe);
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
                    'id_tranche_d_fin_travaux_moe' => $this->post('id_tranche_d_fin_travaux_moe'),
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
                $dataId = $this->Demande_fin_travaux_moeManager->add($data);
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
                    'id_tranche_d_fin_travaux_moe' => $this->post('id_tranche_d_fin_travaux_moe'),
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
                $update = $this->Demande_fin_travaux_moeManager->update($id, $data);
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
            $delete = $this->Demande_fin_travaux_moeManager->delete($id);         
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
