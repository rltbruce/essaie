<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Paiement_mobilier_moe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('paiement_mobilier_moe_model', 'Paiement_mobilier_moeManager');
        $this->load->model('demande_mobilier_moe_model', 'Demande_mobilier_moeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_demande_mobilier_moe = $this->get('id_demande_mobilier_moe');
            
        if ($id_demande_mobilier_moe) 
        {   $data = array();
            $tmp = $this->Paiement_mobilier_moeManager->findBydemande_mobilier_moe($id_demande_mobilier_moe);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_mobilier_moe = array();
                    $demande_mobilier_moe = $this->Demande_mobilier_moeManager->findById($value->id_demande_mobilier_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['demande_mobilier_moe'] = $demande_mobilier_moe;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $paiement_mobilier_moe = $this->Paiement_mobilier_moeManager->findById($id);
            $demande_mobilier_moe = $this->Demande_mobilier_moeManager->findById($paiement_mobilier_moe->id_demande_mobilier_moe);
            $data['id'] = $paiement_mobilier_moe->id;
            $data['montant_paiement'] = $paiement_mobilier_moe->montant_paiement;
            $data['date_paiement'] = $paiement_mobilier_moe->date_paiement;
            $data['observation'] = $paiement_mobilier_moe->observation;
            $data['demande_mobilier_moe'] = $demande_mobilier_moe;
        } 
        else 
        {
            $menu = $this->Paiement_mobilier_moeManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $demande_mobilier_moe = $this->Demande_mobilier_moeManager->findById($value->id_demande_mobilier_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['demande_mobilier_moe'] = $demande_mobilier_moe;
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
                    'id_demande_mobilier_moe' => $this->post('id_demande_mobilier_moe')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Paiement_mobilier_moeManager->add($data);
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
                    'id_demande_mobilier_moe' => $this->post('id_demande_mobilier_moe')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Paiement_mobilier_moeManager->update($id, $data);
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
            $delete = $this->Paiement_mobilier_moeManager->delete($id);         
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
