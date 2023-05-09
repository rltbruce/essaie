<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Participant_sep extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('participant_sep_model', 'Participant_sepManager');
        $this->load->model('module_sep_model', 'Module_sepManager');
        $this->load->model('situation_participant_sep_model', 'Situation_participant_sepManager');

    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_module_sep = $this->get('id_module_sep');
            
        if ($id_module_sep) 
        {   $data = array();
            $tmp = $this->Participant_sepManager->findBymodule_sep($id_module_sep);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $module_sep = array();
                    $module_sep = $this->Module_sepManager->findById($value->id_module_sep);
                    $situation_participant_sep = $this->Situation_participant_sepManager->findById($value->id_situation_participant_sep);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['prenom'] = $value->prenom;
                    $data[$key]['sexe'] = $value->sexe;
                    $data[$key]['situation_participant_sep'] = $situation_participant_sep;
                    $data[$key]['module_sep'] = $module_sep;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $participant_sep = $this->Participant_sepManager->findById($id);
            $module_sep = $this->Module_sepManager->findById($participant_sep->id_module_sep);
            $situation_participant_sep = $this->Situation_participant_sepManager->findById($participant_sep->id_module_sep);
            $data['id'] = $participant_sep->id;
            $data['nom'] = $participant_sep->nom;
            $data['prenom'] = $participant_sep->prenom;
            $data['age'] = $participant_sep->age;
            $data['sexe'] = $participant_sep->sexe;
            $data['situation_participant_sep'] = $situation_participant_sep;
            $data['module_sep'] = $module_sep;
        } 
        else 
        {
            $menu = $this->Participant_sepManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $module_sep = $this->Module_sepManager->findById($value->id_module_sep);
                    $situation_participant_sep = $this->Situation_participant_sepManager->findById($value->id_situation_participant_sep);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['prenom'] = $value->prenom;
                    $data[$key]['sexe'] = $value->sexe;
                    $data[$key]['situation_participant_sep'] = $situation_participant_sep;
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
                    'nom' => $this->post('nom'),
                    'prenom' => $this->post('prenom'),
                    'sexe' => $this->post('sexe'),
                    'id_situation_participant_sep' => $this->post('id_situation_participant_sep'),
                    'id_module_sep' => $this->post('id_module_sep')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Participant_sepManager->add($data);
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
                    'id_situation_participant_sep' => $this->post('id_situation_participant_sep'),
                    'id_module_sep' => $this->post('id_module_sep')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Participant_sepManager->update($id, $data);
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
            $delete = $this->Participant_sepManager->delete($id);         
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
