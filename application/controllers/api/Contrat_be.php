<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Contrat_be extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('contrat_be_model', 'Contrat_beManager');
        $this->load->model('bureau_etude_model', 'Bureau_etudeManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        $this->load->model('demande_batiment_moe_model', 'Demande_batiment_moeManager');
        $this->load->model('passation_marches_be_model', 'Passation_marches_beManager');
        $this->load->model('divers_sousrubrique_calendrier_paie_moe_detail_model', 'Divers_sousrubrique_calendrier_paie_moe_detailManager');
        $this->load->model('divers_calendrier_paie_moe_prevu_model', 'Divers_calendrier_paie_moe_prevuManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_moe = $this->get('id_contrat_moe');
        $id_convention_entete = $this->get('id_convention_entete');
        $id_bureau_etude = $this->get('id_bureau_etude');
        $id_cisco = $this->get('id_cisco');
        $menus = $this->get('menus');

        if ($menus=='getcontratByconvention')
         {
            $menu = $this->Contrat_beManager->findAllByConvention($id_convention_entete);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $passation = $this->Passation_marches_beManager->findpassationarrayByconvention($value->id_convention_entete);

                    $data[$key]['passation'] = $passation;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['bureau_etude'] = $bureau_etude;
                        }
            } 
                else
                    $data = array();
        }
        elseif ($menus=='getetatcontratByconvention')
         {
            $menu = $this->Contrat_beManager->findcontratvalideByConvention($id_convention_entete);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {   $avancement_financ = 0;
                    $bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $montant_facture = $this->Demande_batiment_moeManager->avancement_financiereBycontrat($value->id);
                    if($montant_facture)
                    {
                       $avancement_financ = ($montant_facture[0]->montant_facture_total*100)/$value->montant_contrat; 
                    }
                    $passation = $this->Passation_marches_beManager->findpassationarrayByconvention($value->id_convention_entete);

                    $data[$key]['passation'] = $passation;

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['bureau_etude'] = $bureau_etude;
                    $data[$key]['avancement_financ'] = $avancement_financ ;
                        }
            } 
                else
                    $data = array();
        }
        elseif ($menus=='getcontratvalideByconvention')
         {
            $menu = $this->Contrat_beManager->findcontratvalideByConvention($id_convention_entete);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $passation = $this->Passation_marches_beManager->findpassationarrayByconvention($value->id_convention_entete);

                    $data[$key]['passation'] = $passation;

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['bureau_etude'] = $bureau_etude;
                        }
            } 
                else
                    $data = array();
        }
        elseif ($menus=='getcontratvalideById')
         {
            $menu = $this->Contrat_beManager->findcontratvalideById($id_contrat_moe);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    //$convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $passation = $this->Passation_marches_beManager->findpassationarrayByconvention($value->id_convention_entete);

                    $data[$key]['passation'] = $passation;

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['bureau_etude'] = $bureau_etude;
                        }
            } 
                else
                    $data = array();
        }
        elseif ($menus=='getcontratinvalideByconvention')
        {
            $menu = $this->Contrat_beManager->findcontratinvalideByConvention($id_convention_entete);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $passation = $this->Passation_marches_beManager->findpassationarrayByconvention($value->id_convention_entete);

                    $data[$key]['passation'] = $passation;

                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['bureau_etude'] = $bureau_etude;
                        }
            } 
                else
                    $data = array();
        }     
        elseif ($id)
        {
            $data = array();
            $contrat_be = $this->Contrat_beManager->findById($id);

            $bureau_etude = $this->Bureau_etudeManager->findById($contrat_be->id_bureau_etude);
            $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($contrat_be->id_convention_entete);
            $passation = $this->Passation_marches_beManager->findpassationarrayByconvention($contrat_be->id_convention_entete);

            $data['passation'] = $passation;

            $data['id'] = $contrat_be->id;
            $data['intitule'] = $contrat_be->intitule;
            $data['ref_contrat']   = $contrat_be->ref_contrat;
            $data['montant_contrat']    = $contrat_be->montant_contrat;
            $data['date_signature'] = $contrat_be->date_signature;
            $data['convention_entete'] = $convention_entete;
            $data['bureau_etude'] = $bureau_etude;
        } 
        else 
        {
            $menu = $this->Contrat_beManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $bureau_etude = $this->Bureau_etudeManager->findById($value->id_bureau_etude);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);
                    $passation = $this->Passation_marches_beManager->findpassationarrayByconvention($value->id_convention_entete);

                    $data[$key]['passation'] = $passation;
                    
                    $data[$key]['id'] = $value->id;
                    $data[$key]['intitule'] = $value->intitule;
                    $data[$key]['ref_contrat']   = $value->ref_contrat;
                    $data[$key]['montant_contrat']    = $value->montant_contrat;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['bureau_etude'] = $bureau_etude;
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
                    'id_bureau_etude' => $this->post('id_bureau_etude'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Contrat_beManager->add($data);
                if (!is_null($dataId)) 
                {   
                    $dataId_calendrier = array();
                    $status_calendrier = false;
                    $tmp_calendrier = $this->Divers_sousrubrique_calendrier_paie_moe_detailManager->findAll();
                    foreach ($tmp_calendrier as $key => $value)
                    {
                        
                        $data_calendrier_paie = array(
                            'id' => $this->post('id'),
                            'id_contrat_bureau_etude' => $dataId,
                            'id_sousrubrique_detail' => $value->id,
                            'montant_prevu'    => ($this->post('montant_contrat')*$value->pourcentage)/100
                        );

                        $dataId_calendrier[$key] = $this->Divers_calendrier_paie_moe_prevuManager->add($data_calendrier_paie);
                    }
                    if (count($tmp_calendrier)==count($dataId_calendrier))
                    {
                        $status_calendrier = true;
                    }
                    $this->response([
                        'status' => TRUE,
                        'status_calendrier_paie' => $status_calendrier,
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
                    'id_bureau_etude' => $this->post('id_bureau_etude'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Contrat_beManager->update($id, $data);
                if(!is_null($update)) {

                    $dataId_calendrier = array();
                    $tmp_calendrier_prevu= array();
                    $status_calendrier = false;
                    $tmp_calendrier = $this->Divers_sousrubrique_calendrier_paie_moe_detailManager->findAll();                       
                    foreach ($tmp_calendrier as $key => $value)
                    {   

                    $tmp_calendrier_prevu = $this->Divers_calendrier_paie_moe_prevuManager->finddetailcontrat($id,$value->id); 
                    if (count($tmp_calendrier_prevu)>0) 
                    {
                          $data_calendrier_paie = array(
                                        'id_contrat_bureau_etude' => $id,
                                        'id_sousrubrique_detail' => $value->id,
                                        'montant_prevu'    => ($this->post('montant_contrat')*$value->pourcentage)/100
                                );

                        $dataId_calendrier[$key] = $this->Divers_calendrier_paie_moe_prevuManager->update($id,$value->id,$data_calendrier_paie);
                    }
                    else
                    {
                        $data_calendrier_paie = array(
                                        'id_contrat_bureau_etude' => $id,
                                        'id_sousrubrique_detail' => $value->id,
                                        'montant_prevu'    => ($this->post('montant_contrat')*$value->pourcentage)/100
                                );

                        $dataId_calendrier[$key] = $this->Divers_calendrier_paie_moe_prevuManager->add($data_calendrier_paie);
                    }  
                        
                            
                            
                    }
                    if (count($tmp_calendrier)==count($dataId_calendrier))
                    {
                        $status_calendrier = true;
                    }

                    $this->response([
                        'status' => TRUE,
                        'response' => 1,
                        'status_calendrier_paie' => $status_calendrier,
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
            $delete = $this->Contrat_beManager->delete($id);
            $deletecalendrier = $this->Divers_calendrier_paie_moe_prevuManager->deletebycontrat($id);         
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
