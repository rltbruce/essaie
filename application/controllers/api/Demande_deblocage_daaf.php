<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Demande_deblocage_daaf extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demande_deblocage_daaf_model', 'Demande_deblocage_daafManager');
        $this->load->model('convention_ufp_daaf_entete_model', 'Convention_ufp_daaf_enteteManager');
        $this->load->model('convention_ufp_daaf_detail_model', 'Convention_ufp_daaf_detailManager');
        $this->load->model('tranche_deblocage_daaf_model', 'Tranche_deblocage_daafManager');
        $this->load->model('compte_daaf_model', 'Compte_daafManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_convention_ufp_daaf_entete = $this->get('id_convention_ufp_daaf_entete');
        $menu = $this->get('menu');
        $validation = $this->get('validation');
        $annee = $this->get('annee');
        $id_demande_deblocage_daaf = $this->get('id_demande_deblocage_daaf');
        if ($menu=="getdemandeinvalideufp")
        {
            $tmp = $this->Demande_deblocage_daafManager->getdemandeinvalideufp($id_convention_ufp_daaf_entete);
            if ($tmp) 
            {                
                foreach ($tmp as $key => $value) 
                {
                    //$convention_ufpdaaf= array();
                    //$convention_ufp_daaf_entete = $this->Convention_ufp_daaf_enteteManager->findById($value->id_convention_ufp_daaf_entete);
                    $tranche_deblocage_daaf = $this->Tranche_deblocage_daafManager->findById($value->id_tranche_deblocage_daaf);
                    $compte_daaf = $this->Compte_daafManager->findById($value->id_compte_daaf);
                    $data[$key]['compte_daaf'] = $compte_daaf;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_demande'] = $value->ref_demande;
                    $data[$key]['prevu'] = $value->prevu;
                    $data[$key]['tranche'] = $tranche_deblocage_daaf;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['convention_ufp_daaf_entete'] = $convention_ufp_daaf_entete;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getdemandedisponible")
        {
            $tmp = $this->Demande_deblocage_daafManager->findDisponibleByconvention_ufpdaaf($id_convention_ufp_daaf_entete);
            if ($tmp) 
            {                
                foreach ($tmp as $key => $value) 
                {
                    //$convention_ufpdaaf= array();
                    //$convention_ufp_daaf_entete = $this->Convention_ufp_daaf_enteteManager->findById($value->id_convention_ufp_daaf_entete);
                    $tranche_deblocage_daaf = $this->Tranche_deblocage_daafManager->findById($value->id_tranche_deblocage_daaf);
                    $compte_daaf = $this->Compte_daafManager->findById($value->id_compte_daaf);
                    $data[$key]['compte_daaf'] = $compte_daaf;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_demande'] = $value->ref_demande;
                    $data[$key]['prevu'] = $value->prevu;
                    $data[$key]['tranche'] = $tranche_deblocage_daaf;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    //$data[$key]['convention_ufp_daaf_entete'] = $convention_ufp_daaf_entete;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu == 'getdemande_deblocage_daaf')
        {
            $tmp = $this->Demande_deblocage_daafManager->getdemande_deblocage_daaf($id_convention_ufp_daaf_entete);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {                    
                    $tranche_deblocage_daaf = $this->Tranche_deblocage_daafManager->findById($value->id_tranche_deblocage_daaf);
                    $compte_daaf = $this->Compte_daafManager->findById($value->id_compte_daaf);
                    $data[$key]['compte_daaf'] = $compte_daaf;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_demande'] = $value->ref_demande;
                    $data[$key]['prevu'] = $value->prevu;
                    $data[$key]['tranche'] = $tranche_deblocage_daaf;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['id_convention_ufp_daaf_entete'] = $value->id_convention_ufp_daaf_entete;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu == 'getdemande_deblocage_daaf_invalide')
        {
            $tmp = $this->Demande_deblocage_daafManager->getdemande_deblocage_daaf_invalide($validation);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $convention_ufpdaaf= array();
                    $convention_ufp_daaf_entete = $this->Convention_ufp_daaf_enteteManager->findById($value->id_convention_ufp_daaf_entete);
                    $convention_ufp_daaf_detail = $this->Convention_ufp_daaf_detailManager->findByIdligne($value->id_convention_ufp_daaf_entete);
                    $tranche_deblocage_daaf = $this->Tranche_deblocage_daafManager->findById($value->id_tranche_deblocage_daaf);
                    $compte_daaf = $this->Compte_daafManager->findById($value->id_compte_daaf);
                    $data[$key]['compte_daaf'] = $compte_daaf;
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_demande'] = $value->ref_demande;
                    $data[$key]['prevu'] = $value->prevu;
                    $data[$key]['tranche'] = $tranche_deblocage_daaf;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['convention_ufp_daaf_entete'] = $convention_ufp_daaf_entete;
                    $data[$key]['convention_ufp_daaf_detail'] = $convention_ufp_daaf_detail;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu == 'getdemandeByvalidationconvention')
        {
            $tmp = $this->Demande_deblocage_daafManager->finddemandeByvalidationconvention($id_convention_ufp_daaf_entete,$validation);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    //$convention_ufpdaaf= array();
                    //$convention_ufp_daaf_entete = $this->Convention_ufp_daaf_enteteManager->findById($value->id_convention_ufp_daaf_entete);
                    $tranche_deblocage_daaf = $this->Tranche_deblocage_daafManager->findById($value->id_tranche_deblocage_daaf);
                    $compte_daaf = $this->Compte_daafManager->findById($value->id_compte_daaf);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_demande'] = $value->ref_demande;
                    $data[$key]['prevu'] = $value->prevu;
                    $data[$key]['tranche'] = $tranche_deblocage_daaf;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['compte_daaf'] = $compte_daaf;
                    //$data[$key]['convention_ufp_daaf_entete'] = $convention_ufp_daaf_entete;
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu == 'getdemande_deblocageById')
        {
            $tmp = $this->Demande_deblocage_daafManager->getdemande_deblocageById($id_demande_deblocage_daaf);
            if ($tmp) 
            {
                $data=$tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    //$convention_ufpdaaf= array();
                    //$convention_ufp_daaf_entete = $this->Convention_ufp_daaf_enteteManager->findById($value->id_convention_ufp_daaf_entete);
                    $tranche_deblocage_daaf = $this->Tranche_deblocage_daafManager->findById($value->id_tranche_deblocage_daaf);
                    $compte_daaf = $this->Compte_daafManager->findById($value->id_compte_daaf);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_demande'] = $value->ref_demande;
                    $data[$key]['prevu'] = $value->prevu;
                    $data[$key]['tranche'] = $tranche_deblocage_daaf;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['compte_daaf'] = $compte_daaf;
                    //$data[$key]['convention_ufp_daaf_entete'] = $convention_ufp_daaf_entete;
                }*/
            } 
                else
                    $data = array();
        }
       /* elseif ($id_convention_ufp_daaf_entete)
        {
            $tmp = $this->Demande_deblocage_daafManager->findAllByconvention_ufpdaaf($id_convention_ufp_daaf_entete);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $convention_ufpdaaf= array();
                    $convention_ufp_daaf_entete = $this->Convention_ufp_daaf_enteteManager->findById($value->id_convention_ufp_daaf_entete);
                    $tranche_deblocage_daaf = $this->Tranche_deblocage_daafManager->findById($value->id_tranche_deblocage_daaf);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_demande'] = $value->ref_demande;
                    $data[$key]['prevu'] = $value->prevu;
                    $data[$key]['tranche'] = $tranche_deblocage_daaf;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['convention_ufp_daaf_entete'] = $convention_ufp_daaf_entete;
                }
            } 
                else
                    $data = array();
        }*/
        elseif ($id)
        {
            $data = array();
            $demande_deblocage_daaf = $this->Demande_deblocage_daafManager->findById($id);
            $convention_ufp_daaf_entete = $this->Convention_ufp_daaf_enteteManager->findById($demande_deblocage_daaf->id_convention_ufp_daaf_entete);
            $tranche_deblocage_daaf = $this->Tranche_deblocage_daafManager->findById($demande_deblocage_daaf->id_tranche_deblocage_daaf);
            $data['id'] = $demande_deblocage_daaf->id;
            $data['objet'] = $demande_deblocage_daaf->objet;
            $data['ref_demande'] = $demande_deblocage_daaf->ref_demande;
            $data['prevu'] = $demande_deblocage_daaf->prevu;
            $data['tranche_deblocage_daaf'] = $tranche_deblocage_daaf;
            $data['cumul'] = $demande_deblocage_daaf->cumul;
            $data['anterieur'] = $demande_deblocage_daaf->anterieur;
            $data['reste'] = $demande_deblocage_daaf->reste;
            $data['date'] = $demande_deblocage_daaf->date;
            $data['validation'] = $demande_deblocage_daaf->validation;
            $data['convention_ufp_daaf_entete'] = $convention_ufp_daaf_entete;
        } 
        else 
        {
            $menu = $this->Demande_deblocage_daafManager->findAll();
            if ($menu) 
            {
                foreach ($menu as $key => $value) 
                {
                    $convention_ufp_daaf_entete= array();
                    $convention_ufp_daaf_entete = $this->Convention_ufp_daaf_enteteManager->findById($value->id_convention_ufp_daaf_entete);
                    $tranche_deblocage_daaf = $this->Tranche_deblocage_daafManager->findById($value->id_tranche_deblocage_daaf);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_demande'] = $value->ref_demande;
                    $data[$key]['prevu'] = $value->prevu;
                    $data[$key]['tranche'] = $tranche_deblocage_daaf;
                    $data[$key]['cumul'] = $value->cumul;
                    $data[$key]['anterieur'] = $value->anterieur;
                    $data[$key]['reste'] = $value->reste;
                    $data[$key]['date'] = $value->date;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['convention_ufp_daaf_entete'] = $convention_ufp_daaf_entete;

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
                    'anterieur' => $this->post('anterieur'),
                    'prevu' => $this->post('prevu'),
                    'ref_demande' => $this->post('ref_demande'),
                    'cumul' => $this->post('cumul'),
                    'reste' => $this->post('reste'),
                    'date' => $this->post('date'),
                    'id_tranche_deblocage_daaf' => $this->post('id_tranche_deblocage_daaf'),                    
                    'id_convention_ufp_daaf_entete' => $this->post('id_convention_ufp_daaf_entete'),                   
                    'id_compte_daaf' => $this->post('id_compte_daaf'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Demande_deblocage_daafManager->add($data);
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
                    'prevu' => $this->post('prevu'),
                    'ref_demande' => $this->post('ref_demande'),
                    'anterieur' => $this->post('anterieur'),
                    'cumul' => $this->post('cumul'),
                    'reste' => $this->post('reste'),
                    'date' => $this->post('date'),
                    'id_tranche_deblocage_daaf' => $this->post('id_tranche_deblocage_daaf'),                    
                    'id_convention_ufp_daaf_entete' => $this->post('id_convention_ufp_daaf_entete'),                  
                    'id_compte_daaf' => $this->post('id_compte_daaf'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Demande_deblocage_daafManager->update($id, $data);
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
            $delete = $this->Demande_deblocage_daafManager->delete($id);         
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
