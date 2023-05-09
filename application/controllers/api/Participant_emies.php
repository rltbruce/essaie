<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Participant_emies extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('participant_emies_model', 'Participant_emiesManager');
        $this->load->model('module_emies_model', 'Module_emiesManager');
        $this->load->model('situation_participant_emies_model', 'Situation_participant_emiesManager');

    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_module_emies = $this->get('id_module_emies');
            
        if ($id_module_emies) 
        {   $data = array();
            $tmp = $this->Participant_emiesManager->findBymodule_emies($id_module_emies);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $module_emies = array();
                    $module_emies = $this->Module_emiesManager->findById($value->id_module_emies);
                    $situation_participant_emies = $this->Situation_participant_emiesManager->findById($value->id_situation_participant_emies);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['prenom'] = $value->prenom;
                    $data[$key]['sexe'] = $value->sexe;
                    $data[$key]['situation_participant_emies'] = $situation_participant_emies;
                    $data[$key]['module_emies'] = $module_emies;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $participant_emies = $this->Participant_emiesManager->findById($id);
            $module_emies = $this->Module_emiesManager->findById($participant_emies->id_module_emies);
            $situation_participant_emies = $this->Situation_participant_emiesManager->findById($participant_emies->id_module_emies);
            $data['id'] = $participant_emies->id;
            $data['nom'] = $participant_emies->nom;
            $data['prenom'] = $participant_emies->prenom;
            $data['age'] = $participant_emies->age;
            $data['sexe'] = $participant_emies->sexe;
            $data['situation_participant_emies'] = $situation_participant_emies;
            $data['module_emies'] = $module_emies;
        } 
        else 
        {
            $menu = $this->Participant_emiesManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $module_emies = $this->Module_emiesManager->findById($value->id_module_emies);
                    $situation_participant_emies = $this->Situation_participant_emiesManager->findById($value->id_situation_participant_emies);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['prenom'] = $value->prenom;
                    $data[$key]['sexe'] = $value->sexe;
                    $data[$key]['situation_participant_emies'] = $situation_participant_emies;
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
                    'nom' => $this->post('nom'),
                    'prenom' => $this->post('prenom'),
                    'sexe' => $this->post('sexe'),
                    'id_situation_participant_emies' => $this->post('id_situation_participant_emies'),
                    'id_module_emies' => $this->post('id_module_emies')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Participant_emiesManager->add($data);
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
                    'id_situation_participant_emies' => $this->post('id_situation_participant_emies'),
                    'id_module_emies' => $this->post('id_module_emies')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Participant_emiesManager->update($id, $data);
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
            $delete = $this->Participant_emiesManager->delete($id);         
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
