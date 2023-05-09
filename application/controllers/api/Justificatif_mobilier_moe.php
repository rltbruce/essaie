<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Justificatif_mobilier_moe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('justificatif_mobilier_moe_model', 'Justificatif_mobilier_moeManager');
       $this->load->model('demande_mobilier_moe_model', 'Demande_mobilier_moeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_demande_mobilier_moe = $this->get('id_demande_mobilier_moe');
            
        if ($id_demande_mobilier_moe)
        {
            $tmp = $this->Justificatif_mobilier_moeManager->findAllBydemande($id_demande_mobilier_moe);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_mobilier_moe= array();
                    $demande_mobilier_moe = $this->Demande_mobilier_moeManager->findById($value->id_demande_mobilier_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
                    $data[$key]['demande_mobilier_moe'] = $demande_mobilier_moe;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $justificatif_mobilier_moe = $this->Justificatif_mobilier_moeManager->findById($id);
            $demande_mobilier_moe = $this->Demande_mobilier_moeManager->findById($justificatif_mobilier_moe->id_demande_mobilier_moe);
            $data['id'] = $justificatif_mobilier_moe->id;
            $data['description'] = $justificatif_mobilier_moe->description;
            $data['fichier'] = $justificatif_mobilier_moe->fichier;
            //$data['date'] = $justificatif_mobilier_moe->date;
            $data['demande_mobilier_moe'] = $demande_mobilier_moe;
        } 
        else 
        {
            $menu = $this->Justificatif_mobilier_moeManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $demande_mobilier_moe= array();
                    $demande_mobilier_moe = $this->Demande_mobilier_moeManager->findById($value->id_demande_mobilier_moe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
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
                    'description' => $this->post('description'),
                    'fichier' => $this->post('fichier'),
                    'id_demande_mobilier_moe' => $this->post('id_demande_mobilier_moe')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Justificatif_mobilier_moeManager->add($data);
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
                    'id_demande_mobilier_moe' => $this->post('id_demande_mobilier_moe')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Justificatif_mobilier_moeManager->update($id, $data);
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
            $delete = $this->Justificatif_mobilier_moeManager->delete($id);         
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
