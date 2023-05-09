<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Document_prestataire_scan extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('document_prestataire_scan_model', 'Document_prestataire_scanManager');
        $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        $this->load->model('document_prestataire_model', 'Document_prestataireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_document_prestataire = $this->get('id_document_prestataire');
        $id_document_prestataire_scan = $this->get('id_document_prestataire_scan');
        $validation = $this->get('validation');
        $menu = $this->get('menu');
        $id_cisco = $this->get('id_cisco');
            
       /* if ($menu == "getmemoireBycontrat")
        {
            $tmp = $this->Document_prestataire_scanManager->findAllBycontrat($id_contrat_prestataire,$validation);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_prestataire = array();
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_livraison'] = $value->date_livraison;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                }
            } 
                else
                    $data = array();
        }*/
       /* if ($menu == "getmemoireByvalidation")
        {
            $tmp = $this->Document_prestataire_scanManager->findAllByvalidation($validation);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_prestataire = array();
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_livraison'] = $value->date_livraison;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                }
            } 
                else
                    $data = array();
        }*/if ($menu == "getdocumentvalideById")
        {
            $tmp = $this->Document_prestataire_scanManager->getdocumentvalideById($id_document_prestataire_scan);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getdocumentBycontratdossier_prevu")
        {
            $tmp = $this->Document_prestataire_scanManager->getdocumentBycontratdossier_prevu($id_document_prestataire,$id_contrat_prestataire);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getdocument_valideBycisco")
        {
            $menu = $this->Document_prestataire_scanManager->finddocument_valideBycisco($id_cisco);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_prestataire= array();
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $document_prestataire = $this->Document_prestataireManager->findById($value->id_document_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                    $data[$key]['document_prestataire'] = $document_prestataire;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getdocument_invalideBycisco")
        {
            $menu = $this->Document_prestataire_scanManager->finddocument_invalideBycisco($id_cisco);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_prestataire= array();
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $document_prestataire = $this->Document_prestataireManager->findById($value->id_document_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                    $data[$key]['document_prestataire'] = $document_prestataire;
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
            $document_prestataire = $this->Document_prestataireManager->findById($document_prestataire_scan->id_document_prestataire);
            $data['id'] = $document_prestataire_scan->id;
            $data['fichier'] = $document_prestataire_scan->fichier;
            $data['date_elaboration'] = $document_prestataire_scan->date_elaboration;
            $data['observation'] = $document_prestataire_scan->observation;
            $data['contrat_prestataire'] = $contrat_prestataire;
            $data['document_prestataire'] = $document_prestataire;
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
                    $document_prestataire = $this->Document_prestataireManager->findById($value->id_document_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                    $data[$key]['document_prestataire'] = $document_prestataire;
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
                    'id_document_prestataire' => $this->post('id_document_prestataire'),
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
                    'id_document_prestataire' => $this->post('id_document_prestataire'),
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
