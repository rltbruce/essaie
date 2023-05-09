<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//harizo
// afaka fafana refa ts ilaina
// require APPPATH . '/libraries/REST_Controller.php';

class Importer_fichier extends CI_Controller {
    public function __construct() {
        parent::__construct();
        

    }
	public function save_upload_file() {

		ini_set('upload_max_filesize', '20M');  
		ini_set('post_max_size', '20M');
//ini_set('max_input_time', 3000);
//ini_set('max_execution_time', 3000);
		$erreur="aucun";
		$replace=array('e','e','e','a','o','c','_');
		$search= array('é','è','ê','à','ö','ç',' ');

		$replacename=array('_','_','_','_');
		$searchname= array('/','"\"',' ','\'');

		$repertoire= $_POST['repertoire'];
		$name_fichier=$_POST['name_fichier'];

		$repertoire=str_replace($search,$replace,$repertoire);
		$name_fichier=str_replace($searchname,$replacename,$name_fichier);
		//The name of the directory that we need to create.
		$directoryName = dirname(__FILE__) ."/../../../../../../assets/" .$repertoire;
		//Check if the directory already exists.
		if(!is_dir($directoryName)){
			//Directory does not exist, so lets create it.
			mkdir($directoryName, 0777,true);
		}				

		$rapport=array();
		//$rapport['repertoire']=dirname(__FILE__) ."/../../../../../../assets/ddb/" .$repertoire;
		$config['upload_path']          = dirname(__FILE__) ."/../../../../../../assets/".$repertoire;
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|doc|docx|pdf|txt';
		$config['max_size'] = 100000000;
		$config['max_width'] = 200000000;
		$config['max_height'] = 20000000;  
		$config['overwrite'] = TRUE;
		if (isset($_FILES['file']['tmp_name']))
		{
			$name=$_FILES['file']['name'];
			//$name1=str_replace($search,$replace,$name);
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
				$rapport["erreur"]= $error;
				echo json_encode($rapport);
			}else{
				
				echo json_encode($rapport);
			}
			
		} else {
			$rapport["erreur"]= 'File upload not found' ;
           // echo 'File upload not found';
            echo json_encode($rapport);
		} 
		
	}

	public function remove_upload_file()
	{	
		$chemin= $_POST['chemin'];
		$directoryName = dirname(__FILE__)."/../../../../../../assets/".$chemin;
	  	$delete = unlink($directoryName);
	}
} ?>	
