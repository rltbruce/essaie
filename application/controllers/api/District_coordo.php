<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class District_coordo extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('district_model', 'DistrictManager');
        $this->load->model('region_model', 'RegionManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_region = $this->get('id_region');
            
            $tmp = $this->DistrictManager->findAll();
            $tmp2 = $this->DistrictManager->finddistrict_coordo();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $region = array();
                    $region = $this->RegionManager->findById($value->id_region);
                    $dat = array(
                            'code' => $value->code,
                            'nom' => $value->nom,
                            'id_region' => $value->id_region,
                            'coordonnees' => null
                            );
                            $update = $this->DistrictManager->update($value->id, $dat);
                  $data[$key]['id'] = $value->id;
                            $data[$key]['code'] = $value->code;
                            $data[$key]['nom'] = $value->nom;
                   /* foreach ($tmp2 as $key2 => $value2) 
                    {
                        if (strtolower($value->nom) == strtolower($value2->nom))
                        {
                            $dat = array(
                            'code' => $value->code,
                            'nom' => $value->nom,
                            'id_region' => $value->id_region,
                            'coordonnees' => $value2->coordonnees
                            );
                            $update = $this->DistrictManager->update($value->id, $dat);
                            $data[$key]['id'] = $value->id;
                            $data[$key]['code'] = $value->code;
                            $data[$key]['nom'] = $value->nom;
                            $data[$key]['coordonnees'] = $value2->coordonnees;
                        }
                        
                    }*/
                }
            } 
                else
                    $data = array();
        
    
        
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
        $data = array(
                    'coordonnees' => serialize($this->post('coordonnees')) 
                );
        $update = $this->DistrictManager->update_coordo($id, $data);
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
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
