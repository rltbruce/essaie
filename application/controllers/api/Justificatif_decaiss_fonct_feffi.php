<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Justificatif_decaiss_fonct_feffi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('justificatif_decaiss_fonct_feffi_model', 'Justificatif_decaiss_fonct_feffiManager');
       $this->load->model('decaiss_fonct_feffi_model', 'Decaiss_fonct_feffiManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_decaiss_fonct_feffi = $this->get('id_decaiss_fonct_feffi');
            
        if ($id_decaiss_fonct_feffi)
        {
            $tmp = $this->Justificatif_decaiss_fonct_feffiManager->findAllBytransfert($id_decaiss_fonct_feffi);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $decaiss_fonct_feffi= array();
                    $decaiss_fonct_feffi = $this->Decaiss_fonct_feffiManager->findById($value->id_decaiss_fonct_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
                    $data[$key]['decaiss_fonct_feffi'] = $decaiss_fonct_feffi;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $justificatif_decaiss_fonct_feffi = $this->Justificatif_decaiss_fonct_feffiManager->findById($id);
            $decaiss_fonct_feffi = $this->Decaiss_fonct_feffiManager->findById($justificatif_decaiss_fonct_feffi->id_decaiss_fonct_feffi);
            $data['id'] = $justificatif_decaiss_fonct_feffi->id;
            $data['description'] = $justificatif_decaiss_fonct_feffi->description;
            $data['fichier'] = $justificatif_decaiss_fonct_feffi->fichier;
            //$data['date'] = $justificatif_decaiss_fonct_feffi->date;
            $data['decaiss_fonct_feffi'] = $decaiss_fonct_feffi;
        } 
        else 
        {
            $menu = $this->Justificatif_decaiss_fonct_feffiManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $decaiss_fonct_feffi= array();
                    $decaiss_fonct_feffi = $this->Decaiss_fonct_feffiManager->findById($value->id_decaiss_fonct_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
                    $data[$key]['decaiss_fonct_feffi'] = $decaiss_fonct_feffi;
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
                    'id_decaiss_fonct_feffi' => $this->post('id_decaiss_fonct_feffi')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Justificatif_decaiss_fonct_feffiManager->add($data);
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
                    'id_decaiss_fonct_feffi' => $this->post('id_decaiss_fonct_feffi')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Justificatif_decaiss_fonct_feffiManager->update($id, $data);
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
            $delete = $this->Justificatif_decaiss_fonct_feffiManager->delete($id);         
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
