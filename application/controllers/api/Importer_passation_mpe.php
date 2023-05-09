<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importer_passation_mpe extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        $this->load->model('passation_marches_model', 'Passation_marchesManager');
        

    }
	public function importerdonnee_passation_mpe() {

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
				$rapport['passation_inserer']=$retour['passation_inserer'];
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
		$passation_inserer = array();
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
			$sheet = $excel->getSheet(19);
			// pour lecture début - fin seulement
			$XLSXDocument = new PHPExcel_Reader_Excel2007();
		} else {
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel2007');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(19);
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
							$date_lancement =$cell->getValue();
							if(isset($date_lancement) && $date_lancement>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_lancement = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_lancement)); 
								}
							} 
							else 
							{
								$date_lancement=null;
							}
						} 

						else if('C' == $cell->getColumn())
						{
							$date_remise =$cell->getValue();
							if(isset($date_remise) && $date_remise>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_remise = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_remise)); 
								}
							} 
							else 
							{
								$date_remise=null;
							}
						} 
						else if('D' == $cell->getColumn())
						{
							$montant_moin_chere =$cell->getValue();
						} 
						else if('E' == $cell->getColumn())
						{
							$date_rapport_evaluation =$cell->getValue();
							if(isset($date_rapport_evaluation) && $date_rapport_evaluation>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_rapport_evaluation = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_rapport_evaluation)); 
								}
							} 
							else 
							{
								$date_rapport_evaluation=null;
							}
						} 
						else if('F' == $cell->getColumn())
						{
							$date_demande_ano_dpfi =$cell->getValue();
							if(isset($date_demande_ano_dpfi) && $date_demande_ano_dpfi>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_demande_ano_dpfi = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_demande_ano_dpfi)); 
								}
							} 
							else 
							{
								$date_demande_ano_dpfi=null;
							}
						}						
						else if('G' == $cell->getColumn())
						{
							$date_ano_dpfi = $cell->getValue();
							if(isset($date_ano_dpfi) && $date_ano_dpfi>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_ano_dpfi = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_ano_dpfi)); 
								}
							} 
							else 
							{
								$date_ano_dpfi=null;
							}	
						}						
						else if('H' == $cell->getColumn())
						{
							$notification_intention = $cell->getValue();
							if(isset($notification_intention) && $notification_intention>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$notification_intention = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($notification_intention)); 
								}
							} 
							else 
							{
								$notification_intention=null;
							}	
						}						
						else if('I' == $cell->getColumn())
						{
							$date_notification_attribution = $cell->getValue();
							if(isset($date_notification_attribution) && $date_notification_attribution>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_notification_attribution = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_notification_attribution)); 
								}
							} 
							else 
							{
								$date_notification_attribution=null;
							}	
						}

						else if('J' == $cell->getColumn())
						{
							$date_os = $cell->getValue();
							if(isset($date_os) && $date_os>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_os = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_os)); 
								}
							} 
							else 
							{
								$date_os=null;
							}	
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

					if($date_lancement=="")
					{						
						$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					} 

					if($date_remise=="")
					{						
						$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);	
						$erreur = true;												
					}
					if($montant_moin_chere=="")
					{						
						$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($date_rapport_evaluation=="")
					{						
						$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($date_demande_ano_dpfi=="")
					{						
						$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}


					if($date_ano_dpfi=="")
					{						
						$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					} 

					if($notification_intention=="")
					{						
						$sheet->getStyle("H".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);	
						$erreur = true;												
					}
					if($date_notification_attribution=="")
					{						
						$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($date_os=="")
					{						
						$sheet->getStyle("J".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					/*if($observation=="")
					{						
						$sheet->getStyle("O".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}*/
					
					if($erreur==false)
					{	
						$doublon = $this->Passation_marchesManager->getpassationByconvention($id_convention_entete);
						if (count($doublon)>0)
						{
							$sheet->setCellValue('L'.$ligne, "Doublon");
							$nbr_erreur = $nbr_erreur + 1;							
						}
						else
						{
		        			$sheet->setCellValue('L'.$ligne, "Ok");
		        			$data = array(
		                    'id_convention_entete' => $id_convention_entete,
		                    'date_lancement' => $date_lancement,
		                    'date_remise'   => $date_remise,
		                    'montant_moin_chere'    => $montant_moin_chere,
		                    'date_rapport_evaluation' => $date_rapport_evaluation,
		                    'date_demande_ano_dpfi' => $date_demande_ano_dpfi,
		                    'date_ano_dpfi' => $date_ano_dpfi,
		                    'notification_intention'   => $notification_intention,
		                    'date_notification_attribution'    => $date_notification_attribution,
		                    'date_os' => $date_os,
		                    'observation' => $observation, 
		                    'validation' => 0
		                	);
	                		$dataId = $this->Passation_marchesManager->add($data);                		

		                	array_push($passation_inserer, $data);
							$nbr_inserer = $nbr_inserer + 1;
						}
	        																
					}
					else
					{
						$sheet->setCellValue('L'.$ligne, "Erreur");
						$nbr_erreur = $nbr_erreur + 1;
					}						
						
					//$ligne = $ligne + 1;
				}
			
			
		}
		//$report['requete']=$subvention_initial;
		$report['nbr_erreur']=$nbr_erreur;
		$report['nbr_inserer']=$nbr_inserer;
		//$report['user']=$type_latrine;
		$report['passation_inserer']=$passation_inserer;
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
