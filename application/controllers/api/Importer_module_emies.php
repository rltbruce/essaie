<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importer_module_emies extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('contrat_partenaire_relai_model', 'Contrat_partenaire_relaiManager');
        $this->load->model('module_emies_model', 'Module_emiesManager');
        

    }
	public function importerdonnee_module_emies() {

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
				$rapport['module_emies_inserer']=$retour['module_emies_inserer'];
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
		$module_emies_inserer = array();
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
			$sheet = $excel->getSheet(14);
			// pour lecture début - fin seulement
			$XLSXDocument = new PHPExcel_Reader_Excel2007();
		} else {
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel2007');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(14);
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
							$date_debut_previ_form =$cell->getValue();
							if(isset($date_debut_previ_form) && $date_debut_previ_form>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_debut_previ_form = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_debut_previ_form)); 
								}
							} 
							else 
							{
								$date_debut_previ_form=null;
							}
						} 

						else if('C' == $cell->getColumn())
						{
							$date_fin_previ_form =$cell->getValue();
							if(isset($date_fin_previ_form) && $date_fin_previ_form>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_fin_previ_form = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_fin_previ_form)); 
								}
							} 
							else 
							{
								$date_fin_previ_form=null;
							}
						} 
						else if('D' == $cell->getColumn())
						{
							$date_previ_resti =$cell->getValue();
							if(isset($date_previ_resti) && $date_previ_resti>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_previ_resti = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_previ_resti)); 
								}
							} 
							else 
							{
								$date_previ_resti=null;
							}
						} 
						else if('E' == $cell->getColumn())
						{
							$date_debut_reel_form =$cell->getValue();
							if(isset($date_debut_reel_form) && $date_debut_reel_form>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_debut_reel_form = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_debut_reel_form)); 
								}
							} 
							else 
							{
								$date_debut_reel_form=null;
							}
						} 
						else if('F' == $cell->getColumn())
						{
							$date_fin_reel_form =$cell->getValue();
							if(isset($date_fin_reel_form) && $date_fin_reel_form>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_fin_reel_form = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_fin_reel_form)); 
								}
							} 
							else 
							{
								$date_fin_reel_form=null;
							}
						}						
						else if('G' == $cell->getColumn())
						{
							$date_reel_resti = $cell->getValue();
							if(isset($date_reel_resti) && $date_reel_resti>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_reel_resti = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_reel_resti)); 
								}
							} 
							else 
							{
								$date_reel_resti=null;
							}	
						}						
						else if('H' == $cell->getColumn())
						{
							$nbr_previ_parti = $cell->getValue();	
						}						
						else if('I' == $cell->getColumn())
						{
							$nbr_previ_fem_parti = $cell->getValue();	
						}

						else if('J' == $cell->getColumn())
						{
							$lieu_formation = $cell->getValue();	
						}						
						else if('K' == $cell->getColumn())
						{
							$observation = $cell->getValue();	
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
						$retour_contrat = $this->Contrat_partenaire_relaiManager->findByRef_convention($ref_convention);
						if(count($retour_contrat) >0)
						{
							foreach($retour_contrat as $k=>$v)
							{
								$id_contrat_partenaire_relai = $v->id;
								$id_convention_entete = $v->id_convention_entete;
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

					if($date_debut_previ_form=="")
					{						
						$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					} 

					if($date_fin_previ_form=="")
					{						
						$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);	
						$erreur = true;												
					}
					if($date_previ_resti=="")
					{						
						$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($date_debut_reel_form=="")
					{						
						$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($date_fin_reel_form=="")
					{						
						$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}


					if($date_reel_resti=="")
					{						
						$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					} 

					if($nbr_previ_parti=="")
					{						
						$sheet->getStyle("H".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);	
						$erreur = true;												
					}
					if($nbr_previ_fem_parti=="")
					{						
						$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($lieu_formation=="")
					{						
						$sheet->getStyle("J".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($erreur==false)
					{	
						$doublon = $this->Module_emiesManager->getmoduleBycontrat($id_contrat_partenaire_relai);
						if (count($doublon)>0)
						{
							$sheet->setCellValue('L'.$ligne, "Doublon");
							$nbr_erreur = $nbr_erreur + 1;							
						}
						else
						{
		        			$sheet->setCellValue('L'.$ligne, "Ok");
		        			$data = array(
		                    'id_contrat_partenaire_relai' => $id_contrat_partenaire_relai,
		                    'date_debut_previ_form' => $date_debut_previ_form,
		                    'date_fin_previ_form'   => $date_fin_previ_form,
		                    'date_previ_resti'    => $date_previ_resti,
		                    'date_debut_reel_form' => $date_debut_reel_form,
		                    'date_fin_reel_form' => $date_fin_reel_form,
		                    'date_reel_resti' => $date_reel_resti,
		                    'nbr_previ_parti'   => $nbr_previ_parti,
		                    'nbr_parti'    => null,
		                    'nbr_previ_fem_parti'   => $nbr_previ_fem_parti,
		                    'nbr_reel_fem_parti' => null,
		                    'observation' => $observation,
		                    'lieu_formation'   => $lieu_formation, 
		                    'validation' => 0
		                	);
	                		//$dataId = $this->Module_emiesManager->add($data);                		

		                	array_push($module_emies_inserer, $data);
							$nbr_inserer = $nbr_inserer + 1;
						}
	        																
					}
					else
					{
						$sheet->setCellValue('L'.$ligne, "Erreur");
						$nbr_erreur = $nbr_erreur + 1;
					}						
					$ligne = $ligne+1;
				}
			
			
		}
		//$report['requete']=$subvention_initial;
		$report['nbr_erreur']=$nbr_erreur;
		$report['nbr_inserer']=$nbr_inserer;
		//$report['user']=$type_latrine;
		$report['module_emies_inserer']=$module_emies_inserer;
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
