<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Paiement_batiment_moe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('paiement_batiment_moe_model', 'Paiement_batiment_moeManager');
        $this->load->model('demande_batiment_moe_model', 'Demande_batiment_moeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_demande_batiment_moe = $this->get('id_demande_batiment_moe');
        $menu = $this->get('menu');
            
        if ($menu=='getpaiementinvalideBydemande') 
        {   $data = array();
            $tmp = $this->Paiement_batiment_moeManager->findpaiementinvalideBydemande($id_demande_batiment_moe);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_batiment_moe = array();
                    $demande_batiment_moe = $this->Demande_batiment_moeManager->findById($value->id_demande_batiment_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['demande_batiment_moe'] = $demande_batiment_moe;
                }
            }
        }
        elseif ($menu=='getpaiementvalideBydemande') 
        {   $data = array();
            $tmp = $this->Paiement_batiment_moeManager->findpaiementvalideBydemand($id_demande_batiment_moe);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_batiment_moe = array();
                    $demande_batiment_moe = $this->Demande_batiment_moeManager->findById($value->id_demande_batiment_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['demande_batiment_moe'] = $demande_batiment_moe;
                }
            }
        }
        elseif ($menu=='getpaiementBydemande') 
        {   $data = array();
            $tmp = $this->Paiement_batiment_moeManager->findpaiementBydemande($id_demande_batiment_moe);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_batiment_moe = array();
                    $demande_batiment_moe = $this->Demande_batiment_moeManager->findById($value->id_demande_batiment_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['demande_batiment_moe'] = $demande_batiment_moe;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $paiement_batiment_moe = $this->Paiement_batiment_moeManager->findById($id);
            $demande_batiment_moe = $this->Demande_batiment_moeManager->findById($paiement_batiment_moe->id_demande_batiment_moe);
            $data['id'] = $paiement_batiment_moe->id;
            $data['montant_paiement'] = $paiement_batiment_moe->montant_paiement;
            $data['date_paiement'] = $paiement_batiment_moe->date_paiement;
            $data['observation'] = $paiement_batiment_moe->observation;
            $data['demande_batiment_moe'] = $demande_batiment_moe;
        } 
        else 
        {
            $menu = $this->Paiement_batiment_moeManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $demande_batiment_moe = $this->Demande_batiment_moeManager->findById($value->id_demande_batiment_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['demande_batiment_moe'] = $demande_batiment_moe;
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
                    'validation' => $this->post('validation'),
                    //'pourcentage_paiement' => $this->post('pourcentage_paiement'),
                    'date_paiement' => $this->post('date_paiement'),
                    'observation' => $this->post('observation'),
                    'id_demande_batiment_moe' => $this->post('id_demande_batiment_moe')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Paiement_batiment_moeManager->add($data);
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
                    'validation' => $this->post('validation'),
                    //'cumul' => $this->post('cumul'),
                    //'pourcentage_paiement' => $this->post('pourcentage_paiement'),
                    'date_paiement' => $this->post('date_paiement'),
                    'observation' => $this->post('observation'),
                    'id_demande_batiment_moe' => $this->post('id_demande_batiment_moe')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Paiement_batiment_moeManager->update($id, $data);
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
            $delete = $this->Paiement_batiment_moeManager->delete($id);         
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
