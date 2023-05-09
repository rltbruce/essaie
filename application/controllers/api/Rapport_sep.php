<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Rapport_sep extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('rapport_sep_model', 'Rapport_sepManager');
       $this->load->model('module_sep_model', 'Module_sepManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_module_sep = $this->get('id_module_sep');
            
        if ($id_module_sep)
        {
            $tmp = $this->Rapport_sepManager->findAllBymodule($id_module_sep);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $module_sep= array();
                    $module_sep = $this->Module_sepManager->findById($value->id_module_sep);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['module_sep'] = $module_sep;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $rapport_sep = $this->Rapport_sepManager->findById($id);
            $module_sep = $this->Module_sepManager->findById($rapport_sep->id_module_sep);
            $data['id'] = $rapport_sep->id;
            $data['intitule'] = $rapport_sep->intitule;
            $data['fichier'] = $rapport_sep->fichier;
            $data['module_sep'] = $module_sep;
        } 
        else 
        {
            $menu = $this->Rapport_sepManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $module_sep= array();
                    $module_sep = $this->Module_sepManager->findById($value->id_module_sep);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['module_sep'] = $module_sep;
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
                    'id_module_sep' => $this->post('id_module_sep')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Rapport_sepManager->add($data);
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
                    'id_module_sep' => $this->post('id_module_sep')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Rapport_sepManager->update($id, $data);
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
            $delete = $this->Rapport_sepManager->delete($id);         
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
