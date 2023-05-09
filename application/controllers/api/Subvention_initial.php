<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Subvention_initial extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('subvention_initial_model', 'Subvention_initialManager');
        $this->load->model('type_batiment_model', 'Type_batimentManager');
        $this->load->model('type_latrine_model', 'Type_latrineManager');
        $this->load->model('type_mobilier_model', 'Type_mobilierManager');
        $this->load->model('type_cout_maitrise_model', 'Type_cout_maitriseManager');
        $this->load->model('type_cout_sousprojet_model', 'Type_cout_sousprojetManager');
        $this->load->model('acces_zone_model', 'Acces_zoneManager');
        $this->load->model('zone_subvention_model', 'Zone_subventionManager');

        //$this->load->model('attachement_batiment_model', 'Attachement_batimentManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');

        $id_zone_subvention = $this->get('id_zone_subvention');
        $id_acces_zone = $this->get('id_acces_zone');
        $menu = $this->get('menu');
        if ($menu == 'getsubventionByzone')
        {
            $tmp = $this->Subvention_initialManager->findByZone($id_zone_subvention,$id_acces_zone);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    
                    $type_latrine = $this->Type_latrineManager->findById($value->id_type_latrine);                   
                    $type_batiment = $this->Type_batimentManager->findById($value->id_type_batiment);
                    $type_mobilier = $this->Type_mobilierManager->findById($value->id_type_mobilier);
                    $type_cout_maitrise = $this->Type_cout_maitriseManager->findById($value->id_type_cout_maitrise);
                    $type_cout_sousprojet = $this->Type_cout_sousprojetManager->findById($value->id_type_cout_sousprojet);
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['type_latrine'] = $type_latrine;
                    $data[$key]['type_batiment'] = $type_batiment;
                    $data[$key]['type_mobilier'] = $type_mobilier;
                    $data[$key]['type_cout_maitrise'] = $type_cout_maitrise;
                    $data[$key]['type_cout_sousprojet'] = $type_cout_sousprojet;

                    $data[$key]['type_batiment']->zone_subvention = $zone_subvention;
                    $data[$key]['type_batiment']->acces_zone = $acces_zone;

                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['acces_zone'] = $acces_zone;


                    
                }
            } 
                else
                    $data = array();
        } 
        elseif ($id)
        {
            $data = array();
            $subvention_initial = $this->Subvention_initialManager->findById($id);
            $type_latrine = $this->Type_latrineManager->findById($subvention_initial->id_type_latrine);
            $type_batiment = $this->Type_batimentManager->findById($subvention_initial->id_type_batiment);
            $type_mobilier = $this->Type_mobilierManager->findById($subvention_initial->id_type_mobilier);
            $type_cout_maitrise = $this->Type_cout_maitriseManager->findById($subvention_initial->id_type_cout_maitrise);
            $type_cout_sousprojet = $this->Type_cout_sousprojetManager->findById($subvention_initial->id_type_cout_sousprojet);
            $zone_subvention = $this->Zone_subventionManager->findById($subvention_initial->id_zone_subvention);
            $acces_zone = $this->Acces_zoneManager->findById($subvention_initial->id_acces_zone);

            $data['id'] = $subvention_initial->id;
            $data['type_latrine'] = $type_latrine;
            $data['type_batiment'] = $type_batiment;
            $data['type_mobilier'] = $type_mobilier;
            $data['type_cout_maitrise'] = $type_cout_maitrise;
            $data['type_cout_sousprojet'] = $type_cout_sousprojet;

            $data['zone_subvention'] = $zone_subvention;
            $data['acces_zone'] = $acces_zone;
        } 
        else 
        {
            $tmp = $this->Subvention_initialManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    
                    $type_latrine = $this->Type_latrineManager->findById($value->id_type_latrine);                   
                    $type_batiment = $this->Type_batimentManager->findById($value->id_type_batiment);
                    $type_mobilier = $this->Type_mobilierManager->findById($value->id_type_mobilier);
                    $type_cout_maitrise = $this->Type_cout_maitriseManager->findById($value->id_type_cout_maitrise);
                    $type_cout_sousprojet = $this->Type_cout_sousprojetManager->findById($value->id_type_cout_sousprojet);
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['type_latrine'] = $type_latrine;
                    $data[$key]['type_batiment'] = $type_batiment;
                    $data[$key]['type_mobilier'] = $type_mobilier;
                    $data[$key]['type_cout_maitrise'] = $type_cout_maitrise;
                    $data[$key]['type_cout_sousprojet'] = $type_cout_sousprojet;

                    $data[$key]['type_batiment']->zone_subvention = $zone_subvention;
                    $data[$key]['type_batiment']->acces_zone = $acces_zone;

                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['acces_zone'] = $acces_zone;


                    
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
        $menu = $this->post('menu') ;
        //$id_type_latrine = $this->post('id_type_latrine');
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'id_type_batiment' => $this->post('id_type_batiment'),
                    'id_type_latrine' => $this->post('id_type_latrine'),
                    'id_type_mobilier' => $this->post('id_type_mobilier'),
                    'id_type_cout_maitrise' => $this->post('id_type_cout_maitrise'),
                    'id_type_cout_sousprojet' => $this->post('id_type_cout_sousprojet'),
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
                $dataId = $this->Subvention_initialManager->add($data);
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
                    'id_type_batiment' => $this->post('id_type_batiment'),
                    'id_type_latrine' => $this->post('id_type_latrine'),
                    'id_type_mobilier' => $this->post('id_type_mobilier'),
                    'id_type_cout_maitrise' => $this->post('id_type_cout_maitrise'),
                    'id_type_cout_sousprojet' => $this->post('id_type_cout_sousprojet'),
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
                $update = $this->Subvention_initialManager->update($id, $data);
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
            $delete = $this->Subvention_initialManager->delete($id);         
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
