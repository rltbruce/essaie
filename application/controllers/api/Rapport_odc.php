<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Rapport_odc extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('rapport_odc_model', 'Rapport_odcManager');
       $this->load->model('module_odc_model', 'Module_odcManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_module_odc = $this->get('id_module_odc');
            
        if ($id_module_odc)
        {
            $tmp = $this->Rapport_odcManager->findAllBymodule($id_module_odc);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $module_odc= array();
                    $module_odc = $this->Module_odcManager->findById($value->id_module_odc);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['module_odc'] = $module_odc;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $rapport_odc = $this->Rapport_odcManager->findById($id);
            $module_odc = $this->Module_odcManager->findById($rapport_odc->id_module_odc);
            $data['id'] = $rapport_odc->id;
            $data['intitule'] = $rapport_odc->intitule;
            $data['fichier'] = $rapport_odc->fichier;
            $data['module_odc'] = $module_odc;
        } 
        else 
        {
            $menu = $this->Rapport_odcManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $module_odc= array();
                    $module_odc = $this->Module_odcManager->findById($value->id_module_odc);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['module_odc'] = $module_odc;
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
                    'id_module_odc' => $this->post('id_module_odc')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Rapport_odcManager->add($data);
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
                    'id_module_odc' => $this->post('id_module_odc')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Rapport_odcManager->update($id, $data);
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
            $delete = $this->Rapport_odcManager->delete($id);         
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
