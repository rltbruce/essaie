<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Addition_frais_fonctionnement extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('addition_frais_fonctionnement_model', 'Addition_frais_fonctionnementManager');
        $this->load->model('rubrique_addition_fonct_feffi_model', 'Rubrique_addition_fonct_feffiManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_entete = $this->get('id_convention_entete');
        $id_rubrique_addition = $this->get('id_rubrique_addition');
        $id_addition = $this->get('id_addition');
        $menu = $this->get('menu');//getaddition_frais_valideById

        if ($menu=='getaddition_valideByconvention')
        {
           $tmp = $this->Addition_frais_fonctionnementManager->getaddition_valideByconvention($id_convention_entete);
           if ($tmp) 
           {
               foreach ($tmp as $key => $value) 
               {
                   $rubrique_addition_fonct_feffi = $this->Rubrique_addition_fonct_feffiManager->findById($value->id_rubrique_addition);

                   $data[$key]['id'] = $value->id;
                   $data[$key]['observation'] = $value->observation;
                   $data[$key]['montant']   = $value->montant;
                   $data[$key]['validation'] = $value->validation;
                   $data[$key]['rubrique'] = $rubrique_addition_fonct_feffi;
               }
           } 
               else
                   $data = array();
       }  
       elseif ($menu=='getaddition_invalideByconvention')
         {
            $tmp = $this->Addition_frais_fonctionnementManager->getaddition_invalideByconvention($id_convention_entete);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $rubrique_addition_fonct_feffi = $this->Rubrique_addition_fonct_feffiManager->findById($value->id_rubrique_addition);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['montant']   = $value->montant;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['rubrique'] = $rubrique_addition_fonct_feffi;
                }
            } 
                else
                    $data = array();
        }  
        elseif ($menu=='getaddition_frais_fonctionnementById')
         {
            $tmp = $this->Addition_frais_fonctionnementManager->getaddition_frais_fonctionnementById($id_addition);
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
            $addition_frais_fonctionnement = $this->Addition_frais_fonctionnementManager->findById($id);
            $rubrique_addition_fonct_feffi = $this->Rubrique_addition_fonct_feffiManager->findById($Addition_frais_fonctionnement->id_rubrique_addition);

            $data['id'] = $addition_frais_fonctionnement->id;
            $data['observation'] = $addition_frais_fonctionnement->observation;
            $data['montant']   = $addition_frais_fonctionnement->montant;

            $data['rubrique'] = $rubrique_addition_fonct_feffi;
        } 
        else 
        {
            $tmp = $this->Addition_frais_fonctionnementManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {                   
                    $rubrique_addition_fonct_feffi = $this->Rubrique_addition_fonct_feffiManager->findById($value->id_rubrique_addition);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['montant']   = $value->montant;

                    $data[$key]['rubrique'] = $rubrique_addition_fonct_feffi;
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
                    'observation' => $this->post('observation'),
                    'montant'   => $this->post('montant'),
                    'validation' => $this->post('validation'),
                    'id_rubrique_addition' => $this->post('id_rubrique_addition'),
                    'id_convention_entete' => $this->post('id_convention_entete')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Addition_frais_fonctionnementManager->add($data);
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
                    'observation' => $this->post('observation'),
                    'montant'   => $this->post('montant'),
                    'validation' => $this->post('validation'),
                    'id_rubrique_addition' => $this->post('id_rubrique_addition'),
                    'id_convention_entete' => $this->post('id_convention_entete')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Addition_frais_fonctionnementManager->update($id, $data);
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
            $delete = $this->Addition_frais_fonctionnementManager->delete($id);         
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
