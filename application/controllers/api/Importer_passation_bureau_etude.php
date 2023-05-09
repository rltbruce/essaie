<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importer_passation_bureau_etude extends CI_Controller {
    public function __construct() {
        parent::__construct();       
        $this->load->model('passation_marches_be_model', 'Passation_marches_beManager');       
        $this->load->model('convention_cisco_feffi_entete_model', 'Convention_cisco_feffi_enteteManager');       
        $this->load->model('bureau_etude_model', 'Bureau_etudeManager');
        

    }

	public function remove_upload_file()
	{	
		$chemin= $_POST['chemin'];
		$directoryName = dirname(__FILE__)."/../../../../../../assets/excel".$chemin;
	  	$delete = unlink($directoryName);
	}

	public function testpassation_bureau_etude() {

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
				$retour = $this->controler_donnees_importertestdistrict($name1,$repertoire);
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
	public function controler_donnees_importertestdistrict($filename,$directory) {
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
						if('J' == $cell->getColumn())
						{
							$code_conv =$cell->getValue();
						}  
						else if('EE' == $cell->getColumn())
						{
							//$date_shor =$cell->getFormattedValue();
							$date_shor =$cell->getValue();
							if(isset($date_shor) && $date_shor>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_shor = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_shor)); 
								}
							} 
							else 
							{
								$date_shor=null;
							}
						}  
						else if('EF' == $cell->getColumn())
						{
							//$date_mani =$cell->getFormattedValue();
							$date_mani =$cell->getValue();
							if(isset($date_mani) && $date_mani>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_mani = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_mani)); 
								}
							} 
							else 
							{
								$date_mani=null;
							}							
						}  
						else if('EG' == $cell->getColumn())
						{
							//$date_lance =$cell->getFormattedValue();
							$date_lance =$cell->getValue();
							if(isset($date_lance) && $date_lance>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_lance = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_lance)); 
								}
							} 
							else 
							{
								$date_lance=null;
							}							
						}  
						else if('EH' == $cell->getColumn())
						{
							//$date_ram =$cell->getFormattedValue();
							$date_ram =$cell->getValue();
							if(isset($date_ram) && $date_ram>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_ram = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_ram)); 
								}
							} 
							else 
							{
								$date_ram=null;
							}							
						}  
						else if('EI' == $cell->getColumn())
						{
							$nbr_offre=$cell->getValue();							
						}  
						else if('EJ' == $cell->getColumn())
						{
							//$date_rap  =$cell->getFormattedValue();
							$date_rap =$cell->getValue();
							if(isset($date_rap) && $date_rap>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_rap = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_rap)); 
								}
							} 
							else 
							{
								$date_rap=null;
							}							
						}  
						else if('EK' == $cell->getColumn())
						{
							//$date_ano =$cell->getFormattedValue();
							$date_ano =$cell->getValue();
							if(isset($date_ano) && $date_ano>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_ano = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_ano)); 
								}
							} 
							else 
							{
								$date_ano=null;
							}							
						}  
						else if('EL' == $cell->getColumn())
						{
							//$date_dano =$cell->getFormattedValue();
							$date_dano =$cell->getValue();
							if(isset($date_dano) && $date_dano>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_dano = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_dano)); 
								}
							} 
							else 
							{
								$date_dano=null;
							}							
						}  
						else if('EM' == $cell->getColumn())
						{
							//$date_inten =$cell->getFormattedValue();
							$date_inten =$cell->getValue();
							if(isset($date_inten) && $date_inten>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_inten = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_inten)); 
								}
							} 
							else 
							{
								$date_inten=null;
							}							
						}  
						else if('EN' == $cell->getColumn())
						{
							//$date_attri =$cell->getFormattedValue();
							$date_attri =$cell->getValue();
							if(isset($date_attri) && $date_attri>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_attri = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_attri)); 
								}
							} 
							else 
							{
								$date_attri=null;
							}							
						}  
						else if('EO' == $cell->getColumn())
						{
							//$date_signat =$cell->getFormattedValue();
							$date_signat =$cell->getValue();
							if(isset($date_signat) && $date_signat>"")
							{
								if(PHPExcel_Shared_Date::isDateTime($cell))
								{
									$date_signat = date($format='Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_signat)); 
								}
							} 
							else 
							{
								$date_signat=null;
							}							
						}  
						else if('EP' == $cell->getColumn())
						{
							//$date_os =$cell->getFormattedValue();
							$date_os =$cell->getValue();
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
						else if('EQ' == $cell->getColumn())
						{
							$nom_consu =$cell->getValue();							
						}  
						else if('ER' == $cell->getColumn())
						{
							$stat =$cell->getValue();							
						}	 
					}
					
					// Si donnée incorrect : coleur cellule en rouge
					if($code_conv=="")
					{						
						$sheet->getStyle("J".$ligne)->getFill()->applyFromArray(
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
						$code_convn=strtolower($code_conv);
						$retour_convention = $this->Convention_cisco_feffi_enteteManager->getconventiontest($code_convn);
						if(count($retour_convention) >0)
						{
							foreach($retour_convention as $k=>$v)
							{
								$id_convetion = $v->id;								
							}	
						}
						else
						{
							$sheet->getStyle("J".$ligne)->getFill()->applyFromArray(
										 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
											 'startcolor' => array('rgb' => 'f24141'),
											 'endcolor'   => array('rgb' => 'f24141')
										 )
							);
							$erreur = true;
						}
					}
					if($date_shor=="")
					{						
						$sheet->getStyle("EE".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					} 
					/*if($date_mani=="")
					{						
						$sheet->getStyle("EF".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					} */
					if($date_lance=="")
					{						
						$sheet->getStyle("EG".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}  
					if($date_ram=="")
					{						
						$sheet->getStyle("EH".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					} 
					if($nbr_offre=="")
					{						
						$sheet->getStyle("EI".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					} 
					if($date_rap=="")
					{						
						$sheet->getStyle("EJ".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($date_ano=="")
					{						
						$sheet->getStyle("EK".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($date_dano=="")
					{						
						$sheet->getStyle("EL".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($date_inten=="")
					{						
						$sheet->getStyle("EM".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($date_attri=="")
					{						
						$sheet->getStyle("EN".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($date_signat=="")
					{						
						$sheet->getStyle("EO".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($date_os=="")
					{						
						$sheet->getStyle("EP".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($nom_consu=="")
					{						
						$sheet->getStyle("EQ".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($stat=="")
					{						
						$sheet->getStyle("ER".$ligne)->getFill()->applyFromArray(
									 array('type'       => PHPExcel_Style_Fill::FILL_SOLID,'rotation'   => 0,
										 'startcolor' => array('rgb' => 'f2e641'),
										 'endcolor'   => array('rgb' => 'f2e641')
									 )
						);
						$erreur = true;													
					}
					
					if($erreur==false)
					{	
						$code_convn=strtolower($code_conv);
						$doublon = $this->Passation_marches_beManager->getpassationtest($id_convetion);
						if (count($doublon)>0)//mis doublon
						{
							$sheet->setCellValue('IO'.$ligne, "Doublon");
							array_push($zap_inserer, $doublon);
							$nbr_erreur = $nbr_erreur + 1;							
						}
						else//ts doublon
						{
						   $data = array(
						   'date_lancement_dp' => date("Y-m-d", strtotime($date_lance)),
						   'date_remise'   => date("Y-m-d", strtotime($date_ram)),
						   'nbr_offre_recu'    => $nbr_offre,
						   'date_rapport_evaluation' => date("Y-m-d", strtotime($date_rap)),
						   'date_demande_ano_dpfi' => date("Y-m-d", strtotime($date_ano)),
						   'date_ano_dpfi' => date("Y-m-d", strtotime($date_dano)),
						   'notification_intention'   => date("Y-m-d", strtotime($date_inten)),
						   'date_notification_attribution'    => date("Y-m-d", strtotime($date_attri)),
						   'date_signature_contrat'   => date("Y-m-d", strtotime($date_signat)),
						   'date_os' => date("Y-m-d", strtotime($date_os)),
						   'observation' => null,
	   
						   'date_shortlist' => date("Y-m-d", strtotime($date_shor)),
						   'date_manifestation' => null,
						   'statut' => $this->statu_moe($stat),
	   
						   'id_convention_entete' => $id_convetion,
						   'validation' => 0,
					   );
						   $dataId = $this->Passation_marches_beManager->add($data);
								$nom_consun=strtolower($nom_consu);
								$doublon_consu = $this->Bureau_etudeManager->getbureau_etudetest($nom_consun);
								if (count($doublon_consu)==0)//mis doublon
								{
									$data_consu = array(
										'telephone' => null,
										'nom' => $nom_consu,
										'nif' => null,
										'stat' => null,
										'siege' => null
									);
									$dataId = $this->Bureau_etudeManager->add($data_consu);							
								}
								else
								{
									$sheet->setCellValue('IP'.$ligne, "doublon partenaire");
								}
		                	
								$sheet->setCellValue('IO'.$ligne, "ok");        		

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
	public function statu_moe($statu)
	{
		$statut=1;
		if (strtolower($statu)=='ce')
		{
			$statut=2;
		}
		return $statut;
	}

////////////////////////////////////////////////////////////////////


} ?>	
