<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//harizo
// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Excel_indicateur extends REST_Controller
{

    public function __construct() {
        parent::__construct();        
        $this->load->model('convention_ufp_daaf_entete_model', 'Convention_ufp_daaf_enteteManager');
        
    }
   
    public function index_get() 
    {
        $menu = $this->get('menu');
        $id_convention_entete = $this->get('id_convention_entete');
        $repertoire = $this->get('repertoire');
        $data = array() ;


        //*********************************** Nombre echantillon *************************
        
        if ($menu=="exportindicateurByconvention")
        {
            $tmp = $this->Convention_ufp_daaf_enteteManager->findindicateurByconvention($id_convention_entete);
            if ($tmp) 
            {
                $data = $tmp;
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

        $nom_file='indicateur';
        $directoryName = dirname(__FILE__) ."/../../../../../../assets/excel/".$repertoire;
            
            //Check if the directory already exists.
        if(!is_dir($directoryName))
        {
            mkdir($directoryName, 0777,true);
        }
            
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Myexcel")
                    ->setLastModifiedBy("Me")
                    ->setTitle("suivi FEFFI")
                    ->setSubject("suivi FEFFI")
                    ->setDescription("suivi FEFFI")
                    ->setKeywords("suivi FEFFI")
                    ->setCategory("suivi FEFFI");

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

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);

       
           
       /* $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
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
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);*/
            
        $objPHPExcel->getActiveSheet()->setTitle("suivi FEFFI");

        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&11&B Page &P / &N');
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R&11&B Page &P / &N');

        $styleGras = array
        (
        'alignment' => array
            (
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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
                'size'  => 8,
                //'color' => array('rgb' => '00ffee'),
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

        $ligne++;
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":B".$ligne)->applyFromArray($styleGras);
        //$objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":B".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "PROJET D'APPUI A L'EDUCATION DE BASE (PAEB)");

        $ligne++;
        //$objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($styleGras);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "TABLEAU DE SUIVI ");

        $ligne=$ligne+2;
        $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":Q".$ligne);
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":Q".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":Q".$ligne)->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '4f81bd')
        )
    ));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "INDICATEURS");

        $ligne++;
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":Q".$ligne)->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, "Prevision nombre de salles de classe construites");

        $objPHPExcel->getActiveSheet()->getStyle("B".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, "Nombre de salles de classe construites");
        
        $objPHPExcel->getActiveSheet()->getStyle("C".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, "Prevision Bénéficiaires directs du programme deconstruction (nombre)");

        $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, "Bénéficiaires directs du programme de construction (nombre)");

        $objPHPExcel->getActiveSheet()->getStyle("E".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, "Prevision Nombre d'Ecoles construites");

        $objPHPExcel->getActiveSheet()->getStyle("F".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, "Nombre d'Ecoles construites");

        $objPHPExcel->getActiveSheet()->getStyle("G".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, "Prévision nombre de box de latrine");

        $objPHPExcel->getActiveSheet()->getStyle("H".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, "Réalisation box de latrine");

        $objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, "Prevision Nombre de systèmes de point d'Eau installé");

        $objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, "Nombre de système de point d'eau  installé");

        $objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, "PREVISION NOMBRE TABLES BANC");

        $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, "REALISATION NOMBRE TABLES BANC");

        $objPHPExcel->getActiveSheet()->getStyle("M".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, "PREVISION NOMBRE TABLES DU MAITRE ");

        $objPHPExcel->getActiveSheet()->getStyle("N".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, "REALISATION NOMBRE TABLES DU MAITRE");

        $objPHPExcel->getActiveSheet()->getStyle("O".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$ligne, "PREVISION NOMBRE CHAISE DU MAITRE");

        $objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$ligne, "REALISATION NOMBRE CHAISE DU MAITRE");

        $objPHPExcel->getActiveSheet()->getStyle("Q".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$ligne, "OBSERVATIONS SUR LES INDICATEURS");
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":Q".$ligne)->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'dce6f1')
        )
    ));

        $ligne++;
        $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne, $data[0]->nbr_salle_prevu);

        $objPHPExcel->getActiveSheet()->getStyle("B".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$ligne, $data[0]->nbr_salle_construite);
        
        $objPHPExcel->getActiveSheet()->getStyle("C".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$ligne, $data[0]->nbr_beneficiaire_prevu);

        $objPHPExcel->getActiveSheet()->getStyle("D".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$ligne, $data[0]->nbr_beneficiaire);

        $objPHPExcel->getActiveSheet()->getStyle("E".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$ligne, $data[0]->nbr_beneficiaire);

        $objPHPExcel->getActiveSheet()->getStyle("F".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$ligne, $data[0]->nbr_ecole_construite);

        $objPHPExcel->getActiveSheet()->getStyle("G".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$ligne, $data[0]->nbr_box_latrine_prevu);

        $objPHPExcel->getActiveSheet()->getStyle("H".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$ligne, $data[0]->nbr_box_latrine_construite);

        $objPHPExcel->getActiveSheet()->getStyle("I".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$ligne, $data[0]->nbr_point_eau_prevu);

        $objPHPExcel->getActiveSheet()->getStyle("J".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$ligne, $data[0]->nbr_point_eau_construite);

        $objPHPExcel->getActiveSheet()->getStyle("K".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$ligne, $data[0]->nbr_table_banc_prevu);

        $objPHPExcel->getActiveSheet()->getStyle("L".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$ligne, $data[0]->nbr_table_banc_construite);

        $objPHPExcel->getActiveSheet()->getStyle("M".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$ligne, $data[0]->nbr_table_maitre_prevu);

        $objPHPExcel->getActiveSheet()->getStyle("N".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$ligne, $data[0]->nbr_table_maitre_construite);

        $objPHPExcel->getActiveSheet()->getStyle("O".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$ligne, $data[0]->nbr_chaise_maitre_prevu);

        $objPHPExcel->getActiveSheet()->getStyle("P".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$ligne, $data[0]->nbr_chaise_maitre_construite);

        $objPHPExcel->getActiveSheet()->getStyle("Q".$ligne)->applyFromArray($styleTitre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$ligne, " ");

        try
        {
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save(dirname(__FILE__) . "/../../../../../../assets/excel/indicateur/".$nom_file.".xlsx");
            
            $this->response([
                'status' => TRUE,
                'nom_file' =>$nom_file.".xlsx",
                'message' => 'Get file success',
            ], REST_Controller::HTTP_OK);
          
        } 
        catch (PHPExcel_Writer_Exception $e)
        {
            $this->response([
                  'status' => FALSE,
                   'nom_file' => array(),
                   'message' => "Something went wrong: ". $e->getMessage(),
                ], REST_Controller::HTTP_OK);
        }

    }

    public function insertion_entete($style,$ligne,$objPHPExcel,$id_region,$id_district,$id_site_embarquement,$id_unite_peche,$id_espece)
    {

        if($id_region!='*' && $id_region!="undefined")
        {
            $tmp= $this->RegionManager->findById($id_region);

            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
               
            $objRichText = new PHPExcel_RichText();

            $titre = $objRichText->createTextRun('Region : ');
            $titre->getFont()->applyFromArray(array( "bold" => true, "size" => 11, "name" => "Calibri"));

            $contenu = $objRichText->createTextRun($tmp->nom);
            $contenu->getFont()->applyFromArray(array("size" => 11, "name" => "Calibri"));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne,$objRichText);
            $ligne++;
        }
        if($id_district!='*' && $id_district!="undefined")
        {
            $tmp= $this->DistrictManager->findById($id_district);
            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
               
            $objRichText = new PHPExcel_RichText();

            $titre = $objRichText->createTextRun('District : ');
            $titre->getFont()->applyFromArray(array( "bold" => true, "size" => 11, "name" => "Calibri"));

            $contenu = $objRichText->createTextRun($tmp->nom);
            $contenu->getFont()->applyFromArray(array("size" => 11, "name" => "Calibri"));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne,$objRichText);
            $ligne++;
        }
        if($id_site_embarquement!='*' && $id_site_embarquement!="undefined")
        {
            $tmp= $this->Site_embarquementManager->findById($id_site_embarquement);

            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
            $objRichText = new PHPExcel_RichText();

            $titre = $objRichText->createTextRun('Site de débarquement : ');
            $titre->getFont()->applyFromArray(array( "bold" => true, "size" => 11, "name" => "Calibri"));

            $contenu = $objRichText->createTextRun($tmp->libelle);
            $contenu->getFont()->applyFromArray(array("size" => 11, "name" => "Calibri"));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne,$objRichText);

            $ligne++;
        }
        if($id_unite_peche!='*' && $id_unite_peche!="undefined")
        {
            $tmp= $this->Unite_pecheManager->findById($id_unite_peche);

            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
             $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":B".$ligne)->getAlignment()->setWrapText(false);  
            $objRichText = new PHPExcel_RichText();

            $titre = $objRichText->createTextRun('Unite de pêche : ');
            $titre->getFont()->applyFromArray(array( "bold" => true, "size" => 11, "name" => "Calibri"));

            $contenu = $objRichText->createTextRun($tmp->libelle);
            $contenu->getFont()->applyFromArray(array("size" => 11, "name" => "Calibri"));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne,$objRichText);
            $ligne++;
        }
        if($id_espece!='*' && $id_espece!="undefined")
        {
            $tmp= $this->EspeceManager->findById($id_espece);

            $objPHPExcel->getActiveSheet()->getStyle("A".$ligne)->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->mergeCells("A".$ligne.":B".$ligne);
             $objPHPExcel->getActiveSheet()->getStyle("A".$ligne.":B".$ligne)->getAlignment()->setWrapText(false);  
            $objRichText = new PHPExcel_RichText();

            $titre = $objRichText->createTextRun('Espece : ');
            $titre->getFont()->applyFromArray(array( "bold" => true, "size" => 11, "name" => "Calibri"));

            $contenu = $objRichText->createTextRun($tmp->nom_scientifique." (".$tmp->nom_local.")");
            $contenu->getFont()->applyFromArray(array("size" => 11, "name" => "Calibri"));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$ligne,$objRichText);
            $ligne++;
        }

        return $ligne;
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

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
?>