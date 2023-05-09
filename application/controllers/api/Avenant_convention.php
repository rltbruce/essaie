<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Avenant_convention extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('avenant_convention_model', 'Avenant_conventionManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_entete = $this->get('id_convention_entete');
        $id_document_feffi = $this->get('id_document_feffi');
        $id_avenant_convention = $this->get('id_avenant_convention');
        $menu = $this->get('menu');

         if ($menu=='getavenantByconvention')
         {
            $tmp = $this->Avenant_conventionManager->findavenantByconvention($id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['ref_avenant'] = $value->ref_avenant;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['montant']    = $value->montant;
                    $data[$key]['date_signature']    = $value->date_signature;
                    $data[$key]['validation']    = $value->validation;

                    $data[$key]['convention_entete'] = $convention_entete;
                        }*/
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='getavenantvalideByconvention')
         {
            $tmp = $this->Avenant_conventionManager->findavenantvalideByconvention($id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['ref_avenant'] = $value->ref_avenant;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['montant']    = $value->montant;
                    $data[$key]['date_signature']    = $value->date_signature;
                    $data[$key]['validation']    = $value->validation;

                    $data[$key]['convention_entete'] = $convention_entete;
                        }*/
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getavenant_conventionvalideById')
         {
            $tmp = $this->Avenant_conventionManager->getavenant_conventionvalideById($id_avenant_convention);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getdocumentByconventiondossier_prevu')
         {
            $tmp = $this->Avenant_conventionManager->getdocumentByconventiondossier_prevu($id_document_feffi,$id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }   
        elseif ($menu=='getavenantinvalideByconvention')
         {
            $tmp = $this->Avenant_conventionManager->findavenantinvalideByconvention($id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['ref_avenant'] = $value->ref_avenant;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['montant']    = $value->montant;
                    $data[$key]['date_signature']    = $value->date_signature;
                    $data[$key]['validation']    = $value->validation;

                    $data[$key]['convention_entete'] = $convention_entete;
                        }*/
            } 
                else
                    $data = array();
        }   
        /*elseif ($menu=='getavenantByconvention')
         {
            $tmp = $this->Avenant_conventionManager->findavenantvalideByconvention($id_convention_entete);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['ref_avenant'] = $value->ref_avenant;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['montant']    = $value->montant;
                    $data[$key]['date_signature']    = $value->date_signature;
                    $data[$key]['validation']    = $value->validation;

                    $data[$key]['convention_entete'] = $convention_entete;
                        }
            } 
                else
                    $data = array();
        }  */ 
        elseif ($id)
        {
            $data = array();
            $avenant_convention = $this->Avenant_conventionManager->findById($id);
            //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($avenant_convention->id_contrat_convention);

            $data['id'] = $avenant_convention->id;
            $data['ref_avenant'] = $avenant_convention->ref_avenant;
            $data['description'] = $avenant_convention->description;
            $data['montant']    = $avenant_convention->montant;
            $data['date_signature']    = $avenant_convention->date_signature;
            $data['validation']    = $avenant_convention->validation;

            //$data['convention_entete'] = $convention_entete;
        } 
        else 
        {
            $tmp = $this->Avenant_conventionManager->findAll();
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_contrat_convention);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['ref_avenant'] = $value->ref_avenant;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['montant']    = $value->montant;
                    $data[$key]['date_signature']    = $value->date_signature;
                    $data[$key]['validation']    = $value->validation;

                    $data[$key]['convention_entete'] = $convention_entete;
                        }*/
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
                    'ref_avenant' => $this->post('ref_avenant'),
                    'description' => $this->post('description'),
                    'montant'    => $this->post('montant'),
                    'date_signature'    => $this->post('date_signature'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Avenant_conventionManager->add($data);
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
                    'ref_avenant' => $this->post('ref_avenant'),
                    'description' => $this->post('description'),
                    'montant'    => $this->post('montant'),
                    'date_signature'    => $this->post('date_signature'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Avenant_conventionManager->update($id, $data);
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
            $delete = $this->Avenant_conventionManager->delete($id);         
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
