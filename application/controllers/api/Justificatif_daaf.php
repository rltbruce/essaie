<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class justificatif_daaf extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('justificatif_daaf_model', 'Justificatif_daafManager');
       $this->load->model('demande_deblocage_daaf_model', 'Demande_deblocage_daafManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_demande_deblocage_daaf = $this->get('id_demande_deblocage_daaf');
        $id_tranche = $this->get('id_tranche');
        $menu = $this->get('menu');
            
        if ($id_demande_deblocage_daaf)
        {
            $tmp = $this->Justificatif_daafManager->findAllBydemande($id_demande_deblocage_daaf,$id_tranche);
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
                    $data[$key]['id_demande_deblocage_daaf'] = $value->id_demande_deblocage_daaf;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $justificatif_daaf = $this->Justificatif_daafManager->findById($id);
            $demande_deblocage_daaf = $this->Demande_deblocage_daafManager->findById($justificatif_daaf->id_demande_deblocage_daaf);
            $data['id'] = $justificatif_daaf->id;
            $data['description'] = $justificatif_daaf->description;
            $data['fichier'] = $justificatif_daaf->fichier;
            $data['demande_deblocage_daaf'] = $demande_deblocage_daaf;
        } 
        else 
        {
            $menu = $this->Justificatif_daafManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $demande_deblocage_daaf= array();
                    $demande_deblocage_daaf = $this->Demande_deblocage_daafManager->findById($value->id_demande_deblocage_daaf);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['demande_deblocage_daaf'] = $demande_deblocage_daaf;
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
                    'id_demande_deblocage_daaf' => $this->post('id_demande_deblocage_daaf'),
                    'id_justificatif_prevu' => $this->post('id_justificatif_prevu')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Justificatif_daafManager->add($data);
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
                    'id_demande_deblocage_daaf' => $this->post('id_demande_deblocage_daaf'),
                    'id_justificatif_prevu' => $this->post('id_justificatif_prevu')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Justificatif_daafManager->update($id, $data);
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
            $delete = $this->Justificatif_daafManager->delete($id);         
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
