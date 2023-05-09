<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Rubrique_addition_fonct_feffi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('rubrique_addition_fonct_feffi_model', 'Rubrique_addition_fonct_feffiManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
            
        if ($id)
        {
            $data = array();
            $rubrique_addition_fonct_feffi= $this->Rubrique_addition_fonct_feffiManager->findById($id);
            $data['id'] = $rubrique_addition_fonct_feffi->id;
            $data['libelle'] = $rubrique_addition_fonct_feffi->libelle;
            $data['description'] = $rubrique_addition_fonct_feffi->description;
        } 
        else 
        {
            $menu = $this->Rubrique_addition_fonct_feffiManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
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
                    'description' => $this->post('description')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Rubrique_addition_fonct_feffiManager->add($data);
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
                    'description' => $this->post('description')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Rubrique_addition_fonct_feffiManager->update($id, $data);
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
            $delete = $this->Rubrique_addition_fonct_feffiManager->delete($id);         
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
