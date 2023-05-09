<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Transfert_ufp extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('transfert_ufp_model', 'Transfert_ufpManager');
        $this->load->model('demande_deblocage_daaf_model', 'Demande_deblocage_daafManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_demande_daaf = $this->get('id_demande_daaf');
        $id_demande_deblocage_daaf = $this->get('id_demande_deblocage_daaf');
        $id_transfert_ufp = $this->get('id_transfert_ufp');
        $menu = $this->get('menu');
            
        if ($menu=='gettransfertvalidebyid_demande') 
        {   
            $tmp = $this->Transfert_ufpManager->gettransfertvalidebyid_demande($id_demande_daaf);
            if ($tmp) 
            {
                $data = $tmp;
            }
            else
                $data = array();
        }
        elseif ($menu=='gettransfert_ufpvalideById') 
        {   
            $tmp = $this->Transfert_ufpManager->gettransfert_ufpvalideById($id_transfert_ufp);
            if ($tmp) 
            {
                $data = $tmp;
            }
            else
                $data = array();
        }
        elseif ($id_demande_deblocage_daaf) 
        {   $data = array();
            $tmp = $this->Transfert_ufpManager->findBydemande_deblocage_daaf($id_demande_deblocage_daaf);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_deblocage_daaf = array();
                    $demande_deblocage_daaf = $this->Demande_deblocage_daafManager->findById($value->id_demande_deblocage_daaf);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_transfert'] = $value->montant_transfert;
                    $data[$key]['frais_bancaire'] = $value->frais_bancaire;
                    $data[$key]['montant_total'] = $value->montant_total;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['demande_deblocage_daaf'] = $demande_deblocage_daaf;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $transfert_ufp = $this->Transfert_ufpManager->findById($id);
            $demande_deblocage_daaf = $this->Demande_deblocage_daafManager->findById($transfert_ufp->id_demande_deblocage_daaf);
            $data['id'] = $transfert_ufp->id;
            $data['montant_transfert'] = $transfert_ufp->montant_transfert;
            $data['frais_bancaire'] = $transfert_ufp->frais_bancaire;
            $data['montant_total'] = $transfert_ufp->montant_total;
            $data['date'] = $transfert_ufp->date;
            $data['observation'] = $transfert_ufp->observation;
            $data['validation'] = $transfert_ufp->validation;
            $data['demande_deblocage_daaf'] = $demande_deblocage_daaf;
        } 
        else 
        {
            $menu = $this->Transfert_ufpManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $demande_deblocage_daaf = $this->Demande_deblocage_daafManager->findById($value->id_demande_deblocage_daaf);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_transfert'] = $value->montant_transfert;
                    $data[$key]['frais_bancaire'] = $value->frais_bancaire;
                    $data[$key]['montant_total'] = $value->montant_total;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['demande_deblocage_daaf'] = $demande_deblocage_daaf;
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
                    'montant_transfert' => $this->post('montant_transfert'),
                    'frais_bancaire' => $this->post('frais_bancaire'),
                    'montant_total' => $this->post('montant_total'),
                    'date' => $this->post('date'),
                    'observation' => $this->post('observation'),
                    'id_demande_deblocage_daaf' => $this->post('id_demande_deblocage_daaf'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Transfert_ufpManager->add($data);
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
                    'montant_transfert' => $this->post('montant_transfert'),
                    'frais_bancaire' => $this->post('frais_bancaire'),
                    'montant_total' => $this->post('montant_total'),
                    'date' => $this->post('date'),
                    'observation' => $this->post('observation'),
                    'id_demande_deblocage_daaf' => $this->post('id_demande_deblocage_daaf'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Transfert_ufpManager->update($id, $data);
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
            $delete = $this->Transfert_ufpManager->delete($id);         
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
