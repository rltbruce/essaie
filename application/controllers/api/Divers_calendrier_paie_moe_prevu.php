<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Divers_calendrier_paie_moe_prevu extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('divers_calendrier_paie_moe_prevu_model', 'Divers_calendrier_paie_moe_prevuManager');
        //$this->load->model('divers_calendrier_paie_moe_model', 'Divers_calendrier_paie_moeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');
        $id_sousrubrique = $this->get('id_sousrubrique'); 
        $menu = $this->get('menu');
 
        if ($menu == "getcalendrier_paie_moe_prevuwithdetailbycontrat")
        {
            $tmp = $this->Divers_calendrier_paie_moe_prevuManager->getcalendrier_paie_moe_prevuwithdetailbycontrat($id_contrat_bureau_etude,$id_sousrubrique);
            if ($tmp) 
            { 
                $data=$tmp;
            } 
                else
                    $data = array();
        }
      /*  elseif ($menu == "getmontant_total_prevubycontrat")
        {
            $tmp = $this->Divers_attachement_batiment_prevuManager->getmontant_total_prevubycontrat($id_contrat_prestataire);
            if ($tmp) 
            { 
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getattachement_batimentprevubyrubrique")
        {
            $tmp = $this->Divers_attachement_batiment_prevuManager->getattachement_batimentprevubyrubrique($id_contrat_prestataire,$id_attachement_batiment);
            if ($tmp) 
            { 
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getprevuattachement_batimentbycontrat")
        {
            $tmp = $this->Divers_attachement_batiment_prevuManager->getprevuattachement_batimentbycontrat($id_contrat_prestataire,$id_attachement_batiment);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }*/
        elseif ($id)
        {
            $data = array();
            $divers_calendrier_paie_moe_prevu = $this->Divers_calendrier_paie_moe_prevuManager->findById($id);
            $data['id'] = $divers_calendrier_paie_moe_prevu->id;
            $data['montant_prevu'] = $divers_calendrier_paie_moe_prevu->montant_prevu;
            $data['id_contrat_prestataire'] = $divers_calendrier_paie_moe_prevu->id_contrat_prestataire;
            $data['id_rubrique'] = $divers_calendrier_paie_moe_prevu->id_rubrique;
        } 
        else 
        {
            $tmp = $this->Divers_attachement_batiment_prevuManager->findAll();
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
                    'montant_prevu' => $this->post('montant_prevu'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'id_rubrique' => $this->post('id_rubrique')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Divers_calendrier_paie_moe_prevuManager->add($data);
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
                    'montant_prevu' => $this->post('montant_prevu'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'id_rubrique' => $this->post('id_rubrique')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Divers_calendrier_paie_moe_prevuManager->update($id, $data);
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
            $delete = $this->Divers_calendrier_paie_moe_prevuManager->delete($id);         
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
