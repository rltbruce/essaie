<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Justificatif_pv_consta_entete_travaux_mpe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('justificatif_pv_consta_entete_travaux_mpe_model', 'Justificatif_pv_consta_entete_travaux_mpeManager');
       $this->load->model('pv_consta_entete_travaux_model', 'Pv_consta_entete_travauxManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_pv_consta_entete_travaux = $this->get('id_pv_consta_entete_travaux');
            
        if ($id_pv_consta_entete_travaux)
        {
            $tmp = $this->Justificatif_pv_consta_entete_travaux_mpeManager->findAllBydemande($id_pv_consta_entete_travaux);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $pv_consta_entete_travaux= array();
                    $pv_consta_entete_travaux = $this->Pv_consta_entete_travauxManager->findById($value->id_pv_consta_entete_travaux);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
                    $data[$key]['pv_consta_entete_travaux'] = $pv_consta_entete_travaux;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $justificatif_pv_consta_entete_travaux_mpe = $this->Justificatif_pv_consta_entete_travaux_mpeManager->findById($id);
            $pv_consta_entete_travaux = $this->Pv_consta_entete_travauxManager->findById($justificatif_pv_consta_entete_travaux_mpe->id_pv_consta_entete_travaux);
            $data['id'] = $justificatif_pv_consta_entete_travaux_mpe->id;
            $data['description'] = $justificatif_pv_consta_entete_travaux_mpe->description;
            $data['fichier'] = $justificatif_pv_consta_entete_travaux_mpe->fichier;
            //$data['date'] = $justificatif_pv_consta_entete_travaux_mpe->date;
            $data['pv_consta_entete_travaux'] = $pv_consta_entete_travaux;
        } 
        else 
        {
            $menu = $this->Justificatif_pv_consta_entete_travaux_mpeManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $pv_consta_entete_travaux= array();
                    $pv_consta_entete_travaux = $this->Pv_consta_entete_travauxManager->findById($value->id_pv_consta_entete_travaux);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
                    $data[$key]['pv_consta_entete_travaux'] = $pv_consta_entete_travaux;
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
                    'id_pv_consta_entete_travaux' => $this->post('id_pv_consta_entete_travaux')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Justificatif_pv_consta_entete_travaux_mpeManager->add($data);
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
                    'id_pv_consta_entete_travaux' => $this->post('id_pv_consta_entete_travaux')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Justificatif_pv_consta_entete_travaux_mpeManager->update($id, $data);
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
            $delete = $this->Justificatif_pv_consta_entete_travaux_mpeManager->delete($id);         
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
