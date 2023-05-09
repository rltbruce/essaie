

<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Pv_consta_entete_travaux extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('pv_consta_entete_travaux_model', 'Pv_consta_entete_travauxManager');
        $this->load->model('facture_mpe_model', 'Facture_mpeManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_prestataire = $this->get('id_contrat_prestataire');
        $id_pv_consta_entete_travaux = $this->get('id_pv_consta_entete_travaux');
        $id_facture_mpe = $this->get('id_facture_mpe');
        $menu = $this->get('menu');

        if ($menu=="getrecapBymax_travauxcontrat")
        {
            $tmp = $this->Pv_consta_entete_travauxManager->getrecapBymax_travauxcontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                $data=$tmp[0];           
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getrecapByentete_travauxcontrat")
        {
            $tmp = $this->Pv_consta_entete_travauxManager->getrecapByentete_travauxcontrat($id_pv_consta_entete_travaux,$id_contrat_prestataire);
            if ($tmp) 
            {
                $data=$tmp[0];           
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getpv_consta_factureById")
        {
            $tmp = $this->Pv_consta_entete_travauxManager->getpv_consta_factureById($id_pv_consta_entete_travaux);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {                
                    $facture = $this->Facture_mpeManager->findfacture_mpeBypv_consta_entete($id_pv_consta_entete_travaux);
                    $avance_global = $this->Pv_consta_entete_travauxManager->getanvance_global_contrat($value->id,$value->id_contrat_prestataire);
                    if ($avance_global)
                    {                        
                        $data[$key]['avancement_global_periode'] = $avance_global[0]->periode_cumul;
                        $data[$key]['avancement_global_cumul'] = $avance_global[0]->total_cumul;
                    }
                    $data[$key]['id'] = $value->id;
                    $data[$key]['numero'] = $value->numero;
                    $data[$key]['date_etablissement'] = $value->date_etablissement;
                    $data[$key]['montant_travaux'] = $value->montant_travaux;
                    $data[$key]['id_contrat_prestataire'] = $value->id_contrat_prestataire;
                    $data[$key]['facture'] = $facture;
                }            
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getpv_consta_entete_travauxvalideBycontrat")
        {
            $tmp = $this->Pv_consta_entete_travauxManager->getpv_consta_entete_travauxvalideBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                //$data = $tmp;
                foreach ($tmp as $key => $value)
                {                
                    $facture = $this->Facture_mpeManager->findfacture_mpeBypv_consta_entete($value->id);
                    $avance_global = $this->Pv_consta_entete_travauxManager->getanvance_global_contrat($value->id,$value->id_contrat_prestataire);
                    if ($avance_global)
                    {                        
                        $data[$key]['avancement_global_periode'] = $avance_global[0]->periode_cumul;
                        $data[$key]['avancement_global_cumul'] = $avance_global[0]->total_cumul;
                    }
                    $data[$key]['id'] = $value->id;
                    $data[$key]['numero'] = $value->numero;
                    $data[$key]['date_etablissement'] = $value->date_etablissement;
                    $data[$key]['montant_travaux'] = $value->montant_travaux;
                    $data[$key]['id_contrat_prestataire'] = $value->id_contrat_prestataire;
                    $data[$key]['validation'] = $value->validation_fact;
                    
                    $data[$key]['facture'] = $facture;
                }             
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getpv_consta_entete_travauxBycontrat")
        {
            $tmp = $this->Pv_consta_entete_travauxManager->getpv_consta_entete_travauxBycontrat($id_contrat_prestataire);
            if ($tmp) 
            {
                //$data = $tmp;
                foreach ($tmp as $key => $value)
                {                
                    $facture = $this->Facture_mpeManager->findfacture_mpeBypv_consta_entete($value->id);
                    $avance_global = $this->Pv_consta_entete_travauxManager->getanvance_global_contrat($value->id,$value->id_contrat_prestataire);
                    if ($avance_global)
                    {                        
                        $data[$key]['avancement_global_periode'] = $avance_global[0]->periode_cumul;
                        $data[$key]['avancement_global_cumul'] = $avance_global[0]->total_cumul;
                    }
                    $data[$key]['id'] = $value->id;
                    $data[$key]['numero'] = $value->numero;
                    $data[$key]['date_etablissement'] = $value->date_etablissement;
                    $data[$key]['montant_travaux'] = $value->montant_travaux;
                    $data[$key]['id_contrat_prestataire'] = $value->id_contrat_prestataire;
                    $data[$key]['ato'] = 'atyy';
                    $data[$key]['facture'] = $facture;
                    $data[$key]['validation'] = $value->validation_fact;
                    $data[$key]['validation_fact'] = $value->validation_fact;
                    //$data[$key]['avance_global'] = $avance_global;
                }             
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getpv_consta_entete_travauxvalideById")
        {
            $tmp = $this->Pv_consta_entete_travauxManager->getpv_consta_entete_travauxvalideById($id_pv_consta_entete_travaux);
            if ($tmp) 
            {
                $data = $tmp;            
            } 
                else
                    $data = array();
        }
        elseif ($id)
        {
            $data = array();
            $pv_consta_entete_travaux = $this->Pv_consta_entete_travauxManager->findById($id);
            $data['id'] = $pv_consta_entete_travaux->id;
            $data['numero'] = $pv_consta_entete_travaux->numero;
            $data['date_etablissement'] = $pv_consta_entete_travaux->date_etablissement;
            $data['montant_travaux'] = $pv_consta_entete_travaux->montant_travaux;
            $data['avancement_global_periode'] = $pv_consta_entete_travaux->avancement_global_periode;
            $data['avancement_global_cumul'] = $pv_consta_entete_travaux->avancement_global_cumul;
            $data['id_contrat_prestataire'] = $pv_consta_entete_travaux->id_contrat_prestataire;
        } 
        else 
        {
            $tmp = $this->Pv_consta_entete_travauxManager->findAll();
            if ($tmp) 
            {
                $data=$tmp;
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
                    'numero' => $this->post('numero'),
                    'date_etablissement' => $this->post('date_etablissement'),
                    'montant_travaux' => $this->post('montant_travaux'),
                    'avancement_global_periode' => $this->post('avancement_global_periode'),
                    'avancement_global_cumul' => $this->post('avancement_global_cumul'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Pv_consta_entete_travauxManager->add($data);
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
                    'numero' => $this->post('numero'),
                    'date_etablissement' => $this->post('date_etablissement'),
                    'montant_travaux' => $this->post('montant_travaux'),
                    'avancement_global_periode' => $this->post('avancement_global_periode'),
                    'avancement_global_cumul' => $this->post('avancement_global_cumul'),
                    'id_contrat_prestataire' => $this->post('id_contrat_prestataire')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Pv_consta_entete_travauxManager->update($id, $data);
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
            $delete = $this->Pv_consta_entete_travauxManager->delete($id);         
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
