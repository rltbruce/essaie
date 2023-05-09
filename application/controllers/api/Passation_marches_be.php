<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Passation_marches_be extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('passation_marches_be_model', 'Passation_marches_beManager');
        $this->load->model('bureau_etude_model', 'Bureau_etudeManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_passation_moe = $this->get('id_passation_moe');
        $id_convention_entete = $this->get('id_convention_entete');
        $id_bureau_etude = $this->get('id_bureau_etude');
        $id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');
        $menu = $this->get('menu');

        if ($menu=='getdate_contratByconvention')
         {
            $tmp = $this->Passation_marches_beManager->getdate_contratByconvention($id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getpassationByconvention')
         {
            $tmp = $this->Passation_marches_beManager->getpassationByconvention($id_convention_entete);
            if ($tmp) 
            {
               $data=$tmp;
               /* foreach ($tmp as $key => $value) 
                {
                    //$bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement_dp'] = $value->date_lancement_dp;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $value->nbr_offre_recu;
                    $data[$key]['date_rapport_evaluation'] = $value->date_rapport_evaluation;
                    $data[$key]['date_demande_ano_dpfi'] = $value->date_demande_ano_dpfi;
                    $data[$key]['date_ano_dpfi'] = $value->date_ano_dpfi;
                    $data[$key]['notification_intention']   = $value->notification_intention;
                    $data[$key]['date_notification_attribution']    = $value->date_notification_attribution;
                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['observation'] = $value->observation;

                    $data[$key]['date_manifestation']   = $value->date_manifestation;
                    $data[$key]['date_shortlist'] = $value->date_shortlist;
                    $data[$key]['statut'] = $value->statut;
                    $data[$key]['validation'] = $value->validation;

                    $data[$key]['convention_entete'] = $convention_entete;
                        }*/
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getpassationvalideByconvention')
         {
            $tmp = $this->Passation_marches_beManager->getpassationvalideByconvention($id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    //$bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement_dp'] = $value->date_lancement_dp;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $value->nbr_offre_recu;
                    $data[$key]['date_rapport_evaluation'] = $value->date_rapport_evaluation;
                    $data[$key]['date_demande_ano_dpfi'] = $value->date_demande_ano_dpfi;
                    $data[$key]['date_ano_dpfi'] = $value->date_ano_dpfi;
                    $data[$key]['notification_intention']   = $value->notification_intention;
                    $data[$key]['date_notification_attribution']    = $value->date_notification_attribution;
                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['observation'] = $value->observation;

                    $data[$key]['date_manifestation']   = $value->date_manifestation;
                    $data[$key]['date_shortlist'] = $value->date_shortlist;
                    $data[$key]['statut'] = $value->statut;
                    $data[$key]['validation'] = $value->validation;

                    $data[$key]['convention_entete'] = $convention_entete;
                        }*/
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getpassationvalideById')
         {
            $tmp = $this->Passation_marches_beManager->getpassationvalideById($id_passation_moe);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getpassationvalidationByconvention')
         {
            $tmp = $this->Passation_marches_beManager->getpassationvalidationByconvention($id_convention_entete);
            if ($tmp) 
            {
               $data=$tmp;
               /* foreach ($tmp as $key => $value) 
                {
                    //$bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement_dp'] = $value->date_lancement_dp;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $value->nbr_offre_recu;
                    $data[$key]['date_rapport_evaluation'] = $value->date_rapport_evaluation;
                    $data[$key]['date_demande_ano_dpfi'] = $value->date_demande_ano_dpfi;
                    $data[$key]['date_ano_dpfi'] = $value->date_ano_dpfi;
                    $data[$key]['notification_intention']   = $value->notification_intention;
                    $data[$key]['date_notification_attribution']    = $value->date_notification_attribution;
                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['observation'] = $value->observation;

                    $data[$key]['date_manifestation']   = $value->date_manifestation;
                    $data[$key]['date_shortlist'] = $value->date_shortlist;
                    $data[$key]['statut'] = $value->statut;
                    $data[$key]['validation'] = $value->validation;

                    $data[$key]['convention_entete'] = $convention_entete;
                        }*/
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getpassationinvalidationByconvention')
         {
            $tmp = $this->Passation_marches_beManager->getpassationinvalidationByconvention($id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    //$bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement_dp'] = $value->date_lancement_dp;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $value->nbr_offre_recu;
                    $data[$key]['date_rapport_evaluation'] = $value->date_rapport_evaluation;
                    $data[$key]['date_demande_ano_dpfi'] = $value->date_demande_ano_dpfi;
                    $data[$key]['date_ano_dpfi'] = $value->date_ano_dpfi;
                    $data[$key]['notification_intention']   = $value->notification_intention;
                    $data[$key]['date_notification_attribution']    = $value->date_notification_attribution;
                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['observation'] = $value->observation;

                    $data[$key]['date_manifestation']   = $value->date_manifestation;
                    $data[$key]['date_shortlist'] = $value->date_shortlist;
                    $data[$key]['statut'] = $value->statut;
                    $data[$key]['validation'] = $value->validation;

                    $data[$key]['convention_entete'] = $convention_entete;
                        }*/
            } 
                else
                    $data = array();
        }
        /* if ($menu=='getpassationBycontrat_be')
         {
            $tmp = $this->Passation_marches_beManager->findpassationBycontrat_be($id_contrat_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement_dp'] = $value->date_lancement_dp;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $value->nbr_offre_recu;
                    $data[$key]['date_rapport_evaluation'] = $value->date_rapport_evaluation;
                    $data[$key]['date_demande_ano_dpfi'] = $value->date_demande_ano_dpfi;
                    $data[$key]['date_ano_dpfi'] = $value->date_ano_dpfi;
                    $data[$key]['notification_intention']   = $value->notification_intention;
                    $data[$key]['date_notification_attribution']    = $value->date_notification_attribution;
                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['observation'] = $value->observation;

                    $data[$key]['date_manifestation']   = $value->date_manifestation;
                    $data[$key]['date_shortlist'] = $value->date_shortlist;
                    $data[$key]['statut'] = $value->statut;

                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['bato'] = 'ato';
                        }
            } 
                else
                    $data = array();
        } elseif ($menu=='getpassationBybe')
         {
            $tmp= $this->Passation_marches_beManager->findAllBybe($id_bureau_etude);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement_dp'] = $value->date_lancement_dp;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $value->nbr_offre_recu;
                    $data[$key]['date_rapport_evaluation'] = $value->date_rapport_evaluation;
                    $data[$key]['date_demande_ano_dpfi'] = $value->date_demande_ano_dpfi;
                    $data[$key]['date_ano_dpfi'] = $value->date_ano_dpfi;
                    $data[$key]['notification_intention']   = $value->notification_intention;
                    $data[$key]['date_notification_attribution']    = $value->date_notification_attribution;
                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['observation'] = $value->observation;

                    $data[$key]['date_manifestation']   = $value->date_manifestation;
                    $data[$key]['date_shortlist'] = $value->date_shortlist;
                    $data[$key]['statut'] = $value->statut;

                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['bato'] = 'ato';
                        }
            } 
                else
                    $data = array();
        }*/   
        elseif ($id)
        {
            $data = array();
            $passation_marches_be = $this->Passation_marches_beManager->findById($id);

            //$bureau_etude = $this->Bureau_etudeManager->findById($passation_marches_be->id_bureau_etude);
            $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($passation_marches_be->id_convention_entete);

            $data['id'] = $passation_marches_be->id;
            $data['date_lancement_dp'] = $passation_marches_be->date_lancement_dp;
            $data['date_remise']   = $passation_marches_be->date_remise;
            $data['nbr_offre_recu']    = $passation_marches_be->nbr_offre_recu;
            $data['date_rapport_evaluation'] = $passation_marches_be->date_rapport_evaluation;
            $data['date_demande_ano_dpfi'] = $passation_marches_be->date_demande_ano_dpfi;
            $data['date_ano_dpfi'] = $passation_marches_be->date_ano_dpfi;
            $data['notification_intention']   = $passation_marches_be->notification_intention;
            $data['date_notification_attribution']    = $passation_marches_be->date_notification_attribution;
            $data['date_signature_contrat']   = $passation_marches_be->date_signature_contrat;
            $data['date_os'] = $passation_marches_be->date_os;
            $data['observation'] = $passation_marches_be->observation;

            $data['date_manifestation']   = $passation_marches_be->date_manifestation;
            $data['date_shortlist'] = $passation_marches_be->date_shortlist;
            $data['statut'] = $passation_marches_be->statut;

            $data['convention_entete'] = $convention_entete;
            //$data['be'] = $bureau_etude;
        } 
        else 
        {
            $tmp= $this->Passation_marches_beManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement_dp'] = $value->date_lancement_dp;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $value->nbr_offre_recu;
                    $data[$key]['date_rapport_evaluation'] = $value->date_rapport_evaluation;
                    $data[$key]['date_demande_ano_dpfi'] = $value->date_demande_ano_dpfi;
                    $data[$key]['date_ano_dpfi'] = $value->date_ano_dpfi;
                    $data[$key]['notification_intention']   = $value->notification_intention;
                    $data[$key]['date_notification_attribution']    = $value->date_notification_attribution;
                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['observation'] = $value->observation;

                    $data[$key]['date_manifestation']   = $value->date_manifestation;
                    $data[$key]['date_shortlist'] = $value->date_shortlist;
                    $data[$key]['statut'] = $value->statut;

                    $data[$key]['convention_entete'] = $convention_entete;
                    //$data[$key]['be'] = $bureau_etude;
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
        
        $date_lancement_dp = null;
        $date_remise       = null;
        $date_rapport_evaluation    = null;
        $date_demande_ano_dpfi      = null;
        $date_ano_dpfi              =null;
        $notification_intention     =null;
        $date_notification_attribution = null;
        $date_signature_contrat     =null;
        $date_os    =null;
        $date_shortlist =null;
        $date_manifestation =null;

        if ($this->post('date_lancement_dp')!='' &&$this->post('date_lancement_dp')!='null' && $this->post('date_lancement_dp')!='undefined')
        {
            $date_lancement_dp = $this->post('date_lancement_dp');
        }

        if ($this->post('date_remise')!='' &&$this->post('date_remise')!='null' && $this->post('date_remise')!='undefined')
        {
            $date_remise = $this->post('date_remise');
        }

        if ($this->post('date_rapport_evaluation')!='' &&$this->post('date_rapport_evaluation')!='null' && $this->post('date_rapport_evaluation')!='undefined')
        {
            $date_rapport_evaluation = $this->post('date_rapport_evaluation');
        }

        if ($this->post('date_demande_ano_dpfi')!='' &&$this->post('date_demande_ano_dpfi')!='null' && $this->post('date_demande_ano_dpfi')!='undefined')
        {
            $date_demande_ano_dpfi = $this->post('date_demande_ano_dpfi');
        }

        if ($this->post('date_ano_dpfi')!='' &&$this->post('date_ano_dpfi')!='null' && $this->post('date_ano_dpfi')!='undefined')
        {
            $date_ano_dpfi = $this->post('date_ano_dpfi');
        }

        if ($this->post('notification_intention')!='' &&$this->post('notification_intention')!='null' && $this->post('notification_intention')!='undefined')
        {
            $notification_intention = $this->post('notification_intention');
        }

        if ($this->post('date_notification_attribution')!='' &&$this->post('date_notification_attribution')!='null' && $this->post('date_notification_attribution')!='undefined')
        {
            $date_notification_attribution = $this->post('date_notification_attribution');
        }

        if ($this->post('date_signature_contrat')!='' &&$this->post('date_signature_contrat')!='null' && $this->post('date_signature_contrat')!='undefined')
        {
            $date_signature_contrat = $this->post('date_signature_contrat');
        }

        if ($this->post('date_os')!='' &&$this->post('date_os')!='null' && $this->post('date_os')!='undefined')
        {
            $date_os = $this->post('date_os');
        }

        if ($this->post('date_shortlist')!='' &&$this->post('date_shortlist')!='null' && $this->post('date_shortlist')!='undefined')
        {
            $date_shortlist = $this->post('date_shortlist');
        }

        if ($this->post('date_manifestation')!='' &&$this->post('date_manifestation')!='null' && $this->post('date_manifestation')!='undefined')
        {
            $date_manifestation = $this->post('date_manifestation');
        }
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                     'id' => $this->post('id'),
                    'date_lancement_dp' => $date_lancement_dp,
                    'date_remise'   => $date_remise,
                    'nbr_offre_recu'    => $this->post('nbr_offre_recu'),
                    'date_rapport_evaluation' => $date_rapport_evaluation,
                    'date_demande_ano_dpfi' => $date_demande_ano_dpfi,
                    'date_ano_dpfi' => $date_ano_dpfi,
                    'notification_intention'   => $notification_intention,
                    'date_notification_attribution'    => $date_notification_attribution,
                    'date_signature_contrat'   => $date_signature_contrat,
                    'date_os' => $date_os,
                    'observation' => $this->post('observation'),

                    'date_shortlist' => $date_shortlist,
                    'date_manifestation' => $date_manifestation,
                    'statut' => $this->post('statut'),

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
                $dataId = $this->Passation_marches_beManager->add($data);
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
                    'date_rapport_evaluation' => $date_rapport_evaluation,
                    'date_demande_ano_dpfi' => $date_demande_ano_dpfi,
                    'date_ano_dpfi' => $date_ano_dpfi,
                    'notification_intention'   => $notification_intention,
                    'date_notification_attribution'    => $date_notification_attribution,
                    'date_signature_contrat'   => $date_signature_contrat,
                    'date_os' => $date_os,
                    'observation' => $this->post('observation'),

                    'date_shortlist' => $date_shortlist,
                    'date_manifestation' => $date_manifestation,
                    'statut' => $this->post('statut'),

                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'validation' => $this->post('validation'),
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Passation_marches_beManager->update($id, $data);
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
            $delete = $this->Passation_marches_beManager->delete($id);         
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
