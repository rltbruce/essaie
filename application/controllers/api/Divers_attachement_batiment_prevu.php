<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Divers_attachement_batiment_prevu extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('divers_attachement_batiment_prevu_model', 'Divers_attachement_batiment_prevuManager');
        //$this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        $this->load->model('divers_attachement_batiment_model', 'Divers_attachement_batimentManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_attachement_batiment = $this->get('id_attachement_batiment'); 
        $menu = $this->get('menu');
 
        if ($menu == "getattachement_batiment_prevuwithdetailbyrubrique")
        {
            $tmp = $this->Divers_attachement_batiment_prevuManager->getattachement_batiment_prevuwithdetailbyrubrique($id_contrat_prestataire,$id_attachement_batiment);
            if ($tmp) 
            { 
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getmontant_total_prevubycontrat")
        {
            $tmp = $this->Divers_attachement_batiment_prevuManager->getmontant_total_prevubycontrat($id_contrat_prestataire);
            if ($tmp) 
            { 
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getattachement_batimentprevubyrubrique")
        {
            $tmp = $this->Divers_attachement_batiment_prevuManager->getattachement_batimentprevubyrubrique($id_contrat_prestataire,$id_attachement_batiment);
            if ($tmp) 
            {   
                /*foreach ($tmp as $key => $value)
                {
                    $divers_attachement_batiment = $this->Divers_attachement_batimentManager->findById($value->id_divers_attachement_batiment);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['quantite_prevu'] = $value->quantite_prevu;
                    $data[$key]['prix_unitaire'] = $value->prix_unitaire;
                    $data[$key]['montant_prevu'] = $value->montant_prevu;
                    $data[$key]['id_contrat_prestataire'] = $value->id_contrat_prestataire;
                    $data[$key]['divers_attachement_batiment'] = $divers_attachement_batiment;
                    $data[$key]['divers_attachement_batiment'] = $divers_attachement_batiment;
                }*/
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getprevuattachement_batimentbycontrat")
        {
            $tmp = $this->Divers_attachement_batiment_prevuManager->getprevuattachement_batimentbycontrat($id_contrat_prestataire,$id_attachement_batiment);
            if ($tmp) 
            {   
                /*foreach ($tmp as $key => $value)
                {
                    $divers_attachement_batiment = $this->Divers_attachement_batimentManager->findById($value->id_divers_attachement_batiment);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['quantite_prevu'] = $value->quantite_prevu;
                    $data[$key]['prix_unitaire'] = $value->prix_unitaire;
                    $data[$key]['montant_prevu'] = $value->montant_prevu;
                    $data[$key]['id_contrat_prestataire'] = $value->id_contrat_prestataire;
                    $data[$key]['divers_attachement_batiment'] = $divers_attachement_batiment;
                    $data[$key]['divers_attachement_batiment'] = $divers_attachement_batiment;
                }*/
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $divers_attachement_batiment_prevu = $this->Divers_attachement_batiment_prevuManager->findById($id);
            $data['id'] = $divers_attachement_batiment_prevu->id;
            $data['quantite_prevu'] = $divers_attachement_batiment_prevu->quantite_prevu;
            $data['prix_unitaire'] = $divers_attachement_batiment_prevu->prix_unitaire;
            $data['montant_prevu'] = $divers_attachement_batiment_prevu->montant_prevu;
            $data['id_contrat_prestataire'] = $divers_attachement_batiment_prevu->id_contrat_prestataire;
            $data['id_divers_attachement_batiment'] = $divers_attachement_batiment_prevu->id_divers_attachement_batiment;
        } 
        else 
        {
            $tmp = $this->Divers_attachement_batiment_prevuManager->findAll();
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
                    'quantite_prevu' => $this->post('quantite_prevu'),
                    'prix_unitaire' => $this->post('prix_unitaire'),
                    'montant_prevu' => $this->post('montant_prevu'),
                    'unite' => $this->post('unite'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'id_attachement_batiment_detail' => $this->post('id_attachement_batiment_detail')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Divers_attachement_batiment_prevuManager->add($data);
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
                    'quantite_prevu' => $this->post('quantite_prevu'),
                    'prix_unitaire' => $this->post('prix_unitaire'),
                    'montant_prevu' => $this->post('montant_prevu'),
                    'unite' => $this->post('unite'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire'),
                    'id_attachement_batiment_detail' => $this->post('id_attachement_batiment_detail')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Divers_attachement_batiment_prevuManager->update($id, $data);
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
            $delete = $this->Divers_attachement_batiment_prevuManager->delete($id);         
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
