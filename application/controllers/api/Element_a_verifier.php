<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Element_a_verifier extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('element_a_verifier_model', 'Element_a_verifierManager');
        $this->load->model('designation_infrastructure_model', 'Designation_designation_infrastructureManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_designation_infrastructure = $this->get('id_designation_infrastructure');
            
        if ($id_designation_infrastructure) 
        {   $data = array();
            $tmp = $this->Element_a_verifierManager->findBydesignation_infrastructure($id_designation_infrastructure);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $designation_infrastructure = array();
                    $designation_infrastructure = $this->Designation_designation_infrastructureManager->findById($value->id_designation_infrastructure);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['element_verifier'] = $value->element_verifier;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['designation_infrastructure'] = $designation_infrastructure;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $element_a_verifier = $this->Element_a_verifierManager->findById($id);
            $designation_infrastructure = $this->Designation_designation_infrastructureManager->findById($element_a_verifier->id_designation_infrastructure);
            $data['id'] = $element_a_verifier->id;
            $data['element_verifier'] = $element_a_verifier->element_verifier;
            $data['description'] = $element_a_verifier->description;
            $data['designation_infrastructure'] = $designation_infrastructure;
        } 
        else 
        {
            $menu = $this->Element_a_verifierManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $designation_infrastructure = $this->Designation_designation_infrastructureManager->findById($value->id_designation_infrastructure);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['element_verifier'] = $value->element_verifier;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['designation_infrastructure'] = $designation_infrastructure;
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
                    'element_verifier' => $this->post('element_verifier'),
                    'description' => $this->post('description'),
                    'id_designation_infrastructure' => $this->post('id_designation_infrastructure')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Element_a_verifierManager->add($data);
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
                    'element_verifier' => $this->post('element_verifier'),
                    'description' => $this->post('description'),
                    'id_designation_infrastructure' => $this->post('id_designation_infrastructure')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Element_a_verifierManager->update($id, $data);
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
            $delete = $this->Element_a_verifierManager->delete($id);         
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
