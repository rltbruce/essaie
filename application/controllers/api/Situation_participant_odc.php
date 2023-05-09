<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Situation_participant_odc extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('situation_participant_odc_model', 'Situation_participant_odcManager');
        $this->load->model('classification_site_model', 'Classification_siteManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_classification_site = $this->get('id_classification_site');
            
        if ($id_classification_site) 
        {   $data = array();
            $tmp = $this->Situation_participant_odcManager->findByclassification_site($id_classification_site);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $classification_site = array();
                    $classification_site = $this->Classification_siteManager->findById($value->id_classification_site);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['classification_site'] = $classification_site;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $situation_participant_odc = $this->Situation_participant_odcManager->findById($id);
            $classification_site = $this->Classification_siteManager->findById($situation_participant_odc->id_classification_site);
            $data['id'] = $situation_participant_odc->id;
            $data['libelle'] = $situation_participant_odc->libelle;
            $data['description'] = $situation_participant_odc->description;
            $data['classification_site'] = $classification_site;
        } 
        else 
        {
            $menu = $this->Situation_participant_odcManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $classification_site = $this->Classification_siteManager->findById($value->id_classification_site);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['classification_site'] = $classification_site;
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
                    'libelle' => $this->post('libelle'),
                    'description' => $this->post('description'),
                    'id_classification_site' => $this->post('id_classification_site')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Situation_participant_odcManager->add($data);
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
                    'libelle' => $this->post('libelle'),
                    'description' => $this->post('description'),
                    'id_classification_site' => $this->post('id_classification_site')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Situation_participant_odcManager->update($id, $data);
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
            $delete = $this->Situation_participant_odcManager->delete($id);         
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
