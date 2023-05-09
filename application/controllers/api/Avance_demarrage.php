<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Avance_demarrage extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('avance_demarrage_model', 'Avance_demarrageManager');
        $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_avance_demarrage = $this->get('id_avance_demarr$id_avance_demarrage');
        $menu = $this->get('menu');

        if ($menu=="getavancevalideById")
        {
            $tmp = $this->Avance_demarrageManager->getavancevalideById($id_avance_demarrage);
            if ($tmp) 
            {
                $data = $tmp;           
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getavancevalideBycontrat")
        {
            $tmp = $this->Avance_demarrageManager->getavancevalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['numero'] = 'acompte';
                    $data[$key]['montant_avance'] = $value->montant_avance;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['pourcentage_rabais'] = $value->pourcentage_rabais;
                    $data[$key]['montant_rabais'] = $value->montant_rabais;
                    $data[$key]['taxe_marche_public'] = $value->taxe_marche_public;
                    $data[$key]['net_payer'] = $value->net_payer;
                    $data[$key]['reste_payer'] = ($value->cout_batiment+$value->cout_latrine+$value->cout_mobilier)-$value->montant_avance;
                }           
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getavance_demarragevalidebcafBycontrat")
        {
            $tmp = $this->Avance_demarrageManager->findavance_demarragevalidebcafBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                $data = $tmp;            } 
                else
                    $data = array();
        }
        elseif ($menu=="getavance_demarrageBycontrat")
        {
            $tmp = $this->Avance_demarrageManager->findavance_demarrageBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                $data = $tmp;            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $avance_demarrage = $this->Avance_demarrageManager->findById($id);
            $data['id'] = $avance_demarrage->id;
            $data['montant_avance'] = $avance_demarrage->montant_avance;
            $data['date_signature'] = $avance_demarrage->date_signature;
            $data['pourcentage_rabais'] = $avance_demarrage->pourcentage_rabais;
            $data['montant_rabais'] = $avance_demarrage->montant_rabais;
            $data['taxe_marche_public'] = $avance_demarrage->taxe_marche_public;
            $data['net_payer'] = $avance_demarrage->net_payer;
            $data['id_contrat_prestataire'] = $avance_demarrage->id_contrat_prestataire;
        } 
        else 
        {
            $tmp = $this->Avance_demarrageManager->findAll();
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
                    'description' => $this->post('description'),
                    'montant_avance' => $this->post('montant_avance'),
                    'date_signature' => $this->post('date_signature'),
                    'pourcentage_rabais' => $this->post('pourcentage_rabais'),
                    'montant_rabais' => $this->post('montant_rabais'),
                    'taxe_marche_public' => $this->post('taxe_marche_public'),
                    'net_payer' => $this->post('net_payer'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Avance_demarrageManager->add($data);
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
                    'montant_avance' => $this->post('montant_avance'),
                    'date_signature' => $this->post('date_signature'),
                    'pourcentage_rabais' => $this->post('pourcentage_rabais'),
                    'taxe_marche_public' => $this->post('taxe_marche_public'),
                    'montant_rabais' => $this->post('montant_rabais'),
                    'net_payer' => $this->post('net_payer'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Avance_demarrageManager->update($id, $data);
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
            $delete = $this->Avance_demarrageManager->delete($id);         
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
