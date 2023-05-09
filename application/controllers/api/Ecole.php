<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Ecole extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ecole_model', 'EcoleManager');
        $this->load->model('fokontany_model', 'FokontanyManager');
        $this->load->model('zone_subvention_model', 'Zone_subventionManager');
        $this->load->model('acces_zone_model', 'Acces_zoneManager');
        $this->load->model('cisco_model', 'CiscoManager');
        $this->load->model('commune_model', 'CommuneManager');
        $this->load->model('zap_model', 'ZapManager');
        $this->load->model('region_model', 'RegionManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_fokontany = $this->get('id_fokontany');
        $menus = $this->get('menus');
        $id_cisco = $this->get('id_cisco');
        $id_commune = $this->get('id_commune');
        $id_zap = $this->get('id_zap');
        $id_region = $this->get('id_region');
        $id_ecole = $this->get('id_ecole');
            
        if ($menus=='getecoleByfiltre') 
        {   $data = array();
            $tmp = $this->EcoleManager->findByfiltre($this->generer_requete($id_region,$id_cisco,$id_commune,$id_ecole,$id_zap));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    
                    $fokontany = $this->FokontanyManager->findById($value->id_fokontany);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $region = $this->RegionManager->findById($value->id_region);
                    $zap = $this->ZapManager->findById($value->id_zap);
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['lieu'] = $value->lieu;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['latitude'] = $value->latitude;
                    $data[$key]['longitude'] = $value->longitude;
                    $data[$key]['altitude'] = $value->altitude;
                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['acces_zone'] = $acces_zone;
                    $data[$key]['fokontany'] = $fokontany;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['commune'] = $commune;
                    $data[$key]['zap'] = $zap;
                    $data[$key]['region'] = $region;
                }
            } 
        }
        elseif ($menus=='getecoleByzap') 
        {   $data = array();
            $tmp = $this->EcoleManager->findByzap($id_zap);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['lieu'] = $value->lieu;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['latitude'] = $value->latitude;
                    $data[$key]['longitude'] = $value->longitude;
                    $data[$key]['altitude'] = $value->altitude;
                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['acces_zone'] = $acces_zone;
                }
            }
        }
        elseif ($menus=='getecoleBycommune') 
        {   $data = array();
            $tmp = $this->EcoleManager->findBycommune($id_commune);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['lieu'] = $value->lieu;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['latitude'] = $value->latitude;
                    $data[$key]['longitude'] = $value->longitude;
                    $data[$key]['altitude'] = $value->altitude;
                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['acces_zone'] = $acces_zone;
                }
            }
        }
        elseif ($menus=='getecoleBycisco') 
        {   $data = array();
            $tmp = $this->EcoleManager->findBycisco($id_cisco);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $fokontany = array();
                    $fokontany = $this->FokontanyManager->findById($value->id_fokontany);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $region = $this->RegionManager->findById($value->id_region);
                    $zap = $this->ZapManager->findById($value->id_zap);
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['lieu'] = $value->lieu;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['latitude'] = $value->latitude;
                    $data[$key]['longitude'] = $value->longitude;
                    $data[$key]['altitude'] = $value->altitude;
                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['acces_zone'] = $acces_zone;
                    $data[$key]['fokontany'] = $fokontany;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['commune'] = $commune;
                    $data[$key]['zap'] = $zap;
                    $data[$key]['region'] = $region;
                }
            }
        }
        elseif ($id_fokontany) 
        {   $data = array();
            $tmp = $this->EcoleManager->findByfokontany($id_fokontany);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $fokontany = array();
                    $fokontany = $this->FokontanyManager->findById($value->id_fokontany);
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $zap = $this->ZapManager->findById($value->id_zap);
                    $region = $this->RegionManager->findById($value->id_region);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['lieu'] = $value->lieu;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['latitude'] = $value->latitude;
                    $data[$key]['longitude'] = $value->longitude;
                    $data[$key]['altitude'] = $value->altitude;
                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['acces_zone'] = $acces_zone;
                    $data[$key]['fokontany'] = $fokontany;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['commune'] = $commune;
                    $data[$key]['zap'] = $zap;
                    $data[$key]['region'] = $region;
                }
            }
        }
        elseif ($id)
        {
            $data = array();
            $ecole = $this->EcoleManager->findById($id);
            $fokontany = $this->FokontanyManager->findById($ecole->id_fokontany);
            $zone_subvention = $this->Zone_subventionManager->findById($ecole->id_zone_subvention);
            $acces_zone = $this->Acces_zoneManager->findById($ecole->id_acces_zone);
            $cisco = $this->CiscoManager->findById($ecole->id_cisco);
            $commune = $this->CommuneManager->findById($ecole->id_commune);
            $zap = $this->ZapManager->findById($ecole->id_zap);
            $region = $this->RegionManager->findById($ecole->id_region);
            $data['id'] = $ecole->id;
            $data['code'] = $ecole->code;
            $data['lieu'] = $ecole->lieu;
            $data['description'] = $ecole->description;
            $data['latitude'] = $ecole->latitude;
            $data['longitude'] = $ecole->longitude;
            $data['altitude'] = $ecole->altitude;
            $data['zone_subvention'] = $zone_subvention;
            $data['acces_zone'] = $acces_zone;
            $data['fokontany'] = $fokontany;
            $data['cisco'] = $cisco;
            $data['commune'] = $commune;
            $data['zap'] = $zap;
            $data['region'] = $region;
        } 
        else 
        {
            $menu = $this->EcoleManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $fokontany = array();
                    $fokontany = $this->FokontanyManager->findById($value->id_fokontany);
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $cisco = $this->CiscoManager->findById($value->id_cisco);
                    $commune = $this->CommuneManager->findById($value->id_commune);
                    $zap = $this->ZapManager->findById($value->id_zap);
                    $region = $this->RegionManager->findById($value->id_region);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['lieu'] = $value->lieu;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['latitude'] = $value->latitude;
                    $data[$key]['longitude'] = $value->longitude;
                    $data[$key]['altitude'] = $value->altitude;
                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['acces_zone'] = $acces_zone;
                    $data[$key]['fokontany'] = $fokontany;
                    $data[$key]['cisco'] = $cisco;
                    $data[$key]['commune'] = $commune;
                    $data[$key]['zap'] = $zap;
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
                    'lieu' => $this->post('lieu'),
                    'description' => $this->post('description'),
                    'latitude' => $this->post('latitude'),
                    'longitude' => $this->post('longitude'),
                    'altitude' => $this->post('altitude'),
                    'id_zone_subvention' => $this->post('id_zone_subvention'),
                    'id_acces_zone' => $this->post('id_acces_zone'),
                    'id_fokontany' => $this->post('id_fokontany'),
                    'id_cisco' => $this->post('id_cisco'),
                    'id_commune' => $this->post('id_commune'),
                    'id_zap' => $this->post('id_zap'),
                    'id_region' => $this->post('id_region')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->EcoleManager->add($data);
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
                    'lieu' => $this->post('lieu'),
                    'description' => $this->post('description'),
                    'latitude' => $this->post('latitude'),
                    'longitude' => $this->post('longitude'),
                    'altitude' => $this->post('altitude'),
                    'id_zone_subvention' => $this->post('id_zone_subvention'),
                    'id_acces_zone' => $this->post('id_acces_zone'),
                    'id_fokontany' => $this->post('id_fokontany'),
                    'id_cisco' => $this->post('id_cisco'),
                    'id_commune' => $this->post('id_commune'),
                    'id_zap' => $this->post('id_zap'),
                    'id_region' => $this->post('id_region')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->EcoleManager->update($id, $data);
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
            $delete = $this->EcoleManager->delete($id);         
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


    public function generer_requete($id_region,$id_cisco,$id_commune,$id_ecole,$id_zap)
    {
        $requete = "region.id='".$id_region."'" ;           

            if (($id_cisco!='*')&&($id_cisco!='undefined')&&($id_cisco!='null')&&($id_cisco!='')) 
            {
                $requete = $requete." AND ecole.id_cisco='".$id_cisco."'" ;
            }

            if (($id_commune!='*')&&($id_commune!='undefined')&&($id_commune!='null')&&($id_commune!='')) 
            {
                $requete = $requete." AND ecole.id_commune='".$id_commune."'" ;
            }

            if (($id_ecole!='*')&&($id_ecole!='undefined')&&($id_ecole!='null')&&($id_ecole!='')) 
            {
                $requete = $requete." AND ecole.id='".$id_ecole."'" ;
            }

            if (($id_zap!='*')&&($id_zap!='undefined')&&($id_zap!='null')&&($id_zap!='')) 
            {
                $requete = $requete." AND ecole.id_zap='".$id_zap."'" ;
            }
            
        return $requete ;
    }
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
