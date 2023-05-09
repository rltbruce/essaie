<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Contrat_prestataire extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        $this->load->model('prestataire_model', 'PrestataireManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        $this->load->model('facture_mpe_model', 'Facture_mpeManager');
        $this->load->model('passation_marches_model', 'Passation_marchesManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_mpe= $this->get('id_contrat_mpe');
        $id_convention_entete = $this->get('id_convention_entete');
        $menus = $this->get('menus');
        $id_demande_batiment_pre = $this->get('id_demande_batiment_pre');
        $id_demande_latrine_pre = $this->get('id_demande_latrine_pre');
        $id_demande_mobilier_pre = $this->get('id_demande_mobilier_pre');
        $id_cisco = $this->get('id_cisco');
        $id_ecole = $this->get('id_ecole');
         
         if ($menus=='getcontratinvalideByconvention')
         {
            $tmp = $this->Contrat_prestataireManager->findinvalideByConvention($id_convention_entete);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $prestataire = $this->PrestataireManager->findById($value->id_prestataire);
                    $passation = $this->Passation_marchesManager->findpassationarrayByconvention($value->id_convention_entete);

                    $data[$key]['passation'] = $passation;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['num_contrat']   = $value->num_contrat;
                    $data[$key]['cout_batiment']    = $value->cout_batiment;
                    $data[$key]['cout_latrine']   = $value->cout_latrine;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    //$data[$key]['date_signature'] = $value->date_signature;
                    //$data[$key]['date_prev_deb_trav'] = $value->date_prev_deb_trav;
                    //$data[$key]['date_reel_deb_trav'] = $value->date_reel_deb_trav;
                    //$data[$key]['delai_execution'] = $value->delai_execution;
                    //$data[$key]['paiement_recu'] = $value->paiement_recu;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['prestataire'] = $prestataire;
                    $data[$key]['montant_total_ttc'] = $value->cout_mobilier + $value->cout_latrine + $value->cout_batiment;
                    $data[$key]['montant_total_ht'] = ($value->cout_mobilier + $value->cout_latrine + $value->cout_batiment)/1;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menus=='getcontratvalideByconvention')
         {
            $tmp = $this->Contrat_prestataireManager->findvalideByConvention($id_convention_entete);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $prestataire = $this->PrestataireManager->findById($value->id_prestataire);
                    $passation = $this->Passation_marchesManager->findpassationarrayByconvention($value->id_convention_entete);

                    $data[$key]['passation'] = $passation;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['num_contrat']   = $value->num_contrat;
                    $data[$key]['cout_batiment']    = $value->cout_batiment;
                    $data[$key]['cout_latrine']   = $value->cout_latrine;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    //$data[$key]['date_signature'] = $value->date_signature;
                    //$data[$key]['date_prev_deb_trav'] = $value->date_prev_deb_trav;
                    //$data[$key]['date_reel_deb_trav'] = $value->date_reel_deb_trav;
                    //$data[$key]['delai_execution'] = $value->delai_execution;
                    //$data[$key]['paiement_recu'] = $value->paiement_recu;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['prestataire'] = $prestataire;
                    $data[$key]['montant_total_ttc'] = $value->cout_mobilier + $value->cout_latrine + $value->cout_batiment;
                    $data[$key]['montant_total_ht'] = ($value->cout_mobilier + $value->cout_latrine + $value->cout_batiment)/1;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menus=='getcontrat_mpevalideById')
         {
            $tmp = $this->Contrat_prestataireManager->findcontratvalideById($id_contrat_mpe);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $prestataire = $this->PrestataireManager->findById($value->id_prestataire);
                    $passation = $this->Passation_marchesManager->findpassationarrayByconvention($value->id_convention_entete);

                    $data[$key]['passation'] = $passation;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['num_contrat']   = $value->num_contrat;
                    $data[$key]['cout_batiment']    = $value->cout_batiment;
                    $data[$key]['cout_latrine']   = $value->cout_latrine;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    //$data[$key]['date_signature'] = $value->date_signature;
                   // $data[$key]['delai_execution'] = $value->delai_execution;
                   // $data[$key]['paiement_recu'] = $value->paiement_recu;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['prestataire'] = $prestataire;
                    $data[$key]['montant_total_ttc'] = $value->cout_mobilier + $value->cout_latrine + $value->cout_batiment;
                    $data[$key]['montant_total_ht'] = ($value->cout_mobilier + $value->cout_latrine + $value->cout_batiment)/1;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menus=='getetatcontratByconvention')
         {
            $tmp = $this->Contrat_prestataireManager->findvalideByConvention($id_convention_entete);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {   
                    $avancement_financ = 0;
                    $prestataire = $this->PrestataireManager->findById($value->id_prestataire);
                    $montant_facture = $this->Facture_mpeManager->avancement_financiereBycontrat($value->id);
                    if($montant_facture)
                    {
                       $avancement_financ = ($montant_facture[0]->montant_facture_total*100)/($value->cout_batiment + $value->cout_latrine + $value->cout_mobilier); 
                    }

                    $passation = $this->Passation_marchesManager->findpassationarrayByconvention($value->id_convention_entete);

                    $data[$key]['passation'] = $passation;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['num_contrat']   = $value->num_contrat;
                    $data[$key]['cout_batiment']    = $value->cout_batiment;
                    $data[$key]['cout_latrine']   = $value->cout_latrine;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                   // $data[$key]['date_signature'] = $value->date_signature;
                   // $data[$key]['date_prev_deb_trav'] = $montant_facture;
                    //$data[$key]['date_reel_deb_trav'] = $value->date_reel_deb_trav;
                   // $data[$key]['delai_execution'] = $value->delai_execution;
                    $data[$key]['validation'] = $value->validation;
                   // $data[$key]['paiement_recu'] = $value->paiement_recu;
                    $data[$key]['avancement_financ'] = $avancement_financ;
                    $data[$key]['montant_total_ttc'] = $value->cout_mobilier + $value->cout_latrine + $value->cout_batiment;
                    $data[$key]['montant_total_ht'] = ($value->cout_mobilier + $value->cout_latrine + $value->cout_batiment)/1;
                        }
            } 
                else
                    $data = array();
        }
        elseif ($menus=='getcontratByconvention')
         {
            $tmp = $this->Contrat_prestataireManager->findcontratByConvention($id_convention_entete);
            if ($tmp) 
            {  // $data = $tmp;
               
                foreach ($tmp as $key => $value) 
                {
                    $prestataire = $this->PrestataireManager->findById($value->id_prestataire);

                    $passation = $this->Passation_marchesManager->findpassationarrayByconvention($value->id_convention_entete);

                    $data[$key]['passation'] = $passation;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['num_contrat']   = $value->num_contrat;
                    $data[$key]['cout_batiment']    = $value->cout_batiment;
                    $data[$key]['cout_latrine']   = $value->cout_latrine;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    //$data[$key]['date_signature'] = $value->date_signature;
                   // $data[$key]['delai_execution'] = $value->delai_execution;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['paiement_recu'] = $value->paiement_recu;
                    $data[$key]['prestataire'] = $prestataire;
                    $data[$key]['montant_total_ttc'] = $value->cout_mobilier + $value->cout_latrine + $value->cout_batiment;
                    $data[$key]['montant_total_ht'] = ($value->cout_mobilier + $value->cout_latrine + $value->cout_batiment)/1;
                }
            } 
                else
                    $data = array();
        }   
       /* elseif ($menus=='getcontrat_prestataireByecole')
         {
            $menu = $this->Contrat_prestataireManager->findcontrat_prestataireByecole($id_ecole);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $prestataire = $this->PrestataireManager->findById($value->id_prestataire);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['num_contrat']   = $value->num_contrat;
                    $data[$key]['cout_batiment']    = $value->cout_batiment;
                    $data[$key]['cout_latrine']   = $value->cout_latrine;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['date_prev_deb_trav'] = $value->date_prev_deb_trav;
                    $data[$key]['date_reel_deb_trav'] = $value->date_reel_deb_trav;
                    $data[$key]['delai_execution'] = $value->delai_execution;
                    $data[$key]['paiement_recu'] = $value->paiement_recu;
                    $data[$key]['prestataire'] = $prestataire;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($menus=='getcontrat_prestataireBycisco')
         {
            $menu = $this->Contrat_prestataireManager->findcontrat_prestataireBycisco($id_cisco);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $prestataire = $this->PrestataireManager->findById($value->id_prestataire);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['num_contrat']   = $value->num_contrat;
                    $data[$key]['cout_batiment']    = $value->cout_batiment;
                    $data[$key]['cout_latrine']   = $value->cout_latrine;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['date_prev_deb_trav'] = $value->date_prev_deb_trav;
                    $data[$key]['date_reel_deb_trav'] = $value->date_reel_deb_trav;
                    $data[$key]['delai_execution'] = $value->delai_execution;
                    $data[$key]['paiement_recu'] = $value->paiement_recu;
                    $data[$key]['prestataire'] = $prestataire;
                        }
            } 
                else
                    $data = array();
        }   
        elseif ($menus=='getcontratconvenBydemande_mobilier')
         {
            $menu = $this->Contrat_prestataireManager->findcontratconvenBydemande_mobilier($id_demande_mobilier_pre);
            if ($menu) 
            {
                $data=$menu;
            } 
                else
                    $data = array();
        }
        elseif ($menus=='getcontratdemande_latrine')//nisy azy teo alo justifi latrine de esorina ra ts miasa
         {
            $menu = $this->Contrat_prestataireManager->findcontratBydemande_latrine($id_demande_latrine_pre);
            if ($menu) 
            {
                $data=$menu;
            } 
                else
                    $data = array();
        }   
        elseif ($menus=='getcontratconvenBydemande_latrine')//nisy azy teo alo justifi latrine de esorina ra ts miasa
         {
            $menu = $this->Contrat_prestataireManager->findcontratconvenBydemande_latrine($id_demande_latrine_pre);
            if ($menu) 
            {
                $data=$menu;
            } 
                else
                    $data = array();
        }   
        elseif ($menus=='getcontratconvenBydemande_batiment')
         {
            $menu = $this->Contrat_prestataireManager->findcontratconvenBydemande_batiment($id_demande_batiment_pre);
            if ($menu) 
            {
                $data=$menu;
            } 
                else
                    $data = array();
        }   
        elseif ($menus=='getpassationByconvention')
         {
            $menu = $this->Contrat_prestataireManager->findAllByConvention($id_convention_entete);
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $prestataire = $this->PrestataireManager->findById($value->id_prestataire);
                    $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['num_contrat']   = $value->num_contrat;
                    $data[$key]['cout_batiment']    = $value->cout_batiment;
                    $data[$key]['cout_latrine']   = $value->cout_latrine;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    $data[$key]['date_signature'] = $value->date_signature;
                    $data[$key]['date_prev_deb_trav'] = $value->date_prev_deb_trav;
                    $data[$key]['date_reel_deb_trav'] = $value->date_reel_deb_trav;
                    $data[$key]['delai_execution'] = $value->delai_execution;
                    $data[$key]['paiement_recu'] = $value->paiement_recu;

                    $data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['prestataire'] = $prestataire;
                        }
            } 
                else
                    $data = array();
        } */  
        elseif ($id)
        {
            $data = array();
            $contrat_prestataire = $this->Contrat_prestataireManager->findById($id);

            $prestataire = $this->PrestataireManager->findById($contrat_prestataire->id_prestataire);
           // $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($contrat_prestataire->id_convention_entete);
            $passation = $this->Passation_marchesManager->findpassationarrayByconvention($contrat_prestataire->id_convention_entete);

            $data['passation'] = $passation;
            $data['id'] = $contrat_prestataire->id;
            $data['description'] = $contrat_prestataire->description;
            $data['num_contrat']   = $contrat_prestataire->num_contrat;
            $data['cout_batiment']    = $contrat_prestataire->cout_batiment;
            $data['cout_latrine']   = $contrat_prestataire->cout_latrine;
            $data['cout_mobilier'] = $contrat_prestataire->cout_mobilier;
           // $data['date_signature'] = $contrat_prestataire->date_signature;
            //$data['date_prev_deb_trav'] = $contrat_prestataire->date_prev_deb_trav;
            //$data['date_reel_deb_trav'] = $contrat_prestataire->date_reel_deb_trav;
            //$data['delai_execution'] = $contrat_prestataire->delai_execution;
           // $data['paiement'] = $contrat_prestataire->paiement;

            //$data['convention_entete'] = $convention_entete;
            $data['prestataire'] = $prestataire;
            $data['montant_total_ttc'] = $contrat_prestataire->cout_mobilier + $contrat_prestataire->cout_latrine + $contrat_prestataire->cout_batiment;
            $data['montant_total_ht'] = ($contrat_prestataire->cout_mobilier + $contrat_prestataire->cout_latrine + $contrat_prestataire->cout_batiment)/1;
        } 
        else 
        {
            $tmp = $this->Contrat_prestataireManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $prestataire = $this->PrestataireManager->findById($value->id_prestataire);
                   // $convention_entete = $this->Convention_cisco_feffi_enteteManager->findById($value->id_convention_entete);

                    $passation = $this->Passation_marchesManager->findpassationarrayByconvention($value->id_convention_entete);

                    $data[$key]['passation'] = $passation;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['num_contrat']   = $value->num_contrat;
                    $data[$key]['cout_batiment']    = $value->cout_batiment;
                    $data[$key]['cout_latrine']   = $value->cout_latrine;
                    $data[$key]['cout_mobilier'] = $value->cout_mobilier;
                    //$data[$key]['date_signature'] = $value->date_signature;
                    //$data[$key]['date_prev_deb_trav'] = $value->date_prev_deb_trav;
                    //$data[$key]['date_reel_deb_trav'] = $value->date_reel_deb_trav;
                    //$data[$key]['delai_execution'] = $value->delai_execution;
                    //$data[$key]['paiement_recu'] = $value->paiement_recu;

                    //$data[$key]['convention_entete'] = $convention_entete;
                    $data[$key]['prestataire'] = $prestataire;
                    $data[$key]['montant_total_ttc'] = $value->cout_mobilier + $value->cout_latrine + $value->cout_batiment;
                    $data[$key]['montant_total_ht'] = ($value->cout_mobilier + $value->cout_latrine + $value->cout_batiment)/1;
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
                    'num_contrat'   => $this->post('num_contrat'),
                    'cout_batiment'    => $this->post('cout_batiment'),
                    'cout_latrine'   => $this->post('cout_latrine'),
                    'cout_mobilier' => $this->post('cout_mobilier'),
                    //'date_signature' => $this->post('date_signature'),
                    //'date_prev_deb_trav' => $this->post('date_prev_deb_trav'),
                    //'date_reel_deb_trav' => $this->post('date_reel_deb_trav'),
                    //'delai_execution' => $this->post('delai_execution'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'id_prestataire' => $this->post('id_prestataire'),
                    //'paiement_recu' => $this->post('paiement_recu'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Contrat_prestataireManager->add($data);
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
                    'num_contrat'   => $this->post('num_contrat'),
                    'cout_batiment'    => $this->post('cout_batiment'),
                    'cout_latrine'   => $this->post('cout_latrine'),
                    'cout_mobilier' => $this->post('cout_mobilier'),
                    //'date_signature' => $this->post('date_signature'),
                    //'date_prev_deb_trav' => $this->post('date_prev_deb_trav'),
                    //'date_reel_deb_trav' => $this->post('date_reel_deb_trav'),
                    //'delai_execution' => $this->post('delai_execution'),
                    'id_convention_entete' => $this->post('id_convention_entete'),
                    'id_prestataire' => $this->post('id_prestataire'),
                    //'paiement_recu' => $this->post('paiement_recu'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Contrat_prestataireManager->update($id, $data);
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
            $delete = $this->Contrat_prestataireManager->delete($id);         
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
