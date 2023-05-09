<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Cisco extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('cisco_model', 'CiscoManager');
        $this->load->model('district_model', 'DistrictManager');
        $this->load->model('region_model', 'RegionManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_district = $this->get('id_district');
        $id_region = $this->get('id_region');
            
        if ($id_region) 
        {   $data = array();
            $tmp = $this->CiscoManager->findByregion($id_region);
            if ($tmp) 
            {
                $data=$tmp;
            }
        }
        elseif ($id_district) 
        {   $data = array();
            $tmp = $this->CiscoManager->findBydistrict($id_district);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $district = array();
                    $district = $this->DistrictManager->findById($value->id_district);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['district'] = $district;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $cisco = $this->CiscoManager->findById($id);
            $district = $this->DistrictManager->findById($cisco->id_district);
            $data['id'] = $cisco->id;
            $data['code'] = $cisco->code;
            $data['description'] = $cisco->description;
            $data['district'] = $district;
        } 
        else 
        {
            $menu = $this->CiscoManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $district = array();
                    $district = $this->DistrictManager->findById($value->id_district);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['district'] = $district;
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
                    'code' => $this->post('code'),
                    'description' => $this->post('description'),
                    'id_district' => $this->post('id_district')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->CiscoManager->add($data);
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
                    'code' => $this->post('code'),
                    'description' => $this->post('description'),
                    'id_district' => $this->post('id_district')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->CiscoManager->update($id, $data);
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
            $delete = $this->CiscoManager->delete($id);         
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
