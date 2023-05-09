<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Convention_ufp_daaf_detail extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('convention_ufp_daaf_detail_model', 'Convention_ufp_daaf_detailManager');
        $this->load->model('convention_ufp_daaf_entete_model', 'Convention_ufp_daaf_enteteManager');
        $this->load->model('compte_daaf_model', 'Compte_daafManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_ufp_daaf_entete = $this->get('id_convention_ufp_daaf_entete');
        $id_zone_subvention = $this->get('id_zone_subvention');
        $id_acces_zone = $this->get('id_acces_zone');

        if ($id_convention_ufp_daaf_entete)
        {
            $detail = $this->Convention_ufp_daaf_detailManager->findAllByEntete($id_convention_ufp_daaf_entete );
            if ($detail) 
            {
                foreach ($detail as $key => $value) 
                {                     
                    $convention_ufp_daaf_entete = $this->Convention_ufp_daaf_enteteManager->findById($value->id_convention_ufp_daaf_entete);

                    $compte_daaf = $this->Compte_daafManager->findById($value->id_compte_daaf);

                    $data[$key]['id'] = $value->id;                    
                    $data[$key]['convention_ufp_daaf_entete'] = $convention_ufp_daaf_entete;                    
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['delai'] = $value->delai;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['compte_daaf'] = $compte_daaf;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $convention_ufp_daaf_detail = $this->Convention_ufp_daaf_detailManager->findById($id);
            $convention_ufp_daaf_entete = $this->Convention_ufp_daaf_enteteManager->findById($convention_ufp_daaf_detail->id_convention_ufp_daaf_entete);
            $compte_daaf = $this->Compte_daafManager->findById($convention_ufp_daaf_detail->id_compte_daaf);

            $data['id'] = $convention_ufp_daaf_detail->id;
            $data['convention_ufp_daaf_entete'] = $convention_ufp_daaf_detail->convention_ufp_daaf_entete;
            $data['date_signature'] = $convention_ufp_daaf_detail->date_signature;
            $data['delai'] = $convention_ufp_daaf_detail->delai;
            $data['observation'] = $convention_ufp_daaf_detail->observation;
            $data['compte_feffi'] = $compte_feffi;
        } 
        else 
        {
            $menu = $this->Convention_ufp_daaf_detailManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $data = array();
                    $convention_ufp_daaf_entete = $this->Convention_ufp_daaf_enteteManager->findById($value->id_convention_ufp_daaf_entete);
                    $compte_daaf = $this->Compte_daafManager->findById($value->id_compte_daaf);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['convention_ufp_daaf_entete'] = $convention_ufp_daaf_entete;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['delai'] = $value->delai;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['compte_daaf'] = $compte_daaf;
                    
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
        $id_convention_ufp_daaf_entete = $this->post('id_convention_ufp_daaf_entete');

        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'id_convention_ufp_daaf_entete' => $this->post('id_convention_ufp_daaf_entete'),
                    'date_signature' => $this->post('date_signature'),
                    'delai' => $this->post('delai'),
                    'observation' => $this->post('observation'),
                    'id_compte_daaf' => $this->post('id_compte_daaf')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Convention_ufp_daaf_detailManager->add($data);
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
                    'id_convention_ufp_daaf_entete' => $this->post('id_convention_ufp_daaf_entete'),
                    'date_signature' => $this->post('date_signature'),
                    'delai' => $this->post('delai'),
                    'observation' => $this->post('observation'),
                    'id_compte_daaf' => $this->post('id_compte_daaf')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Convention_ufp_daaf_detailManager->update($id, $data);
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
            $delete = $this->Convention_ufp_daaf_detailManager->delete($id);         
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
