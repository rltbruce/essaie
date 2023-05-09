<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Avenant_prestataire extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('avenant_prestataire_model', 'Avenant_prestataireManager');
        $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_avenant_mpe = $this->get('id_avenant_mpe');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $menu = $this->get('menu');

         if ($menu=='getavenantvalideBycontrat')
         {
            $tmp = $this->Avenant_prestataireManager->findavenantvalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['cout_batiment']    = $value->cout_batiment;
                    $data[$key]['cout_latrine']   = $value->cout_latrine;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['ref_avenant'] = $value->ref_avenant;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['cout_total_ttc'] = $value->cout_mobilier + $value->cout_latrine + $value->cout_batiment;
                    $data[$key]['cout_total_ht'] = ($value->cout_mobilier + $value->cout_latrine + $value->cout_batiment)/1;

                    //$data[$key]['contrat_prestataire'] = $contrat_prestataire;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getavenant_mpevalideById')
         {
            $tmp = $this->Avenant_prestataireManager->findavenantvalideById($id_avenant_mpe);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['cout_batiment']    = $value->cout_batiment;
                    $data[$key]['cout_latrine']   = $value->cout_latrine;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['ref_avenant'] = $value->ref_avenant;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['cout_total_ttc'] = $value->cout_mobilier + $value->cout_latrine + $value->cout_batiment;
                    $data[$key]['cout_total_ht'] = ($value->cout_mobilier + $value->cout_latrine + $value->cout_batiment)/1;

                    //$data[$key]['contrat_prestataire'] = $contrat_prestataire;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getavenantinvalideBycontrat')
         {
            $tmp = $this->Avenant_prestataireManager->findavenantinvalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['cout_batiment']    = $value->cout_batiment;
                    $data[$key]['cout_latrine']   = $value->cout_latrine;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['ref_avenant'] = $value->ref_avenant;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['cout_total_ttc'] = $value->cout_mobilier + $value->cout_latrine + $value->cout_batiment;
                    $data[$key]['cout_total_ht'] = ($value->cout_mobilier + $value->cout_latrine + $value->cout_batiment)/1;

                   // $data[$key]['contrat_prestataire'] = $contrat_prestataire;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getavenantBycontrat')
         {
            $tmp = $this->Avenant_prestataireManager->findavenantBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['cout_batiment']    = $value->cout_batiment;
                    $data[$key]['cout_latrine']   = $value->cout_latrine;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['ref_avenant'] = $value->ref_avenant;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['cout_total_ttc'] = $value->cout_mobilier + $value->cout_latrine + $value->cout_batiment;
                    $data[$key]['cout_total_ht'] = ($value->cout_mobilier + $value->cout_latrine + $value->cout_batiment)/1;

                    //$data[$key]['contrat_prestataire'] = $contrat_prestataire;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getpassationByconvention')
         {
            $tmp = $this->Avenant_prestataireManager->findAllByContrat_prestataire($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['cout_batiment']    = $value->cout_batiment;
                    $data[$key]['cout_latrine']   = $value->cout_latrine;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['cout_total_ttc'] = $value->cout_mobilier + $value->cout_latrine + $value->cout_batiment;
                    $data[$key]['cout_total_ht'] = ($value->cout_mobilier + $value->cout_latrine + $value->cout_batiment)/1;

                    //$data[$key]['contrat_prestataire'] = $contrat_prestataire;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($id)
        {
            $data = array();
            $avenant_prestataire = $this->Avenant_prestataireManager->findById($id);
            //$contrat_prestataire = $this->Contrat_prestataireManager->findById($avenant_prestataire->id_contrat_prestataire);

            $data['id'] = $avenant_prestataire->id;
            $data['description'] = $avenant_prestataire->description;
            $data['cout_batiment']    = $avenant_prestataire->cout_batiment;
            $data['cout_latrine']   = $avenant_prestataire->cout_latrine;
            $data['cout_mobilier'] = $avenant_prestataire->cout_mobilier;
            $data['date_signature'] = $avenant_prestataire->date_signature;
            $data['cout_total_ttc'] = $avenant_prestataire->cout_mobilier + $avenant_prestataire->cout_latrine + $avenant_prestataire->cout_batiment;
            $data['cout_total_ht'] = ($avenant_prestataire->cout_mobilier + $avenant_prestataire->cout_latrine + $avenant_prestataire->cout_batiment)/1;

            //$data['contrat_prestataire'] = $contrat_prestataire;
        } 
        else 
        {
            $tmp = $this->Avenant_prestataireManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$prestataire = $this->PrestataireManager->findById($value->id_prestataire);
                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['cout_batiment']    = $value->cout_batiment;
                    $data[$key]['cout_latrine']   = $value->cout_latrine;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['cout_total_ttc'] = $value->cout_mobilier + $value->cout_latrine + $value->cout_batiment;
                    $data[$key]['cout_total_ht'] = ($value->cout_mobilier + $value->cout_latrine + $value->cout_batiment)/1;
                    
                    //$data[$key]['contrat_prestataire'] = $contrat_prestataire;
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
                    'id' => $this->post('id'),
                    'description' => $this->post('description'),
                    'cout_batiment'    => $this->post('cout_batiment'),
                    'cout_latrine'   => $this->post('cout_latrine'),
                    'cout_mobilier' => $this->post('cout_mobilier'),
                    'date_signature' => $this->post('date_signature'),
                    'ref_avenant' => $this->post('ref_avenant'),
                    'validation' => $this->post('validation'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Avenant_prestataireManager->add($data);
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
                    'id' => $this->post('id'),
                    'description' => $this->post('description'),
                    'cout_batiment'    => $this->post('cout_batiment'),
                    'cout_latrine'   => $this->post('cout_latrine'),
                    'cout_mobilier' => $this->post('cout_mobilier'),
                    'date_signature' => $this->post('date_signature'),
                    'ref_avenant' => $this->post('ref_avenant'),
                    'validation' => $this->post('validation'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Avenant_prestataireManager->update($id, $data);
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
            $delete = $this->Avenant_prestataireManager->delete($id);         
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
