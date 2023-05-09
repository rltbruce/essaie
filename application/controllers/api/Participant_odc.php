<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Participant_odc extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('participant_odc_model', 'Participant_odcManager');
        $this->load->model('module_odc_model', 'Module_odcManager');
        $this->load->model('situation_participant_odc_model', 'Situation_participant_odcManager');

    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_module_odc = $this->get('id_module_odc');
            
        if ($id_module_odc) 
        {   $data = array();
            $tmp = $this->Participant_odcManager->findBymodule_odc($id_module_odc);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $module_odc = array();
                    $module_odc = $this->Module_odcManager->findById($value->id_module_odc);
                    $situation_participant_odc = $this->Situation_participant_odcManager->findById($value->id_situation_participant_odc);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['prenom'] = $value->prenom;
                    $data[$key]['sexe'] = $value->sexe;
                    $data[$key]['situation_participant_odc'] = $situation_participant_odc;
                    $data[$key]['module_odc'] = $module_odc;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $participant_odc = $this->Participant_odcManager->findById($id);
            $module_odc = $this->Module_odcManager->findById($participant_odc->id_module_odc);
            $situation_participant_odc = $this->Situation_participant_odcManager->findById($participant_odc->id_module_odc);
            $data['id'] = $participant_odc->id;
            $data['nom'] = $participant_odc->nom;
            $data['prenom'] = $participant_odc->prenom;
            $data['age'] = $participant_odc->age;
            $data['sexe'] = $participant_odc->sexe;
            $data['situation_participant_odc'] = $situation_participant_odc;
            $data['module_odc'] = $module_odc;
        } 
        else 
        {
            $menu = $this->Participant_odcManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $module_odc = $this->Module_odcManager->findById($value->id_module_odc);
                    $situation_participant_odc = $this->Situation_participant_odcManager->findById($value->id_situation_participant_odc);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['prenom'] = $value->prenom;
                    $data[$key]['sexe'] = $value->sexe;
                    $data[$key]['situation_participant_odc'] = $situation_participant_odc;
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
                    'nom' => $this->post('nom'),
                    'prenom' => $this->post('prenom'),
                    'sexe' => $this->post('sexe'),
                    'id_situation_participant_odc' => $this->post('id_situation_participant_odc'),
                    'id_module_odc' => $this->post('id_module_odc')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Participant_odcManager->add($data);
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
                    'id_situation_participant_odc' => $this->post('id_situation_participant_odc'),
                    'id_module_odc' => $this->post('id_module_odc')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Participant_odcManager->update($id, $data);
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
            $delete = $this->Participant_odcManager->delete($id);         
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
