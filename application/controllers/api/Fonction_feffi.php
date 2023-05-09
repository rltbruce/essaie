<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Fonction_feffi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('fonction_feffi_model', 'Fonction_feffiManager');
        $this->load->model('organe_feffi_model', 'Organe_feffiManager');
    }
    public function index_get() {
        $id = $this->get('id');
        $id_organe_feffi = $this->get('id_organe_feffi');
        $menu = $this->get('menu');
		$taiza="";
        if ($menu=="getfonction_feffiByorgane")
        {
            $data = array();
            $tmp = $this->Fonction_feffiManager->findByorgane_feffi($id_organe_feffi);
            if ($tmp) 
            {
                $data = $tmp;
            } 
        }elseif ($id) 
        {
            $data = array();
            $fonction_feffi = $this->Fonction_feffiManager->findById($id);
            $data['id'] = $fonction_feffi->id;
            $data['id_organe_feffi'] = $fonction_feffi->id_organe_feffi;
            $data['libelle'] = $fonction_feffi->libelle;
            $data['description'] = $fonction_feffi->description;
        }else
        {
			$taiza="findAll no nataony";
            $tmp = $this->Fonction_feffiManager->findAll();
            if ($tmp)
            {
                $data=$tmp;
            } else
                    $data = array();
        }
        
        if (count($data)>0) {
            $this->response([
                'status' => TRUE,
                'response' => $data,
                'message' => $taiza,
                // 'message' => 'Get data success',
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'response' => array(),
                'message' => 'No data were found'
            ], REST_Controller::HTTP_OK);
        }
    }
    public function index_post() {
        $id = $this->post('id') ;
        $supprimer = $this->post('supprimer') ;
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'libelle' => $this->post('libelle'),
                    'description' => $this->post('description'),
                    'id_organe_feffi' => $this->post('id_organe_feffi')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Fonction_feffiManager->add($data);
                if (!is_null($dataId))  {
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
                    'id_organe_feffi' => $this->post('id_organe_feffi')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Fonction_feffiManager->update($id, $data);
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
            $delete = $this->Fonction_feffiManager->delete($id);
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
