<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Participant_pmc extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('participant_pmc_model', 'Participant_pmcManager');
        $this->load->model('module_pmc_model', 'Module_pmcManager');
        $this->load->model('situation_participant_pmc_model', 'Situation_participant_pmcManager');

    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_module_pmc = $this->get('id_module_pmc');
            
        if ($id_module_pmc) 
        {   $data = array();
            $tmp = $this->Participant_pmcManager->findBymodule_pmc($id_module_pmc);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $module_pmc = array();
                    $module_pmc = $this->Module_pmcManager->findById($value->id_module_pmc);
                    $situation_participant_pmc = $this->Situation_participant_pmcManager->findById($value->id_situation_participant_pmc);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['prenom'] = $value->prenom;
                    $data[$key]['sexe'] = $value->sexe;
                    $data[$key]['situation_participant_pmc'] = $situation_participant_pmc;
                    $data[$key]['module_pmc'] = $module_pmc;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $participant_pmc = $this->Participant_pmcManager->findById($id);
            $module_pmc = $this->Module_pmcManager->findById($participant_pmc->id_module_pmc);
            $situation_participant_pmc = $this->Situation_participant_pmcManager->findById($participant_pmc->id_module_pmc);
            $data['id'] = $participant_pmc->id;
            $data['nom'] = $participant_pmc->nom;
            $data['prenom'] = $participant_pmc->prenom;
            $data['age'] = $participant_pmc->age;
            $data['sexe'] = $participant_pmc->sexe;
            $data['situation_participant_pmc'] = $situation_participant_pmc;
            $data['module_pmc'] = $module_pmc;
        } 
        else 
        {
            $menu = $this->Participant_pmcManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $module_pmc = $this->Module_pmcManager->findById($value->id_module_pmc);
                    $situation_participant_pmc = $this->Situation_participant_pmcManager->findById($value->id_situation_participant_pmc);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['prenom'] = $value->prenom;
                    $data[$key]['sexe'] = $value->sexe;
                    $data[$key]['situation_participant_pmc'] = $situation_participant_pmc;
                    $data[$key]['module_pmc'] = $module_pmc;
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
                    'id_situation_participant_pmc' => $this->post('id_situation_participant_pmc'),
                    'id_module_pmc' => $this->post('id_module_pmc')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Participant_pmcManager->add($data);
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
                    'id_situation_participant_pmc' => $this->post('id_situation_participant_pmc'),
                    'id_module_pmc' => $this->post('id_module_pmc')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Participant_pmcManager->update($id, $data);
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
            $delete = $this->Participant_pmcManager->delete($id);         
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
