<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//harizo
// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Excel_export_convention extends REST_Controller
{

    public function __construct() {
        parent::__construct();
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        
    }
   
    public function index_get() 
    {
        $menu = $this->get('menu');
        
        $id_cisco = $this->get('id_cisco');
        $id_ecole = $this->get('id_ecole');
        $id_convention_entete = $this->get('id_convention_entete');
        $date_debut = $this->get('date_debut');
        $date_fin = $this->get('date_fin');
        $lot = $this->get('lot');
        $id_region = $this->get('id_region');
        $id_commune = $this->get('id_commune');
        $id_zap = $this->get('id_zap');
        $repertoire = $this->get('repertoire');

        $data = array() ;


        //*********************************** Nombre echantillon *************************
        
        if ($menu=='getexporter_convention') //mande       
         {
                    
            $tmp = $this->Convention_cisco_feffi_enteteManager->findexporter_convention($this->generer_requete($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap));
            if ($tmp) 
            {
                $data =$tmp;
            } 
            else
                    $data = array();
        }
        
        //********************************* fin Nombre echantillon *****************************
        if (count($data)>0) {
        
        $export=$this->export_excel($repertoire,$data);
            

        } else {
            $this->response([
                'status' => FALSE,
                'response' => array(),
                'message' => 'No data were found'
            ], REST_Controller::HTTP_OK);
        }
    }

   
    public function export_excel($repertoire,$data)
    {
        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/IOFactory.php';      

        $nom_file='convention_export';
        $directoryName = dirname(__FILE__) ."/../../../../../../assets/excel/".$repertoire;
            
            //Check if the directory already exists.
        if(!is_dir($directoryName))
        {
            mkdir($directoryName, 0777,true);
        }
            
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Myexcel")
                    ->setLastModifiedBy("Me")
                    ->setTitle("Convention")
                    ->setSubject("Convention")
                    ->setDescription("Convention")
                    ->setKeywords("Convention")
                    ->setCategory("Convention");

        $ligne=1;            
            // Set Orientation, size and scaling
            // Set Orientation, size and scaling
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
        $objPHPExcel->getActiveSheet()->getPageMargins()->SetLeft(0.64); //***pour marge gauche
        $objPHPExcel->getActiveSheet()->getPageMargins()->SetRight(0.64); //***pour marge droite
        $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
            
        $objPHPExcel->getActiveSheet()->setTitle("Convention");

        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

        $styleGras = array
        (   'borders' => array
            (
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
        'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
            ),
        'font' => array
            (
                'name'  => 'Arial Narrow',
                'bold'  => true,
                'size'  => 12
            ),
        );
        $styleTitre = array
        (

            'borders' => array
            (
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
        'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
            ),
        'font' => array
            (
                'name'  => 'Arial Narrow',
                'bold'  => true,
                'size'  => 8
            ),
        );
        $stylesousTitre = array
        (
            'borders' => array
            (
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            
            'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
            ),
            'font' => array
            (
                'name'  => 'Arial Narrow',
                //'bold'  => true,
                'size'  => 8
            ),
        );
            
        $stylecontenu = array
        (
            'borders' => array
            (
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array
            (
                'name'  => 'Calibri',
                //'bold'  => true,
                'size'  => 10
            )
        );

        $stylepied = array
        (
            'borders' => array
            (
                'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            ),
            
            'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    
            ),
            'font' => array
            (
                    //'name'  => 'Times New Roman',
                'bold'  => true,
                'size'  => 11
            ),
        );

        $ligne++;
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":W".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":W".$ligne)->applyFromArray($styleGras);
        //$objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":B".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "CONVENTION CISCO/FEFFI");

        //GLOBAL
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":W".$ligne)->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'bed4ed')
        )
        ));
        
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(25);
        $ligne++;
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":W".$ligne)->applyFromArray($styleTitre);
        //$objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":B".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "OBJET");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, "CISCO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, "FEFFI");
       // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "SITE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "REFERENCE CONVENTION");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "CÔUT ESTIME MAITRISE D'OEUVRE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "CÔUT ESTIME BLOC DE SALLE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "CÔUT ESTIME BLOC LATRINE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "CÔUT ESTIME MOBILIER");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, "CÔUT ESTIME GESTION SOUS PROJET");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, "CÔUT ESTIME TOTAL");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, "NOMBRE SALLE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, "NOMBRE BOX LATRINE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, "NOMBRE POINT D'EAU");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, "NOMBRE TABLE BANC");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$ligne, "NOMBRE TABLE MAITRE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$ligne, "NOMBRE CHAISE MAITRE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$ligne, "PREVISION NOMBRE BENEFICIAIRE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$ligne, "PREVISION NOMBRE ECOLE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$ligne, "NUMERO COMPTE FEFFI");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$ligne, "ADRESSE BANQUE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$ligne, "NOM BANQUE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$ligne, "DATE SIGNATURE");        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$ligne, "OBSERVATION");

        $ligne++;

        foreach ($data as $key => $value)
        { 

            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($stylecontenu);
            //$objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":B".$ligne)->getAlignment()->setWrapText(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $value->objet);

            $objPHPExcel->getActiveSheet()->getStyle("B".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, $value->nom_cisco);

            $objPHPExcel->getActiveSheet()->getStyle("C".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, $value->nom_feffi);

            $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $value->ref_convention);

            $objPHPExcel->getActiveSheet()->getStyle("E".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $value->cout_maitrise);

            $objPHPExcel->getActiveSheet()->getStyle("F".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $value->cout_batiment);

            $objPHPExcel->getActiveSheet()->getStyle("G".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $value->cout_latrine);

            $objPHPExcel->getActiveSheet()->getStyle("H".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $value->cout_mobilier);

            $objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $value->cout_sousprojet);

            $objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, $value->montant_convention);

            $objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $value->prev_nbr_salle);

            $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, $value->prev_nbr_box_latrine);

            $objPHPExcel->getActiveSheet()->getStyle("M".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, $value->prev_nbr_point_eau);

            $objPHPExcel->getActiveSheet()->getStyle("N".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, $value->prev_nbr_table_banc);

            $objPHPExcel->getActiveSheet()->getStyle("O".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$ligne, $value->prev_nbr_table_maitre);

            $objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$ligne, $value->prev_nbr_chaise_maitre);

            $objPHPExcel->getActiveSheet()->getStyle("Q".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$ligne, $value->prev_beneficiaire);

            $objPHPExcel->getActiveSheet()->getStyle("R".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$ligne, $value->prev_nbr_ecole);

            $objPHPExcel->getActiveSheet()->getStyle("S".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$ligne, $value->numero_compte);

            $objPHPExcel->getActiveSheet()->getStyle("T".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$ligne, $value->adresse_banque);

            $objPHPExcel->getActiveSheet()->getStyle("U".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$ligne, $value->nom_banque);

            $objPHPExcel->getActiveSheet()->getStyle("V".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$ligne, $value->date_signature_convention);

            $objPHPExcel->getActiveSheet()->getStyle("W".$ligne)->applyFromArray($stylecontenu);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$ligne, $value->observation_convention);
            $ligne++;
        }
        
        
    

        try
        {
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save(dirname(__FILE__) . "/../../../../../../assets/excel/export_convention/".$nom_file.".xlsx");
            
            $this->response([
                'status' => TRUE,
                'nom_file' =>$nom_file.".xlsx",
                'data' =>$data,
                'message' => 'Get file success',
            ], REST_Controller::HTTP_OK);
          
        } 
        catch (PHPExcel_Writer_Exception $e)
        {
            $this->response([
                  'status' => FALSE,
                   'nom_file' => $repertoire,
                   'message' => "Something went wrong: ". $e->getMessage(),
                ], REST_Controller::HTTP_OK);
        }

    }

    public function conversion_kg_tonne($val)
    {   
        if ($val > 1000) 
        {
          $res = $val/1000 ;
          $res=number_format(($val/1000),3,","," ");

          return $res." t" ;
        }
        else
        { 
            $res=number_format($val,3,","," ");

            return $res." Kg" ;
        }
    }
    public function generer_requete($date_debut,$date_fin,$id_region,$id_cisco,$id_commune,$id_ecole,$id_convention_entete,$lot,$id_zap)
    {
            $requete = "date_signature BETWEEN '".$date_debut."' AND '".$date_fin."' " ;
        
            

            if (($id_region!='*')&&($id_region!='undefined')&&($id_region!='null')) 
            {
                $requete = $requete." AND region.id='".$id_region."'" ;
            }

            if (($id_cisco!='*')&&($id_cisco!='undefined')&&($id_cisco!='null')) 
            {
                $requete = $requete." AND convention_cisco_feffi_entete.id_cisco='".$id_cisco."'" ;
            }

            if (($id_commune!='*')&&($id_commune!='undefined')&&($id_commune!='null')) 
            {
                $requete = $requete." AND commune.id='".$id_commune."'" ;
            }

            if (($id_ecole!='*')&&($id_ecole!='undefined')&&($id_ecole!='null')) 
            {
                $requete = $requete." AND ecole.id='".$id_ecole."'" ;
            }

            if (($id_convention_entete!='*')&&($id_convention_entete!='undefined')&&($id_convention_entete!='null')) 
            {
                $requete = $requete." AND convention_cisco_feffi_entete.id='".$id_convention_entete."'" ;
            }
            if (($lot!='*')&&($lot!='undefined')&&($lot!='null')) 
            {
                $requete = $requete." AND site.lot='".$lot."'" ;
            }

            if (($id_zap!='*')&&($id_zap!='undefined')&&($id_zap!='null')) 
            {
                $requete = $requete." AND zap.id='".$id_zap."'" ;
            }
            
        return $requete ;
    }    

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
?>