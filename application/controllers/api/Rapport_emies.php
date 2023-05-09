<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Rapport_emies extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('rapport_emies_model', 'Rapport_emiesManager');
       $this->load->model('module_emies_model', 'Module_emiesManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_module_emies = $this->get('id_module_emies');
            
        if ($id_module_emies)
        {
            $tmp = $this->Rapport_emiesManager->findAllBymodule($id_module_emies);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $module_emies= array();
                    $module_emies = $this->Module_emiesManager->findById($value->id_module_emies);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['module_emies'] = $module_emies;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $rapport_emies = $this->Rapport_emiesManager->findById($id);
            $module_emies = $this->Module_emiesManager->findById($rapport_emies->id_module_emies);
            $data['id'] = $rapport_emies->id;
            $data['intitule'] = $rapport_emies->intitule;
            $data['fichier'] = $rapport_emies->fichier;
            $data['module_emies'] = $module_emies;
        } 
        else 
        {
            $menu = $this->Rapport_emiesManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $module_emies= array();
                    $module_emies = $this->Module_emiesManager->findById($value->id_module_emies);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['module_emies'] = $module_emies;
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
                    'id_module_emies' => $this->post('id_module_emies')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Rapport_emiesManager->add($data);
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
                    'id_module_emies' => $this->post('id_module_emies')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Rapport_emiesManager->update($id, $data);
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
            $delete = $this->Rapport_emiesManager->delete($id);         
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
