<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Membre_titulaire extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('membre_titulaire_model', 'Membre_titulaireManager');
        $this->load->model('membre_feffi_model', 'Membre_feffiManager');
        $this->load->model('compte_feffi_model', 'Compte_feffiManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_compte = $this->get('id_compte');
        $id_membre = $this->get('id_membre');
            
        if ($id_compte) 
        {   
            $tmp = $this->Membre_titulaireManager->findBycompte($id_compte);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $compte = array();
                    $membre = array();
                    $compte = $this->Compte_feffiManager->findById($value->id_compte);
                    $membre = $this->Membre_feffiManager->findByMembre($value->id_membre);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['membre'] = $membre;
                    $data[$key]['compte'] = $compte;
                }
            }else
                $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $compte = array();
            $membre = array();
            $tmp = $this->Membre_titulaireManager->findBycompte($id);
            $compte = $this->Compte_feffiManager->findById($tmp->id_compte);
            $membre = $this->Membre_feffiManager->findByMembre($tmp->id_membre);
            $data['id'] = $tmp->id;
            $data['membre'] = $membre;
            $data['compte'] = $compte;
        } 
        else 
        {
            $tmp = $this->Membre_titulaireManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $compte = array();
                    $membre = array();
                    $compte = $this->Compte_feffiManager->findById($value->id_compte);
                    $membre = $this->Membre_feffiManager->findByMembre($value->id_membre);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['membre'] = $membre;
                    $data[$key]['compte'] = $compte;
                }
            }else
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
                    'id_compte' => $this->post('id_compte'),
                    'id_membre' => $this->post('id_membre')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Membre_titulaireManager->add($data);
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
                    'id_compte' => $this->post('id_compte'),
                    'id_membre' => $this->post('id_membre')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Membre_titulaireManager->update($id, $data);
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
            $delete = $this->Membre_titulaireManager->delete($id);         
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
