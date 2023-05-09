<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Participant_dpp extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('participant_dpp_model', 'Participant_dppManager');
        $this->load->model('module_dpp_model', 'Module_dppManager');
        $this->load->model('situation_participant_dpp_model', 'Situation_participant_dppManager');

    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_module_dpp = $this->get('id_module_dpp');
            
        if ($id_module_dpp) 
        {   $data = array();
            $tmp = $this->Participant_dppManager->findBymodule_dpp($id_module_dpp);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $module_dpp = array();
                    $module_dpp = $this->Module_dppManager->findById($value->id_module_dpp);
                    $situation_participant_dpp = $this->Situation_participant_dppManager->findById($value->id_situation_participant_dpp);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['prenom'] = $value->prenom;
                    $data[$key]['sexe'] = $value->sexe;
                    $data[$key]['situation_participant_dpp'] = $situation_participant_dpp;
                    $data[$key]['module_dpp'] = $module_dpp;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $participant_dpp = $this->Participant_dppManager->findById($id);
            $module_dpp = $this->Module_dppManager->findById($participant_dpp->id_module_dpp);
            $situation_participant_dpp = $this->Situation_participant_dppManager->findById($participant_dpp->id_module_dpp);
            $data['id'] = $participant_dpp->id;
            $data['nom'] = $participant_dpp->nom;
            $data['prenom'] = $participant_dpp->prenom;
            $data['age'] = $participant_dpp->age;
            $data['sexe'] = $participant_dpp->sexe;
            $data['situation_participant_dpp'] = $situation_participant_dpp;
            $data['module_dpp'] = $module_dpp;
        } 
        else 
        {
            $menu = $this->Participant_dppManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $module_dpp = $this->Module_dppManager->findById($value->id_module_dpp);
                    $situation_participant_dpp = $this->Situation_participant_dppManager->findById($value->id_situation_participant_dpp);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['prenom'] = $value->prenom;
                    $data[$key]['sexe'] = $value->sexe;
                    $data[$key]['situation_participant_dpp'] = $situation_participant_dpp;
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
                    'nom' => $this->post('nom'),
                    'prenom' => $this->post('prenom'),
                    'sexe' => $this->post('sexe'),
                    'id_situation_participant_dpp' => $this->post('id_situation_participant_dpp'),
                    'id_module_dpp' => $this->post('id_module_dpp')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Participant_dppManager->add($data);
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
                    'id_situation_participant_dpp' => $this->post('id_situation_participant_dpp'),
                    'id_module_dpp' => $this->post('id_module_dpp')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Participant_dppManager->update($id, $data);
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
            $delete = $this->Participant_dppManager->delete($id);         
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
