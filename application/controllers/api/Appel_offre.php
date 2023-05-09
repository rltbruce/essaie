<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Appel_offre extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('appel_offre_model', 'Appel_offreManager');
       $this->load->model('contrat_be_model', 'Contrat_beManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_appel_offre = $this->get('id_appel_offre');
        $id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');
        $id_cisco = $this->get('id_cisco');
        $validation = $this->get('validation');
        $menu = $this->get('menu');
            
        if ($menu == "getappelBycontrat")
        {
            $tmp = $this->Appel_offreManager->findappelBycontrat($id_contrat_bureau_etude);
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
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }*/
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getappelvalideBycontrat")
        {
            $tmp = $this->Appel_offreManager->findappelvalideBycontrat($id_contrat_bureau_etude);
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
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }*/
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getappelvalideById")
        {
            $tmp = $this->Appel_offreManager->findappelvalideById($id_appel_offre);
            if ($tmp) 
            {
               $data = $tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getappelinvalideBycontrat")
        {
            $tmp = $this->Appel_offreManager->findappelinvalideBycontrat($id_contrat_bureau_etude);
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
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }*/
            } 
                else
                    $data = array();
        }
        /*if ($menu == "getappelvalidationBycisco")
        {
            $tmp = $this->Appel_offreManager->findAllvalidationBycisco($validation,$id_cisco);
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
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getappelByvalidation")
        {
            $tmp = $this->Appel_offreManager->findAllByvalidation($validation);
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
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['contrat_be'] = $contrat_be;
                }
            } 
                else
                    $data = array();
        }*/
        /*if ($menu == "getappelBycontrat")
        {
            $tmp = $this->Appel_offreManager->findAllBycontrat($id_contrat_bureau_etude,$validation);
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
        elseif ($id)
        {
            $data = array();
            $appel_offre = $this->Appel_offreManager->findById($id);
            $contrat_be = $this->Contrat_beManager->findById($appel_offre->id_contrat_bureau_etude);
            $data['id'] = $appel_offre->id;
            $data['description'] = $appel_offre->description;
            //$data['fichier'] = $appel_offre->fichier;
            $data['date_livraison'] = $appel_offre->date_livraison;
            $data['date_approbation'] = $appel_offre->date_approbation;
            $data['observation'] = $appel_offre->observation;
            $data['contrat_be'] = $contrat_be;
        } 
        else 
        {
            $menu = $this->Appel_offreManager->findAll();
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
                $dataId = $this->Appel_offreManager->add($data);
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
                $update = $this->Appel_offreManager->update($id, $data);
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
            $delete = $this->Appel_offreManager->delete($id);         
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
