<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Type_batiment extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('type_batiment_model', 'Type_batimentManager');
        $this->load->model('zone_subvention_model', 'Zone_subventionManager');
        $this->load->model('acces_zone_model', 'Acces_zoneManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_acces_zone = $this->get('id_acces_zone');
        $id_zone_subvention = $this->get('id_zone_subvention');
            
        if ($menu=='getbatimentByZone') 
        {   $data = array();
            //$tmp = array();
            $tmp = $this->Type_batimentManager->findByZone($id_zone_subvention,$id_acces_zone);
            //$data=$tmp;
           if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $acces_zone = array();
                    $zone_subvention = array();

                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['nbr_salle'] = $value->nbr_salle;
                    $data[$key]['cout_batiment'] = $value->cout_batiment;
                    $data[$key]['acces_zone'] = $acces_zone;
                    $data[$key]['zone_subvention'] = $zone_subvention;
                }
           }
        }
        elseif ($id)
        {
            $data = array();
            $type_batiment = $this->Type_batimentManager->findById($id);

            $acces_zone = array();
            $zone_subvention = array();

            $acces_zone = $this->Acces_zoneManager->findById($type_batiment->id_acces_zone);
            $zone_subvention = $this->Zone_subventionManager->findById($type_batiment->id_zone_subvention);
            $data['id'] = $type_batiment->id;
            $data['code'] = $type_batiment->code;
            $data['libelle'] = $type_batiment->libelle;
            $data['description'] = $type_batiment->description;
            $data['nbr_salle'] = $type_batiment->nbr_salle;
            $data['cout_batiment'] = $type_batiment->cout_batiment;
            $data['acces_zone'] = $acces_zone;
            $data['zone_subvention'] = $zone_subvention;
        } 
        else 
        {
            $menu = $this->Type_batimentManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $acces_zone = array();
                    $zone_subvention = array();

                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['nbr_salle'] = $value->nbr_salle;
                    $data[$key]['cout_batiment'] = $value->cout_batiment;
                    $data[$key]['acces_zone'] = $acces_zone;
                    $data[$key]['zone_subvention'] = $zone_subvention;
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
                    'nbr_salle' => $this->post('nbr_salle'),
                    'cout_batiment' => $this->post('cout_batiment'),
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
                $dataId = $this->Type_batimentManager->add($data);
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
                    'nbr_salle' => $this->post('nbr_salle'),
                    'cout_batiment' => $this->post('cout_batiment'),
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
                $update = $this->Type_batimentManager->update($id, $data);
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
            $delete = $this->Type_batimentManager->delete($id);         
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
