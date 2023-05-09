<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Reception_mpe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('reception_mpe_model', 'Reception_mpeManager');
        $this->load->model('prestataire_model', 'PrestataireManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        $this->load->model('mpe_soumissionaire_model', 'Mpe_soumissionaireManager');
        $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_reception_mpe = $this->get('id_reception_mpe');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_cisco = $this->get('id_cisco');
       
       if ($menu=='getreception_mpeBycontrat')
         {
            $tmp = $this->Reception_mpeManager->findreception_mpeBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                $data = $tmp;
            }
                else
                    $data = array();
        }  
        elseif ($menu=='getreception_mpevalideBycontrat')
         {
            $tmp = $this->Reception_mpeManager->findreception_mpevalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                $data = $tmp;
            }
                else
                    $data = array();
        }  
        elseif ($menu=='getreception_mpevalideById')
         {
            $tmp = $this->Reception_mpeManager->findreception_mpevalideById($id_reception_mpe);
            if ($tmp) 
            {
                $data = $tmp;
            }
                else
                    $data = array();
        }  
        elseif ($menu=='getreception_mpeinvalideBycontrat')
         {
            $tmp = $this->Reception_mpeManager->findtreception_mpeinvalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                $data = $tmp;
            }
                else
                    $data = array();
        }   
       /* if ($menu=='getreceptionBycisco')
         {
            $tmp = $this->Reception_mpeManager->findAllByCisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {   
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_previ_recep_tech']    = $value->date_previ_recep_tech;
                    $data[$key]['date_reel_tech']           = $value->date_reel_tech;
                    $data[$key]['date_leve_recep_tech']     = $value->date_leve_recep_tech;
                    $data[$key]['date_previ_recep_prov']    = $value->date_previ_recep_prov;
                    $data[$key]['date_reel_recep_prov']     =  $value->date_reel_recep_prov;
                    $data[$key]['date_previ_leve']          = $value->date_previ_leve;
                    $data[$key]['date_reel_lev_ava_rd']     = $value->date_reel_lev_ava_rd;
                    $data[$key]['date_previ_recep_defi']    = $value->date_previ_recep_defi;
                    $data[$key]['date_reel_recep_defi']     = $value->date_reel_recep_defi;
                    $data[$key]['observation']              = $value->observation;
                    $data[$key]['contrat_prestataire']      = $contrat_prestataire;
                }
            }
                else
                    $data = array();
        }  
        elseif ($menu=='getreceptionBycontrat_prestataire')
         {
            $tmp = $this->Reception_mpeManager->findAllByContrat_prestataire($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {   
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_previ_recep_tech']    = $value->date_previ_recep_tech;
                    $data[$key]['date_reel_tech']           = $value->date_reel_tech;
                    $data[$key]['date_leve_recep_tech']     = $value->date_leve_recep_tech;
                    $data[$key]['date_previ_recep_prov']    = $value->date_previ_recep_prov;
                    $data[$key]['date_reel_recep_prov']     =  $value->date_reel_recep_prov;
                    $data[$key]['date_previ_leve']          = $value->date_previ_leve;
                    $data[$key]['date_reel_lev_ava_rd']     = $value->date_reel_lev_ava_rd;
                    $data[$key]['date_previ_recep_defi']    = $value->date_previ_recep_defi;
                    $data[$key]['date_reel_recep_defi']     = $value->date_reel_recep_defi;
                    $data[$key]['observation']              = $value->observation;
                    $data[$key]['contrat_prestataire']      = $contrat_prestataire;
                }
            }
                else
                    $data = array();
        } */ 
        elseif ($id)
        {
            $data = array();
            $reception_mpe = $this->Reception_mpeManager->findById($id); 
            $contrat_prestataire = $this->Contrat_prestataireManager->findById($reception_mpe->id_contrat_prestataire);           

            $data['id'] = $reception_mpe->id;
            $data['date_previ_recep_tech'] = $reception_mpe->date_previ_recep_tech;
            $data['date_reel_tech']   = $reception_mpe->date_reel_tech;
            $data['date_leve_recep_tech']   = $reception_mpe->date_leve_recep_tech;
            $data['date_previ_recep_prov'] = $reception_mpe->date_previ_recep_prov;
            $data['date_reel_recep_prov'] = $reception_mpe->date_reel_recep_prov;
            $data['date_previ_leve'] = $reception_mpe->date_previ_leve;
            $data['date_reel_lev_ava_rd']     = $reception_mpe->date_reel_lev_ava_rd;
            $data['date_previ_recep_defi']   = $reception_mpe->date_previ_recep_defi;
            $data['date_reel_recep_defi']    = $reception_mpe->date_reel_recep_defi;
            $data['observation'] = $reception_mpe->observation;
            $data['validation'] = $reception_mpe->validation;
            $data['contrat_prestataire'] = $contrat_prestataire;
        } 
        else 
        {
            $tmp = $this->Reception_mpeManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {   
                    $contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_previ_recep_tech']    = $value->date_previ_recep_tech;
                    $data[$key]['date_reel_tech']           = $value->date_reel_tech;
                    $data[$key]['date_leve_recep_tech']     = $value->date_leve_recep_tech;
                    $data[$key]['date_previ_recep_prov']    = $value->date_previ_recep_prov;
                    $data[$key]['date_reel_recep_prov']     =  $value->date_reel_recep_prov;
                    $data[$key]['date_previ_leve']          = $value->date_previ_leve;
                    $data[$key]['date_reel_lev_ava_rd']     = $value->date_reel_lev_ava_rd;
                    $data[$key]['date_previ_recep_defi']    = $value->date_previ_recep_defi;
                    $data[$key]['date_reel_recep_defi']     = $value->date_reel_recep_defi;
                    $data[$key]['observation']              = $value->observation;
                    $data[$key]['validation']              = $value->validation;
                    $data[$key]['contrat_prestataire']      = $contrat_prestataire;
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

                    'id' => $this->post('id'),
                    'date_previ_recep_tech' => $this->post('date_previ_recep_tech'),
                    'date_reel_tech'   => $this->post('date_reel_tech'),
                    'date_leve_recep_tech'   => $this->post('date_leve_recep_tech'),
                    'date_previ_recep_prov' => $this->post('date_previ_recep_prov'),
                    'date_reel_recep_prov' => $this->post('date_reel_recep_prov'),
                    'date_previ_leve' => $this->post('date_previ_leve'),
                    'date_reel_lev_ava_rd' => $this->post('date_reel_lev_ava_rd'),
                    'date_previ_recep_defi'   => $this->post('date_previ_recep_defi'),
                    'date_reel_recep_defi'    => $this->post('date_reel_recep_defi'),
                    'avancement_physi' => $this->post('avancement_physi'),
                    'observation' => $this->post('observation'),
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
                $dataId = $this->Reception_mpeManager->add($data);
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
                    'date_previ_recep_tech' => $this->post('date_previ_recep_tech'),
                    'date_reel_tech'   => $this->post('date_reel_tech'),
                    'date_leve_recep_tech'   => $this->post('date_leve_recep_tech'),
                    'date_previ_recep_prov' => $this->post('date_previ_recep_prov'),
                    'date_reel_recep_prov' => $this->post('date_reel_recep_prov'),
                    'date_previ_leve' => $this->post('date_previ_leve'),
                    'date_reel_lev_ava_rd' => $this->post('date_reel_lev_ava_rd'),
                    'date_previ_recep_defi'   => $this->post('date_previ_recep_defi'),
                    'date_reel_recep_defi'    => $this->post('date_reel_recep_defi'),
                    'avancement_physi' => $this->post('avancement_physi'),
                    'observation' => $this->post('observation'),
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
                $update = $this->Reception_mpeManager->update($id, $data);
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
            $delete = $this->Reception_mpeManager->delete($id);         
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
