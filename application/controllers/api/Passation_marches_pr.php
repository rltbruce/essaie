<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Passation_marches_pr extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('passation_marches_pr_model', 'Passation_marches_prManager');
        $this->load->model('partenaire_relai_model', 'Partenaire_relaiManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_entete = $this->get('id_convention_entete');
        $id_partenaire_relai = $this->get('id_partenaire_relai');
        $id_contrat_partenaire_relai = $this->get('id_contrat_partenaire_relai');
        $id_passation_pr = $this->get('id_passation_pr');
        $menu = $this->get('menu');

         if ($menu=='getdate_contratByconvention')
         {
            $tmp = $this->Passation_marches_prManager->getdate_contratByconvention($id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getpassationByconvention')
         {
            $tmp = $this->Passation_marches_prManager->getpassationByconvention($id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    //$partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                   // $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement_dp'] = $value->date_lancement_dp;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $value->nbr_offre_recu;
                   
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['validation'] = $value->validation;

                    $data[$key]['date_manifestation']   = $value->date_manifestation;

                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                   

                    //$data[$key]['convention_entete'] = $convention_entete;
                   
                        }*/
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getpassationvalideByconvention')
         {
            $tmp = $this->Passation_marches_prManager->getpassationvalideByconvention($id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    //$partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                   // $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement_dp'] = $value->date_lancement_dp;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $value->nbr_offre_recu;
                   
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['validation'] = $value->validation;

                    $data[$key]['date_manifestation']   = $value->date_manifestation;

                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                   

                    //$data[$key]['convention_entete'] = $convention_entete;
                   
                        }*/
            } 
                else
                    $data = array();
        }

        elseif ($menu=='getpassationvalideById')
         {
            $tmp = $this->Passation_marches_prManager->getpassationvalideById($id_passation_pr);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getpassationinvalideByconvention')
         {
            $tmp = $this->Passation_marches_prManager->getpassationinvalideByconvention($id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    //$partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                    //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement_dp'] = $value->date_lancement_dp;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $value->nbr_offre_recu;
                   
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['validation'] = $value->validation;

                    $data[$key]['date_manifestation']   = $value->date_manifestation;

                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                   

                    //$data[$key]['convention_entete'] = $convention_entete;
                   
                        }*/
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getpassationBycontrat_partenaire_relai')
         {
            $tmp = $this->Passation_marches_prManager->findpassationBycontrat_partenaire_relai($id_contrat_partenaire_relai);
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    //$partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement_dp'] = $value->date_lancement_dp;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $value->nbr_offre_recu;
                   
                    $data[$key]['date_os'] = $value->date_os;
                    //$data[$key]['observation'] = $value->observation;

                    $data[$key]['date_manifestation']   = $value->date_manifestation;

                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                   

                    $data[$key]['convention_entete'] = $convention_entete;
                   
                        }*/
            } 
                else
                    $data = array();
        }elseif ($menu=='getpassationBypartenaire_relai')
         {
            $tmp = $this->Passation_marches_prManager->findAllBypartenaire_relai($id_partenaire_relai);
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    //$partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement_dp'] = $value->date_lancement_dp;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $value->nbr_offre_recu;
                   
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['observation'] = $value->observation;

                    $data[$key]['date_manifestation']   = $value->date_manifestation;

                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                   

                    $data[$key]['convention_entete'] = $convention_entete;
                   
                        }*/
            } 
                else
                    $data = array();
        }   
        elseif ($id)
        {
            $data = array();
            $passation_marches_pr = $this->Passation_marches_prManager->findById($id);

            //$partenaire_relai = $this->Partenaire_relaiManager->findById($passation_marches_pr->id_partenaire_relai);
            $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($passation_marches_pr->id_convention_entete);

            $data['id'] = $passation_marches_pr->id;
            $data['date_lancement_dp'] = $passation_marches_pr->date_lancement_dp;
            $data['date_remise']   = $passation_marches_pr->date_remise;
            $data['nbr_offre_recu']    = $passation_marches_pr->nbr_offre_recu;            
            $data['date_os'] = $passation_marches_pr->date_os;          

            $data['date_manifestation']   = $passation_marches_pr->date_manifestation;
            $data['date_signature_contrat']   = $passation_marches_pr->date_signature_contrat;
            

            $data['convention_entete'] = $convention_entete;
            //$data['partenaire_relai'] = $partenaire_relai;
        } 
        else 
        {
            $tmp = $this->Passation_marches_prManager->findAll();
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    //$partenaire_relai = $this->Partenaire_relaiManager->findById($value->id_partenaire_relai);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement_dp'] = $value->date_lancement_dp;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $value->nbr_offre_recu;
                   
                    $data[$key]['date_os'] = $value->date_os;                   

                    $data[$key]['date_manifestation']   = $value->date_manifestation;
                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;                   

                    $data[$key]['convention_entete'] = $convention_entete;
                    //$data[$key]['partenaire_relai'] = $partenaire_relai;
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

        $date_lancement_dp = null;
        $date_remise = null;                    
        $date_os = null;
        $date_manifestation = null;
        $date_signature_contrat = null;

        if ($this->post('date_manifestation')!='' &&$this->post('date_manifestation')!='null' && $this->post('date_manifestation')!='undefined')
        {
            $date_manifestation = $this->post('date_manifestation');
        }

        if ($this->post('date_remise')!='' &&$this->post('date_remise')!='null' && $this->post('date_remise')!='undefined')
        {
            $date_remise = $this->post('date_remise');
        }

        if ($this->post('date_os')!='' &&$this->post('date_os')!='null' && $this->post('date_os')!='undefined')
        {
            $date_os = $this->post('date_os');
        }

        if ($this->post('date_lancement_dp')!='' &&$this->post('date_lancement_dp')!='null' && $this->post('date_lancement_dp')!='undefined')
        {
            $date_lancement_dp = $this->post('date_lancement_dp');
        }

        if ($this->post('date_signature_contrat')!='' &&$this->post('date_signature_contrat')!='null' && $this->post('date_signature_contrat')!='undefined')
        {
            $date_signature_contrat = $this->post('date_signature_contrat');
        }
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                     'id' => $this->post('id'),
                    'date_lancement_dp' => $date_lancement_dp,
                    'date_remise'   => $date_remise,
                    'nbr_offre_recu'    => $this->post('nbr_offre_recu'),                    
                    'date_os' => $date_os,
                    'date_manifestation' => $date_manifestation,
                    'date_signature_contrat' => $date_signature_contrat,
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
                $dataId = $this->Passation_marches_prManager->add($data);
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
                    'date_lancement_dp' => $date_lancement_dp,
                    'date_remise'   => $date_remise,
                    'nbr_offre_recu'    => $this->post('nbr_offre_recu'),                    
                    'date_os' => $date_os,
                    'date_manifestation' => $date_manifestation,
                    'date_signature_contrat' => $date_signature_contrat,
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
                $update = $this->Passation_marches_prManager->update($id, $data);
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
            $delete = $this->Passation_marches_prManager->delete($id);         
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
