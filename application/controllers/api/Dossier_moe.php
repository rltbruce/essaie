<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Dossier_moe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('document_moe_scan_model', 'Document_moe_scanManager');
        $this->load->model('document_moe_model', 'Document_moeManager');
       $this->load->model('contrat_be_model', 'Contrat_beManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');
        $id_convention_entete = $this->get('id_convention_entete');
        $validation = $this->get('validation');
        $menu = $this->get('menu');

        if ($menu =="getdocumentinvalideBycontrat")
        {
            $tmp = $this->Document_moeManager->finddocumentinvalideBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $existance = false;
                    //$contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['id_document_moe_scan'] = $value->id_document_moe_scan;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    
                    //$data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;
                    if ($value->id_document_moe_scan) {
                        $existance = true;
                    }
                    $data[$key]['existance'] = $existance;
                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu =="getdocumentvalideBycontrat")
        {
            $tmp = $this->Document_moeManager->finddocumentvalideBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $existance = false;
                    //$contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['id_document_moe_scan'] = $value->id_document_moe_scan;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    
                   // $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;
                    if ($value->id_document_moe_scan) {
                        $existance = true;
                    }
                    $data[$key]['existance'] = $existance;
                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu =="getdocumentBycontrat")
        {
            $tmp = $this->Document_moeManager->finddocumentBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $existance = false;
                    //$contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['id_document_moe_scan'] = $value->id_document_moe_scan;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    
                    //$data[$key]['contrat_bureau_etude'] = $value->id_contrat_bureau_etude;
                    if ($value->id_document_moe_scan) {
                        $existance = true;
                    }
                    $data[$key]['existance'] = $existance;
                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu =="getdocument_scanByConvention")
        {
            $menu = $this->Document_moeManager->findAllByConvention($id_convention_entete);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $existance = false;
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['id_document_moe_scan'] = $value->id_document_moe_scan;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;
                    if ($value->id_document_moe_scan) {
                        $existance = true;
                    }
                    $data[$key]['existance'] = $existance;
                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu =="getdocument_scanByContrat")
        {
            $menu = $this->Document_moeManager->findAllByContrat($id_contrat_bureau_etude);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $existance = false;
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['id_document_moe_scan'] = $value->id_document_moe_scan;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;
                    if ($value->id_document_moe_scan) {
                        $existance = true;
                    }
                    $data[$key]['existance'] = $existance;
                }
            } 
                else
                    $data = array();
        } 
        elseif ($id)
        {
            $data = array();
            $document_moe_scan = $this->Document_moe_scanManager->findById($id);
            $contrat_bureau_etude = $this->Contrat_beManager->findById($document_moe_scan->id_contrat_bureau_etude);
            $data['id'] = $document_moe_scan->id;
            $data['fichier'] = $document_moe_scan->fichier;
            $data['date_elaboration'] = $document_moe_scan->date_elaboration;
            $data['observation'] = $document_moe_scan->observation;
            $data['contrat_bureau_etude'] = $contrat_bureau_etude;
        } 
        else 
        {
            $menu = $this->Document_moe_scanManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_bureau_etude= array();
                    $contrat_bureau_etude = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_bureau_etude'] = $contrat_bureau_etude;
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
                    'fichier' => $this->post('fichier'),
                    'date_elaboration' => $this->post('date_elaboration'),
                    'observation' => $this->post('observation'),
                    'id_contrat_bureau_etude' => $this->post('id_contrat_bureau_etude'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Document_moe_scanManager->add($data);
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
                    'fichier' => $this->post('fichier'),
                    'date_elaboration' => $this->post('date_elaboration'),
                    'observation' => $this->post('observation'),
                    'id_contrat_bureau_etude' => $this->post('id_contrat_bureau_etude'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Document_moe_scanManager->update($id, $data);
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
            $delete = $this->Document_moe_scanManager->delete($id);         
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
