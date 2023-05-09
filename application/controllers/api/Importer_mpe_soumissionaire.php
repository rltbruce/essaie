<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importer_mpe_soumissionaire extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('passation_marches_model', 'Passation_marchesManager');
        $this->load->model('prestataire_model', 'PrestataireManager');
        $this->load->model('mpe_soumissionaire_model', 'Mpe_soumissionaireManager');
        

    }
	public function importerdonnee_mpe_soumissionaire() {

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
				$rapport['mpe_soumissionaire_inserer']=$retour['mpe_soumissionaire_inserer'];
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
		$mpe_soumissionaire_inserer = array();
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
			$sheet = $excel->getSheet(20);
			// pour lecture début - fin seulement
			$XLSXDocument = new PHPExcel_Reader_Excel2007();
		} else {
			$objet_read_write = PHPExcel_IOFactory::createReader('Excel2007');
			$excel = $objet_read_write->load($lien_vers_mon_document_excel);			 
			$sheet = $excel->getSheet(20);
			$XLSXDocument = new PHPExcel_Reader_Excel5();
		}
		$Excel = $XLSXDocument->load($lien_vers_mon_document_excel);
		// get all the row of my file
		$rowIterator = $Excel->getActiveSheet()->getRowIterator();

		foreach($rowIterator as $row)
		{			
			$ligne = $row->getRowIndex ();
			if($ligne ==2)
				{	
					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false);
					$rowIndex = $row->getRowIndex ();
					foreach ($cellIterator as $cell)
					{
						if('B' == $cell->getColumn())
						{
							$ref_convention =$cell->getValue();
						}
					}


					if($ref_convention=="")
					{						
						$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'f2e641'),
											 'endcolor'   => array('rgb' => 'f2e641')
										 )
							);
						$erreur = true;
						break;													
					}
					else
					{
						//Vérifier si nom_feffi existe dans la BDD
						$ref_convention=strtolower($ref_convention);
						$retour_passation_marches = $this->Passation_marchesManager->findByRef_convention($ref_convention);
						if(count($retour_passation_marches) >0)
						{
							foreach($retour_passation_marches as $k=>$v)
							{
								$id_passation_marches = $v->id;
									//$id_convention_entete = $v->id_convention_entete;
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
							break;
						}
					}
				}
			
				if($ligne >=4)
				{
					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false);
					$rowIndex = $row->getRowIndex ();
					foreach ($cellIterator as $cell)
					{
						if('A' == $cell->getColumn())
						{
							$nom =$cell->getValue();							
						} 

						else if('B' == $cell->getColumn())
						{
							$siege =$cell->getValue();
							
						} 
						else if('C' == $cell->getColumn())
						{
							$telephone =$cell->getValue();
							
						}  
						else if('D' == $cell->getColumn())
						{
							$stat =$cell->getValue();
							
						} 
						else if('E' == $cell->getColumn())
						{
							$nif =$cell->getValue();
							
						}
							 
					}
					
					// Si donnée incorrect : coleur cellule en rouge
					if($nom=="")
					{						
						$sheet->getStyle("A".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					} 

					if($siege=="")
					{						
						$sheet->getStyle("B".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);	
						$erreur = true;												
					}
					if($telephone=="")
					{						
						$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					if($stat=="")
					{						
						$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					if($nif=="")
					{						
						$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}		
					
					if($erreur==false)
					{	
						$prestataire = $this->PrestataireManager->findByNom(strtolower($nom));
						if (count($prestataire)>0)
						{
							foreach($retour_passation_marches as $k=>$v)
							{
								$id_prestataire = $v->id;
							}
							$doublon = $this->Mpe_soumissionaireManager->getmpesoumissionaireBypassationpres($id_passation_marches,$id_prestataire);
							if (count($doublon)>0)
							{
								$sheet->setCellValue('F'.$ligne, "Doublon");
								$nbr_erreur = $nbr_erreur + 1;							
							}
							else
							{
			        			$sheet->setCellValue('F'.$ligne, "Ok");
			        			$data = array(
			                    'id_passation_marches' => $id_passation_marches,
			                    'id_prestataire' => $id_prestataire
			                	);
		                		$dataId = $this->Mpe_soumissionaireManager->add($data);                		

			                	array_push($mpe_soumissionaire_inserer, $data);
								$nbr_inserer = $nbr_inserer + 1;
							}
						}
						else
						{	

		                	$sheet->setCellValue('F'.$ligne, "Ok");

							$data_prestataire = array(
			                    'nom' => $nom, 
			                    'siege' => $siege, 
			                    'telephone' => $telephone, 
			                    'stat' => $stat, 
			                    'nif' => $nif
			                	);
		                	$dataId_prestataire = $this->PrestataireManager->add($data_prestataire);
			        			$data = array(
			                    'id_passation_marches' => $id_passation_marches,
			                    'id_prestataire' => $dataId_prestataire
			                	);
		                		$dataId = $this->Mpe_soumissionaireManager->add($data);                		

			                	array_push($mpe_soumissionaire_inserer, $data);
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
		$report['mpe_soumissionaire_inserer']=$mpe_soumissionaire_inserer;
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
