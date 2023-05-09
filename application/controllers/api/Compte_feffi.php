<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Compte_feffi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('compte_feffi_model', 'Compte_feffiManager');
        $this->load->model('feffi_model', 'FeffiManager');
        $this->load->model('membre_feffi_model', 'Membre_feffiManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_feffi = $this->get('id_feffi');
       /* $maj=$this->get('maj');

            
        if ($maj==1) 
        { 
            $menu = $this->Compte_feffiManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $feffi = array();
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    
                    $ecole = $this->Compte_feffiManager->findByIdecole($value->id_feffi);
                    $tmp[$key]['ecole'] = $ecole->description;
                    //$membre_feffi = $this->Membre_feffiManager->findById($value->id_membre_feffi);
                    //$tmp[$key]['membre_feffi'] = $membre_feffi;
                    $tmp[$key]['id'] = $value->id;
                    $tmp[$key]['rib'] = $value->rib;
                    $tmp[$key]['nom_banque'] = $value->nom_banque;
                    $tmp[$key]['numero_compte'] = $value->numero_compte;
                    $tmp[$key]['adresse_banque'] = $value->adresse_banque;
                    $tmp[$key]['intitule'] = $value->intitule;
                    
                    $tmp[$key]['feffi'] = $feffi;
                    $data[$key] = array(
                        'id' => $value->id,
                        'rib' => $value->rib,
                        'nom_banque' => $value->nom_banque,
                        'adresse_banque' => $value->adresse_banque,
                        'numero_compte' => $value->numero_compte,
                        //'id_membre_feffi' => $this->post('id_membre_feffi'),
                        'id_feffi' => $feffi->id,
                        'intitule' => 'PAEB construction FEFFI '.$ecole->description
                    );
                    $update = $this->Compte_feffiManager->update($value->id, $data[$key]);

                }
            } 
                else
                    $data = array();
        }
        else*/
        if ($id_feffi) 
        {   $data = array();
            $tmp = $this->Compte_feffiManager->findByfeffi($id_feffi);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $feffi = array();
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    //$membre_feffi = $this->Membre_feffiManager->findById($value->id_membre_feffi);
                    //$data[$key]['membre_feffi'] = $membre_feffi;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['nom_banque'] = $value->nom_banque;
                    $data[$key]['rib'] = $value->rib;
                    $data[$key]['adresse_banque'] = $value->adresse_banque;
                    $data[$key]['numero_compte'] = $value->numero_compte;
                    $data[$key]['intitule'] = $value->intitule;
                   
                    $data[$key]['feffi'] = $feffi;

                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $compte_feffi = $this->Compte_feffiManager->findById($id);
            $feffi = $this->FeffiManager->findById($compte_feffi->id_feffi);
            //$membre_feffi = $this->Membre_feffiManager->findById($compte_feffi->id_membre_feffi);
            //$data['membre_feffi'] = $membre_feffi;
            $data['id'] = $compte_feffi->id;
            $data['rib'] = $compte_feffi->rib;
            $data['nom_banque'] = $compte_feffi->nom_banque;
            $data['numero_compte'] = $compte_feffi->numero_compte;
            $data['adresse_banque'] = $compte_feffi->adresse_banque;
            $data['intitule'] = $compte_feffi->intitule;
            
            $data['feffi'] = $feffi;
        } 
        else 
        {
            $menu = $this->Compte_feffiManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $feffi = array();
                    $feffi = $this->FeffiManager->findById($value->id_feffi);
                    //$membre_feffi = $this->Membre_feffiManager->findById($value->id_membre_feffi);
                    //$data[$key]['membre_feffi'] = $membre_feffi;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['rib'] = $value->rib;
                    $data[$key]['nom_banque'] = $value->nom_banque;
                    $data[$key]['numero_compte'] = $value->numero_compte;
                    $data[$key]['adresse_banque'] = $value->adresse_banque;
                    $data[$key]['intitule'] = $value->intitule;
                    
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
                    'rib' => $this->post('rib'),
                    'nom_banque' => $this->post('nom_banque'),
                    'adresse_banque' => $this->post('adresse_banque'),
                    'numero_compte' => $this->post('numero_compte'),
                    //'id_membre_feffi' => $this->post('id_membre_feffi'),
                    'id_feffi' => $this->post('id_feffi'),
                    'intitule' => $this->post('intitule')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Compte_feffiManager->add($data);
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
                    'rib' => $this->post('rib'),
                    'nom_banque' => $this->post('nom_banque'),
                    'adresse_banque' => $this->post('adresse_banque'),
                    'numero_compte' => $this->post('numero_compte'),
                    //'id_membre_feffi' => $this->post('id_membre_feffi'),
                    'id_feffi' => $this->post('id_feffi'),
                    'intitule' => $this->post('intitule')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Compte_feffiManager->update($id, $data);
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
            $delete = $this->Compte_feffiManager->delete($id);         
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
