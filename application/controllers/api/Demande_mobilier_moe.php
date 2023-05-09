<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Demande_mobilier_moe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_mobilier_moe_model', 'Demande_mobilier_moeManager');
        $this->load->model('mobilier_construction_model', 'mobilier_constructionManager');
        $this->load->model('tranche_demande_mobilier_moe_model', 'Tranche_demande_mobilier_moeManager');
        $this->load->model('contrat_be_model', 'Contrat_beManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_mobilier_construction = $this->get('id_mobilier_construction');
        $id_cisco = $this->get('id_cisco');
        $menu = $this->get('menu');
      
        if ($menu=="getalldemandevalideBycisco")
        {
            $tmp = $this->Demande_mobilier_moeManager->findAlldemandevalideBycisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    /*$mobilier_construction= array();
                    $mobilier_construction = $this->mobilier_constructionManager->findById($value->id_mobilier_construction);*/
                     $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_mobilier_moe = $this->Tranche_demande_mobilier_moeManager->findById($value->id_tranche_demande_mobilier_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mobilier_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                   // $data[$key]['mobilier_construction'] = $mobilier_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;


                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getalldemandeinvalideBycisco")
        {
            $tmp = $this->Demande_mobilier_moeManager->findAlldemandeinvalideBycisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    /*$mobilier_construction= array();
                    $mobilier_construction = $this->mobilier_constructionManager->findById($value->id_mobilier_construction);*/
                     $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_mobilier_moe = $this->Tranche_demande_mobilier_moeManager->findById($value->id_tranche_demande_mobilier_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mobilier_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                   // $data[$key]['mobilier_construction'] = $mobilier_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;


                }
            } 
                else
                    $data = array();
        }
        /*if ($menu=="getalldemandeBymobilier")
        {
            $tmp = $this->Demande_mobilier_moeManager->findAllByMobilier($id_mobilier_construction);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $mobilier_construction= array();
                    $mobilier_construction = $this->mobilier_constructionManager->findById($value->id_mobilier_construction);
                    $tranche_demande_mobilier_moe = $this->Tranche_demande_mobilier_moeManager->findById($value->id_tranche_demande_mobilier_moe);
                     $contrat_bureau_etude = $this->Contrat_beManager->findByMobilier($value->id_mobilier_construction);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mobilier_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['mobilier_construction'] = $mobilier_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;

                }
            } 
                else
                    $data = array();
        }*/
        elseif ($menu=="getdemandeByValide")
        {
            $tmp = $this->Demande_mobilier_moeManager->findAllValide();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                   /* $mobilier_construction= array();
                    $mobilier_construction = $this->mobilier_constructionManager->findById($value->id_mobilier_construction);*/
                     $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_mobilier_moe = $this->Tranche_demande_mobilier_moeManager->findById($value->id_tranche_demande_mobilier_moe);
                     $contrat_bureau_etude = $this->Contrat_beManager->findByMobilier($value->id_mobilier_construction);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mobilier_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['mobilier_construction'] = $mobilier_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeByValidedpfi")
        {
            $tmp = $this->Demande_mobilier_moeManager->findAllValidedpfi();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    /*$mobilier_construction= array();
                    $mobilier_construction = $this->mobilier_constructionManager->findById($value->id_mobilier_construction);*/
                     $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_mobilier_moe = $this->Tranche_demande_mobilier_moeManager->findById($value->id_tranche_demande_mobilier_moe);
                     $contrat_bureau_etude = $this->Contrat_beManager->findByMobilier($value->id_mobilier_construction);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mobilier_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['mobilier_construction'] = $mobilier_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeByValidebcaf")
        {
            $tmp = $this->Demande_mobilier_moeManager->findAllValidebcaf();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                   /* $mobilier_construction= array();
                    $mobilier_construction = $this->mobilier_constructionManager->findById($value->id_mobilier_construction);*/
                     $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_mobilier_moe = $this->Tranche_demande_mobilier_moeManager->findById($value->id_tranche_demande_mobilier_moe);
                     $contrat_bureau_etude = $this->Contrat_beManager->findByMobilier($value->id_contrat_bureau_etude);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mobilier_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['mobilier_construction'] = $mobilier_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeByInvalide")
        {
            $tmp = $this->Demande_mobilier_moeManager->findAllInvalide();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    /*$mobilier_construction= array();
                    $mobilier_construction = $this->mobilier_constructionManager->findById($value->id_mobilier_construction);*/
                     $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_mobilier_moe = $this->Tranche_demande_mobilier_moeManager->findById($value->id_tranche_demande_mobilier_moe);
                     $contrat_bureau_etude = $this->Contrat_beManager->findByMobilier($value->id_contrat_bureau_etude);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mobilier_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['mobilier_construction'] = $mobilier_construction;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeInvalideBymobilier")
        {
            $tmp = $this->Demande_mobilier_moeManager->findAllInvalideBymobilier($id_mobilier_construction);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    /*$mobilier_construction= array();
                    $mobilier_construction = $this->mobilier_constructionManager->findById($value->id_mobilier_construction);*/
                     $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_mobilier_moe = $this->Tranche_demande_mobilier_moeManager->findById($value->id_tranche_demande_mobilier_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mobilier_moe;
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
        elseif ($id)
        {
            $data = array();
            $demande_mobilier_moe = $this->Demande_mobilier_moeManager->findById($id);
            /*$mobilier_construction = $this->mobilier_constructionManager->findById($demande_mobilier_moe->id_mobilier_construction);*/
             $contrat_bureau_etude = $this->Contrat_beManager->findById($demande_mobilier_moe->id_contrat_bureau_etude);
            $tranche_demande_mobilier_moe = $this->Tranche_demande_mobilier_moeManager->findById($demande_mobilier_moe->id_tranche_demande_mobilier_moe);
            $data['id'] = $demande_mobilier_moe->id;
            $data['objet'] = $demande_mobilier_moe->objet;
            $data['description'] = $demande_mobilier_moe->description;
            $data['ref_facture'] = $demande_mobilier_moe->ref_facture;
            $data['montant'] = $demande_mobilier_moe->montant;
            $data['tranche_demande_mobilier_moe'] = $tranche_demande_mobilier_moe;
            $data['cumul'] = $demande_mobilier_moe->cumul;
            $data['anterieur'] = $demande_mobilier_moe->anterieur;
            $data['reste'] = $demande_mobilier_moe->reste;
            $data['date'] = $demande_mobilier_moe->date;
            $data['validation'] = $demande_mobilier_moe->validation;
            $data['contrat_bureau_etude'] = $contrat_bureau_etude;
        } 
        else 
        {
            $menu = $this->Demande_mobilier_moeManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    /*$mobilier_construction= array();
                    $mobilier_construction = $this->mobilier_constructionManager->findById($value->id_mobilier_construction);*/
                     $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $tranche_demande_mobilier_moe = $this->Tranche_demande_mobilier_moeManager->findById($value->id_tranche_demande_mobilier_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mobilier_moe;
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
                    'id_tranche_demande_mobilier_moe' => $this->post('id_tranche_demande_mobilier_moe'),
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
                $dataId = $this->Demande_mobilier_moeManager->add($data);
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
                    'id_tranche_demande_mobilier_moe' => $this->post('id_tranche_demande_mobilier_moe'),
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
                $update = $this->Demande_mobilier_moeManager->update($id, $data);
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
            $delete = $this->Demande_mobilier_moeManager->delete($id);         
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
