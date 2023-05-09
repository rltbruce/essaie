<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Phase_sous_projet_construction extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('phase_sous_projet_construction_model', 'Phase_sous_projet_constructionManager');
        $this->load->model('phase_sous_projets_model', 'Phase_sous_projetsManager');
        $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_cisco = $this->get('id_cisco');
        $menu = $this->get('menu');
            
        if ($menu =='getphaseBycontrat') 
        {   $data = array();
            $tmp = $this->Phase_sous_projet_constructionManager->findphaseBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {   $phase_sous_projet = $this->Phase_sous_projetsManager->findById($value->id_phase_sous_projet);
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['phase_sous_projet'] = $phase_sous_projet;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                }
            }
        }
        elseif ($menu =='getphaseinvalideBycisco') 
        {   $data = array();
            $tmp = $this->Phase_sous_projet_constructionManager->findphaseinvalideBycisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {   $phase_sous_projet = $this->Phase_sous_projetsManager->findById($value->id_phase_sous_projet);
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['phase_sous_projet'] = $phase_sous_projet;
                    $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $phase_sous_projet_construction = $this->Phase_sous_projet_constructionManager->findById($id);
            $phase_sous_projet = $this->Phase_sous_projetsManager->findById($phase_sous_projet_construction->id_phase_sous_projet);
            $contrat_prestataire = $this->Contrat_prestataireManager->findById($phase_sous_projet_construction->id_contrat_prestataire);
            $data['id'] = $phase_sous_projet_construction->id;
            $data['validation'] = $phase_sous_projet_construction->validation;
            $data['phase_sous_projet'] = $phase_sous_projet;
            $data['contrat_prestataire'] = $contrat_prestataire;
        } 
        else 
        {
            $menu = $this->Phase_sous_projet_constructionManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {   
                    $phase_sous_projet = $this->Phase_sous_projetsManager->findById($value->id_phase_sous_projet);
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['phase_sous_projet'] = $phase_sous_projet;
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
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'id_phase_sous_projet' => $this->post('id_phase_sous_projet'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Phase_sous_projet_constructionManager->add($data);
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
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'id_phase_sous_projet' => $this->post('id_phase_sous_projet'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Phase_sous_projet_constructionManager->update($id, $data);
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
            $delete = $this->Phase_sous_projet_constructionManager->delete($id);         
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
