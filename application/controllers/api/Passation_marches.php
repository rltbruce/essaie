<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Passation_marches extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('passation_marches_model', 'Passation_marchesManager');
        $this->load->model('prestataire_model', 'PrestataireManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        $this->load->model('mpe_soumissionaire_model', 'Mpe_soumissionaireManager');
        //$this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_passation_mpe = $this->get('id_passation_mpe');
        $id_convention_entete = $this->get('id_convention_entete');
        $menu = $this->get('menu');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        
        if ($menu=='getdate_contratByconvention')
         {
            $tmp = $this->Passation_marchesManager->getdate_contratByconvention($id_convention_entete);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getpassationvalideByconvention')
         {
            $tmp = $this->Passation_marchesManager->findpassationvalideByconvention($id_convention_entete);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$prestataire = $this->PrestataireManager->findById($value->id_prestataire);
                    //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $countmpe_soumissionaire = $this->Mpe_soumissionaireManager->countAllBympe_soumissionnaire($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement'] = $value->date_lancement;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $countmpe_soumissionaire[0]->nbr;
                    $data[$key]['montant_moin_chere']   = $value->montant_moin_chere;
                    $data[$key]['date_rapport_evaluation'] = $value->date_rapport_evaluation;
                    $data[$key]['date_demande_ano_dpfi'] = $value->date_demande_ano_dpfi;
                    $data[$key]['date_ano_dpfi'] = $value->date_ano_dpfi;
                    $data[$key]['notification_intention']   = $value->notification_intention;
                    $data[$key]['date_notification_attribution']    = $value->date_notification_attribution;
                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation']   = $value->validation;

                    //$data[$key]['convention_entete'] = $convention_entete;
                    //$data[$key]['prestataire'] = $prestataire;
                        }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getpassationvalideById')
         {
            $tmp = $this->Passation_marchesManager->findpassationvalideById($id_passation_mpe);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getpassationinvalideByconvention')
         {
            $tmp = $this->Passation_marchesManager->findpassationinvalideByconvention($id_convention_entete);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$prestataire = $this->PrestataireManager->findById($value->id_prestataire);
                    //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $countmpe_soumissionaire = $this->Mpe_soumissionaireManager->countAllBympe_soumissionnaire($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement'] = $value->date_lancement;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $countmpe_soumissionaire[0]->nbr;
                    $data[$key]['montant_moin_chere']   = $value->montant_moin_chere;
                    $data[$key]['date_rapport_evaluation'] = $value->date_rapport_evaluation;
                    $data[$key]['date_demande_ano_dpfi'] = $value->date_demande_ano_dpfi;
                    $data[$key]['date_ano_dpfi'] = $value->date_ano_dpfi;
                    $data[$key]['notification_intention']   = $value->notification_intention;
                    $data[$key]['date_notification_attribution']    = $value->date_notification_attribution;
                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                    $data[$key]['validation']   = $value->validation;
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['observation'] = $value->observation;

                    //$data[$key]['convention_entete'] = $convention_entete;
                    //$data[$key]['prestataire'] = $prestataire;
                        }
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getpassationByconvention')
         {
            $tmp = $this->Passation_marchesManager->findpassationByconvention($id_convention_entete);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$prestataire = $this->PrestataireManager->findById($value->id_prestataire);
                    //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $countmpe_soumissionaire = $this->Mpe_soumissionaireManager->countAllBympe_soumissionnaire($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement'] = $value->date_lancement;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $countmpe_soumissionaire[0]->nbr;
                    $data[$key]['montant_moin_chere']   = $value->montant_moin_chere;
                    $data[$key]['date_rapport_evaluation'] = $value->date_rapport_evaluation;
                    $data[$key]['date_demande_ano_dpfi'] = $value->date_demande_ano_dpfi;
                    $data[$key]['date_ano_dpfi'] = $value->date_ano_dpfi;
                    $data[$key]['notification_intention']   = $value->notification_intention;
                    $data[$key]['date_notification_attribution']    = $value->date_notification_attribution;
                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['observation'] = $value->observation;
                    $data[$key]['validation']   = $value->validation;

                    //$data[$key]['convention_entete'] = $convention_entete;
                    //$data[$key]['prestataire'] = $prestataire;
                        }
            } 
                else
                    $data = array();
        }  
        elseif ($id)
        {
            $data = array();
            $passation_marches = $this->Passation_marchesManager->findById($id);

            //$prestataire = $this->PrestataireManager->findById($passation_marches->id_prestataire);
            //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($passation_marches->id_convention_entete);
            $countmpe_soumissionaire = $this->Mpe_soumissionaireManager->countAllBympe_soumissionnaire($passation_marches->id);

            $data['id'] = $passation_marches->id;
            $data['date_lancement'] = $passation_marches->date_lancement;
            $data['date_remise']   = $passation_marches->date_remise;
            $data['nbr_offre_recu']    = $countmpe_soumissionaire[0]->nbr;
            $data['montant_moin_chere']   = $passation_marches->montant_moin_chere;
            $data['date_rapport_evaluation'] = $passation_marches->date_rapport_evaluation;
            $data['date_demande_ano_dpfi'] = $passation_marches->date_demande_ano_dpfi;
            $data['date_ano_dpfi'] = $passation_marches->date_ano_dpfi;
            $data['notification_intention']   = $passation_marches->notification_intention;
            $data['date_notification_attribution']    = $passation_marches->date_notification_attribution;
            $data['date_signature_contrat']   = $passation_marches->date_signature_contrat;
            $data['date_os'] = $passation_marches->date_os;
            $data['observation'] = $passation_marches->observation;

            //$data['convention_entete'] = $convention_entete;
            //$data['prestataire'] = $prestataire;
        } 
        else 
        {
            $tmp = $this->Passation_marchesManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$prestataire = $this->PrestataireManager->findById($value->id_prestataire);
                    //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $countmpe_soumissionaire = $this->Mpe_soumissionaireManager->countAllBympe_soumissionnaire($value->id);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_lancement'] = $value->date_lancement;
                    $data[$key]['date_remise']   = $value->date_remise;
                    $data[$key]['nbr_offre_recu']    = $countmpe_soumissionaire[0]->nbr;
                    $data[$key]['montant_moin_chere']   = $value->montant_moin_chere;
                    $data[$key]['date_rapport_evaluation'] = $value->date_rapport_evaluation;
                    $data[$key]['date_demande_ano_dpfi'] = $value->date_demande_ano_dpfi;
                    $data[$key]['date_ano_dpfi'] = $value->date_ano_dpfi;
                    $data[$key]['notification_intention']   = $value->notification_intention;
                    $data[$key]['date_notification_attribution']    = $value->date_notification_attribution;
                    $data[$key]['date_signature_contrat']   = $value->date_signature_contrat;
                    $data[$key]['date_os'] = $value->date_os;
                    $data[$key]['observation'] = $value->observation;

                    //$data[$key]['convention_entete'] = $convention_entete;
                    //$data[$key]['prestataire'] = $prestataire;
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

        $date_lancement = null;
        $date_remise = null;
        $date_rapport_evaluation = null;
        $date_demande_ano_dpfi = null;
        $date_ano_dpfi = null;
        $notification_intention = null;
        $date_notification_attribution = null;
        $date_signature_contrat = null;
        $date_os = null;


        if ($this->post('date_lancement')!='' &&$this->post('date_lancement')!='null' && $this->post('date_lancement')!='undefined')
        {
            $date_lancement = $this->post('date_lancement');
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
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'id' => $this->post('id'),
                    'date_lancement' => $date_lancement,
                    'date_remise'   => $date_remise,
                    'montant_moin_chere'   => $this->post('montant_moin_chere'),
                    'date_rapport_evaluation' => $date_rapport_evaluation,
                    'date_demande_ano_dpfi' => $date_demande_ano_dpfi,
                    'date_ano_dpfi' => $date_ano_dpfi,
                    'notification_intention'   => $notification_intention,
                    'date_notification_attribution'    => $date_notification_attribution,
                    'date_signature_contrat'   => $date_signature_contrat,
                    'date_os' => $date_os,
                    'observation' => $this->post('observation'),
                    'validation' => $this->post('validation'),
                    'id_convention_entete' => $this->post('id_convention_entete')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Passation_marchesManager->add($data);
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
                    'date_lancement' => $date_lancement,
                    'date_remise'   => $date_remise,
                    'montant_moin_chere'   => $this->post('montant_moin_chere'),
                    'date_rapport_evaluation' => $date_rapport_evaluation,
                    'date_demande_ano_dpfi' => $date_demande_ano_dpfi,
                    'date_ano_dpfi' => $date_ano_dpfi,
                    'notification_intention'   => $notification_intention,
                    'date_notification_attribution'    => $date_notification_attribution,
                    'date_signature_contrat'   => $date_signature_contrat,
                    'date_os' => $date_os,
                    'observation' => $this->post('observation'),
                    'validation' => $this->post('validation'),
                    'id_convention_entete' => $this->post('id_convention_entete')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Passation_marchesManager->update($id, $data);
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
            $delete = $this->Passation_marchesManager->delete($id);         
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
