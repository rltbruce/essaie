<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Zap_commune extends REST_Controller {

    public function __construct() {
        parent::__construct();        
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('zap_model', 'ZapManager');        
        $this->load->model('zap_commune_model', 'Zap_communeManager');
    }
    //recuperation zap
    public function index_get() {
		set_time_limit(0);
        $id = $this->get('id');
        $id_commune = $this->get('id_commune');
        $menu = $this->get('menu');

        if ($menu=='getzapBycommune') {
            $data = array();
            // Récupération des zap par commune
            $tmp = $this->Zap_communeManager->findzapByCommune($id_commune);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['nom'] = $value->nom;
                }
            }else $data =array();    
        } 
        elseif ($menu=='getzap_communeBycommune')
        {
            $data = array();
			// Récupération des zap par commune
            $tmp = $this->Zap_communeManager->findAllByCommune($id_commune);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
					// Récupérationdescription commune
                    $commune = array();
                    $zap = array();
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $zap = $this->ZapManager->findById($value->id_zap);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['zap'] = $zap;
                    $data[$key]['commune'] = $commune;
                }
            }else $data =array();    
        } else {
            if ($id) {
                $data = array();
				// Récupération par id
                $zap_commune = $this->Zap_communeManager->findById($id);
                $commune = $this->CommmuneManager->findById($zap_commune->id_commune);
                $zap = $this->ZapManager->findById($zap_commune->id_zap);
                $data['id'] = $zap->id;
                $data['zap'] = $zap->zap;
                $data['commune'] = $commune;
                
            } else {
				// Récupération de tous les zap
                $tmp = $this->Zap_communeManager->findAll();
                if ($tmp) {
                    foreach ($tmp as $key => $value) {
                        $commune = array();
                        $zap = array();
                        $commune = $this->CommuneManager->findById($value->id_commune);
                        $zap = $this->ZapManager->findById($value->id_zap);
                        $data[$key]['id'] = $value->id;
                        $data[$key]['zap'] = $zap;
                        $data[$key]['commune'] = $commune;

                    };
                } else
                    $data = array();
            }
        }
        if (count($data)>0) {
            $this->response([
                'status' => TRUE,
                'response' => $data,
                'message' => 'Get data success',
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => TRUE,
                'response' => array(),
                'message' => 'No data were found'
            ], REST_Controller::HTTP_OK);
        }
    }
    //insertion,modification,suppression zap
    public function index_post() {
        $id = $this->post('id') ;
        $supprimer = $this->post('supprimer') ;
		$data = array(
			'id_zap' => $this->post('id_zap'),
			'id_commune' => $this->post('id_commune')
		);               
        if ($supprimer == 0) {
            if ($id == 0) {
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
				// Ajout d'un enregistrement
                $dataId = $this->Zap_communeManager->add($data);              
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
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
				// Mise à jour d'un enregistrement
                $update = $this->Zap_communeManager->update($id, $data);              
                if(!is_null($update)){
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
			// Suppression d'un enregistrement
            $delete = $this->Zap_communeManager->delete($id);          
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