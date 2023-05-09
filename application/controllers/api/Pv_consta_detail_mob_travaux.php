<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Pv_consta_detail_mob_travaux extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('pv_consta_detail_mob_travaux_model', 'Pv_consta_detail_mob_travauxManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_rubrique_phase = $this->get('id_rubrique_phase');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_pv_consta_entete_travaux = $this->get('id_pv_consta_entete_travaux');
        $menu = $this->get('menu');

        if ($id)
        {
            $data = array();
            $pv_consta_detail_mob_travaux = $this->Pv_consta_detail_mob_travauxManager->findById($id);
            $data['id'] = $pv_consta_detail_mob_travaux->id;
            $data['id_pv_consta_entete_travaux'] = $pv_consta_detail_mob_travaux->id_pv_consta_entete_travaux;
            $data['id_rubrique_phase'] = $pv_consta_detail_mob_travaux->id_rubrique_phase;
            $data['periode'] = $pv_consta_detail_mob_travaux->periode;
            $data['observation'] = $pv_consta_detail_mob_travaux->observation;
        } 
        else 
        {
            $tmp = $this->Pv_consta_detail_mob_travauxManager->findAll();
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
    
        
        if (count($data)>0) {
            $this->response([
                'statu' => TRUE,
                'response' => $data,
                'message' => 'Get data success',
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'statu' => FALSE,
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
                    'id_pv_consta_entete_travaux' => $this->post('id_pv_consta_entete_travaux'),
                    'id_rubrique_phase' => $this->post('id_rubrique_phase'),
                    'periode' => $this->post('periode'),
                    'observation' => $this->post('observation')
                );
                if (!$data) {
                    $this->response([
                        'periode' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Pv_consta_detail_mob_travauxManager->add($data);
                if (!is_null($dataId)) {
                    $this->response([
                        'periode' => TRUE,
                        'response' => $dataId,
                        'message' => 'Data insert success'
                            ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'periode' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $data = array(
                    'id_pv_consta_entete_travaux' => $this->post('id_pv_consta_entete_travaux'),
                    'id_rubrique_phase' => $this->post('id_rubrique_phase'),
                    'periode' => $this->post('periode'),
                    'observation' => $this->post('observation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'periode' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Pv_consta_detail_mob_travauxManager->update($id, $data);
                if(!is_null($update)) {
                    $this->response([
                        'periode' => TRUE,
                        'response' => 1,
                        'message' => 'Update data success'
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'periode' => FALSE,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_OK);
                }
            }
        } else {
            if (!$id) {
                $this->response([
                    'periode' => FALSE,
                    'response' => 0,
                    'message' => 'No request found'
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $delete = $this->Pv_consta_detail_mob_travauxManager->delete($id);         
            if (!is_null($delete)) {
                $this->response([
                    'periode' => TRUE,
                    'response' => 1,
                    'message' => "Delete data success"
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'periode' => FALSE,
                    'response' => 0,
                    'message' => 'No request found'
                        ], REST_Controller::HTTP_OK);
            }
        }        
    }
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
