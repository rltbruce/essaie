<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class type_mobilier extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('type_mobilier_model', 'Type_mobilierManager');
        $this->load->model('zone_subvention_model', 'Zone_subventionManager');
        $this->load->model('acces_zone_model', 'Acces_zoneManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');;
        $id_zone_subvention = $this->get('id_zone_subvention');
        $id_acces_zone = $this->get('id_acces_zone');
        $menu = $this->get('menu');
            
        if ($menu=='getByZone') 
        {   $data = array();
            $tmp = $this->Type_mobilierManager->findByZone($id_zone_subvention,$id_acces_zone);
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
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    $data[$key]['nbr_table_banc'] = $value->nbr_table_banc;
                    $data[$key]['nbr_table_maitre'] = $value->nbr_table_maitre;
                    $data[$key]['nbr_chaise_maitre'] = $value->nbr_chaise_maitre;
                    
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $type_mobilier = $this->Type_mobilierManager->findById($id);
            $acces_zone = array();
            $zone_subvention = array();

            $acces_zone = $this->Acces_zoneManager->findById($type_batiment->id_acces_zone);
            $zone_subvention = $this->Zone_subventionManager->findById($type_batiment->id_zone_subvention);
            $data['id'] = $type_mobilier->id;
            $data['libelle'] = $type_mobilier->libelle;
            $data['description'] = $type_mobilier->description;
            $data['nbr_chaise_maitre'] = $type_mobilier->nbr_chaise_maitre;
            $data['nbr_table_maitre'] = $type_mobilier->nbr_table_maitre;
            $data['nbr_table_banc'] = $type_mobilier->nbr_table_banc;
            $data['cout_mobilier'] = $type_mobilier->cout_mobilier;
            $data['acces_zone'] = $acces_zone;
            $data['zone_subvention'] = $zone_subvention;
            
        } 
        else 
        {
            $menu = $this->Type_mobilierManager->findAll();
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
                    $data[$key]['nbr_table_banc'] = $value->nbr_table_banc;
                    $data[$key]['nbr_table_maitre'] = $value->nbr_table_maitre;
                    $data[$key]['nbr_chaise_maitre'] = $value->nbr_chaise_maitre;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    
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
                    'nbr_table_maitre' => $this->post('nbr_table_maitre'),
                    'nbr_table_banc' => $this->post('nbr_table_banc'),
                    'nbr_chaise_maitre' => $this->post('nbr_chaise_maitre'),
                    'cout_mobilier' => $this->post('cout_mobilier'),
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
                $dataId = $this->Type_mobilierManager->add($data);
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
                    'nbr_table_maitre' => $this->post('nbr_table_maitre'),
                    'nbr_table_banc' => $this->post('nbr_table_banc'),
                    'nbr_chaise_maitre' => $this->post('nbr_chaise_maitre'),
                    'cout_mobilier' => $this->post('cout_mobilier'),
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
                $update = $this->Type_mobilierManager->update($id, $data);
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
            $delete = $this->Type_mobilierManager->delete($id);         
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
