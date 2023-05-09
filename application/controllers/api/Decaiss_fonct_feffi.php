<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Decaiss_fonct_feffi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('decaiss_fonct_feffi_model', 'Decaiss_fonct_feffiManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_entete = $this->get('id_convention_entete');
        $id_decaiss_fonct_feffi = $this->get('id_decaiss_fonct_feffi');
        $menu = $this->get('menu');        
        $id_cisco = $this->get('id_cisco');
            
        if ($menu=='getddecaiss_fonct_feffiById') 
        {   $data = array();
            $tmp = $this->Decaiss_fonct_feffiManager->getddecaiss_fonct_feffiById($id_decaiss_fonct_feffi);
            if ($tmp) 
            {
                $data = $tmp;
            }
        }
        elseif ($menu=='getdecaissByconvention') 
        {   $data = array();
            $tmp = $this->Decaiss_fonct_feffiManager->findallByconvention($id_convention_entete);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $convention_entete = array();
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['date_decaissement'] = $value->date_decaissement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['convention_entete'] = $convention_entete;
                }
            }
        }
        elseif ($menu=='getdecaiss_valideByconvention') 
        {   $data = array();
            $tmp = $this->Decaiss_fonct_feffiManager->findvalideByconvention($id_convention_entete);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $convention_entete = array();
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['date_decaissement'] = $value->date_decaissement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['convention_entete'] = $convention_entete;
                }
            }
        }
        elseif ($menu=='getdecaiss_invalideByconvention') 
        {   $data = array();
            $tmp = $this->Decaiss_fonct_feffiManager->findinvalideByconvention($id_convention_entete);
            if ($tmp) 
            {
                $data = $tmp;
                /* foreach ($tmp as $key => $value) 
                {
                    $convention_entete = array();
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['date_decaissement'] = $value->date_decaissement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['convention_entete'] = $convention_entete;
                }*/
            }
        }
        elseif ($menu=='getdecaiss_invalideBycisco') 
        {   $data = array();
            $tmp = $this->Decaiss_fonct_feffiManager->findinvalideBycisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $convention_entete = array();
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['date_decaissement'] = $value->date_decaissement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['convention_entete'] = $convention_entete;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $decais = $this->Decaiss_fonct_feffiManager->findById($id);
            $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($decais->id_convention_entete);
            $data['id'] = $decais->id;
            $data['montant'] = $decais->montant;
            $data['date_decaissement'] = $decais->date_decaissement;
            $data['observation'] = $decais->observation;
            $data['validation'] = $decais->validation;
            $data['convention_entete'] = $convention_entete;
        } 
        else 
        {
            $tmp = $this->Decaiss_fonct_feffiManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['date_decaissement'] = $value->date_decaissement;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['convention_entete'] = $convention_entete;
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
                    'montant' => $this->post('montant'),
                    'date_decaissement' => $this->post('date_decaissement'),
                    'observation' => $this->post('observation'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Decaiss_fonct_feffiManager->add($data);
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
                    'montant' => $this->post('montant'),
                    'date_decaissement' => $this->post('date_decaissement'),
                    'observation' => $this->post('observation'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Decaiss_fonct_feffiManager->update($id, $data);
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
            $delete = $this->Decaiss_fonct_feffiManager->delete($id);         
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
