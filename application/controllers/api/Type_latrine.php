<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class type_latrine extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('type_latrine_model', 'Type_latrineManager');
        $this->load->model('zone_subvention_model', 'Zone_subventionManager');
        $this->load->model('acces_zone_model', 'Acces_zoneManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_zone_subvention = $this->get('id_zone_subvention');
        $id_acces_zone = $this->get('id_acces_zone');
        $menu = $this->get('menu');
            
        if ($menu=='getByZone') 
        {   $data = array();
            $tmp = $this->Type_latrineManager->findByZone($id_zone_subvention,$id_acces_zone);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                   $acces_zone = array();
                    $zone_subvention = array();

                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $data[$key]['acces_zone'] = $acces_zone;
                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['nbr_box_latrine'] = $value->nbr_box_latrine;
                    $data[$key]['nbr_point_eau'] = $value->nbr_point_eau;
                    $data[$key]['cout_latrine'] = $value->cout_latrine;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $type_latrine = $this->Type_latrineManager->findById($id);
            $acces_zone = array();
            $zone_subvention = array();

            $acces_zone = $this->Acces_zoneManager->findById($type_batiment->id_acces_zone);
            $zone_subvention = $this->Zone_subventionManager->findById($type_batiment->id_zone_subvention);
            $data['id'] = $type_latrine->id;
            $data['code'] = $type_latrine->code;
            $data['libelle'] = $type_latrine->libelle;
            $data['description'] = $type_latrine->description;
            $data['nbr_box_latrine'] = $type_latrine->nbr_box_latrine;
            $data['nbr_point_eau'] = $type_latrine->nbr_point_eau;
            $data['cout_latrine'] = $type_latrine->cout_latrine;
            $data['acces_zone'] = $acces_zone;
            $data['zone_subvention'] = $zone_subvention;
        } 
        else 
        {
            $menu = $this->Type_latrineManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $acces_zone = array();
                    $zone_subvention = array();

                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $data[$key]['acces_zone'] = $acces_zone;
                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['nbr_box_latrine'] = $value->nbr_box_latrine;
                    $data[$key]['nbr_point_eau'] = $value->nbr_point_eau;
                    $data[$key]['cout_latrine'] = $value->cout_latrine;
                    
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
                    'libelle' => $this->post('libelle'),
                    'description' => $this->post('description'),
                    'nbr_box_latrine' => $this->post('nbr_box_latrine'),
                    'nbr_point_eau' => $this->post('nbr_point_eau'),
                    'cout_latrine' => $this->post('cout_latrine'),
                    'id_zone_subvention' => $this->post('id_zone_subvention'),
                    'id_acces_zone' => $this->post('id_acces_zone')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Type_latrineManager->add($data);
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
                    'libelle' => $this->post('libelle'),
                    'description' => $this->post('description'),
                    'nbr_box_latrine' => $this->post('nbr_box_latrine'),
                    'nbr_point_eau' => $this->post('nbr_point_eau'),
                    'cout_latrine' => $this->post('cout_latrine'),
                    'id_zone_subvention' => $this->post('id_zone_subvention'),
                    'id_acces_zone' => $this->post('id_acces_zone')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Type_latrineManager->update($id, $data);
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
            $delete = $this->Type_latrineManager->delete($id);         
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
