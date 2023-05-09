<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Pv_consta_rubrique_designation_lat extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('pv_consta_rubrique_designation_lat_model', 'Pv_consta_rubrique_designation_latManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_rubrique_phase = $this->get('id_rubrique_phase');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_pv_consta_entete_travaux = $this->get('id_pv_consta_entete_travaux');
        $menu = $this->get('menu');

        if ($menu == 'getpv_consta_statutravauxbyphasecontrat') 
        {   $data = array();
            $tmp = $this->Pv_consta_rubrique_designation_latManager->getpv_consta_statutravauxbyphasecontrat($id_rubrique_phase,$id_pv_consta_entete_travaux,$id_contrat_prestataire);
           
            if ($tmp) 
            {
                //$data = $tmp;
                foreach ($tmp as $key => $value)
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['numero'] = $value->numero;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['id_designation'] = $value->id_designation;
                   // $data[$key]['id_pv_consta_entete_travaux'] = $value->id_pv_consta_entete_travaux;
                    if ($value->periode==1)
                    {
                        $data[$key]['periode'] = true;
                    }
                    else
                    {
                        $data[$key]['periode'] = false;
                    }
                    if ($value->anterieur==1)
                    {
                        $data[$key]['anterieur'] = true;
                    }
                    else
                    {
                        $data[$key]['anterieur'] = false;
                    }
                }
            }
            else
            $data=array();
        }
        elseif ($menu == 'getrubrique_designation_lat') 
        {   $data = array();
            $tmp = $this->Pv_consta_rubrique_designation_latManager->getrubrique_designation_lat($id_rubrique_phase);
           
            if ($tmp) 
            {
                $data = $tmp;
            }
        }
        elseif ($id)
        {
            $data = array();
            $pv_consta_rubrique_designation_lat = $this->Pv_consta_rubrique_designation_latManager->findById($id);
            $data['id'] = $pv_consta_rubrique_designation_lat->id;
            $data['libelle'] = $pv_consta_rubrique_designation_lat->libelle;
            $data['description'] = $pv_consta_rubrique_designation_lat->description;
            $data['numero'] = $pv_consta_rubrique_designation_lat->numero;
        } 
        else 
        {
            $tmp = $this->Pv_consta_rubrique_designation_latManager->findAll();
            if ($tmp) 
            {
                $data=$tmp;
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
                    'id_rubrique_phase' => $this->post('id_rubrique_phase')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Pv_consta_rubrique_designation_latManager->add($data);
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
                    'id_rubrique_phase' => $this->post('id_rubrique_phase')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Pv_consta_rubrique_designation_latManager->update($id, $data);
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
            $delete = $this->Pv_consta_rubrique_designation_latManager->delete($id);         
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
