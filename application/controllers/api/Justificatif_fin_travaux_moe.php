<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Justificatif_fin_travaux_moe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('justificatif_fin_travaux_moe_model', 'Justificatif_fin_travaux_moeManager');
       $this->load->model('demande_fin_travaux_moe_model', 'Demande_fin_travaux_moeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_demande_fin_travaux_moe = $this->get('id_demande_fin_travaux_moe');
            
        if ($id_demande_fin_travaux_moe)
        {
            $tmp = $this->Justificatif_fin_travaux_moeManager->findAllBydemande($id_demande_fin_travaux_moe);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_fin_travaux_moe= array();
                    $demande_fin_travaux_moe = $this->Demande_fin_travaux_moeManager->findById($value->id_demande_fin_travaux_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
                    $data[$key]['demande_fin_travaux_moe'] = $demande_fin_travaux_moe;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $justificatif_fin_travaux_moe = $this->Justificatif_fin_travaux_moeManager->findById($id);
            $demande_fin_travaux_moe = $this->Demande_fin_travaux_moeManager->findById($justificatif_fin_travaux_moe->id_demande_fin_travaux_moe);
            $data['id'] = $justificatif_fin_travaux_moe->id;
            $data['description'] = $justificatif_fin_travaux_moe->description;
            $data['fichier'] = $justificatif_fin_travaux_moe->fichier;
            //$data['date'] = $justificatif_fin_travaux_moe->date;
            $data['demande_fin_travaux_moe'] = $demande_fin_travaux_moe;
        } 
        else 
        {
            $menu = $this->Justificatif_fin_travaux_moeManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $demande_fin_travaux_moe= array();
                    $demande_fin_travaux_moe = $this->Demande_fin_travaux_moeManager->findById($value->id_demande_fin_travaux_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
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
                    'description' => $this->post('description'),
                    'fichier' => $this->post('fichier'),
                    'id_demande_fin_travaux_moe' => $this->post('id_demande_fin_travaux_moe')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Justificatif_fin_travaux_moeManager->add($data);
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
                    'id_demande_fin_travaux_moe' => $this->post('id_demande_fin_travaux_moe')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Justificatif_fin_travaux_moeManager->update($id, $data);
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
            $delete = $this->Justificatif_fin_travaux_moeManager->delete($id);         
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
