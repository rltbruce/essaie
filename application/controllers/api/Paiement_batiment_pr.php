<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Paiement_batiment_pr extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('paiement_batiment_pr_model', 'Paiement_batiment_prManager');
        $this->load->model('demande_batiment_pr_model', 'Demande_batiment_prManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_demande_batiment_pr = $this->get('id_demande_batiment_pr');
            
        if ($id_demande_batiment_pr) 
        {   $data = array();
            $tmp = $this->Paiement_batiment_prManager->findBydemande_batiment_pr($id_demande_batiment_pr);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_batiment_pr = array();
                    $demande_batiment_pr = $this->Demande_batiment_prManager->findById($value->id_demande_batiment_pr);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['demande_batiment_pr'] = $demande_batiment_pr;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $paiement_batiment_pr = $this->Paiement_batiment_prManager->findById($id);
            $demande_batiment_pr = $this->Demande_batiment_prManager->findById($paiement_batiment_pr->id_demande_batiment_pr);
            $data['id'] = $paiement_batiment_pr->id;
            $data['montant_paiement'] = $paiement_batiment_pr->montant_paiement;
            $data['date_paiement'] = $paiement_batiment_pr->date_paiement;
            $data['observation'] = $paiement_batiment_pr->observation;
            $data['demande_batiment_pr'] = $demande_batiment_pr;
        } 
        else 
        {
            $menu = $this->Paiement_batiment_prManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $demande_batiment_pr = $this->Demande_batiment_prManager->findById($value->id_demande_batiment_pr);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['demande_batiment_pr'] = $demande_batiment_pr;
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
                    //'cumul' => $this->post('cumul'),
                    //'pourcentage_paiement' => $this->post('pourcentage_paiement'),
                    'date_paiement' => $this->post('date_paiement'),
                    'observation' => $this->post('observation'),
                    'id_demande_batiment_pr' => $this->post('id_demande_batiment_pr')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Paiement_batiment_prManager->add($data);
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
                    //'cumul' => $this->post('cumul'),
                    //'pourcentage_paiement' => $this->post('pourcentage_paiement'),
                    'date_paiement' => $this->post('date_paiement'),
                    'observation' => $this->post('observation'),
                    'id_demande_batiment_pr' => $this->post('id_demande_batiment_pr')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Paiement_batiment_prManager->update($id, $data);
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
            $delete = $this->Paiement_batiment_prManager->delete($id);         
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
