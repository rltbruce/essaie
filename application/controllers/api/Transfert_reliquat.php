<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class transfert_reliquat extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Transfert_reliquat_model', 'Transfert_reliquatManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');       
        $menu = $this->get('menu');
        $validation = $this->get('validation');
        $id_cisco = $this->get('id_cisco');
        $id_convention_entete = $this->get('id_convention_entete');

        if ($menu=="getmontantatransfererByconvention")
        {
            $tmp = $this->Transfert_reliquatManager->getmontantatransfererByconvention($id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=="gettransfertByconvention")
        {
            $tmp = $this->Transfert_reliquatManager->findtransfertByconvention($id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=="gettransfertvalideByconvention")
        {
            $tmp = $this->Transfert_reliquatManager->findtransfertvalideByconvention($id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=="gettransfertinvalideByconvention")
        {
            $tmp = $this->Transfert_reliquatManager->findtransfertinvalideByconvention($id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=="gettransfertinvalideBycisco")
        {
            $tmp = $this->Transfert_reliquatManager->findtransfertinvalideByCisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {   
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['date_transfert'] = $value->date_transfert;
                    $data[$key]['objet_utilisation'] = $value->objet_utilisation;
                    $data[$key]['intitule_compte'] = $value->intitule_compte;
                    $data[$key]['rib'] = $value->rib;                    
                    $data[$key]['convention_entete'] = $convention_entete;
                    
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $tmp = $this->Transfert_reliquatManager->findByIddate_transfert($id);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {   
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['objet_utilisation'] = $value->objet_utilisation;
                    $data[$key]['date_transfert'] = $value->date_transfert;
                    $data[$key]['intitule_compte'] = $value->intitule_compte;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['rib'] = $value->rib;                    
                    $data[$key]['convention_entete'] = $convention_entete;
                    
                }
            } 
                else
                    $data = array();
        } 
        else 
        {
            $menu = $this->Transfert_reliquatManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {   
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['objet_utilisation'] = $value->objet_utilisation;
                    $data[$key]['date_transfert'] = $value->date_transfert;
                    $data[$key]['intitule_compte'] = $value->intitule_compte;
                    $data[$key]['rib'] = $value->rib;                    
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
                    'date_transfert' => $this->post('date_transfert'),
                    'objet_utilisation' => $this->post('objet_utilisation'),
                    'situation_utilisation' => $this->post('situation_utilisation'),
                    'rib' => $this->post('rib'),
                    'intitule_compte' => $this->post('intitule_compte'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'validation' => $this->post('validation'),
                    'observation' => $this->post('observation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Transfert_reliquatManager->add($data);
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
                    'date_transfert' => $this->post('date_transfert'),
                    'objet_utilisation' => $this->post('objet_utilisation'),
                    'situation_utilisation' => $this->post('situation_utilisation'),
                    'rib' => $this->post('rib'),
                    'intitule_compte' => $this->post('intitule_compte'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'validation' => $this->post('validation'),
                    'observation' => $this->post('observation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Transfert_reliquatManager->update($id, $data);
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
            $delete = $this->Transfert_reliquatManager->delete($id);         
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
