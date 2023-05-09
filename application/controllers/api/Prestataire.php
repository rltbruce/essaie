<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Prestataire extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('prestataire_model', 'PrestataireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_convention_entete = $this->get('id_convention_entete');
        $mpe_like = $this->get('mpe_like');
            
        if ($menu=="getprestatairebylike")
        {   $mpe = strtolower($mpe_like);
            $tmp = $this->PrestataireManager->getprestatairebylike($mpe);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        } 
        elseif ($menu=="prestataireBysousmissionnaire")
        {
            $tmp = $this->PrestataireManager->prestataireBysousmissionnaire($id_convention_entete);
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
        elseif ($id)
        {
            $data = array();
            $prestataire = $this->PrestataireManager->findById($id);
            $data['id'] = $prestataire->id;
            $data['telephone'] = $prestataire->telephone;
            $data['nom'] = $prestataire->nom;
            $data['nif'] = $prestataire->nif;
            $data['stat'] = $prestataire->stat;
            $data['siege'] = $prestataire->siege;
        } 
        else 
        {
            $tmp = $this->PrestataireManager->findAll();
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
                $dataId = $this->PrestataireManager->add($data);
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
                $update = $this->PrestataireManager->update($id, $data);
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
            $delete = $this->PrestataireManager->delete($id);         
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
