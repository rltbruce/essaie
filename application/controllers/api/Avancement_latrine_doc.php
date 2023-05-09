<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Avancement_latrine_doc extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('avancement_latrine_doc_model', 'Avancement_latrine_docManager');
       $this->load->model('avancement_latrine_model', 'Avancement_latrineManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_avancement_latrine = $this->get('id_avancement_latrine');
            
        if ($id_avancement_latrine)
        {
            $tmp = $this->Avancement_latrine_docManager->findAllBydemande($id_avancement_latrine);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $avancement_latrine= array();
                    $avancement_latrine = $this->Avancement_latrineManager->findById($value->id_avancement_latrine);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['avancement_latrine'] = $avancement_latrine;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $avancement_latrine_doc = $this->Avancement_latrine_docManager->findById($id);
            $avancement_latrine = $this->Avancement_latrineManager->findById($avancement_latrine_doc->id_avancement_latrine);
            $data['id'] = $avancement_latrine_doc->id;
            $data['description'] = $avancement_latrine_doc->description;
            $data['fichier'] = $avancement_latrine_doc->fichier;
            //$data['date'] = $avancement_latrine_doc->date;
            $data['avancement_latrine'] = $avancement_latrine;
        } 
        else 
        {
            $menu = $this->Avancement_latrine_docManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $avancement_latrine= array();
                    $avancement_latrine = $this->Avancement_latrineManager->findById($value->id_avancement_latrine);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
                    $data[$key]['avancement_latrine'] = $avancement_latrine;
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
                    'id_avancement_latrine' => $this->post('id_avancement_latrine')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Avancement_latrine_docManager->add($data);
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
                    'id_avancement_latrine' => $this->post('id_avancement_latrine')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Avancement_latrine_docManager->update($id, $data);
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
            $delete = $this->Avancement_latrine_docManager->delete($id);         
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
