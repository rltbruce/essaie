<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Avancement_latrine extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('avancement_latrine_model', 'Avancement_latrineManager');
        $this->load->model('attachement_latrine_model', 'Attachement_latrineManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_latrine_construction = $this->get('id_latrine_construction');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $menu = $this->get('menu');

         if ($menu=='getavancementinvalideBycontrat')
         {
            $tmp = $this->Avancement_latrineManager->findavancementinvalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $attachement_latrine = $this->Attachement_latrineManager->findById($value->id_attachement_latrine);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['intitule']   = $value->intitule;
                    $data[$key]['observation']    = $value->observation;
                    $data[$key]['date']   = $value->date;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['attachement_latrine'] = $attachement_latrine;
                }
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getavancementvalideBycontrat')
         {
            $tmp = $this->Avancement_latrineManager->findavancementvalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $attachement_latrine = $this->Attachement_latrineManager->findById($value->id_attachement_latrine);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['intitule']   = $value->intitule;
                    $data[$key]['observation']    = $value->observation;
                    $data[$key]['date']   = $value->date;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['attachement_latrine'] = $attachement_latrine;
                }
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getavancementBycontrat')
         {
            $tmp = $this->Avancement_latrineManager->findavancementBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $attachement_latrine = $this->Attachement_latrineManager->findById($value->id_attachement_latrine);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['intitule']   = $value->intitule;
                    $data[$key]['observation']    = $value->observation;
                    $data[$key]['date']   = $value->date;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['attachement_latrine'] = $attachement_latrine;
                }
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getavancementBylatrine')
         {
            $menu = $this->Avancement_latrineManager->findAllBylatrine_construction($id_latrine_construction);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $attachement_latrine = $this->Attachement_latrineManager->findById($value->id_attachement_latrine);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['intitule']   = $value->intitule;
                    $data[$key]['observation']    = $value->observation;
                    $data[$key]['date']   = $value->date;
                    $data[$key]['attachement_latrine'] = $attachement_latrine;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($id)
        {
            $data = array();
            $avancement_latrine = $this->Avancement_latrineManager->findById($id);

            $attachement_latrine = $this->Attachement_latrineManager->findById($avancement_latrine->id_attachement_latrine);

            $data['id'] = $avancement_latrine->id;
            $data['description'] = $avancement_latrine->description;
            $data['intitule']   = $avancement_latrine->intitule;
            $data['observation']    = $avancement_latrine->observation;
            $data['date']   = $avancement_latrine->date;
            $data['attachement_latrine'] = $attachement_latrine;
        } 
        else 
        {
            $menu = $this->Avancement_latrineManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $attachement_latrine = $this->Attachement_latrineManager->findById($value->id_attachement_latrine);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['intitule']   = $value->intitule;
                    $data[$key]['observation']    = $value->observation;
                    $data[$key]['date']   = $value->date;
                    $data[$key]['attachement_latrine'] = $attachement_latrine;
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
                    'id_latrine_construction' => $this->post('id_latrine_construction'),
                    'id_attachement_latrine' => $this->post('id_attachement_latrine'),
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
                $dataId = $this->Avancement_latrineManager->add($data);
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
                    'id_latrine_construction' => $this->post('id_latrine_construction'),
                    'id_attachement_latrine' => $this->post('id_attachement_latrine'),
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
                $update = $this->Avancement_latrineManager->update($id, $data);
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
            $delete = $this->Avancement_latrineManager->delete($id);         
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
