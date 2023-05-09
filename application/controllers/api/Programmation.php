<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Programmation extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('programmation_model', 'ProgrammationManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
            
        if ($id)
        {
            $data = array();
            $programmation = $this->ProgrammationManager->findById($id);
            $data['id'] = $programmation->id;
            $data['date'] = $programmation->date;
            $data['description'] = $programmation->description;
            $data['montant_total_prevu'] = $programmation->montant_total_prevu;
        } 
        else 
        {
            $menu = $this->ProgrammationManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['montant_total_prevu'] = $value->montant_total_prevu;
                    
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
                    'date' => $this->post('date'),
                    'description' => $this->post('description'),
                    'montant_total_prevu' => $this->post('montant_total_prevu'),
                    
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->ProgrammationManager->add($data);
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
                    'date' => $this->post('date'),
                    'description' => $this->post('description'),
                    'montant_total_prevu' => $this->post('montant_total_prevu'),
                    
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->ProgrammationManager->update($id, $data);
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
            $delete = $this->ProgrammationManager->delete($id);         
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
