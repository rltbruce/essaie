<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Document_pr_scan extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('document_pr_scan_model', 'Document_pr_scanManager');
        $this->load->model('contrat_partenaire_relai_model', 'Contrat_partenaire_relaiManager');
        $this->load->model('document_pr_model', 'Document_prManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_partenaire_relai = $this->get('id_contrat_partenaire_relai');
        $id_document_pr = $this->get('id_document_pr');
        $id_convention_entete = $this->get('id_convention_entete');
        $validation = $this->get('validation');
        $menu = $this->get('menu');
        $id_document_pr_scan = $this->get('id_document_pr_scan');
            
        if ($menu == "getdocumentvalideById")
        {
            $tmp = $this->Document_pr_scanManager->getdocumentvalideById($id_document_pr_scan);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getdocument_pr_scanByConvention")
        {
            $tmp = $this->Document_pr_scanManager->findAllByconvention($id_convention_entete,$validation);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_partenaire_relai= array();
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);
                    //$convention_cisco_feffi_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $document_pr = $this->Document_prManager->findById($value->id_document_pr);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                    $data[$key]['document_pr'] = $document_pr;
                    //$data[$key]['convention_entete'] = $convention_cisco_feffi_entete;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getdocumentBycontratdossier_prevu")
        {
            $tmp = $this->Document_pr_scanManager->getdocumentBycontratdossier_prevu($id_document_pr,$id_contrat_partenaire_relai);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
       /* if ($menu == "getmemoireByvalidation")
        {
            $tmp = $this->Document_pr_scanManager->findAllByvalidation($validation);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_partenaire_relai = array();
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_livraison'] = $value->date_livraison;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                }
            } 
                else
                    $data = array();
        }*/
        elseif ($id)
        {
            $data = array();
            $document_pr_scan = $this->Document_pr_scanManager->findById($id);
            $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($document_pr_scan->id_contrat_partenaire_relai);
            //$convention_cisco_feffi_entete = $this->Convention_cisco_feffi_enteteManager->findById($document_pr_scan->id_convention_entete);
            $document_pr = $this->Document_prManager->findById($document_pr_scan->id_document_pr);
            $data['id'] = $document_pr_scan->id;
            $data['fichier'] = $document_pr_scan->fichier;
            $data['date_elaboration'] = $document_pr_scan->date_elaboration;
            $data['observation'] = $document_pr_scan->observation;
            $data['contrat_partenaire_relai'] = $contrat_partenaire_relai;
            $data['document_pr'] = $document_pr;
            //$data['convention_entete'] = $convention_cisco_feffi_entete;
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
                    $convention_cisco_feffi_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $document_pr = $this->Document_prManager->findById($value->id_document_pr);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                    $data[$key]['document_pr'] = $document_pr;
                    $data[$key]['convention_entete'] = $convention_cisco_feffi_entete;
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
                    'id_document_pr' => $this->post('id_document_pr'),
                    'validation' => $this->post('validation'),
                    //'id_convention_entete' => $this->post('id_convention_entete'),
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
                    'id_document_pr' => $this->post('id_document_pr'),
                    'validation' => $this->post('validation'),
                    //'id_convention_entete' => $this->post('id_convention_entete')
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
