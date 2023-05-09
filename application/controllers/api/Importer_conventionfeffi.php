<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importer_conventionfeffi extends CI_Controller {
    public function __construct() {
        parent::__construct();        
        $this->load->model('ecole_model', 'EcoleManager');       
        $this->load->model('region_model', 'RegionManager');       
        $this->load->model('cisco_model', 'CiscoManager');      
        $this->load->model('commune_model', 'CommuneManager');       
        $this->load->model('zap_model', 'ZapManager');         
        $this->load->model('zap_commune_model', 'Zap_communeManager');     
        $this->load->model('fokontany_model', 'FokontanyManager');   
        $this->load->model('zone_subvention_model', 'Zone_subventionManager');   
        $this->load->model('acces_zone_model', 'Acces_zoneManager');
        $this->load->model('feffi_model', 'FeffiManager');
        $this->load->model('compte_feffi_model', 'Compte_feffiManager');
        $this->load->model('site_model', 'SiteManager');
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');
        $this->load->model('convention_cisco_feffi_detail_model', 'Convention_cisco_feffi_detailManager');
        $this->load->model('agence_acc_model', 'Agence_accManager');
        $this->load->model('cout_sousprojet_construction_model', 'Cout_sousprojet_constructionManager');
        $this->load->model('cout_maitrise_construction_model', 'Cout_maitrise_constructionManager');
        $this->load->model('batiment_construction_model', 'Batiment_constructionManager');
        $this->load->model('latrine_construction_model', 'Latrine_constructionManager');
        $this->load->model('mobilier_construction_model', 'Mobilier_constructionManager');
        $this->load->model('subvention_initial_model', 'Subvention_initialManager');
        
		
    }

	public function remove_upload_file()
	{	
		$chemin= $_POST['chemin'];
		$directoryName = dirname(__FILE__)."/../../../../../../assets/excel".$chemin;
	  	$delete = unlink($directoryName);
	}


	public function testconventionfeffi() {

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
		$lot=$_POST['lot'];

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
				$retour = $this->controler_donnees_importertestconventionfeffi($name1,$repertoire,$lot);
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
	public function controler_donnees_importertestconventionfeffi($filename,$directory,$lot) {
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
		$rowIterator = $Excel->getActiveSheet()->getRowIterator();

		foreach($rowIterator as $row)
		{			
			$ligne = $row->getRowIndex ();
			$erreur = false;
				if($ligne >=10)
				{
					$cellIterator = $row->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(false);
					$rowIndex = $row->getRowIndex ();
					foreach ($cellIterator as $cell)
					{
						if('A' == $cell->getColumn())
						{
							$aac =$cell->getValue();
						}  
						else if('B' == $cell->getColumn())
						{
							$eco =$cell->getValue();
						}  
						else if('D' == $cell->getColumn())
						{
							$foko =$cell->getValue();							
						}  
						else if('E' == $cell->getColumn())
						{
							$com =$cell->getValue();							
						}  
						else if('F' == $cell->getColumn())
						{
							$cis =$cell->getValue();							
						}  
						else if('G' == $cell->getColumn())
						{
							$reg =$cell->getValue();							
						}  
						else if('H' == $cell->getColumn())
						{
							$acc =$cell->getValue();							
						} 
						else if('I' == $cell->getColumn())
						{
							$fef =$cell->getValue();							
						}
						else if('J' == $cell->getColumn())
						{
							$conv =$cell->getValue();							
						}
						else if('K' == $cell->getColumn())
						{
							//$date_conv=$cell->getFormattedValue();
							$date_conv =$cell->getValue();
							if(isset($date_conv) && $date_conv>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_conv = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_conv)); 
								}
							} 
							else 
							{
								$date_conv=null;
							}							
						}	 
					}
					
					// Si donnée incorrect : coleur cellule en rouge
					
					if($reg=="")
					{						
						$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
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
						$regn=strtolower($reg);
						$retour_region = $this->RegionManager->getregiontest($regn);
						if(count($retour_region) >0)
						{
							foreach($retour_region as $k=>$v)
							{
								$id_region = $v->id;
							}	
						}
						else
						{
							$sheet->getStyle("G".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'f24141'),
											 'endcolor'   => array('rgb' => 'f24141')
										 )
							);
							$erreur = true;
							$sheet->setCellValue('IQ'.$ligne, 'retour_region');
						}
					}
					if($cis=="")
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
						// Vérifier si nom_feffi existe dans la BDD
						$cisn=strtolower($cis);
						$regn=strtolower($reg);
						$retour_cisco = $this->CiscoManager->getciscotest($cisn,$regn);
						if(count($retour_cisco) >0)
						{
							foreach($retour_cisco as $k=>$v)
							{
								$id_cisco = $v->id;
							}	
						}
						else
						{
							$sheet->getStyle("F".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'f24141'),
											 'endcolor'   => array('rgb' => 'f24141')
										 )
							);
							$erreur = true;
							$sheet->setCellValue('IQ'.$ligne, 'retour_cisco');
						}
					}
					
					if($com=="")
					{						
						$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;	
						$sheet->setCellValue('IQ'.$ligne, 'retour_commune1');												
					}
					else
					{
						// Vérifier si nom_feffi existe dans la BDD
						$regn=strtolower($reg);
						$distn=strtolower($cis);
						$comn=strtolower($com);
						$retour_commune = $this->CommuneManager->getcommunetest($regn,$distn,$comn);
						if(count($retour_commune) >0)
						{
							foreach($retour_commune as $k=>$v)
							{
								$id_commune = $v->id;
							}	
						}
						else
						{
							$sheet->getStyle("E".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'f24141'),
											 'endcolor'   => array('rgb' => 'f24141')
										 )
							);
							$erreur = true;
							$sheet->setCellValue('IQ'.$ligne, 'retour_commune');
						}
					}
					if($foko=="")
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
						// Vérifier si nom_feffi existe dans la BDD
						$fokon=strtolower($foko);
						if (isset($id_commune)) 
						{
							$retour_fokontany = $this->FokontanyManager->getfokontanytestbyid_commune($id_commune,$fokon);
							if(count($retour_fokontany) >0)
							{
								foreach($retour_fokontany as $k=>$v)
								{
									$id_fokontany = $v->id;
								}	
							}
							else
							{
								$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
											array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
												'startcolor' => array('rgb' => 'f24141'),
												'endcolor'   => array('rgb' => 'f24141')
											)
								);
								$erreur = true;
								$sheet->setCellValue('IQ'.$ligne, 'retour_fokontany');
							}
						}
						else
						{
								$sheet->getStyle("D".$ligne)->getFill()->applyFromArray(
									array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										'startcolor' => array('rgb' => 'f24141'),
										'endcolor'   => array('rgb' => 'f24141')
									)
								);
								$erreur = true;
								$sheet->setCellValue('IQ'.$ligne, 'retour_fokontany');
						}
						
					}
					
					if($eco=="")
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
						$econ=strtolower($eco);
						if (isset($id_fokontany))
						{
							$retour_ecole = $this->EcoleManager->getecoletestbyid_fokontany($id_fokontany,$econ);
							if(count($retour_ecole) >0)
							{
								foreach($retour_ecole as $k=>$v)
								{
									$id_ecole = $v->id;
									$id_zap = $v->id_zap;
									$id_zone_subvention = $v->id_zone_subvention;
									$id_acces_zone = $v->id_acces_zone;

									$retour_subvention_initial = $this->Subvention_initialManager->findByZoneobjet($id_zone_subvention,$id_acces_zone);
									
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
								$sheet->setCellValue('IQ'.$ligne, $id_fokontany.$econ);
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
					
					if($fef=="")
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
						$fefn=strtolower($fef);
						if (isset($id_ecole)) 
						{
							$retour_feffi = $this->FeffiManager->getfeffitest($id_ecole,$fefn);
							if(count($retour_feffi) >0)
							{
								foreach($retour_feffi as $k=>$v)
								{
									$id_feffi = $v->id;								
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
					
					if($aac=="")
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
						$aacn=strtolower($aac);
						$retour_aac = $this->Agence_accManager->getagencetest($aacn);
						if(count($retour_aac) >0)
						{
							foreach($retour_aac as $k=>$v)
							{
								$id_aac = $v->id;								
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
					
					if($conv=="")
					{						
						$sheet->getStyle("J".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($date_conv =="")
					{						
						$sheet->getStyle("K".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					/*$id_region =1;
					$id_cisco=1;
					$id_commune=1;
					$id_zap=1;
					$id_fokontany=1;*/
					if($erreur==false)
					{	
						$convn=strtolower($conv);						
						$doublon = $this->Convention_cisco_feffi_enteteManager->getconventiontest($convn);
						if (count($doublon)>0)//mis doublon
						{
							$sheet->setCellValue('IO'.$ligne, "Doublon");
							array_push($zap_inserer, $doublon);
							$nbr_erreur = $nbr_erreur + 1;
							/*foreach ($doublon as $keyc => $valuec) {
								$id_c=$valuec->id;
								$dataconv_detail = array(
									'intitule' => 'Construction d’un bâtiment à 2 salles de classe éq',
									'delai' => '120',
									'prev_beneficiaire' => '50',
									'prev_nbr_ecole' => '1',
									'date_signature' =>date("Y-m-d",strtotime($date_conv)) , 
									'observation' => null,
									'id_convention_entete' => $valuec->id
								);
								$dataIdcoonv_detail = $this->Convention_cisco_feffi_detailManager->update_det($valuec->id,$dataconv_detail);
							}	*/						
						}
						else//ts doublon
						{

		                		//$dataId = $this->ZapManager->add($data); 
		                	
								//$sheet->setCellValue('IO'.$ligne, "ok"); 
								$datasite = array(
									'code_sous_projet' => $conv,
									'objet_sous_projet' => 'construction ecole',
									'id_agence_acc' => $id_aac,
									'statu_convention' => 2,
									'observation' => null,
									'id_region' => $id_region,
									'id_cisco' => $id_cisco,
									'id_commune' => $id_commune,
									'id_zap' => $id_zap,
									'id_ecole' => $id_ecole,
									'id_classification_site' => 2,
									'lot' => $lot,
									'validation' => 1,
									'acces' => $acc
								);
								$dataIdsite = $this->SiteManager->add($datasite);

								$dataconv = array(
									'ref_convention' => $conv,
									'objet' => 'MOD pour la construction de 02 salles de classe équipées',
									'id_region' => $id_region,
									'id_cisco' => $id_cisco,
									'id_feffi' => $id_feffi, 
									'id_site' => $dataIdsite,
									'ref_financement' => 'Crédit IDA N° 62170',
									'validation' => 1,
									'id_convention_ufpdaaf' => null,
									'type_convention' => 1,
									'id_user' => null,
									'montant_total' => null
								);
								$dataIdcoonv = $this->Convention_cisco_feffi_enteteManager->add($dataconv);

								$dataconv_detail = array(
									'intitule' => 'Construction d’un bâtiment à 2 salles de classe éq',
									'delai' => '120',
									'prev_beneficiaire' => '50',
									'prev_nbr_ecole' => '1',
									'date_signature' =>date("Y-m-d",strtotime($date_conv)) , 
									'observation' => null,
									'id_convention_entete' => $dataIdcoonv
								);
								$dataIdcoonv_detail = $this->Convention_cisco_feffi_detailManager->add($dataconv_detail);
								
								$datas_type_batiment = array(
									'id_type_batiment'=>$retour_subvention_initial->id_type_batiment,
									'cout_unitaire'=> $retour_subvention_initial->cout_batiment ,
									'id_convention_entete'=> $dataIdcoonv,
									'nbr_batiment'=>null				
								);
								$dataIdsubvention_batiment = $this->Batiment_constructionManager->add($datas_type_batiment);

								$datas_type_latrine = array(
									'id_type_latrine'=> $retour_subvention_initial->id_type_latrine,
									'cout_unitaire'=> $retour_subvention_initial->cout_latrine,
									'id_convention_entete'=> $dataIdcoonv,
									'nbr_latrine'=>null				
								);
								$dataIdsubvention_latrine = $this->Latrine_constructionManager->add($datas_type_latrine);

								$datas_type_mobilier = array(
									'id_type_mobilier'=> $retour_subvention_initial->id_type_mobilier,
									'cout_unitaire'=> $retour_subvention_initial->cout_mobilier,
									'id_convention_entete'=> $dataIdcoonv,
									'nbr_mobilier'=>null				
								);
								$dataIdsubvention_mobilier = $this->Mobilier_constructionManager->add($datas_type_mobilier);

								$datas_type_maitrise = array(
									'id_type_cout_maitrise'=> $retour_subvention_initial->id_type_maitrise,
									'cout'=> $retour_subvention_initial->cout_maitrise,
									'id_convention_entete'=> $dataIdcoonv				
								);
								$dataIdsubvention_maitrise = $this->Cout_maitrise_constructionManager->add($datas_type_maitrise);

								$datas_type_sousprojet = array(
									'id_type_cout_sousprojet'=> $retour_subvention_initial->id_type_sousprojet,
									'cout'=> $retour_subvention_initial->cout_sousprojet,
									'id_convention_entete'=> $dataIdcoonv				
								);
								$dataIdsubvention_sousprojet = $this->Cout_sousprojet_constructionManager->add($datas_type_sousprojet);
								$sheet->setCellValue('IO'.$ligne, 'ok'); 
		                	//array_push($zap_inserer, $data);
							$nbr_inserer = $nbr_inserer + 1;
						}
	        																
					}
					else//mis erreur
					{
						$sheet->setCellValue('IO'.$ligne, "erreur");
						$nbr_erreur = $nbr_erreur + 1;
					}						
						
					$ligne = $ligne + 1;
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
