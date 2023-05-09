<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Paiement_fin_travaux_moe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('paiement_fin_travaux_moe_model', 'Paiement_fin_travaux_moeManager');
        $this->load->model('demande_fin_travaux_moe_model', 'Demande_fin_travaux_moeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_demande_fin_travaux = $this->get('id_demande_fin_travaux');
         $menu = $this->get('menu');
            
        if ($menu=='getpaiementinvalideBydemande') 
        {   $data = array();
            $tmp = $this->Paiement_fin_travaux_moeManager->findpaiementinvalideBydemande($id_demande_fin_travaux);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_fin_travaux_moe = array();
                    $demande_fin_travaux_moe = $this->Demande_fin_travaux_moeManager->findById($value->id_demande_fin_travaux);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['demande_fin_travaux_moe'] = $demande_fin_travaux_moe;
                }
            }
        }
        elseif ($menu=='getpaiementvalideBydemande') 
        {   $data = array();
            $tmp = $this->Paiement_fin_travaux_moeManager->findpaiementvalideBydemand($id_demande_fin_travaux);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_fin_travaux_moe = array();
                    $demande_fin_travaux_moe = $this->Demande_fin_travaux_moeManager->findById($value->id_demande_fin_travaux);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['demande_fin_travaux_moe'] = $demande_fin_travaux_moe;
                }
            }
        }
        elseif ($menu=='getpaiementBydemande') 
        {   $data = array();
            $tmp = $this->Paiement_fin_travaux_moeManager->findpaiementBydemande($id_demande_fin_travaux);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_fin_travaux_moe = array();
                    $demande_fin_travaux_moe = $this->Demande_fin_travaux_moeManager->findById($value->id_demande_fin_travaux);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['demande_fin_travaux_moe'] = $demande_fin_travaux_moe;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $paiement_fin_travaux_moe = $this->Paiement_fin_travaux_moeManager->findById($id);
            $demande_fin_travaux_moe = $this->Demande_fin_travaux_moeManager->findById($paiement_fin_travaux_moe->id_demande_fin_travaux);
            $data['id'] = $paiement_fin_travaux_moe->id;
            $data['montant_paiement'] = $paiement_fin_travaux_moe->montant_paiement;
            $data['date_paiement'] = $paiement_fin_travaux_moe->date_paiement;
            $data['observation'] = $paiement_fin_travaux_moe->observation;
            $data['demande_fin_travaux_moe'] = $demande_fin_travaux_moe;
        } 
        else 
        {
            $menu = $this->Paiement_fin_travaux_moeManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $demande_fin_travaux_moe = $this->Demande_fin_travaux_moeManager->findById($value->id_demande_fin_travaux);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['demande_fin_travaux_moe'] = $demande_fin_travaux_moe;
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
                    'validation' => $this->post('validation'),
                    'id_demande_fin_travaux' => $this->post('id_demande_fin_travaux')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Paiement_fin_travaux_moeManager->add($data);
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
                    'validation' => $this->post('validation'),
                    'id_demande_fin_travaux' => $this->post('id_demande_fin_travaux')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Paiement_fin_travaux_moeManager->update($id, $data);
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
            $delete = $this->Paiement_fin_travaux_moeManager->delete($id);         
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
