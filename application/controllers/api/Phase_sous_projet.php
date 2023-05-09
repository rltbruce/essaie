<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Phase_sous_projet extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('phase_sous_projet_model', 'Phase_sous_projetManager');
        $this->load->model('etape_sousprojet_model', 'Etape_sousprojetManager');
        //$this->load->model('contrat_etape_sousprojet_model', 'Contrat_Etape_sousprojetManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_delai_travaux = $this->get('id_delai_travaux');
        $id_phase_sous_projet = $this->get('id_phase_sous_projet');
        
        if ($menu=='getphasesousprojetvalideBycontrat')
         {
            $tmp = $this->Phase_sous_projetManager->findphasesousprojetvalideBydelai($id_delai_travaux);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $etape_sousprojet = $this->Etape_sousprojetManager->findById($value->id_etape_sousprojet);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_travaux'] = $value->date_travaux;
                    $data[$key]['etape_sousprojet'] = $etape_sousprojet;
                        }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getphase_sous_projetvalideById')
         {
            $tmp = $this->Phase_sous_projetManager->getphase_sous_projetvalideById($id_phase_sous_projet);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $etape_sousprojet = $this->Etape_sousprojetManager->findById($value->id_etape_sousprojet);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_travaux'] = $value->date_travaux;
                    $data[$key]['etape_sousprojet'] = $etape_sousprojet;
                        }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getphasesousprojetinvalideBydelai')
         {
            $tmp = $this->Phase_sous_projetManager->findphasesousprojetinvalideBydelai($id_delai_travaux);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $etape_sousprojet = $this->Etape_sousprojetManager->findById($value->id_etape_sousprojet);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_travaux'] = $value->date_travaux;
                    $data[$key]['etape_sousprojet'] = $etape_sousprojet;
                        }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getphasesousprojetBydelai')
         {
            $tmp = $this->Phase_sous_projetManager->findphasesousprojetBydelai($id_delai_travaux);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $etape_sousprojet = $this->Etape_sousprojetManager->findById($value->id_etape_sousprojet);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_travaux'] = $value->date_travaux;
                    $data[$key]['etape_sousprojet'] = $etape_sousprojet;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($id)
        {
            $data = array();
            $phase_sous_projet = $this->Phase_sous_projetManager->findById($id);

            $etape_sousprojet = $this->Etape_sousprojetManager->findById($phase_sous_projet->id_etape_sousprojet);

            $data['id'] = $phase_sous_projet->id;
            $data['validation'] = $phase_sous_projet->validation;
            $data['date_travaux'] = $phase_sous_projet->date_travaux;
            $data['etape_sousprojet'] = $etape_sousprojet;
        } 
        else 
        {
            $tmp = $this->Phase_sous_projetManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $etape_sousprojet = $this->Etape_sousprojetManager->findById($value->id_etape_sousprojet);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_travaux'] = $value->date_travaux;
                    $data[$key]['etape_sousprojet'] = $etape_sousprojet;
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
                     'id' => $this->post('id'),                    
                    'id_etape_sousprojet' => $this->post('id_etape_sousprojet'),
                    'id_delai_travaux' => $this->post('id_delai_travaux'),
                    'validation' => $this->post('validation'),
                    'date_travaux' => $this->post('date_travaux')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Phase_sous_projetManager->add($data);
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
                     'id' => $this->post('id'),                    
                    'id_etape_sousprojet' => $this->post('id_etape_sousprojet'),
                    'id_delai_travaux' => $this->post('id_delai_travaux'),
                    'validation' => $this->post('validation'),
                    'date_travaux' => $this->post('date_travaux')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Phase_sous_projetManager->update($id, $data);
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
            $delete = $this->Phase_sous_projetManager->delete($id);         
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
