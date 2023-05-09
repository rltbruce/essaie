<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importer_convention extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('feffi_model', 'FeffiManager');
        $this->load->model('cisco_model', 'CiscoManager');
        $this->load->model('site_model', 'SiteManager');
        $this->load->model('utilisateurs_model', 'UserManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        $this->load->model('convention_cisco_feffi_detail_model', 'Convention_cisco_feffi_detailManager');
        $this->load->model('subvention_initial_model', 'Subvention_initialManager');
        $this->load->model('type_batiment_model', 'Type_batimentManager');
        $this->load->model('type_latrine_model', 'Type_latrineManager');
        $this->load->model('type_mobilier_model', 'Type_mobilierManager');
        $this->load->model('type_cout_maitrise_model', 'Type_cout_maitriseManager');
        $this->load->model('type_cout_sousprojet_model', 'Type_cout_sousprojetManager');
        $this->load->model('batiment_construction_model', 'Batiment_constructionManager');
        $this->load->model('latrine_construction_model', 'Latrine_constructionManager');
        $this->load->model('mobilier_construction_model', 'Mobilier_constructionManager');
        $this->load->model('cout_maitrise_construction_model', 'Cout_maitrise_constructionManager');
        $this->load->model('cout_sousprojet_construction_model', 'Cout_sousprojet_constructionManager');
        

    }
	public function importerdonneeconvention() {

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
				$rapport['convention_inserer']=$retour['convention_inserer'];
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
		$subvention_initial = array();
		$type_latrine = array();
		$convention_inserer = array();
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
		$rowIterator = $Excel->getActiveSheet()->getRowIterator();

		foreach($rowIterator as $row)
		{
			
			$ligne = $row->getRowIndex ();
			if($ligne ==1)
			{	
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(false);
				$rowIndex = $row->getRowIndex ();
				foreach ($cellIterator as $cell)
				{
					if('B' == $cell->getColumn())
					{
						$nom_agence =$cell->getValue();
					}
				}
			}
			if($ligne ==2)
			{	
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(false);
				$rowIndex = $row->getRowIndex ();
				foreach ($cellIterator as $cell)
				{
					if('B' == $cell->getColumn())
					{
						$prenom_agence =$cell->getValue();
					}
				}
			}
			if($ligne ==3)
			{	
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(false);
				$rowIndex = $row->getRowIndex ();
				foreach ($cellIterator as $cell)
				{
					if('B' == $cell->getColumn())
					{
						$telephone =$cell->getValue();
					}
				}
				if(($this->generer_requete_user(strtolower($nom_agence),strtolower($prenom_agence),$telephone))!="")
				{
					$user = $this->UserManager->findByFiltre($this->generer_requete_user(strtolower($nom_agence),strtolower($prenom_agence),$telephone));
					if (count($user)==1)
					{
						foreach($user as $k=>$v)
						{
							$id_user = $v->id;
						}
					}
					else
					{
						$sheet->getStyle("B1:B".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f24141'),
										 'endcolor'   => array('rgb' => 'f24141')
									 )
						);
						break;
					}
				}
				else
				{
					$sheet->getStyle("B1:B".$ligne)->getFill()->applyFromArray(
								 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
									 'startcolor' => array('rgb' => 'f2e641'),
									 'endcolor'   => array('rgb' => 'f2e641')
								 )
					);
					break;
				}
			}

				if($ligne >=6)
				{
					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false);
					$rowIndex = $row->getRowIndex ();
					foreach ($cellIterator as $cell)
					{
						if('A' == $cell->getColumn())
						{
							$nom_feffi =$cell->getValue();
						} 
						else if('B' == $cell->getColumn())
						{
							$nom_cisco =$cell->getValue();
						} 

						else if('C' == $cell->getColumn())
						{
							$code_site =$cell->getValue();
						} 
						else if('D' == $cell->getColumn())
						{
							$objet =$cell->getValue();
						} 
						else if('E' == $cell->getColumn())
						{
							$ref_convention =$cell->getValue();
						} 
						else if('F' == $cell->getColumn())
						{
							$ref_financement =$cell->getValue();
						} 
						else if('G' == $cell->getColumn())
						{
							$intitule =$cell->getValue();
						} 
						else if('H' == $cell->getColumn())
						{
							$delai =$cell->getValue();
						} 
						else if('I' == $cell->getColumn())
						{
							$prev_beneficiaire =$cell->getValue();
						} 
						else if('J' == $cell->getColumn())
						{
							$prev_nbr_ecole =$cell->getValue();
						} 
						else if('K' == $cell->getColumn())
						{
							$date_signature = $cell->getValue();
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
						else if('L' == $cell->getColumn())
						{
							$observation =$cell->getValue();
						}	 
					}
					
					// Si donnée incorrect : coleur cellule en rouge
					if($nom_feffi=="")
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
						$nom_feffi=strtolower($nom_feffi);
						$retour_feffi = $this->FeffiManager->findByNom($nom_feffi);
						if(count($retour_feffi) >0)
						{
							foreach($retour_feffi as $k=>$v)
							{
								$id_feffi = $v->id;
								$id_feffi = $v->id;
								$id_zone_subvention = $v->id_zone_subvention;
								$id_acces_zone = $v->id_acces_zone;
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

					if($nom_cisco=="")
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
						// Vérifier si nom_cisco existe dans la BDD
						$nom_cisco=strtolower($nom_cisco);
						$retour_cisco = $this->CiscoManager->findByNom($nom_cisco);
						if(count($retour_cisco) >0)
						{
							foreach($retour_cisco as $k=>$v)
							{
								$id_cisco = $v->id;
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
						}
					} 

					if($code_site=="")
					{						
						$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);	
						$erreur = true;												
					}
					else
					{
						// Vérifier si code_site existe dans la BDD
						$code_site=strtolower($code_site);
						$retour_site = $this->SiteManager->findByCode($code_site);
						if(count($retour_site) >0)
						{
							foreach($retour_site as $k=>$v)
							{
								$id_site = $v->id;
							}	
						}
						else
						{
							$sheet->getStyle("C".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'f24141'),
											 'endcolor'   => array('rgb' => 'f24141')
										 )
							);
							$erreur = true;
						}
					}
					if($objet=="")
					{						
						$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					if($ref_convention=="")
					{						
						$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					if($ref_financement=="")
					{						
						$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					if($intitule=="")
					{						
						$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
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
					if($prev_beneficiaire=="")
					{						
						$sheet->getStyle("I".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					if($prev_nbr_ecole=="")
					{						
						$sheet->getStyle("J".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					if($date_signature=="")
					{						
						$sheet->getStyle("K".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					/*Sif($observation=="")
					{						
						$sheet->getStyle("L".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}*/
					
					if($erreur==false)
					{	
						$doublon = $this->Convention_cisco_feffi_enteteManager->findByRef_convention($ref_convention);
						if (count($doublon)>0)
						{
							$sheet->setCellValue('M'.$ligne, "Doublon");
							$nbr_erreur = $nbr_erreur + 1;							
						}
						else
						{
		        			$sheet->setCellValue('M'.$ligne, "Ok");
		        			$data_entete = array(
		                    'ref_convention' => $ref_convention,
		                    'objet' => $objet,
		                    'id_cisco' => $id_cisco,
		                    'id_feffi' => $id_feffi, 
		                    'id_site' => $id_site,
		                    'ref_financement' => $ref_financement,
		                    'validation' => 0,
		                    'id_convention_ufpdaaf' => null,
		                    'montant_total' => 0,
		                    'avancement' => 0,
		                    'type_convention' => 1,
		                    'id_user' => $id_user
		                	);
	                		$dataId = $this->Convention_cisco_feffi_enteteManager->add($data_entete);
	                		//$dataId = 1;
	                		if(!is_null($dataId))
	                		{	
	                			$data_detail = array(
			                    'intitule' => $intitule,
			                    'delai' => $delai,
			                    'prev_beneficiaire' => $prev_beneficiaire,
			                    'prev_nbr_ecole' => $prev_nbr_ecole, 
			                    'date_signature' => $date_signature,
			                    'observation' => $observation,
			                    'id_convention_entete' => $dataId
			                	);

	                			$datadetailId = $this->Convention_cisco_feffi_detailManager->add($data_detail);
		        				$subvention_initial = $this->Subvention_initialManager->findByZone($id_zone_subvention,$id_acces_zone);
		        				if (count($subvention_initial)>0)
		        				{
						        	$type_latrine = $this->Type_latrineManager->findById($subvention_initial[0]->id_type_latrine);                  
				                    $type_batiment = $this->Type_batimentManager->findById($subvention_initial[0]->id_type_batiment);
				                    $type_mobilier = $this->Type_mobilierManager->findById($subvention_initial[0]->id_type_mobilier);
				                    $type_cout_maitrise = $this->Type_cout_maitriseManager->findById($subvention_initial[0]->id_type_cout_maitrise);
				                    $type_cout_sousprojet = $this->Type_cout_sousprojetManager->findById($subvention_initial[0]->id_type_cout_sousprojet);

				                    $data_batiment = array(
				                    'id_convention_entete' => $dataId,
				                    'id_type_batiment' => $type_batiment->id,
				                    'cout_unitaire' => $type_batiment->cout_batiment
				                	);
				                	$dataId_batiment= $this->Batiment_constructionManager->add($data_batiment);

				                	$data_latrine = array(
				                    'id_convention_entete' => $dataId,
				                    'id_type_latrine' => $type_latrine->id,
				                    'cout_unitaire' => $type_latrine->cout_latrine
				                	); 
				                	$dataId_latrine= $this->Latrine_constructionManager->add($data_latrine);

				                	$data_mobilier = array(
				                    'id_convention_entete' => $dataId,
				                    'id_type_mobilier' => $type_mobilier->id,
				                    'cout_unitaire' => $type_mobilier->cout_mobilier
				                	); 
				                	$dataId_mobilier= $this->Mobilier_constructionManager->add($data_mobilier);

				                	$data_maitrise = array(
				                    'id_convention_entete' => $dataId,
				                    'id_type_cout_maitrise' => $type_cout_maitrise->id,
				                    'cout' => $type_cout_maitrise->cout_maitrise
				                	);
				                	$dataId_maitrise= $this->Cout_maitrise_constructionManager->add($data_maitrise);

				                	$data_sousprojet = array(
				                    'id_convention_entete' => $dataId,
				                    'id_type_cout_sousprojet' => $type_cout_sousprojet->id,
				                    'cout' => $type_cout_sousprojet->cout_sousprojet
				                	);
				                	$dataId_sousprojet= $this->Cout_sousprojet_constructionManager->add($data_sousprojet);

		        				}
		        				$convention_entete = array(
			                    'id' => $dataId,
			                    'ref_convention' => $ref_convention,
			                    'objet' => $objet,
			                    'cisco' => $retour_cisco,
			                    'feffi' => $retour_feffi, 
			                    'site' => $retour_site,
			                    'ref_financement' => $ref_financement,
			                    'validation' => 0,
			                    'id_convention_ufpdaaf' => null,
			                    'montant_total' => 0,
			                    'avancement' => 0,
			                    'type_convention' => 1,
			                    'user' => $user
			                	);
		                	array_push($convention_inserer, $convention_entete);

	                		}

							$nbr_inserer = $nbr_inserer + 1;
						}
	        																
					}
					else
					{
						$sheet->setCellValue('M'.$ligne, "Erreur");
						$nbr_erreur = $nbr_erreur + 1;
					}						
						
					//$ligne = $ligne + 1;
				}
			
			
		}
		//$report['requete']=$subvention_initial;
		$report['nbr_erreur']=$nbr_erreur;
		$report['nbr_inserer']=$nbr_inserer;
		//$report['user']=$type_latrine;
		$report['convention_inserer']=$convention_inserer;
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

	 public function generer_requete_user($nom,$prenom,$telephone)
    {
            $requete = "";
            if ($nom!='') 
            {	
                $requete = "lower(nom)= '".$nom."'";
            }

            if ($prenom!='') 
            {	
            	if ($requete!='')
            	{            		
                	$requete = $requete." AND lower(prenom)='".$prenom."'" ;
            	}
            	else
            	 {
            	 	$requete = "lower(prenom)='".$prenom."'" ;
            	 }
            }

            if ($telephone!='') 
            {
                if ($requete!='')
            	{            		
                	$requete = $requete." AND telephone='".$telephone."'" ;
            	}
            	else
            	 {
            	 	$requete = "telephone='".$telephone."'" ;
            	 }
            }
          //var_dump($requete);
          //die();  
        return $requete ;
    }
} ?>	
