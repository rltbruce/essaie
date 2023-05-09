<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Convention_ufp_daaf_entete extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('convention_ufp_daaf_entete_model', 'Convention_ufp_daaf_enteteManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');       
        $menu = $this->get('menu');
        $validation = $this->get('validation');
        $id_convention_ufp_daaf_entete = $this->get('id_convention_ufp_daaf_entete');       
        $date_today = $this->get('date_today');       
        $annee = $this->get('annee');
        $date_debut = $this->get('date_debut');
        $date_fin = $this->get('date_fin');

        if ($menu=='getconventionBydemandevalidedaaf')
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findconventionBydemandevalidedaaf();
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='getetatconventionByfiltre') //mande
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findetatconventionByfiltre($date_debut,$date_fin);
            if ($tmp) 
            {
                $data=$tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getetatconventionwithpourcenfinancByfiltre')
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findetatconventionwithpourcenfinancByfiltre($date_debut,$date_fin);
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventionByfiltre')
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findconventionByfiltre($this->generer_requete($date_debut,$date_fin));
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        }
        elseif ($menu=='getconventionByfiltre')
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findconventionByfiltre($this->generer_requete($date_debut,$date_fin));
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='getconventionByinvalidedemande')
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findConventionByinvalidedemande();
            if ($tmp) 
            {
                $data = $tmp;
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='conventionmaxBydate')
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findconventionmaxBydate($date_today);
            if ($tmp) 
            {
                $data = $tmp;

            } 
                else
                    $data = array();
        } 
        elseif ($menu=="getindicateurByconvention")
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findindicateurByconvention($id_convention_ufp_daaf_entete);
            if ($tmp) 
            {
                $data = $tmp;
                /*foreach ($tmp as $key => $value) 
                {
                    $data[$key]['nbr_beneficiaire'] = $value->nbr_beneficiaire;
                    $data[$key]['nbr_beneficiaire_prevu'] = $value->nbr_beneficiaire_prevu;
                    $data[$key]['nbr_ecole_construite'] = $value->nbr_ecole_construite;

                    
                }*/
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getDetailcoutByConvention")
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findDetailcoutByConvention($id_convention_ufp_daaf_entete);
            if ($tmp) 
            {
               /* foreach ($tmp as $key => $value) 
                {
                    $data[$key]['montant_trav_mob'] = $value->cout_batiment + $value->cout_latrine + $value->cout_mobilier;
                    $data[$key]['montant_divers'] = $value->cout_divers;
                    
                }*/
                $data=$tmp;
            } 
                else
                    $data = array();
        }
       /* elseif ($menu=="getconventionByfiltre")
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findconventionByfiltre($this->generer_requete($date_debut,$date_fin));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_convention'] = $value->montant_convention;                    
                    $data[$key]['montant_trans_comm'] = $value->montant_trans_comm;
                    $data[$key]['frais_bancaire'] = $value->frais_bancaire;
                    $data[$key]['num_vague'] = $value->num_vague;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['nbr_beneficiaire'] = $value->nbr_beneficiaire;
                    
                }
            } 
                else
                    $data = array();
        }*/
        elseif ($menu=="getconvention_creerinvalideByfiltre")
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findconvention_creerinvalideByfiltre($this->generer_requete_convention_creer($date_debut,$date_fin));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_convention'] = $value->montant_convention;                    
                    $data[$key]['montant_trans_comm'] = $value->montant_trans_comm;
                    $data[$key]['frais_bancaire'] = $value->frais_bancaire;
                    $data[$key]['num_vague'] = $value->num_vague;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['nbr_beneficiaire'] = $value->nbr_beneficiaire;
                    $data[$key]['date_creation'] = $value->date_creation;
                    
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getconvention_invalideByfiltre")
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findconvention_invalideByfiltre($this->generer_requete($date_debut,$date_fin));
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_convention'] = $value->montant_convention;                    
                    $data[$key]['montant_trans_comm'] = $value->montant_trans_comm;
                    $data[$key]['frais_bancaire'] = $value->frais_bancaire;
                    $data[$key]['num_vague'] = $value->num_vague;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['nbr_beneficiaire'] = $value->nbr_beneficiaire;
                    $data[$key]['date_creation'] = $value->date_creation;
                    
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getetatconvention_now") //mande
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findetatConvention_now($annee);
            if ($tmp) 
            {
               $data=$tmp;
                
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getconvention_now")
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findConvention_now($annee);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_convention'] = $value->montant_convention;                    
                    $data[$key]['montant_trans_comm'] = $value->montant_trans_comm;
                    $data[$key]['frais_bancaire'] = $value->frais_bancaire;
                    $data[$key]['num_vague'] = $value->num_vague;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['nbr_beneficiaire'] = $value->nbr_beneficiaire;
                    $data[$key]['date_creation'] = $value->date_creation;
                    
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getconvention_creerinvalide_now")
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findConvention_creerinvalide_now($annee);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_convention'] = $value->montant_convention;                    
                    $data[$key]['montant_trans_comm'] = $value->montant_trans_comm;
                    $data[$key]['frais_bancaire'] = $value->frais_bancaire;
                    $data[$key]['num_vague'] = $value->num_vague;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['nbr_beneficiaire'] = $value->nbr_beneficiaire;
                    $data[$key]['date_creation'] = $value->date_creation;
                    
                }
            } 
                else
                    $data = array();
        }
        elseif ($menu=="getconvention_invalide_now")
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findConvention_invalide_now($annee);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_convention'] = $value->montant_convention;                    
                    $data[$key]['montant_trans_comm'] = $value->montant_trans_comm;
                    $data[$key]['frais_bancaire'] = $value->frais_bancaire;
                    $data[$key]['num_vague'] = $value->num_vague;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['nbr_beneficiaire'] = $value->nbr_beneficiaire;
                    $data[$key]['date_creation'] = $value->date_creation;
                    
                }
            } 
                else
                    $data = array();
        } 
        elseif ($menu=='testconventionByIfvalide') //mande
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findtestconventionByIfvalide($id_convention_ufp_daaf_entete);
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
            $tmp = $this->Convention_ufp_daaf_enteteManager->findByIdObjet($id);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_convention'] = $value->montant_convention;                    
                    $data[$key]['montant_trans_comm'] = $value->montant_trans_comm;
                    $data[$key]['frais_bancaire'] = $value->frais_bancaire;
                    $data[$key]['num_vague'] = $value->num_vague;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['nbr_beneficiaire'] = $value->nbr_beneficiaire;
                    $data[$key]['date_creation'] = $value->date_creation;
                    
                }
            } 
                else
                    $data = array();
        } 
        else 
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value) 
                {
                    $data[$key]['id'] = $value->id;
                    $data[$key]['ref_convention'] = $value->ref_convention;
                    $data[$key]['objet'] = $value->objet;
                    $data[$key]['ref_financement'] = $value->ref_financement;
                    $data[$key]['montant_convention'] = $value->montant_convention;                    
                    $data[$key]['montant_trans_comm'] = $value->montant_trans_comm;
                    $data[$key]['frais_bancaire'] = $value->frais_bancaire;
                    $data[$key]['num_vague'] = $value->num_vague;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['nbr_beneficiaire'] = $value->nbr_beneficiaire;
                    $data[$key]['date_creation'] = $value->date_creation;
                    
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
                    'ref_convention' => $this->post('ref_convention'),
                    'objet' => $this->post('objet'),
                    'montant_convention' => $this->post('montant_convention'),
                    'ref_financement' => $this->post('ref_financement'),
                    'montant_trans_comm' => $this->post('montant_trans_comm'),
                    'frais_bancaire' => $this->post('frais_bancaire'),
                    'num_vague' => $this->post('num_vague'),
                    'nbr_beneficiaire' => $this->post('nbr_beneficiaire'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Convention_ufp_daaf_enteteManager->add($data);
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
                    'ref_convention' => $this->post('ref_convention'),
                    'objet' => $this->post('objet'),
                    'montant_convention' => $this->post('montant_convention'),
                    'ref_financement' => $this->post('ref_financement'),
                    'montant_trans_comm' => $this->post('montant_trans_comm'),
                    'frais_bancaire' => $this->post('frais_bancaire'),
                    'num_vague' => $this->post('num_vague'),
                    'nbr_beneficiaire' => $this->post('nbr_beneficiaire'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Convention_ufp_daaf_enteteManager->update($id, $data);
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
            $delete = $this->Convention_ufp_daaf_enteteManager->delete($id);         
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

    public function generer_requete_convention_creer($date_debut,$date_fin)
    {
            $requete = "date_creation BETWEEN '".$date_debut."' AND '".$date_fin."' " ;
            
        return $requete ;
    }

    public function generer_requete($date_debut,$date_fin)
    {
            $requete = "date_signature BETWEEN '".$date_debut."' AND '".$date_fin."' " ;
            
        return $requete ;
    }
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
