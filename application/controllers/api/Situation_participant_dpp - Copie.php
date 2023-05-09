<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Travaux_preparatoire extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('travaux_preparatoire_model', 'Travaux_preparatoireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
            
        if ($id)
        {
            $data = array();
            $travaux_preparatoire = $this->Travaux_preparatoireManager->findById($id);
            $data['id'] = $travaux_preparatoire->id;
            $data['designation'] = $travaux_preparatoire->designation;
            $data['unite'] = $travaux_preparatoire->unite;
            $data['qt_prevu'] = $travaux_preparatoire->qt_prevu;
            $data['numero'] = $travaux_preparatoire->numero;
        } 
        else 
        {
            $tmp = $this->Travaux_preparatoireManager->findAll();
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['designation'] = $value->designation;
                    $data[$key]['unite'] = $value->unite;
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
                    'designation' => $this->post('designation'),
                    'unite' => $this->post('unite'),
                    'qt_prevu' => $this->post('qt_prevu'),
                    'numero' => $this->post('numero')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Travaux_preparatoireManager->add($data);
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
                    'designation' => $this->post('designation'),
                    'unite' => $this->post('unite'),
                    'qt_prevu' => $this->post('qt_prevu'),
                    'numero' => $this->post('numero')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Travaux_preparatoireManager->update($id, $data);
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
            $delete = $this->Travaux_preparatoireManager->delete($id);         
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
