<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Paiement_fin_travaux_pr extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('paiement_fin_travaux_pr_model', 'Paiement_fin_travaux_prManager');
        $this->load->model('demande_fin_travaux_pr_model', 'Demande_fin_travaux_prManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_demande_fin_travaux = $this->get('id_demande_fin_travaux');
            
        if ($id_demande_fin_travaux) 
        {   $data = array();
            $tmp = $this->Paiement_fin_travaux_prManager->findBydemande_fin_travaux_pr($id_demande_fin_travaux);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_fin_travaux_pr = array();
                    $demande_fin_travaux_pr = $this->Demande_fin_travaux_prManager->findById($value->id_demande_fin_travaux);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['demande_fin_travaux_pr'] = $demande_fin_travaux_pr;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $paiement_fin_travaux_pr = $this->Paiement_fin_travaux_prManager->findById($id);
            $demande_fin_travaux_pr = $this->Demande_fin_travaux_prManager->findById($paiement_fin_travaux_pr->id_demande_fin_travaux);
            $data['id'] = $paiement_fin_travaux_pr->id;
            $data['montant_paiement'] = $paiement_fin_travaux_pr->montant_paiement;
            $data['date_paiement'] = $paiement_fin_travaux_pr->date_paiement;
            $data['observation'] = $paiement_fin_travaux_pr->observation;
            $data['demande_fin_travaux_pr'] = $demande_fin_travaux_pr;
        } 
        else 
        {
            $menu = $this->Paiement_fin_travaux_prManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $demande_fin_travaux_pr = $this->Demande_fin_travaux_prManager->findById($value->id_demande_fin_travaux);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['demande_fin_travaux_pr'] = $demande_fin_travaux_pr;
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
                    'montant_paiement' => $this->post('montant_paiement'),
                    'date_paiement' => $this->post('date_paiement'),
                    'observation' => $this->post('observation'),
                    'id_demande_fin_travaux' => $this->post('id_demande_fin_travaux')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Paiement_fin_travaux_prManager->add($data);
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
                    'montant_paiement' => $this->post('montant_paiement'),
                    'date_paiement' => $this->post('date_paiement'),
                    'observation' => $this->post('observation'),
                    'id_demande_fin_travaux' => $this->post('id_demande_fin_travaux')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Paiement_fin_travaux_prManager->update($id, $data);
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
            $delete = $this->Paiement_fin_travaux_prManager->delete($id);         
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
