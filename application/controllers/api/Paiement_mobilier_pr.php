<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Paiement_mobilier_pr extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('paiement_mobilier_pr_model', 'Paiement_mobilier_prManager');
        $this->load->model('demande_mobilier_pr_model', 'Demande_mobilier_prManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_demande_mobilier_pr = $this->get('id_demande_mobilier_pr');
            
        if ($id_demande_mobilier_pr) 
        {   $data = array();
            $tmp = $this->Paiement_mobilier_prManager->findBydemande_mobilier_pr($id_demande_mobilier_pr);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_mobilier_pr = array();
                    $demande_mobilier_pr = $this->Demande_mobilier_prManager->findById($value->id_demande_mobilier_pr);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['demande_mobilier_pr'] = $demande_mobilier_pr;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $paiement_mobilier_pr = $this->Paiement_mobilier_prManager->findById($id);
            $demande_mobilier_pr = $this->Demande_mobilier_prManager->findById($paiement_mobilier_pr->id_demande_mobilier_pr);
            $data['id'] = $paiement_mobilier_pr->id;
            $data['montant_paiement'] = $paiement_mobilier_pr->montant_paiement;
            $data['date_paiement'] = $paiement_mobilier_pr->date_paiement;
            $data['observation'] = $paiement_mobilier_pr->observation;
            $data['demande_mobilier_pr'] = $demande_mobilier_pr;
        } 
        else 
        {
            $menu = $this->Paiement_mobilier_prManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $demande_mobilier_pr = $this->Demande_mobilier_prManager->findById($value->id_demande_mobilier_pr);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['demande_mobilier_pr'] = $demande_mobilier_pr;
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
                    'id_demande_mobilier_pr' => $this->post('id_demande_mobilier_pr')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Paiement_mobilier_prManager->add($data);
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
                    'id_demande_mobilier_pr' => $this->post('id_demande_mobilier_pr')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Paiement_mobilier_prManager->update($id, $data);
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
            $delete = $this->Paiement_mobilier_prManager->delete($id);         
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
