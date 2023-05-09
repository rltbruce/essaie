<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Partenaire_relai extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('partenaire_relai_model', 'Partenaire_relaiManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
            
        if ($id)
        {
            $data = array();
            $partenaire_relai = $this->Partenaire_relaiManager->findById($id);
            $data['id'] = $partenaire_relai->id;
            $data['telephone'] = $partenaire_relai->telephone;
            $data['nom'] = $partenaire_relai->nom;
            $data['nif'] = $partenaire_relai->nif;
            $data['stat'] = $partenaire_relai->stat;
            $data['siege'] = $partenaire_relai->siege;
        } 
        else 
        {
            $tmp = $this->Partenaire_relaiManager->findAll();
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $district = array();
                    $data[$key]['id'] = $value->id;
                    $data[$key]['telephone'] = $value->telephone;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['nif'] = $value->nif;
                    $data[$key]['stat'] = $value->stat;
                    $data[$key]['siege'] = $value->siege;
                }*/
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
                    'telephone' => $this->post('telephone'),
                    'nom' => $this->post('nom'),
                    'nif' => $this->post('nif'),
                    'stat' => $this->post('stat'),
                    'siege' => $this->post('siege')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Partenaire_relaiManager->add($data);
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
                    'telephone' => $this->post('telephone'),
                    'nom' => $this->post('nom'),
                    'nif' => $this->post('nif'),
                    'stat' => $this->post('stat'),
                    'siege' => $this->post('siege')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Partenaire_relaiManager->update($id, $data);
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
            $delete = $this->Partenaire_relaiManager->delete($id);         
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
