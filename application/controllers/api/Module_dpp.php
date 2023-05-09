<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Module_dpp extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('module_dpp_model', 'Module_dppManager');
        $this->load->model('contrat_partenaire_relai_model', 'Contrat_partenaire_relaiManager');
        $this->load->model('participant_dpp_model', 'Participant_dppManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_partenaire_relai = $this->get('id_contrat_partenaire_relai');
        $menu = $this->get('menu');
        $id_module = $this->get('id_module');

        if ($menu=='getmoduleBycontrat')
         {
            $tmp = $this->Module_dppManager->findmoduleBycontrat($id_contrat_partenaire_relai);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $nbr_parti= $this->Participant_dppManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_dppManager->count_femininbyId($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_debut_previ_form'] = $value->date_debut_previ_form;
                    $data[$key]['date_fin_previ_form']   = $value->date_fin_previ_form;
                    $data[$key]['date_previ_resti']    = $value->date_previ_resti;
                    $data[$key]['date_debut_reel_form'] = $value->date_debut_reel_form;
                    $data[$key]['date_fin_reel_form'] = $value->date_fin_reel_form;
                    $data[$key]['date_reel_resti'] = $value->date_reel_resti;
                    $data[$key]['nbr_previ_parti']   = $value->nbr_previ_parti;
                    $data[$key]['nbr_parti']    = $nbr_parti->nbr_participant;
                    $data[$key]['nbr_previ_fem_parti']   = $value->nbr_previ_fem_parti;
                    $data[$key]['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['lieu_formation'] = $value->lieu_formation;
                    $data[$key]['observation']   = $value->observation;
                    $data[$key]['validation']   = $value->validation;
                    //$data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getmodulevalideBycontrat')
         {
            $tmp = $this->Module_dppManager->findvalideBycontrat($id_contrat_partenaire_relai);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $nbr_parti= $this->Participant_dppManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_dppManager->count_femininbyId($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_debut_previ_form'] = $value->date_debut_previ_form;
                    $data[$key]['date_fin_previ_form']   = $value->date_fin_previ_form;
                    $data[$key]['date_previ_resti']    = $value->date_previ_resti;
                    $data[$key]['date_debut_reel_form'] = $value->date_debut_reel_form;
                    $data[$key]['date_fin_reel_form'] = $value->date_fin_reel_form;
                    $data[$key]['date_reel_resti'] = $value->date_reel_resti;
                    $data[$key]['nbr_previ_parti']   = $value->nbr_previ_parti;
                    $data[$key]['nbr_parti']    = $nbr_parti->nbr_participant;
                    $data[$key]['nbr_previ_fem_parti']   = $value->nbr_previ_fem_parti;
                    $data[$key]['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['lieu_formation'] = $value->lieu_formation;
                    $data[$key]['observation']   = $value->observation;
                    $data[$key]['validation']   = $value->validation;
                    //$data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getmodulevalideById')
         {
            $tmp = $this->Module_dppManager->findvalideById($id_module);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $nbr_parti= $this->Participant_dppManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_dppManager->count_femininbyId($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_debut_previ_form'] = $value->date_debut_previ_form;
                    $data[$key]['date_fin_previ_form']   = $value->date_fin_previ_form;
                    $data[$key]['date_previ_resti']    = $value->date_previ_resti;
                    $data[$key]['date_debut_reel_form'] = $value->date_debut_reel_form;
                    $data[$key]['date_fin_reel_form'] = $value->date_fin_reel_form;
                    $data[$key]['date_reel_resti'] = $value->date_reel_resti;
                    $data[$key]['nbr_previ_parti']   = $value->nbr_previ_parti;
                    $data[$key]['nbr_parti']    = $nbr_parti->nbr_participant;
                    $data[$key]['nbr_previ_fem_parti']   = $value->nbr_previ_fem_parti;
                    $data[$key]['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['lieu_formation'] = $value->lieu_formation;
                    $data[$key]['observation']   = $value->observation;
                    $data[$key]['validation']   = $value->validation;
                    //$data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getmoduleinvalideBycontrat')
         {
            $tmp = $this->Module_dppManager->findinvalideBycontrat($id_contrat_partenaire_relai);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $nbr_parti= $this->Participant_dppManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_dppManager->count_femininbyId($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_debut_previ_form'] = $value->date_debut_previ_form;
                    $data[$key]['date_fin_previ_form']   = $value->date_fin_previ_form;
                    $data[$key]['date_previ_resti']    = $value->date_previ_resti;
                    $data[$key]['date_debut_reel_form'] = $value->date_debut_reel_form;
                    $data[$key]['date_fin_reel_form'] = $value->date_fin_reel_form;
                    $data[$key]['date_reel_resti'] = $value->date_reel_resti;
                    $data[$key]['nbr_previ_parti']   = $value->nbr_previ_parti;
                    $data[$key]['nbr_parti']    = $nbr_parti->nbr_participant;
                    $data[$key]['nbr_previ_fem_parti']   = $value->nbr_previ_fem_parti;
                    $data[$key]['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['lieu_formation'] = $value->lieu_formation;
                    $data[$key]['observation']   = $value->observation;
                    $data[$key]['validation']   = $value->validation;
                    //$data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                }
            } 
                else
                    $data = array();
        }/* if ($menu=='getmodule_dppByinvalide')
         {
            $menu = $this->Module_dppManager->findAllByinvalide();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $nbr_parti= $this->Participant_dppManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_dppManager->count_femininbyId($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_debut_previ_form'] = $value->date_debut_previ_form;
                    $data[$key]['date_fin_previ_form']   = $value->date_fin_previ_form;
                    $data[$key]['date_previ_resti']    = $value->date_previ_resti;
                    $data[$key]['date_debut_reel_form'] = $value->date_debut_reel_form;
                    $data[$key]['date_fin_reel_form'] = $value->date_fin_reel_form;
                    $data[$key]['date_reel_resti'] = $value->date_reel_resti;
                    $data[$key]['nbr_previ_parti']   = $value->nbr_previ_parti;
                    $data[$key]['nbr_parti']    = $nbr_parti->nbr_participant;
                    $data[$key]['nbr_previ_fem_parti']   = $value->nbr_previ_fem_parti;
                    $data[$key]['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['lieu_formation'] = $value->lieu_formation;
                    $data[$key]['observation']   = $value->observation;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getmodule_dppByDate')
         {
            $menu = $this->Module_dppManager->findAllBydate();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $nbr_parti= $this->Participant_dppManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_dppManager->count_femininbyId($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_debut_previ_form'] = $value->date_debut_previ_form;
                    $data[$key]['date_fin_previ_form']   = $value->date_fin_previ_form;
                    $data[$key]['date_previ_resti']    = $value->date_previ_resti;
                    $data[$key]['date_debut_reel_form'] = $value->date_debut_reel_form;
                    $data[$key]['date_fin_reel_form'] = $value->date_fin_reel_form;
                    $data[$key]['date_reel_resti'] = $value->date_reel_resti;
                    $data[$key]['nbr_previ_parti']   = $value->nbr_previ_parti;
                    $data[$key]['nbr_parti']    = $nbr_parti->nbr_participant;
                    $data[$key]['nbr_previ_fem_parti']   = $value->nbr_previ_fem_parti;
                    $data[$key]['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['lieu_formation'] = $value->lieu_formation;
                    $data[$key]['observation']   = $value->observation;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getmodule_dppBycontrat')
         {
            $menu = $this->Module_dppManager->findAllBycontrat($id_contrat_partenaire_relai);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);

                    $nbr_parti= $this->Participant_dppManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_dppManager->count_femininbyId($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_debut_previ_form'] = $value->date_debut_previ_form;
                    $data[$key]['date_fin_previ_form']   = $value->date_fin_previ_form;
                    $data[$key]['date_previ_resti']    = $value->date_previ_resti;
                    $data[$key]['date_debut_reel_form'] = $value->date_debut_reel_form;
                    $data[$key]['date_fin_reel_form'] = $value->date_fin_reel_form;
                    $data[$key]['date_reel_resti'] = $value->date_reel_resti;
                    $data[$key]['nbr_previ_parti']   = $value->nbr_previ_parti;
                    $data[$key]['nbr_parti']    = $nbr_parti->nbr_participant;
                    $data[$key]['nbr_previ_fem_parti']   = $value->nbr_previ_fem_parti;
                    $data[$key]['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['lieu_formation'] = $value->lieu_formation;
                    $data[$key]['observation']   = $value->observation;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
                        }
            } 
                else
                    $data = array();
        }  */ 
        elseif ($id)
        {
            $data = array();
            $module_dpp = $this->Module_dppManager->findById($id);

            //$contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($module_dpp->id_contrat_partenaire_relai);
            $nbr_parti= $this->Participant_dppManager->count_participantbyId($module_dpp->id);
            $nbr_feminin= $this->Participant_dppManager->count_femininbyId($module_dpp->id);

            $data['id'] = $module_dpp->id;
            $data['date_debut_previ_form'] = $module_dpp->date_debut_previ_form;
            $data['date_fin_previ_form']   = $module_dpp->date_fin_previ_form;
            $data['date_previ_resti']    = $module_dpp->date_previ_resti;
            $data['date_debut_reel_form'] = $module_dpp->date_debut_reel_form;
            $data['date_fin_reel_form'] = $module_dpp->date_fin_reel_form;
            $data['date_reel_resti'] = $module_dpp->date_reel_resti;
            $data['nbr_previ_parti']   = $module_dpp->nbr_previ_parti;
            $data['nbr_parti']    = $nbr_parti->nbr_participant;
            $data['nbr_previ_fem_parti']   = $module_dpp->nbr_previ_fem_parti;
            $data['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
            $data['lieu_formation'] = $module_dpp->lieu_formation;
            $data['observation']   = $module_dpp->observation;
            $data['validation']   = $module_dpp->validation;
            //$data['contrat_partenaire_relai'] = $contrat_partenaire_relai;
        } 
        else 
        {
            $tmp = $this->Module_dppManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);
                    $nbr_parti= $this->Participant_dppManager->count_participantbyId($value->id);
                    $nbr_feminin= $this->Participant_dppManager->count_femininbyId($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_debut_previ_form'] = $value->date_debut_previ_form;
                    $data[$key]['date_fin_previ_form']   = $value->date_fin_previ_form;
                    $data[$key]['date_previ_resti']    = $value->date_previ_resti;
                    $data[$key]['date_debut_reel_form'] = $value->date_debut_reel_form;
                    $data[$key]['date_fin_reel_form'] = $value->date_fin_reel_form;
                    $data[$key]['date_reel_resti'] = $value->date_reel_resti;
                    $data[$key]['nbr_previ_parti']   = $value->nbr_previ_parti;
                    $data[$key]['nbr_parti']    = $nbr_parti->nbr_participant;
                    $data[$key]['nbr_previ_fem_parti']   = $value->nbr_previ_fem_parti;
                    $data[$key]['nbr_reel_fem_parti'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['lieu_formation'] = $value->lieu_formation;
                    $data[$key]['observation']   = $value->observation;
                    $data[$key]['validation']   = $value->validation;
                    //$data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;
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
                    'date_debut_previ_form' => $this->post('date_debut_previ_form'),
                    'date_fin_previ_form'   => $this->post('date_fin_previ_form'),
                    'date_previ_resti'    => $this->post('date_previ_resti'),
                    'date_debut_reel_form' => $this->post('date_debut_reel_form'),
                    'date_fin_reel_form' => $this->post('date_fin_reel_form'),
                    'date_reel_resti' => $this->post('date_reel_resti'),
                    'nbr_previ_parti'   => $this->post('nbr_previ_parti'),
                    //'nbr_parti'    => $this->post('nbr_parti'),
                    'nbr_previ_fem_parti'   => $this->post('nbr_previ_fem_parti'),
                    //'nbr_reel_fem_parti' => $this->post('nbr_reel_fem_parti'),
                    'lieu_formation' => $this->post('lieu_formation'),
                    'observation' => $this->post('observation'),
                    'id_contrat_partenaire_relai' => $this->post('id_contrat_partenaire_relai'),
                    'validation' => $this->post('validation'),
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Module_dppManager->add($data);
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
                    'date_debut_previ_form' => $this->post('date_debut_previ_form'),
                    'date_fin_previ_form'   => $this->post('date_fin_previ_form'),
                    'date_previ_resti'    => $this->post('date_previ_resti'),
                    'date_debut_reel_form' => $this->post('date_debut_reel_form'),
                    'date_fin_reel_form' => $this->post('date_fin_reel_form'),
                    'date_reel_resti' => $this->post('date_reel_resti'),
                    'nbr_previ_parti'   => $this->post('nbr_previ_parti'),
                    'nbr_parti'    => $this->post('nbr_parti'),
                    'nbr_previ_fem_parti'   => $this->post('nbr_previ_fem_parti'),
                    'nbr_reel_fem_parti' => $this->post('nbr_reel_fem_parti'),
                    'lieu_formation' => $this->post('lieu_formation'),
                    'observation' => $this->post('observation'),
                    'id_contrat_partenaire_relai' => $this->post('id_contrat_partenaire_relai'),
                    'validation' => $this->post('validation'),
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Module_dppManager->update($id, $data);
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
            $delete = $this->Module_dppManager->delete($id);         
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
