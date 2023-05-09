<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Divers_attachement_latrine_travaux extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('divers_attachement_latrine_travaux_model', 'Divers_attachement_latrine_travauxManager');
        //$this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        $this->load->model('divers_attachement_latrine_prevu_model', 'Divers_attachement_latrine_prevuManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_demande_latrine_mpe = $this->get('id_demande_latrine_mpe');
        $id_attachement_latrine = $this->get('id_attachement_latrine');
        $id_attachement_latrine_prevu = $this->get('id_attachement_latrine_prevu');
        $menu = $this->get('menu');
 
       /* if ($menu == "getmax_1attachement_travauxByattachement_prevu")
        {
            $tmp = $this->Divers_attachement_latrine_travauxManager->findmax_1attachement_travauxByattachement_prevu($id_attachement_latrine_prevu,$id_contrat_prestataire);
            if ($tmp) 
            {   
                foreach ($tmp as $key => $value)
                {   

                    $divers_attachement_latrine_prevu = $this->Divers_attachement_latrine_prevuManager->findByIdlibelle($value->id_attachement_latrine_prevu);                 
                    $data[$key]['id'] = $value->id;                  
                    $data[$key]['id_demande_latrine_mpe'] = $value->id_demande_latrine_mpe;                  
                    $data[$key]['quantite_periode'] = $value->quantite_periode;                  
                    $data[$key]['quantite_anterieur'] = $value->quantite_anterieur;                  
                    $data[$key]['quantite_cumul'] = $value->quantite_cumul;                  
                    $data[$key]['montant_prevu'] = $value->montant_prevu;                  
                    $data[$key]['montant_periode'] = $value->montant_periode;                  
                    $data[$key]['montant_anterieur'] = $value->montant_anterieur;                  
                    $data[$key]['montant_cumul'] = $value->montant_cumul;                 
                    $data[$key]['pourcentage'] = $value->pourcentage;                 
                    $data[$key]['attachement_latrine_prevu'] = $value->divers_attachement_latrine_prevu;
                }
               // $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getmaxattachement_travauxByattachement_prevu")
        {
            $tmp = $this->Divers_attachement_latrine_travauxManager->findmaxattachement_travauxByattachement_prevu($id_attachement_latrine_prevu,$id_contrat_prestataire);
            if ($tmp) 
            {   
                foreach ($tmp as $key => $value)
                {   

                    $divers_attachement_latrine_prevu = $this->Divers_attachement_latrine_prevuManager->findByIdlibelle($value->id_attachement_latrine_prevu);                 
                    $data[$key]['id'] = $value->id;                  
                    $data[$key]['id_demande_latrine_mpe'] = $value->id_demande_latrine_mpe;                  
                    $data[$key]['quantite_periode'] = $value->quantite_periode;                  
                    $data[$key]['quantite_anterieur'] = $value->quantite_anterieur;                  
                    $data[$key]['quantite_cumul'] = $value->quantite_cumul;                  
                    $data[$key]['montant_prevu'] = $value->montant_prevu;                  
                    $data[$key]['montant_periode'] = $value->montant_periode;                  
                    $data[$key]['montant_anterieur'] = $value->montant_anterieur;                  
                    $data[$key]['montant_cumul'] = $value->montant_cumul;                 
                    $data[$key]['pourcentage'] = $value->pourcentage;                 
                    $data[$key]['attachement_latrine_prevu'] = $value->divers_attachement_latrine_prevu;
                }
               // $data=$tmp;
            } 
                else
                    $data = array();
        }
        else*/
            if ($menu == "getattachement_latrinetravauxbydemande")
        {
            $tmp = $this->Divers_attachement_latrine_travauxManager->finddivers_attachementByDemande($id_contrat_prestataire,$id_demande_latrine_mpe,$id_attachement_latrine);
            if ($tmp) 
            {   
                 //$data=$tmp;
                foreach ($tmp as $key => $value)
                {                 
                    $data[$key]['id'] = $value->id;                  
                    $data[$key]['libelle'] = $value->libelle;                  
                    $data[$key]['numero'] = $value->numero;                 
                    $data[$key]['id_attachement_latrine_detail'] = $value->id_attache_latrine_detail;                
                    $data[$key]['id_attachement_latrine_prevu'] = $value->id_attachement_latrine_prevu;                
                    $data[$key]['montant_prevu'] = $value->montant_prevu;                
                    $data[$key]['prix_unitaire'] = $value->prix_unitaire;                
                    $data[$key]['quantite_prevu'] = $value->quantite_prevu;               
                    $data[$key]['unite'] = $value->unite;

                    $data[$key]['quantite_periode'] = $value->quantite_periode;                  
                    $data[$key]['quantite_anterieur'] = $value->quantite_anterieur;                  
                    $data[$key]['quantite_cumul'] = $value->quantite_periode + $value->quantite_anterieur; 

                    $data[$key]['montant_periode'] = $value->montant_periode;                  
                    $data[$key]['montant_anterieur'] = $value->montant_anterieur;                  
                    $data[$key]['montant_cumul'] = $value->montant_periode + $value->montant_anterieur;

                    $data[$key]['pourcentage_periode'] = ($value->montant_periode * 100)/$value->montant_prevu;
                    $data[$key]['pourcentage_anterieur'] = ($value->montant_anterieur * 100)/$value->montant_prevu;
                    $data[$key]['pourcentage_cumul'] = (($value->montant_periode + $value->montant_anterieur)*100)/$value->montant_prevu; 
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $divers_attachement_latrine_travaux = $this->Divers_attachement_latrine_travauxManager->findById($id);
            $data['id'] = $divers_attachement_latrine_travaux->id;
            $data['montant_prevu'] = $divers_attachement_latrine_travaux->montant_prevu;
            $data['id_contrat_prestataire'] = $divers_attachement_latrine_travaux->id_contrat_prestataire;
            $data['id_divers_attachement_latrine'] = $divers_attachement_latrine_travaux->id_divers_attachement_latrine;
        } 
        else 
        {
            $tmp = $this->Divers_attachement_latrine_travauxManager->findAll();
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
                    'quantite_periode' => $this->post('quantite_periode'),
                    'quantite_anterieur' => $this->post('quantite_anterieur'),
                    'quantite_cumul' => $this->post('quantite_cumul'),
                    'montant_periode' => $this->post('montant_periode'),
                    'montant_anterieur' => $this->post('montant_anterieur'),
                    'montant_cumul' => $this->post('montant_cumul'),
                    'pourcentage' => $this->post('pourcentage'),
                    'id_demande_latrine_mpe' => $this->post('id_demande_latrine_mpe'),
                    'id_attachement_latrine_prevu' => $this->post('id_attachement_latrine_prevu')            
              
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Divers_attachement_latrine_travauxManager->add($data);
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
                    'quantite_periode' => $this->post('quantite_periode'),
                    'quantite_anterieur' => $this->post('quantite_anterieur'),
                    'quantite_cumul' => $this->post('quantite_cumul'),
                    'montant_periode' => $this->post('montant_periode'),
                    'montant_anterieur' => $this->post('montant_anterieur'),
                    'montant_cumul' => $this->post('montant_cumul'),
                    'pourcentage' => $this->post('pourcentage'),
                    'id_demande_latrine_mpe' => $this->post('id_demande_latrine_mpe'),
                    'id_attachement_latrine_prevu' => $this->post('id_attachement_latrine_prevu')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Divers_attachement_latrine_travauxManager->update($id, $data);
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
            $delete = $this->Divers_attachement_latrine_travauxManager->delete($id);         
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
