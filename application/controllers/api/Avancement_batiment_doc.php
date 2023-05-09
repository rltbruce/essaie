<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Avancement_batiment_doc extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('avancement_batiment_doc_model', 'Avancement_batiment_docManager');
       $this->load->model('avancement_batiment_model', 'Avancement_batimentManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_avancement_batiment = $this->get('id_avancement_batiment');
            
        if ($id_avancement_batiment)
        {
            $tmp = $this->Avancement_batiment_docManager->findAllBydemande($id_avancement_batiment);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $avancement_batiment= array();
                    $avancement_batiment = $this->Avancement_batimentManager->findById($value->id_avancement_batiment);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['avancement_batiment'] = $avancement_batiment;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $avancement_batiment_doc = $this->Avancement_batiment_docManager->findById($id);
            $avancement_batiment = $this->Avancement_batimentManager->findById($avancement_batiment_doc->id_avancement_batiment);
            $data['id'] = $avancement_batiment_doc->id;
            $data['description'] = $avancement_batiment_doc->description;
            $data['fichier'] = $avancement_batiment_doc->fichier;
            //$data['date'] = $avancement_batiment_doc->date;
            $data['avancement_batiment'] = $avancement_batiment;
        } 
        else 
        {
            $menu = $this->Avancement_batiment_docManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $avancement_batiment= array();
                    $avancement_batiment = $this->Avancement_batimentManager->findById($value->id_avancement_batiment);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
                    $data[$key]['avancement_batiment'] = $avancement_batiment;
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
                    'id_avancement_batiment' => $this->post('id_avancement_batiment')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Avancement_batiment_docManager->add($data);
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
                    'id_avancement_batiment' => $this->post('id_avancement_batiment')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Avancement_batiment_docManager->update($id, $data);
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
            $delete = $this->Avancement_batiment_docManager->delete($id);         
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
