<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importer_contrat_mpe extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        $this->load->model('contrat_prestataire_model', 'Contrat_prestataireManager');
        $this->load->model('prestataire_model', 'PrestataireManager');
        

    }
	public function importerdonnee_contrat_mpe() {

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
				$rapport['contrat_inserer']=$retour['contrat_inserer'];
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
		//$user_ok=false;
		$nbr_erreur=0;
		$nbr_inserer=0;
		$contrat_inserer = array();
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
			$sheet = $excel->getSheet(21);
			// pour lecture début - fin seulement
			$XLSXDocument = new PHPExcel_Reader_Excel2007();
		} else {
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel2007');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(21);
			$XLSXDocument = new PHPExcel_Reader_Excel5();
		}
		$Excel = $XLSXDocument->load($lien_vers_mon_document_excel);
		// get all the row of my file
		$rowIterator = $Excel->getActiveSheet()->getRowIterator();

		foreach($rowIterator as $row)
		{			
			$ligne = $row->getRowIndex ();
			
				if($ligne >=3)
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
							$ref_contrat =$cell->getValue();							
						} 

						else if('C' == $cell->getColumn())
						{
							$description =$cell->getValue();
							
						} 
						else if('D' == $cell->getColumn())
						{
							$cout_batiment =$cell->getValue();
							
						}  
						else if('E' == $cell->getColumn())
						{
							$cout_latrine =$cell->getValue();
							
						} 
						else if('F' == $cell->getColumn())
						{
							$cout_mobilier =$cell->getValue();
							
						}
						else if('G' == $cell->getColumn())
						{
							$date_signature =$cell->getValue();
							if(isset($date_signature) && $date_signature>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_signature = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_signature)); 
								}
							} 
							else 
							{
								$date_signature=null;
							}
						}
						/*else if('H' == $cell->getColumn())
						{
							$date_prev_deb_trav =$cell->getValue();
							if(isset($date_prev_deb_trav) && $date_prev_deb_trav>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_prev_deb_trav = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_prev_deb_trav)); 
								}
							} 
							else 
							{
								$date_prev_deb_trav=null;
							}
						}
						else if('I' == $cell->getColumn())
						{
							$date_reel_deb_trav =$cell->getValue();
							if(isset($date_reel_deb_trav) && $date_reel_deb_trav>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_reel_deb_trav = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_reel_deb_trav)); 
								}
							} 
							else 
							{
								$date_reel_deb_trav=null;
							}
						}*/
						else if('H' == $cell->getColumn())
						{
							$delai =$cell->getValue();							
						}						
						else if('I' == $cell->getColumn())
						{
							$nom_consultant = $cell->getValue();
								
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
						$retour_convention = $this->Convention_cisco_feffi_enteteManager->findByRef_convention($ref_convention);
						if(count($retour_convention) >0)
						{
							foreach($retour_convention as $k=>$v)
							{
								$id_convention_entete = $v->id;
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

					if($ref_contrat=="")
					{						
						$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					} 

					if($description=="")
					{						
						$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);	
						$erreur = true;												
					}
					if($cout_batiment=="")
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
						if (is_numeric($cout_batiment) == false))
						{
							$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
								array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									'startcolor' => array('rgb' => 'f2e641'),
									'endcolor'   => array('rgb' => 'f2e641')
								)
							);
							$erreur = true;
						}
					}
					if($cout_latrine=="")
					{						
						$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					else
					{
						if (is_numeric($cout_latrine) == false))
						{
							$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
								array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									'startcolor' => array('rgb' => 'f2e641'),
									'endcolor'   => array('rgb' => 'f2e641')
								)
							);
							$erreur = true;	
						}
					}
					if($cout_mobilier=="")
					{						
						$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					else
					{
						if (is_numeric($cout_mobilier) == false))
						{
							$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
								array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									'startcolor' => array('rgb' => 'f2e641'),
									'endcolor'   => array('rgb' => 'f2e641')
								)
							);
							$erreur = true;	
						}
					
					
					if($date_signature=="")
					{						
						$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					/*if($date_prev_deb_trav=="")
					{						
						$sheet->getStyle("H".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($date_reel_deb_trav=="")
					{						
						$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}*/
					
					if($delai=="")
					{						
						$sheet->getStyle("H".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($nom_consultant=="")
					{						
						$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
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
						$nom_consultant=strtolower($nom_consultant);
						$retour_prestataire = $this->PrestataireManager->findBynom($nom_consultant);
						if(count($retour_prestataire) >0)
						{
							foreach($retour_prestataire as $k=>$v)
							{
								$id_prestataire = $v->id;
							}	
						}
						else
						{
							$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'f24141'),
											 'endcolor'   => array('rgb' => 'f24141')
										 )
							);
							$erreur = true;
						}
					} 
					
					if($erreur==false)
					{	
						$doublon = $this->Contrat_prestataireManager->getcontratByconvention($id_convention_entete);
						if (count($doublon)>0)
						{
							$sheet->setCellValue('J'.$ligne, "Doublon");
							$nbr_erreur = $nbr_erreur + 1;							
						}
						else
						{
		        			$sheet->setCellValue('J'.$ligne, "Ok");
		        			$data = array(
		                    'id_convention_entete' => $id_convention_entete,
		                    'num_contrat' => $ref_contrat,
		                    'description' => $description, 
		                    'cout_batiment' => $cout_batiment, 
		                    'cout_latrine' => $cout_latrine, 
		                    'cout_mobilier' => $cout_mobilier, 
		                    'date_signature' => $date_signature, 
		                    //'date_prev_deb_trav' => $date_prev_deb_trav, 
		                    //'date_reel_deb_trav' => $date_reel_deb_trav, 
		                    'delai_execution' => $delai, 
		                    'paiement_recu' => null,
		                    'id_prestataire' => $id_prestataire, 
		                    'validation' => 0
		                	);
	                		$dataId = $this->Contrat_prestataireManager->add($data);                		

		                	array_push($contrat_inserer, $data);
							$nbr_inserer = $nbr_inserer + 1;
						}
	        																
					}
					else
					{
						$sheet->setCellValue('J'.$ligne, "Erreur");
						$nbr_erreur = $nbr_erreur + 1;
					}						
						
					//$ligne = $ligne + 1;
				}
			
			
		}
		//$report['requete']=$subvention_initial;
		$report['nbr_erreur']=$nbr_erreur;
		$report['nbr_inserer']=$nbr_inserer;
		//$report['user']=$type_latrine;
		$report['contrat_inserer']=$contrat_inserer;
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
