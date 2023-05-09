<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importer_rapport_mensuel extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('contrat_be_model', 'Contrat_beManager');
        $this->load->model('rapport_mensuel_model', 'Rapport_mensuelManager');
        

    }
	public function importerdonnee_rapport_mensuel() {

		$erreur="aucun";
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
		$config['max_size'] = 2000;
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
				$retour = $this->controler_donnees_importer($name1,$repertoire);
				$rapport['nbr_inserer']=$retour['nbr_inserer'];
				$rapport['nbr_refuser']=$retour['nbr_erreur'];
				$rapport['rapport_mensuel_inserer']=$retour['rapport_mensuel_inserer'];
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
	public function controler_donnees_importer($filename,$directory) {
		require_once 'Classes/PHPExcel.php';
		require_once 'Classes/PHPExcel/IOFactory.php';

		set_time_limit(0);
		$replace=array('e','e','e','a','o','c','_');
		$search= array('é','è','ê','à','ö','ç',' ');
		$repertoire= $directory;
		$nomfichier = $filename;		
		$repertoire=str_replace($search,$replace,$repertoire);
		$erreur=false;
		$erreur2=false;
		$erreur3=false;
		$erreur4=false;
		//$user_ok=false;
		$nbr_erreur=0;
		$nbr_inserer=0;
		$rapport_mensuel_inserer = array();
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
			$sheet = $excel->getSheet(24);
			// pour lecture début - fin seulement
			$XLSXDocument = new PHPExcel_Reader_Excel2007();
		} else {
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel2007');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(24);
			$XLSXDocument = new PHPExcel_Reader_Excel5();
		}
		$Excel = $XLSXDocument->load($lien_vers_mon_document_excel);
		// get all the row of my file
		$rowIterator = $Excel->getActiveSheet()->getRowIterator();

		foreach($rowIterator as $row)
		{			
			$ligne = $row->getRowIndex ();
			
				if($ligne >=4)
				{
					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false);
					$rowIndex = $row->getRowIndex ();
					foreach ($cellIterator as $cell)
					{
						if('A' == $cell->getColumn())
						{
							$ref_convention =$cell->getValue();
						} 
						else if('B' == $cell->getColumn())
						{
							$description =$cell->getValue();							
						} 

						else if('C' == $cell->getColumn())
						{
							$date_livraison =$cell->getValue();
							if(isset($date_livraison) && $date_livraison>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_livraison = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_livraison)); 
								}
							} 
							else 
							{
								$date_livraison=null;
							}
						}  
						else if('D' == $cell->getColumn())
						{
							$observation =$cell->getValue();
							
						} 
						else if('F' == $cell->getColumn())
						{
							$description2 =$cell->getValue();							
						} 

						else if('G' == $cell->getColumn())
						{
							$date_livraison2 =$cell->getValue();
							if(isset($date_livraison2) && $date_livraison2>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_livraison2 = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_livraison2)); 
								}
							} 
							else 
							{
								$date_livraison2=null;
							}
						}  
						else if('H' == $cell->getColumn())
						{
							$observation2 =$cell->getValue();							
						} 

						else if('J' == $cell->getColumn())
						{
							$description3 =$cell->getValue();							
						} 

						else if('K' == $cell->getColumn())
						{
							$date_livraison3 =$cell->getValue();
							if(isset($date_livraison3) && $date_livraison3>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_livraison3 = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_livraison3)); 
								}
							} 
							else 
							{
								$date_livraison3=null;
							}
						}  
						else if('L' == $cell->getColumn())
						{
							$observation3 =$cell->getValue();							
						}
						else if('N' == $cell->getColumn())
						{
							$description4 =$cell->getValue();							
						} 

						else if('O' == $cell->getColumn())
						{
							$date_livraison4 =$cell->getValue();
							if(isset($date_livraison4) && $date_livraison4>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_livraison4 = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_livraison4)); 
								}
							} 
							else 
							{
								$date_livraison4=null;
							}
						}  
						else if('P' == $cell->getColumn())
						{
							$observation4 =$cell->getValue();							
						}					
							 
					}
					
					// Si donnée incorrect : coleur cellule en rouge
					if($ref_convention=="")
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
						$ref_convention=strtolower($ref_convention);
						$retour_contrat = $this->Contrat_beManager->findByRef_convention($ref_convention);
						if(count($retour_contrat) >0)
						{
							foreach($retour_contrat as $k=>$v)
							{
								$id_contrat_bureau_etude = $v->id;
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
						}
					} 

					if($description=="")
					{						
						$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					} 

					if($date_livraison=="")
					{						
						$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);	
						$erreur = true;												
					}
					
					if($erreur==false)
					{	
						$doublon = $this->Rapport_mensuelManager->getrapport_mensuel1Bycontrat($id_contrat_bureau_etude);
						if (count($doublon)>0)
						{
							$sheet->setCellValue('E'.$ligne, "Doublon");
							$nbr_erreur = $nbr_erreur + 1;							
						}
						else
						{
		        			$sheet->setCellValue('E'.$ligne, "Ok");
		        			$data = array(
		                    'id_contrat_bureau_etude' => $id_contrat_bureau_etude,
		                    'description' => $description, 
		                    'date_livraison' => $date_livraison, 
		                    'observation' => $observation, 
		                    'numero' => 1,
		                    'validation' => 0
		                	);
	                		$dataId = $this->Rapport_mensuelManager->add($data);                		

		                	array_push($rapport_mensuel_inserer, $data);
							$nbr_inserer = $nbr_inserer + 1;
						}
	        																
					}
					else
					{
						$sheet->setCellValue('E'.$ligne, "Erreur");
						$nbr_erreur = $nbr_erreur + 1;
					}


					if($description2=="")
					{						
						$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur2 = true;													
					} 

					if($date_livraison2=="")
					{						
						$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);	
						$erreur2 = true;												
					}
					
					if($erreur2==false)
					{	
						$doublon = $this->Rapport_mensuelManager->getrapport_mensuel2Bycontrat($id_contrat_bureau_etude);
						if (count($doublon)>0)
						{
							$sheet->setCellValue('I'.$ligne, "Doublon");
							$nbr_erreur = $nbr_erreur + 1;							
						}
						else
						{
		        			$sheet->setCellValue('I'.$ligne, "Ok");
		        			$data = array(
		                    'id_contrat_bureau_etude' => $id_contrat_bureau_etude,
		                    'description' => $description2, 
		                    'date_livraison' => $date_livraison2, 
		                    'observation' => $observation2, 
		                    'numero' => 2,
		                    'validation' => 0
		                	);
	                		$dataId = $this->Rapport_mensuelManager->add($data);                		

		                	array_push($rapport_mensuel_inserer, $data);
							$nbr_inserer = $nbr_inserer + 1;
						}
	        																
					}
					else
					{
						$sheet->setCellValue('I'.$ligne, "Erreur");
						$nbr_erreur = $nbr_erreur + 1;
					}


					if($description3=="")
					{						
						$sheet->getStyle("J".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur3 = true;													
					} 

					if($date_livraison3=="")
					{						
						$sheet->getStyle("K".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);	
						$erreur3 = true;												
					}
					
					if($erreur3==false)
					{	
						$doublon = $this->Rapport_mensuelManager->getrapport_mensuel3Bycontrat($id_contrat_bureau_etude);
						if (count($doublon)>0)
						{
							$sheet->setCellValue('M'.$ligne, "Doublon");
							$nbr_erreur = $nbr_erreur + 1;							
						}
						else
						{
		        			$sheet->setCellValue('M'.$ligne, "Ok");
		        			$data = array(
		                    'id_contrat_bureau_etude' => $id_contrat_bureau_etude,
		                    'description' => $description3, 
		                    'date_livraison' => $date_livraison3, 
		                    'observation' => $observation3, 
		                    'numero' => 3,
		                    'validation' => 0
		                	);
	                		$dataId = $this->Rapport_mensuelManager->add($data);                		

		                	array_push($rapport_mensuel_inserer, $data);
							$nbr_inserer = $nbr_inserer + 1;
						}
	        																
					}
					else
					{
						$sheet->setCellValue('M'.$ligne, "Erreur");
						$nbr_erreur = $nbr_erreur + 1;
					}


					if($description4=="")
					{						
						$sheet->getStyle("N".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur4 = true;													
					} 

					if($date_livraison4=="")
					{						
						$sheet->getStyle("O".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);	
						$erreur4 = true;												
					}
					
					if($erreur4==false)
					{	
						$doublon = $this->Rapport_mensuelManager->getrapport_mensuel4Bycontrat($id_contrat_bureau_etude);
						if (count($doublon)>0)
						{
							$sheet->setCellValue('Q'.$ligne, "Doublon");
							$nbr_erreur = $nbr_erreur + 1;							
						}
						else
						{
		        			$sheet->setCellValue('Q'.$ligne, "Ok");
		        			$data = array(
		                    'id_contrat_bureau_etude' => $id_contrat_bureau_etude,
		                    'description' => $description4, 
		                    'date_livraison' => $date_livraison4, 
		                    'observation' => $observation4, 
		                    'numero' => 4,
		                    'validation' => 0
		                	);
	                		$dataId = $this->Rapport_mensuelManager->add($data);                		

		                	array_push($rapport_mensuel_inserer, $data);
							$nbr_inserer = $nbr_inserer + 1;
						}
	        																
					}
					else
					{
						$sheet->setCellValue('Q'.$ligne, "Erreur");
						$nbr_erreur = $nbr_erreur + 1;
					}						
						
					$ligne = $ligne + 1;
				}
			
			
		}
		//$report['requete']=$subvention_initial;
		$report['nbr_erreur']=$nbr_erreur;
		$report['nbr_inserer']=$nbr_inserer;
		//$report['user']=$type_latrine;
		$report['rapport_mensuel_inserer']=$rapport_mensuel_inserer;
		//echo json_encode($report);	
		$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$objWriter->save(dirname(__FILE__) ."/../../../../../../assets/excel/".$repertoire. $nomfichier);
		unset($excel);
		unset($objWriter);
		return $report;
	}


	public function remove_upload_file()
	{	
		$chemin= $_POST['chemin'];
		$directoryName = dirname(__FILE__)."/../../../../../../assets/excel".$chemin;
	  	$delete = unlink($directoryName);
	}
} ?>	
