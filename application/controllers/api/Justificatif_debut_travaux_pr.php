<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Justificatif_debut_travaux_pr extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('justificatif_debut_travaux_pr_model', 'Justificatif_debut_travaux_prManager');
       $this->load->model('demande_debut_travaux_pr_model', 'Demande_debut_travaux_prManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_demande_debut_travaux_pr = $this->get('id_demande_debut_travaux_pr');
            
        if ($id_demande_debut_travaux_pr)
        {
            $tmp = $this->Justificatif_debut_travaux_prManager->findAllBydemande($id_demande_debut_travaux_pr);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $demande_debut_travaux_pr= array();
                    $demande_debut_travaux_pr = $this->Demande_debut_travaux_prManager->findById($value->id_demande_debut_travaux_pr);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
                    $data[$key]['demande_debut_travaux_pr'] = $demande_debut_travaux_pr;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $justificatif_debut_travaux_pr = $this->Justificatif_debut_travaux_prManager->findById($id);
            $demande_debut_travaux_pr = $this->Demande_debut_travaux_prManager->findById($justificatif_debut_travaux_pr->id_demande_debut_travaux_pr);
            $data['id'] = $justificatif_debut_travaux_pr->id;
            $data['description'] = $justificatif_debut_travaux_pr->description;
            $data['fichier'] = $justificatif_debut_travaux_pr->fichier;
            //$data['date'] = $justificatif_debut_travaux_pr->date;
            $data['demande_debut_travaux_pr'] = $demande_debut_travaux_pr;
        } 
        else 
        {
            $menu = $this->Justificatif_debut_travaux_prManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $demande_debut_travaux_pr= array();
                    $demande_debut_travaux_pr = $this->Demande_debut_travaux_prManager->findById($value->id_demande_debut_travaux_pr);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
                    $data[$key]['demande_debut_travaux_pr'] = $demande_debut_travaux_pr;
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
                    'description' => $this->post('description'),
                    'fichier' => $this->post('fichier'),
                    'id_demande_debut_travaux_pr' => $this->post('id_demande_debut_travaux_pr')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Justificatif_debut_travaux_prManager->add($data);
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
                    'description' => $this->post('description'),
                    'fichier' => $this->post('fichier'),
                    'id_demande_debut_travaux_pr' => $this->post('id_demande_debut_travaux_pr')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Justificatif_debut_travaux_prManager->update($id, $data);
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
            $delete = $this->Justificatif_debut_travaux_prManager->delete($id);         
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
