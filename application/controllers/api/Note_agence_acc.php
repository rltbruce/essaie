<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Note_agence_acc extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('note_agence_acc_model', 'Note_agence_accManager');
        $this->load->model('agence_acc_model', 'Agence_accManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $annee = $this->get('annee');
        $id_agence_acc = $this->get('id_agence_acc');
        $menu = $this->get('menu');
            
        if ($menu=='getnote_agence_accByfiltre') 
        {   
            $data = array();
            $tmp = $this->Note_agence_accManager->findnote_agence_accByfiltre($this->generer_requete($annee,$id_agence_acc));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $agence_acc = $this->Agence_accManager->findById($value->id_agence_acc);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['note'] = $value->note;
                    $data[$key]['annee'] = $value->annee;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['agence_acc'] = $agence_acc;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $note_agence_acc = $this->Note_agence_accManager->findById($id);
            $agence_acc = $this->Agence_accManager->findById($note_agence_acc->id_agence_acc);
            $data['id'] = $note_agence_acc->id;
            $data['note'] = $note_agence_acc->note;
            $data['annee'] = $note_agence_acc->annee;
            $data['observation'] = $note_agence_acc->observation;
            $data['agence_acc'] = $agence_acc;
        } 
        else 
        {
            $tmp = $this->Note_agence_accManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $ecole = array();
                    $ecole = $this->EcoleManager->findById($value->id_ecole);
                    $classification_note_agence_acc = $this->Classification_Note_agence_accManager->findById($value->id_classification_note_agence_acc);
                    $agence_acc = $this->Agence_accManager->findById($value->id_agence_acc);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['note'] = $value->note;
                    $data[$key]['annee'] = $value->annee;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['agence_acc'] = $agence_acc;
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
                    'note' => $this->post('note'),
                    'annee' => $this->post('annee'),
                    'id_agence_acc' => $this->post('id_agence_acc'),
                    'observation' => $this->post('observation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Note_agence_accManager->add($data);
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
                    'note' => $this->post('note'),
                    'annee' => $this->post('annee'),
                    'id_agence_acc' => $this->post('id_agence_acc'),
                    'observation' => $this->post('observation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Note_agence_accManager->update($id, $data);
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
            $delete = $this->Note_agence_accManager->delete($id);         
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

    public function generer_requete($annee,$id_agence_acc)
    {
            $requete = "annee ='".$annee."'" ;

            if (($id_agence_acc!='*')&&($id_agence_acc!='undefined')&&($id_agence_acc!='null')) 
            {
                $requete = $requete." AND agence_acc.id='".$id_agence_acc."'" ;
            }
            
        return $requete ;
    } 
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
