<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Mpe_soumissionaire extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mpe_soumissionaire_model', 'Mpe_soumissionaireManager');
        $this->load->model('passation_marches_model', 'Passation_marchesManager');
        $this->load->model('prestataire_model', 'PrestataireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_passation_marches = $this->get('id_passation_marches');

        if ($id_passation_marches)
        {
            $mpe_soumissionaire = $this->Mpe_soumissionaireManager->findAllByPassation($id_passation_marches );
            if ($mpe_soumissionaire) 
            {
                foreach ($mpe_soumissionaire as $key => $value) 
                {                   
                    
                    $passation_marches = $this->Passation_marchesManager->findById($value->id_passation_marches);
                    $prestataire = $this->PrestataireManager->findById($value->id_prestataire);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['passation_marches'] = $passation_marches;
                    $data[$key]['prestataire'] = $prestataire;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $mpe_soumissionaire = $this->Mpe_soumissionaireManager->findById($id);
            $prestataire = $this->PrestataireManager->findById($mpe_soumissionaire->id_prestataire);
            $passation_marches = $this->Passation_marchesManager->findById($mpe_soumissionaire->id_passation_marches);

            $data['id'] = $mpe_soumissionaire->id;
            $data['prestataire'] = $prestataire;
            $data['passation_marches'] = $passation_marches;
        } 
        else 
        {
            $menu = $this->Convention_cisco_feffi_enteteManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $data = array();

                    $prestataire = $this->PrestataireManager->findById($value->id_prestataire);
                    $passation_marches = $this->Passation_marchesManager->findById($value->id_passation_marches);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['prestataire'] = $prestataire;
                    $data[$key]['passation_marches'] = $passation_marches;
                    
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
        $menu = $this->post('menu') ;
        $id_passation_marches = $this->post('id_passation_marches');
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'id_passation_marches' => $this->post('id_passation_marches'),
                    'id_prestataire' => $this->post('id_prestataire')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Mpe_soumissionaireManager->add($data);
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
                    'id_passation_marches' => $this->post('id_passation_marches'),
                    'id_prestataire' => $this->post('id_prestataire')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Mpe_soumissionaireManager->update($id, $data);
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
            $delete = $this->Mpe_soumissionaireManager->delete($id);         
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
