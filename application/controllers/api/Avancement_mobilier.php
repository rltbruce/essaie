<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Avancement_mobilier extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('avancement_mobilier_model', 'Avancement_mobilierManager');
        $this->load->model('attachement_mobilier_model', 'Attachement_mobilierManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_mobilier_construction = $this->get('id_mobilier_construction');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $menu = $this->get('menu');

         if ($menu=='getavancementinvalideBycontrat')
         {
            $tmp = $this->Avancement_mobilierManager->findavancementinvalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $attachement_mobilier = $this->Attachement_mobilierManager->findById($value->id_attachement_mobilier);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['intitule']   = $value->intitule;
                    $data[$key]['observation']    = $value->observation;
                    $data[$key]['date']   = $value->date;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['attachement_mobilier'] = $attachement_mobilier;
                }
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getavancementvalideBycontrat')
         {
            $tmp = $this->Avancement_mobilierManager->findavancementvalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $attachement_mobilier = $this->Attachement_mobilierManager->findById($value->id_attachement_mobilier);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['intitule']   = $value->intitule;
                    $data[$key]['observation']    = $value->observation;
                    $data[$key]['date']   = $value->date;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['attachement_mobilier'] = $attachement_mobilier;
                }
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getavancementBycontrat')
         {
            $tmp = $this->Avancement_mobilierManager->findavancementBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $attachement_mobilier = $this->Attachement_mobilierManager->findById($value->id_attachement_mobilier);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['intitule']   = $value->intitule;
                    $data[$key]['observation']    = $value->observation;
                    $data[$key]['date']   = $value->date;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['attachement_mobilier'] = $attachement_mobilier;
                }
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getavancementBymobilier')
         {
            $menu = $this->Avancement_mobilierManager->findAllBymobilier_construction($id_mobilier_construction);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $attachement_mobilier = $this->Attachement_mobilierManager->findById($value->id_attachement_mobilier);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['intitule']   = $value->intitule;
                    $data[$key]['observation']    = $value->observation;
                    $data[$key]['date']   = $value->date;
                    $data[$key]['attachement_mobilier'] = $attachement_mobilier;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($id)
        {
            $data = array();
            $avancement_mobilier = $this->Avancement_mobilierManager->findById($id);

            $attachement_mobilier = $this->Attachement_mobilierManager->findById($avancement_mobilier->id_attachement_mobilier);

            $data['id'] = $avancement_mobilier->id;
            $data['description'] = $avancement_mobilier->description;
            $data['intitule']   = $avancement_mobilier->intitule;
            $data['observation']    = $avancement_mobilier->observation;
            $data['date']   = $avancement_mobilier->date;
            $data['attachement_mobilier'] = $attachement_mobilier;
        } 
        else 
        {
            $menu = $this->Avancement_mobilierManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $attachement_mobilier = $this->Attachement_mobilierManager->findById($value->id_attachement_mobilier);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['intitule']   = $value->intitule;
                    $data[$key]['observation']    = $value->observation;
                    $data[$key]['date']   = $value->date;
                    $data[$key]['attachement_mobilier'] = $attachement_mobilier;
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
                    'id_mobilier_construction' => $this->post('id_mobilier_construction'),                    
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),                    
                    'validation' => $this->post('validation'),
                    'id_attachement_mobilier' => $this->post('id_attachement_mobilier')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Avancement_mobilierManager->add($data);
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
                    'id_mobilier_construction' => $this->post('id_mobilier_construction'),                    
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),                    
                    'validation' => $this->post('validation'),
                    'id_attachement_mobilier' => $this->post('id_attachement_mobilier')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Avancement_mobilierManager->update($id, $data);
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
            $delete = $this->Avancement_mobilierManager->delete($id);         
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
