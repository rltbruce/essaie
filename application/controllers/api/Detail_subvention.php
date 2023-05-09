<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Detail_subvention extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('detail_subvention_model', 'Detail_subventionManager');
        $this->load->model('zone_subvention_model', 'Zone_subventionManager');
        $this->load->model('acces_zone_model', 'Acces_zoneManager');
        $this->load->model('detail_ouvrage_model', 'Detail_ouvrageManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
            
        if ($id)
        {
            $data = array();
            $detail_subvention = $this->Detail_subventionManager->findById($id);

            $zone_subvention = $this->Zone_subventionManager->findById($detail_subvention->id_zone_subvention);
            $acces_zone = $this->Acces_zoneManager->findById($detail_subvention->id_acces_zone);
            $detail_ouvrage = $this->Detail_ouvrageManager->findById($detail_subvention->id_detail_ouvrage);

            $data['id'] = $detail_subvention->id;
            $data['cout_maitrise_oeuvre'] = $detail_subvention->cout_maitrise_oeuvre;
            $data['cout_batiment']   = $detail_subvention->cout_batiment;
            $data['cout_latrine']    = $detail_subvention->cout_latrine;
            $data['cout_mobilier']   = $detail_subvention->cout_mobilier;
            $data['cout_sousprojet'] = $detail_subvention->cout_sousprojet;
            $data['acces_zone']      = $acces_zone;
            $data['zone_subvention'] = $zone_subvention;
            $data['detail_ouvrage']  = $detail_ouvrage;
        } 
        else 
        {
            $menu = $this->Detail_subventionManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);
                    $detail_ouvrage = $this->Detail_ouvrageManager->findById($value->id_detail_ouvrage);

                    $data[$key]['id']              = $value->id;
                    $data[$key]['cout_maitrise_oeuvre'] = $value->cout_maitrise_oeuvre;
                    $data[$key]['cout_batiment']   = $value->cout_batiment;
                    $data[$key]['cout_latrine']    = $value->cout_latrine;
                    $data[$key]['cout_mobilier']   = $value->cout_mobilier;
                    $data[$key]['cout_sousprojet'] = $value->cout_sousprojet;
                    $data[$key]['acces_zone']      = $acces_zone;
                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['detail_ouvrage']  = $detail_ouvrage;
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
                    'id_acces_zone'     => $this->post('id_acces_zone'),
                    'id_zone_subvention' => $this->post('id_zone_subvention'),
                    'cout_maitrise_oeuvre' => $this->post('cout_maitrise_oeuvre'),
                    'cout_batiment'     => $this->post('cout_batiment'),
                    'cout_latrine'      => $this->post('cout_latrine'),
                    'cout_mobilier'     => $this->post('cout_mobilier'),
                    'cout_sousprojet'   => $this->post('cout_sousprojet'),
                    'id_detail_ouvrage'   => $this->post('id_detail_ouvrage')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Detail_subventionManager->add($data);
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
                    'id_acces_zone'     => $this->post('id_acces_zone'),
                    'id_zone_subvention' => $this->post('id_zone_subvention'),
                    'cout_maitrise_oeuvre' => $this->post('cout_maitrise_oeuvre'),
                    'cout_batiment'     => $this->post('cout_batiment'),
                    'cout_latrine'      => $this->post('cout_latrine'),
                    'cout_mobilier'     => $this->post('cout_mobilier'),
                    'cout_sousprojet'   => $this->post('cout_sousprojet'),
                    'id_detail_ouvrage'   => $this->post('id_detail_ouvrage')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Detail_subventionManager->update($id, $data);
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
            $delete = $this->Detail_subventionManager->delete($id);         
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


