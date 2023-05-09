<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Indicateur extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('indicateur_model', 'IndicateurManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_entete = $this->get('id_convention_entete');
        $menu = $this->get('menu');
        $id_indicateur = $this->get('id_indicateur');
         
         if ($menu=='getindicateurinvalideByconvention')
         {
            $tmp = $this->IndicateurManager->findindicateurinvalideByConvention($id_convention_entete);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getindicateurvalideByconvention')
         {
            $tmp = $this->IndicateurManager->findindicateurvalideByConvention($id_convention_entete);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getindicateurvalideById')
         {
            $tmp = $this->IndicateurManager->findindicateurvalideById($id_indicateur);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getindicateurByconvention')
         {
            $tmp = $this->IndicateurManager->findindicateurByConvention($id_convention_entete);
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
            $indicateur = $this->IndicateurManager->findById($id);

            $prestataire = $this->PrestataireManager->findById($indicateur->id_prestataire);
            $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($indicateur->id_convention_entete);

            $data['id'] = $indicateur->id;
            $data['nbr_salle_const'] = $indicateur->nbr_salle_const;
            $data['nbr_beneficiaire']   = $indicateur->nbr_beneficiaire;
            $data['nbr_ecole']    = $indicateur->nbr_ecole;
            $data['nbr_box']   = $indicateur->nbr_box;
            $data['nbr_point_eau'] = $indicateur->nbr_point_eau;
            $data['nbr_banc'] = $indicateur->nbr_banc;
            $data['nbr_table_maitre'] = $indicateur->nbr_table_maitre;
            $data['observation'] = $indicateur->observation;
        } 
        else 
        {
            $tmp = $this->IndicateurManager->findAll();
            if ($tmp) 
            {
                $data = $tmp;
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
                    'nbr_salle_const' => $this->post('nbr_salle_const'),
                    'nbr_beneficiaire'   => $this->post('nbr_beneficiaire'),
                    'nbr_ecole'    => $this->post('nbr_ecole'),
                    'nbr_box'   => $this->post('nbr_box'),
                    'nbr_point_eau' => $this->post('nbr_point_eau'),
                    'nbr_banc' => $this->post('nbr_banc'),
                    'nbr_table_maitre' => $this->post('nbr_table_maitre'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'nbr_chaise' => $this->post('nbr_chaise'),
                    'observation' => $this->post('observation'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->IndicateurManager->add($data);
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
                    'nbr_salle_const' => $this->post('nbr_salle_const'),
                    'nbr_beneficiaire'   => $this->post('nbr_beneficiaire'),
                    'nbr_ecole'    => $this->post('nbr_ecole'),
                    'nbr_box'   => $this->post('nbr_box'),
                    'nbr_point_eau' => $this->post('nbr_point_eau'),
                    'nbr_banc' => $this->post('nbr_banc'),
                    'nbr_table_maitre' => $this->post('nbr_table_maitre'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'nbr_chaise' => $this->post('nbr_chaise'),
                    'observation' => $this->post('observation'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->IndicateurManager->update($id, $data);
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
            $delete = $this->IndicateurManager->delete($id);         
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
