<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Avancement_batiment extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('avancement_batiment_model', 'Avancement_batimentManager');
        $this->load->model('attachement_batiment_model', 'Attachement_batimentManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_batiment_construction = $this->get('id_batiment_construction');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $menu = $this->get('menu');

         if ($menu=='getavancementinvalideBycontrat')
         {
            $tmp = $this->Avancement_batimentManager->findavancementinvalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $attachement_batiment = $this->Attachement_batimentManager->findById($value->id_attachement_batiment);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['intitule']   = $value->intitule;
                    $data[$key]['observation']    = $value->observation;
                    $data[$key]['date']   = $value->date;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['attachement_batiment'] = $attachement_batiment;
                }
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getavancementvalideBycontrat')
         {
            $tmp = $this->Avancement_batimentManager->findavancementvalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $attachement_batiment = $this->Attachement_batimentManager->findById($value->id_attachement_batiment);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['intitule']   = $value->intitule;
                    $data[$key]['observation']    = $value->observation;
                    $data[$key]['date']   = $value->date;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['attachement_batiment'] = $attachement_batiment;
                }
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getavancementBycontrat')
         {
            $tmp = $this->Avancement_batimentManager->findavancementBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $attachement_batiment = $this->Attachement_batimentManager->findById($value->id_attachement_batiment);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['intitule']   = $value->intitule;
                    $data[$key]['observation']    = $value->observation;
                    $data[$key]['date']   = $value->date;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['attachement_batiment'] = $attachement_batiment;
                }
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getavancementBybatiment')
         {
            $tmp = $this->Avancement_batimentManager->findAllByBatiment_construction($id_batiment_construction);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $attachement_batiment = $this->Attachement_batimentManager->findById($value->id_attachement_batiment);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['intitule']   = $value->intitule;
                    $data[$key]['observation']    = $value->observation;
                    $data[$key]['date']   = $value->date;
                    $data[$key]['attachement_batiment'] = $attachement_batiment;
                }
            } 
                else
                    $data = array();
        }   
        elseif ($id)
        {
            $data = array();
            $avancement_batiment = $this->Avancement_batimentManager->findById($id);

            $attachement_batiment = $this->Attachement_batimentManager->findById($avancement_batiment->id_attachement_batiment);

            $data['id'] = $avancement_batiment->id;
            $data['description'] = $avancement_batiment->description;
            $data['intitule']   = $avancement_batiment->intitule;
            $data['observation']    = $avancement_batiment->observation;
            $data['date']   = $avancement_batiment->date;
            $data['attachement_batiment'] = $attachement_batiment;
        } 
        else 
        {
            $menu = $this->Avancement_batimentManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $attachement_batiment = $this->Attachement_batimentManager->findById($value->id_attachement_batiment);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['intitule']   = $value->intitule;
                    $data[$key]['observation']    = $value->observation;
                    $data[$key]['date']   = $value->date;
                    $data[$key]['attachement_batiment'] = $attachement_batiment;
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
                    'description' => $this->post('description'),
                    'intitule'   => $this->post('intitule'),
                    'observation'    => $this->post('observation'),
                    'date'   => $this->post('date'),
                    'id_batiment_construction' => $this->post('id_batiment_construction'),
                    'id_attachement_batiment' => $this->post('id_attachement_batiment'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Avancement_batimentManager->add($data);
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
                    'description' => $this->post('description'),
                    'intitule'   => $this->post('intitule'),
                    'observation'    => $this->post('observation'),
                    'date'   => $this->post('date'),
                    'id_batiment_construction' => $this->post('id_batiment_construction'),
                    'id_attachement_batiment' => $this->post('id_attachement_batiment'),
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
                $update = $this->Avancement_batimentManager->update($id, $data);
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
            $delete = $this->Avancement_batimentManager->delete($id);         
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
