<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Rapport_mensuel extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Rapport_mensuel_model', 'Rapport_mensuelManager');
       $this->load->model('contrat_be_model', 'Contrat_beManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');
        $validation = $this->get('validation');
        $id_cisco = $this->get('id_cisco');
        $id_rapport_mensuel = $this->get('id_rapport_mensuel');
        $menu = $this->get('menu');
            
        if ($menu == "getrapportBycontrat")
        {
            $tmp = $this->Rapport_mensuelManager->findrapportBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {   
                $data = $tmp;
               /* foreach ($tmp as $key => $value) 
                {
                    $contrat_be = array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['date_livraison'] = $value->date_livraison;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['numero'] = $value->numero;
                    $data[$key]['contrat_be'] = $contrat_be;
                }*/
            } 
                else
                    $data = array();
        }

        elseif ($menu == "getrapportvalideById")
        {
            $tmp = $this->Rapport_mensuelManager->getrapportvalideById($id_rapport_mensuel);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        }

        elseif ($menu == "getrapportvalideBycontrat")
        {
            $tmp = $this->Rapport_mensuelManager->findrapportvalideBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                $data = $tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $contrat_be = array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['date_livraison'] = $value->date_livraison;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['numero'] = $value->numero;
                    $data[$key]['contrat_be'] = $contrat_be;
                }*/
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getrapportinvalideBycontrat")
        {
            $tmp = $this->Rapport_mensuelManager->findrapportinvalideBycontrat($id_contrat_bureau_etude);
            if ($tmp) 
            {
                $data = $tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $contrat_be = array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['date_livraison'] = $value->date_livraison;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['numero'] = $value->numero;
                    $data[$key]['contrat_be'] = $contrat_be;
                }*/
            } 
                else
                    $data = array();
        }
        /*if ($menu == "getrapportBycontrat")
        {
            $tmp = $this->Rapport_mensuelManager->findAllBycontrat($id_contrat_bureau_etude,$validation);
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
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }
            } 
                else
                    $data = array();
        }*/
       /* if ($menu == "getrapportvalidationBycisco")
        {
            $tmp = $this->Rapport_mensuelManager->findAllvalidationBycisco($validation,$id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_be = array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    //$data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_livraison'] = $value->date_livraison;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getrapportByvalidation")
        {
            $tmp = $this->Rapport_mensuelManager->findAllByvalidation($validation);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_be = array();
                    $contrat_be = $this->Contrat_beManager->findById($value->id_contrat_bureau_etude);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    //$data[$key]['fichier'] = $value->fichier;
                    $data[$key]['date_livraison'] = $value->date_livraison;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }
            } 
                else
                    $data = array();
        }*/
        elseif ($id)
        {
            $data = array();
            $rapport_mensuel = $this->Rapport_mensuelManager->findById($id);
            $contrat_be = $this->Contrat_beManager->findById($rapport_mensuel->id_contrat_bureau_etude);
            $data['id'] = $rapport_mensuel->id;
            $data['description'] = $rapport_mensuel->description;
            //$data['fichier'] = $rapport_mensuel->fichier;
            $data['date_livraison'] = $rapport_mensuel->date_livraison;
            $data['observation'] = $rapport_mensuel->observation;
            $data['numero'] = $rapport_mensuel->numero;
            $data['contrat_be'] = $contrat_be;
        } 
        else 
        {
            $menu = $this->Rapport_mensuelManager->findAll();
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
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['numero'] = $value->numero;
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
                    'observation' => $this->post('observation'),
                    'numero' => $this->post('numero'),
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
                $dataId = $this->Rapport_mensuelManager->add($data);
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
                    //'fichier' => $this->post('fichier'),
                    'date_livraison' => $this->post('date_livraison'),
                    'observation' => $this->post('observation'),
                    'numero' => $this->post('numero'),
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
                $update = $this->Rapport_mensuelManager->update($id, $data);
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
            $delete = $this->Rapport_mensuelManager->delete($id);         
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
