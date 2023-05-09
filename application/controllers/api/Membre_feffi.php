<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Membre_feffi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('membre_feffi_model', 'Membre_feffiManager');
        $this->load->model('feffi_model', 'FeffiManager');
        $this->load->model('organe_feffi_model', 'Organe_feffiManager');
        $this->load->model('fonction_feffi_model', 'Fonction_feffiManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_feffi = $this->get('id_feffi');
            
        if ($id_feffi) 
        {   $data = array();
            $tmp = $this->Membre_feffiManager->findByfeffi($id_feffi);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $feffi = array();
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $organe_feffi = $this->Organe_feffiManager->findById($value->id_organe_feffi);
                    $fonction_feffi = $this->Fonction_feffiManager->findById($value->id_fonction_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['prenom'] = $value->prenom;
                    $data[$key]['age'] = $value->age;
                    $data[$key]['sexe'] = $value->sexe;
                    $data[$key]['organe_feffi'] = $organe_feffi;
                    $data[$key]['fonction_feffi'] = $fonction_feffi;
                    $data[$key]['feffi'] = $feffi;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $membre_feffi = $this->Membre_feffiManager->findById($id);
            $feffi = $this->FeffiManager->findById($membre_feffi->id_feffi);
            $organe_feffi = $this->Organe_feffiManager->findById($membre_feffi->id_organe_feffi);
            $fonction_feffi = $this->Fonction_feffiManager->findById($membre_feffi->id_fonction_feffi);
            
            $data['id'] = $membre_feffi->id;
            $data['nom'] = $membre_feffi->nom;
            $data['prenom'] = $membre_feffi->prenom;
            $data['age'] = $membre_feffi->age;
            $data['sexe'] = $membre_feffi->sexe;
            $data['organe_feffi'] = $organe_feffi;
            $data['fonction_feffi'] = $fonction_feffi;
            $data['feffi'] = $feffi;
        } 
        else 
        {
            $menu = $this->Membre_feffiManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    $organe_feffi = $this->Organe_feffiManager->findById($value->id_organe_feffi);
                    $fonction_feffi = $this->Fonction_feffiManager->findById($value->id_fonction_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['prenom'] = $value->prenom;
                    $data[$key]['age'] = $value->age;
                    $data[$key]['sexe'] = $value->sexe;
                    $data[$key]['organe_feffi'] = $organe_feffi;
                    $data[$key]['fonction_feffi'] = $fonction_feffi;
                    $data[$key]['feffi'] = $feffi;
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
                    'nom' => $this->post('nom'),
                    'prenom' => $this->post('prenom'),
                    'sexe' => $this->post('sexe'),
                    'age' => $this->post('age'),
                    'id_organe_feffi' => $this->post('id_organe_feffi'),
                    'id_fonction_feffi' => $this->post('id_fonction_feffi'),
                    'id_feffi' => $this->post('id_feffi')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Membre_feffiManager->add($data);
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
                    'nom' => $this->post('nom'),
                    'prenom' => $this->post('prenom'),
                    'sexe' => $this->post('sexe'),
                    'age' => $this->post('age'),
                    'id_organe_feffi' => $this->post('id_organe_feffi'),
                    'id_fonction_feffi' => $this->post('id_fonction_feffi'),
                    'id_feffi' => $this->post('id_feffi')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Membre_feffiManager->update($id, $data);
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
            $delete = $this->Membre_feffiManager->delete($id);         
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
