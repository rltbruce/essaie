<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Rapport_pmc extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('rapport_pmc_model', 'Rapport_pmcManager');
       $this->load->model('module_pmc_model', 'Module_pmcManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_module_pmc = $this->get('id_module_pmc');
            
        if ($id_module_pmc)
        {
            $tmp = $this->Rapport_pmcManager->findAllBymodule($id_module_pmc);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $module_pmc= array();
                    $module_pmc = $this->Module_pmcManager->findById($value->id_module_pmc);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['module_pmc'] = $module_pmc;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $rapport_pmc = $this->Rapport_pmcManager->findById($id);
            $module_pmc = $this->Module_pmcManager->findById($rapport_pmc->id_module_pmc);
            $data['id'] = $rapport_pmc->id;
            $data['intitule'] = $rapport_pmc->intitule;
            $data['fichier'] = $rapport_pmc->fichier;
            $data['module_pmc'] = $module_pmc;
        } 
        else 
        {
            $menu = $this->Rapport_pmcManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $module_pmc= array();
                    $module_pmc = $this->Module_pmcManager->findById($value->id_module_pmc);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
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
                    'intitule' => $this->post('intitule'),
                    'fichier' => $this->post('fichier'),
                    'id_module_pmc' => $this->post('id_module_pmc')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Rapport_pmcManager->add($data);
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
                    'id_module_pmc' => $this->post('id_module_pmc')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Rapport_pmcManager->update($id, $data);
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
            $delete = $this->Rapport_pmcManager->delete($id);         
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
