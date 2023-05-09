<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Tranche_d_debut_travaux_moe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('tranche_d_debut_travaux_moe_model', 'Tranche_d_debut_travaux_moeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $pourcentage = $this->get('pourcentage');
            
        if ($pourcentage) 
        {   $data = array();
            $tmp = $this->Tranche_d_debut_travaux_moeManager->findBydistrict($pourcentage);
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
            $tranche_d_debut_travaux_moe = $this->Tranche_d_debut_travaux_moeManager->findById($id);
            $data['id'] = $tranche_d_debut_travaux_moe->id;
            $data['code'] = $tranche_d_debut_travaux_moe->code;
            $data['libelle'] = $tranche_d_debut_travaux_moe->libelle;
            $data['periode'] = $tranche_d_debut_travaux_moe->periode;
            $data['pourcentage'] = $tranche_d_debut_travaux_moe->pourcentage;
            $data['description'] = $tranche_d_debut_travaux_moe->description;
        } 
        else 
        {
            $tmp = $this->Tranche_d_debut_travaux_moeManager->findAll();
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['periode'] = $value->periode;                    
                    $data[$key]['pourcentage'] = $value->pourcentage;
                    $data[$key]['description'] = $value->description;
                }*/
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
                $dataId = $this->Tranche_d_debut_travaux_moeManager->add($data);
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
                $update = $this->Tranche_d_debut_travaux_moeManager->update($id, $data);
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
            $delete = $this->Tranche_d_debut_travaux_moeManager->delete($id);         
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
