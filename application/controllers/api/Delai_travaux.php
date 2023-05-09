<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Delai_travaux extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('delai_travaux_model', 'Delai_travauxManager');
        $this->load->model('contrat_prestataire_model', 'Contrat_prestatireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_delai_travaux = $this->get('id_delai_travaux');

         if ($menu=='getdelai_travauxBycontrat')
         {
            $tmp = $this->Delai_travauxManager->finddelai_travauxBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                $data = $tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $contrat_prestataire = $this->Contrat_prestatireManager->findById($value->id_contrat_prestataire);
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_prev_debu_travau'] = $value->date_prev_debu_travau;
                    $data[$key]['date_reel_debu_travau']= $value->date_reel_debu_travau;
                    $data[$key]['delai_execution']    = $value->delai_execution;
                    $data[$key]['date_expiration_police']   = $value->date_expiration_police;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                        }*/
            } 
                else
                    $data = array();
        }  
        elseif ($menu=='getdelai_travauxinvalideBycontrat')
         {
            $tmp = $this->Delai_travauxManager->finddelai_travauxinvalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                $data = $tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $contrat_prestataire = $this->Contrat_prestatireManager->findById($value->id_contrat_prestataire);
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_prev_debu_travau'] = $value->date_prev_debu_travau;
                    $data[$key]['date_reel_debu_travau']= $value->date_reel_debu_travau;
                    $data[$key]['delai_execution']    = $value->delai_execution;
                    $data[$key]['date_expiration_police']   = $value->date_expiration_police;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                }*/
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getdelai_travauxvalideById')
         {
            $tmp = $this->Delai_travauxManager->finddelai_travauxvalideById($id_delai_travaux);
            if ($tmp) 
            {
               $data = $tmp;
               /* foreach ($tmp as $key => $value) 
                {
                    $contrat_prestataire = $this->Contrat_prestatireManager->findById($value->id_contrat_prestataire);
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_prev_debu_travau'] = $value->date_prev_debu_travau;
                    $data[$key]['date_reel_debu_travau']= $value->date_reel_debu_travau;
                    $data[$key]['delai_execution']    = $value->delai_execution;
                    $data[$key]['date_expiration_police']   = $value->date_expiration_police;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                        }*/
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getdelai_travauxvalideBycontrat')
         {
            $tmp = $this->Delai_travauxManager->finddelai_travauxvalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
               $data = $tmp;
               /* foreach ($tmp as $key => $value) 
                {
                    $contrat_prestataire = $this->Contrat_prestatireManager->findById($value->id_contrat_prestataire);
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_prev_debu_travau'] = $value->date_prev_debu_travau;
                    $data[$key]['date_reel_debu_travau']= $value->date_reel_debu_travau;
                    $data[$key]['delai_execution']    = $value->delai_execution;
                    $data[$key]['date_expiration_police']   = $value->date_expiration_police;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                        }*/
            } 
                else
                    $data = array();
        }  
        elseif ($id)
        {
            $data = array();
            $delai_travaux = $this->Delai_travauxManager->findById($id);

            $contrat_prestataire = $this->Contrat_prestatireManager->findById($delai_travaux->id_contrat_prestataire);

            $data['id'] = $delai_travaux->id;
            $data['date_prev_debu_travau'] = $delai_travaux->date_prev_debu_travau;
            $data['date_reel_debu_travau']   = $delai_travaux->date_reel_debu_travau;
            $data['delai_execution']    = $delai_travaux->delai_execution;
            $data['date_expiration_police']   = $delai_travaux->date_expiration_police;
            $data['validation']   = $delai_travaux->validation;
            $data['contrat_prestataire'] = $contrat_prestataire;
        } 
        else 
        {
            $tmp = $this->Delai_travauxManager->findAll();
            if ($tmp) 
            {
                $data = $tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $contrat_prestataire = $this->Contrat_prestatireManager->findById($value->id_contrat_prestataire);
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_prev_debu_travau'] = $value->date_prev_debu_travau;
                    $data[$key]['date_reel_debu_travau']   = $value->date_reel_debu_travau;
                    $data[$key]['delai_travaux']    = $value->delai_travaux;
                    $data[$key]['date_expiration_police']   = $value->date_expiration_police;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                        }*/
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
                    'date_prev_debu_travau' => $this->post('date_prev_debu_travau'),
                    'date_reel_debu_travau'   => $this->post('date_reel_debu_travau'),
                    'delai_execution'    => $this->post('delai_execution'),
                    'date_expiration_police'   => $this->post('date_expiration_police'),
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
                $dataId = $this->Delai_travauxManager->add($data);
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
                    'date_prev_debu_travau' => $this->post('date_prev_debu_travau'),
                    'date_reel_debu_travau'   => $this->post('date_reel_debu_travau'),
                    'delai_execution'    => $this->post('delai_execution'),
                    'date_expiration_police'   => $this->post('date_expiration_police'),
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
                $update = $this->Delai_travauxManager->update($id, $data);
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
            $delete = $this->Delai_travauxManager->delete($id);         
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
