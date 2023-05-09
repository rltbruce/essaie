<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Demande_debut_travaux_pr extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_debut_travaux_pr_model', 'Demande_debut_travaux_prManager');
        $this->load->model('contrat_partenaire_relai_model', 'Contrat_partenaire_relaiManager');
        $this->load->model('tranche_d_debut_travaux_pr_model', 'Tranche_d_debut_travaux_prManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_partenaire_relai = $this->get('id_contrat_partenaire_relai');
        $menu = $this->get('menu');

        if ($menu=="getdemandedisponibleBycontrat")
        {
            $tmp = $this->Demande_debut_travaux_prManager->finddemandedisponibleBycontrat($id_contrat_partenaire_relai);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_partenaire_relai= array();
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);
                    $tranche_d_debut_travaux_pr = $this->Tranche_d_debut_travaux_prManager->findById($value->id_tranche_d_debut_travaux_pr);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_d_debut_travaux_pr;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                     $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getalldemandeByContrat")
        {
            $tmp = $this->Demande_debut_travaux_prManager->findAllBycontrat($id_contrat_partenaire_relai);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_partenaire_relai= array();
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);
                    $tranche_d_debut_travaux_pr = $this->Tranche_d_debut_travaux_prManager->findById($value->id_tranche_d_debut_travaux_pr);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_d_debut_travaux_pr;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                     $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;

                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandeByValide")
        {
            $tmp = $this->Demande_debut_travaux_prManager->findAllValide();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_partenaire_relai= array();
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);
                    $tranche_d_debut_travaux_pr = $this->Tranche_d_debut_travaux_prManager->findById($value->id_tranche_d_debut_travaux_pr);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_d_debut_travaux_pr;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;

                }
            } 
                else
                    $data = array();
        }elseif ($menu=="getdemandeByValidedpfi")
        {
            $tmp = $this->Demande_debut_travaux_prManager->findAllValidedpfi();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_partenaire_relai= array();
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);
                    $tranche_d_debut_travaux_pr = $this->Tranche_d_debut_travaux_prManager->findById($value->id_tranche_d_debut_travaux_pr);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_d_debut_travaux_pr;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;

                }
            } 
                else
                    $data = array();
        }elseif ($menu=="getdemandeByValidebcaf")
        {
            $tmp = $this->Demande_debut_travaux_prManager->findAllValidebcaf();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_partenaire_relai= array();
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);
                    $tranche_d_debut_travaux_pr = $this->Tranche_d_debut_travaux_prManager->findById($value->id_tranche_d_debut_travaux_pr);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_d_debut_travaux_pr;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;

                }
            } 
                else
                    $data = array();
        }elseif ($menu=="getdemandeByInvalide")
        {
            $tmp = $this->Demande_debut_travaux_prManager->findAllInvalide();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_partenaire_relai= array();
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);
                    $tranche_d_debut_travaux_pr = $this->Tranche_d_debut_travaux_prManager->findById($value->id_tranche_d_debut_travaux_pr);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_d_debut_travaux_pr;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                     $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;

                }
            } 
                else
                    $data = array();
        }elseif ($menu=="getdemandeByContrat_partenaire_relai")
        {
            $tmp = $this->Demande_debut_travaux_prManager->findAllInvalideBycontrat($id_contrat_partenaire_relai);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $contrat_partenaire_relai= array();
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);
                    $tranche_d_debut_travaux_pr = $this->Tranche_d_debut_travaux_prManager->findById($value->id_tranche_d_debut_travaux_pr);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_d_debut_travaux_pr;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                     $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;

                }
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $demande_debut_travaux_pr = $this->Demande_debut_travaux_prManager->findById($id);
            $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($demande_debut_travaux_pr->id_contrat_partenaire_relai);
            $tranche_d_debut_travaux_pr = $this->Tranche_d_debut_travaux_prManager->findById($demande_debut_travaux_pr->id_tranche_d_debut_travaux_pr);
            $data['id'] = $demande_debut_travaux_pr->id;
            $data['objet'] = $demande_debut_travaux_pr->objet;
            $data['description'] = $demande_debut_travaux_pr->description;
            $data['ref_facture'] = $demande_debut_travaux_pr->ref_facture;
            $data['montant'] = $demande_debut_travaux_pr->montant;
            $data['tranche_d_debut_travaux_pr'] = $tranche_d_debut_travaux_pr;
            $data['cumul'] = $demande_debut_travaux_pr->cumul;
            $data['anterieur'] = $demande_debut_travaux_pr->anterieur;
            $data['reste'] = $demande_debut_travaux_pr->reste;
            $data['date'] = $demande_debut_travaux_pr->date;
            $data['contrat_partenaire_relai'] = $contrat_partenaire_relai;
        } 
        else 
        {
            $menu = $this->Demande_debut_travaux_prManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $contrat_partenaire_relai= array();
                    $contrat_partenaire_relai = $this->Contrat_partenaire_relaiManager->findById($value->id_contrat_partenaire_relai);
                    $tranche_d_debut_travaux_pr = $this->Tranche_d_debut_travaux_prManager->findById($value->id_tranche_d_debut_travaux_pr);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['description'] = $value->description;
                    $data[$key]['ref_facture'] = $value->ref_facture;
                    $data[$key]['montant'] = $value->montant;
                    $data[$key]['tranche'] = $tranche_d_debut_travaux_pr;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                     $data[$key]['validation'] = $value->validation;
                    $data[$key]['contrat_partenaire_relai'] = $contrat_partenaire_relai;

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
                    'objet' => $this->post('objet'),
                    'description' => $this->post('description'),
                    'ref_facture' => $this->post('ref_facture'),
                    'date' => $this->post('date'),
                    'montant' => $this->post('montant'),
                    'id_tranche_d_debut_travaux_pr' => $this->post('id_tranche_d_debut_travaux_pr'),
                    'anterieur' => $this->post('anterieur'),
                    'cumul' => $this->post('cumul'),
                    'reste' => $this->post('reste'),
                    'id_contrat_partenaire_relai' => $this->post('id_contrat_partenaire_relai'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Demande_debut_travaux_prManager->add($data);
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
                    'objet' => $this->post('objet'),
                    'description' => $this->post('description'),
                    'ref_facture' => $this->post('ref_facture'),
                    'montant' => $this->post('montant'),
                    'id_tranche_d_debut_travaux_pr' => $this->post('id_tranche_d_debut_travaux_pr'),
                    'anterieur' => $this->post('anterieur'),
                    'cumul' => $this->post('cumul'),
                    'reste' => $this->post('reste'),
                    'date' => $this->post('date'),
                    'id_contrat_partenaire_relai' => $this->post('id_contrat_partenaire_relai'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Demande_debut_travaux_prManager->update($id, $data);
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
            $delete = $this->Demande_debut_travaux_prManager->delete($id);         
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
