<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Avancement_physi_mobilier extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('avancement_physi_mobilier_model', 'Avancement_physi_mobilierManager');
        //$this->load->model('divers_attachement_mobilier_detail_model','Divers_attachement_mobilier_detailManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $menu = $this->get('menu');

         if ($menu=='getavancementBycontrat')
         {
            $tmp = $this->Avancement_physi_mobilierManager->findavancementBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$attachement_detail = $this->Divers_attachement_mobilier_detailManager->findById($value->id_attachement_detail);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['pourcentage']    = $value->pourcentage;
                    $data[$key]['date']   = $value->date;
                    $data[$key]['pourcentage_prevu']    = $value->pourcentage_prevu;
                }
            } 
                else
                    $data = array();
        }  
        elseif ($id)
        {
            $data = array();
            $avancement_physi_mobilier = $this->Avancement_physi_mobilierManager->findById($id);

            //$attachement_detail = $this->Divers_attachement_mobilier_detailManager->findById($avancement_detail->id_attachement_detail);

            
            $data[$key]['id'] = $avancement_physi_mobilier->id;
            $data[$key]['pourcentage']    = $avancement_physi_mobilier->pourcentage;
            $data[$key]['date']   = $avancement_physi_mobilier->date;
            $data[$key]['pourcentage_prevu']    = $avancement_physi_mobilier->pourcentage_prevu;
        } 
        else 
        {
            $menu = $this->Avancement_mobilierManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    //$attachement_detail = $this->Divers_attachement_mobilier_detailManager->findById($value->id_attachement_detail);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['pourcentage']    = $value->pourcentage;
                    $data[$key]['date']   = $value->date;
                    $data[$key]['pourcentage_prevu']    = $value->pourcentage_prevu;
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
                    'pourcentage' => $this->post('pourcentage'),
                    'date'   => $this->post('date'),
                    'pourcentage_prevu' => $this->post('pourcentage_prevu'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire')
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
                    'pourcentage' => $this->post('pourcentage'),
                    'date'   => $this->post('date'),
                    'pourcentage_prevu' => $this->post('pourcentage_prevu'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire')
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
