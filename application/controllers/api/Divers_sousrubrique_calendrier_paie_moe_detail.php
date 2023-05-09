<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Divers_sousrubrique_calendrier_paie_moe_detail extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('divers_sousrubrique_calendrier_paie_moe_detail_model', 'Divers_sousrubrique_calendrier_paie_moe_detailManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_sousrubrique = $this->get('id_sousrubrique');
        $menu = $this->get('menu');

        if ($menu == 'getdetailsousrubriquebysousrubrique') 
        {   $data = array();
            $tmp = $this->Divers_sousrubrique_calendrier_paie_moe_detailManager->getdetailsousrubriquebysousrubrique($id_sousrubrique);
           
            if ($tmp) 
            {
                $data = $tmp;
            }
        }
        elseif ($id)
        {
            $data = array();
            $divers_sousrubrique_calendrier_paie_moe_detail = $this->Divers_sousrubrique_calendrier_paie_moe_detailManager->findById($id);
            $data['id'] = $divers_sousrubrique_calendrier_paie_moe_detail->id;
            $data['libelle'] = $divers_sousrubrique_calendrier_paie_moe_detail->libelle;
            $data['description'] = $divers_sousrubrique_calendrier_paie_moe_detail->description;
        } 
        else 
        {
            $tmp = $this->Divers_sousrubrique_calendrier_paie_moe_detailManager->findAll();
            if ($tmp) 
            {
                $data=$tmp;
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
                    'libelle' => $this->post('libelle'),
                    'description' => $this->post('description'),
                    'pourcentage' => $this->post('pourcentage'),
                    'condition_paiement' => $this->post('condition_paiement'),
                    'id_sousrubrique' => $this->post('id_sousrubrique')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Divers_sousrubrique_calendrier_paie_moe_detailManager->add($data);
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
                    'libelle' => $this->post('libelle'),
                    'description' => $this->post('description'),
                    'pourcentage' => $this->post('pourcentage'),
                    'condition_paiement' => $this->post('condition_paiement'),
                    'id_sousrubrique' => $this->post('id_sousrubrique')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Divers_sousrubrique_calendrier_paie_moe_detailManager->update($id, $data);
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
            $delete = $this->Divers_sousrubrique_calendrier_paie_moe_detailManager->delete($id);         
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
