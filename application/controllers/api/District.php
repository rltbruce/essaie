<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class District extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('district_model', 'DistrictManager');
        $this->load->model('region_model', 'RegionManager');
    }

    public function index_get() 
    {   
        set_time_limit(0);
        ini_set ('memory_limit', '40000M');
        $id = $this->get('id');
        $id_region = $this->get('id_region');
        $menu = $this->get('menu');
        $now = date('yy');
        $datearray= $date_t     = explode('-', $now);
            
        if ($menu=="reportingvuecarte2") 
        {   
            $tmp = $this->DistrictManager->findByregion($id_region);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$reporting = array();
                    //$reporting = $this->DistrictManager->findreporting($now, $value->id);
                    $coordonnees=null;                
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $now;
                    $data[$key]['nom'] = $value->nom;
                    if (!is_null($value->coordonnees) && $value->coordonnees!='')
                    {
                        $coordonnees=unserialize($value->coordonnees);
                    }
                    $data[$key]['coordonnees'] = $coordonnees;
                    
                    //$data[$key]['reporting'] =$reporting;
                    
                }

               // $data = $tmp ;
            }
            else 
                $data = array();
        }
        elseif ($menu=="reportingvuecarte") 
        {   
            $tmp = $this->DistrictManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $coordonnees=null;                
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['nom'] = $value->nom;
                    if (!is_null($value->coordonnees) && $value->coordonnees!='')
                    {
                        $coordonnees=unserialize($value->coordonnees);
                    }
                    $data[$key]['coordonnees'] = unserialize($value->coordonnees);

                    
                    
                }

               // $data = $tmp ;
            }
            else 
                $data = array();
        }
        elseif ($id_region) 
        {   $data = array();
            $tmp = $this->DistrictManager->findByregion($id_region);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $region = array();
                    $region = $this->RegionManager->findById($value->id_region);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['region'] = $region;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $district = $this->DistrictManager->findById($id);
            $region = $this->RegionManager->findById($district->id_region);
            $data['id'] = $district->id;
            $data['code'] = $district->code;
            $data['nom'] = $district->nom;
            $data['region'] = $region;
        } 
        else 
        {
            $menu = $this->DistrictManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $region = array();
                    $region = $this->RegionManager->findById($value->id_region);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['nom'] = $value->nom;
                    $data[$key]['region'] = $region;
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
                    'nom' => $this->post('nom'),
                    'id_region' => $this->post('id_region')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->DistrictManager->add($data);
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
                    'nom' => $this->post('nom'),
                    'id_region' => $this->post('id_region')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->DistrictManager->update($id, $data);
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
            $delete = $this->DistrictManager->delete($id);         
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
