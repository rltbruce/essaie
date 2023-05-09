<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Document_feffi_scan extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('document_feffi_scan_model', 'Document_feffi_scanManager');
        $this->load->model('document_feffi_model', 'Document_feffiManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        $this->load->model('feffi_model', 'FeffiManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_entete = $this->get('id_convention_entete');
        $validation = $this->get('validation');
        $id_cisco = $this->get('id_cisco');
        $id_document_feffi_scan = $this->get('id_document_feffi_scan');
        $id_document_feffi = $this->get('id_document_feffi');
        $menu = $this->get('menu');
            
        if ($menu == "getdocumentByconventiondossier_prevu")
        {
            $tmp = $this->Document_feffi_scanManager->getdocumentByconventiondossier_prevu($id_document_feffi,$id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getdocument_feffi_scanvalideById")
        {
            $tmp = $this->Document_feffi_scanManager->getdocument_feffi_scanvalideById($id_document_feffi_scan);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getdocument_valideBycisco")
        {
            $tmp = $this->Document_feffi_scanManager->findAllvalideBycisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$convention_entete= array();
                    //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    //$convention_cisco_feffi_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    //$feffi = $this->FeffiManager->findById($convention_cisco_feffi_entete->id_feffi);
                    $document_feffi = $this->Document_feffiManager->findById($value->id_document_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    //$data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['document_feffi'] = $document_feffi;
                    //$data[$key]['convention_entete'] = $convention_cisco_feffi_entete;
                    //$data[$key]['feffi'] = $feffi;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getdocument_invalideBycisco")
        {
            $tmp = $this->Document_feffi_scanManager->findAllinvalideBycisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$convention_entete= array();
                    //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    //$convention_cisco_feffi_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    //$feffi = $this->FeffiManager->findById($convention_cisco_feffi_entete->id_feffi);
                    $document_feffi = $this->Document_feffiManager->findById($value->id_document_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    //$data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['document_feffi'] = $document_feffi;
                    //$data[$key]['convention_entete'] = $convention_cisco_feffi_entete;
                    //$data[$key]['feffi'] = $feffi;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getdocumentByvalidation")
        {
            $tmp = $this->Document_feffi_scanManager->findAllByvalidation($validation);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$convention_entete= array();
                    //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    //$convention_cisco_feffi_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    //$feffi = $this->FeffiManager->findById($convention_cisco_feffi_entete->id_feffi);
                    $document_feffi = $this->Document_feffiManager->findById($value->id_document_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    //$data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['document_feffi'] = $document_feffi;
                    //$data[$key]['convention_entete'] = $convention_cisco_feffi_entete;
                    //$data[$key]['feffi'] = $feffi;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getdocument_feffi_scanByConvention")
        {
            $tmp = $this->Document_feffi_scanManager->findAllByconvention($id_convention_entete,$validation);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$convention_entete= array();
                    //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    //$convention_cisco_feffi_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    //$feffi = $this->FeffiManager->findById($convention_cisco_feffi_entete->id_feffi);
                    $document_feffi = $this->Document_feffiManager->findById($value->id_document_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    //$data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['document_feffi'] = $document_feffi;
                    //$data[$key]['convention_entete'] = $convention_cisco_feffi_entete;
                    //$data[$key]['feffi'] = $feffi;

                }
            } 
                else
                    $data = array();
        }
       /* if ($menu == "getmemoireByvalidation")
        {
            $tmp = $this->Document_feffi_scanManager->findAllByvalidation($validation);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $convention_entete = array();
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_livraison'] = $value->date_livraison;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['convention_entete'] = $convention_entete;
                }
            } 
                else
                    $data = array();
        }*/
        elseif ($id)
        {
            $data = array();
            $document_feffi_scan = $this->Document_feffi_scanManager->findById($id);
            //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($document_feffi_scan->id_convention_entete);
            //$convention_cisco_feffi_entete = $this->Convention_cisco_feffi_enteteManager->findById($document_feffi_scan->id_convention_entete);
            $document_feffi = $this->Document_feffiManager->findById($document_feffi_scan->id_document_feffi);
            //$feffi = $this->FeffiManager->findById($convention_cisco_feffi_entete->id_feffi);
            $data['id'] = $document_feffi_scan->id;
            $data['fichier'] = $document_feffi_scan->fichier;
            $data['date_elaboration'] = $document_feffi_scan->date_elaboration;
            $data['observation'] = $document_feffi_scan->observation;
            //$data['convention_entete'] = $convention_entete;
            $data['document_feffi'] = $document_feffi;
            //$data['convention_entete'] = $convention_cisco_feffi_entete;
            //$data['feffi'] = $feffi;
        } 
        else 
        {
            $menu = $this->Document_feffi_scanManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    //$convention_entete= array();
                    //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    //$convention_cisco_feffi_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $document_feffi = $this->Document_feffiManager->findById($value->id_document_feffi);
                    //$feffi = $this->FeffiManager->findById($convention_cisco_feffi_entete->id_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_elaboration'] = $value->date_elaboration;
                    $data[$key]['observation'] = $value->observation;
                    //$data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['document_feffi'] = $document_feffi;
                    //$data[$key]['convention_entete'] = $convention_cisco_feffi_entete;
                    //$data[$key]['feffi'] = $feffi;
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
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'id_document_feffi' => $this->post('id_document_feffi'),
                    'validation' => $this->post('validation'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Document_feffi_scanManager->add($data);
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
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'id_document_feffi' => $this->post('id_document_feffi'),
                    'validation' => $this->post('validation'),
                    'id_convention_entete' => $this->post('id_convention_entete')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Document_feffi_scanManager->update($id, $data);
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
            $delete = $this->Document_feffi_scanManager->delete($id);         
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
