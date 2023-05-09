<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Facture_moe_detail extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('facture_moe_detail_model', 'Facture_moe_detailManager');
        //$this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        //$this->load->model('divers_attachement_batiment_prevu_model', 'Divers_attachement_batiment_prevuManager');
    }

    public function index_get() 
    {
        $id = $this->get('id');
        $id_contrat_bureau_etude = $this->get('id_contrat_bureau_etude');
        $id_facture_moe_entete = $this->get('id_facture_moe_entete');
        $id_facture_detail_moe = $this->get('id_facture_detail_moe');
        $id_sousrubrique = $this->get('id_sousrubrique');
        $code_pai = $this->get('code_pai');
        $menu = $this->get('menu');
        $id_convention_entete = $this->get('id_convention_entete');
        
        if ($menu == "getfacturedetailp5p6supprbyconventionandcode")
        {
            $tmp = $this->Facture_moe_detailManager->getfacturedetailp5p6supprbyconventionandcode($id_convention_entete);
            if ($tmp)
            {
                $data=$tmp;
            }
            else
            {
                $data=array();
            }
        }
        elseif ($menu == "getfacturedetailp5p6byconventionandcode")
        {
            $tmp = $this->Facture_moe_detailManager->getfacturedetailp5p6byconventionandcode($id_convention_entete);
            if ($tmp)
            {
                $data=$tmp;
            }
            else
            {
                $data=array();
            }
        }
        elseif ($menu == "getfacturedetailsupprbyconventionandcode")
        {
            $tmp = $this->Facture_moe_detailManager->getfacturedetailsupprbyconventionandcode($id_convention_entete,$code_pai);
            if ($tmp)
            {
                $data=$tmp;
            }
            else
            {
                $data=array();
            }
        }
        elseif ($menu == "getfacturedetailbyconventionandcode")
        {
            $tmp = $this->Facture_moe_detailManager->getfacturedetailbyconventionandcode($id_convention_entete,$code_pai);
            if ($tmp)
            {
                $data=$tmp;
            }
            else
            {
                $data=array();
            }
        }
        elseif ($menu == "getmontant_anterieur_p9bycontrat")
        {
            $tmp = $this->Facture_moe_detailManager->getmontant_anterieur_p9bycontrat($id_contrat_bureau_etude);
            if ($tmp)
            {
                $data=$tmp;
            }
            else
            {
                $data=array();
            }
        }
        elseif ($menu == "getmontant_anterieur_p8bycontrat")
        {
            $tmp = $this->Facture_moe_detailManager->getmontant_anterieur_p8bycontrat($id_contrat_bureau_etude);
            if ($tmp)
            {
                $data=$tmp;
            }
            else
            {
                $data=array();
            }
        }
        elseif ($menu == "getmontant_anterieurbycontrat")
        {
            $tmp = $this->Facture_moe_detailManager->getmontant_anterieurbycontrat($id_contrat_bureau_etude,$code_pai);
            if ($tmp)
            {
                $data=$tmp;
            }
            else
            {
                $data=array();
            }
        }
        elseif ($menu == "getmontant_anterieurbycontratbyid")
        {
            $tmp = $this->Facture_moe_detailManager->getmontant_anterieurbycontratbyid($id_contrat_bureau_etude,$code_pai,$id_facture_detail_moe);
            if ($tmp)
            {
                $data=$tmp;
            }
            else
            {
                $data=array();
            }
        }
        
        elseif ($menu == "getfacture_moe_detailwithcalendrier_detailbyentete")
        {
            //$tmp = $this->Facture_moe_detailManager->getfacture_moe_detailwithcalendrier_detailbyentete($id_contrat_bureau_etude,$id_facture_moe_entete,$id_sousrubrique);
            $tmp = $this->Facture_moe_detailManager->getcalendrier_detail($id_sousrubrique,$id_contrat_bureau_etude);
            if ($tmp) 
            {   
               foreach ($tmp as $key => $value)
                {   
                    $montant_anterieur = 0;
                    $id = 0;
                    $montant_periode = 0;
                    $observation = null;
                    //$data[$key]['id'] = $value->id;                  
                    $data[$key]['id_sousrubrique_detail'] = $value->id_sousrubrique_detail;                   
                    $data[$key]['libelle'] = $value->libelle;                      
                    $data[$key]['code'] = $value->code;                  
                    $data[$key]['pourcentage'] = $value->pourcentage;                  
                    $data[$key]['libelle'] = $value->libelle;                  
                    $data[$key]['id_calendrier_paie_moe_prevu'] = $value->id_calendrier_paie_moe_prevu;                
                    $data[$key]['montant_prevu_detail'] = $value->montant_prevu; 
                    $data[$key]['montant_prevu'] = $value->montant_prevu;

                    $facture_periode = $this->Facture_moe_detailManager->getfacture_detail_periodebycontrat($id_contrat_bureau_etude,$id_facture_moe_entete,$value->id_sousrubrique_detail);
                   // $montant_prevu_sous_rubrique = $this->Facture_moe_detailManager->getmontant_prevu_sous_rubrique($id_contrat_bureau_etude,$id_sousrubrique);                
                    //$data[$key]['montant_prevu'] = $montant_prevu_sous_rubrique->montant_prevu; 
                    if ($facture_periode)
                    {
                        $id = $facture_periode->id;
                        $montant_periode = $facture_periode->montant_periode;
                        $observation = $facture_periode->observation;
                    }
                    $data[$key]['id'] = $id;
                    $data[$key]['montant_periode'] = $montant_periode;                   
                    $data[$key]['observation'] = $observation;
                    $data[$key]['pourcentage_periode'] = ($montant_periode * $value->pourcentage)/$value->montant_prevu;

                    if ($value->code=='p1') //p1 dao
                    {  
                        $tmp_montant_anterieur = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,$value->code,$id_facture_moe_entete);
                        if($tmp_montant_anterieur)
                        {
                            $montant_anterieur=$tmp_montant_anterieur->montant_periode;
                        }
                    }
                    if ($value->code=='p2') //p1 batiment
                    {  
                        $tmp_montant_anterieur = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,$value->code,$id_facture_moe_entete);
                        if($tmp_montant_anterieur)
                        {
                            $montant_anterieur=$tmp_montant_anterieur->montant_periode;
                        }
                    }

                    if ($value->code=='p3') //p2 batimant
                    {  
                        $montant_p2 = 0;
                        $montant_current_p2 = 0;

                        $montant_p3 = 0;
                      //  if ($id!=0 && $id!=null) 
                       // {                            
                            $montant_anterieurp2 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p2',$id_facture_moe_entete);
                            if ($montant_anterieurp2)
                            {
                                $montant_p2 = $montant_anterieurp2->montant_periode;
                            }
                            $row_currentp2 = $this->Facture_moe_detailManager->getmontant_currentpbycontratcodep($id_contrat_bureau_etude,'p2',$id_facture_moe_entete);
                            if ($row_currentp2)
                            {
                                $montant_current_p2 = $row_currentp2->montant_periode;
                            }


                            $montant_anterieurp3 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p3',$id_facture_moe_entete);
                            if ($montant_anterieurp3)
                            {
                                $montant_p3 = $montant_anterieurp3->montant_periode;
                            }
                        //}
                        $montant_anterieur = $montant_p2 + $montant_current_p2 + $montant_p3;
                        //$data[$key]['ato'] ='ato';
                    }

                    if ($value->code=='p4') //p3 batiment
                    {  
                        $montant_p3 = 0;
                        $montant_current_p3 = 0; 
                        
                        $montant_p2 = 0;
                        $montant_current_p2 = 0;

                        $montant_p4 = 0;
                       // if ($id) 
                      //  { 
                            

                            $montant_anterieurp3 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p3',$id_facture_moe_entete);
                            if ($montant_anterieurp3)
                            {
                                $montant_p3 = $montant_anterieurp3->montant_periode;
                                $montant_anterieurp2 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p2',$id_facture_moe_entete);
                                if ($montant_anterieurp2)
                                {
                                    $montant_p2 = $montant_anterieurp2->montant_periode;
                                }
                                $row_currentp2 = $this->Facture_moe_detailManager->getmontant_currentpbycontratcodep($id_contrat_bureau_etude,'p2',$id_facture_moe_entete);
                                if ($row_currentp2)
                                {
                                    $montant_current_p2 = $row_currentp2->montant_periode;
                                }
                            }
                            $row_currentp3 = $this->Facture_moe_detailManager->getmontant_currentpbycontratcodep($id_contrat_bureau_etude,'p3',$id_facture_moe_entete);
                            if ($row_currentp3)
                            {
                                $montant_current_p3 = $row_currentp3->montant_periode;
                            }

                            $montant_anterieurp4 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p4',$id_facture_moe_entete);
                            if ($montant_anterieurp4)
                            {
                                $montant_p4 = $montant_anterieurp4->montant_periode;
                            }
                       // }
                        $montant_anterieur = $montant_p2 + $montant_current_p2 + $montant_p3 + $montant_current_p3 + $montant_p4;

                    }


                    if ($value->code=='p5') //p1 latrine
                    {  
                        $tmp_montant_anterieur = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,$value->code,$id_facture_moe_entete);
                        if($tmp_montant_anterieur)
                        {
                            $montant_anterieur=$tmp_montant_anterieur->montant_periode;
                        }
                    }

                    if ($value->code=='p6') //p2 latrine
                    {  
                        $montant_p5 = 0;
                        $montant_current_p5 = 0;

                        $montant_p6 = 0;
                       // if ($id) 
                       // { 
                            $montant_anterieurp5 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p5',$id_facture_moe_entete);
                            if ($montant_anterieurp5)
                            {
                                $montant_p5 = $montant_anterieurp2->montant_periode;
                            }
                            $row_currentp5 = $this->Facture_moe_detailManager->getmontant_currentpbycontratcodep($id_contrat_bureau_etude,'p5',$id_facture_moe_entete);
                            if ($row_currentp5)
                            {
                                $montant_current_p5 = $row_currentp5->montant_periode;
                            }


                            $montant_anterieurp6 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p6',$id_facture_moe_entete);
                            if ($montant_anterieurp6)
                            {
                                $montant_p6 = $montant_anterieurp6->montant_periode;
                            }
                       // }
                        $montant_anterieur = $montant_p5 + $montant_current_p5 + $montant_p6;
                        //$data[$key]['ato'] ='ato';
                    }

                    if ($value->code=='p7') // batiment
                    {  
                        $montant_p6 = 0;
                        $montant_current_p6 = 0;
                        
                        $montant_p5 = 0;
                        $montant_current_p5 = 0;

                        $montant_p7 = 0;

                       // if ($id) 
                       // { 
                            

                            $montant_anterieurp6 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p6',$id_facture_moe_entete);
                            if ($montant_anterieurp6)
                            {
                                $montant_p6 = $montant_anterieurp6->montant_periode;
                                $montant_anterieurp5 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p5',$id_facture_moe_entete);
                                if ($montant_anterieurp5)
                                {
                                    $montant_p5 = $montant_anterieurp5->montant_periode;
                                }
                                $row_currentp5 = $this->Facture_moe_detailManager->getmontant_currentpbycontratcodep($id_contrat_bureau_etude,'p5',$id_facture_moe_entete);
                                if ($row_currentp5)
                                {
                                    $montant_current_p5 = $row_currentp5->montant_periode;
                                }
                            }
                            $row_currentp6 = $this->Facture_moe_detailManager->getmontant_currentpbycontratcodep($id_contrat_bureau_etude,'p6',$id_facture_moe_entete);
                            if ($row_currentp6)
                            {
                                $montant_current_p6 = $row_currentp6->montant_periode;
                            }

                            $montant_anterieurp7 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p7',$id_facture_moe_entete);
                            if ($montant_anterieurp7)
                            {
                                $montant_p7 = $montant_anterieurp7->montant_periode;
                            }
                       // }
                        $montant_anterieur =$montant_p5 + $montant_current_p5 + $montant_p6 + $montant_current_p6 + $montant_p7;

                    }


                    if ($value->code=='p8') //p1 RFT
                    {  
                        $tmp_montant_anterieur = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,$value->code,$id_facture_moe_entete);
                        if($tmp_montant_anterieur)
                        {
                            $montant_anterieur=$tmp_montant_anterieur->montant_periode;
                        }
                    }

                    if ($value->code=='p9') //p1 RF
                    {  
                        $tmp_montant_anterieur = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,$value->code,$id_facture_moe_entete);
                        if($tmp_montant_anterieur)
                        {
                            $montant_anterieur=$tmp_montant_anterieur->montant_periode;
                        }
                    }

                    $data[$key]['montant_anterieur'] = $montant_anterieur;
                    $data[$key]['pourcentage_anterieur'] = ($montant_anterieur * $value->pourcentage)/$value->montant_prevu;
                    $data[$key]['montant_cumul'] = $montant_anterieur + $montant_periode;
                    $data[$key]['pourcentage_cumul'] = (($montant_anterieur + $montant_periode) * $value->pourcentage)/$value->montant_prevu;
                }
               // $data=$tmp;
            } 
                else
                    $data = array();
        }
       /* elseif ($menu == "getfacture_moe_detailwithcalendrier_detailbyentete")
        {
            //$tmp = $this->Facture_moe_detailManager->getfacture_moe_detailwithcalendrier_detailbyentete($id_contrat_bureau_etude,$id_facture_moe_entete,$id_sousrubrique);
            $tmp = $this->Facture_moe_detailManager->getcalendrier_detail($id_sousrubrique,$id_contrat_bureau_etude);
            if ($tmp) 
            {   
               foreach ($tmp as $key => $value)
                {   
                    $montant_anterieur = 0;
                    $id = 0;
                    $montant_periode = 0;
                    $observation = null;
                    //$data[$key]['id'] = $value->id;                  
                    $data[$key]['id_sousrubrique_detail'] = $value->id_sousrubrique_detail;                   
                    $data[$key]['libelle'] = $value->libelle;                      
                    $data[$key]['code'] = $value->code;                  
                    $data[$key]['pourcentage'] = $value->pourcentage;                  
                    $data[$key]['libelle'] = $value->libelle;                  
                    $data[$key]['id_calendrier_paie_moe_prevu'] = $value->id_calendrier_paie_moe_prevu;                
                    $data[$key]['montant_prevu_detail'] = $value->montant_prevu; 

                    $facture_periode = $this->Facture_moe_detailManager->getfacture_detail_periodebycontrat($id_contrat_bureau_etude,$id_facture_moe_entete,$value->id_sousrubrique_detail);
                    $montant_prevu_sous_rubrique = $this->Facture_moe_detailManager->getmontant_prevu_sous_rubrique($id_contrat_bureau_etude,$id_sousrubrique);                
                    $data[$key]['montant_prevu'] = $montant_prevu_sous_rubrique->montant_prevu; 
                    if ($facture_periode)
                    {
                        $id = $facture_periode->id;
                        $montant_periode = $facture_periode->montant_periode;
                        $observation = $facture_periode->observation;
                    }
                    $data[$key]['id'] = $id;
                    $data[$key]['montant_periode'] = $montant_periode;                   
                    $data[$key]['observation'] = $observation;
                    $data[$key]['pourcentage_periode'] = ($montant_periode * 100)/$montant_prevu_sous_rubrique->montant_prevu;

                    if ($value->code=='p1') //p1 batiment
                    {  
                        $tmp_montant_anterieur = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,$value->code,$id_facture_moe_entete);
                        if($tmp_montant_anterieur)
                        {
                            $montant_anterieur=$tmp_montant_anterieur->montant_periode;
                        }
                    }
                    if ($value->code=='p2') //p1 batiment
                    {  
                        $tmp_montant_anterieur = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,$value->code,$id_facture_moe_entete);
                        if($tmp_montant_anterieur)
                        {
                            $montant_anterieur=$tmp_montant_anterieur->montant_periode;
                        }
                    }

                    if ($value->code=='p3') //p2 batimant
                    {  
                        $montant_p2 = 0;
                        $montant_current_p2 = 0;

                        $montant_p3 = 0;
                      //  if ($id!=0 && $id!=null) 
                       // {                            
                            $montant_anterieurp2 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p2',$id_facture_moe_entete);
                            if ($montant_anterieurp2)
                            {
                                $montant_p2 = $montant_anterieurp2->montant_periode;
                            }
                            $row_currentp2 = $this->Facture_moe_detailManager->getmontant_currentpbycontratcodep($id_contrat_bureau_etude,'p2',$id_facture_moe_entete);
                            if ($row_currentp2)
                            {
                                $montant_current_p2 = $row_currentp2->montant_periode;
                            }


                            $montant_anterieurp3 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p3',$id_facture_moe_entete);
                            if ($montant_anterieurp3)
                            {
                                $montant_p3 = $montant_anterieurp3->montant_periode;
                            }
                        //}
                        $montant_anterieur = $montant_p2 + $montant_current_p2 + $montant_p3;
                        //$data[$key]['ato'] ='ato';
                    }

                    if ($value->code=='p4') // batiment
                    {  
                        $montant_p3 = 0;
                        $montant_current_p3 = 0;  

                        $montant_p4 = 0;
                       // if ($id) 
                      //  { 
                            $montant_anterieurp3 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p3',$id_facture_moe_entete);
                            if ($montant_anterieurp3)
                            {
                                $montant_p3 = $montant_anterieurp3->montant_periode;
                            }
                            $row_currentp3 = $this->Facture_moe_detailManager->getmontant_currentpbycontratcodep($id_contrat_bureau_etude,'p3',$id_facture_moe_entete);
                            if ($row_currentp3)
                            {
                                $montant_current_p3 = $row_currentp3->montant_periode;
                            }

                            $montant_anterieurp4 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p4',$id_facture_moe_entete);
                            if ($montant_anterieurp4)
                            {
                                $montant_p4 = $montant_anterieurp4->montant_periode;
                            }
                       // }
                        $montant_anterieur = $montant_p3 + $montant_current_p3 + $montant_p4;

                    }


                    if ($value->code=='p5') //p1 latrine
                    {  
                        $tmp_montant_anterieur = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,$value->code,$id_facture_moe_entete);
                        if($tmp_montant_anterieur)
                        {
                            $montant_anterieur=$tmp_montant_anterieur->montant_periode;
                        }
                    }

                    if ($value->code=='p6') //p2 batimant
                    {  
                        $montant_p5 = 0;
                        $montant_current_p5 = 0;

                        $montant_p6 = 0;
                       // if ($id) 
                       // { 
                            $montant_anterieurp5 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p5',$id_facture_moe_entete);
                            if ($montant_anterieurp5)
                            {
                                $montant_p5 = $montant_anterieurp2->montant_periode;
                            }
                            $row_currentp5 = $this->Facture_moe_detailManager->getmontant_currentpbycontratcodep($id_contrat_bureau_etude,'p5',$id_facture_moe_entete);
                            if ($row_currentp5)
                            {
                                $montant_current_p5 = $row_currentp5->montant_periode;
                            }


                            $montant_anterieurp6 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p6',$id_facture_moe_entete);
                            if ($montant_anterieurp6)
                            {
                                $montant_p6 = $montant_anterieurp6->montant_periode;
                            }
                       // }
                        $montant_anterieur = $montant_p5 + $montant_current_p5 + $montant_p6;
                        //$data[$key]['ato'] ='ato';
                    }

                    if ($value->code=='p7') // batiment
                    {  
                        $montant_p6 = 0;
                        $montant_current_p6 = 0;  

                        $montant_p7 = 0;

                       // if ($id) 
                       // { 

                            $montant_anterieurp6 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p6',$id_facture_moe_entete);
                            if ($montant_anterieurp6)
                            {
                                $montant_p6 = $montant_anterieurp6->montant_periode;
                            }
                            $row_currentp6 = $this->Facture_moe_detailManager->getmontant_currentpbycontratcodep($id_contrat_bureau_etude,'p6',$id_facture_moe_entete);
                            if ($row_currentp6)
                            {
                                $montant_current_p6 = $row_currentp6->montant_periode;
                            }

                            $montant_anterieurp7 = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,'p7',$id_facture_moe_entete);
                            if ($montant_anterieurp7)
                            {
                                $montant_p7 = $montant_anterieurp7->montant_periode;
                            }
                       // }
                        $montant_anterieur = $montant_p6 + $montant_current_p6 + $montant_p7;

                    }


                    if ($value->code=='p8') //p1 RFT
                    {  
                        $tmp_montant_anterieur = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,$value->code,$id_facture_moe_entete);
                        if($tmp_montant_anterieur)
                        {
                            $montant_anterieur=$tmp_montant_anterieur->montant_periode;
                        }
                    }

                    if ($value->code=='p9') //p1 RF
                    {  
                        $tmp_montant_anterieur = $this->Facture_moe_detailManager->getmontant_periodepbycontratcodep($id_contrat_bureau_etude,$value->code,$id_facture_moe_entete);
                        if($tmp_montant_anterieur)
                        {
                            $montant_anterieur=$tmp_montant_anterieur->montant_periode;
                        }
                    }

                    $data[$key]['montant_anterieur'] = $montant_anterieur;
                    $data[$key]['pourcentage_anterieur'] = ($montant_anterieur * 100)/$montant_prevu_sous_rubrique->montant_prevu;
                    $data[$key]['montant_cumul'] = $montant_anterieur + $montant_periode;
                    $data[$key]['pourcentage_cumul'] = (($montant_anterieur + $montant_periode) * 100)/$montant_prevu_sous_rubrique->montant_prevu;
                }
               // $data=$tmp;
            } 
                else
                    $data = array();
        }*/
        elseif ($id)
        {
            $data = array();
            $facture_moe_detail = $this->Facture_moe_detailManager->findById($id);
            $data['id'] = $facture_moe_detail->id;
            $data['montant_periode'] = $facture_moe_detail->montant_periode;
            $data['id_calendrier_paie_moe_prevu'] = $facture_moe_detail->id_calendrier_paie_moe_prevu;
            $data['id_facture_moe_entete'] = $facture_moe_detail->id_facture_moe_entete;
            $data['observation'] = $facture_moe_detail->observation;
        } 
        else 
        {
            $tmp = $this->Facture_moe_detailManager->findAll();
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
                    'montant_periode' => $this->post('montant_periode'),
                    'observation' => $this->post('observation'),
                    'id_calendrier_paie_moe_prevu' => $this->post('id_calendrier_paie_moe_prevu'),
                    'id_facture_moe_entete' => $this->post('id_facture_moe_entete')            
              
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Facture_moe_detailManager->add($data);
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
                    'montant_periode' => $this->post('montant_periode'),
                    'observation' => $this->post('observation'),
                    'id_calendrier_paie_moe_prevu' => $this->post('id_calendrier_paie_moe_prevu'),
                    'id_facture_moe_entete' => $this->post('id_facture_moe_entete')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Facture_moe_detailManager->update($id, $data);
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
            $delete = $this->Facture_moe_detailManager->delete($id);         
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
