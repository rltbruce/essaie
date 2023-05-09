<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Rubrique_phase_sous_projet extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Rubrique_phase_sous_projet_model', 'Rubrique_phase_sous_projetManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_phase_sous_projet = $this->get('id_phase_sous_projet');
            
        if ($id_phase_sous_projet) 
        {   $data = array();
            $tmp = $this->Rubrique_phase_sous_projetManager->findBydistrict($id_phase_sous_projet);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['designation'] = $value->designation;
                    $data[$key]['element_verifier'] = $value->element_verifier;
                    $data[$key]['id_phase_sous_projet'] = $value->id_phase_sous_projet;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $Rubrique_phase_sous_projet = $this->Rubrique_phase_sous_projetManager->findById($id);
            $data['id'] = $Rubrique_phase_sous_projet->id;
            $data['designation'] = $Rubrique_phase_sous_projet->designation;
            $data['element_verifier'] = $Rubrique_phase_sous_projet->element_verifier;
            $data['id_phase_sous_projet'] = $Rubrique_phase_sous_projet->id_phase_sous_projet;
        } 
        else 
        {
            $menu = $this->Rubrique_phase_sous_projetManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['designation'] = $value->designation;
                    $data[$key]['element_verifier'] = $value->element_verifier;
                    $data[$key]['id_phase_sous_projet'] = $value->id_phase_sous_projet;
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
                    'element_verifier' => $this->post('element_verifier'),
                    'designation' => $this->post('designation'),
                    'id_phase_sous_projet' => $this->post('id_phase_sous_projet')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Rubrique_phase_sous_projetManager->add($data);
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
                    'designation' => $this->post('designation'),
                    'element_verifier' => $this->post('element_verifier'),
                    'id_phase_sous_projet' => $this->post('id_phase_sous_projet')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Rubrique_phase_sous_projetManager->update($id, $data);
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
            $delete = $this->Rubrique_phase_sous_projetManager->delete($id);         
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
