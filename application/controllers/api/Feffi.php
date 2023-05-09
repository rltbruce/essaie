<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Feffi extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('feffi_model', 'FeffiManager');
        $this->load->model('ecole_model', 'EcoleManager');
        $this->load->model('membre_feffi_model', 'Membre_feffiManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_ecole = $this->get('id_ecole');
        $id_cisco = $this->get('id_cisco');
        $id_district = $this->get('id_district');
        $id_region = $this->get('id_region');
        $menus = $this->get('menus');
            
        if ($menus=='getfeffiByfiltre') 
        {   $data = array();
            $tmp = $this->FeffiManager->findByfiltre($this->generer_requete($id_region,$id_district,$id_cisco));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$ecole = array();
                    $cisco = array();
                   $ecole = $this->EcoleManager->findById($value->id_ecole);
                   $nbr_membre= $this->Membre_feffiManager->count_membrebyId($value->id);
                   $nbr_feminin= $this->Membre_feffiManager->count_femininbyId($value->id);
                   $data[$key]['nbr_membre'] = $nbr_membre->nbr_membre;
                    $data[$key]['nbr_feminin'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['identifiant'] = $value->identifiant;
                    $data[$key]['denomination'] = $value->denomination;
                    //$data[$key]['eco'] = $value->id_ecole;
                    $data[$key]['adresse'] = $value->adresse;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                }
            }
        }
        elseif ($menus=='getfeffiBycisco')
        {   $data = array();
            $tmp = $this->FeffiManager->findBycisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$ecole = array();
                    $cisco = array();
                   $ecole = $this->EcoleManager->findById($value->id_ecole);
                   $nbr_membre= $this->Membre_feffiManager->count_membrebyId($value->id);
                   $nbr_feminin= $this->Membre_feffiManager->count_femininbyId($value->id);
                   $data[$key]['nbr_membre'] = $nbr_membre->nbr_membre;
                    $data[$key]['nbr_feminin'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['identifiant'] = $value->identifiant;
                    $data[$key]['denomination'] = $value->denomination;
                    //$data[$key]['eco'] = $value->id_ecole;
                    $data[$key]['adresse'] = $value->adresse;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                }
            }
        }
        elseif ($id_ecole) 
        {   $data = array();
            $tmp = $this->FeffiManager->findByecole($id_ecole);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = array();
                    $cisco = array();
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $nbr_membre= $this->Membre_feffiManager->count_membrebyId($value->id);
                    $nbr_feminin= $this->Membre_feffiManager->count_femininbyId($value->id);
                    $data[$key]['nbr_membre'] = $nbr_membre->nbr_membre;
                    $data[$key]['nbr_feminin'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['identifiant'] = $value->identifiant;
                    $data[$key]['denomination'] = $value->denomination;
                    
                    $data[$key]['adresse'] = $value->adresse;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $feffi = $this->FeffiManager->findById($id);
            $ecole = $this->EcoleManager->findById($feffi->id_ecole);
            $nbr_membre= $this->Membre_feffiManager->count_membrebyId($feffi->id);
            $nbr_feminin= $this->Membre_feffiManager->count_femininbyId($feffi->id);
            $data[$key]['nbr_membre'] = $nbr_membre->nb;
            $data[$key]['nbr_feminin'] = $nbr_feminin->nbr_feminin;
            $data['id'] = $feffi->id;
            $data['identifiant'] = $feffi->identifiant;
            $data['denomination'] = $feffi->denomination;
            $data['adresse'] = $feffi->adresse;
            $data['observation'] = $feffi->observation;
            $data['ecole'] = $ecole;
        } 
        else 
        {
            $menu = $this->FeffiManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $ecole = array();
                    $cisco = array();
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $nbr_membre= $this->Membre_feffiManager->count_membrebyId($value->id);
                    $nbr_feminin= $this->Membre_feffiManager->count_femininbyId($value->id);
                    $data[$key]['nbr_membre'] = $nbr_membre->nbr_membre;
                    $data[$key]['nbr_feminin'] = $nbr_feminin->nbr_feminin;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['identifiant'] = $value->identifiant;
                    $data[$key]['denomination'] = $value->denomination;
                    $data[$key]['adresse'] = $value->adresse;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['ecole'] = $ecole;
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
                    'identifiant' => $this->post('identifiant'),
                    'denomination' => $this->post('denomination'),
                    'adresse' => $this->post('adresse'),
                    'observation' => $this->post('observation'),
                    'id_ecole' => $this->post('id_ecole')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->FeffiManager->add($data);
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
                    'identifiant' => $this->post('identifiant'),
                    'denomination' => $this->post('denomination'),
                    'adresse' => $this->post('adresse'),
                    'observation' => $this->post('observation'),
                    'id_ecole' => $this->post('id_ecole')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->FeffiManager->update($id, $data);
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
            $delete = $this->FeffiManager->delete($id);         
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

    public function generer_requete($id_region,$id_district,$id_cisco)
    {
        

            $requete = "region.id= '".$id_region."' " ;
        
            if (($id_district!='*')&&($id_district!='undefined')) 
            {
                $requete = $requete." AND district.id='".$id_district."'" ;
            }

            if (($id_cisco!='*')&&($id_cisco!='undefined')) 
            {
                $requete = $requete." AND cisco.id='".$id_cisco."'" ;
            }
            
        return $requete ;
    }
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
