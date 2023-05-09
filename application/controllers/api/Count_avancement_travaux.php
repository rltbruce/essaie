<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Count_avancement_travaux extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('convention_ufp_daaf_entete_model', 'Convention_ufp_daaf_enteteManager');
        $this->load->model('demande_deblocage_daaf_model', 'Demande_deblocage_daafManager');
        $this->load->model('tranche_deblocage_daaf_model', 'Tranche_deblocage_daafManager');
        $this->load->model('demande_deblocage_daaf_syst_model', 'Demande_deblocage_daaf_systManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $invalide = $this->get('invalide');
        $data = array();
            $avancement = $this->Convention_ufp_daaf_enteteManager->avancement_physi_stockconv_ufp_all();

            $demande_deblocage_daaf_syst = $this->Demande_deblocage_daaf_systManager->findAll();
            $tranche_deblocage_daaf_syst = $this->Tranche_deblocage_daafManager->findById($demande_deblocage_daaf_syst[0]->id_tranche_deblocage_daaf);
            $tranche_syst= explode(" ",$tranche_deblocage_daaf_syst->code);
            $numtranche_syst = intval($tranche_syst[1]); 
            if ($avancement)
            {

                foreach ($avancement as $key => $value) 
                {  
                    $avancement_total = $value->avancement_physique;
                    
                    $demande_deblocage_daaf = $this->Demande_deblocage_daafManager->getmax_demande_daafbyconvention($value->id_conv_ufp);
                    if ($demande_deblocage_daaf)
                    {
                        $tranche_deblocage_daaf = $this->Tranche_deblocage_daafManager->findById($demande_deblocage_daaf[0]->id_tranche_deblocage_daaf);

                        $convention_ufp_daaf_entete= $this->Convention_ufp_daaf_enteteManager->findById($value->id_conv_ufp);
                        $convention_cout_feffi= $this->Convention_ufp_daaf_enteteManager->findDetailcoutByConvention($value->id_conv_ufp);
                        /*$data[$key]['id_conv_ufp'] = $value->id_conv_ufp;
                        $data[$key]['avancement_batiment'] = $value->avancement_batiment;
                        $data[$key]['avancement_latrine'] = $value->avancement_latrine;
                        $data[$key]['avancement_mobilier'] = $value->avancement_mobilier;*/

                        /*if ($value->nbr_conv)
                        {
                            $avancement_total = round((($value->avancement_batiment+$value->avancement_latrine+$value->avancement_mobilier)/3)/$value->nbr_conv,4);
                            //$avancement_total = 50;
                            //$avancement_total = round((($value->avancement_batiment+$value->avancement_latrine)/2)/$value->nbr_conv,4);
                        }*/
                        /*$data[$key]['avancement_total'] = $avancement_total;
                        $data[$key]['nbr_conv'] = $value->nbr_conv;
                        $data[$key]['dem'] = $demande_deblocage_daaf[0];
                        $data[$key]['tran'] = $tranche_deblocage_daaf;
                        $data[$key]['numtranche_syst'] = $numtranche_syst;*/

                        $last_tranche_convent = explode(" ",$tranche_deblocage_daaf->code);
                        $num_last_tranche_convent = intval($last_tranche_convent[1]);

                        if (intval($avancement_total)>=50)
                        {
                            if($num_last_tranche_convent == $numtranche_syst-1)
                            {
                                if ($demande_deblocage_daaf[0]->validation ==3)
                                {
                                    
                                    $prevu = (($convention_cout_feffi[0]->cout_batiment+$convention_cout_feffi[0]->cout_latrine+$convention_cout_feffi[0]->cout_mobilier) * $tranche_deblocage_daaf_syst->pourcentage)/100;
                                    $anterieur = $demande_deblocage_daaf[0]->prevu;
                                    $cumul = $demande_deblocage_daaf[0]->cumul + $prevu;
                                    $reste = $convention_ufp_daaf_entete->montant_trans_comm - $cumul;

                                    /*$data[$key]['prevu'] = $prevu;
                                    $data[$key]['anterieur'] = $anterieur;
                                    $data[$key]['cumul'] = $cumul;
                                    $data[$key]['reste'] = $reste;*/
                                    
                                      $a_inserer = array(
                                        'objet' => $demande_deblocage_daaf_syst[0]->objet,
                                        'anterieur' => $anterieur,
                                        'prevu' => $prevu,
                                        'ref_demande' => $demande_deblocage_daaf_syst[0]->ref_demande,
                                        'cumul' => $cumul,
                                        'reste' => $reste,
                                        'date' => date( "Y-m-d"),
                                        'id_tranche_deblocage_daaf' => $demande_deblocage_daaf_syst[0]->id_tranche_deblocage_daaf,                    
                                        'id_convention_ufp_daaf_entete' => $convention_ufp_daaf_entete->id,
                                        'validation' => 0
                                    );
                                    //$data[$key]['dat'] = $a_inserer;
                                   $dataId= $this->Demande_deblocage_daafManager->add($a_inserer);
                                   if (!is_null($dataId)) {
                                        $this->response([
                                            'status' => TRUE,
                                            'response' => $convention_cout_feffi,
                                            'message' => 'Data insert success'
                                                ], REST_Controller::HTTP_OK);
                                    } else {
                                        $this->response([
                                            'status' => FALSE,
                                            'response' => 0,
                                            'message' => 'No request found'
                                                ], REST_Controller::HTTP_BAD_REQUEST);
                                    }
                                }
                            }
                        }
                    
                    }
                    

                    
                }
            }
            //$data = $avancement;
       
    
        
        
    }
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
