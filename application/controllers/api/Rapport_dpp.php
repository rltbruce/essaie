<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Rapport_dpp extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('rapport_dpp_model', 'Rapport_dppManager');
       $this->load->model('module_dpp_model', 'Module_dppManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_module_dpp = $this->get('id_module_dpp');
            
        if ($id_module_dpp)
        {
            $tmp = $this->Rapport_dppManager->findAllBymodule($id_module_dpp);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $module_dpp= array();
                    $module_dpp = $this->Module_dppManager->findById($value->id_module_dpp);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['module_dpp'] = $module_dpp;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $rapport_dpp = $this->Rapport_dppManager->findById($id);
            $module_dpp = $this->Module_dppManager->findById($rapport_dpp->id_module_dpp);
            $data['id'] = $rapport_dpp->id;
            $data['intitule'] = $rapport_dpp->intitule;
            $data['fichier'] = $rapport_dpp->fichier;
            $data['module_dpp'] = $module_dpp;
        } 
        else 
        {
            $menu = $this->Rapport_dppManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $module_dpp= array();
                    $module_dpp = $this->Module_dppManager->findById($value->id_module_dpp);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['module_dpp'] = $module_dpp;
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
                    'intitule' => $this->post('intitule'),
                    'fichier' => $this->post('fichier'),
                    'id_module_dpp' => $this->post('id_module_dpp')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Rapport_dppManager->add($data);
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
                    'intitule' => $this->post('intitule'),
                    'fichier' => $this->post('fichier'),
                    'id_module_dpp' => $this->post('id_module_dpp')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Rapport_dppManager->update($id, $data);
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
            $delete = $this->Rapport_dppManager->delete($id);         
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
