<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Tranche_demande_batiment_pr extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('tranche_demande_batiment_pr_model', 'Tranche_demande_batiment_prManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $pourcentage = $this->get('pourcentage');
            
        if ($pourcentage) 
        {   $data = array();
            $tmp = $this->Tranche_demande_batiment_prManager->findBydistrict($pourcentage);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['periode'] = $value->periode;
                    $data[$key]['pourcentage'] = $value->pourcentage;
                    $data[$key]['description'] = $value->description;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $tranche_demande_batiment_pr = $this->Tranche_demande_batiment_prManager->findById($id);
            $data['id'] = $tranche_demande_batiment_pr->id;
            $data['code'] = $tranche_demande_batiment_pr->code;
            $data['libelle'] = $tranche_demande_batiment_pr->libelle;
            $data['periode'] = $tranche_demande_batiment_pr->periode;
            $data['pourcentage'] = $tranche_demande_batiment_pr->pourcentage;
            $data['description'] = $tranche_demande_batiment_pr->description;
        } 
        else 
        {
            $menu = $this->Tranche_demande_batiment_prManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['periode'] = $value->periode;                    
                    $data[$key]['pourcentage'] = $value->pourcentage;
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
                    'code' => $this->post('code'),
                    'periode' => $this->post('periode'),
                    'pourcentage' => $this->post('pourcentage'),
                    'description' => $this->post('description')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Tranche_demande_batiment_prManager->add($data);
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
                    'code' => $this->post('code'),
                    'libelle' => $this->post('libelle'),
                    'periode' => $this->post('periode'),
                    'pourcentage' => $this->post('pourcentage'),
                    'description' => $this->post('description')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Tranche_demande_batiment_prManager->update($id, $data);
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
            $delete = $this->Tranche_demande_batiment_prManager->delete($id);         
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
