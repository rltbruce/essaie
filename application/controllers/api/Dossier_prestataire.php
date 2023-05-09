<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Dossier_prestataire extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('document_prestataire_scan_model', 'Document_prestataire_scanManager');
        $this->load->model('document_prestataire_model', 'Document_prestataireManager');
       $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_convention_entete = $this->get('id_convention_entete');
        $validation = $this->get('validation');
        $menu = $this->get('menu');

        if ($menu =="getdocumentinvalideBycontrat")
        {
            $tmp = $this->Document_prestataireManager->finddocumentinvalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_prestataire= array();
                    $existance = false;
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['id_document_prestataire_scan'] = $value->id_document_prestataire_scan;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                    if ($value->id_document_prestataire_scan) {
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
            $tmp = $this->Document_prestataireManager->finddocumentvalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_prestataire= array();
                    $existance = false;
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['id_document_prestataire_scan'] = $value->id_document_prestataire_scan;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                    if ($value->id_document_prestataire_scan) {
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
            $tmp = $this->Document_prestataireManager->finddocumentBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_prestataire= array();
                    $existance = false;
                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['id_document_prestataire_scan'] = $value->id_document_prestataire_scan;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    
                    $data[$key]['contrat_prestataire'] = $value->id_contrat_prestataire;
                    if ($value->id_document_prestataire_scan) {
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
            $menu = $this->Document_prestataireManager->findAllByContrat($id_contrat_prestataire);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_prestataire= array();
                    $existance = false;
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['id_document_prestataire_scan'] = $value->id_document_prestataire_scan;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                    if ($value->id_document_prestataire_scan) {
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
            $menu = $this->Document_prestataireManager->findAllByConvention($id_convention_entete);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_prestataire= array();
                    $existance = false;
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['id_document_prestataire_scan'] = $value->id_document_prestataire_scan;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                    if ($value->id_document_prestataire_scan) {
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
            $document_prestataire_scan = $this->Document_prestataire_scanManager->findById($id);
            $contrat_prestataire = $this->Contrat_prestataireManager->findById($document_prestataire_scan->id_contrat_prestataire);
            $data['id'] = $document_prestataire_scan->id;
            $data['fichier'] = $document_prestataire_scan->fichier;
            $data['date_elaboration'] = $document_prestataire_scan->date_elaboration;
            $data['observation'] = $document_prestataire_scan->observation;
            $data['contrat_prestataire'] = $contrat_prestataire;
        } 
        else 
        {
            $menu = $this->Document_prestataire_scanManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_prestataire= array();
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
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
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Document_prestataire_scanManager->add($data);
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
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Document_prestataire_scanManager->update($id, $data);
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
            $delete = $this->Document_prestataire_scanManager->delete($id);         
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
