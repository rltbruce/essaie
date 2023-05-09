<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Demande_latrine_mpe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_latrine_mpe_model', 'Demande_latrine_mpeManager');
        $this->load->model('latrine_construction_model', 'Batiment_constructionManager');
        $this->load->model('tranche_demande_mpe_model', 'Tranche_demande_mpeManager');
        $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        $this->load->model('type_latrine_model', 'Type_latrineManager');
        $this->load->model('facture_mpe_model', 'Facture_mpeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_latrine_construction = $this->get('id_latrine_construction');
        $id_demande_latrine_mpe = $this->get('id_demande_latrine_mpe');
        $id_tranche_demande_mpe = $this->get('id_tranche_demande_mpe');
        $tranche_numero = $this->get('tranche_numero');
        $id_pv_consta_entete_travaux = $this->get('id_pv_consta_entete_travaux');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $menu = $this->get('menu');

        if ($menu=="getdemandeBypv_consta_entete")
        {
            $tmp = $this->Demande_latrine_mpeManager->finddemandeBypv_consta_entete($id_pv_consta_entete_travaux);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($value->id_tranche_demande_mpe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mpe;
                    $data[$key]['id_pv_consta_entete_travaux'] = $value->id_pv_consta_entete_travaux;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandevalideById")
        {
            $tmp = $this->Demande_latrine_mpeManager->getdemandevalideById($id_demande_latrine_mpe);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeByContratTranche")
        {
            $tmp = $this->Demande_latrine_mpeManager->getdemandeByContratTranche($id_tranche_demande_mpe,$id_contrat_prestataire);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeByContratTranchenumero")
        {
            $tmp = $this->Demande_latrine_mpeManager->getdemandeByContratTranchenumero($tranche_numero,$id_contrat_prestataire);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $demande_latrine_prestataire = $this->Demande_latrine_mpeManager->findById($id);
            $latrine_construction = $this->Batiment_constructionManager->findById($demande_latrine_prestataire->id_latrine_construction);
            $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($demande_latrine_prestataire->id_tranche_demande_mpe);
            $data['id'] = $demande_latrine_prestataire->id;
            $data['montant'] = $demande_latrine_prestataire->montant;
            $data['tranche_demande_mpe'] = $tranche_demande_mpe;
            $data['cumul'] = $demande_latrine_prestataire->cumul;
            $data['anterieur'] = $demande_latrine_prestataire->anterieur;
            $data['reste'] = $demande_latrine_prestataire->reste;
        } 
        else 
        {
            $menu = $this->Demande_latrine_mpeManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $latrine_construction= array();
                    $latrine_construction = $this->Batiment_constructionManager->findById($value->id_latrine_construction);
                    $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($value->id_tranche_demande_mpe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;

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
                    'montant' => $this->post('montant'),
                    'id_tranche_demande_mpe' => $this->post('id_tranche_demande_mpe'),
                    'id_pv_consta_entete_travaux' => $this->post('id_pv_consta_entete_travaux')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Demande_latrine_mpeManager->add($data);
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
                    'montant' => $this->post('montant'),
                    'id_tranche_demande_mpe' => $this->post('id_tranche_demande_mpe'),
                    'id_pv_consta_entete_travaux' => $this->post('id_pv_consta_entete_travaux')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Demande_latrine_mpeManager->update($id, $data);
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
            $delete = $this->Demande_latrine_mpeManager->delete($id);         
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
