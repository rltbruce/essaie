<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Memoire_technique extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Memoire_technique_model', 'Memoire_techniqueManager');
       $this->load->model('contrat_be_model', 'Contrat_beManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_memoire_technique = $this->get('id_memoire_technique');
        $id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');
        $validation = $this->get('validation');
        $id_cisco = $this->get('id_cisco');
        $menu = $this->get('menu');
            
       if ($menu == "getmemoireBycontrat")
        {
            $tmp = $this->Memoire_techniqueManager->findmemoireBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $contrat_be = array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['date_livraison'] = $value->date_livraison;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }*/
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getmemoirevalideBycontrat")
        {
            $tmp = $this->Memoire_techniqueManager->findmemoirevalideBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $contrat_be = array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['date_livraison'] = $value->date_livraison;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }*/
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getmemoirevalideById")
        {
            $tmp = $this->Memoire_techniqueManager->findmemoirevalideById($id_memoire_technique);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getmemoireinvalideBycontrat")
        {
            $tmp = $this->Memoire_techniqueManager->findmemoireinvalideBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $contrat_be = array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['date_livraison'] = $value->date_livraison;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }*/
            } 
                else
                    $data = array();
        }
        /* if ($menu == "getmemoireBycontrat")
        {
            $tmp = $this->Memoire_techniqueManager->findAllBycontrat($id_contrat_bureau_etude,$validation);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_be = array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_livraison'] = $value->date_livraison;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }
            } 
                else
                    $data = array();
        }*/
       /* if ($menu == "getmemoireByvalidation")
        {
            $tmp = $this->Memoire_techniqueManager->findAllByvalidation($validation);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_be = array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                   // $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_livraison'] = $value->date_livraison;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }
            } 
                else
                    $data = array();
        }*/
        elseif ($menu == "getmemoirevalidationBycisco")
        {
            $tmp = $this->Memoire_techniqueManager->findAllvalidationBycisco($validation,$id_cisco);
            if ($tmp) 
            {
               $data=$tmp;
               /* foreach ($tmp as $key => $value) 
                {
                    $contrat_be = array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                   // $data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_livraison'] = $value->date_livraison;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }*/
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $memoire_technique = $this->Memoire_techniqueManager->findById($id);
            $contrat_be = $this->Contrat_beManager->findById($memoire_technique->id_contrat_bureau_etude);
            $data['id'] = $memoire_technique->id;
            $data['description'] = $memoire_technique->description;
           // $data['fichier'] = $memoire_technique->fichier;
            $data['date_livraison'] = $memoire_technique->date_livraison;
            $data['date_approbation'] = $memoire_technique->date_approbation;
            $data['observation'] = $memoire_technique->observation;
            $data['contrat_be'] = $contrat_be;
        } 
        else 
        {
            $menu = $this->Memoire_techniqueManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_be= array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    //$data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_livraison'] = $value->date_livraison;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_be'] = $contrat_be;
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
                    'description' => $this->post('description'),
                    //'fichier' => $this->post('fichier'),
                    'date_livraison' => $this->post('date_livraison'),
                    'date_approbation' => $this->post('date_approbation'),
                    'observation' => $this->post('observation'),
                    'id_contrat_bureau_etude' => $this->post('id_contrat_bureau_etude'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Memoire_techniqueManager->add($data);
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
                    ///'fichier' => $this->post('fichier'),
                    'date_livraison' => $this->post('date_livraison'),
                    'date_approbation' => $this->post('date_approbation'),
                    'observation' => $this->post('observation'),
                    'id_contrat_bureau_etude' => $this->post('id_contrat_bureau_etude'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Memoire_techniqueManager->update($id, $data);
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
            $delete = $this->Memoire_techniqueManager->delete($id);         
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
