<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Demande_batiment_bureau_etude extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_batiment_bureau_etude_model', 'Demande_batiment_bureau_etudeManager');
        $this->load->model('batiment_construction_model', 'Batiment_constructionManager');
        $this->load->model('tranche_demande_moe_model', 'Tranche_demande_moeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_batiment_construction = $this->get('id_batiment_construction');
        $menu = $this->get('menu');
        if ($menu=="getdemandeValidetechnique")
        {
            $tmp = $this->Demande_batiment_bureau_etudeManager->findAllValidetechnique();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $batiment_construction= array();
                    $batiment_construction = $this->Batiment_constructionManager->findById($value->id_batiment_construction);
                    $tranche_demande_moe = $this->Tranche_demande_moeManager->findById($value->id_tranche_demande_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['batiment_construction'] = $batiment_construction;
                   
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeValide")
        {
            $tmp = $this->Demande_batiment_bureau_etudeManager->findAllValide();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $batiment_construction= array();
                    $batiment_construction = $this->Batiment_constructionManager->findById($value->id_batiment_construction);
                    $tranche_demande_moe = $this->Tranche_demande_moeManager->findById($value->id_tranche_demande_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['batiment_construction'] = $batiment_construction;
                    $data[$key]['date_approbation'] = $value->date_approbation; 
                   
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeValidebcaf")
        {
            $tmp = $this->Demande_batiment_bureau_etudeManager->findAllValidebcaf();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $batiment_construction= array();
                    $batiment_construction = $this->Batiment_constructionManager->findById($value->id_batiment_construction);
                    $tranche_demande_moe = $this->Tranche_demande_moeManager->findById($value->id_tranche_demande_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['batiment_construction'] = $batiment_construction;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeInvalideBybatiment")
        {
            $tmp = $this->Demande_batiment_bureau_etudeManager->findAllInvalideBybatiment($id_batiment_construction);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $batiment_construction= array();
                    $batiment_construction = $this->Batiment_constructionManager->findById($value->id_batiment_construction);
                    $tranche_demande_moe = $this->Tranche_demande_moeManager->findById($value->id_tranche_demande_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['batiment_construction'] = $batiment_construction;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeInvalide")
        {
            $tmp = $this->Demande_batiment_bureau_etudeManager->findAllInvalide();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $batiment_construction= array();
                    $batiment_construction = $this->Batiment_constructionManager->findById($value->id_batiment_construction);
                    $tranche_demande_moe = $this->Tranche_demande_moeManager->findById($value->id_tranche_demande_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['batiment_construction'] = $batiment_construction;

                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $demande_batiment_bureau_etude = $this->Demande_batiment_bureau_etudeManager->findById($id);
            $batiment_construction = $this->Batiment_constructionManager->findById($demande_batiment_bureau_etude->id_batiment_construction);
            $tranche_demande_moe = $this->Tranche_demande_moeManager->findById($demande_batiment_bureau_etude->id_tranche_demande_moe);
            $data['id'] = $demande_batiment_bureau_etude->id;
            $data['objet'] = $demande_batiment_bureau_etude->objet;
            $data['description'] = $demande_batiment_bureau_etude->description;
            $data['ref_facture'] = $demande_batiment_bureau_etude->ref_facture;
            $data['montant'] = $demande_batiment_bureau_etude->montant;
            $data['tranche_demande_moe'] = $tranche_demande_moe;
            $data['cumul'] = $demande_batiment_bureau_etude->cumul;
            $data['anterieur'] = $demande_batiment_bureau_etude->anterieur;
            $data['reste'] = $demande_batiment_bureau_etude->reste;
            $data['date'] = $demande_batiment_bureau_etude->date;
            $data['batiment_construction'] = $batiment_construction;
        } 
        else 
        {
            $menu = $this->Demande_batiment_bureau_etudeManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $batiment_construction= array();
                    $batiment_construction = $this->Batiment_constructionManager->findById($value->id_batiment_construction);
                    $tranche_demande_moe = $this->Tranche_demande_moeManager->findById($value->id_tranche_demande_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_moe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['batiment_construction'] = $batiment_construction;

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
                    'id_tranche_demande_moe' => $this->post('id_tranche_demande_moe'),
                    'anterieur' => $this->post('anterieur'),
                    'cumul' => $this->post('cumul'),
                    'reste' => $this->post('reste'),
                    'id_batiment_construction' => $this->post('id_batiment_construction'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Demande_batiment_bureau_etudeManager->add($data);
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
                    'id_tranche_demande_moe' => $this->post('id_tranche_demande_moe'),
                    'anterieur' => $this->post('anterieur'),
                    'cumul' => $this->post('cumul'),
                    'reste' => $this->post('reste'),
                    'date' => $this->post('date'),
                    'id_batiment_construction' => $this->post('id_batiment_construction'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Demande_batiment_bureau_etudeManager->update($id, $data);
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
            $delete = $this->Demande_batiment_bureau_etudeManager->delete($id);         
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
