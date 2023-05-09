<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Justificatif_transfert_reliquat extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('justificatif_transfert_reliquat_model', 'Justificatif_transfert_reliquatManager');
       $this->load->model('transfert_reliquat_model', 'Transfert_reliquatManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_transfert_reliquat = $this->get('id_transfert_reliquat');
            
        if ($id_transfert_reliquat)
        {
            $tmp = $this->Justificatif_transfert_reliquatManager->findAllBytransfert($id_transfert_reliquat);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $transfert_reliquat= array();
                    $transfert_reliquat = $this->Transfert_reliquatManager->findById($value->id_transfert_reliquat);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
                    $data[$key]['transfert_reliquat'] = $transfert_reliquat;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $justificatif_transfert_reliquat = $this->Justificatif_transfert_reliquatManager->findById($id);
            $transfert_reliquat = $this->Transfert_reliquatManager->findById($justificatif_transfert_reliquat->id_transfert_reliquat);
            $data['id'] = $justificatif_transfert_reliquat->id;
            $data['description'] = $justificatif_transfert_reliquat->description;
            $data['fichier'] = $justificatif_transfert_reliquat->fichier;
            //$data['date'] = $justificatif_transfert_reliquat->date;
            $data['transfert_reliquat'] = $transfert_reliquat;
        } 
        else 
        {
            $menu = $this->Justificatif_transfert_reliquatManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $transfert_reliquat= array();
                    $transfert_reliquat = $this->Transfert_reliquatManager->findById($value->id_transfert_reliquat);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    //$data[$key]['date'] = $value->date;
                    $data[$key]['transfert_reliquat'] = $transfert_reliquat;
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
                    'description' => $this->post('description'),
                    'fichier' => $this->post('fichier'),
                    'id_transfert_reliquat' => $this->post('id_transfert_reliquat')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Justificatif_transfert_reliquatManager->add($data);
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
                    'description' => $this->post('description'),
                    'fichier' => $this->post('fichier'),
                    'id_transfert_reliquat' => $this->post('id_transfert_reliquat')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Justificatif_transfert_reliquatManager->update($id, $data);
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
            $delete = $this->Justificatif_transfert_reliquatManager->delete($id);         
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
