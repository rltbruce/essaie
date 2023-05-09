<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Pv_consta_rubrique_phase_lat extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('pv_consta_rubrique_phase_lat_model', 'Pv_consta_rubrique_phase_latManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_pv_consta_entete_travaux = $this->get('id_pv_consta_entete_travaux');
        $menu = $this->get('menu');

        if ($menu=='getpv_consta_rubrique_phase_pourcentagebycontrat')
        {
            $tmp = $this->Pv_consta_rubrique_phase_latManager->getpv_consta_rubrique_phase_pourcentagebycontrat($id_contrat_prestataire,$id_pv_consta_entete_travaux);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        } 
        elseif ($id)
        {
            $data = array();
            $pv_consta_rubrique_phase_lat = $this->Pv_consta_rubrique_phase_latManager->findById($id);
            $data['id'] = $pv_consta_rubrique_phase_lat->id;
            $data['libelle'] = $pv_consta_rubrique_phase_lat->libelle;
            $data['description'] = $pv_consta_rubrique_phase_lat->description;
            $data['numero'] = $pv_consta_rubrique_phase_lat->numero;
            $data['pourcentage_prevu'] = $pv_consta_rubrique_phase_lat->pourcentage_prevu;
        } 
        else 
        {
            $tmp = $this->Pv_consta_rubrique_phase_latManager->findAll();
            if ($tmp) 
            {
                $data = $tmp;
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
                    'libelle' => $this->post('libelle'),
                    'description' => $this->post('description'),
                    'numero' => $this->post('numero'),
                    'pourcentage_prevu' => $this->post('pourcentage_prevu')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Pv_consta_rubrique_phase_latManager->add($data);
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
                    'libelle' => $this->post('libelle'),
                    'description' => $this->post('description'),
                    'numero' => $this->post('numero'),
                    'pourcentage_prevu' => $this->post('pourcentage_prevu')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Pv_consta_rubrique_phase_latManager->update($id, $data);
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
            $delete = $this->Pv_consta_rubrique_phase_latManager->delete($id);         
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
