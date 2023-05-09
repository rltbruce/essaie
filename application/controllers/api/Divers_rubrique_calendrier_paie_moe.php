<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Divers_rubrique_calendrier_paie_moe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('divers_rubrique_calendrier_paie_moe_model', 'Divers_rubrique_calendrier_paie_moeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');
        $id_facture_moe_entete = $this->get('id_facture_moe_entete');
        $menu = $this->get('menu');

        if ($menu == 'getrubriquewithmontant_prevubycontrat') 
        {   
            $data = array();
            $tmp = $this->Divers_rubrique_calendrier_paie_moeManager->getrubriquewithmontant_prevubycontrat($id_contrat_bureau_etude);
           
            if ($tmp) 
            {
                $data = $tmp;
            }
        }
        elseif ($menu == 'getrubrique_calendrier_moewithmontantByentetecontrat') 
        {   
            $data = array();
            $tmp = $this->Divers_rubrique_calendrier_paie_moeManager->getrubrique_calendrier_moewithmontantByentetecontrat($id_contrat_bureau_etude,$id_facture_moe_entete);
           
            if ($tmp) 
            {
                $data = $tmp;
            }
        }
       /* elseif ($menu == 'getrubrique_calendrier_paie_moe_prevu') 
        {   $data = array();
            $tmp = $this->Divers_rubrique_calendrier_paie_moeManager->findattachementBycontrat($id_contrat_bureau_etude);
           
            if ($tmp) 
            {
                $data = $tmp;
            }
        }*/
        elseif ($id)
        {
            $data = array();
            $divers_rubrique_calendrier_paie_moe = $this->Divers_rubrique_calendrier_paie_moeManager->findById($id);
            $data['id'] = $divers_rubrique_calendrier_paie_moe->id;
            $data['libelle'] = $divers_rubrique_calendrier_paie_moe->libelle;
            $data['description'] = $divers_rubrique_calendrier_paie_moe->description;
        } 
        else 
        {
            $tmp = $this->Divers_rubrique_calendrier_paie_moeManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
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
                    'libelle' => $this->post('libelle'),
                    'description' => $this->post('description')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Divers_rubrique_calendrier_paie_moeManager->add($data);
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
                    'description' => $this->post('description')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Divers_rubrique_calendrier_paie_moeManager->update($id, $data);
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
            $delete = $this->Divers_rubrique_calendrier_paie_moeManager->delete($id);         
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
