<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Manuel_gestion extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Manuel_gestion_model', 'Manuel_gestionManager');
       $this->load->model('contrat_be_model', 'Contrat_beManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_manuel_gestion = $this->get('id_manuel_gestion');
        $id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');
        $validation = $this->get('validation');
        $id_cisco = $this->get('id_cisco');
        $menu = $this->get('menu');
            
      if ($menu == "getmanuelBycontrat")
        {
            $tmp = $this->Manuel_gestionManager->findmanuelBycontrat($id_contrat_bureau_etude);
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
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }*/
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getmanuelvalideBycontrat")
        {
            $tmp = $this->Manuel_gestionManager->findmanuelvalideBycontrat($id_contrat_bureau_etude);
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
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }*/
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getmanuelvalideById")
        {
            $tmp = $this->Manuel_gestionManager->findmanuelvalideById($id_manuel_gestion);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getmanuelinvalideBycontrat")
        {
            $tmp = $this->Manuel_gestionManager->findmanuelinvalideBycontrat($id_contrat_bureau_etude);
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
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }*/
            } 
                else
                    $data = array();
        }
       /* if ($menu == "getmanuelBycontrat")
        {
            $tmp = $this->Manuel_gestionManager->findAllBycontrat($id_contrat_bureau_etude,$validation);
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
       /* if ($menu == "getmanuelByvalidation")
        {
            $tmp = $this->Manuel_gestionManager->findAllByvalidation($validation);
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
        }
        else*/
        /*    if ($menu == "getmanuelvalidationBycisco")
        {
            $tmp = $this->Manuel_gestionManager->findAllvalidationBycisco($validation,$id_cisco);
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
        elseif ($id)
        {
            $data = array();
            $manuel_gestion = $this->Manuel_gestionManager->findById($id);
            $contrat_be = $this->Contrat_beManager->findById($manuel_gestion->id_contrat_bureau_etude);
            $data['id'] = $manuel_gestion->id;
            $data['description'] = $manuel_gestion->description;
            $data['fichier'] = $manuel_gestion->fichier;
            $data['date_livraison'] = $manuel_gestion->date_livraison;
            $data['observation'] = $manuel_gestion->observation;
            $data['contrat_be'] = $contrat_be;
        } 
        else 
        {
            $menu = $this->Manuel_gestionManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_be= array();
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
                    'fichier' => $this->post('fichier'),
                    'date_livraison' => $this->post('date_livraison'),
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
                $dataId = $this->Manuel_gestionManager->add($data);
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
                    'fichier' => $this->post('fichier'),
                    'date_livraison' => $this->post('date_livraison'),
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
                $update = $this->Manuel_gestionManager->update($id, $data);
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
            $delete = $this->Manuel_gestionManager->delete($id);         
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
