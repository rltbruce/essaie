<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Contrat_partenaire_relai extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('contrat_partenaire_relai_model', 'Contrat_partenaire_relaiManager');
        $this->load->model('partenaire_relai_model', 'Partenaire_relaiManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
    }

    public function index_get() 
    {
        $date=new datetime();
        $date_now=$date->format('Y'); 
        $id = $this->get('id');
        $id_convention_entete = $this->get('id_convention_entete');
        $id_partenaire_relai = $this->get('id_partenaire_relai');
        $validation = $this->get('validation');
        $id_contrat_partenaire = $this->get('id_contrat_partenaire');
        $menus = $this->get('menus');
         
         if ($menus=='getcontratByvalidation')
         {
            $tmp = $this->Contrat_partenaire_relaiManager->findcontratByvalidation($validation);
            if ($tmp) 
            {
                //$data=$tmp;
                foreach ($tmp as $key => $value) 
                {
                    $partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                   //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    //$data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['partenaire_relai'] = $partenaire_relai;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menus=='getcontratvalideByconvention')
        {
            $tmp = $this->Contrat_partenaire_relaiManager->findvalideByConvention($id_convention_entete);
            if ($tmp) 
            {   
                //$data=$tmp;
                foreach ($tmp as $key => $value) 
                {
                    $partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                    //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    //$data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['partenaire_relai'] = $partenaire_relai;
                    $data[$key]['validation'] = $value->validation;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menus=='getcontratvalideById')
        {
            $tmp = $this->Contrat_partenaire_relaiManager->findvalideById($id_contrat_partenaire);
            if ($tmp) 
            {   
                //$data=$tmp;
                foreach ($tmp as $key => $value) 
                {
                    $partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                    //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    //$data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['partenaire_relai'] = $partenaire_relai;
                    $data[$key]['validation'] = $value->validation;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menus=='getcontratByconvention')
        {
            $tmp = $this->Contrat_partenaire_relaiManager->findcontratByConvention($id_convention_entete);
            if ($tmp) 
            {   
                //$data=$tmp;
                foreach ($tmp as $key => $value) 
                {
                    $partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                    //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    //$data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['partenaire_relai'] = $partenaire_relai;
                    $data[$key]['validation'] = $value->validation;
                }
            } 
                else
                    $data = array();
        }   
        elseif ($menus=='getcontratinvalideByconvention')
         {
            $tmp = $this->Contrat_partenaire_relaiManager->findinvalideByConvention($id_convention_entete);
            if ($tmp) 
            {   
                //$data=$tmp;
                foreach ($tmp as $key => $value) 
                {
                    $partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                   // $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    //$data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['partenaire_relai'] = $partenaire_relai;
                    $data[$key]['validation'] = $value->validation;
                }
            } 
                else
                    $data = array();
        } 
       /* elseif ($menus=='getcontratBySanssep')
         {
            $menu = $this->Contrat_partenaire_relaiManager->findContratBySanssep();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                   $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['partenaire_relai'] = $partenaire_relai;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($menus=='getcontratBySanspmc')
         {
            $menu = $this->Contrat_partenaire_relaiManager->findContratBySanspmc();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['partenaire_relai'] = $partenaire_relai;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($menus=='getcontratBySansodc')
         {
            $menu = $this->Contrat_partenaire_relaiManager->findContratBySansodc();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['partenaire_relai'] = $partenaire_relai;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($menus=='getcontratBySansgfpc')
         {
            $menu = $this->Contrat_partenaire_relaiManager->findContratBySansgfpc();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['partenaire_relai'] = $partenaire_relai;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($menus=='getcontratBySansemies')
         {
            $menu = $this->Contrat_partenaire_relaiManager->findContratBySansemies();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                   $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['partenaire_relai'] = $partenaire_relai;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($menus=='getcontratBySansdpp')
         {
            $menu = $this->Contrat_partenaire_relaiManager->findContratBySansdpp();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                   $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['partenaire_relai'] = $partenaire_relai;
                    $data[$key]['validation'] = $value->validation;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($menus=='getcontratBypartenaire_relai')
         {
            $menu = $this->Contrat_partenaire_relaiManager->findAllBypartenaire_relai($id_partenaire_relai);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['partenaire_relai'] = $partenaire_relai;
                    $data[$key]['validation'] = $value->validation;
                        }
            } 
                else
                    $data = array();
        }*/   
        elseif ($id)
        {
            $data = array();
            $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($id);

            $partenaire_relai = $this->Partenaire_relaiManager->findById($contrat_partenaire_relai->id_partenaire_relai);
            $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($contrat_partenaire_relai->id_convention_entete);

            $data['id'] = $contrat_partenaire_relai->id;
            $data['intitule'] = $contrat_partenaire_relai->intitule;
            $data['ref_contrat']   = $contrat_partenaire_relai->ref_contrat;
            $data['montant_contrat']    = $contrat_partenaire_relai->montant_contrat;
            $data['date_signature'] = $contrat_partenaire_relai->date_signature;
            $data['convention_entete'] = $convention_entete;
            $data['partenaire_relai'] = $partenaire_relai;
            $data['validation'] = $contrat_partenaire_relai->validation;
        } 
        else 
        {
            $menu = $this->Contrat_partenaire_relaiManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['partenaire_relai'] = $partenaire_relai;
                    $data[$key]['validation'] = $value->validation;
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
                    'intitule' => $this->post('intitule'),
                    'ref_contrat'   => $this->post('ref_contrat'),
                    'montant_contrat'    => $this->post('montant_contrat'),
                    'date_signature' => $this->post('date_signature'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'id_partenaire_relai' => $this->post('id_partenaire_relai'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Contrat_partenaire_relaiManager->add($data);
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
                    'intitule' => $this->post('intitule'),
                    'ref_contrat'   => $this->post('ref_contrat'),
                    'montant_contrat'    => $this->post('montant_contrat'),
                    'date_signature' => $this->post('date_signature'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'id_partenaire_relai' => $this->post('id_partenaire_relai'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Contrat_partenaire_relaiManager->update($id, $data);
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
            $delete = $this->Contrat_partenaire_relaiManager->delete($id);         
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
