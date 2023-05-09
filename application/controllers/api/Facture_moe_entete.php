

<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Facture_moe_entete extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('facture_moe_entete_model', 'Facture_moe_enteteManager');
        //$this->load->model('facture_mpe_model', 'Facture_mpeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');
        $id_facture_moe = $this->get('id_facture_moe');
        $menu = $this->get('menu');

        if ($menu=="getfacture_moevalideBycontrat")
        {
            $tmp = $this->Facture_moe_enteteManager->getfacture_moevalideBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                $data = $tmp;            
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getfacture_moevalideById")
        {
            $tmp = $this->Facture_moe_enteteManager->getfacture_moevalideById($id_facture_moe);
            if ($tmp) 
            {
                $data = $tmp;            
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getfacturedisponibleBycontrat")
        {
            $tmp = $this->Facture_moe_enteteManager->getfacturedisponibleBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                $data = $tmp;            
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getfactureemidpfiBycontrat")
        {
            $tmp = $this->Facture_moe_enteteManager->getfactureemidpfiBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                $data = $tmp;            
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getfacture_moe_enteteinvalideBycontratstat12")
        {
            $tmp = $this->Facture_moe_enteteManager->getfacture_moe_enteteinvalideBycontratstat12($id_contrat_bureau_etude);
            if ($tmp) 
            {
                $data = $tmp;            
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getfacture_moe_enteteinvalideBycontrat")
        {
            $tmp = $this->Facture_moe_enteteManager->getfacture_moe_enteteinvalideBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                $data = $tmp;            
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getfacture_moe_enteteBycontrat")
        {
            $tmp = $this->Facture_moe_enteteManager->getfacture_moe_enteteBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                $data = $tmp;            
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $facture_moe_entete = $this->Facture_moe_enteteManager->findById($id);
            $data['id'] = $facture_moe_entete->id;
            $data['numero'] = $facture_moe_entete->numero;
            $data['date_br'] = $facture_moe_entete->date_br;
            $data['id_contrat_bureau_etude'] = $facture_moe_entete->id_contrat_bureau_etude;
        } 
        else 
        {
            $tmp = $this->Facture_moe_enteteManager->findAll();
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
                    'numero' => $this->post('numero'),
                    'date_br' => $this->post('date_br'),
                    'id_contrat_bureau_etude' => $this->post('id_contrat_bureau_etude'),
                    'validation' => $this->post('validation'),
                    'statu_fact' => $this->post('statu_fact')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Facture_moe_enteteManager->add($data);
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
                    'numero' => $this->post('numero'),
                    'date_br' => $this->post('date_br'),
                    'id_contrat_bureau_etude' => $this->post('id_contrat_bureau_etude'),
                    'validation' => $this->post('validation'),
                    'statu_fact' => $this->post('statu_fact')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Facture_moe_enteteManager->update($id, $data);
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
            $delete = $this->Facture_moe_enteteManager->delete($id);         
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
