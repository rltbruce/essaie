<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Rubrique_construction extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('rubrique_construction_model', 'Rubrique_constructionManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_phase_construction = $this->get('id_phase_construction');
        $menu = $this->get('menu');

         if ($menu == 'getrubriqueByphase_construction')
         {
            $tmp = $this->Rubrique_constructionManager->findAllByphase_construction($id_phase_construction);
           // if ($tmp) 
           // {
                $data=$tmp;

                /*foreach ($menu as $key => $value) 
                {
                    $phase_sous_projet_construction = $this->Phase_sous_projet_constructionManager->findById($value->id_phase_construction);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_verification'] = $value->date_verification;
                    $data[$key]['conformite']   = $value->conformite;
                    $data[$key]['observation']    = $value->observation;
                   
                    $data[$key]['phase_sous_projet_construction'] = $phase_sous_projet_construction;
                }*/
           // } 
               // else
                //    $data = array();
        }   
        elseif ($id)
        {
            $data = array();
            $rubrique_construction = $this->Rubrique_constructionManager->findById($id);

            $phase_sous_projet_construction = $this->Phase_sous_projet_constructionManager->findById($rubrique_construction->id_phase_construction);

            $data['id'] = $rubrique_construction->id;
            $data['date_verification'] = $rubrique_construction->date_verification;
            $data['conformite']   = $rubrique_construction->conformite;
            $data['observation']    = $rubrique_construction->observation;
                   
            $data['phase_sous_projet_construction'] = $phase_sous_projet_construction;
        } 
        else 
        {
            $menu = $this->Rubrique_constructionManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $phase_sous_projet_construction = $this->Phase_sous_projet_constructionManager->findById($value->id_phase_construction);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_verification'] = $value->date_verification;
                    $data[$key]['conformite']   = $value->conformite;
                    $data[$key]['observation']    = $value->observation;
                   
                    $data[$key]['phase_sous_projet_construction'] = $phase_sous_projet_construction;
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
                    'id' => $this->post('id'),
                    'date_verification' => $this->post('date_verification'),
                    'conformite'   => $this->post('conformite'),
                    'observation'    => $this->post('observation'),
                    'id_rubrique_phase'    => $this->post('id_rubrique_phase'),
                    'id_phase_construction'    => $this->post('id_phase_construction')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Rubrique_constructionManager->add($data);
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
                    'id' => $this->post('id'),
                    'date_verification' => $this->post('date_verification'),
                    'conformite'   => $this->post('conformite'),
                    'observation'    => $this->post('observation'),
                    'id_rubrique_phase'    => $this->post('id_rubrique_phase'),
                    'id_phase_construction'    => $this->post('id_phase_construction')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Rubrique_constructionManager->update($id, $data);
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
            $delete = $this->Rubrique_constructionManager->delete($id);         
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
