<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Dossier_pr extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('document_pr_scan_model', 'Document_pr_scanManager');
        $this->load->model('document_pr_model', 'Document_prManager');
       $this->load->model('contrat_partenaire_relai_model', 'Contrat_partenaire_relaiManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_partenaire_relai = $this->get('id_contrat_partenaire_relai');
        $id_convention_entete = $this->get('id_convention_entete');
        $validation = $this->get('validation');
        $menu = $this->get('menu');

        if ($menu =="getdocumentinvalideBycontrat")
        {
            $tmp = $this->Document_prManager->finddocumentinvalideBycontrat($id_contrat_partenaire_relai);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_partenaire_relai= array();
                    $existance = false;
                    //$contrat_partenaire_relai = $this->Contrat_beManager->findById($value->id_contrat_partenaire_relai);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['id_document_pr_scan'] = $value->id_document_pr_scan;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    
                    //$data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                    if ($value->id_document_pr_scan) {
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
            $tmp = $this->Document_prManager->finddocumentvalideBycontrat($id_contrat_partenaire_relai);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_partenaire_relai= array();
                    $existance = false;
                    //$contrat_partenaire_relai = $this->Contrat_beManager->findById($value->id_contrat_partenaire_relai);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['id_document_pr_scan'] = $value->id_document_pr_scan;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    
                   // $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                    if ($value->id_document_pr_scan) {
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
            $tmp = $this->Document_prManager->finddocumentBycontrat($id_contrat_partenaire_relai);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_partenaire_relai= array();
                    $existance = false;
                    //$contrat_partenaire_relai = $this->Contrat_beManager->findById($value->id_contrat_partenaire_relai);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['id_document_pr_scan'] = $value->id_document_pr_scan;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    
                    //$data[$key]['contrat_partenaire_relai'] = $value->id_contrat_partenaire_relai;
                    if ($value->id_document_pr_scan) {
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
            $menu = $this->Document_prManager->findAllByConvention($id_convention_entete);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_partenaire_relai= array();
                    $existance = false;
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['id_document_pr_scan'] = $value->id_document_pr_scan;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                    if ($value->id_document_pr_scan) {
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
            $menu = $this->Document_prManager->findAllByContrat($id_contrat_partenaire_relai);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_partenaire_relai= array();
                    $existance = false;
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['id_document_pr_scan'] = $value->id_document_pr_scan;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                    if ($value->id_document_pr_scan) {
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
            $document_pr_scan = $this->Document_pr_scanManager->findById($id);
            $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($document_pr_scan->id_contrat_partenaire_relai);
            $data['id'] = $document_pr_scan->id;
            $data['fichier'] = $document_pr_scan->fichier;
            $data['date_elaboration'] = $document_pr_scan->date_elaboration;
            $data['observation'] = $document_pr_scan->observation;
            $data['contrat_partenaire_relai'] = $contrat_partenaire_relai;
        } 
        else 
        {
            $menu = $this->Document_pr_scanManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_partenaire_relai= array();
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
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
                    'id_contrat_partenaire_relai' => $this->post('id_contrat_partenaire_relai'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Document_pr_scanManager->add($data);
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
                    'id_contrat_partenaire_relai' => $this->post('id_contrat_partenaire_relai'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Document_pr_scanManager->update($id, $data);
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
            $delete = $this->Document_pr_scanManager->delete($id);         
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
