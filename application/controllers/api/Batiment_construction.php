<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Batiment_construction extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('batiment_construction_model', 'Batiment_constructionManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        $this->load->model('type_batiment_model', 'Type_batimentManager');
        $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        $this->load->model('contrat_be_model', 'Contrat_beManager');
        //$this->load->model('attachement_batiment_model', 'Attachement_batimentManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_entete = $this->get('id_convention_entete');
       $menu = $this->get('menu');
      //  $id_contrat_prestataire = $this->get('id_contrat_prestataire');
    //$id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');

     //   $id_contrat_partenaire_relai = $this->get('id_contrat_partenaire_relai');
       /* if ($menu=='getbatimentByContrat_partenaire_relai')
        {
            $batiment_construction = $this->Batiment_constructionManager->findAllBycontratpartenaire_relai($id_contrat_partenaire_relai );
            if ($batiment_construction) 
            {
                foreach ($batiment_construction as $key => $value) 
                {                    
                    $type_batiment = $this->Type_batimentManager->findById($value->id_type_batiment);
                    $contrat_be = $this->Contrat_beManager->findById($id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['type_batiment'] = $type_batiment;                    
                    //$data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['cout_unitaire'] = $value->cout_unitaire;
                    //$data[$key]['nbr_batiment'] = $value->nbr_batiment;
                    $data[$key]['contrat_be'] = $contrat_be;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getnbrByContrat_bureau_etude')
        {
            $batiment_construction = $this->Batiment_constructionManager->getnombreconstructionBycontrat($id_contrat_bureau_etude );
            if ($batiment_construction) 
            {
                $data = $batiment_construction;
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getbatimentByContrat_bureau_etude')
        {
            $batiment_construction = $this->Batiment_constructionManager->findAllBycontratbureau_etude($id_contrat_bureau_etude );
            if ($batiment_construction) 
            {
                foreach ($batiment_construction as $key => $value) 
                {                    
                    $type_batiment = $this->Type_batimentManager->findById($value->id_type_batiment);
                    $contrat_be = $this->Contrat_beManager->findById($id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['type_batiment'] = $type_batiment;                    
                    //$data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['cout_unitaire'] = $value->cout_unitaire;
                    //$data[$key]['nbr_batiment'] = $value->nbr_batiment;
                    $data[$key]['contrat_be'] = $contrat_be;
                }
            } 
                else
                    $data = array();
        }
        else*/
        if ($menu=='getbatimentByContrat_prestataire')
        {
            $batiment_construction = $this->Batiment_constructionManager->findAllBycontratprestataire($id_contrat_prestataire );
            if ($batiment_construction) 
            {
                foreach ($batiment_construction as $key => $value) 
                {                     
                    //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $type_batiment = $this->Type_batimentManager->findById($value->id_type_batiment);
                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($id_contrat_prestataire);
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['type_batiment'] = $type_batiment;                    
                    //$data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['cout_unitaire'] = $value->cout_unitaire;
                    //$data[$key]['nbr_batiment'] = $value->nbr_batiment;
                    //$data[$key]['contrat_prestataire'] = $contrat_prestataire;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id_convention_entete)
        {
            $batiment_construction = $this->Batiment_constructionManager->findBatimentByconvention($id_convention_entete );
            if ($batiment_construction) 
            {
                foreach ($batiment_construction as $key => $value) 
                {                     
                    //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $type_batiment = $this->Type_batimentManager->findById($value->id_type_batiment);
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['type_batiment'] = $type_batiment;                    
                    //$data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['cout_unitaire'] = $value->cout_unitaire;
                    //$data[$key]['nbr_batiment'] = $value->nbr_batiment;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $batiment_construction = $this->Batiment_constructionManager->findById($id);
            $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($batiment_construction->id_convention_entete);
            $type_batiment = $this->Type_batimentManager->findById($batiment_construction->id_type_batiment);

            $data['id'] = $batiment_construction->id;
            $data['convention_entete'] = $convention_entete;
            $data['type_batiment'] = $type_batiment;
            $data['cout_unitaire'] = $batiment_construction->cout_unitaire;
            //$data['nbr_batiment'] = $batiment_construction->nbr_batiment;
        } 
        else 
        {
            $tmp = $this->Batiment_constructionManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data = array();
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                   
                    $type_batiment = $this->Type_batimentManager->findById($value->id_type_batiment);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['type_batiment'] = $type_batiment;
                    $data[$key]['cout_unitaire'] = $value->cout_unitaire;
                    //$data[$key]['nbr_batiment'] = $value->nbr_batiment;
                    
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
        $menu = $this->post('menu') ;
        //$id_convention_entete = $this->post('id_convention_entete');
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'id_type_batiment' => $this->post('id_type_batiment'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'cout_unitaire'=> $this->post('cout_unitaire'),
                    //'nbr_batiment'=> $this->post('nbr_batiment')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Batiment_constructionManager->add($data);
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
                    'id_type_batiment' => $this->post('id_type_batiment'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'cout_unitaire'=> $this->post('cout_unitaire'),
                    //'nbr_batiment'=> $this->post('nbr_batiment')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Batiment_constructionManager->update($id, $data);
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
            $delete = $this->Batiment_constructionManager->delete($id);         
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
