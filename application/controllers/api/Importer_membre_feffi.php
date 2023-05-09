<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importer_membre_feffi extends CI_Controller {
    public function __construct() {
        parent::__construct();        
        $this->load->model('organe_feffi_model', 'Organe_feffiManager');       
        $this->load->model('fonction_feffi_model', 'Fonction_feffiManager');       
        $this->load->model('cisco_model', 'CiscoManager');      
        $this->load->model('commune_model', 'CommuneManager');       
        $this->load->model('zap_model', 'ZapManager');         
        $this->load->model('zap_commune_model', 'Zap_communeManager');     
        $this->load->model('fokontany_model', 'FokontanyManager'); 
        $this->load->model('feffi_model', 'FeffiManager');
        $this->load->model('membre_feffi_model', 'Membre_feffiManager');
        

    }

	public function remove_upload_file()
	{	
		$chemin= $_POST['chemin'];
		$directoryName = dirname(__FILE__)."/../../../../../../assets/excel".$chemin;
	  	$delete = unlink($directoryName);
	}


	public function testmembre_feffi() {

		$erreur="aucun";
		ini_set('upload_max_filesize', '200000000000000000M');  
		ini_set('post_max_size', '2000000000000000000000M');
		
        ini_set ('memory_limit', '100000000000000000000000M');
		$replace=array('e','e','e','a','o','c','_');
		$search= array('é','è','ê','à','ö','ç',' ');

		$replacename=array('_','_','_');
		$searchname= array('/','"\"',' ');

		$repertoire=$_POST['repertoire'];
		$name_fichier=$_POST['name_fichier'];

		$repertoire=str_replace($search,$replace,$repertoire);
		$name_fichier=str_replace($searchname,$replacename,$name_fichier);
		//The name of the directory that we need to create.
		$directoryName = dirname(__FILE__) ."/../../../../../../assets/excel/" .$repertoire;
		//Check if the directory already exists.
		if(!is_dir($directoryName)){
			//Directory does not exist, so lets create it.
			mkdir($directoryName, 0777,true);
		}				

		$rapport=array();
		//$rapport['repertoire']=dirname(__FILE__) ."/../../../../../../assets/ddb/" .$repertoire;
		$config['upload_path']          = dirname(__FILE__) ."/../../../../../../assets/excel/".$repertoire;
		$config['allowed_types'] = 'xls|xlsx';
		$config['max_size'] = 200000000;
		$config['overwrite'] = TRUE;
		if (isset($_FILES['file']['tmp_name']))
		{
			$name=$_FILES['file']['name'];
			$name1=str_replace($searchname,$replacename,$name);
			$file_ext = pathinfo($name,PATHINFO_EXTENSION);
			//$rapport['nomFile']=$name_fichier.'.'.$file_ext;
			$rapport['nomFile']=$name_fichier;
			$config['file_name']=$name_fichier;
			//$rapport['repertoire']=$name_image;

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			//$ff=$this->upload->do_upload('file');
			if(!$this->upload->do_upload('file'))
			{
				$error = array('error' => $this->upload->display_errors());
				//$rapport["erreur"]= 'Type d\'image invalide. Veuillez inserer une image.png';
				$rapport["erreur"]= true;
				$rapport["erreur_value"]= $error;
				echo json_encode($rapport);
			}else{
				ini_set('upload_max_filesize', '2000000000M');  
		ini_set('post_max_size', '2000000000M');
		set_time_limit(0);
        ini_set ('memory_limit', '100000000000000M');
				$retour = $this->controler_donnees_importertestmembre_feffi($name1,$repertoire);
				$rapport['nbr_inserer']=$retour['nbr_inserer'];
				$rapport['nbr_refuser']=$retour['nbr_erreur'];
				$rapport['zap_inserer']=$retour['zap_inserer'];
				$rapport['erreur']=false;
				$rapport["erreur_value"]= '' ;
				echo json_encode($rapport);
			}
			
		} else {


			$rapport["erreur"]= true ;
			$rapport["erreur_value"]= 'File upload not found' ;
           // echo 'File upload not found';
            echo json_encode($rapport);
		} 
		
	}
	public function controler_donnees_importertestmembre_feffi($filename,$directory) {
		require_once 'Classes/PHPExcel.php';
		require_once 'Classes/PHPExcel/IOFactory.php';
		ini_set('upload_max_filesize', '2000000000M');  
		ini_set('post_max_size', '2000000000M');
		set_time_limit(0);
        ini_set ('memory_limit', '100000000000000M');
		$replace=array('e','e','e','a','o','c','_');
		$search= array('é','è','ê','à','ö','ç',' ');
		$repertoire= $directory;
		$nomfichier = $filename;		
		$repertoire=str_replace($search,$replace,$repertoire);
		$erreur=false;
		//$user_ok=false;
		$nbr_erreur=0;
		$nbr_inserer=0;
		$zap_inserer = array();
		//The name of the directory that we need to create.
		$directoryName = dirname(__FILE__) ."/../../../../../../assets/excel/".$repertoire;
		//Check if the directory already exists.
		if(!is_dir($directoryName)){
			//Directory does not exist, so lets create it.
			mkdir($directoryName, 0777,true);
		}	
		$chemin=dirname(__FILE__) ."/../../../../../../assets/excel/".$repertoire;
		$lien_vers_mon_document_excel = $chemin . $nomfichier;
		$array_data = array();
		if(strpos($lien_vers_mon_document_excel,"xlsx") >0) {
			// pour mise à jour après : G4 = id_fiche_paiement <=> déjà importé => à ignorer
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel2007');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			// pour lecture début - fin seulement
			$XLSXDocument = new PHPExcel_Reader_Excel2007();
		} else {
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel2007');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(0);
			$XLSXDocument = new PHPExcel_Reader_Excel5();
		}
		$Excel = $XLSXDocument->load($lien_vers_mon_document_excel);
		// get all the row of my file
		$aSheet = $Excel->getActiveSheet();
		$rowIterator = $aSheet->getRowIterator();
		$str_replace=array('');
		$str_search= array(' ');
		
		$cis = $Excel->getActiveSheet()->getCell('A4')->getValue();
		if ($cis=="")
		{
			$sheet->getStyle("A4")->getFill()->applyFromArray(
				array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
					'startcolor' => array('rgb' => 'f2e641'),
					'endcolor'   => array('rgb' => 'f2e641')
				)
			);
			$erreur = true;	
		}else
		{
			$cis_explode= explode(": ",$cis);
			$cisco=str_replace($str_search,$str_replace,$cis_explode[1]);
			$cisn=strtolower($cis_explode[1]);
			$retour_cisco = $this->CiscoManager->getciscobynomcisco($cisn);
			if(count($retour_cisco) >0)
			{
				foreach($retour_cisco as $k=>$v)
				{
					$id_cisco = $v->id;
				}	
			}
			else
			{
				$sheet->getStyle("A4")->getFill()->applyFromArray(
											array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
												'startcolor' => array('rgb' => 'f24141'),
												'endcolor'   => array('rgb' => 'f24141')
											)
								);
				$erreur = true;
			}
		}
		

		$za = $Excel->getActiveSheet()->getCell('A5')->getValue();
		if ($za=="")
		{
			$sheet->getStyle("A5")->getFill()->applyFromArray(
				array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
					'startcolor' => array('rgb' => 'f2e641'),
					'endcolor'   => array('rgb' => 'f2e641')
				)
			);
			$erreur = true;	
		}else
		{
			$za_explode= explode(": ",$za);
			$zap=str_replace($str_search,$str_replace,$za_explode[1]);
			$zapn=strtolower($za_explode[1]);

			$cis_explode= explode(": ",$cis);
			$cisco=str_replace($str_search,$str_replace,$cis_explode[1]);
			$cisn=strtolower($cis_explode[1]);
			$retour_zap = $this->Zap_communeManager->getzapbyzapcisco($zapn,$cisn);
			if(count($retour_zap) >0)
			{
				foreach($retour_zap as $k=>$v)
				{
					$id_zap = $v->id;
				}	
			}
			else
			{
				$sheet->getStyle("A5")->getFill()->applyFromArray(
											array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
												'startcolor' => array('rgb' => 'f24141'),
												'endcolor'   => array('rgb' => 'f24141')
											)
								);
				$erreur = true;
			}
		}
		

		
		$foko = $Excel->getActiveSheet()->getCell('A7')->getValue();

		if ($foko=="")
		{
			$sheet->getStyle("A7")->getFill()->applyFromArray(
				array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
					'startcolor' => array('rgb' => 'f2e641'),
					'endcolor'   => array('rgb' => 'f2e641')
				)
			);
			$erreur = true;	
		}else
		{
			$foko_explode= explode(": ",$foko);
			$fokontany=str_replace($str_search,$str_replace,$foko_explode[1]);
			$fokontanyn=strtolower($foko_explode[1]);

			$za_explode= explode(": ",$za);
			$zap=str_replace($str_search,$str_replace,$za_explode[1]);
			$zapn=strtolower($za_explode[1]);

			$cis_explode= explode(": ",$cis);
			$cisco=str_replace($str_search,$str_replace,$cis_explode[1]);
			$cisn=strtolower($cis_explode[1]);
			$retour_fokontany = $this->FokontanyManager->getfokontanybyfokontanyzapcisco($fokontanyn,$zapn,$cisn);
			if(count($retour_fokontany) >0)
			{
				foreach($retour_fokontany as $k=>$v)
				{
					$id_fokontany = $v->id;
				}	
			}
			else
			{
				$sheet->getStyle("A7")->getFill()->applyFromArray(
											array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
												'startcolor' => array('rgb' => 'f24141'),
												'endcolor'   => array('rgb' => 'f24141')
											)
								);
				$erreur = true;
			}
		}
		
		
		$fef = $Excel->getActiveSheet()->getCell('A6')->getValue();
		if ($fef=="")
		{
			$sheet->getStyle("A6")->getFill()->applyFromArray(
				array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
					'startcolor' => array('rgb' => 'f2e641'),
					'endcolor'   => array('rgb' => 'f2e641')
				)
			);
			$erreur = true;	
		}else
		{
			$fef_explode= explode(": ",$fef);
			$feffi=str_replace($str_search,$str_replace,$fef_explode[1]);
			$feffin=strtolower($fef_explode[1]);

			$sheet->setCellValue('C6', $feffin);
			$foko_explode= explode(": ",$foko);
			$fokontany=str_replace($str_search,$str_replace,$foko_explode[1]);
			$fokontanyn=strtolower($foko_explode[1]);

			$za_explode= explode(": ",$za);
			$zap=str_replace($str_search,$str_replace,$za_explode[1]);
			$zapn=strtolower($za_explode[1]);

			$cis_explode= explode(": ",$cis);
			$cisco=str_replace($str_search,$str_replace,$cis_explode[1]);
			$cisn=strtolower($cis_explode[1]);
			$retour_feffi = $this->FeffiManager->getfeffibyfeffifokozapcisco($feffin,$fokontanyn,$zapn,$cisn);
			if(count($retour_feffi) >0)
			{
				foreach($retour_feffi as $k=>$v)
				{
					$id_feffi = $v->id;
				}	
			}
			else
			{
				$sheet->getStyle("A6")->getFill()->applyFromArray(
											array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
												'startcolor' => array('rgb' => 'f24141'),
												'endcolor'   => array('rgb' => 'f24141')
											)
								);
				$erreur = true;
			}
		}
		if ($erreur==false)
		{
			foreach($rowIterator as $row)
			{			
				$ligne = $row->getRowIndex ();
				$erreur = false;
					if($ligne >=13)
					{
						$cellIterator = $row->getCellIterator();
						$cellIterator->setIterateOnlyExistingCells(false);
						$rowIndex = $row->getRowIndex ();
						foreach ($cellIterator as $cell)
						{
							if('A' == $cell->getColumn())
							{
								foreach ($aSheet->getMergeCells() as $cells) {
									if ($cell->isInRange($cells)) {
									$currMergedCellsArray = PHPExcel_Cell::splitRange($cells);
									$cel = $aSheet->getCell($currMergedCellsArray[0][0]);
									$org =$cel->getValue();
										break;
									}
									else {
										$org =$cell->getValue();
									}
								}
							}  
							else if('B' == $cell->getColumn())
							{
								
							/*	if ($ligne==23)
								{
									$fonc =$cell->getCalculatedValue();
								}
								else {*/
									$fonc =$cell->getValue();
								//}							
							}  
							else if('C' == $cell->getColumn())
							{
								$nom =$cell->getValue();							
							}  
							else if('D' == $cell->getColumn())
							{
								$sex =$cell->getValue();							
							}  
							else if('E' == $cell->getColumn())
							{
								$age =$cell->getValue();							
							} 	 
						}
						
						// Si donnée incorrect : coleur cellule en rouge
						
						if($org=="")
						{						
							$sheet->getStyle("A".$ligne)->getFill()->applyFromArray(
										array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											'startcolor' => array('rgb' => 'f2e641'),
											'endcolor'   => array('rgb' => 'f2e641')
										)
							);
							$erreur = true;													
						}
						else
						{
							// Vérifier si nom_feffi existe dans la BDD
							$orgn=strtolower($org);
							$retour_organe_feffi = $this->Organe_feffiManager->getorgane_feffitest($orgn);
							if(count($retour_organe_feffi) >0)
							{
								foreach($retour_organe_feffi as $k=>$v)
								{
									$id_organe_feffi = $v->id;
								}	
							}
							else
							{
								$sheet->getStyle("A".$ligne)->getFill()->applyFromArray(
											array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
												'startcolor' => array('rgb' => 'f24141'),
												'endcolor'   => array('rgb' => 'f24141')
											)
								);
								$erreur = true;
								$sheet->setCellValue('P'.$ligne, 'retour_organe_feffi');
							}
						}
						if($fonc=="")
						{						
							$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
										array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											'startcolor' => array('rgb' => 'f2e641'),
											'endcolor'   => array('rgb' => 'f2e641')
										)
							);
							$erreur = true;													
						}
						else
						{
							// Vérifier si nom_feffi existe dans la BDD
							$orgn=strtolower($org);
							$foncn=strtolower($fonc);
							$retour_fonction_feffi = $this->Fonction_feffiManager->getfonction_feffitest($orgn,$foncn);
							if(count($retour_fonction_feffi) >0)
							{
								foreach($retour_fonction_feffi as $k=>$v)
								{
									$id_fonction_feffi = $v->id;
								}	
							}
							else
							{
								$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
											array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
												'startcolor' => array('rgb' => 'f24141'),
												'endcolor'   => array('rgb' => 'f24141')
											)
								);
								$erreur = true;
								//$sheet->setCellValue('IQ'.$ligne, 'retour_cisco');
							}
						}
						
						if($nom=="")
						{						
							$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
										array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											'startcolor' => array('rgb' => 'f2e641'),
											'endcolor'   => array('rgb' => 'f2e641')
										)
							);
							$erreur = true;	
							$sheet->setCellValue('IQ'.$ligne, 'retour_commune1');												
						}
						if($sex =="")
						{						
							$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
										array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											'startcolor' => array('rgb' => 'f2e641'),
											'endcolor'   => array('rgb' => 'f2e641')
										)
							);
							$erreur = true;													
						}
						else
						{
							if (strtolower($sex)=='m' || strtolower($sex)=='h')
							{
								$sexe=1;
							}
							elseif (strtolower($sex)=='f')
							{
								$sexe=2;
							}else {
								$erreur = true;	
							}

						}
						
						if($age=="")
						{						
							$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
										array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											'startcolor' => array('rgb' => 'f2e641'),
											'endcolor'   => array('rgb' => 'f2e641')
										)
							);
							//$erreur = true;													
						}
						/*$id_fonction_feffi =1;
						$id_cisco=1;
						$id_commune=1;
						$id_zap=1;
						$id_fokontany=1;*/
						if($erreur==false)
						{	
							$orgn=strtolower($org);	
							$foncn=strtolower($fonc);
							$nom_explode= explode(" ",$nom);
							$nom_membre=$nom_explode[0];
							$prenom="";
							for ($i=1; $i < count($nom_explode); $i++)
							{ 
								$prenom =$prenom." ".$nom_explode[$i];
							}
							$prenom_membre = $prenom;
							//$sheet->setCellValue('C4', $cisco);
							$sheet->setCellValue('P'.$ligne, $nom_membre.$prenom_membre);					
							$doublon = $this->Membre_feffiManager->getmembre_feffitest($id_organe_feffi,$id_fonction_feffi,$nom_membre,$prenom_membre);
							if (count($doublon)>0)//mis doublon
							{
								$sheet->setCellValue('O'.$ligne, "Doublon");
								//$sheet->setCellValue('P'.$ligne, $org);
								array_push($zap_inserer, $doublon);
								$nbr_erreur = $nbr_erreur + 1;							
							}
							else//ts doublon
							{

									//$dataId = $this->ZapManager->add($data); 
								
									
									//$sheet->setCellValue('P'.$ligne, $org);  
									$data = array(
										'nom' => $nom_membre,
										'prenom' => $prenom_membre,
										'age' => $age,
										'sexe' => $sexe,
										'id_organe_feffi' => $id_organe_feffi,
										'id_fonction_feffi' => $id_fonction_feffi,
										'id_feffi' => $id_feffi									
										);
									$dataId = $this->Membre_feffiManager->add($data);

									/*$datacompte = array(
										'nom_banque' => "xxx",
										'rib' => "1234",
										'numero_compte' => "1234",
										'adresse_banque' => "xxx",
										'id_feffi' => $dataId
										
										);
									$dataIdcompte = $this->Compte_feffiManager->add($datacompte);*/	
								//array_push($zap_inserer, $data);
								$sheet->setCellValue('O'.$ligne, "ok");
								$nbr_inserer = $nbr_inserer + 1;
							}
																				
						}
						else//mis erreur
						{
							$sheet->setCellValue('O'.$ligne, "erreur");
							$nbr_erreur = $nbr_erreur + 1;
						}						
							
						$ligne = $ligne + 1;
					}
				
				
			}
		}
		
		//$report['requete']=$subvention_initial;
		$report['nbr_erreur']=$nbr_erreur;
		$report['nbr_inserer']=$nbr_inserer;
		//$report['user']=$type_latrine;
		$report['zap_inserer']=$zap_inserer;
		//echo json_encode($report);	
		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$objWriter->save(dirname(__FILE__) ."/../../../../../../assets/excel/".$repertoire. $nomfichier);
		unset($excel);
		unset($objWriter);
		return $report;
	}

////////////////////////////////////////////////////////////////////


} ?>	
