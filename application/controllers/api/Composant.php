<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Composant extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('composant_model', 'ComposantManager');
        $this->load->model('zone_subvention_model', 'Zone_subventionManager');
        $this->load->model('acces_zone_model', 'Acces_zoneManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_zone_subvention = $this->get('id_zone_subvention');
        $id_acces_zone = $this->get('id_acces_zone');

        if ($menu=="getcomposantByZonesubventionAcces")
        {
            $data = array();
            $composant = $this->ComposantManager->findByAcceszone_zonesubvention($id_acces_zone,$id_zone_subvention);
            if($composant)
            {
               $data['id'] = $composant->id;
                $data['cout_maitrise_oeuvre'] = $composant->cout_maitrise_oeuvre;
                $data['cout_sous_projet'] = $composant->cout_sous_projet; 
            }            
            
        }
        elseif ($id)
        {
            $data = array();
            $composant = $this->ComposantManager->findById($id);
            $zone_subvention = $this->Zone_subventionManager->findById($composant->id_zone_subvention);
            $acces_zone = $this->Acces_zoneManager->findById($composant->id_acces_zone);

            $data['id'] = $composant->id;
            $data['cout_maitrise_oeuvre'] = $composant->cout_maitrise_oeuvre;
            $data['cout_sous_projet'] = $composant->cout_sous_projet;                    
            $data['zone_subvention'] = $zone_subvention;
            $data['acces_zone'] = $acces_zone;
        } 
        else 
        {
            $menu = $this->ComposantManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $data = array();
                    $zone_subvention = $this->Zone_subventionManager->findById($value->id_zone_subvention);
                    $acces_zone = $this->Acces_zoneManager->findById($value->id_acces_zone);

                    $data[$key]['id'] = $value->id;                    
                    $data[$key]['zone_subvention'] = $zone_subvention;
                    $data[$key]['acces_zone'] = $acces_zone;
                    $data[$key]['cout_maitrise_oeuvre'] = $value->cout_maitrise_oeuvre;
                    $data[$key]['cout_sous_projet'] = $value->cout_sous_projet;
                    
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
                    'cout_maitrise_oeuvre' => $this->post('cout_maitrise_oeuvre'),
                    'cout_sous_projet' => $this->post('cout_sous_projet'),
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
                $dataId = $this->ComposantManager->add($data);
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
                    'cout_maitrise_oeuvre' => $this->post('cout_maitrise_oeuvre'),
                    'cout_sous_projet' => $this->post('cout_sous_projet'),
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
                $update = $this->ComposantManager->update($id, $data);
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
            $delete = $this->ComposantManager->delete($id);         
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
