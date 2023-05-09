<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Prestation_mpe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('prestation_mpe_model', 'Prestation_mpeManager');
        $this->load->model('contrat_prestataire_model', 'Contrat_prestatireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_cisco = $this->get('id_cisco');
        $menu = $this->get('menu');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');

         if ($menu=='getprestationBycontrat')
         {
            $tmp = $this->Prestation_mpeManager->findprestationBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_prestataire = $this->Contrat_prestatireManager->findById($value->id_contrat_prestataire);
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_pre_debu_trav'] = $value->date_pre_debu_trav;
                    $data[$key]['date_reel_debu_trav']= $value->date_reel_debu_trav;
                    $data[$key]['delai_execution']    = $value->delai_execution;
                    $data[$key]['date_expiration_assurance_mpe']   = $value->date_expiration_assurance_mpe;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                        }
            } 
                else
                    $data = array();
        }  
        elseif ($menu=='getprestationinvalideBycisco')
         {
            $tmp = $this->Prestation_mpeManager->findprestationinvalideBycisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_prestataire = $this->Contrat_prestatireManager->findById($value->id_contrat_prestataire);
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_pre_debu_trav'] = $value->date_pre_debu_trav;
                    $data[$key]['date_reel_debu_trav']= $value->date_reel_debu_trav;
                    $data[$key]['delai_execution']    = $value->delai_execution;
                    $data[$key]['date_expiration_assurance_mpe']   = $value->date_expiration_assurance_mpe;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                        }
            } 
                else
                    $data = array();
        }  
        elseif ($id)
        {
            $data = array();
            $prestation_mpe = $this->Prestation_mpeManager->findById($id);

            $contrat_prestataire = $this->Contrat_prestatireManager->findById($prestation_mpe->id_contrat_prestataire);

            $data['id'] = $prestation_mpe->id;
            $data['date_pre_debu_trav'] = $prestation_mpe->date_pre_debu_trav;
            $data['date_reel_debu_trav']   = $prestation_mpe->date_reel_debu_trav;
            $data['delai_execution']    = $prestation_mpe->delai_execution;
            $data['date_expiration_assurance_mpe']   = $prestation_mpe->date_expiration_assurance_mpe;
            $data['validation']   = $prestation_mpe->validation;
            $data['contrat_prestataire'] = $contrat_prestataire;
        } 
        else 
        {
            $tmp = $this->Prestation_mpeManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_prestataire = $this->Contrat_prestatireManager->findById($value->id_contrat_prestataire);
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_pre_debu_trav'] = $value->date_pre_debu_trav;
                    $data[$key]['date_reel_debu_trav']   = $value->date_reel_debu_trav;
                    $data[$key]['delai_execution']    = $value->delai_execution;
                    $data[$key]['date_expiration_assurance_mpe']   = $value->date_expiration_assurance_mpe;
                    $data[$key]['validation']   = $value->validation;
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
                     'id' => $this->post('id'),
                    'date_pre_debu_trav' => $this->post('date_pre_debu_trav'),
                    'date_reel_debu_trav'   => $this->post('date_reel_debu_trav'),
                    'delai_execution'    => $this->post('delai_execution'),
                    'date_expiration_assurance_mpe'   => $this->post('date_expiration_assurance_mpe'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'validation' => $this->post('validation'),
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Prestation_mpeManager->add($data);
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
                    'id' => $this->post('id'),
                    'date_pre_debu_trav' => $this->post('date_pre_debu_trav'),
                    'date_reel_debu_trav'   => $this->post('date_reel_debu_trav'),
                    'delai_execution'    => $this->post('delai_execution'),
                    'date_expiration_assurance_mpe'   => $this->post('date_expiration_assurance_mpe'),
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
                $update = $this->Prestation_mpeManager->update($id, $data);
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
            $delete = $this->Prestation_mpeManager->delete($id);         
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
