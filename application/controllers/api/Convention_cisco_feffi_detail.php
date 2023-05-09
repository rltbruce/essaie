<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Convention_cisco_feffi_detail extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('convention_cisco_feffi_detail_model', 'Convention_cisco_feffi_detailManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        $this->load->model('compte_feffi_model', 'Compte_feffiManager');
        $this->load->model('batiment_construction_model', 'Batiment_constructionManager');
        $this->load->model('latrine_construction_model', 'Latrine_constructionManager');
        $this->load->model('mobilier_construction_model', 'Mobilier_constructionManager');
        $this->load->model('cout_maitrise_construction_model', 'Cout_maitrise_constructionManager');
        $this->load->model('cout_sousprojet_construction_model', 'Cout_sousprojet_constructionManager');
        //$this->load->model('zone_subvention_model', 'Zone_subventionManager');
        //$this->load->model('acces_zone_model', 'Acces_zoneManager');
       // $this->load->model('composant_model', 'ComposantManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_entete = $this->get('id_convention_entete');
        $id_zone_subvention = $this->get('id_zone_subvention');
        $id_acces_zone = $this->get('id_acces_zone');
        
        $id_convention_entete_delete = $this->get('id_convention_entete_delete');
        $menu = $this->get('menu');

        if ($menu=="deletededail")
        {
            $detail = $this->Convention_cisco_feffi_detailManager->delete_detail($id_convention_entete_delete );
            $batiment = $this->Batiment_constructionManager->delete_detail($id_convention_entete_delete );
            $latrine = $this->Latrine_constructionManager->delete_detail($id_convention_entete_delete );
            $mobilier = $this->Mobilier_constructionManager->delete_detail($id_convention_entete_delete );
            $cout_maitrise = $this->Cout_maitrise_constructionManager->delete_detail($id_convention_entete_delete );
            $cout_sousprojet = $this->Cout_sousprojet_constructionManager->delete_detail($id_convention_entete_delete );
            $data = array();
            
        }
        elseif ($id_convention_entete)
        {
            $detail = $this->Convention_cisco_feffi_detailManager->findAllByEntete($id_convention_entete );
            if ($detail) 
            {
                foreach ($detail as $key => $value) 
                {                     
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $compte_feffi = $this->Compte_feffiManager->findByfeffiobjet($convention_entete->id_feffi);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    
                    $data[$key]['id_convention_entete'] = $value->id_convention_entete;
                    
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['prev_beneficiaire'] = $value->prev_beneficiaire;
                    $data[$key]['prev_nbr_ecole'] = $value->prev_nbr_ecole;
                    $data[$key]['delai'] = $value->delai;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['compte_feffi'] = $compte_feffi;
                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $convention_detail = $this->Convention_cisco_feffi_detailManager->findById($id);
            //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($convention_detail->$id_convention_entete);
            $compte_feffi = $this->Compte_feffiManager->findByfeffiobjet($convention_entete->id_feffi);

            $data['id'] = $convention_detail->id;
            $data['intitule'] = $convention_detail->intitule;                    
            //$data['zone_subvention'] = $zone_subvention;
            //$data['acces_zone'] = $acces_zone;
            $data['id_convention_entete'] = $convention_detail->id_convention_entete;
            //$data['composant'] = $composant;
            $data['date_signature'] = $convention_detail->date_signature;
            $data['prev_beneficiaire'] = $convention_detail->prev_beneficiaire;
            $data['prev_nbr_ecole'] = $convention_detail->prev_nbr_ecole;
            $data['delai'] = $convention_detail->delai;
            $data['observation'] = $convention_detail->observation;
            $data['compte_feffi'] = $compte_feffi;
        } 
        else 
        {
            $tmp = $this->Convention_cisco_feffi_detailManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data = array();
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $compte_feffi = $this->Compte_feffiManager->findByfeffiobjet($convention_entete->id_feffi);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    //$data[$key]['montant_total'] = $value->montant_total;
                   // $data[$key]['avancement'] = $value->avancement;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['prev_beneficiaire'] = $value->prev_beneficiaire;
                    $data[$key]['prev_nbr_ecole'] = $value->prev_nbr_ecole;
                    $data[$key]['delai'] = $value->delai;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['compte_feffi'] = $compte_feffi;
                    
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
        $id_convention_entete = $this->post('id_convention_entete');
        $menu=$this->post('menu');
        if ($menu=='supressionBytete')
        {
            if (!$id_convention_entete) {
                $this->response([
                    'status' => FALSE,
                    'response' => 0,
                    'message' => 'No request found'
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $delete = $this->Convention_cisco_feffi_detailManager->supressionBytete($id_convention_entete); 
           /* $deletebat = $this->Batiment_constructionManager->supressionBytete($id_convention_entete); 
            $deletelat = $this->Latrine_constructionManager->supressionBytete($id_convention_entete);  
            $deletemait = $this->Cout_maitrise_constructionManager->supressionBytete($id_convention_entete);  
            $deletecout = $this->Cout_sousprojet_constructionManager->supressionBytete($id_convention_entete); */        
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
        }elseif ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'intitule' => $this->post('intitule'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'date_signature' => $this->post('date_signature'),
                    'delai' => $this->post('delai'),
                    'observation' => $this->post('observation'),
                    'prev_beneficiaire' => $this->post('prev_beneficiaire'),
                    'prev_nbr_ecole' => $this->post('prev_nbr_ecole')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Convention_cisco_feffi_detailManager->add($data);
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
                    'intitule' => $this->post('intitule'),                    
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'date_signature' => $this->post('date_signature'),
                    'delai' => $this->post('delai'),
                    'observation' => $this->post('observation'),
                    'prev_beneficiaire' => $this->post('prev_beneficiaire'),
                    'prev_nbr_ecole' => $this->post('prev_nbr_ecole')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Convention_cisco_feffi_detailManager->update($id, $data);
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
            $delete = $this->Convention_cisco_feffi_detailManager->delete($id);         
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
