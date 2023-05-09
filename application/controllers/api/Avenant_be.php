<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Avenant_be extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('avenant_be_model', 'Avenant_beManager');
        $this->load->model('contrat_be_model', 'Contrat_beManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_avenant_moe = $this->get('id_avenant_moe');
        $id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');
        $menu = $this->get('menu');

         if ($menu=='getavenantinvalideBycontrat')
         {
            $tmp = $this->Avenant_beManager->findavenantinvalideBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_avenant']    = $value->ref_avenant;
                    $data[$key]['montant']   = $value->montant;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['validation'] = $value->validation;

                    $data[$key]['contrat_be'] = $contrat_be;
                        }*/
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getavenantvalideBycontrat')
         {
            $tmp = $this->Avenant_beManager->findavenantvalideBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_avenant']    = $value->ref_avenant;
                    $data[$key]['montant']   = $value->montant;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['validation'] = $value->validation;

                    $data[$key]['contrat_be'] = $contrat_be;
                        }*/
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getavenantBycontrat')
         {
            $tmp = $this->Avenant_beManager->findavenantBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_avenant']    = $value->ref_avenant;
                    $data[$key]['montant']   = $value->montant;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['validation'] = $value->validation;

                    $data[$key]['contrat_be'] = $contrat_be;
                        }*/
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getavenantvalideById')
         {
            $tmp = $this->Avenant_beManager->getavenantvalideById($id_avenant_moe);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }   
        elseif ($id)
        {
            $data = array();
            $avenant_be = $this->Avenant_beManager->findById($id);
            $contrat_be = $this->Contrat_beManager->findById($avenant_be->id_contrat_bureau_etude);

            $data['id'] = $avenant_be->id;
            $data['description'] = $avenant_be->description;
            $data['ref_avenant']    = $avenant_be->ref_avenant;
            $data['montant']   = $avenant_be->montant;
            $data['date_signature'] = $avenant_be->date_signature;

            $data['contrat_be'] = $contrat_be;
        } 
        else 
        {
            $tmp = $this->Avenant_beManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {                   
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_avenant']    = $value->ref_avenant;
                    $data[$key]['montant']   = $value->montant;
                    $data[$key]['date_signature'] = $value->date_signature;

                    $data[$key]['contrat_be'] = $contrat_be;
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
                    'ref_avenant'    => $this->post('ref_avenant'),
                    'montant'   => $this->post('montant'),
                    'date_signature' => $this->post('date_signature'),
                    'validation' => $this->post('validation'),
                    'id_contrat_bureau_etude' => $this->post('id_contrat_bureau_etude')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Avenant_beManager->add($data);
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
                    'ref_avenant'    => $this->post('ref_avenant'),
                    'montant'   => $this->post('montant'),
                    'date_signature' => $this->post('date_signature'),
                    'validation' => $this->post('validation'),
                    'id_contrat_bureau_etude' => $this->post('id_contrat_bureau_etude')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Avenant_beManager->update($id, $data);
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
            $delete = $this->Avenant_beManager->delete($id);         
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
