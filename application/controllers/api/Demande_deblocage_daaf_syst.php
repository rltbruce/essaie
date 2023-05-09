<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Demande_deblocage_daaf_syst extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_deblocage_daaf_syst_model', 'Demande_deblocage_daaf_systManager');
        $this->load->model('convention_ufp_daaf_entete_model', 'Convention_ufp_daaf_enteteManager');
        $this->load->model('convention_ufp_daaf_detail_model', 'Convention_ufp_daaf_detailManager');
        $this->load->model('tranche_deblocage_daaf_model', 'Tranche_deblocage_daafManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        if ($id)
        {
            $data = array();
            $demande_deblocage_daaf_syst = $this->Demande_deblocage_daaf_systManager->findById($id);

            $tranche_deblocage_daaf = $this->Tranche_deblocage_daafManager->findById($demande_deblocage_daaf_syst->id_tranche_deblocage_daaf);
            $data['id'] = $demande_deblocage_daaf_syst->id;
            $data['objet'] = $demande_deblocage_daaf_syst->objet;
            $data['ref_demande'] = $demande_deblocage_daaf_syst->ref_demande;
            
            $data['tranche_deblocage_daaf'] = $tranche_deblocage_daaf;           
        } 
        else 
        {
            $menu = $this->Demande_deblocage_daaf_systManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                   
                    $tranche_deblocage_daaf = $this->Tranche_deblocage_daafManager->findById($value->id_tranche_deblocage_daaf);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_demande'] = $value->ref_demande;
                    
                    $data[$key]['tranche_deblocage_daaf'] = $tranche_deblocage_daaf;                   

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
                    'objet' => $this->post('objet'),                    
                    'ref_demande' => $this->post('ref_demande'),                    
                    'id_tranche_deblocage_daaf' => $this->post('id_tranche_deblocage_daaf')                   
                    
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Demande_deblocage_daaf_systManager->add($data);
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
                    'objet' => $this->post('objet'),                    
                    'ref_demande' => $this->post('ref_demande'),                    
                    'id_tranche_deblocage_daaf' => $this->post('id_tranche_deblocage_daaf') 
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Demande_deblocage_daaf_systManager->update($id, $data);
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
            $delete = $this->Demande_deblocage_daaf_systManager->delete($id);         
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
