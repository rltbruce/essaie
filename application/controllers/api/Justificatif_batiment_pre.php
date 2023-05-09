<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Justificatif_batiment_pre extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('justificatif_batiment_pre_model', 'Justificatif_batiment_preManager');
       $this->load->model('demande_batiment_prestataire_model', 'Demande_batiment_prestataireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_demande_pay_pre = $this->get('id_demande_pay_pre');
            
        if ($id_demande_pay_pre)
        {
            $tmp = $this->Justificatif_batiment_preManager->findAllBydemande($id_demande_pay_pre);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_batiment_prestataire= array();
                    $demande_batiment_prestataire = $this->Demande_batiment_prestataireManager->findById($value->id_demande_pay_pre);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
                    $data[$key]['demande_batiment_prestataire'] = $demande_batiment_prestataire;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $justificatif_batiment_pre = $this->Justificatif_batiment_preManager->findById($id);
            $demande_batiment_prestataire = $this->Demande_batiment_prestataireManager->findById($justificatif_batiment_pre->id_demande_pay_pre);
            $data['id'] = $justificatif_batiment_pre->id;
            $data['description'] = $justificatif_batiment_pre->description;
            $data['fichier'] = $justificatif_batiment_pre->fichier;
            //$data['date'] = $justificatif_batiment_pre->date;
            $data['demande_batiment_prestataire'] = $demande_batiment_prestataire;
        } 
        else 
        {
            $menu = $this->Justificatif_batiment_preManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $demande_batiment_prestataire= array();
                    $demande_batiment_prestataire = $this->Demande_batiment_prestataireManager->findById($value->id_demande_pay_pre);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
                    $data[$key]['demande_batiment_prestataire'] = $demande_batiment_prestataire;
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
                    'description' => $this->post('description'),
                    'fichier' => $this->post('fichier'),
                    'id_demande_pay_pre' => $this->post('id_demande_pay_pre')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Justificatif_batiment_preManager->add($data);
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
                    'description' => $this->post('description'),
                    'fichier' => $this->post('fichier'),
                    'id_demande_pay_pre' => $this->post('id_demande_pay_pre')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Justificatif_batiment_preManager->update($id, $data);
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
            $delete = $this->Justificatif_batiment_preManager->delete($id);         
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
