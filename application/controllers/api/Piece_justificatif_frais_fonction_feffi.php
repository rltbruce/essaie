<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Piece_justificatif_frais_fonction_feffi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('piece_justificatif_frais_fonction_feffi_model', 'Piece_justificatif_frais_fonction_feffiManager');
       
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_addition_frais = $this->get('id_addition_frais');
        $menu = $this->get('menu');
            
        if ($id_addition_frais)
        {
            $tmp = $this->Piece_justificatif_frais_fonction_feffiManager->findAllByjustificatif($id_addition_frais);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    if ($value->id == null)
                    {
                        $data[$key]['id'] = 0;
                    }
                    else
                    {
                        $data[$key]['id'] = $value->id;
                    }
                    
                    $data[$key]['code'] = $value->code;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['id_justificatif_prevu'] = $value->id_justificatif_prevu;
                    $data[$key]['fichier'] = $value->fichier;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $piece_justificatif_frais_fonction_feffi = $this->Piece_justificatif_frais_fonction_feffiManager->findById($id);
            $data['id'] = $piece_justificatif_frais_fonction_feffi->id;
            $data['description'] = $piece_justificatif_frais_fonction_feffi->description;
            $data['fichier'] = $piece_justificatif_frais_fonction_feffi->fichier;
        } 
        else 
        {
            $menu = $this->Piece_justificatif_frais_fonction_feffiManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {                   
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
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
                    'fichier' => $this->post('fichier'),
                    'id_addition_frais' => $this->post('id_addition_frais'),
                    'id_justificatif_prevu' => $this->post('id_justificatif_prevu')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Piece_justificatif_frais_fonction_feffiManager->add($data);
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
                    'fichier' => $this->post('fichier'),
                    'id_addition_frais' => $this->post('id_addition_frais'),
                    'id_justificatif_prevu' => $this->post('id_justificatif_prevu')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Piece_justificatif_frais_fonction_feffiManager->update($id, $data);
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
            $delete = $this->Piece_justificatif_frais_fonction_feffiManager->delete($id);         
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
