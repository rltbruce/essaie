<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Transfert_daaf extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('transfert_daaf_model', 'Transfert_daafManager');
       $this->load->model('demande_realimentation_feffi_model', 'Demande_realimentation_feffiManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_demande_rea_feffi = $this->get('id_demande_rea_feffi');
        $id_transfert_daaf = $this->get('id_transfert_daaf');
        $menu = $this->get('menu');
            
        if ($menu=='gettransferBydemande')
        {
            $tmp = $this->Transfert_daafManager->findtransfertBydemande($id_demande_rea_feffi);
            if ($tmp) 
            {
                $data = $tmp;
                /*foreach ($tmp as $key => $value) 
                {
                   // $demande_realimentation_feffi= array();                    
                   // $demande_realimentation_feffi = $this->Demande_realimentation_feffiManager->findById($value->id_demande_rea_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_transfert'] = $value->montant_transfert;
                    $data[$key]['frais_bancaire'] = $value->frais_bancaire;
                    $data[$key]['montant_total'] = $value->montant_total;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['demande_realimentation_feffi'] = $demande_realimentation_feffi;

                }*/
            } 
                else
                    $data = array();
        }
        elseif ($menu=='gettransfert_daafvalideById')
        {
            $tmp = $this->Transfert_daafManager->gettransfert_daafvalideById($id_transfert_daaf);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=='gettransferinvalideBydemande')
        {
            $tmp = $this->Transfert_daafManager->findinvalideBydemande($id_demande_rea_feffi);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_realimentation_feffi= array();                    
                    $demande_realimentation_feffi = $this->Demande_realimentation_feffiManager->findById($value->id_demande_rea_feffi);

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_transfert'] = $value->montant_transfert;
                    $data[$key]['frais_bancaire'] = $value->frais_bancaire;
                    $data[$key]['montant_total'] = $value->montant_total;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['demande_realimentation_feffi'] = $demande_realimentation_feffi;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='gettransfervalideBydemande')
        {
            $tmp = $this->Transfert_daafManager->findvalideBydemande($id_demande_rea_feffi);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_realimentation_feffi= array();                    
                    $demande_realimentation_feffi = $this->Demande_realimentation_feffiManager->findById($value->id_demande_rea_feffi);

                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_transfert'] = $value->montant_transfert;
                    $data[$key]['frais_bancaire'] = $value->frais_bancaire;
                    $data[$key]['montant_total'] = $value->montant_total;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['demande_realimentation_feffi'] = $demande_realimentation_feffi;

                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $transfert_daaf = $this->Transfert_daafManager->findById($id);
            $demande_realimentation_feffi = $this->Demande_realimentation_feffiManager->findById($transfert_daaf->id_demande_rea_feffi);

            $data['id'] = $transfert_daaf->id;
            $data['montant_transfert'] = $transfert_daaf->montant_transfert;
            $data['frais_bancaire'] = $transfert_daaf->frais_bancaire;
            $data['montant_total'] = $transfert_daaf->montant_total;
            $data['date'] = $transfert_daaf->date;
            $data['observation'] = $transfert_daaf->observation;
            $data['validation'] = $transfert_daaf->validation;
            $data['demande_realimentation_feffi'] = $demande_realimentation_feffi;
        } 
        else 
        {
            $tmp = $this->Transfert_daafManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$demande_realimentation_feffi= array();
                    //$demande_realimentation_feffi = $this->Demande_realimentation_feffiManager->findById($value->id_demande_rea_feffi);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant_transfert'] = $value->montant_transfert;
                    $data[$key]['frais_bancaire'] = $value->frais_bancaire;
                    $data[$key]['montant_total'] = $value->montant_total;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['mande'] = 'ato';
                    //$data[$key]['demande_realimentation_feffi'] = $demande_realimentation_feffi;
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
                    'validation' => $this->post('validation'),
                    'id_demande_rea_feffi' => $this->post('id_demande_rea_feffi')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Transfert_daafManager->add($data);
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
                    'validation' => $this->post('validation'),
                    'id_demande_rea_feffi' => $this->post('id_demande_rea_feffi')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Transfert_daafManager->update($id, $data);
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
            $delete = $this->Transfert_daafManager->delete($id);         
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
