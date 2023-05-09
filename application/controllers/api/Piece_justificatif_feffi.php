<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Piece_justificatif_feffi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('piece_justificatif_feffi_model', 'Piece_justificatif_feffiManager');
       $this->load->model('demande_realimentation_feffi_model', 'Demande_realimentation_feffiManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_demande_rea_feffi = $this->get('id_demande_rea_feffi');
        $id_tranche = $this->get('id_tranche');
        $menu = $this->get('menu');
            
        if ($id_demande_rea_feffi)
        {
            $tmp = $this->Piece_justificatif_feffiManager->findAllBydemande($id_demande_rea_feffi,$id_tranche);
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
                    $data[$key]['id_demande_rea_feffi'] = $value->id_demande_rea_feffi;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $piece_justificatif_feffi = $this->Piece_justificatif_feffiManager->findById($id);
            $demande_realimentation_feffi = $this->Demande_realimentation_feffiManager->findById($piece_justificatif_feffi->id_demande_rea_feffi);
            $data['id'] = $piece_justificatif_feffi->id;
            $data['description'] = $piece_justificatif_feffi->description;
            $data['fichier'] = $piece_justificatif_feffi->fichier;
            $data['date'] = $piece_justificatif_feffi->date;
            $data['demande_realimentation_feffi'] = $demande_realimentation_feffi;
        } 
        else 
        {
            $menu = $this->Piece_justificatif_feffiManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $demande_realimentation_feffi= array();
                    $demande_realimentation_feffi = $this->Demande_realimentation_feffiManager->findById($value->id_demande_rea_feffi);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['demande_realimentation_feffi'] = $demande_realimentation_feffi;
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
                    'id_demande_rea_feffi' => $this->post('id_demande_rea_feffi'),
                    'id_justificatif_prevu' => $this->post('id_justificatif_prevu')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Piece_justificatif_feffiManager->add($data);
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
                    'id_demande_rea_feffi' => $this->post('id_demande_rea_feffi'),
                    'id_justificatif_prevu' => $this->post('id_justificatif_prevu')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Piece_justificatif_feffiManager->update($id, $data);
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
            $delete = $this->Piece_justificatif_feffiManager->delete($id);         
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
