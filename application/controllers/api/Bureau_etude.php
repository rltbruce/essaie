<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Bureau_etude extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('bureau_etude_model', 'Bureau_etudeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $moe_like = $this->get('moe_like');

        if ($menu=="getbureau_etudebylike")
        {   $moe = strtolower($moe_like);
            $tmp = $this->Bureau_etudeManager->getbureau_etudebylike($moe);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        } 
        elseif ($id)
        {
            $data = array();
            $bureau_etude = $this->Bureau_etudeManager->findById($id);
            $data['id'] = $bureau_etude->id;
            $data['telephone'] = $bureau_etude->telephone;
            $data['nom'] = $bureau_etude->nom;
            $data['nif'] = $bureau_etude->nif;
            $data['stat'] = $bureau_etude->stat;
            $data['siege'] = $bureau_etude->siege;
        } 
        else 
        {
            $tmp = $this->Bureau_etudeManager->findAll();
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
                $dataId = $this->Bureau_etudeManager->add($data);
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
                $update = $this->Bureau_etudeManager->update($id, $data);
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
            $delete = $this->Bureau_etudeManager->delete($id);         
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
