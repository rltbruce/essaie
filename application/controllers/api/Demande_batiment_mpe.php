<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Demande_batiment_mpe extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_batiment_mpe_model', 'Demande_batiment_mpeManager');
        $this->load->model('batiment_construction_model', 'Batiment_constructionManager');
        $this->load->model('tranche_demande_mpe_model', 'Tranche_demande_mpeManager');
        $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        $this->load->model('type_batiment_model', 'Type_batimentManager');
        $this->load->model('facture_mpe_model', 'Facture_mpeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_batiment_construction = $this->get('id_batiment_construction');
        $id_demande_batiment_mpe = $this->get('id_demande_batiment_mpe');
        $id_tranche_demande_mpe = $this->get('id_tranche_demande_mpe');
        $tranche_numero = $this->get('tranche_numero');
        $id_pv_consta_entete_travaux = $this->get('id_pv_consta_entete_travaux');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $menu = $this->get('menu');

        if ($menu=="getdemandeBypv_consta_entete")
        {
            $tmp = $this->Demande_batiment_mpeManager->finddemandeBypv_consta_entete($id_pv_consta_entete_travaux);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($value->id_tranche_demande_mpe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mpe;
                    $data[$key]['id_pv_consta_entete_travaux'] = $value->id_pv_consta_entete_travaux;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandevalideById")
        {
            $tmp = $this->Demande_batiment_mpeManager->getdemandevalideById($id_demande_batiment_mpe);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeByContratTranche")
        {
            $tmp = $this->Demande_batiment_mpeManager->getdemandeByContratTranche($id_tranche_demande_mpe,$id_contrat_prestataire);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeByContratTranchenumero")
        {
            $tmp = $this->Demande_batiment_mpeManager->getdemandeByContratTranchenumero($tranche_numero,$id_contrat_prestataire);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        }
       /* elseif ($menu=="getdemandeBycontrat")
        {
            $tmp = $this->Demande_batiment_mpeManager->finddemandeBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($value->id_tranche_demande_mpe);

                    //$facture_mpe = $this->Facture_mpeManager->findByAttachement_travaux($value->id_attachement_travaux);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['id_attachement_travaux'] = $value->id_attachement_travaux;
                    $data[$key]['tranche_demande_mpe'] = $tranche_demande_mpe;

                }
            } 
                else
                    $data = array();
        }*/

      /*  if ($menu=="getdemandeBycontrat")
        {
            $tmp = $this->Demande_batiment_mpeManager->finddemandeBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($value->id_tranche_demande_mpe);

                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['id_contrat_prestataire'] = $value->id_contrat_prestataire;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandevalidebcafBycontrat")
        {
            $tmp = $this->Demande_batiment_mpeManager->finddemandevalidebcafBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($value->id_tranche_demande_mpe);

                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['id_contrat_prestataire'] = $value->id_contrat_prestataire;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandevalideBycontrat")
        {
            $tmp = $this->Demande_batiment_mpeManager->finddemandevalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($value->id_tranche_demande_mpe);

                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['id_contrat_prestataire'] = $value->id_contrat_prestataire;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeinvalideBycontrat")
        {
            $tmp = $this->Demande_batiment_mpeManager->finddemandeinvalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($value->id_tranche_demande_mpe);

                    //$contrat_prestataire = $this->Contrat_prestataireManager->findById($value->id_contrat_prestataire);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_approbation'] = $value->date_approbation;
                    $data[$key]['id_contrat_prestataire'] = $value->id_contrat_prestataire;

                }
            } 
                else
                    $data = array();
        }*/
        elseif ($id)
        {
            $data = array();
            $demande_batiment_prestataire = $this->Demande_batiment_mpeManager->findById($id);
            $batiment_construction = $this->Batiment_constructionManager->findById($demande_batiment_prestataire->id_batiment_construction);
            $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($demande_batiment_prestataire->id_tranche_demande_mpe);
            $data['id'] = $demande_batiment_prestataire->id;
            $data['montant'] = $demande_batiment_prestataire->montant;
            $data['tranche_demande_mpe'] = $tranche_demande_mpe;
            $data['cumul'] = $demande_batiment_prestataire->cumul;
            $data['anterieur'] = $demande_batiment_prestataire->anterieur;
            $data['reste'] = $demande_batiment_prestataire->reste;
        } 
        else 
        {
            $menu = $this->Demande_batiment_mpeManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $batiment_construction= array();
                    $batiment_construction = $this->Batiment_constructionManager->findById($value->id_batiment_construction);
                    $tranche_demande_mpe = $this->Tranche_demande_mpeManager->findById($value->id_tranche_demande_mpe);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_demande_mpe;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;

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
                    'montant' => $this->post('montant'),
                    'id_tranche_demande_mpe' => $this->post('id_tranche_demande_mpe'),
                    'id_pv_consta_entete_travaux' => $this->post('id_pv_consta_entete_travaux')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Demande_batiment_mpeManager->add($data);
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
                    'montant' => $this->post('montant'),
                    'id_tranche_demande_mpe' => $this->post('id_tranche_demande_mpe'),
                    'id_pv_consta_entete_travaux' => $this->post('id_pv_consta_entete_travaux')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Demande_batiment_mpeManager->update($id, $data);
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
            $delete = $this->Demande_batiment_mpeManager->delete($id);         
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
