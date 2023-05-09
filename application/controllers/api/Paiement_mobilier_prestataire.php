<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Paiement_mobilier_prestataire extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('paiement_mobilier_prestataire_model', 'Paiement_mobilier_prestataireManager');
        $this->load->model('demande_mobilier_prestataire_model', 'Demande_mobilier_prestataireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_demande_mobilier_pre = $this->get('id_demande_mobilier_pre');
        $menu = $this->get('menu');
            
        if ($menu=='getpaiementinvalideBydemande') 
        {   $data = array();
            $tmp = $this->Paiement_mobilier_prestataireManager->findpaiementinvalideBydemande($id_demande_mobilier_pre);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_mobilier_prestataire = array();
                    $demande_mobilier_prestataire = $this->Demande_mobilier_prestataireManager->findById($value->id_demande_mobilier_pre);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['pourcentage_paiement'] = $value->pourcentage_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['demande_mobilier_prestataire'] = $demande_mobilier_prestataire;
                }
            }
        }
        elseif ($menu=='getpaiementvalideBydemande') 
        {   $data = array();
            $tmp = $this->Paiement_mobilier_prestataireManager->findpaiementvalideBydemande($id_demande_mobilier_pre);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_mobilier_prestataire = array();
                    $demande_mobilier_prestataire = $this->Demande_mobilier_prestataireManager->findById($value->id_demande_mobilier_pre);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['cumul'] = $value->cumul;
                    //$data[$key]['pourcentage_paiement'] = $value->pourcentage_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['demande_mobilier_prestataire'] = $demande_mobilier_prestataire;
                }
            }
        }

        elseif ($menu=='getpaiementBydemande') 
        {   $data = array();
            $tmp = $this->Paiement_mobilier_prestataireManager->findpaiementBydemande($id_demande_mobilier_pre);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_mobilier_prestataire = array();
                    $demande_mobilier_prestataire = $this->Demande_mobilier_prestataireManager->findById($value->id_demande_mobilier_pre);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['cumul'] = $value->cumul;
                    //$data[$key]['pourcentage_paiement'] = $value->pourcentage_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['demande_mobilier_prestataire'] = $demande_mobilier_prestataire;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $paiement_mobilier_prestataire = $this->Paiement_mobilier_prestataireManager->findById($id);
            $demande_mobilier_prestataire = $this->Demande_mobilier_prestataireManager->findById($paiement_mobilier_prestataire->id_demande_mobilier_pre);
            $data['id'] = $paiement_mobilier_prestataire->id;
            $data['montant_paiement'] = $paiement_mobilier_prestataire->montant_paiement;
            //$data['cumul'] = $paiement_mobilier_prestataire->cumul;
            //$data['pourcentage_paiement'] = $paiement_mobilier_prestataire->pourcentage_paiement;
            $data['date_paiement'] = $paiement_mobilier_prestataire->date_paiement;
            $data['observation'] = $paiement_mobilier_prestataire->observation;
            $data['demande_mobilier_prestataire'] = $demande_mobilier_prestataire;
        } 
        else 
        {
            $menu = $this->Paiement_mobilier_prestataireManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $demande_mobilier_prestataire = $this->Demande_mobilier_prestataireManager->findById($value->id_demande_mobilier_pre);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_paiement'] = $value->montant_paiement;
                    //$data[$key]['cumul'] = $value->cumul;
                    //$data[$key]['pourcentage_paiement'] = $value->pourcentage_paiement;
                    $data[$key]['date_paiement'] = $value->date_paiement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['demande_mobilier_prestataire'] = $demande_mobilier_prestataire;
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
                    'id_demande_mobilier_pre' => $this->post('id_demande_mobilier_pre')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Paiement_mobilier_prestataireManager->add($data);
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
                    //'pourcentage_paiement' => $this->post('pourcentage_paiement'),
                    'date_paiement' => $this->post('date_paiement'),
                    'observation' => $this->post('observation'),
                    'id_demande_mobilier_pre' => $this->post('id_demande_mobilier_pre')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Paiement_mobilier_prestataireManager->update($id, $data);
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
            $delete = $this->Paiement_mobilier_prestataireManager->delete($id);         
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
