<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Divers_attachement_latrine_prevu extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('divers_attachement_latrine_prevu_model', 'Divers_attachement_latrine_prevuManager');
        //$this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        $this->load->model('divers_attachement_latrine_model', 'Divers_attachement_latrineManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_attachement_latrine = $this->get('id_attachement_latrine'); 
        $menu = $this->get('menu');
 
        if ($menu == "getattachement_latrine_prevuwithdetailbyrubrique")
        {
            $tmp = $this->Divers_attachement_latrine_prevuManager->getattachement_latrine_prevuwithdetailbyrubrique($id_contrat_prestataire,$id_attachement_latrine);
            if ($tmp) 
            { 
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getattachement_latrineprevubyrubrique")
        {
            $tmp = $this->Divers_attachement_latrine_prevuManager->getattachement_latrineprevubyrubrique($id_contrat_prestataire,$id_attachement_latrine);
            if ($tmp) 
            {   
                /*foreach ($tmp as $key => $value)
                {
                    $divers_attachement_latrine = $this->Divers_attachement_latrineManager->findById($value->id_divers_attachement_latrine);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['quantite_prevu'] = $value->quantite_prevu;
                    $data[$key]['prix_unitaire'] = $value->prix_unitaire;
                    $data[$key]['montant_prevu'] = $value->montant_prevu;
                    $data[$key]['id_contrat_prestataire'] = $value->id_contrat_prestataire;
                    $data[$key]['divers_attachement_latrine'] = $divers_attachement_latrine;
                    $data[$key]['divers_attachement_latrine'] = $divers_attachement_latrine;
                }*/
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu == "getprevuattachement_latrinebycontrat")
        {
            $tmp = $this->Divers_attachement_latrine_prevuManager->getprevuattachement_latrinebycontrat($id_contrat_prestataire,$id_attachement_latrine);
            if ($tmp) 
            {   
                /*foreach ($tmp as $key => $value)
                {
                    $divers_attachement_latrine = $this->Divers_attachement_latrineManager->findById($value->id_divers_attachement_latrine);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['quantite_prevu'] = $value->quantite_prevu;
                    $data[$key]['prix_unitaire'] = $value->prix_unitaire;
                    $data[$key]['montant_prevu'] = $value->montant_prevu;
                    $data[$key]['id_contrat_prestataire'] = $value->id_contrat_prestataire;
                    $data[$key]['divers_attachement_latrine'] = $divers_attachement_latrine;
                    $data[$key]['divers_attachement_latrine'] = $divers_attachement_latrine;
                }*/
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $divers_attachement_latrine_prevu = $this->Divers_attachement_latrine_prevuManager->findById($id);
            $data['id'] = $divers_attachement_latrine_prevu->id;
            $data['quantite_prevu'] = $divers_attachement_latrine_prevu->quantite_prevu;
            $data['prix_unitaire'] = $divers_attachement_latrine_prevu->prix_unitaire;
            $data['montant_prevu'] = $divers_attachement_latrine_prevu->montant_prevu;
            $data['id_contrat_prestataire'] = $divers_attachement_latrine_prevu->id_contrat_prestataire;
            $data['id_divers_attachement_latrine'] = $divers_attachement_latrine_prevu->id_divers_attachement_latrine;
        } 
        else 
        {
            $tmp = $this->Divers_attachement_latrine_prevuManager->findAll();
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
                    'id_attachement_latrine_detail' => $this->post('id_attachement_latrine_detail')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Divers_attachement_latrine_prevuManager->add($data);
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
                    'id_attachement_latrine_detail' => $this->post('id_attachement_latrine_detail')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Divers_attachement_latrine_prevuManager->update($id, $data);
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
            $delete = $this->Divers_attachement_latrine_prevuManager->delete($id);         
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
