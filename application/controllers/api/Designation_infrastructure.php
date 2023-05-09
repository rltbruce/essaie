<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Designation_infrastructure extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('designation_infrastructure_model', 'Designation_infrastructureManager');
        $this->load->model('infrastructure_model', 'InfrastructureManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_infrastructure = $this->get('id_infrastructure');
            
        if ($id_infrastructure) 
        {   $data = array();
            $tmp = $this->Designation_infrastructureManager->findByinfrastructure($id_infrastructure);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $infrastructure = array();
                    $infrastructure = $this->InfrastructureManager->findById($value->id_infrastructure);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['designation'] = $value->designation;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['infrastructure'] = $infrastructure;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $designation_infrastructure = $this->Designation_infrastructureManager->findById($id);
            $infrastructure = $this->InfrastructureManager->findById($designation_infrastructure->id_infrastructure);
            $data['id'] = $designation_infrastructure->id;
            $data['designation'] = $designation_infrastructure->designation;
            $data['description'] = $designation_infrastructure->description;
            $data['infrastructure'] = $infrastructure;
        } 
        else 
        {
            $menu = $this->Designation_infrastructureManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $infrastructure = $this->InfrastructureManager->findById($value->id_infrastructure);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['designation'] = $value->designation;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['infrastructure'] = $infrastructure;
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
                    'designation' => $this->post('designation'),
                    'description' => $this->post('description'),
                    'id_infrastructure' => $this->post('id_infrastructure')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Designation_infrastructureManager->add($data);
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
                    'designation' => $this->post('designation'),
                    'description' => $this->post('description'),
                    'id_infrastructure' => $this->post('id_infrastructure')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Designation_infrastructureManager->update($id, $data);
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
            $delete = $this->Designation_infrastructureManager->delete($id);         
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
