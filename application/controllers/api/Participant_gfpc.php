<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Participant_gfpc extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('participant_gfpc_model', 'Participant_gfpcManager');
        $this->load->model('module_gfpc_model', 'Module_gfpcManager');
        $this->load->model('situation_participant_gfpc_model', 'Situation_participant_gfpcManager');

    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_module_gfpc = $this->get('id_module_gfpc');
            
        if ($id_module_gfpc) 
        {   $data = array();
            $tmp = $this->Participant_gfpcManager->findBymodule_gfpc($id_module_gfpc);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $module_gfpc = array();
                    $module_gfpc = $this->Module_gfpcManager->findById($value->id_module_gfpc);
                    $situation_participant_gfpc = $this->Situation_participant_gfpcManager->findById($value->id_situation_participant_gfpc);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['prenom'] = $value->prenom;
                    $data[$key]['sexe'] = $value->sexe;
                    $data[$key]['situation_participant_gfpc'] = $situation_participant_gfpc;
                    $data[$key]['module_gfpc'] = $module_gfpc;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $participant_gfpc = $this->Participant_gfpcManager->findById($id);
            $module_gfpc = $this->Module_gfpcManager->findById($participant_gfpc->id_module_gfpc);
            $situation_participant_gfpc = $this->Situation_participant_gfpcManager->findById($participant_gfpc->id_module_gfpc);
            $data['id'] = $participant_gfpc->id;
            $data['nom'] = $participant_gfpc->nom;
            $data['prenom'] = $participant_gfpc->prenom;
            $data['age'] = $participant_gfpc->age;
            $data['sexe'] = $participant_gfpc->sexe;
            $data['situation_participant_gfpc'] = $situation_participant_gfpc;
            $data['module_gfpc'] = $module_gfpc;
        } 
        else 
        {
            $menu = $this->Participant_gfpcManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $module_gfpc = $this->Module_gfpcManager->findById($value->id_module_gfpc);
                    $situation_participant_gfpc = $this->Situation_participant_gfpcManager->findById($value->id_situation_participant_gfpc);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['prenom'] = $value->prenom;
                    $data[$key]['sexe'] = $value->sexe;
                    $data[$key]['situation_participant_gfpc'] = $situation_participant_gfpc;
                    $data[$key]['module_gfpc'] = $module_gfpc;
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
                    'nom' => $this->post('nom'),
                    'prenom' => $this->post('prenom'),
                    'sexe' => $this->post('sexe'),
                    'id_situation_participant_gfpc' => $this->post('id_situation_participant_gfpc'),
                    'id_module_gfpc' => $this->post('id_module_gfpc')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Participant_gfpcManager->add($data);
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
                    'nom' => $this->post('nom'),
                    'prenom' => $this->post('prenom'),
                    'sexe' => $this->post('sexe'),
                    'age' => $this->post('age'),
                    'id_situation_participant_gfpc' => $this->post('id_situation_participant_gfpc'),
                    'id_module_gfpc' => $this->post('id_module_gfpc')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Participant_gfpcManager->update($id, $data);
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
            $delete = $this->Participant_gfpcManager->delete($id);         
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
